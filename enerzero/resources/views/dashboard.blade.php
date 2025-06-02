@extends('layouts.app')

@section('title', 'Enerzero')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <header class="mb-6 flex items-center justify-between relative">
        <div class="flex items-center gap-2">
            <i class="fas fa-desktop text-2xl text-green-700"></i>
            <h1 class="text-3xl font-bold text-green-900">Dashboard</h1>
        </div>
        <div class="flex items-center gap-4 text-gray-600">
            <button title="Notifications" id="notif-button" class="hover:text-green-700 relative">
                <i class="fas fa-bell fa-lg"></i>
                <span id="notif-badge" class="absolute top-0 right-0 block w-2 h-2 bg-red-500 rounded-full hidden"></span>
            </button>
            <!-- Dropdown Notifikasi -->
            <div id="notif-dropdown" class="absolute right-0 top-full mt-2 w-72 max-h-80 bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden hidden z-50 transition-all duration-300 ease-in-out">
                <div class="p-4 text-sm text-gray-800 max-h-80 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-100">
                    <p class="font-bold mb-2 text-green-700">Notifikasi</p>
                    <ul id="notif-list" class="space-y-3 text-sm">
                        <li class="text-gray-400 text-center">Memuat notifikasi...</li>
                    </ul>
                </div>
            </div>

            <button title="Settings" class="hover:text-green-700" id="settings-button">
                <i class="fas fa-cog fa-lg"></i>
            </button>
            <div class="w-10 h-10 rounded-full bg-gray-300"></div>
            <div id="dropdown-menu" class="absolute right-20 mt-20 w-48 bg-white rounded-md shadow-lg hidden">
                <form action="#" method="POST">
                    @csrf
                    <button class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left" type="submit">
                        <i class="bi bi-box-arrow-right me-2"></i> Settings
                    </button>
                </form>
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
    {{-- <section class="grid grid-cols-1 md:grid-cols-3 gap-6"> --}}
    <section class="grid grid-cols-1 md:grid-cols-5 gap-6">
    
        <!-- Monthly Comparison Card -->
        {{-- <article class="col-span-2 bg-white rounded-lg p-6 shadow-md"> --}}
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
            </div>
            <div class="flex justify-start mt-4">
                <a href="/energy-usage" class="bg-yellow-400 text-black px-4 py-2 rounded font-semibold hover:bg-yellow-300">
                    See Detail
                </a>
            </div>
        </article>

        <!-- Education Card -->
        {{-- <article class="bg-white rounded-lg p-6 shadow-md flex flex-col md:flex-row md:items-center md:gap-6"> --}}
        <article class="col-span-3 bg-white rounded-lg p-6 shadow-md flex flex-col md:flex-row md:items-center md:gap-6">
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
    <section class="mt-6 grid grid-cols-1 md:grid-cols-5 gap-6">

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
        <div class="col-span-2 overflow-hidden bg-white rounded-lg p-4 shadow-md">
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const notifButton = document.getElementById('notif-button');
    const notifDropdown = document.getElementById('notif-dropdown');
    const notifList = document.getElementById('notif-list');
    const notifBadge = document.getElementById('notif-badge');

    // ➤ Tampilkan badge saat halaman dimuat (panggil saat pertama kali)
    checkUnreadNotifications();

    notifButton?.addEventListener('click', function (event) {
        event.stopPropagation();
        notifDropdown?.classList.toggle('hidden');

        // Tampilkan loading dulu
        notifList.innerHTML = '<li class="text-gray-400 text-center">Memuat notifikasi...</li>';

        fetch('/notifications')
            .then(res => res.json())
            .then(data => {
                notifList.innerHTML = '';
                let unreadCount = 0;

                if (data.length === 0) {
                    notifList.innerHTML = '<li class="text-gray-400 text-center">Tidak ada notifikasi baru</li>';
                    notifBadge?.classList.add('hidden');
                    return;
                }

                data.forEach(notif => {
                    const li = document.createElement('li');
                    li.className = 'cursor-pointer px-3 py-2 rounded hover:bg-gray-100 transition';
                    if (!notif.read_at) {
                        li.classList.add('bg-gray-100'); // notifikasi belum dibaca
                        unreadCount++;
                    }
                    li.setAttribute('data-id', notif.id);
                    let url = '/'; // default
                    if (notif.type === 'energy_alert') {
                        url = '/energy-report';
                    } else if (notif.type === 'daily_challenge') {
                        url = '/challenge';
                    } else if (notif.data.url) {
                        url = notif.data.url;
                    }

                    li.setAttribute('data-url', url);

                    li.innerHTML = `<span>${notif.data.message}</span>`;
                    notifList.appendChild(li);

                });

                // Sembunyikan badge setelah dibuka
                notifBadge?.classList.add('hidden');

                // Tandai sebagai dibaca
                fetch('/notifications/read-all', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
            });
    });

    // Tutup dropdown jika klik di luar
    document.addEventListener('click', function (event) {
        if (!notifDropdown?.contains(event.target) && !notifButton?.contains(event.target)) {
            notifDropdown?.classList.add('hidden');
        }
    });

    // ➤ Cek apakah ada notifikasi yang belum dibaca (untuk badge)
    function checkUnreadNotifications() {
        fetch('/notifications')
            .then(res => res.json())
            .then(data => {
                const unread = data.filter(n => n.read_at === null);
                if (unread.length > 0) {
                    notifBadge?.classList.remove('hidden');
                } else {
                    notifBadge?.classList.add('hidden');
                }
            });
    }

    notifList.addEventListener('click', function (e) {
        const li = e.target.closest('li[data-id]');
        if (!li) return;

        const id = li.getAttribute('data-id');
        const url = li.getAttribute('data-url');

        // tandai sebagai dibaca (hilangkan abu-abu)
        li.classList.remove('bg-gray-100');
        li.classList.add('bg-white');

        fetch('/notifications/read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ id })
        }).then(() => {
            if (url) {
                window.location.href = url;
            }
        });
    });
});
</script>


@endsection