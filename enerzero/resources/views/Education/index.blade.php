@extends('layouts.app')

@section('content')
<div class="rounded-t-3xl min-h-screen bg-green-100">
    <div class="w-full rounded-3xl shadow-2xl p-0 backdrop-blur-md">
        {{-- Header Section --}}
        <div class="rounded-t-3xl bg-gradient-to-r from-blue-600 to-blue-400 px-8 py-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 shadow-lg">
            <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight drop-shadow">Edukasi Hemat Energi</h1>
            {{-- Bookmark Saya Button --}}
            <a href="{{ route('education.bookmarked') }}" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-white text-blue-700 font-bold shadow hover:bg-blue-50 transition">
                <i class="fas fa-bookmark"></i> Bookmark Saya
            </a>
        </div>

        {{-- Category Filter --}}
        <div class="px-8 py-6 flex flex-wrap justify-center gap-4">
            <button class="category-filter px-4 py-2 rounded-full bg-gray-200 hover:bg-blue-500 hover:text-white transition-colors" data-category="all">
                Semua
            </button>
            @foreach($categories as $category)
            <button class="category-filter px-4 py-2 rounded-full bg-gray-200 hover:bg-blue-500 hover:text-white transition-colors" data-category="{{ $category }}">
                {{ $category }}
            </button>
            @endforeach
        </div>

        {{-- Content Grid --}}
        <div class="px-8 py-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($contents as $content)
                {{-- Log rendered category value --}}
                {{-- console.log('Blade rendered category:', '{{ $content['category'] }}'); --}}
                <div class="content-card bg-white rounded-lg shadow-lg overflow-hidden flex flex-col h-full border border-blue-100 hover:shadow-2xl transition" data-category="{{ $content['category'] }}">
                    <!-- Thumbnail/Video -->
                    <div class="relative w-full overflow-hidden">
                        @if($content['type'] === 'video')
                        <div class="video-thumbnail-container relative w-full aspect-w-16 aspect-h-9 cursor-pointer" data-video-id="{{ $content['video_id'] }}">
                            <img src="{{ $content['thumbnail'] }}" alt="{{ $content['title'] }}" class="w-full h-full object-cover">
                            <div class="video-play-button absolute inset-0 flex items-center justify-center bg-black bg-opacity-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        @else
                        <img src="{{ $content['thumbnail'] }}" alt="{{ $content['title'] }}" class="w-full h-48 object-cover">
                        @endif
                        <div class="absolute top-2 right-2">
                            <button class="bookmark-btn p-2 bg-white rounded-full shadow hover:bg-gray-100" 
                                    data-content='@json($content)'
                                    data-bookmarked="{{ in_array($content['content'], $bookmarkedContents ?? []) ? 'true' : 'false' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 {{ in_array($content['content'], $bookmarkedContents ?? []) ? 'text-red-500 fill-current' : 'text-gray-600' }}" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Content Info -->
                    <div class="p-4 flex-1 flex flex-col">
                        <span class="inline-block px-3 py-1 text-sm font-semibold text-blue-600 bg-blue-100 rounded-full mb-2 self-start">
                            {{ $content['category'] }}
                        </span>
                        <h3 class="text-xl font-semibold mb-2">{{ $content['title'] }}</h3>
                        <p class="text-gray-600 mb-4 flex-1">{{ $content['description'] }}</p>
                        @if($content['type'] === 'article')
                        <a href="{{ $content['content'] }}" target="_blank" class="block w-full py-2 px-4 bg-blue-500 text-white rounded-lg text-center hover:bg-blue-600 transition-colors mt-auto">
                            Baca Selengkapnya
                        </a>
                        @else
                        <a href="https://www.youtube.com/watch?v={{ $content['video_id'] }}" target="_blank" class="block w-full py-2 px-4 bg-blue-500 text-white rounded-lg text-center hover:bg-blue-600 transition-colors mt-auto">
                            Tonton Video
                        </a>
                        @endif
                    </div>

                    {{-- Share Buttons --}}
                    <div class="flex justify-center gap-4">
                        {{-- Facebook Share --}}
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($content['type'] === 'article' ? $content['content'] : 'https://www.youtube.com/watch?v=' . $content['video_id']) }}&quote={{ urlencode($content['title']) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-2xl">
                            <i class="fab fa-facebook"></i>
                        </a>
                        {{-- X (Twitter) Share --}}
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode($content['type'] === 'article' ? $content['content'] : 'https://www.youtube.com/watch?v=' . $content['video_id']) }}&text={{ urlencode($content['title']) }}" target="_blank" class="text-blue-400 hover:text-blue-600 text-2xl">
                            <i class="fab fa-twitter"></i>
                        </a>
                        {{-- WhatsApp Share --}}
                        <a href="https://wa.me/?text={{ urlencode($content['title'] . ' ' . ($content['type'] === 'article' ? $content['content'] : 'https://www.youtube.com/watch?v=' . $content['video_id'])) }}" target="_blank" class="text-green-500 hover:text-green-700 text-2xl">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                         {{-- Instagram (Placeholder/Info - direct share not easily possible from web) --}}
                        {{-- <span title="Direct Instagram web share not supported" class="text-gray-400 text-2xl"><i class="fab fa-instagram"></i></span> --}}
                         {{-- Atau jika ingin link ke Instagram utama --}}
                         {{-- <a href="https://www.instagram.com/" target="_blank" class="text-pink-600 hover:text-pink-800 text-2xl"><i class="fab fa-instagram"></i></a> --}}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Category filter functionality
    const filterButtons = document.querySelectorAll('.category-filter');
    const contentCards = document.querySelectorAll('.content-card');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const category = button.dataset.category;
            console.log('Clicked category:', category);
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('bg-blue-500', 'text-white'));
            button.classList.add('bg-blue-500', 'text-white');

            // Filter content
            contentCards.forEach(card => {
                const cardCategory = card.getAttribute('data-category');
                console.log('Checking card:', card, 'with category:', cardCategory);
                if (category === 'all' || cardCategory === category) {
                    console.log('Showing card:', card);
                    card.style.display = 'block';
                } else {
                    console.log('Hiding card:', card);
                    card.style.display = 'none';
                }
            });
        });
    });

    // Bookmark functionality using Local Storage
    const bookmarkButtons = document.querySelectorAll('.bookmark-btn');
    const localStorageKey = 'enerzero_education_bookmarks';

    // Load bookmarks from Local Storage on page load
    let bookmarks = JSON.parse(localStorage.getItem(localStorageKey)) || {};

    // Update icon status based on bookmarks in Local Storage
    bookmarkButtons.forEach(button => {
        const content = JSON.parse(button.dataset.content);
        // Use a unique key for each content item, e.g., content_url
        const bookmarkKey = content.content; 
        const icon = button.querySelector('svg');

        if (bookmarks[bookmarkKey]) {
            icon.classList.add('text-red-500', 'fill-current');
            button.dataset.bookmarked = 'true';
        } else {
            icon.classList.remove('text-red-500', 'fill-current');
            button.dataset.bookmarked = 'false';
        }

        button.addEventListener('click', () => {
            const isBookmarked = button.dataset.bookmarked === 'true';
            
            if (isBookmarked) {
                // Remove from bookmarks
                delete bookmarks[bookmarkKey];
                icon.classList.remove('text-red-500', 'fill-current');
                button.dataset.bookmarked = 'false';
                 alert('Bookmark dihapus!');
            } else {
                // Add to bookmarks
                bookmarks[bookmarkKey] = content; // Store full content data
                icon.classList.add('text-red-500', 'fill-current');
                button.dataset.bookmarked = 'true';
                 alert('Bookmark tersimpan!');
            }

            // Save updated bookmarks to Local Storage
            localStorage.setItem(localStorageKey, JSON.stringify(bookmarks));
        });
    });

    // Video thumbnail click functionality
    const videoThumbnailContainers = document.querySelectorAll('.video-thumbnail-container');
    videoThumbnailContainers.forEach(container => {
        container.addEventListener('click', () => {
            const videoId = container.dataset.videoId;
            const iframe = document.createElement('iframe');
            iframe.setAttribute('src', `https://www.youtube.com/embed/${videoId}?autoplay=1`);
            iframe.setAttribute('frameborder', '0');
            iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
            iframe.setAttribute('allowfullscreen', '');
            iframe.classList.add('w-full', 'h-full'); // Add Tailwind classes for size

            // Replace the thumbnail and play button with the iframe
            container.innerHTML = ''; // Clear current content
            container.appendChild(iframe);
        });
    });
});
</script>
@endpush

@push('styles')
<style>
.aspect-w-16 {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
}

.aspect-w-16 iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
</style>
@endpush
@endsection 