<?php

namespace Tests\Feature;

use App\Mail\ContactMessageReceivedMail;
use App\Mail\NewContactMessageMail;
use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Mail;
use RuntimeException;
use Tests\TestCase;

class PublicWebsiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_pages_are_available(): void
    {
        foreach (['/', '/a-propos', '/services', '/articles', '/contact', '/confidentialite', '/conditions', '/sitemap.xml', '/robots.txt'] as $uri) {
            $this->get($uri)->assertOk();
        }
    }

    public function test_shared_mobile_navigation_and_footer_render(): void
    {
        $this->get(route('accueil'))
            ->assertOk()
            ->assertSee('id="menu-toggle"', false)
            ->assertSee('aria-controls="mobile-menu"', false)
            ->assertSee('id="mobile-menu"', false)
            ->assertSee('Nous consulter')
            ->assertSee('Confidentialité')
            ->assertSee('Conditions');
    }

    public function test_main_marketing_pages_do_not_claim_regulated_accounting_status(): void
    {
        $riskyClaims = [
            'cabinet d’expertise comptable',
            'expert-comptable',
            'commissariat aux comptes',
            'certification des comptes',
            'audit légal',
            'membre de l’ordre',
        ];

        foreach (['/', '/a-propos', '/services', '/contact'] as $uri) {
            $content = mb_strtolower($this->get($uri)->assertOk()->getContent());

            foreach ($riskyClaims as $claim) {
                $this->assertStringNotContainsString($claim, $content, "La page {$uri} contient l’allégation réglementée « {$claim} ».");
            }
        }
    }

    public function test_public_copy_uses_compliant_positioning_and_disclaimer(): void
    {
        $this->get(route('accueil'))
            ->assertSeeText('Votre partenaire de confiance en conseil comptable, fiscal et social')
            ->assertSee('MCCG | Cabinet de conseil comptable et fiscal au Maroc', false)
            ->assertSee('"@context":"https://schema.org"', false)
            ->assertSee('"@type":["LocalBusiness","ProfessionalService"]', false)
            ->assertSee('Les prestations réglementées sont réalisées uniquement lorsqu’elles sont légalement autorisées');

        $this->get(route('services.index'))
            ->assertSee('Tenue comptable')
            ->assertSee('Conseil fiscal')
            ->assertSee('Audit interne &amp; revue comptable', false)
            ->assertSee('Conseil juridique et administratif');
    }

    public function test_published_content_is_publicly_accessible(): void
    {
        $service = Service::where('is_active', true)->first();
        $article = Article::published()->first();

        $this->get(route('services.show', $service))
            ->assertOk()
            ->assertSee($service->meta_title, false)
            ->assertSee('rel="canonical"', false);
        $this->get(route('articles.show', $article))
            ->assertOk()
            ->assertSee($article->meta_title, false)
            ->assertSee('application/ld+json', false)
            ->assertSee('"@context":"https://schema.org"', false);
        $this->get('/sitemap.xml')
            ->assertSee(route('services.show', $service), false)
            ->assertSee(route('articles.show', $article), false);
    }

    public function test_contact_form_stores_a_message(): void
    {
        Mail::fake();

        $this->post(route('contact.store'), [
            'full_name' => 'Samira Alaoui', 'email' => 'samira@example.com',
            'phone' => '+212600000000', 'company' => 'Atlas SARL', 'service' => 'Conseil fiscal',
            'message' => 'Je souhaite échanger au sujet de notre organisation fiscale.',
        ])->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', ['email' => 'samira@example.com', 'status' => 'new']);
        Mail::assertQueued(NewContactMessageMail::class, fn (NewContactMessageMail $mail) => $mail->hasTo(config('mail.contact_notification')));
        Mail::assertQueued(ContactMessageReceivedMail::class, fn (ContactMessageReceivedMail $mail) => $mail->hasTo('samira@example.com'));

        $contactMessage = ContactMessage::where('email', 'samira@example.com')->firstOrFail();
        $this->assertStringContainsString('Samira Alaoui', (new NewContactMessageMail($contactMessage))->render());
        $this->assertStringContainsString('Nous vous confirmons', (new ContactMessageReceivedMail($contactMessage))->render());
    }

    public function test_contact_page_displays_configured_business_details_and_structured_data(): void
    {
        $response = $this->get(route('contact'));

        $response->assertOk()
            ->assertSee('05 24 43 83 70')
            ->assertSee('majd.chraibi@gmail.com')
            ->assertSee('92, Bd Zerktouni, Appt 6, 2ème étage, Guéliz, Marrakech')
            ->assertSee('Casablanca, Dubai')
            ->assertSee('Ouvrir dans Google Maps')
            ->assertSee('Carte du bureau MCCG à Marrakech')
            ->assertSee('Carte du bureau MCCG à Dubai')
            ->assertSee('Bureau Casablanca')
            ->assertSee('Adresse à confirmer')
            ->assertSee('data-map-fallback="Casablanca"', false)
            ->assertDontSee('Carte du bureau MCCG à Casablanca')
            ->assertSee('data-office-carousel', false)
            ->assertSee('"telephone":"05 24 43 83 70"', false)
            ->assertSee('"email":"majd.chraibi@gmail.com"', false)
            ->assertSee('"streetAddress":"92, Bd Zerktouni, Appt 6, 2ème étage"', false)
            ->assertSee('"addressLocality":"Marrakech"', false);

        $this->assertSame(2, substr_count($response->getContent(), '<iframe'));
    }

    public function test_analytics_are_not_rendered_without_configuration(): void
    {
        config()->set('mccg.analytics_provider');
        config()->set('mccg.ga_id');
        config()->set('mccg.plausible_domain');

        $this->get(route('accueil'))
            ->assertOk()
            ->assertDontSee('googletagmanager.com', false)
            ->assertDontSee('plausible.io/js/script.js', false)
            ->assertDontSee('data-cookie-notice', false);
    }

    public function test_google_analytics_and_cookie_notice_require_provider_and_id(): void
    {
        config()->set('mccg.analytics_provider', 'google');
        config()->set('mccg.ga_id', 'G-MCCG123456');
        config()->set('mccg.plausible_domain', 'wrong.example');

        $this->get(route('accueil'))
            ->assertOk()
            ->assertSee('googletagmanager.com/gtag/js', false)
            ->assertSee('G-MCCG123456', false)
            ->assertSee('data-mccg-google-bootstrap', false)
            ->assertSee('data-cookie-notice', false)
            ->assertDontSee('plausible.io/js/script.js', false);
    }

    public function test_incomplete_analytics_configuration_renders_nothing(): void
    {
        config()->set('mccg.analytics_provider', 'google');
        config()->set('mccg.ga_id');

        $this->get(route('accueil'))
            ->assertDontSee('googletagmanager.com', false)
            ->assertDontSee('data-cookie-notice', false);

        config()->set('mccg.analytics_provider', 'plausible');
        config()->set('mccg.plausible_domain');

        $this->get(route('accueil'))
            ->assertDontSee('plausible.io/js/script.js', false);
    }

    public function test_plausible_analytics_requires_provider_and_domain(): void
    {
        config()->set('mccg.analytics_provider', 'plausible');
        config()->set('mccg.plausible_domain', 'www.mc-cg.com');
        config()->set('mccg.ga_id', 'G-WRONG');

        $this->get(route('accueil'))
            ->assertOk()
            ->assertSee('src="https://plausible.io/js/script.js"', false)
            ->assertSee('data-domain="www.mc-cg.com"', false)
            ->assertSee('data-mccg-plausible', false)
            ->assertDontSee('googletagmanager.com', false)
            ->assertDontSee('data-cookie-notice', false);
    }

    public function test_contact_page_and_footer_work_without_google_maps_urls(): void
    {
        config()->set('mccg.google_maps_url');
        config()->set('mccg.google_maps_embed_url');
        config()->set('mccg.office_locations', [[
            'city' => 'Marrakech',
            'address' => config('mccg.address'),
            'maps_url' => null,
            'embed_url' => null,
        ]]);

        $this->get(route('contact'))
            ->assertOk()
            ->assertSee('MCCG Marrakech')
            ->assertSee('Ouvrir dans Google Maps')
            ->assertSee('05 24 43 83 70')
            ->assertSee('majd.chraibi@gmail.com')
            ->assertSee('Autres bureaux');
    }

    public function test_footer_displays_configured_contact_details(): void
    {
        $footer = Blade::render('<x-footer />');

        $this->assertStringContainsString('05 24 43 83 70', $footer);
        $this->assertStringContainsString('majd.chraibi@gmail.com', $footer);
        $this->assertStringContainsString('92, Bd Zerktouni, Appt 6, 2ème étage, Guéliz, Marrakech', $footer);
        $this->assertStringContainsString('Casablanca, Dubai', $footer);
        $this->assertStringContainsString('https://www.linkedin.com/in/majdchraibi', $footer);
        $this->assertStringContainsString('https://www.instagram.com/mccg.consulting', $footer);
    }

    public function test_admin_login_is_available(): void
    {
        $this->get('/admin/login')->assertOk();
        $this->assertTrue(User::first()->canAccessPanel(filament()->getPanel('admin')));
    }

    public function test_contact_is_saved_even_when_notifications_cannot_be_queued(): void
    {
        Mail::shouldReceive('to')->twice()->andThrow(new RuntimeException('Service mail indisponible'));

        $this->post(route('contact.store'), [
            'full_name' => 'Youssef Amrani',
            'email' => 'youssef@example.com',
            'message' => 'Je souhaite être accompagné pour la création de mon entreprise.',
        ])->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', ['email' => 'youssef@example.com', 'status' => 'new']);
    }

    public function test_admin_can_open_all_management_sections(): void
    {
        $this->actingAs(User::first());

        foreach (['/admin', '/admin/articles', '/admin/categories', '/admin/services', '/admin/page-seos', '/admin/contact-messages'] as $uri) {
            $this->get($uri)->assertOk();
        }
    }
}
