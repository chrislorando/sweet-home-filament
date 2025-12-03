<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-40 shadow-sm">
        <div class="container mx-auto px-6 py-10">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Blog</h1>
            <p class="text-gray-600">Insights, news, and tips from our team.</p>

            <!-- Search -->
            <div class="mt-6 max-w-2xl">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <x-heroicon-o-magnifying-glass class="h-6 w-6 text-gray-400" />
                    </div>
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search posts by title or content..."
                        class="w-full pl-12 pr-4 py-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-transparent text-gray-800 placeholder-gray-500"
                    />
                </div>
            </div>
        </div>
    </div>

    <!-- Posts Grid -->
    <div class="container mx-auto px-6 py-12">
        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($posts as $post)
                    <a href="{{ route('blog.show', $post->slug) }}" wire:navigate class="block group">
                        <article>
                            <div class="relative h-64 rounded-2xl overflow-hidden mb-6">
                                @if($post->image)
                                    <img src="{{ $post->image }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <img src="https://via.placeholder.com/400x300" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @endif
                                <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition"></div>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-500 mb-3">
                                <span class="text-amber-600 font-medium">News</span>
                                <span>&bull;</span>
                                <span>{{ optional($post->published_at)->format('M d, Y') }}</span>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-amber-600 transition leading-tight">
                                {{ $post->title }}
                            </h2>
                            <p class="text-gray-600 line-clamp-2 mb-4">
                                {{ Str::limit(strip_tags($post->content), 150) }}
                            </p>
                            <span class="text-amber-600 font-medium group-hover:underline decoration-2 underline-offset-4">
                                Read article
                            </span>
                        </article>
                    </a>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-6">
                    <x-heroicon-o-document-text class="w-10 h-10 text-gray-400" />
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No posts found</h3>
                <p class="text-gray-600">Try adjusting your search.</p>
            </div>
        @endif
    </div>
</div>
