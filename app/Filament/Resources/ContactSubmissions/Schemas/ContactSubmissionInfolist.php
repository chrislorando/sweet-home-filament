<?php

namespace App\Filament\Resources\ContactSubmissions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactSubmissionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Contact Information')
                    ->description('Details about the inquiry')
                    ->icon('heroicon-o-envelope')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('property.title')
                            ->label('Property')
                            ->icon('heroicon-o-home')
                            ->url(fn ($record) => $record->property ? route('properties.show', $record->property->slug) : null)
                            ->openUrlInNewTab()
                            ->columnSpanFull(),

                        TextEntry::make('firstname')
                            ->label('First Name')
                            ->icon('heroicon-o-user'),

                        TextEntry::make('lastname')
                            ->label('Last Name')
                            ->icon('heroicon-o-user'),

                        TextEntry::make('email')
                            ->label('Email')
                            ->icon('heroicon-o-envelope')
                            ->copyable(),

                        TextEntry::make('phone')
                            ->label('Phone')
                            ->icon('heroicon-o-phone')
                            ->copyable(),

                        TextEntry::make('address')
                            ->label('Address')
                            ->icon('heroicon-o-map-pin')
                            ->placeholder('Not provided'),

                        TextEntry::make('postcode')
                            ->label('Postcode')
                            ->icon('heroicon-o-map')
                            ->placeholder('Not provided'),

                        TextEntry::make('created_at')
                            ->label('Submitted At')
                            ->dateTime()
                            ->icon('heroicon-o-calendar')
                            ->since(),
                    ]),

                Section::make('Message')
                    ->description('The inquiry message')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('message')
                            ->hiddenLabel()
                            ->columnSpanFull()
                            ->prose(),
                    ]),
            ]);
    }
}
