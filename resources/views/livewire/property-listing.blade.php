<div class="min-h-screen bg-gray-50">
    <!-- Search & Filter Section -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-40 shadow-sm">
        <div class="container mx-auto px-6 py-6">
            <!-- Search Bar -->
            <div class="mb-6">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <x-heroicon-o-magnifying-glass class="h-6 w-6 text-gray-400" />
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="Search by city, region, postal code, or property name..."
                        class="w-full pl-12 pr-4 py-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-transparent text-gray-800 placeholder-gray-500">
                </div>
            </div>

            <!-- Filters Row -->
            <div class="flex flex-wrap gap-4 items-center">
                <!-- Category Filter -->
                <div class="flex-1 min-w-[200px]">
                    <select wire:model.live="categoryId"
                        class="w-full py-3 pl-4 pr-10 border border-gray-300 bg-white rounded-xl text-gray-700 font-medium focus:ring-2 focus:ring-amber-500 focus:border-transparent cursor-pointer">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Listing Type Filter -->
                <div class="flex-1 min-w-[200px]">
                    <select wire:model.live="listingType"
                        class="w-full py-3 pl-4 pr-10 border border-gray-300 bg-white rounded-xl text-gray-700 font-medium focus:ring-2 focus:ring-amber-500 focus:border-transparent cursor-pointer">
                        <option value="">All Types</option>
                        @foreach(\App\Enums\ListingType::cases() as $type)
                            <option value="{{ $type->value }}">{{ $type->getLabel() }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort By -->
                <div class="flex-1 min-w-[200px]">
                    <select wire:model.live="sortBy"
                        class="w-full py-3 pl-4 pr-10 border border-gray-300 bg-white rounded-xl text-gray-700 font-medium focus:ring-2 focus:ring-amber-500 focus:border-transparent cursor-pointer">
                        <option value="latest">Latest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                    </select>
                </div>

                <!-- Clear Filters Button -->
                @if($search || $categoryId || $listingType || $sortBy !== 'latest')
                    <button wire:click="clearFilters"
                        class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-medium transition flex items-center gap-2">
                        <x-heroicon-o-x-mark class="w-5 h-5" />
                        Clear Filters
                    </button>
                @endif
            </div>

            <!-- Active Filters Display -->
            <div class="mt-4 flex flex-wrap gap-2">
                @if($search)
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-sm font-medium">
                        Search: "{{ $search }}"
                        <button wire:click="$set('search', '')" class="hover:text-amber-900">
                            <x-heroicon-m-x-mark class="w-4 h-4" />
                        </button>
                    </span>
                @endif
                @if($categoryId)
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                        Category: {{ $categories->find($categoryId)->name }}
                        <button wire:click="$set('categoryId', '')" class="hover:text-blue-900">
                            <x-heroicon-m-x-mark class="w-4 h-4" />
                        </button>
                    </span>
                @endif
                @if($listingType)
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                        Type: {{ \App\Enums\ListingType::from($listingType)->getLabel() }}
                        <button wire:click="$set('listingType', '')" class="hover:text-green-900">
                            <x-heroicon-m-x-mark class="w-4 h-4" />
                        </button>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Results Section -->
    <div class="container mx-auto px-6 py-12">
        <!-- Results Count -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                @if($search || $categoryId || $listingType)
                    Search Results
                @else
                    All Properties
                @endif
            </h1>
            <p class="text-gray-600">
                Found {{ $properties->total() }} {{ Str::plural('property', $properties->total()) }}
            </p>
        </div>

        <!-- Properties Grid -->
        @if($properties->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-12">
                @foreach($properties as $property)
                    <a href="{{ route('properties.show', $property->slug) }}" wire:navigate
                        class="block bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 group overflow-hidden border border-gray-100">
                        <div class="relative h-64 overflow-hidden">
                            @if($property->thumbnail)
                                @if(str_starts_with($property->thumbnail->path, 'http'))
                                    <img src="{{ $property->thumbnail->path }}" alt="{{ $property->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @else
                                    <img src="{{ \Storage::disk('s3')->url($property->thumbnail->path) }}" alt="{{ $property->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @endif
                            @else
                                <img src="https://via.placeholder.com/400x300" alt="{{ $property->title }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            @endif
                            <div class="absolute top-4 left-4">
                                <span
                                    class="px-3 py-1 bg-white/90 backdrop-blur-sm text-gray-900 text-xs font-bold rounded-full uppercase tracking-wider">
                                    {{ $property->listing_type->getLabel() }}
                                </span>
                            </div>
                            <div class="absolute bottom-4 left-4">
                                <span class="px-3 py-1 bg-amber-500 text-white text-sm font-bold rounded-lg shadow-lg">
                                    CHF {{ number_format($property->price, 0, '.', "'") }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-2 text-gray-500 text-sm mb-3">
                                <x-heroicon-o-map-pin class="w-4 h-4" />
                                {{ $property->location->city ?? 'Unknown' }}
                            </div>
                            @if($property->category)
                                <div class="mb-2">
                                    <span class="inline-block px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-md font-medium">
                                        {{ $property->category->name }}
                                    </span>
                                </div>
                            @endif
                            <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-1 group-hover:text-amber-600 transition">
                                {{ $property->title }}
                            </h3>
                            <div
                                class="flex items-center justify-between text-gray-500 text-sm border-t border-gray-100 pt-4 mt-4">
                                <div class="flex items-center gap-1">
                                    <x-heroicon-o-home class="w-4 h-4" />
                                    <span>{{ $property->rooms }} rooms</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <x-heroicon-o-square-2-stack class="w-4 h-4" />
                                    <span>{{ $property->living_area }} m²</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $properties->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-6">
                    <x-heroicon-o-home-modern class="w-10 h-10 text-gray-400" />
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No properties found</h3>
                <p class="text-gray-600 mb-6">
                    We couldn't find any properties matching your search criteria.
                </p>
                <button wire:click="clearFilters"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-xl font-medium transition">
                    <x-heroicon-o-arrow-path class="w-5 h-5" />
                    Clear all filters
                </button>
            </div>
        @endif
    </div>
</div>