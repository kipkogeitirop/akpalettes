<?php

namespace App\Models;

use App\Enums\ArtworkAvailability;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'slug',
    'title',
    'category',
    'availability',
    'medium',
    'dimensions',
    'alt',
    'description',
    'width',
    'height',
    'image',
    'thumbnail',
    'featured',
    'in_hero',
    'is_published',
    'sort_order',
])]
class Artwork extends Model
{
    protected function casts(): array
    {
        return [
            'availability' => ArtworkAvailability::class,
            'featured' => 'boolean',
            'in_hero' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    /**
     * Scope a query to artworks visible in the public gallery.
     *
     * @param  Builder<Artwork>  $query
     * @return Builder<Artwork>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }
}
