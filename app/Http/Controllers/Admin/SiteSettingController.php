<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSiteSettingRequest;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Response;

class SiteSettingController extends Controller
{
    public function edit(): Response
    {
        return inertia('Admin/Settings', [
            'settings' => SiteSetting::values(),
        ]);
    }

    public function update(UpdateSiteSettingRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request): void {
            foreach ($request->validated() as $key => $value) {
                SiteSetting::query()->updateOrCreate(
                    ['key' => $key],
                    ['value' => (string) $value],
                );
            }
        });

        return redirect()->route('admin.settings.edit')->with('success', 'Site settings saved.');
    }
}
