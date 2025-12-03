<?php

namespace App\Filament\Resources\BlogPosts\Pages;

use App\Filament\Resources\BlogPosts\BlogPostResource;
use App\Models\BlogPost;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;

class ViewBlogPost extends ViewRecord
{
    protected static string $resource = BlogPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()->button()->icon(Heroicon::Pencil)->color('info'),
            Action::make('unpublish')
                ->button()
                ->icon(Heroicon::ArrowLeftOnRectangle)
                // ->iconPosition(IconPosition::After)
                ->color('warning')
                ->requiresConfirmation()
                ->action(function (BlogPost $record) {
                    $record->update([
                        'published_at' => null,
                    ]);
                })
                ->visible(fn ($record) => $record->published_at !== null),
            Action::make('publish')
                ->button()
                ->icon(Heroicon::PaperAirplane)
                ->iconPosition(IconPosition::After)
                ->color('success')
                ->requiresConfirmation()
                ->action(function (BlogPost $record) {
                    $record->update([
                        'published_at' => now(),
                    ]);
                })
                ->visible(fn ($record) => $record->published_at === null),

        ];
    }
}
