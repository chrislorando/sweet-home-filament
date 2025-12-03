<?php

namespace App\Livewire;

use App\Models\BlogPost;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Livewire\Component;

class BlogDetail extends Component implements HasSchemas
{
    use InteractsWithSchemas;

    public BlogPost $post;

    public function mount($slug)
    {
        $this->post = BlogPost::where('slug', $slug)
            ->whereNotNull('published_at')
            ->with(['user'])
            ->firstOrFail();
    }

    public function postInfolist(Schema $schema): Schema
    {
        return $schema
            ->record($this->post)
            ->components([
                Section::make()
                    ->schema([
                        TextEntry::make('content')
                            ->hiddenLabel()
                            ->markdown()
                            // ->prose()
                            ->size(TextSize::Large)
                            ->columnSpanFull()
                            ->extraAttributes(['class' => 'p-6 md:p-8']),
                    ]),
                // ->extraAttributes(['class' => 'p-6 md:p-8']),
            ]);
    }

    public function render()
    {
        return view('livewire.blog-detail')
            ->layout('layouts.app', ['title' => $this->post->title.' - '.config('app.name')]);
    }
}
