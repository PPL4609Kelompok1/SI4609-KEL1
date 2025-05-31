@extends('layouts.app')

@section('content')
<div class="rounded-t-3xl min-h-screen bg-green-100 py-10 px-2 md:px-0 flex items-center justify-center">
    <div class="w-full max-w-none bg-white/80 rounded-3xl shadow-2xl p-0 backdrop-blur-md">
         {{-- Header Section --}}
        <div class="rounded-t-3xl bg-gradient-to-r from-blue-600 to-blue-400 px-8 py-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 shadow-lg">
            <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight drop-shadow">Artikel dan Video Tersimpan</h1>
            {{-- Back Button --}}
            <a href="{{ route('education.index') }}" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-white text-blue-700 font-bold shadow hover:bg-blue-50 transition">
                <i class="fas fa-arrow-left"></i> Kembali ke Edukasi
            </a>
        </div>

    <div id="bookmarked-contents-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-8 py-6">
        {{-- Content will be loaded here by JavaScript --}}
        <p id="loading-message" class="text-center text-gray-600">Memuat bookmark...</p>
    </div>

    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const localStorageKey = 'enerzero_education_bookmarks';
    const bookmarks = JSON.parse(localStorage.getItem(localStorageKey)) || {};
    const container = document.getElementById('bookmarked-contents-container');
    const loadingMessage = document.getElementById('loading-message');

    // Clear loading message
    loadingMessage.style.display = 'none';
    container.innerHTML = ''; // Clear any initial content

    if (Object.keys(bookmarks).length === 0) {
        container.innerHTML = '<p class="text-center text-gray-600">Belum ada artikel atau video yang Anda simpan.</p>';
    } else {
        // Loop through bookmarks and create content cards
        for (const bookmarkKey in bookmarks) {
            const content = bookmarks[bookmarkKey];

            const cardHtml = `
                <div class="content-card bg-white rounded-lg shadow-lg overflow-hidden flex flex-col h-full border border-blue-100 hover:shadow-2xl transition" data-category="${content.category}">
                    <!-- Thumbnail -->
                    <div class="relative w-full overflow-hidden">
                        ${content.type === 'video'
                            ? `
                            <div class="video-thumbnail-container relative w-full aspect-w-16 aspect-h-9 cursor-pointer" data-video-id="${content.video_id}">
                                <img src="${content.thumbnail}" alt="${content.title}" class="w-full h-full object-cover">
                                <div class="video-play-button absolute inset-0 flex items-center justify-center bg-black bg-opacity-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            `
                            : `
                            <img src="${content.thumbnail}" alt="${content.title}" class="w-full h-48 object-cover">
                            `
                        }
                        <div class="absolute top-2 right-2">
                            <button class="bookmark-btn p-2 bg-white rounded-full shadow hover:bg-gray-100" 
                                    data-bookmark-key="${bookmarkKey}" data-bookmarked="true">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 fill-current" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Content Info -->
                    <div class="p-4 flex-1 flex flex-col">
                        <span class="inline-block px-3 py-1 text-sm font-semibold text-blue-600 bg-blue-100 rounded-full mb-2 self-start">
                            ${content.category}
                        </span>
                        <h3 class="text-xl font-semibold mb-2">${content.title}</h3>
                        <p class="text-gray-600 mb-4 flex-1">${content.description}</p>
                        ${content.type === 'article'
                            ? `
                            <a href="${content.content}" target="_blank" class="block w-full py-2 px-4 bg-blue-500 text-white rounded-lg text-center hover:bg-blue-600 transition-colors mt-auto">
                                Baca Selengkapnya
                            </a>
                            `
                            : `
                             <a href="https://www.youtube.com/watch?v=${content.video_id}" target="_blank" class="block w-full py-2 px-4 bg-blue-500 text-white rounded-lg text-center hover:bg-blue-600 transition-colors mt-auto">
                                Tonton Video
                            </a>
                            `
                        }
                    </div>

                    {{-- Share Buttons --}}
                    <div class="flex justify-center gap-4">
                        {{-- Facebook Share --}}
                        <a href="https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(content.content_type === 'article' ? content.content_url : 'https://www.youtube.com/watch?v=' + content.video_id)}&quote=${encodeURIComponent(content.title)}" target="_blank" class="text-blue-600 hover:text-blue-800 text-2xl">
                            <i class="fab fa-facebook"></i>
                        </a>
                        {{-- X (Twitter) Share --}}
                        <a href="https://twitter.com/intent/tweet?url=${encodeURIComponent(content.content_type === 'article' ? content.content_url : 'https://www.youtube.com/watch?v=' + content.video_id)}&text=${encodeURIComponent(content.title)}" target="_blank" class="text-blue-400 hover:text-blue-600 text-2xl">
                            <i class="fab fa-twitter"></i>
                        </a>
                         {{-- WhatsApp Share --}}
                        <a href="https://wa.me/?text=${encodeURIComponent(content.title + ' ' + (content.content_type === 'article' ? content.content_url : 'https://www.youtube.com/watch?v=' + content.video_id))}" target="_blank" class="text-green-500 hover:text-green-700 text-2xl">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                         {{-- Instagram (Placeholder/Info) --}}
                         {{-- <span title="Direct Instagram web share not supported" class="text-gray-400 text-2xl"><i class="fab fa-instagram"></i></span> --}}
                    </div>
                </div>
            `;
            container.innerHTML += cardHtml;
        }

        // Add event listeners to the dynamically created bookmark buttons
        container.querySelectorAll('.bookmark-btn').forEach(button => {
             button.addEventListener('click', () => {
                const bookmarkKey = button.dataset.bookmarkKey;
                
                // Remove from Local Storage
                delete bookmarks[bookmarkKey];
                localStorage.setItem(localStorageKey, JSON.stringify(bookmarks));

                // Remove the card from the display
                button.closest('.content-card').remove();
                 alert('Bookmark dihapus!');
             });
        });

         // Add event listeners to dynamically created video thumbnails
        container.querySelectorAll('.video-thumbnail-container').forEach(container => {
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
    }
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