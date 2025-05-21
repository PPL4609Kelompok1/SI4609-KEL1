@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Edukasi EV</h1>
        <p class="text-gray-600">Pelajari lebih lanjut tentang kendaraan listrik dan teknologi terkait</p>
    </div>

    <!-- Category Filter -->
    <div class="mb-8">
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('education.index') }}" 
               class="px-4 py-2 rounded-full {{ !request('category') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                Semua
            </a>
            @foreach(['Video', 'Tips', 'Edukasi'] as $category)
                <a href="{{ route('education.index', ['category' => $category]) }}" 
                   class="px-4 py-2 rounded-full {{ request('category') == $category ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    {{ $category }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Articles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($educations as $education)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                @if($education['image'])
                    <div class="relative pb-[56.25%]">
                        <img src="{{ $education['image'] }}" 
                             alt="{{ $education['title'] }}" 
                             class="absolute inset-0 w-full h-full object-cover">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-play text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                            {{ $education['category'] }}
                        </span>
                        <button class="text-gray-400 hover:text-yellow-500 transition-colors duration-300"
                                onclick="toggleSave('{{ $education['id'] }}')">
                            <i class="far fa-bookmark"></i>
                        </button>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">
                        {{ $education['title'] }}
                    </h2>
                    <p class="text-gray-600 mb-4 line-clamp-3">
                        {{ $education['content'] }}
                    </p>
                    <a href="https://www.youtube.com/watch?v={{ $education['video_id'] }}" 
                       target="_blank"
                       class="text-blue-600 hover:text-blue-800 font-medium">
                        Tonton video →
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500">Belum ada video yang tersedia</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($educations->hasPages())
        <div class="mt-8">
            {{ $educations->links() }}
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
        if (data.saved) {
            const button = event.target.closest('button');
            button.classList.remove('text-gray-400');
            button.classList.add('text-yellow-500');
        }
    });
}
</script>
@endpush
@endsection 