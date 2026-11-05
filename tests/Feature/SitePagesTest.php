<?php

namespace Tests\Feature;

use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class SitePagesTest extends TestCase
{
    public function test_about_page_is_rendered(): void
    {
        $this->get('/about')
            ->assertInertia(fn (Assert $page) => $page->component('About'));
    }

    public function test_contact_page_is_rendered(): void
    {
        $this->get('/contact')
            ->assertInertia(fn (Assert $page) => $page->component('Contact'));
    }

    public function test_whatsapp_number_is_shared_as_digits_only(): void
    {
        config(['services.whatsapp.number' => '+254 712-345 678']);

        $this->get('/contact')
            ->assertInertia(fn (Assert $page) => $page
                ->where('contact.whatsapp', '254712345678')
                ->where('contact.email', config('services.contact.email')));
    }

    public function test_whatsapp_is_omitted_when_no_number_is_configured(): void
    {
        config(['services.whatsapp.number' => null]);

        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page->where('contact.whatsapp', null));
    }
}
