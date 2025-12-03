<?php

namespace App\Filament\Resources\Properties\Tables;

use App\Models\Property;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PropertiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->poll(30)
            ->columns([
                ImageColumn::make('thumbnail.path')
                    ->label('Thumbnail')
                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name='.urlencode($record->thumbnail->path ?? $record->title).'&color=7F9CF5&background=EBF4FF&size=300')

                    ->square(),
                TextColumn::make('user.name')
                    ->label('Listing By')
                    ->description(fn ($record) => $record->user->company_name)
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Property')
                    ->description(fn ($record) => $record->slug)
                    ->sortable()
                    ->searchable(),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('location.city')
                    ->label('Location')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('price')
                    ->money('CHF')
                    ->color('success')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()->visible(fn (Property $record) => auth()->user()->id === $record->user_id),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
