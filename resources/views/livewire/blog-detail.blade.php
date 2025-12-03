<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Hero Image -->
    <div class="relative h-[400px] md:h-[500px] bg-gray-900">
        @if($post->image)
            <img src="{{ $post->image }}" alt="{{ $post->title }}" class="w-full h-full object-cover opacity-70"
                onerror="this.onerror=null;this.src='https://via.placeholder.com/1200x500?text=Image+Unavailable';">
        @else
            <div class="w-full h-full bg-gradient-to-br from-amber-500 to-amber-700"></div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>

        <div class="absolute bottom-0 left-0 w-full p-6 md:p-12">
            <div class="container mx-auto max-w-4xl">
                <div class="flex items-center gap-3 text-gray-300 mb-4">
                    <span class="px-3 py-1 bg-amber-500 text-white text-sm font-bold rounded-full">Blog</span>
                    <span>•</span>
                    <span>{{ $post->published_at->format('M d, Y') }}</span>
                </div>
                <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">{{ $post->title }}</h1>
                <div class="flex items-center gap-3 text-gray-300">
                    <div class="w-10 h-10 bg-gray-200 rounded-full overflow-hidden">
                        @if($post->user->avatar_url)
                            <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div
                                class="w-full h-full flex items-center justify-center bg-amber-100 text-amber-600 font-bold text-sm">
                                {{ substr($post->user->name, 0, 2) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <div class="font-medium">{{ $post->user->name }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 py-12 max-w-4xl">
        <!-- Content with Infolist -->
        {{ $this->postInfolist }}

        <!-- Author Info -->
        <div class="mt-12 bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-6">About the Author</h3>
            <div class="flex items-start gap-6">
                <div class="w-20 h-20 bg-gray-200 rounded-full overflow-hidden shrink-0">
                    @if($post->user->avatar_url)
                        <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}"
                            class="w-full h-full object-cover">
                    @else
                        <div
                            class="w-full h-full flex items-center justify-center bg-amber-100 text-amber-600 font-bold text-2xl">
                            {{ substr($post->user->name, 0, 2) }}
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <h4 class="text-lg font-bold text-gray-900 mb-1">{{ $post->user->name }}</h4>
                    @if($post->user->company_name)
                        <div class="text-amber-600 font-medium mb-2">{{ $post->user->company_name }}</div>
                    @endif
                    @if($post->user->description)
                        <p class="text-gray-600">{{ $post->user->description }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8">
            <a href="/" wire:navigate
                class="inline-flex items-center gap-2 text-amber-600 hover:text-amber-700 font-medium transition">
                <x-heroicon-o-arrow-left class="w-5 h-5" />
                Back to Home
            </a>
        </div>
    </div>
</div>