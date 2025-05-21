@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="space-y-6">
    <header class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <i class="fas fa-solar-panel text-2xl text-green-700"></i>
            <h1 class="text-3xl font-bold text-green-900">Detail Produk</h1>
        </div>
        <a href="{{ route('products.index') }}" class="text-green-600 hover:text-green-800">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Produk
        </a>
    </header>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Product Image -->
            <div>
                <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg">
            </div>

            <!-- Product Details -->
            <div>
                <h2 class="text-2xl font-bold text-green-800 mb-4">{{ $product->name }}</h2>
                <p class="text-green-600 font-semibold text-xl mb-4">Harga: Rp {{ number_format($product->price, 0, ',', '.') }},-</p>
                <p class="text-gray-600 mb-4">{{ $product->description }}</p>
                <a href="{{ $product->marketplace_url }}" target="_blank" class="inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-shopping-cart mr-2"></i>Beli di Marketplace
                </a>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-8">
            <h3 class="text-xl font-semibold text-green-800 mb-4">Ulasan Produk</h3>

            <!-- Add Review Form -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h4 class="font-semibold text-green-800 mb-3">Tambah Ulasan</h4>
                <form action="{{ route('products.reviews.store', $product) }}" method="POST">
                    @csrf
                    <input type="hidden" name="username" value="Pengguna">
                    <div class="mb-4">
                        <label for="rating" class="block text-gray-700 mb-2">Rating</label>
                        <div class="flex items-center gap-1 star-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="rating" value="{{ $i }}" id="rating{{ $i }}" required
                                    class="hidden">
                                <label for="rating{{ $i }}" class="cursor-pointer text-2xl text-gray-300 hover:text-yellow-500 transition-colors">
                                    <i class="fas fa-star"></i>
                                </label>
                            @endfor
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="comment" class="block text-gray-700 mb-2">Komentar</label>
                        <textarea name="comment" id="comment" rows="3" required
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                    </div>
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                        Kirim Ulasan
                    </button>
                </form>
            </div>

            <!-- Reviews List -->
            <div class="space-y-4">
                @forelse($product->reviews as $review)
                    <div class="bg-white border rounded-lg p-4 shadow-sm">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h4 class="font-semibold text-green-800">{{ $review->username }}</h4>
                                <div class="flex items-center gap-1 text-yellow-500">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-700">{{ $review->comment }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada ulasan untuk produk ini.</p>
                @endforelse
            </div>
        </div>

        <!-- Recommendations Section -->
        <div class="mt-8">
            <h3 class="text-xl font-semibold text-green-800 mb-4">Produk Lainnya</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($recommendations ?? [] as $recommendedProduct)
                    <article class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow">
                        <a href="{{ route('products.show', $recommendedProduct->id) }}" class="block">
                            <h3 class="text-lg font-bold text-green-800">{{ $recommendedProduct->name }}</h3>
                            <p class="text-green-600 font-semibold mb-2">Harga: Rp {{ number_format($recommendedProduct->price, 0, ',', '.') }},-</p>
                            <p class="text-gray-600 text-sm mb-2">{{ $recommendedProduct->description }}</p>
                            <div class="flex items-center gap-1">
                                <span class="text-sm text-gray-600">Efisiensi Energi:</span>
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $recommendedProduct->energy_efficiency_rating ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Edit Review Modal -->
<div id="editReviewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-xl font-semibold text-green-800 mb-4">Edit Ulasan</h3>
        <form id="editReviewForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="edit_username" class="block text-gray-700 mb-2">Nama</label>
                <input type="text" name="username" id="edit_username" required
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div class="mb-4">
                <label for="edit_rating" class="block text-gray-700 mb-2">Rating</label>
                <select name="rating" id="edit_rating" required
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="5">5 Bintang</option>
                    <option value="4">4 Bintang</option>
                    <option value="3">3 Bintang</option>
                    <option value="2">2 Bintang</option>
                    <option value="1">1 Bintang</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="edit_comment" class="block text-gray-700 mb-2">Komentar</label>
                <textarea name="comment" id="edit_comment" rows="3" required
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeEditModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    Batal
                </button>
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function editReview(reviewId) {
    // Fetch review data
    fetch(`/review/${reviewId}`)
        .then(response => response.json())
        .then(review => {
            // Populate form
            document.getElementById('edit_username').value = review.username;
            document.getElementById('edit_rating').value = review.rating;
            document.getElementById('edit_comment').value = review.comment;
            
            // Update form action
            document.getElementById('editReviewForm').action = `/review/${reviewId}`;
            
            // Show modal
            document.getElementById('editReviewModal').classList.remove('hidden');
            document.getElementById('editReviewModal').classList.add('flex');
        });
}

function closeEditModal() {
    document.getElementById('editReviewModal').classList.add('hidden');
    document.getElementById('editReviewModal').classList.remove('flex');
}

document.addEventListener('DOMContentLoaded', function() {
    // Get all star rating containers
    const starRatings = document.querySelectorAll('.star-rating');
    
    starRatings.forEach(container => {
        const stars = container.querySelectorAll('label');
        const inputs = container.querySelectorAll('input[type="radio"]');
        
        // Handle star hover
        stars.forEach((star, index) => {
            star.addEventListener('mouseover', () => {
                // Highlight all stars up to the hovered one
                stars.forEach((s, i) => {
                    if (i <= index) {
                        s.querySelector('i').classList.add('text-yellow-500');
                        s.querySelector('i').classList.remove('text-gray-300');
                    } else {
                        s.querySelector('i').classList.remove('text-yellow-500');
                        s.querySelector('i').classList.add('text-gray-300');
                    }
                });
            });
        });
        
        // Handle star selection
        inputs.forEach((input, index) => {
            input.addEventListener('change', () => {
                // Update star colors based on selection
                stars.forEach((star, i) => {
                    if (i <= index) {
                        star.querySelector('i').classList.add('text-yellow-500');
                        star.querySelector('i').classList.remove('text-gray-300');
                    } else {
                        star.querySelector('i').classList.remove('text-yellow-500');
                        star.querySelector('i').classList.add('text-gray-300');
                    }
                });
            });
        });
        
        // Reset stars when mouse leaves the container
        container.addEventListener('mouseleave', () => {
            const selectedInput = container.querySelector('input[type="radio"]:checked');
            if (!selectedInput) {
                stars.forEach(star => {
                    star.querySelector('i').classList.remove('text-yellow-500');
                    star.querySelector('i').classList.add('text-gray-300');
                });
            } else {
                const selectedIndex = Array.from(inputs).indexOf(selectedInput);
                stars.forEach((star, i) => {
                    if (i <= selectedIndex) {
                        star.querySelector('i').classList.add('text-yellow-500');
                        star.querySelector('i').classList.remove('text-gray-300');
                    } else {
                        star.querySelector('i').classList.remove('text-yellow-500');
                        star.querySelector('i').classList.add('text-gray-300');
                    }
                });
            }
        });
    });
});
</script>
@endpush
@endsection
