@extends('layouts.app')

@section('content')

    <div class="w-full max-w-none bg-green-100 rounded-3xl shadow-2xl p-0 backdrop-blur-md">
        {{-- Header Section --}}
        <div
            class="rounded-t-3xl bg-gradient-to-r from-blue-600 to-blue-400 px-8 py-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 shadow-lg">
            <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight drop-shadow">Artikel dan Video Tersimpan
            </h1>
            {{-- Back Button --}}
            <a href="{{ route('education.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-white text-blue-700 font-bold shadow hover:bg-blue-50 transition">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div id="bookmarked-contents-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-8 py-6">
            {{-- Content will be loaded here by JavaScript --}}
            <p id="loading-message" class="text-center text-gray-600">Memuat bookmark...</p>
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
                    container.innerHTML =
                        '<div class="col-span-full text-center py-12 flex flex-col items-center justify-center">' +
                        '<i class="far fa-bookmark text-blue-400 text-6xl mb-4 empty-bookmark-icon-animation"></i>' +
                        '<p class="text-gray-600 text-lg">Belum ada artikel atau video yang Anda simpan.</p>' +
                        '<p class="text-gray-500 text-sm mt-2">Kembali ke halaman edukasi untuk menyimpan konten favorit Anda.</p>' +
                        '</div>';
                } else {
                    // Loop through bookmarks and create content cards
                    for (const bookmarkKey in bookmarks) {
                        const content = bookmarks[bookmarkKey];

                        const cardHtml = `
                <div class="content-card bg-white rounded-lg shadow-lg overflow-hidden flex flex-col h-full border border-blue-100 hover:shadow-2xl transition" data-category="${content.category}">
                    <div class="relative w-full h-48 overflow-hidden">
                        ${content.type === 'video'
                                ? `
                                <div class="video-thumbnail-container relative w-full h-full cursor-pointer" data-video-id="${content.video_id}">
                                    <img src="${content.thumbnail}" alt="${content.title}" class="w-full h-full object-cover">
                                    <div class="video-play-button absolute inset-0 flex items-center justify-center bg-black bg-opacity-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                `
                                : `
                                <img src="${content.thumbnail}" alt="${content.title}" class="w-full h-full object-cover">
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

                    <div class="p-4 flex-1 flex flex-col">
                        <span class="inline-block px-3 py-1 text-sm font-semibold text-blue-600 bg-blue-100 rounded-full mb-2 self-start">
                            ${content.category}
                        </span>
                        <h3 class="text-xl font-semibold mb-2">${content.title}</h3>
                        <p class="text-gray-600 mb-4 flex-1">${content.description}</p>

                        <div class="mb-4">
                            ${content.type === 'article'
                                ? `
                                <a href="${content.content}" target="_blank" class="block w-full py-2 px-4 bg-blue-500 text-white rounded-lg text-center hover:bg-blue-600 transition-colors">
                                    Baca Selengkapnya
                                </a>
                                `
                                : `
                                <a href="https://www.youtube.com/watch?v=${content.video_id}" target="_blank" class="block w-full py-2 px-4 bg-blue-500 text-white rounded-lg text-center hover:bg-blue-600 transition-colors">
                                    Tonton Video
                                </a>
                                `
                            }
                        </div>

                        <div class="flex justify-center gap-4 pt-2 border-t border-gray-100">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(content.type === 'article' ? content.content : 'https://www.youtube.com/watch?v=' + content.video_id)}&quote=${encodeURIComponent(content.title)}" target="_blank" class="text-blue-600 hover:text-blue-800 text-2xl transition-colors">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=${encodeURIComponent(content.type === 'article' ? content.content : 'https://www.youtube.com/watch?v=' + content.video_id)}&text=${encodeURIComponent(content.title)}" target="_blank" class="text-blue-400 hover:text-blue-600 text-2xl transition-colors">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://wa.me/?text=${encodeURIComponent(content.title + ' ' + (content.type === 'article' ? content.content : 'https://www.youtube.com/watch?v=' + content.video_id))}" target="_blank" class="text-green-500 hover:text-green-700 text-2xl transition-colors">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            `;
                        container.innerHTML += cardHtml;
                    }

                    // Add event listeners to the dynamically created bookmark buttons
                    container.querySelectorAll('.bookmark-btn').forEach(button => {
                        button.addEventListener('click', () => {
                            const bookmarkKey = button.dataset.bookmarkKey;

                            // Show confirmation dialog
                            if (confirm('Apakah Anda yakin ingin menghapus bookmark ini?')) {
                                // Remove from Local Storage
                                delete bookmarks[bookmarkKey];
                                localStorage.setItem(localStorageKey, JSON.stringify(bookmarks));

                                // Remove the card from the display with animation
                                const card = button.closest('.content-card');
                                card.style.opacity = '0';
                                card.style.transform = 'scale(0.9)';
                                card.style.transition = 'all 0.3s ease';

                                setTimeout(() => {
                                    card.remove();

                                    // Check if no more bookmarks remain
                                    if (container.querySelectorAll('.content-card').length === 0) {
                                        container.innerHTML =
                                            '<div class="col-span-full text-center py-12 flex flex-col items-center justify-center">' +
                                            '<i class="far fa-bookmark text-blue-400 text-6xl mb-4 empty-bookmark-icon-animation"></i>' +
                                            '<p class="text-gray-600 text-lg">Belum ada artikel atau video yang Anda simpan.</p>' +
                                            '<p class="text-gray-500 text-sm mt-2">Kembali ke halaman edukasi untuk menyimpan konten favorit Anda.</p>' +
                                            '</div>';
                                    }
                                }, 300);

                                // Show success message
                                const successMessage = document.createElement('div');
                                successMessage.className = 'fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-green-500 text-white px-6 py-3 rounded-lg shadow-xl z-50 animate-fade-in-up';
                                successMessage.textContent = 'Bookmark berhasil dihapus!';
                                document.body.appendChild(successMessage);

                                // Add animation for fade out and move up, then remove
                                setTimeout(() => {
                                    successMessage.classList.remove('animate-fade-in-up');
                                    successMessage.classList.add('animate-fade-out-up');
                                }, 2000); // Start fade out after 2 seconds

                                setTimeout(() => {
                                    successMessage.remove();
                                }, 2500); // Remove completely after 2.5 seconds (0.5s fade out animation)
                            }
                        });
                    });

                    // Add event listeners to dynamically created video thumbnails
                    container.querySelectorAll('.video-thumbnail-container').forEach(videoContainer => {
                        videoContainer.addEventListener('click', () => {
                            const videoId = videoContainer.dataset.videoId;
                            const iframe = document.createElement('iframe');
                            iframe.setAttribute('src', `https://www.youtube.com/embed/${videoId}?autoplay=1`); // Correct YouTube embed URL
                            iframe.setAttribute('frameborder', '0');
                            iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
                            iframe.setAttribute('allowfullscreen', '');
                            iframe.classList.add('w-full', 'h-full', 'absolute', 'top-0', 'left-0');

                            // Clear current content and add iframe
                            videoContainer.innerHTML = '';
                            videoContainer.classList.add('relative');
                            videoContainer.appendChild(iframe);
                        });
                    });
                }
            });
        </script>
    @endpush

    @push('styles')
        <style>
            /* Video iframe positioning */
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

            .content-card>div:last-child {
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

            /* Smooth card transitions */
            .content-card {
                transition: all 0.3s ease;
            }

            .content-card:hover {
                transform: translateY(-2px);
            }

            /* Animation for empty bookmark icon */
            @keyframes bookmark-bounce {
                0%,
                100% {
                    transform: translateY(0) scale(1);
                    opacity: 0.8;
                }
                25% {
                    transform: translateY(-10px) scale(1.05);
                    /* Jump up */
                    opacity: 1;
                }
                50% {
                    transform: translateY(0) scale(1);
                    opacity: 0.9;
                }
                75% {
                    transform: translateY(-5px) scale(1.02);
                    /* Slight bounce */
                    opacity: 1;
                }
            }

            .empty-bookmark-icon-animation {
                animation: bookmark-bounce 2.5s infinite ease-in-out;
                /* Slower, smoother animation */
                will-change: transform, opacity;
            }

            /* Keyframes for 'Bookmark berhasil dihapus!' notification */
            @keyframes fade-in-up {
                from {
                    opacity: 0;
                    transform: translate(-50%, -30%);
                    /* Start slightly below center */
                }
                to {
                    opacity: 1;
                    transform: translate(-50%, -50%);
                    /* End at true center */
                }
            }

            @keyframes fade-out-up {
                from {
                    opacity: 1;
                    transform: translate(-50%, -50%);
                    /* Start at true center */
                }
                to {
                    opacity: 0;
                    transform: translate(-50%, -70%);
                    /* Move up and fade out */
                }
            }

            .animate-fade-in-up {
                animation: fade-in-up 0.3s ease-out forwards;
            }

            .animate-fade-out-up {
                animation: fade-out-up 0.5s ease-in forwards;
            }
        </style>
    @endpush
@endsection