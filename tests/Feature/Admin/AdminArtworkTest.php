<?php

namespace Tests\Feature\Admin;

use App\Models\Artwork;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class AdminArtworkTest extends TestCase
{
    public function test_admin_can_create_an_artwork_with_an_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $this->actingAs($admin)
            ->post('/admin/artworks', [
                'title' => 'A New Story',
                'slug' => 'a-new-story',
                'category' => 'Nature',
                'alt' => 'A bright painting of flowers',
                'description' => 'A study of colour and nature.',
                'image' => UploadedFile::fake()->image('flowers.jpg', 800, 1000),
                'availability' => 'available',
                'medium' => 'Acrylic on canvas',
                'dimensions' => '50 × 70 cm',
                'featured' => true,
                'in_hero' => true,
                'is_published' => true,
                'sort_order' => 20,
            ])
            ->assertRedirectToRoute('admin.artworks.index')
            ->assertSessionHasNoErrors();

        $artwork = Artwork::query()->where('slug', 'a-new-story')->firstOrFail();

        $this->assertModelExists($artwork);
        $this->assertDatabaseHas('artworks', [
            'slug' => 'a-new-story',
            'availability' => 'available',
            'medium' => 'Acrylic on canvas',
            'dimensions' => '50 × 70 cm',
            'featured' => true,
            'in_hero' => true,
            'is_published' => true,
            'width' => 800,
            'height' => 1000,
        ]);
        Storage::disk('public')->assertExists($artwork->image);

        $this->get('/gallery')
            ->assertInertia(fn (Assert $page) => $page
                ->where('artworks.0.slug', 'ardhanarishvara')
                ->has('artworks', 15));
    }

    public function test_admin_can_update_and_unpublish_an_artwork_without_replacing_its_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $artwork = Artwork::query()->where('slug', 'ardhanarishvara')->firstOrFail();

        $this->actingAs($admin)
            ->put("/admin/artworks/{$artwork->id}", [
                'title' => 'A Quiet Balance',
                'slug' => 'a-quiet-balance',
                'category' => 'Indian traditions',
                'alt' => 'A deity in a mural painting',
                'description' => 'A revised story.',
                'availability' => 'sold',
                'featured' => false,
                'in_hero' => false,
                'is_published' => false,
                'sort_order' => 0,
            ])
            ->assertRedirectToRoute('admin.artworks.index')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('artworks', [
            'id' => $artwork->id,
            'slug' => 'a-quiet-balance',
            'image' => '/images/artworks/ardhanarishvara.jpg',
            'is_published' => false,
        ]);

        $this->get('/gallery/a-quiet-balance')->assertNotFound();
    }

    public function test_artwork_form_rejects_an_invalid_category_and_image_type(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $this->actingAs($admin)
            ->from('/admin/artworks/create')
            ->post('/admin/artworks', [
                'title' => 'Unsafe Upload',
                'slug' => 'unsafe-upload',
                'category' => 'Not a gallery category',
                'alt' => 'Artwork description',
                'description' => 'A description.',
                'image' => UploadedFile::fake()->create('picture.svg', 100, 'image/svg+xml'),
                'availability' => 'reserved',
                'featured' => false,
                'in_hero' => false,
                'is_published' => true,
                'sort_order' => 0,
            ])
            ->assertRedirect('/admin/artworks/create')
            ->assertSessionHasErrors(['category', 'image', 'availability']);

        $this->assertDatabaseMissing('artworks', ['slug' => 'unsafe-upload']);
    }

    public function test_admin_can_remove_an_artwork_and_its_uploaded_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $path = UploadedFile::fake()->image('painting.jpg')->store('artworks', 'public');
        $artwork = Artwork::query()->create([
            'title' => 'Temporary Study',
            'slug' => 'temporary-study',
            'category' => 'Nature',
            'alt' => 'A temporary study',
            'description' => 'A temporary study.',
            'image' => $path,
            'thumbnail' => $path,
            'featured' => false,
            'is_published' => false,
            'sort_order' => 100,
        ]);

        $this->actingAs($admin)
            ->delete("/admin/artworks/{$artwork->id}")
            ->assertRedirectToRoute('admin.artworks.index');

        $this->assertModelMissing($artwork);
        Storage::disk('public')->assertMissing($path);
    }
}
