@extends('layouts.app')

@section('title', 'Produk Energi Terbarukan')

@section('content')
<div class="space-y-6">
    <header class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <i class="fas fa-solar-panel text-2xl text-green-700"></i>
            <h1 class="text-3xl font-bold text-green-900">Produk Energi Terbarukan</h1>
        </div>
    </header>

    <form method="GET" class="mb-6 bg-white p-4 rounded-lg shadow-md">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}" 
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div class="flex-1">
                <select name="category" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">Semua Kategori</option>
                    <option value="solar" {{ request('category') == 'solar' ? 'selected' : '' }}>Solar</option>
                    <option value="wind" {{ request('category') == 'wind' ? 'selected' : '' }}>Wind</option>
                </select>
            </div>
            <div>
                <button type="submit" class="w-full md:w-auto bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
            </div>
        </div>
    </form>

    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($products as $product)
        <article class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow">
            <a href="{{ route('products.show', $product->id) }}" class="block">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-center h-40 object-cover rounded mb-4">
                <h2 class="text-lg font-bold text-green-800">{{ $product->name }}</h2>
                <p class="text-green-600 font-semibold mb-2">Harga: Rp {{ number_format($product->price, 0, ',', '.') }},-</p>
            </a>
            <p class="text-gray-600 text-sm mb-2">{{ $product->description }}</p>
            
            @if($product->reviews->count() > 0)
                <div class="mt-4 bg-gray-50 p-3 rounded-lg">
                    <h4 class="font-semibold text-green-800 mb-2">Ulasan:</h4>
                    @foreach ($product->reviews as $review)
                        <div class="mb-3 pb-3 border-b border-gray-200 last:border-0">
                            <div class="flex items-center gap-2 mb-1">
                                <strong class="text-green-700">{{ $review->username }}</strong>
                                <span class="text-yellow-500">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                                    @endfor
                                </span>
                            </div>
                            <p class="text-gray-700">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('products.reviews.store', $product) }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700">Rating</label>
                    <div class="flex items-center gap-1 star-rating" data-product-id="{{ $product->id }}">
                        @for($i = 1; $i <= 5; $i++)
                            <input type="radio" name="rating" value="{{ $i }}" id="rating{{ $product->id }}_{{ $i }}" required
                                class="hidden">
                            <label for="rating{{ $product->id }}_{{ $i }}" class="cursor-pointer text-2xl text-gray-300 hover:text-yellow-500 transition-colors">
                                <i class="fas fa-star"></i>
                            </label>
                        @endfor
                    </div>
                </div>
                <div class="mb-3">
                    <label for="comment" class="block text-sm font-medium text-gray-700">Komentar</label>
                    <textarea name="comment" id="comment" rows="3" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"></textarea>
                </div>
                <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors">
                    Kirim Ulasan
                </button>
            </form>
        </article>
        @endforeach
    </section>

    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>

@push('scripts')
<script>
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