@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Artikel Tersimpan</h1>
        <p class="text-gray-600">Kumpulan artikel yang telah Anda simpan untuk dibaca nanti</p>
    </div>

    <!-- Articles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($savedEducations as $education)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                @if($education->image)
                    <img src="{{ Storage::url($education->image) }}" 
                         alt="{{ $education->title }}" 
                         class="w-full h-48 object-cover">
                @endif
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                            {{ $education->category }}
                        </span>
                        <button class="text-yellow-500 hover:text-yellow-600 transition-colors duration-300"
                                onclick="toggleSave({{ $education->id }})">
                            <i class="fas fa-bookmark"></i>
                        </button>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">
                        {{ $education->title }}
                    </h2>
                    <p class="text-gray-600 mb-4 line-clamp-3">
                        {{ Str::limit(strip_tags($education->content), 150) }}
                    </p>
                    <a href="{{ route('education.show', $education->id) }}" 
                       class="text-blue-600 hover:text-blue-800 font-medium">
                        Baca selengkapnya →
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="mb-4">
                    <i class="far fa-bookmark text-4xl text-gray-400"></i>
                </div>
                <p class="text-gray-500 mb-4">Anda belum menyimpan artikel apapun</p>
                <a href="{{ route('education.index') }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    Jelajahi Artikel
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($savedEducations->count() > 0)
        <div class="mt-8">
            {{ $savedEducations->links() }}
        </div>
    @endif
</div>

@push('scripts')
<script>
function toggleSave(educationId) {
    fetch(`/api/education/${educationId}/toggle-save`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (!data.saved) {
            // Remove the article card from the saved articles page
            const articleCard = document.querySelector(`[data-education-id="${educationId}"]`);
            if (articleCard) {
                articleCard.remove();
            }
        }
    });
}
</script>
@endpush
@endsection 