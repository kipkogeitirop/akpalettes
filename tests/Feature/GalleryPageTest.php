<?php

namespace Tests\Feature;

use App\Enums\ArtworkAvailability;
use App\Models\Artwork;
use App\Support\ArtworkCatalog;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class GalleryPageTest extends TestCase
{
    public function test_gallery_lists_every_artwork_and_category(): void
    {
        $this->get('/gallery')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Gallery/Index')
                ->has('artworks', 14)
                ->where('categories', ArtworkCatalog::Categories));
    }

    public function test_every_artwork_has_an_image_on_disk(): void
    {
        foreach ((new ArtworkCatalog)->all() as $artwork) {
            $this->assertFileExists(public_path($artwork['image']));
            $this->assertFileExists(public_path($artwork['thumbnail']));
            $this->assertContains($artwork['category'], ArtworkCatalog::Categories);
        }
    }

    public function test_artwork_page_shows_the_artwork_with_its_neighbours(): void
    {
        $this->get('/gallery/women-by-the-river')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Gallery/Show')
                ->where('artwork.title', 'Women by the River')
                ->where('position', 2)
                ->where('total', 14)
                ->where('previous.slug', 'ardhanarishvara')
                ->where('next.slug', 'krishna-and-the-herd')
                ->has('related', 4)
                ->where('related.0.category', 'Contemporary'));
    }

    public function test_first_artwork_wraps_around_to_the_last(): void
    {
        $this->get('/gallery/ardhanarishvara')
            ->assertInertia(fn (Assert $page) => $page
                ->where('previous.slug', 'the-tree-of-life'));
    }

    public function test_artwork_page_includes_sale_details(): void
    {
        Artwork::query()->where('slug', 'into-the-sun')->update([
            'availability' => ArtworkAvailability::Sold,
            'medium' => 'Acrylic on canvas',
            'dimensions' => '40 × 60 cm',
        ]);

        $this->get('/gallery/into-the-sun')
            ->assertInertia(fn (Assert $page) => $page
                ->where('artwork.availability', 'sold')
                ->where('artwork.availability_label', 'Sold')
                ->where('artwork.medium', 'Acrylic on canvas')
                ->where('artwork.dimensions', '40 × 60 cm'));
    }

    public function test_artworks_without_sale_details_have_no_availability(): void
    {
        $this->get('/gallery/into-the-sun')
            ->assertInertia(fn (Assert $page) => $page
                ->where('artwork.availability', null)
                ->where('artwork.availability_label', null));
    }

    public function test_unknown_artwork_returns_not_found(): void
    {
        $this->get('/gallery/not-a-real-painting')->assertNotFound();
    }
}
