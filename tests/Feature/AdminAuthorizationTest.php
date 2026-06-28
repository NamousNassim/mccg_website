<?php

namespace Tests\Feature;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Models\ContactMessage;
use App\Models\PageSeo;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class AdminAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_admin_can_manage_users_but_cannot_delete_their_own_account(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $marketer = User::create([
            'name' => 'Marketeur MCCG',
            'email' => 'marketer@mccg.ma',
            'password' => 'SecurePassword123!',
            'role' => 'marketer',
        ]);

        $this->actingAs($admin);
        $this->get('/admin/users')->assertOk();
        $this->get('/admin/users/create')->assertOk();
        $this->get("/admin/users/{$marketer->id}/edit")->assertOk();

        $this->assertFalse(Gate::forUser($admin)->allows('delete', $admin));
        $this->assertTrue(Gate::forUser($admin)->allows('delete', $marketer));
    }

    public function test_marketer_cannot_access_user_management(): void
    {
        $marketer = User::create([
            'name' => 'Marketeur MCCG',
            'email' => 'marketer@mccg.ma',
            'password' => 'SecurePassword123!',
            'role' => 'marketer',
        ]);

        $this->actingAs($marketer)->get('/admin/users')->assertForbidden();
    }

    public function test_marketer_permissions_follow_the_content_matrix(): void
    {
        $marketer = User::create([
            'name' => 'Marketeur MCCG',
            'email' => 'marketer@mccg.ma',
            'password' => 'SecurePassword123!',
            'role' => 'marketer',
        ]);
        $message = ContactMessage::create([
            'first_name' => 'Nadia', 'last_name' => 'Bennani', 'email' => 'nadia@example.com',
            'message' => 'Demande de renseignements concernant les services MCCG.',
        ]);
        $service = Service::firstOrFail();
        $pageSeo = PageSeo::firstOrFail();

        $this->actingAs($marketer);
        $this->get('/admin/articles')->assertOk();
        $this->get('/admin/categories')->assertOk();
        $this->get('/admin/contact-messages')->assertOk();
        $this->get("/admin/contact-messages/{$message->id}/view")->assertOk();
        $this->get("/admin/contact-messages/{$message->id}/edit")->assertForbidden();
        $this->get('/admin/services')->assertOk();
        $this->get('/admin/page-seos')->assertOk();

        $this->assertFalse(Gate::forUser($marketer)->allows('delete', $service));
        $this->assertFalse(Gate::forUser($marketer)->allows('delete', $pageSeo));
        $this->assertFalse(Gate::forUser($marketer)->allows('update', $message));
    }

    public function test_admin_can_create_a_user_and_edit_without_changing_the_password(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $this->actingAs($admin);
        filament()->setCurrentPanel(filament()->getPanel('admin'));

        Livewire::test(CreateUser::class)
            ->fillForm([
                'name' => 'Compte incomplet',
                'email' => 'incomplet@mccg.ma',
                'role' => 'marketer',
            ])
            ->call('create')
            ->assertHasFormErrors(['password' => 'required']);

        Livewire::test(CreateUser::class)
            ->fillForm([
                'name' => 'Nouvelle Marketeuse',
                'email' => 'nouvelle@mccg.ma',
                'role' => 'marketer',
                'password' => 'SecurePassword123!',
                'password_confirmation' => 'SecurePassword123!',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $marketer = User::where('email', 'nouvelle@mccg.ma')->firstOrFail();
        $this->assertTrue(Hash::check('SecurePassword123!', $marketer->password));
        $originalPassword = $marketer->password;

        Livewire::test(EditUser::class, ['record' => $marketer->getRouteKey()])
            ->fillForm(['name' => 'Marketeuse MCCG'])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame($originalPassword, $marketer->fresh()->password);
    }
}
