<?php

namespace App\Support;

use App\Models\Artwork;
use Illuminate\Support\Facades\Storage;

/**
 * The collection of artworks shown across the site.
 *
 * @phpstan-type Artwork array{
 *     slug: string,
 *     title: string,
 *     category: string,
 *     alt: string,
 *     description: string,
 *     width: int,
 *     height: int,
 *     featured: bool,
 *     availability: string|null,
 *     availability_label: string|null,
 *     medium: string|null,
 *     dimensions: string|null,
 *     image: string,
 *     thumbnail: string,
 * }
 */
class ArtworkCatalog
{
    /**
     * The order categories appear in on the gallery filters.
     *
     * @var list<string>
     */
    public const Categories = ['Indian traditions', 'Nature', 'Contemporary', 'African cultures'];

    /**
     * @var list<array{slug: string, title: string, category: string, alt: string, description: string, width: int, height: int, featured?: bool, in_hero?: bool}>
     */
    private const Artworks = [
        [
            'slug' => 'ardhanarishvara',
            'title' => 'Ardhanarishvara',
            'category' => 'Indian traditions',
            'alt' => 'Mural-style painting of a deity, half white and half green, framed by a dotted orange border',
            'description' => 'Half Shiva, half Parvati — one face, two natures, held in perfect balance. Inspired by the rich ochres and fine ornament of Kerala mural painting, this piece is about the idea that opposites are never really apart.',
            'width' => 1099,
            'height' => 1600,
            'featured' => true,
        ],
        [
            'slug' => 'women-by-the-river',
            'title' => 'Women by the River',
            'category' => 'Contemporary',
            'alt' => 'Golden painting of three women seated by a river beneath a willow, a town in the distance',
            'description' => 'Three women pause by the water as the town glows behind them. Warm golds and soft willow greens turn an ordinary moment of rest into something that feels like a memory.',
            'width' => 1090,
            'height' => 745,
        ],
        [
            'slug' => 'krishna-and-the-herd',
            'title' => 'Krishna and the Herd',
            'category' => 'Indian traditions',
            'alt' => 'Mural-style painting of Krishna playing the flute, surrounded by cows beneath a green tree',
            'description' => 'Krishna plays his flute beneath a spreading tree while the herd gathers close. The patterned border and layered greens draw on traditional devotional painting, told with a gentle, joyful hand.',
            'width' => 1055,
            'height' => 1425,
            'in_hero' => true,
        ],
        [
            'slug' => 'two-faces-of-the-goddess',
            'title' => 'Two Faces of the Goddess',
            'category' => 'Contemporary',
            'alt' => 'Two women’s faces, one golden and one blue, framed by red hibiscus flowers',
            'description' => 'Gentle and fierce, golden and blue — two faces of the same goddess, framed by red hibiscus. A contemporary portrait about the many sides we each carry.',
            'width' => 1145,
            'height' => 1150,
            'featured' => true,
        ],
        [
            'slug' => 'the-stag-in-bloom',
            'title' => 'The Stag in Bloom',
            'category' => 'Nature',
            'alt' => 'A stag standing among pink roses and wildflowers in front of a misty blue forest',
            'description' => 'A stag stands quietly at the edge of a misty forest, half hidden among roses and wildflowers. A study in stillness, texture and the softness of the natural world.',
            'width' => 960,
            'height' => 1310,
            'in_hero' => true,
        ],
        [
            'slug' => 'durga-in-ink',
            'title' => 'Durga in Ink',
            'category' => 'Indian traditions',
            'alt' => 'Detailed black and white line drawing of Durga riding a lion beneath an ornate arch',
            'description' => 'Durga rides her lion beneath an ornate arch, drawn entirely in black and white. Without colour, every line has to carry the story — the strength, the movement and the detail.',
            'width' => 970,
            'height' => 1405,
        ],
        [
            'slug' => 'into-the-sun',
            'title' => 'Into the Sun',
            'category' => 'African cultures',
            'alt' => 'Silhouette of a woman in a patterned dress and headwrap walking toward a glowing orange sun',
            'description' => 'A woman in a patterned dress walks toward a blazing sun, the city glowing around her. Inspired by African cultures, this piece celebrates grace, strength and the warmth of a golden hour.',
            'width' => 870,
            'height' => 1470,
            'featured' => true,
        ],
        [
            'slug' => 'buddha-beneath-the-tree',
            'title' => 'Buddha Beneath the Tree',
            'category' => 'Nature',
            'alt' => 'A resting Buddha beneath a flowering tree full of birds, framed by a vine border',
            'description' => 'The Buddha rests beneath a flowering tree alive with birds, framed by a winding vine. A quiet piece about peace, patience and finding calm in nature.',
            'width' => 873,
            'height' => 1600,
        ],
        [
            'slug' => 'shiva-and-parvati',
            'title' => 'Shiva and Parvati',
            'category' => 'Indian traditions',
            'alt' => 'Shiva and Parvati seated beneath a draped arch, in black line work against deep maroon',
            'description' => 'Shiva and Parvati sit side by side beneath a draped arch. Intricate black line work against deep maroon gives this divine couple a timeless, textile-like richness.',
            'width' => 1040,
            'height' => 1470,
        ],
        [
            'slug' => 'tree-of-peacocks',
            'title' => 'Tree of Peacocks',
            'category' => 'Nature',
            'alt' => 'A cream tree of flowers and peacocks painted against a rich red background',
            'description' => 'Peacocks nest among the blossoms of a flowering tree, painted in cream and charcoal against a rich red ground. Inspired by Indian textile traditions and the endless pattern of nature.',
            'width' => 1035,
            'height' => 1380,
            'in_hero' => true,
        ],
        [
            'slug' => 'the-cat-and-the-fish',
            'title' => 'The Cat and the Fish',
            'category' => 'Indian traditions',
            'alt' => 'Folk painting of a woman holding a fish while a cat steals another from a table',
            'description' => 'A woman holds up her catch while the cat helps itself to another. Inspired by the bold lines and playful wit of Kalighat painting, it’s a little everyday drama with a smile.',
            'width' => 1110,
            'height' => 1390,
            'featured' => true,
        ],
        [
            'slug' => 'woman-with-a-basket',
            'title' => 'Woman with a Basket',
            'category' => 'Contemporary',
            'alt' => 'A woman in blue carrying a basket on her head and a stringed instrument, painted in bold yellows',
            'description' => 'A woman carries a basket on her head and music in her hands. Bold yellows and blues and fragmented, cubist-inspired shapes bring a traditional scene into a contemporary world.',
            'width' => 1145,
            'height' => 1455,
            'in_hero' => true,
        ],
        [
            'slug' => 'the-couple',
            'title' => 'The Couple',
            'category' => 'Indian traditions',
            'alt' => 'Folk painting of a man adorning a seated woman’s hair beneath a blue curtain',
            'description' => 'A man tucks a flower into his wife’s hair as she checks her reflection. Inspired by Kalighat painting, it’s a tender, slightly theatrical moment framed by a blue curtain.',
            'width' => 985,
            'height' => 1320,
        ],
        [
            'slug' => 'the-tree-of-life',
            'title' => 'The Tree of Life',
            'category' => 'Indian traditions',
            'alt' => 'A tree with a deer and a woman’s face woven into its trunk, painted in blue, green and orange on white',
            'description' => 'A deer and a woman grow from the roots of the same tree. Inspired by the dotted, flowing patterns of Gond art, it’s a reminder that people and nature share one story.',
            'width' => 940,
            'height' => 1235,
        ],
    ];

    /**
     * Get every artwork in gallery order.
     *
     * @return list<Artwork>
     */
    public function all(): array
    {
        return Artwork::query()
            ->published()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map($this->present(...))
            ->all();
    }

    /**
     * Get the artworks highlighted on the home page.
     *
     * @return list<Artwork>
     */
    public function featured(): array
    {
        return Artwork::query()
            ->published()
            ->where('featured', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map($this->present(...))
            ->all();
    }

    /**
     * Get the artworks that rotate through the home page hero.
     *
     * Falls back to the featured works, then the first artwork, so the hero is never empty.
     *
     * @return list<Artwork>
     */
    public function hero(int $limit = 4): array
    {
        $hero = Artwork::query()
            ->published()
            ->where('in_hero', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->limit($limit)
            ->get();

        if ($hero->isEmpty()) {
            $hero = Artwork::query()
                ->published()
                ->orderByDesc('featured')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->limit(1)
                ->get();
        }

        return $hero->map($this->present(...))->all();
    }

    /**
     * Find an artwork by its slug.
     *
     * @return Artwork|null
     */
    public function find(string $slug): ?array
    {
        $artwork = Artwork::query()->published()->where('slug', $slug)->first();

        return $artwork === null ? null : $this->present($artwork);
    }

    /**
     * Get other artworks in the same category, falling back to the rest of the collection.
     *
     * @param  Artwork  $artwork
     * @return list<Artwork>
     */
    public function related(array $artwork, int $limit = 4): array
    {
        $others = array_values(array_filter(
            $this->all(),
            fn (array $other): bool => $other['slug'] !== $artwork['slug'],
        ));

        usort($others, fn (array $first, array $second): int => ($second['category'] === $artwork['category']) <=> ($first['category'] === $artwork['category']));

        return array_slice($others, 0, $limit);
    }

    /**
     * @param  array{slug: string, title: string, category: string, alt: string, description: string, width: int, height: int, featured?: bool}  $artwork
     * @return Artwork
     */
    private function present(Artwork $artwork): array
    {
        return [
            'slug' => $artwork->slug,
            'title' => $artwork->title,
            'category' => $artwork->category,
            'alt' => $artwork->alt,
            'description' => $artwork->description,
            'width' => $artwork->width,
            'height' => $artwork->height,
            'featured' => $artwork->featured,
            'availability' => $artwork->availability?->value,
            'availability_label' => $artwork->availability?->label(),
            'medium' => $artwork->medium,
            'dimensions' => $artwork->dimensions,
            'image' => $this->imageUrl($artwork->image),
            'thumbnail' => $this->imageUrl($artwork->thumbnail ?? $artwork->image),
        ];
    }

    /**
     * @return list<array<string, int|string|bool|null>>
     */
    public static function seedRecords(): array
    {
        return array_map(
            static fn (array $artwork, int $index): array => [
                ...$artwork,
                'featured' => $artwork['featured'] ?? false,
                'in_hero' => $artwork['in_hero'] ?? false,
                'is_published' => true,
                'sort_order' => $index,
                'image' => "/images/artworks/{$artwork['slug']}.jpg",
                'thumbnail' => "/images/artworks/{$artwork['slug']}-sm.jpg",
            ],
            self::Artworks,
            array_keys(self::Artworks),
        );
    }

    private function imageUrl(string $path): string
    {
        return str_starts_with($path, '/') ? $path : Storage::disk('public')->url($path);
    }
}
