<?php

namespace Tests\Feature;

use App\Mail\ContactMessageReceivedMail;
use App\Mail\NewContactMessageMail;
use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
            ->assertSee('application/ld+json', false);
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
