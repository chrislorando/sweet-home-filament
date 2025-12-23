<?php

namespace App\Filament\Resources\Properties\Schemas;

use App\Enums\Availability;
use App\Enums\Condition;
use App\Models\Location;
use Dotswan\MapPicker\Fields\Map;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PropertyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->description('Basic details about the property')
                    ->icon('heroicon-o-home')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('slug', Str::slug($state));
                            })
                            ->columnSpanFull(),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->dehydrated(),

                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required()
                            ->preload(),

                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('CHF')
                            ->maxValue(999999999),

                        Textarea::make('description')
                            ->required()
                            ->columnSpanFull()
                            ->rows(4),
                    ])
                    ->columnSpanFull(),

                Section::make('Location & Address')
                    ->description('Where is the property located?')
                    ->icon('heroicon-o-map-pin')
                    ->columns(2)
                    ->schema([
                        Select::make('location_id')
                            ->relationship('location', 'city')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->city} ({$record->postal_code})")
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, $livewire) {
                                if (! $state) {
                                    return;
                                }

                                $location = Location::find($state);
                                if (! $location) {
                                    return;
                                }

                                $query = "{$location->city}, {$location->country}";

                                try {
                                    $response = Http::withHeaders([
                                        'User-Agent' => 'Casafina.ch/1.0',
                                    ])->get('https://nominatim.openstreetmap.org/search', [
                                        'q' => $query,
                                        'format' => 'json',
                                        'limit' => 1,
                                    ]);

                                    if ($response->successful() && ! empty($response->json())) {
                                        $data = $response->json()[0];
                                        $lat = $data['lat'];
                                        $lon = $data['lon'];

                                        $set('latitude', $lat);
                                        $set('longitude', $lon);

                                        $set('maps', [
                                            'lat' => (float) $lat,
                                            'lng' => (float) $lon,
                                            'latitude' => (float) $lat, // Adding these just in case the component expects full names
                                            'longitude' => (float) $lon,
                                        ]);

                                        $livewire->dispatch('refreshMap');
                                    }
                                } catch (\Exception $e) {
                                    //
                                }
                            })

                            ->extraAttributes([
                                'style' => 'z-index: 5000 !important;',
                            ])
                            ->columnSpanFull(),

                        TextInput::make('latitude')
                            ->numeric()
                            ->inputMode('decimal'),

                        TextInput::make('longitude')
                            ->numeric()
                            ->inputMode('decimal'),
                        TextInput::make('address')
                            ->columnSpanFull()
                            ->required()
                            ->readOnly(),

                        Map::make('maps')
                            ->label('Maps')
                            ->columnSpanFull()
                            // Basic Configuration
                            ->defaultLocation(latitude: 47.3744489, longitude: 8.5410422)
                            ->draggable(true)
                            ->clickable(true)
                            ->zoom(18)
                            ->minZoom(5)
                            ->maxZoom(28)
                            ->tilesUrl('https://tile.openstreetmap.de/{z}/{x}/{y}.png')
                            ->detectRetina(true)

                            // Marker Configuration
                            ->showMarker(true)
                            ->markerColor('#3b82f6')
                            ->markerIconSize([36, 36])
                            ->markerIconAnchor([18, 36])

                            // Controls
                            ->showFullscreenControl(true)
                            ->showZoomControl(true)

                            // Location Features
                            // ->liveLocation(true, true, 5000)
                            ->showMyLocationButton(true)
                            // ->boundaries(true, 49.5, -11, 61, 2)
                            ->rangeSelectField('distance')
                            ->rotateMode(true)
                            ->setColor('#3388ff')
                            ->setFilledColor('#cad9ec')
                            ->snappable(true, 20)

                            // Extra Customization
                            ->extraStyles([
                                'min-height: 60vh',
                            ])
                            ->extraControl(['customControl' => true])
                            ->extraTileControl(['customTileOption' => 'value'])

                            ->afterStateUpdated(function ($set, ?array $state): void {

                                $set('latitude', $state['lat']);
                                $set('longitude', $state['lng']);

                                try {
                                    $response = Http::withHeaders([
                                        'User-Agent' => 'Casafina.ch/1.0',
                                    ])->get('https://nominatim.openstreetmap.org/reverse', [
                                        'lat' => $state['lat'],
                                        'lon' => $state['lng'],
                                        'format' => 'json',
                                    ]);

                                    // dd($response->json());

                                    if ($response->successful() && ! empty($response->json())) {
                                        $data = $response->json();
                                        $set('address', $data['display_name']);

                                        // $livewire->dispatch('refreshMap');
                                    }
                                } catch (\Exception $e) {
                                    //
                                }
                            })
                            ->afterStateHydrated(function ($state, $record, $set): void {
                                $set('location', [
                                    'lat' => $record?->latitude,
                                    'lng' => $record?->longitude,
                                    // 'geojson' => json_decode(strip_tags($record->description))
                                ]);
                            }),

                    ])
                    ->columnSpanFull(),

                Section::make('Property Details')
                    ->description('Specific features and measurements')
                    ->icon('heroicon-o-information-circle')
                    ->columns(2)
                    ->schema([

                        TextInput::make('rooms')
                            ->numeric()
                            ->step(0.5),

                        Select::make('condition')
                            ->options(Condition::class),

                        TextInput::make('property_type')
                            ->placeholder('e.g. Duplex, Penthouse'),

                        Select::make('availability')
                            ->options(Availability::class),

                        TextInput::make('floor')
                            ->numeric(),

                        TextInput::make('living_area')
                            ->label('Living Area (m²)')
                            ->numeric(),

                        TextInput::make('plot_size')
                            ->numeric(),

                        TextInput::make('construction_year')
                            ->numeric(),

                        TextInput::make('last_renovation')
                            ->numeric(),

                        TextInput::make('immocode'),
                        TextInput::make('property_number'),

                        FileUpload::make('document')
                            ->disk('s3')
                            ->visibility('public')
                            ->label('Brochure / PDF')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('property-documents')
                            ->moveFiles()
                            ->deletable()
                            ->storeFileNamesIn('document_name')
                            ->columnSpanFull(),
                    ])->columnSpanFull(),

                Section::make('Characteristics')
                    ->description('Features and amenities')
                    ->icon('heroicon-o-check-circle')
                    ->schema([
                        CheckboxList::make('characteristics')
                            ->relationship('characteristics', 'name')
                            ->columns(3)
                            ->searchable()
                            ->bulkToggleable(),
                    ])->columnSpanFull(),

                Section::make('Property Images')
                    ->description('Upload images of the property')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        Repeater::make('images')
                            ->relationship()
                            ->schema([
                                FileUpload::make('path')
                                    ->label('Image')
                                    ->image()
                                    ->directory('properties')
                                    ->required()
                                    ->columnSpanFull()
                                    ->afterStateHydrated(function ($component, $state) {
                                        // Skip validation untuk URL eksternal
                                        if (is_string($state) && filter_var($state, FILTER_VALIDATE_URL)) {
                                            $component->state(null);
                                        }
                                    }),
                            ])
                            ->grid(3)
                            ->defaultItems(3)
                            ->reorderableWithDragAndDrop()
                            ->reorderable(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
