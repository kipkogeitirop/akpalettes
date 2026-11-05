<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ArtworkAvailability;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreArtworkRequest;
use App\Http\Requests\Admin\UpdateArtworkRequest;
use App\Models\Artwork;
use App\Support\ArtworkCatalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Response;
use RuntimeException;

class ArtworkController extends Controller
{
    public function index(): Response
    {
        return inertia('Admin/Artworks/Index', [
            'artworks' => Artwork::query()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(['id', 'title', 'slug', 'category', 'availability', 'image', 'is_published', 'featured', 'in_hero', 'sort_order'])
                ->map(fn (Artwork $artwork): array => [
                    ...$artwork->only(['id', 'title', 'slug', 'category', 'is_published', 'featured', 'in_hero', 'sort_order']),
                    'availability_label' => $artwork->availability?->label(),
                    'image_url' => $this->imageUrl($artwork->image),
                ])
                ->all(),
        ]);
    }

    public function create(): Response
    {
        return inertia('Admin/Artworks/Form', [
            'artwork' => null,
            'categories' => ArtworkCatalog::Categories,
            'availabilities' => $this->availabilityOptions(),
        ]);
    }

    public function store(StoreArtworkRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $image = $request->file('image');
        $data['image'] = $this->storeImage($image);
        $data['thumbnail'] = $data['image'];
        [$data['width'], $data['height']] = $image->dimensions();

        Artwork::query()->create($data);

        return redirect()->route('admin.artworks.index')->with('success', 'Artwork added to your collection.');
    }

    public function edit(Artwork $artwork): Response
    {
        return inertia('Admin/Artworks/Form', [
            'artwork' => [
                ...$artwork->toArray(),
                'image_url' => $this->imageUrl($artwork->image),
            ],
            'categories' => ArtworkCatalog::Categories,
            'availabilities' => $this->availabilityOptions(),
        ]);
    }

    public function update(UpdateArtworkRequest $request, Artwork $artwork): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $oldImage = $artwork->image;
            $image = $request->file('image');
            $data['image'] = $this->storeImage($image);
            $data['thumbnail'] = $data['image'];
            [$data['width'], $data['height']] = $image->dimensions();
        } else {
            unset($data['image']);
        }

        $artwork->update($data);

        if (isset($oldImage)) {
            $this->deleteUploadedImage($oldImage);
        }

        return redirect()->route('admin.artworks.index')->with('success', 'Artwork updated.');
    }

    public function destroy(Artwork $artwork): RedirectResponse
    {
        $image = $artwork->image;
        $thumbnail = $artwork->thumbnail;

        $artwork->delete();

        $this->deleteUploadedImage($image);

        if ($thumbnail !== $image) {
            $this->deleteUploadedImage($thumbnail);
        }

        return redirect()->route('admin.artworks.index')->with('success', 'Artwork removed.');
    }

    /**
     * @return list<array{value: string, label: string}>
     */
    private function availabilityOptions(): array
    {
        return array_map(
            fn (ArtworkAvailability $availability): array => ['value' => $availability->value, 'label' => $availability->label()],
            ArtworkAvailability::cases(),
        );
    }

    private function deleteUploadedImage(?string $path): void
    {
        if ($path !== null && Str::startsWith($path, 'artworks/') && Storage::disk('public')->exists($path)) {
            if (! Storage::disk('public')->delete($path)) {
                throw new RuntimeException('An uploaded artwork image could not be removed.');
            }
        }
    }

    private function storeImage(UploadedFile $image): string
    {
        $path = $image->store('artworks', 'public');

        if ($path === false) {
            throw new RuntimeException('The artwork image could not be stored.');
        }

        return $path;
    }

    private function imageUrl(string $path): string
    {
        return Str::startsWith($path, '/') ? $path : Storage::disk('public')->url($path);
    }
}
