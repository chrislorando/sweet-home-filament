<?php

namespace App\Filament\Provider\Resources\Properties\Schemas;

use App\Enums\Availability;
use App\Enums\Condition;
use App\Enums\ListingType;
use App\Models\Location;
use Blade;
use Dotswan\MapPicker\Fields\Map;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class PropertyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Property')
                        ->description('Enter the basic details about your property')
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
                                ->hidden()
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true)
                                ->dehydrated()
                                ->columnSpanFull(),

                            Select::make('category_id')
                                ->relationship('category', 'name')
                                ->required()
                                ->preload(),

                            Select::make('listing_type')
                                ->options(ListingType::class)
                                ->required(),

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
                                                'latitude' => (float) $lat,
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
                                ->defaultLocation(latitude: 47.3744489, longitude: 8.5410422)
                                ->draggable(true)
                                ->clickable(true)
                                ->zoom(18)
                                ->minZoom(5)
                                ->maxZoom(28)
                                ->tilesUrl('https://tile.openstreetmap.de/{z}/{x}/{y}.png')
                                ->detectRetina(true)
                                ->showMarker(true)
                                ->markerColor('#3b82f6')
                                ->markerIconSize([36, 36])
                                ->markerIconAnchor([18, 36])
                                ->showFullscreenControl(true)
                                ->showZoomControl(true)
                                ->showMyLocationButton(true)
                                ->rangeSelectField('distance')
                                ->rotateMode(true)
                                ->setColor('#3388ff')
                                ->setFilledColor('#cad9ec')
                                ->snappable(true, 20)
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

                                        if ($response->successful() && ! empty($response->json())) {
                                            $data = $response->json();
                                            $set('address', $data['display_name']);
                                        }
                                    } catch (\Exception $e) {
                                        //
                                    }
                                })
                                ->afterStateHydrated(function ($state, $record, $set): void {
                                    $set('location', [
                                        'lat' => $record?->latitude,
                                        'lng' => $record?->longitude,
                                    ]);
                                }),
                        ]),

                    Step::make('Details')
                        ->description('Add specific features and measurements')
                        ->icon('heroicon-o-information-circle')
                        // ->columns(2)
                        ->schema([
                            Fieldset::make('Price and availability')->schema([
                                TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('CHF')
                                    ->maxValue(999999999),

                                Select::make('availability')
                                    ->options(Availability::class),
                            ]),

                            Fieldset::make('At a glance')->schema([
                                TextInput::make('rooms')
                                    ->numeric()
                                    ->step(0.5),
                                Select::make('condition')
                                    ->options(Condition::class),

                                TextInput::make('property_type')
                                    ->placeholder('e.g. Duplex, Penthouse'),

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
                            ]),

                            MarkdownEditor::make('description')
                                ->required()
                                ->extraAttributes([
                                    'class' => 'h-64',
                                ])
                                ->columnSpanFull(),

                            CheckboxList::make('characteristics')
                                ->label('Characteristics')
                                ->relationship('characteristics', 'name')
                                ->columns(3)
                                ->searchable()
                                ->bulkToggleable()
                                ->columnSpanFull(),

                        ]),

                    Step::make('Media')
                        ->description('Upload photos and documentsof your property')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            Repeater::make('images')
                                ->relationship(
                                    modifyQueryUsing: fn ($query) => 
                                        $query->where('path', 'NOT LIKE', '%picsum.photos%')
                                            ->orWhereNull('path')
                                )
                                ->schema([
                                    FileUpload::make('path')
                                        ->label('Image')
                                        ->image()
                                        ->directory('properties')
                                        ->moveFiles()
                                        ->deletable()
                                        ->required()
                                        ->columnSpanFull(),
                                ])
                                ->grid(3)
                                ->defaultItems(3)
                                ->reorderableWithDragAndDrop()
                                ->reorderable(),

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
                        ]),
                ])
                    ->columnSpanFull()
                    // ->skippable()
                    ->persistStepInQueryString()
                    ->submitAction(new HtmlString(Blade::render(<<<'BLADE'
                            <x-filament::button
                                type="submit"
                                size="sm"
                            >
                                Submit
                            </x-filament::button>
                        BLADE))),
            ]);
    }
}
