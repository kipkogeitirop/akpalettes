<?php

use App\Http\Controllers\Admin\ArtworkController as AdminArtworkController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\ArtworkController;
use App\Support\ArtworkCatalog;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function (ArtworkCatalog $catalog) {
    return Inertia::render('Welcome', [
        'hero' => $catalog->hero(),
        'featured' => $catalog->featured(),
    ]);
})->name('home');

Route::get('/gallery', [ArtworkController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{slug}', [ArtworkController::class, 'show'])->name('gallery.show');

Route::inertia('/about', 'About')->name('about');
Route::inertia('/contact', 'Contact')->name('contact');

Route::middleware('guest')->prefix('admin')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('throttle:admin-login')->name('admin.login.store');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('artworks', AdminArtworkController::class)->except('show');
    Route::get('/settings', [SiteSettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SiteSettingController::class, 'update'])->name('settings.update');
});
