<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Availability: string implements HasLabel
{
    case Now = 'now';
    case Arrangement = 'arrangement';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Now => 'Immediately',
            self::Arrangement => 'By Arrangement',
        };
    }
}
