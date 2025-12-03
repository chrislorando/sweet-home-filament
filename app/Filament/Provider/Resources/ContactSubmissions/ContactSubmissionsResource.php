<?php

namespace App\Filament\Provider\Resources\ContactSubmissions;

use App\Filament\Provider\Resources\ContactSubmissions\Pages\CreateContactSubmissions;
use App\Filament\Provider\Resources\ContactSubmissions\Pages\EditContactSubmissions;
use App\Filament\Provider\Resources\ContactSubmissions\Pages\ListContactSubmissions;
use App\Filament\Provider\Resources\ContactSubmissions\Pages\ViewContactSubmissions;
use App\Filament\Provider\Resources\ContactSubmissions\Schemas\ContactSubmissionsForm;
use App\Filament\Provider\Resources\ContactSubmissions\Schemas\ContactSubmissionsInfolist;
use App\Filament\Provider\Resources\ContactSubmissions\Tables\ContactSubmissionsTable;
use App\Models\ContactSubmission;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContactSubmissionsResource extends Resource
{
    protected static ?string $model = ContactSubmission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserCircle;

    public static function form(Schema $schema): Schema
    {
        return ContactSubmissionsForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ContactSubmissionsInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactSubmissionsTable::configure($table);
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
            'index' => ListContactSubmissions::route('/'),
            'create' => CreateContactSubmissions::route('/create'),
            'view' => ViewContactSubmissions::route('/{record}'),
            'edit' => EditContactSubmissions::route('/{record}/edit'),
        ];
    }
}
