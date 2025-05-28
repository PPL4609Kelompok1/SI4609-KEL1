@extends('layouts.app')

@section('content')
    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-8 text-gray-800">
                    <div class="mb-6 pb-4 border-b border-gray-200">
                        <a href="{{ route('education.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center text-sm font-semibold">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali ke Daftar Edukasi
                        </a>
                    </div>

                    @if($education->image_url)
                        <img src="{{ $education->image_url }}" alt="{{ $education->title }}" class="w-full h-72 object-cover rounded-lg mb-8 shadow">
                    @endif

                    <div class="mb-4">
                        <span class="inline-block px-4 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full">
                            {{ $education->category }}
                        </span>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-bold mb-6 leading-tight">{{ $education->title }}</h1>

                    <div class="prose prose-lg max-w-none mt-8 mb-10 text-gray-700 leading-relaxed">
                        {!! $education->content !!}
                    </div>

                    <div class="mt-10 pt-6 border-t border-gray-200">
                        <h2 class="text-xl font-semibold mb-4 text-gray-800">Bagikan Artikel Ini</h2>
                        <div class="flex space-x-4">
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($education->title) }}" 
                               target="_blank"
                               class="text-blue-500 hover:text-blue-700 transition-colors duration-200">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                               target="_blank"
                               class="text-blue-700 hover:text-blue-900 transition-colors duration-200">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 