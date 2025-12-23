<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sweet Home') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="antialiased font-sans text-gray-900 bg-white">
    <!-- Navbar -->
    <nav class="absolute top-0 left-0 w-full z-50 bg-transparent py-6">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <a href="/" wire:navigate class="text-2xl font-bold text-white flex items-center gap-2">
                <x-heroicon-o-home-modern class="w-8 h-8 text-amber-500" />
                {{ config('app.name', 'Sweet Home') }}
            </a>
            <div class="flex items-center gap-6">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/admin') }}" wire:navigate
                            class="text-white hover:text-amber-400 font-medium transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" wire:navigate class="text-white hover:text-amber-400 font-medium transition">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" wire:navigate
                                class="bg-amber-500 hover:bg-amber-600 text-white px-5 py-2.5 rounded-full font-medium transition shadow-lg shadow-amber-500/30">Sign
                                up</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative h-[600px] flex items-center justify-center">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
                alt="Hero Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/40"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
                Find your perfect <span class="text-amber-500">home</span>
            </h1>
            <p class="text-xl text-gray-200 mb-10 max-w-2xl mx-auto">
                Discover the best properties for sale and rent in Switzerland. Your dream home is just a search away.
            </p>

            <!-- Search Bar -->
            <form action="/properties" method="GET"
                class="bg-white p-2 rounded-full shadow-2xl max-w-4xl mx-auto flex flex-col md:flex-row gap-2">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <x-heroicon-o-magnifying-glass class="h-6 w-6 text-gray-400" />
                    </div>
                    <input type="text" name="search" placeholder="City, region, or postal code"
                        class="w-full pl-12 pr-4 py-4 rounded-full border-none focus:ring-0 text-gray-800 placeholder-gray-500 text-lg">
                </div>
                <div class="flex items-center gap-2 px-2">
                    <select name="categoryId"
                        class="py-3 pl-4 pr-10 border-none bg-gray-50 rounded-full text-gray-700 font-medium focus:ring-0 cursor-pointer hover:bg-gray-100 transition">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <select name="listingType"
                        class="py-3 pl-4 pr-10 border-none bg-gray-50 rounded-full text-gray-700 font-medium focus:ring-0 cursor-pointer hover:bg-gray-100 transition">
                        <option value="">All Types</option>
                        @foreach(\App\Enums\ListingType::cases() as $type)
                            <option value="{{ $type->value }}">{{ $type->getLabel() }}</option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="bg-amber-500 hover:bg-amber-600 text-white px-8 py-3.5 rounded-full font-bold text-lg transition shadow-lg shadow-amber-500/30 flex items-center gap-2">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Latest Properties Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Latest Properties</h2>
                    <p class="text-gray-600">Freshly added listings for you</p>
                </div>
                <a href="/properties" wire:navigate class="text-amber-600 font-medium hover:text-amber-700 flex items-center gap-1">
                    View all properties <x-heroicon-m-arrow-right class="w-4 h-4" />
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($properties as $property)
                    <a href="{{ route('properties.show', $property->slug) }}" wire:navigate
                        class="block bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 group overflow-hidden border border-gray-100">
                        <div class="relative h-64 overflow-hidden">
                            @if($property->thumbnail)
                                @if(str_starts_with($property->thumbnail->path, 'http'))
                                    <img src="{{ $property->thumbnail->path }}" alt="{{ $property->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                        onerror="this.onerror=null;this.src='https://via.placeholder.com/400x300?text=Image+Unavailable';">
                                @else
                                    <img src="{{ \Storage::disk('s3')->url($property->thumbnail->path) }}"
                                        alt="{{ $property->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                        onerror="this.onerror=null;this.src='https://via.placeholder.com/400x300?text=Image+Unavailable';">
                                @endif
                            @else
                                    <img src="https://via.placeholder.com/400x300" alt="{{ $property->title }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                    onerror="this.onerror=null;this.src='https://via.placeholder.com/400x300?text=No+Image';">
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
                            <h3
                                class="text-xl font-bold text-gray-900 mb-3 line-clamp-1 group-hover:text-amber-600 transition">
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
        </div>
    </section>

    <!-- Blog Posts Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Latest News & Advice</h2>
                    <p class="text-gray-600">Insights from the real estate world</p>
                </div>
                <a href="/blog" wire:navigate class="text-amber-600 font-medium hover:text-amber-700 flex items-center gap-1">
                    Read our blog <x-heroicon-m-arrow-right class="w-4 h-4" />
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                @foreach($blogPosts as $post)
                    <a href="{{ route('blog.show', $post->slug) }}"  class="block group">
                        <article>
                            <div class="relative h-64 rounded-2xl overflow-hidden mb-6">
                                @if($post->image)
                                    <img src="{{ $post->image }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                        onerror="this.onerror=null;this.src='https://via.placeholder.com/400x300?text=Image+Unavailable';">
                                @else
                                    <img src="https://via.placeholder.com/400x300" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @endif
                                <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition"></div>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-500 mb-3">
                                <span class="text-amber-600 font-medium">News</span>
                                <span>&bull;</span>
                                <span>{{ $post->published_at->format('M d, Y') }}</span>
                            </div>
                            <h3
                                class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-amber-600 transition leading-tight">
                                {{ $post->title }}
                            </h3>
                            <p class="text-gray-600 line-clamp-2 mb-4">
                                {{ Str::limit(strip_tags($post->content), 120) }}
                            </p>
                            <span
                                class="text-amber-600 font-medium group-hover:underline decoration-2 underline-offset-4">Read
                                article</span>
                        </article>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <x-heroicon-o-home-modern class="w-8 h-8 text-amber-500" />
                        <span class="text-2xl font-bold">{{ config('app.name', 'Sweet Home') }}</span>
                    </div>
                    <p class="text-gray-400 leading-relaxed">
                        Your trusted partner in finding the perfect property in Switzerland. We make real estate simple
                        and transparent.
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-6">Quick Links</h4>
                    <ul class="space-y-4 text-gray-400">
                        <li><a href="/properties?listingType=buy" wire:navigate class="hover:text-amber-500 transition">Buy
                                Property</a></li>
                        <li><a href="/properties?listingType=rent" wire:navigate class="hover:text-amber-500 transition">Rent
                                Property</a></li>
                        <li><a href="/admin" wire:navigate class="hover:text-amber-500 transition">Sell Property</a></li>
                        <li><a href="#" class="hover:text-amber-500 transition">Our Agents</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-6">Company</h4>
                    <ul class="space-y-4 text-gray-400">
                        <li><a href="#" class="hover:text-amber-500 transition">About Us</a></li>
                        <li><a href="#" class="hover:text-amber-500 transition">Careers</a></li>
                        <li><a href="#" class="hover:text-amber-500 transition">Contact</a></li>
                        <li><a href="#" class="hover:text-amber-500 transition">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-6">Newsletter</h4>
                    <p class="text-gray-400 mb-4">Subscribe to get the latest property news.</p>
                    <div class="flex gap-2">
                        <input type="email" placeholder="Your email"
                            class="bg-gray-800 border-none rounded-lg px-4 py-2 w-full focus:ring-1 focus:ring-amber-500">
                        <button
                            class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg font-medium transition">
                            Subscribe
                        </button>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} {{ config('app.name', 'Sweet Home') }}. All rights reserved.
            </div>
        </div>
    </footer>
</body>

@livewireScripts

</html>