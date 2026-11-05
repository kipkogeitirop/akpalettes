<?php

namespace App\Http\Controllers;

use App\Support\ArtworkCatalog;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * List every public page and painting for search engines.
     */
    public function sitemap(ArtworkCatalog $catalog): Response
    {
        $pages = [
            ['url' => url('/'), 'priority' => '1.0', 'images' => []],
            ['url' => url('/gallery'), 'priority' => '0.9', 'images' => []],
            ['url' => url('/about'), 'priority' => '0.8', 'images' => [url('/images/aloknanda-kundu.jpg')]],
            ['url' => url('/contact'), 'priority' => '0.6', 'images' => []],
        ];

        foreach ($catalog->all() as $artwork) {
            $pages[] = [
                'url' => url("/gallery/{$artwork['slug']}"),
                'priority' => '0.7',
                'images' => [url($artwork['image'])],
            ];
        }

        return response()
            ->view('sitemap', ['pages' => $pages])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    /**
     * Tell crawlers where the sitemap is and keep them out of the admin area.
     */
    public function robots(): Response
    {
        $lines = [
            'User-agent: *',
            'Disallow: /admin',
            '',
            'Sitemap: '.route('sitemap'),
        ];

        return response(implode("\n", $lines)."\n")
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
