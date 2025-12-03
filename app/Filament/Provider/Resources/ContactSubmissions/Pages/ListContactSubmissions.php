<?php

namespace App\Filament\Provider\Resources\ContactSubmissions\Pages;

use App\Filament\Provider\Resources\ContactSubmissions\ContactSubmissionsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContactSubmissions extends ListRecords
{
    protected static string $resource = ContactSubmissionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
