<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Sweet Home'))</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    @filamentStyles
    @livewireStyles

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @filamentStyles
    @vite('resources/css/app.css')
</head>

<body class="antialiased font-sans text-gray-900 bg-white">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-200">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" wire:navigate class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <x-heroicon-o-home-modern class="w-8 h-8 text-amber-500" />
                {{ config('app.name', 'Sweet Home') }}
            </a>
            <div class="flex items-center gap-6">
                <a href="/" wire:navigate class="text-gray-700 hover:text-amber-500 font-medium transition">Home</a>
                <a href="/properties" wire:navigate class="text-gray-700 hover:text-amber-500 font-medium transition">Properties</a>
                <a href="/blog" wire:navigate class="text-gray-700 hover:text-amber-500 font-medium transition">Blog</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/admin') }}" wire:navigate
                            class="text-gray-700 hover:text-amber-500 font-medium transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" wire:navigate class="text-gray-700 hover:text-amber-500 font-medium transition">Log
                            in</a>
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

    <!-- Main Content -->
    {{ $slot }}

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
                        <li><a href="#" class="hover:text-amber-500 transition">Buy Property</a></li>
                        <li><a href="#" class="hover:text-amber-500 transition">Rent Property</a></li>
                        <li><a href="#" class="hover:text-amber-500 transition">Sell Property</a></li>
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

     @livewire('notifications') {{-- Only required if you wish to send flash notifications --}}

        @filamentScripts
        @vite('resources/js/app.js')
    @livewireScripts

    @stack('scripts')
</body>

</html>