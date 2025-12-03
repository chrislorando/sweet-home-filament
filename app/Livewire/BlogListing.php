<?php

namespace App\Livewire;

use App\Models\BlogPost;
use Livewire\Component;
use Livewire\WithPagination;

class BlogListing extends Component
{
    use WithPagination;

    public string $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $posts = BlogPost::query()
            ->whereNotNull('published_at')
            ->when($this->search, function ($query) {
                $query->where(function ($sub) {
                    $sub->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('content', 'like', '%' . $this->search . '%');
                });
            })
            ->latest('published_at')
            ->with(['user'])
            ->paginate(9);

        return view('livewire.blog-listing', [
            'posts' => $posts,
        ])->layout('layouts.app', [
            'title' => 'Blog - ' . config('app.name'),
        ]);
    }
}
