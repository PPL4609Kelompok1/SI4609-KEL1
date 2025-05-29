@extends('layouts.app')

@section('title', 'Enerzero')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <header class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <i class="fas fa-desktop text-2xl text-green-700"></i>
            <h1 class="text-3xl font-bold text-green-900">Dashboard</h1>
        </div>
        <div class="flex items-center gap-4 text-gray-600">
            <button title="Notifications" id="notif-button" class="hover:text-green-700 relative">
                <i class="fas fa-bell fa-lg"></i>
                @if($notification)
                    <span class="absolute top-0 right-0 block w-2 h-2 bg-red-500 rounded-full animate-ping"></span>
                    <span class="absolute top-0 right-0 block w-2 h-2 bg-red-500 rounded-full"></span>
                @endif
            </button>
            @if($notification)
            <div id="notif-dropdown" class="absolute right-20 mt-20 w-64 bg-white rounded-md shadow-lg hidden z-50">
                <div class="p-4 text-sm text-gray-800">
                    <p class="font-bold mb-2">Notifikasi Penting</p>
                    <p><i class="fas fa-exclamation-circle text-yellow-500 mr-2"></i>{{ $notification['message'] }}</p>
                </div>
            </div>
            @endif
            <button title="Settings" class="hover:text-green-700" id="settings-button">
                <i class="fas fa-cog fa-lg"></i>
            </button>
            <div class="w-10 h-10 rounded-full bg-gray-300"></div>
            <div id="dropdown-menu" class="absolute right-20 mt-20 w-48 bg-white rounded-md shadow-lg hidden">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left" type="submit">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Welcome Text -->
    <section>
        <p class="text-lg font-semibold text-gray-900">
            Hai! Selamat datang, <span class="font-bold">{{ auth()->user()->username ?? 'username' }}</span>
        </p>
        <p class="text-sm text-gray-800">Save Energy, Save the world!</p>
    </section>

    <!-- Main Cards Wrapper -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
    
        <!-- Monthly Comparison Card -->
        <article class="col-span-2 bg-white rounded-lg p-6 shadow-md">
            <h2 class="text-xl font-semibold text-green-700 mb-4">Monthly Comparison</h2>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-gray-600">Current Month Usage</p>
                    <p class="text-2xl font-bold">{{ $comparisonData['current_month'] }} kWh</p>
                </div>
                <div class="text-right">
                    <p class="text-gray-600">Previous Month</p>
                    <p class="text-xl">{{ $comparisonData['previous_month'] }} kWh</p>
                </div>
            </div>
            <div class="flex items-center gap-2 {{ $comparisonData['trend'] === 'increase' ? 'text-red-500' : 'text-green-500' }}">
                <i class="fas fa-{{ $comparisonData['trend'] === 'increase' ? 'arrow-up' : 'arrow-down' }}"></i>
                <span class="font-semibold">{{ $comparisonData['percentage_change'] }}% {{ $comparisonData['trend'] }}</span>
                <span class="text-gray-600">from last month</span>
                <a href="/energy-usage" class="mt-4 bg-yellow-400 text-black px-4 py-2 rounded font-semibold hover:bg-yellow-300">
                See Detail
                </a>
            </div>
        </article>

        <!-- Education Card -->
        <article class="bg-white rounded-lg p-6 shadow-md flex flex-col md:flex-row md:items-center md:gap-6">
            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=300&q=80" alt="Solar Panels" class="rounded-lg w-full md:w-1/2 object-cover mb-4 md:mb-0" />
            <div class="flex-1">
                <h2 class="text-green-700 font-semibold text-lg mb-2 uppercase">Education</h2>
                <p class="font-bold text-black">
                    Dari Kesadaran Menuju Tindakan: Edukasi Energi sebagai Pendorong Pembangunan Berkelanjutan
                </p>
                <p class="text-gray-800 text-sm my-2">
                    Edukasi energi mencakup berbagai inisiatif yang ditujukan untuk menumbuhkan kesadaran, pemahaman, dan perilaku yang bertanggung jawab terhadapi...
                </p>
                <button class="mt-2 bg-yellow-400 text-black px-4 py-2 rounded font-semibold hover:bg-yellow-300">
                    Read More
                </button>
            </div>
        </article>

    </section>

    <!-- Bottom Section -->
    <section class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-6">

        <!-- Forum -->
        <article class="md:col-span-3 bg-white rounded-lg p-4 shadow-md overflow-auto max-h-[320px] scrollbar-thin">
            <h3 class="text-green-700 font-semibold text-lg mb-4">FORUM</h3>
            <div class="space-y-4">
            @foreach ($forums as $forum)
                <a href="{{ route('forum.show', $forum->id) }}" class="block hover:shadow-lg transition">
                    <article class="bg-gray-200 p-3 rounded">
                        <h4 class="font-semibold">
                            <i class="fas fa-bolt mr-2"></i> {{ $forum->title }}
                        </h4>
                        <p class="text-gray-700 text-sm">
                            {{ Str::limit($forum->description, 100) }}
                        </p>
                        <div class="text-xs text-gray-500 mt-1 flex justify-between items-center">
                            <div class="flex items-center gap-1">
                                <i class="far fa-clock"></i> {{ $forum->created_at->diffForHumans() }}
                            </div>
                            <div class="flex items-center gap-3">
                                <span><i class="fas fa-reply"></i> {{ $forum->replies_count }}</span>
                                <span><i class="fas fa-heart"></i> {{ $forum->likes_count }}</span>
                            </div>
                        </div>
                    </article>
                </a>
            @endforeach
            </div>
        </article>

        <!-- Products -->
        <div class="overflow-hidden bg-white rounded-lg p-4 shadow-md">
            <h3 class="text-green-700 font-semibold text-lg mb-4 uppercase">PRODUCTS</h3>
            <div class="flex gap-4 transition-transform duration-700 ease-in-out" id="product-slider">
                @foreach ($products as $index => $product)
                <div class="w-full flex-shrink-0">
                    <div class="product-slide w-full h-full">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-40 object-contain mb-2 mx-auto" />
                        <div class="text-center">
                            <h4 class="font-bold text-lg text-green-800">{{ $product->name }}</h4>
                            <p class="text-sm text-gray-700">{{ Str::limit($product->description, 80) }}</p>
                            <p class="mt-2 text-green-600 font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <a href="{{ route('products.show', $product->id) }}" class="mt-3 inline-block bg-yellow-400 text-black px-4 py-2 rounded font-semibold hover:bg-yellow-300">
                                See Product Detail
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </section>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>document.addEventListener('DOMContentLoaded', function() {

    const button = document.getElementById('settings-button');
    const menu = document.getElementById('dropdown-menu');

    button.addEventListener('click', function(event) {
        event.stopPropagation();
        menu.classList.toggle('hidden');
    });
    document.addEventListener('click', function(event) {
        if (!menu.contains(event.target) && !button.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });
    const notifButton = document.getElementById('notif-button');
    const notifDropdown = document.getElementById('notif-dropdown');
    const notifList = document.getElementById('notif-list');
    const notifBadge = document.getElementById('notif-badge');

    notifButton?.addEventListener('click', function(event) {
        event.stopPropagation();
        notifDropdown?.classList.toggle('hidden');
    });

    document.addEventListener('click', function(event) {
        if (!notifDropdown?.contains(event.target) && !notifButton?.contains(event.target)) {
            notifDropdown?.classList.add('hidden');
        }
    });

    const slider = document.getElementById('product-slider');
    const totalSlides = slider.children.length;
    let current = 0;

    function showSlide(index) {
        const percentage = -(index * 100);
        slider.style.transform = `translateX(${percentage}%)`;
    }
    setInterval(() => {
        current = (current + 1) % totalSlides;
        showSlide(current);
    }, 3000);
});
</script>
@endsection