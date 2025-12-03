<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BlogPostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Blog Post Details')
                    ->description('Information about this blog post')
                    ->icon('heroicon-o-document-text')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('title')
                            ->weight('bold'),

                        TextEntry::make('slug')
                            ->copyable()
                            ->icon('heroicon-o-link'),

                        TextEntry::make('user.name')
                            ->label('Author')
                            ->icon('heroicon-o-user')
                            ->badge()
                            ->color('info'),

                        TextEntry::make('published_at')
                            ->label('Published')
                            ->dateTime()
                            ->icon('heroicon-o-calendar')
                            ->badge()
                            ->color(fn ($state) => $state ? 'success' : 'gray')
                            ->formatStateUsing(fn ($state) => $state ? $state->format('M d, Y H:i') : 'Draft')
                            ->placeholder('Not published'),

                        TextEntry::make('created_at')
                            ->dateTime()
                            ->icon('heroicon-o-calendar'),

                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->icon('heroicon-o-calendar')
                            ->since(),

                        TextEntry::make('deleted_at')
                            ->dateTime()
                            ->icon('heroicon-o-trash')
                            ->color('danger')
                            ->visible(fn ($record) => $record->trashed())
                            ->placeholder('Not deleted'),

                        ImageEntry::make('image')
                            ->label('Featured Image')
                            // ->height(420)
                            ->columnSpanFull()
                            ->placeholder('No image')
                            ->square()
                            ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name='.urlencode($record->image ?? $record->title).'&color=7F9CF5&background=EBF4FF&size=300'),

                    ]),

                Section::make('Content')
                    ->description('Blog post content')
                    ->icon('heroicon-o-document')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('content')
                            ->hiddenLabel()
                            ->markdown()
                            ->columnSpanFull()
                            ->prose(),
                    ])
                    ->collapsible(),

                // Section::make('Metadata')
                //     ->description('Post metadata')
                //     ->icon('heroicon-o-information-circle')
                //     ->columns(2)
                //     ->schema([
                //         TextEntry::make('created_at')
                //             ->dateTime()
                //             ->icon('heroicon-o-calendar'),

                //         TextEntry::make('updated_at')
                //             ->dateTime()
                //             ->icon('heroicon-o-calendar')
                //             ->since(),

                //         TextEntry::make('deleted_at')
                //             ->dateTime()
                //             ->icon('heroicon-o-trash')
                //             ->color('danger')
                //             ->visible(fn($record) => $record->trashed())
                //             ->placeholder('Not deleted'),
                //     ])
                //     ->collapsible()
                //     ->collapsed(),
            ]);
    }
}
