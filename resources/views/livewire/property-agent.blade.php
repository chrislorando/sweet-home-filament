<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Agent Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-6 py-12">
            <div class="flex flex-col md:flex-row items-start gap-8">
                <!-- Avatar -->
                <div
                    class="w-32 h-32 md:w-40 md:h-40 bg-gray-200 rounded-full overflow-hidden border-4 border-white shadow-lg flex-shrink-0">
                    @if($agent->avatar_url)
                        <img src="{{ $agent->avatar_url }}" alt="{{ $agent->name }}" class="w-full h-full object-cover">
                    @else
                        <div
                            class="w-full h-full flex items-center justify-center bg-amber-100 text-amber-600 font-bold text-4xl">
                            {{ substr($agent->company_name ?? $agent->name, 0, 2) }}
                        </div>
                    @endif
                </div>

                <!-- Info -->
                <div class="flex-1 w-full">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                        <div class="w-full">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                                {{ $agent->company_name ?? $agent->name }}
                            </h1>
                            @if($agent->company_name && $agent->name)
                                <div class="text-xl text-gray-500 font-medium mb-4">
                                    Represented by {{ $agent->name }}
                                </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-2 gap-x-8 text-gray-600 mt-4">
                                @if($agent->address)
                                    <div class="flex items-start gap-2">
                                        <x-heroicon-o-map-pin class="w-5 h-5 mt-0.5 flex-shrink-0 text-amber-500" />
                                        <span>{{ $agent->address }}</span>
                                    </div>
                                @endif

                                @if($agent->email)
                                    <a href="mailto:{{ $agent->email }}"
                                        class="flex items-center gap-2 hover:text-amber-600 transition">
                                        <x-heroicon-o-envelope class="w-5 h-5 flex-shrink-0 text-amber-500" />
                                        {{ $agent->email }}
                                    </a>
                                @endif

                                @if($agent->phone)
                                    <a href="tel:{{ $agent->phone }}"
                                        class="flex items-center gap-2 hover:text-amber-600 transition">
                                        <x-heroicon-o-phone class="w-5 h-5 flex-shrink-0 text-amber-500" />
                                        {{ $agent->phone }}
                                    </a>
                                @endif

                                @if($agent->website)
                                    <a href="{{ $agent->website }}" target="_blank"
                                        class="flex items-center gap-2 hover:text-amber-600 transition">
                                        <x-heroicon-o-globe-alt class="w-5 h-5 flex-shrink-0 text-amber-500" />
                                        Website
                                    </a>
                                @endif
                            </div>

                            @if($agent->services && is_array($agent->services) && count($agent->services) > 0)
                                <div class="mt-6">
                                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-2">Services</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($agent->services as $service)
                                            <span
                                                class="px-3 py-1 bg-amber-50 text-amber-700 rounded-full text-sm font-medium border border-amber-100">
                                                {{ is_array($service) ? ($service['description'] ?? '') : $service }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($agent->description)
                        <div class="mt-6 text-gray-600 max-w-3xl border-t border-gray-100 pt-6">
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-2">About</h3>
                            <p class="leading-relaxed">{{ $agent->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Agent's Properties -->
    <div class="container mx-auto px-6 py-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Properties by {{ $agent->company_name ?? $agent->name }}</h2>

        @if($properties->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
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

            <div class="mt-12">
                {{ $properties->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-2xl shadow-sm">
                <x-heroicon-o-home class="w-16 h-16 text-gray-300 mx-auto mb-4" />
                <h3 class="text-lg font-medium text-gray-900">No properties found</h3>
                <p class="text-gray-500">This agent hasn't listed any properties yet.</p>
            </div>
        @endif
    </div>
</div>