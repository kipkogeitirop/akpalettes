<?php

namespace Database\Seeders;

use App\Models\Artwork;
use App\Support\ArtworkCatalog;
use Illuminate\Database\Seeder;

class ArtworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (ArtworkCatalog::seedRecords() as $artwork) {
            Artwork::query()->firstOrCreate(
                ['slug' => $artwork['slug']],
                $artwork,
            );
        }
    }
}
