@props(['images'])

<div x-data="{
    modalOpen: false,
    currentIndex: 0,
    images: {{ Js::from($images) }},
    get currentImage() {
        return this.images[this.currentIndex] || '';
    },
    nextImage() {
        this.currentIndex = (this.currentIndex + 1) % this.images.length;
    },
    prevImage() {
        this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
    },
    openModal(index) {
        this.currentIndex = index;
        this.modalOpen = true;
    }
}">
    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($images as $index => $image)
            <div class="aspect-video rounded-xl overflow-hidden cursor-pointer hover:opacity-90 transition"
                @click="openModal({{ $index }})">
                <img src="{{ $image }}" 
                    alt="Property Image {{ $index + 1 }}" 
                    class="w-full h-full object-cover"
                    onerror="this.onerror=null;this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22800%22 height=%22450%22%3E%3Crect width=%22100%25%22 height=%22100%25%22 fill=%22%23e5e7eb%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-size=%2232%22 fill=%22%239ca3af%22%3ENo Image%3C/text%3E%3C/svg%3E';">
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    <div x-show="modalOpen" 
        x-cloak
        @keydown.escape.window="modalOpen = false"
        @keydown.arrow-left.window="prevImage()"
        @keydown.arrow-right.window="nextImage()"
        class="fixed inset-0 flex items-center justify-center bg-black/80 px-4 pt-24 pb-4 overflow-y-auto"
        style="z-index: 9999; margin: 0;"
        @click="modalOpen = false">
        
        <div class="relative w-full max-w-5xl my-8 bg-white rounded-2xl shadow-2xl"
            style="max-height: calc(100vh - 10rem);"
            @click.stop>
            
            <!-- Close Button -->
            <button @click="modalOpen = false" 
                class="absolute -top-14 right-0 bg-white/90 hover:bg-white text-gray-800 rounded-full p-2 transition shadow-lg z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Image Container -->
            <div class="flex items-center justify-center bg-gray-100 p-6 rounded-t-2xl" style="min-height: 400px; max-height: calc(100vh - 12rem);">
                <img :src="currentImage" 
                    class="max-w-full max-h-full object-contain"
                    style="max-height: calc(100vh - 16rem);"
                    alt="Property Image">
            </div>

            <!-- Navigation & Counter Bar -->
            <div class="flex items-center justify-between bg-white px-6 py-4 rounded-b-2xl border-t border-gray-200">
                <!-- Previous Button -->
                <button @click="prevImage()" 
                    x-show="images.length > 1"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-full p-3 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                
                <!-- Image Counter -->
                <div class="bg-gray-100 text-gray-800 px-4 py-2 rounded-full text-sm font-medium">
                    <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
                </div>

                <!-- Next Button -->
                <button @click="nextImage()" 
                    x-show="images.length > 1"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-full p-3 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
