<?php

use App\Http\Controllers\Admin\ArtworkController as AdminArtworkController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\SitemapController;
use App\Support\ArtworkCatalog;
use App\Support\SeoMeta;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function (ArtworkCatalog $catalog, SeoMeta $seo) {
    $hero = $catalog->hero();

    return Inertia::render('Welcome', [
        'hero' => $hero,
        'featured' => $catalog->featured(),
        'seo' => $seo->page(
            title: 'AK PALETTES — Original paintings by artist Aloknanda Kundu',
            description: 'Explore the art of Aloknanda Kundu: original contemporary paintings inspired by Indian traditions, African cultures, nature and the stories that connect us. Commissions welcome.',
            image: $hero[0]['image'] ?? null,
            imageAlt: $hero[0]['alt'] ?? null,
            schema: [$seo->website(), $seo->artist()],
        ),
    ]);
})->name('home');

Route::get('/gallery', [ArtworkController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{slug}', [ArtworkController::class, 'show'])->name('gallery.show');

Route::get('/about', function (SeoMeta $seo) {
    return Inertia::render('About', [
        'seo' => $seo->page(
            title: 'About the artist Aloknanda Kundu | AK PALETTES',
            description: 'Meet Aloknanda Kundu, the artist and painter behind AK PALETTES, and the Indian traditions, African cultures, nature and memories that shape her work.',
            image: SeoMeta::PortraitImage,
            imageAlt: 'Portrait of the artist Aloknanda Kundu',
            type: 'profile',
            schema: [
                [
                    '@type' => 'ProfilePage',
                    'name' => 'About Aloknanda Kundu',
                    'url' => url('/about'),
                    'mainEntity' => ['@id' => url('/about').'#artist'],
                ],
                $seo->breadcrumbs(['/' => 'Home', '/about' => 'The artist']),
                $seo->artist(),
            ],
        ),
    ]);
})->name('about');

Route::get('/contact', function (SeoMeta $seo) {
    return Inertia::render('Contact', [
        'seo' => $seo->page(
            title: 'Contact & commissions — Aloknanda Kundu | AK PALETTES',
            description: 'Get in touch with Aloknanda Kundu on WhatsApp or by email about buying an original painting, commissioning a piece or collaborating.',
            schema: [
                [
                    '@type' => 'ContactPage',
                    'name' => 'Get in touch',
                    'url' => url('/contact'),
                    'about' => ['@id' => url('/about').'#artist'],
                ],
                $seo->breadcrumbs(['/' => 'Home', '/contact' => 'Get in touch']),
                $seo->artist(),
            ],
        ),
    ]);
})->name('contact');

Route::get('/sitemap.xml', [SitemapController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

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
