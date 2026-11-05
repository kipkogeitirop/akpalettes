<?php

namespace App\Enums;

enum ArtworkAvailability: string
{
    case Available = 'available';
    case Sold = 'sold';

    /**
     * The label shown to visitors and in the admin.
     */
    public function label(): string
    {
        return match ($this) {
            self::Available => 'Available',
            self::Sold => 'Sold',
        };
    }
}
