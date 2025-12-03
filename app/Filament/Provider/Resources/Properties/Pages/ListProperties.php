<?php

namespace App\Filament\Provider\Resources\Properties\Pages;

use App\Enums\PropertyStatus;
use App\Filament\Provider\Resources\Properties\PropertyResource;
use App\Models\Property;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;

class ListProperties extends ListRecords
{
    protected static string $resource = PropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Advertise')->icon(Heroicon::BuildingStorefront),
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
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', $status)->where('user_id', auth()->id()))
                ->badge(fn () => Property::where('status', $status)->where('user_id', auth()->id())->count())
                ->badgeColor($status->getColor());
        }

        return $tabs;
    }
}
