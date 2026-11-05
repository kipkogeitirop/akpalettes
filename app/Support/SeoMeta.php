<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Support\Str;

/**
 * Builds the title, description, social preview and structured data for a public page.
 *
 * The result is shared with the page as the `seo` prop, so the root Blade template can print it
 * for crawlers and link previews, and the client-side <Seo> component can keep it in sync.
 *
 * @phpstan-type Seo array{
 *     title: string,
 *     description: string,
 *     canonical: string,
 *     image: string,
 *     imageAlt: string,
 *     type: string,
 *     siteName: string,
 *     schema: array<string, mixed>
 * }
 */
class SeoMeta
{
    public const SiteName = 'AK PALETTES';

    public const ArtistName = 'Aloknanda Kundu';

    public const DefaultImage = '/images/artworks/tree-of-peacocks.jpg';

    public const PortraitImage = '/images/aloknanda-kundu.jpg';

    /**
     * @param  list<array<string, mixed>>  $schema
     * @return Seo
     */
    public function page(
        string $title,
        string $description,
        ?string $image = null,
        ?string $imageAlt = null,
        string $type = 'website',
        array $schema = [],
    ): array {
        return [
            'title' => $title,
            'description' => Str::limit(Str::squish($description), 160),
            'canonical' => url()->current(),
            'image' => $this->absoluteUrl($image ?? self::DefaultImage),
            'imageAlt' => $imageAlt ?? 'A painting by '.self::ArtistName,
            'type' => $type,
            'siteName' => self::SiteName,
            'schema' => [
                '@context' => 'https://schema.org',
                '@graph' => $schema,
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function website(): array
    {
        return [
            '@type' => 'WebSite',
            '@id' => url('/').'#website',
            'name' => self::SiteName,
            'url' => url('/'),
            'publisher' => ['@id' => $this->artistId()],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function artist(): array
    {
        $instagramHandle = ltrim(SiteSetting::values()['instagram_handle'] ?? '', '@');

        return array_filter([
            '@type' => 'Person',
            '@id' => $this->artistId(),
            'name' => self::ArtistName,
            'jobTitle' => 'Artist and painter',
            'url' => url('/about'),
            'image' => $this->absoluteUrl(self::PortraitImage),
            'brand' => ['@type' => 'Brand', 'name' => self::SiteName],
            'knowsAbout' => ['Painting', 'Indian traditional art', 'African art', 'Contemporary art'],
            'sameAs' => $instagramHandle !== '' ? ["https://www.instagram.com/{$instagramHandle}/"] : null,
        ]);
    }

    /**
     * @param  array<string, mixed>  $artwork
     * @return array<string, mixed>
     */
    public function artwork(array $artwork): array
    {
        return array_filter([
            '@type' => 'VisualArtwork',
            '@id' => url("/gallery/{$artwork['slug']}").'#artwork',
            'name' => $artwork['title'],
            'description' => $artwork['description'],
            'image' => $this->absoluteUrl($artwork['image']),
            'url' => url("/gallery/{$artwork['slug']}"),
            'artform' => 'Painting',
            'genre' => $artwork['category'],
            'artMedium' => $artwork['medium'] ?? null,
            'size' => $artwork['dimensions'] ?? null,
            'creator' => ['@id' => $this->artistId()],
        ]);
    }

    /**
     * @param  array<string, string>  $crumbs  Page names keyed by their path.
     * @return array<string, mixed>
     */
    public function breadcrumbs(array $crumbs): array
    {
        $position = 0;

        return [
            '@type' => 'BreadcrumbList',
            'itemListElement' => array_map(
                function (string $path, string $name) use (&$position): array {
                    return [
                        '@type' => 'ListItem',
                        'position' => ++$position,
                        'name' => $name,
                        'item' => url($path),
                    ];
                },
                array_keys($crumbs),
                $crumbs,
            ),
        ];
    }

    private function artistId(): string
    {
        return url('/about').'#artist';
    }

    private function absoluteUrl(string $path): string
    {
        return Str::startsWith($path, ['http://', 'https://']) ? $path : url($path);
    }
}
