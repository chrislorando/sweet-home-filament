<?php

namespace App\Filament\Resources\Properties\Pages;

use App\Enums\PropertyStatus;
use App\Filament\Resources\Properties\PropertyResource;
use App\Models\Property;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewProperty extends ViewRecord
{
    protected static string $resource = PropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()->visible(fn (Property $record) => auth()->user()->id === $record->user_id),
            Action::make('approve')
                ->label('Approve')
                ->color('info')
                ->icon('heroicon-o-check-circle')
                ->requiresConfirmation()
                ->modalHeading('Approve Property Listing')
                ->modalDescription('Are you sure you want to approve this property listing?')
                ->action(function (Property $record) {
                    $record->approve();

                    Notification::make()
                        ->title("{$record->user->company_name} approved property listing:{$record->title}")
                        ->success()
                        ->actions([
                            Action::make('view')
                                ->button()
                                ->url(\App\Filament\Provider\Resources\Properties\PropertyResource::getUrl(name: 'view', panel: 'provider', parameters: ['record' => $record->slug]))
                                ->markAsRead(),
                        ])
                        ->sendToDatabase(User::find($record->user_id));
                })
                ->visible(fn (Property $record) => $record->status === PropertyStatus::Pending)
                ->after(function () {
                    $this->record->refresh();
                }),
            Action::make('reject')
                ->label('Reject')
                ->color('danger')
                ->icon('heroicon-o-x-circle')
                ->requiresConfirmation()
                ->modalHeading('Reject Property Listing')
                ->modalDescription('Are you sure you want to reject this property listing?')
                ->schema([
                    TextInput::make('rejection_notes')
                        ->label('Rejection Notes')
                        ->required(),
                ])
                ->action(function (Property $record, array $data) {
                    $record->reject($data['rejection_notes']);

                    Notification::make()
                        ->title("Rejected property listing:{$record->title}")
                        ->success()
                        ->actions([
                            Action::make('view')
                                ->button()
                                ->url(\App\Filament\Provider\Resources\Properties\PropertyResource::getUrl(name: 'view', panel: 'provider', parameters: ['record' => $record->slug]))
                                ->markAsRead(),
                        ])
                        ->sendToDatabase(User::find($record->user_id));
                })
                ->visible(fn (Property $record) => $record->status === PropertyStatus::Pending)
                ->after(function () {
                    $this->record->refresh();
                }),
        ];
    }
}
