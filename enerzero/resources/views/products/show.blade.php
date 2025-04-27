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
                @include('reviews._form')
            </div>

            <!-- Reviews List -->
            <div class="space-y-4">
                @forelse($product->reviews as $review)
                    <div class="bg-white border rounded-lg p-4 shadow-sm">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <strong class="text-green-700">{{ $review->username }}</strong>
                                <span class="text-yellow-500 ml-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                                    @endfor
                                </span>
                            </div>
                            <div class="flex gap-2">
                                <!-- Edit Button -->
                                <button onclick="editReview({{ $review->id }})" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <!-- Delete Button -->
                                <form action="{{ route('review.destroy', $review->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <p class="text-gray-700">{{ $review->comment }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Belum ada ulasan untuk produk ini.</p>
                @endforelse
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
</script>
@endpush
@endsection
