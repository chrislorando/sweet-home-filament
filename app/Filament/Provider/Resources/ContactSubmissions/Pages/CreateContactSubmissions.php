<?php

namespace App\Filament\Provider\Resources\ContactSubmissions\Pages;

use App\Filament\Provider\Resources\ContactSubmissions\ContactSubmissionsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContactSubmissions extends CreateRecord
{
    protected static string $resource = ContactSubmissionsResource::class;
}
