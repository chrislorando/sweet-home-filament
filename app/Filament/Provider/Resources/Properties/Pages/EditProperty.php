<?php

namespace App\Filament\Provider\Resources\Properties\Pages;

use App\Enums\PropertyStatus;
use App\Filament\Provider\Resources\Properties\PropertyResource;
use App\Models\Property;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProperty extends EditRecord
{
    protected static string $resource = PropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()->url(fn (Property $record): string => PropertyResource::getUrl('view', ['record' => $record->slug])),
            DeleteAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        return [];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record->slug]);
    }

    protected function afterSave(): void
    {
        $this->record->update([
            'status' => PropertyStatus::Draft,
            'approved_at' => null,
            'approved_by' => null,
            'rejected_at' => null,
            'rejected_by' => null,
            'rejected_notes' => null,
        ]);
    }
}
