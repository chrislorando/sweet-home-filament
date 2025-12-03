<?php

namespace App\Filament\Provider\Resources\Properties\Pages;

use App\Filament\Provider\Resources\Properties\PropertyResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProperty extends CreateRecord
{
    protected static string $resource = PropertyResource::class;

    public function getTitle(): string
    {
        return 'Place listing';
    }

    protected function getFormActions(): array
    {
        return [];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record->slug]);
    }

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     // dd($data);
    //     // $recipients = User::where('role', 'freelancer')->get();
    //     // Notification::make()
    //     //     ->title("New job:{$data->title}")
    //     //     ->success()
    //     //     ->actions([
    //     //         Action::make('view')
    //     //             ->button()
    //     //             ->url(ProjectResource::getUrl(name: 'view', panel: 'freelancer', parameters: ['record' => $data->slug]))
    //     //             ->markAsRead(),
    //     //     ])
    //     //     ->sendToDatabase($recipients);
    // }
}
