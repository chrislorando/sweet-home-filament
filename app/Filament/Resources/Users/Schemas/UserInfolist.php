<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profile')
                    ->afterHeader(fn ($record) => $record->role?->name ?? '-')
                    // ->columns(1)
                    ->schema([
                        Grid::make()
                            ->gridContainer()
                            ->columns([
                                '@sm' => 1,
                            ])
                            ->schema([
                                ImageEntry::make('avatar')
                                    ->hiddenLabel()
                                    ->square()
                                    ->size(100)
                                    ->alignCenter()
                                    ->columnSpanFull()

                                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name='.urlencode($record->company_name).'&color=7F9CF5&background=EBF4FF&size=300'),

                                TextEntry::make('company_name')
                                    ->hiddenLabel()
                                    ->weight(\Filament\Support\Enums\FontWeight::Bold)
                                    ->size('lg')
                                    ->alignCenter()
                                    ->columnSpanFull(),

                            ]),

                        Grid::make(1)
                            ->dense()
                            ->gridContainer()
                            ->columns([
                                '@sm' => 1,
                                '@md' => 1,
                                '@lg' => 1,
                            ])
                            ->schema([
                                TextEntry::make('name')->inlineLabel(),

                                TextEntry::make('phone')
                                    ->inlineLabel()
                                    ->placeholder('No phone'),
                                TextEntry::make('email')
                                    ->inlineLabel()
                                    ->copyable(),

                                TextEntry::make('location')
                                    ->inlineLabel()
                                    ->placeholder('No location'),
                            ])->grow(false),

                        TextEntry::make('description')
                            ->columnSpanFull()
                            ->prose()
                            ->hiddenLabel()
                            ->visible(fn ($record) => filled($record->description)),
                    ])
                    ->grow(false),

                Grid::make()
                    ->gridContainer()
                    ->columns([
                        '@md' => 2,
                        '@lg' => 2,
                    ])
                    ->grow()
                    ->schema([

                        Section::make('Services')
                            ->columnSpanFull()
                            ->visible(fn ($record) => $record->role === \App\Enums\UserRole::Provider)
                            ->columns(1)
                            ->schema([
                                RepeatableEntry::make('services')
                                    ->hiddenLabel()
                                    ->contained(false)
                                    ->columns(1)
                                    ->visible(fn ($record) => ! empty($record->services))
                                    ->schema([
                                        TextEntry::make('description')
                                            ->icon(Heroicon::ChevronRight)
                                            ->hiddenLabel(),

                                    ]),
                            ]),

                        Section::make('System Information')
                            ->columnSpanFull()
                            ->schema([
                                Grid::make(2)
                                    ->schema([

                                        TextEntry::make('email_verified_at')
                                            ->label('Email Verified')
                                            ->dateTime(),
                                        TextEntry::make('created_at')
                                            ->label('Joined')
                                            ->dateTime(),
                                        TextEntry::make('updated_at')
                                            ->label('Last Updated')
                                            ->dateTime(),

                                    ]),
                            ]),

                    ]),

            ]);
    }
}
