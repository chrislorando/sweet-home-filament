<?php

namespace App\Filament\Provider\Resources\ContactSubmissions\Pages;

use App\Filament\Provider\Resources\ContactSubmissions\ContactSubmissionsResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewContactSubmissions extends ViewRecord
{
    protected static string $resource = ContactSubmissionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // EditAction::make(),
        ];
    }
}
