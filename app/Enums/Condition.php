<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Condition: string implements HasLabel
{
    case New = 'new';
    case Good = 'good';
    case Maintained = 'maintained';
    case Renovated = 'renovated';
    case NeedsRenovation = 'needs_renovation';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::New => 'New',
            self::Good => 'Good',
            self::Maintained => 'Maintained',
            self::Renovated => 'Renovated',
            self::NeedsRenovation => 'Needs Renovation',
        };
    }
}
