<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    public function test_admin_sign_in_page_is_available(): void
    {
        $this->get('/admin/login')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('Admin/Login'));
    }

    public function test_admin_pages_redirect_guests_to_sign_in(): void
    {
        $this->get('/admin')
            ->assertRedirectToRoute('login');
    }

    public function test_regular_users_cannot_sign_in_as_an_admin(): void
    {
        $user = User::factory()->create();

        $this->post('/admin/login', [
            'email' => $user->email,
            'password' => 'password',
        ])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_admin_can_sign_in_and_sign_out(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => 'password',
        ])
            ->assertRedirectToRoute('admin.dashboard')
            ->assertSessionHasNoErrors();

        $this->assertAuthenticatedAs($admin);

        $this->get('/admin')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Admin/Dashboard')
                ->where('stats.total', 14)
                ->where('stats.published', 14)
                ->has('recentArtworks', 5));

        $this->post('/admin/logout')
            ->assertRedirectToRoute('login');

        $this->assertGuest();
    }

    public function test_authenticated_non_admins_are_forbidden_from_admin_routes(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_invalid_admin_credentials_are_rejected(): void
    {
        $this->from('/admin/login')
            ->post('/admin/login', [
                'email' => 'admin@example.com',
                'password' => 'incorrect',
            ])
            ->assertRedirect('/admin/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_admin_can_open_artwork_and_site_settings_pages(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $this->actingAs($admin);

        $this->get('/admin/artworks')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Admin/Artworks/Index')
                ->has('artworks', 14));

        $this->get('/admin/settings')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Admin/Settings')
                ->where('settings.contact_email', config('services.contact.email')));
    }
}
