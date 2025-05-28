@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-8 text-center">Edukasi Hemat Energi</h1>
                    
                    <!-- Category Filter -->
                    <div class="mb-8">
                        <div class="flex flex-wrap gap-2 justify-center">
                            <a href="{{ route('education.index') }}" 
                               class="px-4 py-2 rounded-full {{ !$category ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }} hover:bg-blue-500 hover:text-white transition">
                                Semua
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('education.index', ['category' => $cat]) }}" 
                                   class="px-4 py-2 rounded-full {{ $category === $cat ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }} hover:bg-blue-500 hover:text-white transition">
                                    {{ $cat }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Education Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($educations as $education)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                                @if($education->image_url)
                                    <img src="{{ $education->image_url }}" alt="{{ $education->title }}" class="w-full h-48 object-cover">
                                @endif
                                <div class="p-4">
                                    <span class="inline-block px-3 py-1 text-sm font-semibold text-blue-600 bg-blue-100 rounded-full mb-2">
                                        {{ $education->category }}
                                    </span>
                                    <h2 class="text-xl font-semibold mb-2">{{ $education->title }}</h2>
                                    <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit(strip_tags($education->content), 150) }}</p>
                                    <a href="{{ route('education.show', $education) }}" 
                                       class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                        Baca Selengkapnya
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $educations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 