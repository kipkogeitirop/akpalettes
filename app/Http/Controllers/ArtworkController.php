<?php

namespace App\Http\Controllers;

use App\Support\ArtworkCatalog;
use Inertia\Response;

class ArtworkController extends Controller
{
    public function __construct(private ArtworkCatalog $catalog) {}

    /**
     * Show the full gallery.
     */
    public function index(): Response
    {
        return inertia('Gallery/Index', [
            'artworks' => $this->catalog->all(),
            'categories' => ArtworkCatalog::Categories,
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
        ]);
    }
}
