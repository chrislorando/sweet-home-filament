<?php

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Property;
use Illuminate\Support\Facades\Route;
use App\Livewire\BlogListing;

Route::get('/', function () {
    $properties = Property::where('status', \App\Enums\PropertyStatus::Approved)
        ->latest()
        ->take(4)
        ->get();

    $blogPosts = BlogPost::whereNotNull('published_at')
        ->latest('published_at')
        ->take(3)
        ->get();

    $categories = Category::orderBy('name')->get();

    return view('welcome', compact('properties', 'blogPosts', 'categories'));
});

Route::get('/properties', \App\Livewire\PropertyListing::class);
Route::get('/properties/{slug}', \App\Livewire\PropertyDetail::class)->name('properties.show');
Route::get('/agents/{slug}', \App\Livewire\PropertyAgent::class)->name('agents.show');
Route::get('/blog', BlogListing::class)->name('blog.index');
Route::get('/blog/{slug}', \App\Livewire\BlogDetail::class)->name('blog.show');
