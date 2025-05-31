@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-center mb-8">{{ $foundContent['title'] }}</h1>

    <div class="flex flex-col md:flex-row gap-8">
        <div class="md:w-2/3">
            @if($foundContent['type'] === 'article')
            <img src="{{ $foundContent['thumbnail'] }}" alt="{{ $foundContent['title'] }}" class="w-full rounded-lg mb-4">
            <div class="prose max-w-none">
                <p class="text-gray-600 mb-4">{{ $foundContent['description'] }}</p>
                {!! nl2br(e($foundContent['content'])) !!}
            </div>
            @elseif($foundContent['type'] === 'video')
            <div class="aspect-w-16 aspect-h-9 mb-4">
                <iframe src="{{ $foundContent['content'] }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <p class="text-gray-600 mb-4">{{ $foundContent['description'] }}</p>
            @endif
        </div>

        <div class="md:w-1/3">
            <!-- You can add related content or other information here -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Informasi Konten</h2>
                <p><strong>Kategori:</strong> {{ $foundContent['category'] }}</p>
                <p><strong>Tipe:</strong> {{ $foundContent['type'] === 'article' ? 'Artikel' : 'Video' }}</p>
                <!-- Add more details if available -->
            </div>
        </div>
    </div>
</div>
@endsection 