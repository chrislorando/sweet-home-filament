<?php

namespace App\Filament\Resources\Characteristics\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CharacteristicForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Characteristic Details')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Balcony')
                            ->columnSpanFull(),

                        Hidden::make('type')
                            ->default('boolean'),
                    ])
                    ->columns(1)
                    ->columnSpanFull(),
            ]);
    }
}
