<?php

namespace App\Filament\Provider\Resources\Properties\Tables;

use App\Filament\Provider\Resources\Properties\PropertyResource;
use App\Models\Property;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PropertiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    ImageColumn::make('thumbnail.path')
                        ->height(136)
                        ->label('Thumbnail')
                        ->square()
                        ->grow(false),

                    Stack::make([
                        TextColumn::make('title')
                            ->weight(FontWeight::Bold)
                            // ->description(fn($record) => $record->slug)
                            ->searchable(),
                        TextColumn::make('category.name')
                            ->icon(Heroicon::Tag)
                            ->label('Category')
                            ->searchable(),
                        TextColumn::make('location.city')
                            ->icon(Heroicon::Map)
                            ->label('Location')
                            ->searchable()
                            // ->description(fn ($record) => $record->address),

                    ]),

                    TextColumn::make('price')
                        ->description('Price', position: 'above')
                        ->money('CHF')
                        ->color('success')
                        ->sortable()
                        ->alignEnd()
                        ->size('md'),
                    TextColumn::make('status')
                        ->description('Status', position: 'above')
                        ->label('Status')
                        ->badge()
                        ->sortable()
                        ->alignEnd()
                        ->size('md'),

                ]),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()->button()->label('View')->url(fn (Property $record): string => PropertyResource::getUrl('view', ['record' => $record->slug])),
                EditAction::make()->button()->color('gray')->label('Edit')->url(fn (Property $record): string => PropertyResource::getUrl('edit', ['record' => $record->slug])),
            ])
            ->toolbarActions([

            ]);
    }
}
