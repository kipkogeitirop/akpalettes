<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['key', 'value'])]
class SiteSetting extends Model
{
    /**
     * @var array<string, string>
     */
    public const Defaults = [
        'home_intro_heading' => 'Art is how I make sense of the beautiful, the everyday, and everything in between.',
        'home_intro_copy' => 'I’m Aloknanda Kundu — an artist and painter drawn to the stories held in colour, culture and the world around us.',
        'home_story_first' => 'AK is me, Aloknanda Kundu. PALETTES is every possibility waiting to happen — the colours, the experiments, the happy accidents that become something personal.',
        'home_story_second' => 'AK PALETTES is where my ideas and influences meet: Indian traditions, African cultures, portraits, nature and the beautiful in-between.',
        'about_biography' => 'For me, painting has always been a way of making sense of the beautiful, the everyday and everything in between. A canvas is where I can slow down, look closely and say the things that are hard to put into words.',
        'about_influences' => 'My work moves between worlds. Some pieces lean on the rich traditions I grew up surrounded by — mural painting, folk art, the gods and goddesses of Indian stories. Others are drawn from African cultures, from nature, or simply from a face or a moment that stayed with me.',
        'about_colour' => 'What ties them together is colour. I believe colour has a language of its own, and every painting is my attempt to speak it.',
        'instagram_handle' => '',
        'testimonial_quote' => '',
        'testimonial_author' => '',
        'testimonial_detail' => '',
        'exhibitions' => '',
    ];

    /**
     * Return editable content merged with the application's default copy.
     *
     * @return array<string, string>
     */
    public static function values(): array
    {
        return [
            ...self::Defaults,
            'contact_email' => config('services.contact.email', 'hello@akpalettes.com'),
            'whatsapp_number' => config('services.whatsapp.number', ''),
            ...static::query()->pluck('value', 'key')->all(),
        ];
    }
}
