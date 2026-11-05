<?php

namespace Tests\Feature;

use App\Models\Artwork;
use App\Models\SiteSetting;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class SeoTest extends TestCase
{
    public function test_home_page_html_contains_meta_tags_for_crawlers_and_link_previews(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('<title data-inertia>AK PALETTES — Original paintings by artist Aloknanda Kundu</title>', false)
            ->assertSee('<meta data-inertia="description" name="description" content="Explore the art of Aloknanda Kundu', false)
            ->assertSee('<link data-inertia="canonical" rel="canonical" href="'.url('/').'">', false)
            ->assertSee('<meta data-inertia="og:image" property="og:image" content="'.url('/images/artworks/'), false)
            ->assertSee('<meta data-inertia="twitter:card" name="twitter:card" content="summary_large_image">', false)
            ->assertSee('"@type":"Person"', false)
            ->assertSee('"name":"Aloknanda Kundu"', false)
            ->assertDontSee('noindex', false);
    }

    public function test_artwork_page_describes_the_painting_with_structured_data(): void
    {
        $artwork = Artwork::query()->where('slug', 'tree-of-peacocks')->firstOrFail();
        $artwork->update(['medium' => 'Acrylic on canvas', 'dimensions' => '60 × 90 cm']);

        $this->get('/gallery/tree-of-peacocks')
            ->assertOk()
            ->assertSee("<title data-inertia>{$artwork->title} — Painting by Aloknanda Kundu | AK PALETTES</title>", false)
            ->assertSee('<link data-inertia="canonical" rel="canonical" href="'.url('/gallery/tree-of-peacocks').'">', false)
            ->assertSee('<meta data-inertia="og:image" property="og:image" content="'.url('/images/artworks/tree-of-peacocks.jpg').'">', false)
            ->assertSee('"@type":"VisualArtwork"', false)
            ->assertSee('"artMedium":"Acrylic on canvas"', false)
            ->assertSee('"@type":"BreadcrumbList"', false)
            ->assertInertia(fn (Assert $page) => $page
                ->where('seo.type', 'article')
                ->where('seo.canonical', url('/gallery/tree-of-peacocks')));
    }

    public function test_long_descriptions_are_trimmed_for_search_results(): void
    {
        Artwork::query()->where('slug', 'tree-of-peacocks')->update(['description' => str_repeat('A painted story. ', 30)]);

        $this->get('/gallery/tree-of-peacocks')
            ->assertInertia(fn (Assert $page) => $page
                ->where('seo.description', fn (string $description): bool => mb_strlen($description) <= 163));
    }

    public function test_instagram_profile_is_linked_to_the_artist_once_set(): void
    {
        SiteSetting::query()->updateOrCreate(['key' => 'instagram_handle'], ['value' => '@akpalettes']);

        $this->get('/about')
            ->assertOk()
            ->assertSee('"sameAs":["https://www.instagram.com/akpalettes/"]', false);
    }

    public function test_admin_pages_are_hidden_from_search_engines(): void
    {
        $this->get('/admin/login')
            ->assertOk()
            ->assertSee('<meta data-inertia="robots" name="robots" content="noindex, nofollow">', false);
    }

    public function test_sitemap_lists_public_pages_and_published_paintings(): void
    {
        Artwork::query()->where('slug', 'the-couple')->update(['is_published' => false]);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<loc>'.url('/about').'</loc>', false)
            ->assertSee('<loc>'.url('/gallery/tree-of-peacocks').'</loc>', false)
            ->assertSee('<image:loc>'.url('/images/artworks/tree-of-peacocks.jpg').'</image:loc>', false)
            ->assertDontSee('/gallery/the-couple<', false)
            ->assertDontSee('/admin', false);
    }

    public function test_robots_file_points_to_the_sitemap_and_blocks_admin(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Disallow: /admin')
            ->assertSee('Sitemap: '.url('/sitemap.xml'));
    }
}
