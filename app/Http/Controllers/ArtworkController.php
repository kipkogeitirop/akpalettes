<?php

namespace App\Http\Controllers;

use App\Support\ArtworkCatalog;
use App\Support\SeoMeta;
use Inertia\Response;

class ArtworkController extends Controller
{
    public function __construct(private ArtworkCatalog $catalog, private SeoMeta $seo) {}

    /**
     * Show the full gallery.
     */
    public function index(): Response
    {
        $artworks = $this->catalog->all();

        return inertia('Gallery/Index', [
            'artworks' => $artworks,
            'categories' => ArtworkCatalog::Categories,
            'seo' => $this->seo->page(
                title: 'Gallery — Original paintings by Aloknanda Kundu | AK PALETTES',
                description: 'Browse original paintings by Aloknanda Kundu, inspired by Indian traditions, nature, African cultures and contemporary life. Enquire about available works and commissions.',
                image: $artworks[0]['image'] ?? null,
                imageAlt: $artworks[0]['alt'] ?? null,
                schema: [
                    [
                        '@type' => 'CollectionPage',
                        'name' => 'Gallery',
                        'url' => url('/gallery'),
                        'about' => ['@id' => url('/about').'#artist'],
                        'hasPart' => array_map(
                            fn (array $artwork): array => ['@id' => url("/gallery/{$artwork['slug']}").'#artwork'],
                            $artworks,
                        ),
                    ],
                    $this->seo->breadcrumbs(['/' => 'Home', '/gallery' => 'Gallery']),
                    $this->seo->artist(),
                ],
            ),
        ]);
    }

    /**
     * Show a single artwork.
     */
    public function show(string $slug): Response
    {
        $artwork = $this->catalog->find($slug);

        abort_if($artwork === null, 404);

        $artworks = $this->catalog->all();
        $position = array_search($slug, array_column($artworks, 'slug'), true);
        $count = count($artworks);

        return inertia('Gallery/Show', [
            'artwork' => $artwork,
            'position' => $position + 1,
            'total' => $count,
            'previous' => $artworks[($position - 1 + $count) % $count],
            'next' => $artworks[($position + 1) % $count],
            'related' => $this->catalog->related($artwork),
            'seo' => $this->seo->page(
                title: "{$artwork['title']} — Painting by Aloknanda Kundu | AK PALETTES",
                description: $artwork['description'],
                image: $artwork['image'],
                imageAlt: $artwork['alt'],
                type: 'article',
                schema: [
                    $this->seo->artwork($artwork),
                    $this->seo->breadcrumbs([
                        '/' => 'Home',
                        '/gallery' => 'Gallery',
                        "/gallery/{$artwork['slug']}" => $artwork['title'],
                    ]),
                    $this->seo->artist(),
                ],
            ),
        ]);
    }
}
