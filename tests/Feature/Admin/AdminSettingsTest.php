<?php

namespace Tests\Feature\Admin;

use App\Models\SiteSetting;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class AdminSettingsTest extends TestCase
{
    public function test_admin_can_update_content_and_contact_settings(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $settings = SiteSetting::values();
        $settings['home_intro_heading'] = 'Every colour has a story.';
        $settings['contact_email'] = 'studio@example.com';
        $settings['whatsapp_number'] = '+254 700 123 456';

        $this->actingAs($admin)
            ->put('/admin/settings', $settings)
            ->assertRedirectToRoute('admin.settings.edit')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('site_settings', [
            'key' => 'home_intro_heading',
            'value' => 'Every colour has a story.',
        ]);

        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->where('siteContent.home_intro_heading', 'Every colour has a story.')
                ->where('contact.email', 'studio@example.com')
                ->where('contact.whatsapp', '254700123456'));
    }

    public function test_admin_can_add_social_proof_to_the_homepage(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $settings = SiteSetting::values();
        $settings['instagram_handle'] = '@akpalettes';
        $settings['testimonial_quote'] = 'It brightens our home every day.';
        $settings['testimonial_author'] = 'A happy collector';
        $settings['exhibitions'] = '2025 — Spring Show, City Gallery';

        $this->actingAs($admin)
            ->put('/admin/settings', $settings)
            ->assertSessionHasNoErrors();

        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->where('siteContent.instagram_handle', '@akpalettes')
                ->where('siteContent.testimonial_quote', 'It brightens our home every day.')
                ->where('siteContent.exhibitions', '2025 — Spring Show, City Gallery'));
    }

    public function test_social_proof_is_empty_until_the_admin_adds_it(): void
    {
        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->where('siteContent.instagram_handle', '')
                ->where('siteContent.testimonial_quote', '')
                ->where('siteContent.exhibitions', ''));
    }

    public function test_a_collector_quote_needs_a_name_and_a_valid_instagram_handle(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $settings = SiteSetting::values();
        $settings['testimonial_quote'] = 'Wonderful work.';
        $settings['testimonial_author'] = '';
        $settings['instagram_handle'] = 'https://instagram.com/akpalettes';

        $this->actingAs($admin)
            ->from('/admin/settings')
            ->put('/admin/settings', $settings)
            ->assertSessionHasErrors(['testimonial_author', 'instagram_handle']);
    }

    public function test_site_settings_reject_invalid_contact_addresses_without_saving(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $settings = SiteSetting::values();
        $settings['contact_email'] = 'not-an-email';

        $this->actingAs($admin)
            ->from('/admin/settings')
            ->put('/admin/settings', $settings)
            ->assertRedirect('/admin/settings')
            ->assertSessionHasErrors('contact_email');

        $this->assertDatabaseMissing('site_settings', [
            'key' => 'contact_email',
            'value' => 'not-an-email',
        ]);
    }
}
