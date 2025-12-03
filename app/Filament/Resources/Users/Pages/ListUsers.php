<?php

namespace App\Filament\Resources\Users\Pages;

use App\Enums\UserRole;
use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make('All')
                ->badge(fn () => User::count()),
        ];

        foreach (UserRole::cases() as $role) {
            $tabs[str($role->value)->slug()->toString()] = Tab::make($role->getLabel())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', $role))
                ->badge(fn () => User::where('role', $role)->count());
        }

        return $tabs;
    }
}
