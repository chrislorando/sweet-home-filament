<?php

namespace App\Filament\Resources\Properties\Pages;

use App\Enums\PropertyStatus;
use App\Filament\Resources\Properties\PropertyResource;
use App\Models\Property;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListProperties extends ListRecords
{
    protected static string $resource = PropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [];

        foreach (PropertyStatus::cases() as $status) {
            // Skip Draft status in admin panel
            // if ($status === PropertyStatus::Draft) {
            //     continue;
            // }

            $tabs[str($status->value)->slug()->toString()] = Tab::make($status->getLabel())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', $status))
                ->badge(fn () => Property::where('status', $status)->count())
                ->badgeColor($status->getColor());
        }

        return $tabs;
    }
}
