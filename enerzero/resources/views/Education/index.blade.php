@extends('layouts.app')

@section('content')
<div class="rounded-t-3xl min-h-screen bg-green-100">
    <div class="w-full rounded-3xl shadow-2xl p-0 backdrop-blur-md">
        {{-- Header Section --}}
        <div class="rounded-t-3xl bg-gradient-to-r from-blue-600 to-blue-400 px-8 py-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 shadow-lg">
            <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight drop-shadow">Edukasi Hemat Energi</h1>
            {{-- Bookmark Saya Button --}}
            <a href="{{ route('education.bookmarked') }}" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-white text-blue-700 font-bold shadow hover:bg-blue-50 transition">
                <i class="fas fa-bookmark"></i> Bookmark
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
        <div class="px-8 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($contents as $content)
                <div class="content-card bg-white rounded-lg shadow-lg overflow-hidden flex flex-col h-full border border-blue-100 hover:shadow-2xl transition" data-category="{{ $content['category'] }}">
                    <div class="relative w-full h-48 overflow-hidden">
                        @if($content['type'] === 'video')
                        <div class="video-thumbnail-container relative w-full h-full cursor-pointer" data-video-id="{{ $content['video_id'] }}">
                            <img src="{{ $content['thumbnail'] }}" alt="{{ $content['title'] }}" class="w-full h-full object-cover">
                            <div class="video-play-button absolute inset-0 flex items-center justify-center bg-black bg-opacity-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        @else
                        <img src="{{ $content['thumbnail'] }}" alt="{{ $content['title'] }}" class="w-full h-full object-cover">
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

                    <div class="p-4 flex-1 flex flex-col">
                        <span class="inline-block px-3 py-1 text-sm font-semibold text-blue-600 bg-blue-100 rounded-full mb-2 self-start">
                            {{ $content['category'] }}
                        </span>
                        <h3 class="text-xl font-semibold mb-2">{{ $content['title'] }}</h3>
                        <p class="text-gray-600 mb-4 flex-1">{{ $content['description'] }}</p>

                        <div class="mb-4">
                            @if($content['type'] === 'article')
                            <a href="{{ $content['content'] }}" target="_blank" class="block w-full py-2 px-4 bg-blue-500 text-white rounded-lg text-center hover:bg-blue-600 transition-colors">
                                Baca Selengkapnya
                            </a>
                            @else
                            <a href="https://www.youtube.com/watch?v={{ $content['video_id'] }}" target="_blank" class="block w-full py-2 px-4 bg-blue-500 text-white rounded-lg text-center hover:bg-blue-600 transition-colors">
                                Tonton Video
                            </a>
                            @endif
                        </div>

                        {{-- Share Buttons --}}
                        <div class="flex justify-center gap-4 pt-2 border-t border-gray-100">
                            {{-- Facebook Share --}}
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($content['type'] === 'article' ? $content['content'] : 'https://www.youtube.com/watch?v=' . $content['video_id']) }}&quote={{ urlencode($content['title']) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-2xl transition-colors">
                                <i class="fab fa-facebook"></i>
                            </a>
                            {{-- X (Twitter) Share --}}
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode($content['type'] === 'article' ? $content['content'] : 'https://www.youtube.com/watch?v=' . $content['video_id']) }}&text={{ urlencode($content['title']) }}" target="_blank" class="text-blue-400 hover:text-blue-600 text-2xl transition-colors">
                                <i class="fab fa-twitter"></i>
                            </a>
                            {{-- WhatsApp Share --}}
                            <a href="https://wa.me/?text={{ urlencode($content['title'] . ' ' . ($content['type'] === 'article' ? $content['content'] : 'https://www.youtube.com/watch?v=' . $content['video_id'])) }}" target="_blank" class="text-green-500 hover:text-green-700 text-2xl transition-colors">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
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

            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('bg-blue-500', 'text-white'));
            button.classList.add('bg-blue-500', 'text-white');

            // Filter content
            contentCards.forEach(card => {
                const cardCategory = card.getAttribute('data-category');
                if (category === 'all' || cardCategory === category) {
                    card.style.display = 'block';
                } else {
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

    // Function to show a notification
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        // Changed placement to left-1/2 for horizontal centering
        notification.className = `fixed top-16 left-1/2 px-6 py-3 rounded-lg shadow-lg z-50 notification-animation notification-${type}`;
        notification.textContent = message;
        document.body.appendChild(notification);

        // Trigger slide-in animation
        notification.classList.add('slide-in-from-top');

        // Hide and remove after 3 seconds with fade-out animation
        setTimeout(() => {
            notification.classList.remove('slide-in-from-top');
            notification.classList.add('fade-out-and-slide-up');
            notification.addEventListener('animationend', () => {
                notification.remove();
            }, { once: true }); // Ensure listener is removed after one execution
        }, 3000);
    }

    // Update icon status based on bookmarks in Local Storage
    bookmarkButtons.forEach(button => {
        const content = JSON.parse(button.dataset.content);
        // Use a unique key for each content item, e.g., content_url
        const bookmarkKey = content.content;
        const iconSvg = button.querySelector('svg');

        if (bookmarks[bookmarkKey]) {
            iconSvg.classList.add('text-red-500', 'fill-current');
            iconSvg.classList.remove('text-gray-600');
            button.dataset.bookmarked = 'true';
        } else {
            iconSvg.classList.remove('text-red-500', 'fill-current');
            iconSvg.classList.add('text-gray-600');
            button.dataset.bookmarked = 'false';
        }

        button.addEventListener('click', () => {
            const isBookmarked = button.dataset.bookmarked === 'true';
            const currentIconSvg = button.querySelector('svg'); // Get the SVG element again in case the DOM changes

            if (isBookmarked) {
                // Remove from bookmarks
                delete bookmarks[bookmarkKey];
                currentIconSvg.classList.remove('text-red-500', 'fill-current');
                currentIconSvg.classList.add('text-gray-600');
                button.dataset.bookmarked = 'false';
                // Add heart pop animation
                currentIconSvg.classList.add('heart-pop-animation');
                setTimeout(() => {
                    currentIconSvg.classList.remove('heart-pop-animation');
                }, 300); // Duration of the heart pop animation
                showNotification('Bookmark dihapus!', 'danger'); // Show notification
            } else {
                // Add to bookmarks
                bookmarks[bookmarkKey] = content; // Store full content data
                currentIconSvg.classList.add('text-red-500', 'fill-current');
                currentIconSvg.classList.remove('text-gray-600');
                button.dataset.bookmarked = 'true';
                // Add heart pop animation
                currentIconSvg.classList.add('heart-pop-animation');
                setTimeout(() => {
                    currentIconSvg.classList.remove('heart-pop-animation');
                }, 300); // Duration of the heart pop animation
                showNotification('Bookmark tersimpan!', 'success'); // Show notification
            }

            // Save updated bookmarks to Local Storage
            localStorage.setItem(localStorageKey, JSON.stringify(bookmarks));
        });
    });

    // Video thumbnail click functionality with improved iframe handling
    const videoThumbnailContainers = document.querySelectorAll('.video-thumbnail-container');
    videoThumbnailContainers.forEach(container => {
        container.addEventListener('click', () => {
            const videoId = container.dataset.videoId;
            const iframe = document.createElement('iframe');
            iframe.setAttribute('src', `https://www.youtube.com/embed/${videoId}?autoplay=1`); // Correct YouTube embed URL
            iframe.setAttribute('frameborder', '0');
            iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
            iframe.setAttribute('allowfullscreen', '');
            iframe.classList.add('w-full', 'h-full', 'absolute', 'top-0', 'left-0');

            // Clear current content and add iframe
            container.innerHTML = '';
            container.classList.add('relative');
            container.appendChild(iframe);
        });
    });
});
</script>
@endpush

@push('styles')
<style>
/* Remove the old aspect ratio classes since we're using fixed height */
.video-thumbnail-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

/* Ensure consistent card heights */
.content-card {
    display: flex;
    flex-direction: column;
}

.content-card > div:last-child {
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* Better hover effects for social buttons */
.content-card a[href*="facebook"]:hover i,
.content-card a[href*="twitter"]:hover i,
.content-card a[href*="wa.me"]:hover i {
    transform: scale(1.1);
    transition: transform 0.2s ease;
}

/* Heart pop animation for bookmark icon */
@keyframes heart-pop {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.2); /* Pop out */
        opacity: 0.8;
    }
    100% {
        transform: scale(1); /* Return to normal size */
        opacity: 1;
    }
}

.heart-pop-animation {
    animation: heart-pop 0.3s ease-out; /* Fast, snappy animation */
}


/* Notification Animations */

/* Slide in from top */
@keyframes slideInFromTop {
    0% {
        transform: translate(-50%, -100%); /* Start above and centered */
        opacity: 0;
    }
    100% {
        transform: translate(-50%, 0); /* End at current position, still centered */
        opacity: 1;
    }
}

/* Fade out and slide up */
@keyframes fadeOutAndSlideUp {
    0% {
        transform: translate(-50%, 0); /* Start at current position, still centered */
        opacity: 1;
    }
    100% {
        transform: translate(-50%, -50%); /* Move up slightly while fading, still centered */
        opacity: 0;
    }
}

.notification-animation {
    /* Important for horizontal centering */
    left: 50%;
    transform: translateX(-50%);
    /* Default transition properties for smoother appearance */
    transition: transform 0.3s ease-out, opacity 0.3s ease-out;
    /* Ensure it's on top */
    z-index: 1000; /* High z-index */
    /* Add max-width for better responsiveness on small screens */
    max-width: 90%; /* Max width 90% of parent */
    box-sizing: border-box; /* Include padding and border in width */
    text-align: center; /* Center text within the notification */
}

/* Specific classes for animation */
.notification-animation.slide-in-from-top {
    animation: slideInFromTop 0.5s ease-out forwards;
}

.notification-animation.fade-out-and-slide-up {
    animation: fadeOutAndSlideUp 0.5s ease-out forwards;
}

/* Notification styling */
.notification-success {
    background-color: #4CAF50; /* Green */
    color: white;
}

.notification-danger {
    background-color: #f44336; /* Red */
    color: white;
}
</style>
@endpush
@endsection