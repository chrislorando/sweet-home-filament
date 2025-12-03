<?php

namespace App\Filament\Provider\Resources\Properties\Pages;

use App\Enums\PropertyStatus;
use App\Enums\UserRole;
use App\Filament\Provider\Resources\Properties\PropertyResource;
use App\Models\Property;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;

class ViewProperty extends ViewRecord
{
    protected static string $resource = PropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()->button()->icon(Heroicon::PencilSquare)->label('Edit Property')->color('gray')->url(fn (Property $record): string => PropertyResource::getUrl('edit', ['record' => $record->slug])),

            Action::make('Request Approval')
                ->icon(Heroicon::Play)
                ->iconPosition(IconPosition::After)
                ->label('Continue to publication')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Request Approval')
                ->modalDescription('Are you sure you want to request approval for this property listing?')
                ->action(function (Property $record) {
                    $record->status = PropertyStatus::Pending;
                    $record->save();

                    Notification::make()
                        ->title("{$record->user->company_name} requested for property listing:{$record->title}")
                        ->warning()
                        ->actions([
                            Action::make('view')
                                ->button()
                                ->url(\App\Filament\Resources\Properties\PropertyResource::getUrl(name: 'view', panel: 'admin', parameters: ['record' => $record]))
                                ->markAsRead(),
                        ])
                        ->sendToDatabase(User::where('role', UserRole::Admin)->first());
                })
                ->visible(fn (Property $record) => $record->status === PropertyStatus::Draft)
                ->after(function () {
                    $this->record->refresh();
                }),
        ];
    }
}
