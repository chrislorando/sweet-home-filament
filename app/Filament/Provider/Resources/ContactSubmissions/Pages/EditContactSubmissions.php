<?php

namespace App\Filament\Provider\Resources\ContactSubmissions\Pages;

use App\Filament\Provider\Resources\ContactSubmissions\ContactSubmissionsResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditContactSubmissions extends EditRecord
{
    protected static string $resource = ContactSubmissionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
