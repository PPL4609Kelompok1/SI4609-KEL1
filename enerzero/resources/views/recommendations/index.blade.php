@extends('layouts.app')

@section('title', 'Rekomendasi Produk')

@section('content')
<div class="space-y-6">

    <header class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <i class="fas fa-lightbulb text-2xl text-green-700"></i>
            <h1 class="text-3xl font-bold text-green-900">Rekomendasi Produk Energi Terbarukan</h1>
        </div>
    </header>

    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($products as $product)
        <article class="bg-white rounded-lg shadow-md p-4">
            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-40 object-cover rounded mb-4">
            <h2 class="text-lg font-bold text-green-800">{{ $product['name'] }}</h2>
            <p class="text-sm text-gray-700 mb-2">{{ $product['description'] }}</p>
            <p class="text-green-600 font-semibold mb-2">Harga: {{ $product['price'] }}</p>
    
            <div class="flex items-center space-x-4 mb-3">
                <a href="{{ $product['shopee_link'] }}" target="_blank">
                    <img src="{{ asset('images/shopee_logo.webp') }}" alt="Shopee" class="w-8 h-8 object-contain">
                </a>
                <a href="{{ $product['tokopedia_link'] }}" target="_blank">
                    <img src="{{ asset('images/tokopedia_logo.png') }}" alt="Tokopedia" class="w-8 h-8 object-contain">
                </a>
            </div>
    
            <div class="bg-gray-100 p-2 rounded text-sm text-gray-700">
                <strong>Ulasan:</strong>
                <ul class="list-disc list-inside">
                    @foreach ($product['reviews'] as $review)
                    <li>{{ $review }}</li>
                    @endforeach
                </ul>
            </div>
        </article>
        @endforeach
    </section>
    

</div>
@endsection
