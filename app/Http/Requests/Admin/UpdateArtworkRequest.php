<?php

namespace App\Http\Requests\Admin;

use App\Enums\ArtworkAvailability;
use App\Models\Artwork;
use App\Models\User;
use App\Support\ArtworkCatalog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateArtworkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() instanceof User && $this->user()->is_admin;
    }

    public function rules(): array
    {
        $artwork = $this->route('artwork');

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:160',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('artworks', 'slug')->ignore($artwork instanceof Artwork ? $artwork->id : null),
            ],
            'category' => ['required', 'string', Rule::in(ArtworkCatalog::Categories)],
            'availability' => ['nullable', Rule::enum(ArtworkAvailability::class)],
            'medium' => ['nullable', 'string', 'max:120'],
            'dimensions' => ['nullable', 'string', 'max:60'],
            'alt' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'extensions:jpg,jpeg,png,webp', 'max:10240'],
            'featured' => ['required', 'boolean'],
            'in_hero' => ['required', 'boolean'],
            'is_published' => ['required', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ];
    }
}
