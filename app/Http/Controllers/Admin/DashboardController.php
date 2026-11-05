<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        return inertia('Admin/Dashboard', [
            'stats' => [
                'total' => Artwork::query()->count(),
                'published' => Artwork::query()->where('is_published', true)->count(),
                'drafts' => Artwork::query()->where('is_published', false)->count(),
                'featured' => Artwork::query()->where('featured', true)->count(),
            ],
            'recentArtworks' => Artwork::query()
                ->orderByDesc('updated_at')
                ->orderByDesc('id')
                ->limit(5)
                ->get(['id', 'title', 'category', 'image', 'is_published', 'updated_at']),
        ]);
    }
}
