<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    ImageColumn::make('avatar')
                        ->square()
                        ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name='.urlencode($record->company_name ?? $record->name).'&color=7F9CF5&background=EBF4FF&size=300')
                        ->grow(false),
                    Stack::make([
                        TextColumn::make('name')
                            ->searchable()
                            ->sortable()
                            ->grow(false),
                        TextColumn::make('company_name')
                            ->weight(FontWeight::Bold)
                            ->searchable()
                            ->sortable()
                            ->grow(false),

                    ])
                        ->alignment(Alignment::Start),

                    Stack::make([
                        TextColumn::make('phone')->icon(Heroicon::Phone)->grow(false),
                        TextColumn::make('email')->icon(Heroicon::Envelope)->grow(false),
                        TextColumn::make('website')->icon(Heroicon::GlobeAlt)->grow(false),
                    ])->alignment(Alignment::Start),
                    TextColumn::make('role')
                        ->badge()
                        ->sortable(),
                ]),

            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
