<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Image Gallery -->
    <div class="bg-gray-900 h-[400px] md:h-[500px] relative">
        @if($property->thumbnail)
            @if(str_starts_with($property->thumbnail->path, 'http'))
                <img src="{{ $property->thumbnail->path }}" alt="{{ $property->title }}"
                    class="w-full h-full object-cover opacity-80"
                    onerror="this.onerror=null;this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%221200%22 height=%22600%22%3E%3Crect width=%22100%25%22 height=%22100%25%22 fill=%22%23e5e7eb%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-size=%2248%22 fill=%22%239ca3af%22%3ENo Image%3C/text%3E%3C/svg%3E';">
            @else
                <img src="{{ \Storage::disk('s3')->url($property->thumbnail->path) }}" alt="{{ $property->title }}"
                    class="w-full h-full object-cover opacity-80"
                    onerror="this.onerror=null;this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%221200%22 height=%22600%22%3E%3Crect width=%22100%25%22 height=%22100%25%22 fill=%22%23e5e7eb%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-size=%2248%22 fill=%22%239ca3af%22%3ENo Image%3C/text%3E%3C/svg%3E';">
            @endif
        @else
            <img src="data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%221200%22 height=%22600%22%3E%3Crect width=%22100%25%22 height=%22100%25%22 fill=%22%23e5e7eb%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-size=%2248%22 fill=%22%239ca3af%22%3ENo Image%3C/text%3E%3C/svg%3E" alt="{{ $property->title }}"
                class="w-full h-full object-cover opacity-80">
        @endif

        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>

        <div class="absolute bottom-0 left-0 w-full p-6 md:p-12">
            <div class="container mx-auto">
                <div class="flex flex-col md:flex-row justify-between items-end gap-6">
                    <div>
                        <span
                            class="inline-block px-3 py-1 bg-amber-500 text-white text-sm font-bold rounded-full mb-4">
                            {{ $property->listing_type->getLabel() }}
                        </span>
                        <h1 class="text-3xl md:text-5xl font-bold text-white mb-2">{{ $property->title }}</h1>
                        <div class="flex items-center gap-2 text-gray-300 text-lg">
                            <x-heroicon-o-map-pin class="w-5 h-5" />
                            {{ $property->address }}, {{ $property->location->city }}
                        </div>
                    </div>
                    <div class="text-white">
                        <div class="text-3xl md:text-4xl font-bold">CHF
                            {{ number_format($property->price, 0, '.', "'") }}</div>
                        @if($property->listing_type->value === 'rent')
                            <div class="text-gray-400 text-sm text-right">/ month</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 -mt-10 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Key Stats -->
                <div class="bg-white rounded-2xl shadow-sm p-8 grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="text-gray-500 text-sm mb-1">Living Space</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $property->living_area }} m²</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="text-gray-500 text-sm mb-1">Rooms</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $property->rooms }}</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="text-gray-500 text-sm mb-1">Floor</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $property->floor ?? '-' }}</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="text-gray-500 text-sm mb-1">Available</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $property->availability->getLabel() }}</div>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-2xl shadow-sm p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Description</h2>
                    <div class="prose max-w-none text-gray-600">
                        {!! nl2br(e($property->description)) !!}
                    </div>
                </div>

                <!-- Property Details -->
                <div class="bg-white rounded-2xl shadow-sm p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Property Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($property->category)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Category</span>
                                <span class="text-gray-900 font-semibold">{{ $property->category->name }}</span>
                            </div>
                        @endif
                        
                        @if($property->property_type)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Property Type</span>
                                <span class="text-gray-900 font-semibold">{{ $property->property_type }}</span>
                            </div>
                        @endif

                        @if($property->condition)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Condition</span>
                                <span class="text-gray-900 font-semibold">{{ $property->condition->getLabel() }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Availability</span>
                            <span class="text-gray-900 font-semibold">{{ $property->availability->getLabel() }}</span>
                        </div>

                        @if($property->living_area)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Living Area</span>
                                <span class="text-gray-900 font-semibold">{{ number_format($property->living_area, 0) }} m²</span>
                            </div>
                        @endif

                        @if($property->plot_size)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Plot Size</span>
                                <span class="text-gray-900 font-semibold">{{ number_format($property->plot_size, 0) }} m²</span>
                            </div>
                        @endif

                        @if($property->cubic_area)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Cubic Area</span>
                                <span class="text-gray-900 font-semibold">{{ number_format($property->cubic_area, 0) }} m³</span>
                            </div>
                        @endif

                        @if($property->rooms)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Number of Rooms</span>
                                <span class="text-gray-900 font-semibold">{{ $property->rooms }}</span>
                            </div>
                        @endif

                        @if($property->floor)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Floor</span>
                                <span class="text-gray-900 font-semibold">{{ $property->floor }}</span>
                            </div>
                        @endif

                        @if($property->construction_year)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Construction Year</span>
                                <span class="text-gray-900 font-semibold">{{ $property->construction_year }}</span>
                            </div>
                        @endif

                        @if($property->last_renovation)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Last Renovation</span>
                                <span class="text-gray-900 font-semibold">{{ $property->last_renovation }}</span>
                            </div>
                        @endif

                        @if($property->immocode)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">ImmoCode</span>
                                <span class="text-gray-900 font-semibold">{{ $property->immocode }}</span>
                            </div>
                        @endif

                        @if($property->property_number)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Property Number</span>
                                <span class="text-gray-900 font-semibold">{{ $property->property_number }}</span>
                            </div>
                        @endif

                        @if($property->location)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Location</span>
                                <span class="text-gray-900 font-semibold">{{ $property->location->city }}, {{ $property->location->region }}</span>
                            </div>
                        @endif

                        @if($property->location && $property->location->postal_code)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Postal Code</span>
                                <span class="text-gray-900 font-semibold">{{ $property->location->postal_code }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Characteristics -->
                @if($property->characteristics->count() > 0)
                    <div class="bg-white rounded-2xl shadow-sm p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Features & Amenities</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($property->characteristics as $characteristic)
                                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                    <div class="w-2 h-2 bg-amber-500 rounded-full"></div>
                                    <span class="text-gray-700 font-medium">{{ $characteristic->name }}</span>
                                    @if($characteristic->pivot->value)
                                        <span class="text-gray-500 text-sm ml-auto">{{ $characteristic->pivot->value }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Location Map -->
                @if($property->latitude && $property->longitude)
                    <div class="bg-white rounded-2xl shadow-sm p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Location</h2>
                        <div
                            id="map"
                            class="w-full h-[400px] rounded-xl z-0"
                            data-lat="{{ $property->latitude }}"
                            data-lng="{{ $property->longitude }}"
                            data-title="{{ $property->title }}"
                        ></div>
                    </div>
                @endif

                <!-- Gallery Grid -->
                @if($property->images->count() > 0)
                    <div class="bg-white rounded-2xl shadow-sm p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Gallery</h2>
                        <x-image-gallery-modal :images="$property->images->map(fn($image) => str_starts_with($image->path, 'http') ? $image->path : \Storage::disk('s3')->url($image->path))->toArray()" />
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Contact Form -->
                <div class="bg-white rounded-2xl shadow-lg p-8 sticky top-24 border border-gray-100">
                    <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                        <div class="w-16 h-16 bg-gray-200 rounded-full overflow-hidden">
                            @if($property->user->avatar_url)
                                <img src="{{ $property->user->avatar_url }}" alt="{{ $property->user->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center bg-amber-100 text-amber-600 font-bold text-xl">
                                    {{ substr($property->user->company_name ?? $property->user->name, 0, 2) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Contact Agent</div>
                            {{-- <a href="{{ route('agents.show', $property->user->slug) }}" wire:navigate class="font-bold text-gray-900 text-lg hover:text-amber-600 transition">
                                {{ $property->user->company_name ?? $property->user->name }}
                            </a> --}}
                            <x-filament::link class="text-lg" size="xl" weight="semibold" icon="heroicon-m-arrow-top-right-on-square" icon-position="after" :href="route('agents.show', $property->user->slug)" wire:navigate>
                               {{ $property->user->company_name ?? $property->user->name }}
                            </x-filament::link>
                            
                            @if($property->user->company_name && $property->user->name)
                                <div class="text-gray-500 font-medium text-sm">{{ $property->user->name }}</div>
                            @endif
                        </div>
                    </div>

                    @if (session()->has('message'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6"
                            role="alert">
                            <span class="block sm:inline">{{ session('message') }}</span>
                        </div>
                    @else
                        <form wire:submit="submitContact">
                            {{ $this->form }}

                            <button type="submit"
                                class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-4 rounded-lg transition shadow-lg shadow-amber-500/30 flex items-center justify-center gap-2 mt-4">
                                <x-heroicon-o-paper-airplane class="w-5 h-5" />
                                Send Message
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>