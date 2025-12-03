<?php

namespace App\Filament\Resources\Locations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Location Information')
                    ->description('Enter the location details')
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        Select::make('country')
                            ->required()
                            ->options([
                                'Switzerland' => 'Switzerland',
                                'Germany' => 'Germany',
                                'France' => 'France',
                                'Italy' => 'Italy',
                                'Austria' => 'Austria',
                            ])
                            ->default('Switzerland')
                            ->searchable()
                            ->columnSpan(1),

                        TextInput::make('city')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Zürich')
                            ->columnSpan(1),

                        TextInput::make('region')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Zürich Canton')
                            ->helperText('State, canton, or province')
                            ->columnSpan(1),

                        TextInput::make('postal_code')
                            ->label('Postal Code')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., 8001')
                            ->columnSpan(1),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
