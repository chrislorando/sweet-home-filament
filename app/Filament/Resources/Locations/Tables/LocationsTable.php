<?php

namespace App\Filament\Resources\Locations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LocationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('city')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-map-pin')
                    ->weight('medium'),

                TextColumn::make('region')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-map'),

                TextColumn::make('country')
                    ->badge()
                    ->color('success')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('postal_code')
                    ->label('Postal Code')
                    ->badge()
                    ->color('gray')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('properties_count')
                    ->counts('properties')
                    ->label('Properties')
                    ->badge()
                    ->color('info')
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
                SelectFilter::make('country')
                    ->options([
                        'Switzerland' => 'Switzerland',
                    ]),

                SelectFilter::make('region')
                    ->options(
                        fn () => \App\Models\Location::query()
                            ->distinct()
                            ->pluck('region', 'region')
                            ->toArray()
                    ),
            ])
            ->recordActions([
                // ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('city', 'asc');
    }
}
