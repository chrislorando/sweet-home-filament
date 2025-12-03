<?php

namespace App\Livewire;

use App\Enums\PropertyStatus;
use App\Models\Category;
use App\Models\Property;
use Livewire\Component;
use Livewire\WithPagination;

class PropertyListing extends Component
{
    use WithPagination;

    public $search = '';

    public $categoryId = '';

    public $listingType = '';

    public $sortBy = 'latest';

    protected $queryString = [
        'search' => ['except' => ''],
        'categoryId' => ['except' => ''],
        'listingType' => ['except' => ''],
        'sortBy' => ['except' => 'latest'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryId()
    {
        $this->resetPage();
    }

    public function updatingListingType()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'categoryId', 'listingType', 'sortBy']);
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::orderBy('name')->get();

        $properties = Property::query()
            ->where('status', PropertyStatus::Approved)
            ->with(['location', 'category', 'thumbnail'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%'.$this->search.'%')
                        ->orWhere('address', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%')
                        ->orWhereHas('location', function ($locationQuery) {
                            $locationQuery->where('city', 'like', '%'.$this->search.'%')
                                ->orWhere('region', 'like', '%'.$this->search.'%')
                                ->orWhere('postal_code', 'like', '%'.$this->search.'%');
                        });
                });
            })
            ->when($this->categoryId, function ($query) {
                $query->where('category_id', $this->categoryId);
            })
            ->when($this->listingType, function ($query) {
                $query->where('listing_type', $this->listingType);
            })
            ->when($this->sortBy === 'price_low', function ($query) {
                $query->orderBy('price', 'asc');
            })
            ->when($this->sortBy === 'price_high', function ($query) {
                $query->orderBy('price', 'desc');
            })
            ->when($this->sortBy === 'latest', function ($query) {
                $query->latest();
            })
            ->when($this->sortBy === 'oldest', function ($query) {
                $query->oldest();
            })
            ->paginate(12);

        return view('livewire.property-listing', [
            'properties' => $properties,
            'categories' => $categories,
        ])->layout('layouts.app', ['title' => 'Properties - '.config('app.name', 'Sweet Home')]);
    }
}
