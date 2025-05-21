@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <a href="{{ route('education.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-6">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Artikel
        </a>

        <!-- Article Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                    {{ $education->category }}
                </span>
                <button class="text-gray-400 hover:text-yellow-500 transition-colors duration-300"
                        onclick="toggleSave({{ $education->id }})">
                    <i class="far fa-bookmark"></i>
                </button>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $education->title }}</h1>
            <div class="flex items-center text-gray-600 text-sm">
                <span>Dipublikasikan pada {{ $education->created_at->format('d M Y') }}</span>
            </div>
        </div>

        <!-- Featured Image -->
        @if($education->image)
            <div class="mb-8">
                <img src="{{ Storage::url($education->image) }}" 
                     alt="{{ $education->title }}" 
                     class="w-full h-96 object-cover rounded-lg">
            </div>
        @endif

        <!-- Article Content -->
        <div class="prose prose-lg max-w-none">
            {!! $education->content !!}
        </div>

        <!-- Share Section -->
        <div class="mt-12 pt-8 border-t">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Bagikan Artikel</h3>
            <div class="flex space-x-4">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                   target="_blank"
                   class="text-blue-600 hover:text-blue-800">
                    <i class="fab fa-facebook fa-lg"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($education->title) }}" 
                   target="_blank"
                   class="text-blue-400 hover:text-blue-600">
                    <i class="fab fa-twitter fa-lg"></i>
                </a>
                <a href="https://wa.me/?text={{ urlencode($education->title . ' ' . request()->url()) }}" 
                   target="_blank"
                   class="text-green-600 hover:text-green-800">
                    <i class="fab fa-whatsapp fa-lg"></i>
                </a>
            </div>
        </div>
    </div>
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
        if (data.saved) {
            // Update UI to show saved state
        }
    });
}
</script>
@endpush
@endsection 