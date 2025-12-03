<?php

namespace App\Filament\Provider\Resources\Properties;

use App\Filament\Provider\Resources\Properties\Pages\CreateProperty;
use App\Filament\Provider\Resources\Properties\Pages\EditProperty;
use App\Filament\Provider\Resources\Properties\Pages\ListProperties;
use App\Filament\Provider\Resources\Properties\Pages\ViewProperty;
use App\Filament\Provider\Resources\Properties\Schemas\PropertyForm;
use App\Filament\Provider\Resources\Properties\Schemas\PropertyInfolist;
use App\Filament\Provider\Resources\Properties\Tables\PropertiesTable;
use App\Models\Property;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice;

    protected static ?string $modelLabel = 'Property Listings';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $recordRouteKeyName = 'slug';

    public static function form(Schema $schema): Schema
    {
        return PropertyForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PropertyInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PropertiesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProperties::route('/'),
            'create' => CreateProperty::route('/create'),
            'view' => ViewProperty::route('/{record}'),
            'edit' => EditProperty::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }
}
