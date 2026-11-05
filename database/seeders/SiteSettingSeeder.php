<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (SiteSetting::Defaults as $key => $value) {
            SiteSetting::query()->firstOrCreate(
                ['key' => $key],
                ['value' => $value],
            );
        }
    }
}
