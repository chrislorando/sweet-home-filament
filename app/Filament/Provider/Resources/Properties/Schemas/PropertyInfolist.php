<?php

namespace App\Filament\Provider\Resources\Properties\Schemas;

use App\Enums\PropertyStatus;
use Dotswan\MapPicker\Infolists\MapEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PropertyInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->description('Basic property details')
                    ->icon('heroicon-o-home')
                    ->columns(2)
                    ->afterHeader(fn ($record) => $record->listing_type->getLabel())
                    ->schema([
                        TextEntry::make('title')
                            ->weight('bold')
                            ->columnSpanFull(),

                        TextEntry::make('slug')
                            ->copyable()
                            ->icon('heroicon-o-link')
                            ->columnSpanFull(),

                        TextEntry::make('description')
                            ->columnSpanFull()
                            ->prose(),

                        TextEntry::make('price')
                            ->money('CHF')
                            ->weight('bold')
                            ->color('success'),

                        TextEntry::make('status')
                            ->badge(),

                        TextEntry::make('category.name')
                            ->label('Category')
                            ->badge()
                            ->color('info'),

                        TextEntry::make('user.name')
                            ->label('Provider')
                            ->belowContent(fn ($record) => $record->user->company_name),
                    ]),

                Section::make('Location & Address')
                    ->description('Property location details')
                    ->icon('heroicon-o-map-pin')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('location.city')
                            ->label('City'),

                        TextEntry::make('location.postal_code')
                            ->label('Postal Code'),

                        TextEntry::make('location.region')
                            ->label('Region')
                            ->placeholder('-'),

                        TextEntry::make('location.country')
                            ->label('Country'),

                        TextEntry::make('address')
                            ->columnSpanFull()
                            ->icon('heroicon-o-map-pin'),

                        TextEntry::make('latitude')
                            ->numeric()
                            ->placeholder('-'),

                        TextEntry::make('longitude')
                            ->numeric()
                            ->placeholder('-'),

                        MapEntry::make('maps')
                            // Basic Configuration
                            ->defaultLocation(latitude: 40.4168, longitude: -3.7038)
                            ->draggable(false)
                            ->zoom(18)
                            ->minZoom(0)
                            ->maxZoom(28)
                            ->tilesUrl('https://tile.openstreetmap.de/{z}/{x}/{y}.png')
                            ->detectRetina(true)

                            // Marker Configuration
                            ->showMarker(true)
                            ->markerColor('#22c55eff')
                            ->markerIconSize([36, 36])
                            ->markerIconAnchor([18, 36])

                            // Controls
                            ->showFullscreenControl(true)
                            ->showZoomControl(true)

                            // Styling
                            ->extraStyles([
                                'min-height: 45vh',
                            ])

                            // State Management
                            ->state(fn ($record) => [
                                'lat' => $record?->latitude,
                                'lng' => $record?->longitude,
                            ])->columnSpanFull(),
                    ]),

                Section::make('Property Details')
                    ->description('Specifications and measurements')
                    ->icon('heroicon-o-information-circle')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('rooms')
                            ->numeric()
                            ->suffix(' rooms')
                            ->placeholder('-'),

                        TextEntry::make('condition')
                            ->badge()
                            ->placeholder('-'),

                        TextEntry::make('availability')
                            ->badge()
                            ->placeholder('-'),

                        TextEntry::make('property_type')
                            ->placeholder('-'),

                        TextEntry::make('floor')
                            ->numeric()
                            ->suffix(' floor')
                            ->placeholder('-'),

                        TextEntry::make('living_area')
                            ->numeric()
                            ->suffix(' m²')
                            ->placeholder('-'),

                        TextEntry::make('plot_size')
                            ->numeric()
                            ->suffix(' m²')
                            ->placeholder('-'),

                        TextEntry::make('construction_year')
                            ->placeholder('-'),

                        TextEntry::make('last_renovation')
                            ->placeholder('-'),

                        TextEntry::make('immocode')
                            ->placeholder('-')
                            ->copyable(),

                        TextEntry::make('property_number')
                            ->placeholder('-')
                            ->copyable(),

                        TextEntry::make('document_name')
                            ->placeholder('-')
                            ->url(fn ($record) => $record->document ? \Storage::disk()->url($record->document) : null)
                            ->openUrlInNewTab()
                            ->icon('heroicon-o-document')
                            ->columnSpanFull(),
                    ]),

                Section::make('Characteristics')
                    ->description('Property features and amenities')
                    ->icon('heroicon-o-check-circle')
                    ->schema([
                        TextEntry::make('characteristics.name')
                            ->bulleted()
                            ->placeholder('No characteristics added'),
                    ])
                    ->collapsible(),

                Section::make('Property Images')
                    ->description('Gallery of property images')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        RepeatableEntry::make('images')
                            ->schema([
                                ImageEntry::make('path')
                                    ->hiddenLabel()
                                    ->height(200)
                                    ->width(300)
                                    ->square(),
                            ])
                            ->contained(false)
                            ->grid(3)
                            ->placeholder('No images uploaded'),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),

                Section::make('Additional Information')
                    ->description('Status and notes')
                    ->icon('heroicon-o-document-text')
                    ->columns(fn ($record) => $record->status === PropertyStatus::Rejected ? 3 : 2)
                    ->schema([
                        TextEntry::make('approvedBy.name')
                            ->label('Approved By')
                            ->badge()
                            ->icon('heroicon-o-user')
                            ->visible(fn ($record) => $record->status === PropertyStatus::Approved),
                        TextEntry::make('approved_at')
                            ->label('Approved At')
                            ->dateTime()
                            ->icon('heroicon-o-calendar')
                            ->visible(fn ($record) => $record->status === PropertyStatus::Approved),
                        TextEntry::make('rejectedBy.name')
                            ->label('Rejected By')
                            ->badge()
                            ->icon('heroicon-o-user')
                            ->visible(fn ($record) => $record->status === PropertyStatus::Rejected),
                        TextEntry::make('rejected_at')
                            ->label('Rejected At')
                            ->dateTime()
                            ->icon('heroicon-o-calendar')
                            ->visible(fn ($record) => $record->status === PropertyStatus::Rejected),
                        TextEntry::make('rejection_notes')
                            ->placeholder('No rejection notes')
                            ->color('danger')
                            ->visible(fn ($record) => $record->status === PropertyStatus::Rejected),

                        TextEntry::make('created_at')
                            ->dateTime()
                            ->icon('heroicon-o-calendar'),

                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->icon('heroicon-o-calendar')
                            ->since(),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),
            ]);
    }
}
