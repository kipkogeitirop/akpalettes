<?php

namespace Tests\Feature;

use App\Models\Artwork;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_home_page_is_rendered_with_the_featured_artworks(): void
    {
        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Welcome')
                ->has('featured', 4)
                ->where('featured.0.slug', 'ardhanarishvara')
                ->where('featured.0.thumbnail', '/images/artworks/ardhanarishvara-sm.jpg'));
    }

    public function test_hero_rotates_through_the_artworks_chosen_for_it(): void
    {
        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->has('hero', 4)
                ->where('hero.0.slug', 'krishna-and-the-herd')
                ->where('hero.3.slug', 'woman-with-a-basket'));
    }

    public function test_hero_never_shows_more_than_four_artworks(): void
    {
        Artwork::query()->update(['in_hero' => true]);

        $this->get('/')->assertInertia(fn (Assert $page) => $page->has('hero', 4));
    }

    public function test_hero_falls_back_to_a_featured_artwork_when_none_are_chosen(): void
    {
        Artwork::query()->update(['in_hero' => false]);

        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->has('hero', 1)
                ->where('hero.0.featured', true));
    }

    public function test_unpublished_artworks_are_left_out_of_the_hero(): void
    {
        Artwork::query()->where('slug', 'krishna-and-the-herd')->update(['is_published' => false]);

        $this->get('/')
            ->assertInertia(fn (Assert $page) => $page
                ->has('hero', 3)
                ->where('hero.0.slug', 'the-stag-in-bloom'));
    }
}
