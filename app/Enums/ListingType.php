<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ListingType: string implements HasColor, HasLabel
{
    case Buy = 'buy';
    case Rent = 'rent';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Buy => 'For Sale',
            self::Rent => 'For Rent',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Buy => 'success',
            self::Rent => 'info',
        };
    }
}
