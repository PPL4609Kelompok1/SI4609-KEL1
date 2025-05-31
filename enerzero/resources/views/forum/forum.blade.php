@extends('layouts.app')
@section('title', 'Enerzero | Forum')

<!-- Main Content -->
@section('content')
    <!-- Box for forum content -->
    <div class="w-90/100">

        <!-- Forum Heading -->
        <div class="flex justify-between items-center mb-6">
            <!-- Kiri: Icon komentar + Judul -->
            <div class="flex items-center">
                <i class="fas fa-comments text-green-600 text-xl mr-3"></i>
                <h1 class="text-3xl font-bold text-green-800">Forum</h1>
            </div>

            <!-- Kanan: Icon notif, setting, avatar -->
            <div class="flex items-center gap-4">
                <!-- Icon notif -->
                <i class="fas fa-bell text-gray-600 text-xl hover:text-gray-800 cursor-pointer"></i>
                
                <!-- Icon setting -->
                <i class="fas fa-cog text-gray-600 text-xl hover:text-gray-800 cursor-pointer"></i>
                
                <!-- Avatar user -->
                <img alt="User avatar" class="w-10 h-10 rounded-full object-cover cursor-pointer" src="https://placehold.co/40x40" />
            </div>
        </div>


        <!-- Search bar -->
        <div class="bg-white w-1/4 p-3 mb-2 rounded-lg">
            <div class="flex item-center gap-4">
                <!-- Icon search -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 3a7.5 7.5 0 006.15 13.65z" />
                </svg>
                <!-- Input user to search forum by title -->
                <input type="text" id="searchInput" placeholder="Type here to search" value="{{ request('search') }}"
                    class="bg-transparent outline-none text-black" />
            </div>
        </div>

        <script>
            document.getElementById('searchInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const query = e.target.value;
                    const url = new URL(window.location.href);
                    url.searchParams.set('search', query);
                    window.location.href = url.toString();
                }
            });
        </script>

        <!-- Create Forum Section -->
        @include('forum.create')

        <!-- Add Separator -->
        <div class="bg-white h-1 rounded-lg mb-4"></div>

        <!-- box for forum 1 -->
        @if ($forums->isEmpty())
            <p class="flex item-center">Tidak ada forum yang ditemukan.</p>
        @else
            @foreach ($forums as $forum)
                <div class="{{ $loop->iteration % 2 == 0 ? 'bg-green-100' : 'bg-green-200' }} p-4 rounded-lg mb-4 shadow">
                    <h2 class="text-l font-semibold mb-2">{{ $forum->title }}</h2>
                    
                    <div class="flex items-center mb-4">
                        <img alt="User avatar" class="rounded-full mr-2" src="https://placehold.co/40x40" />
                        <div>
                            <p class="text-gray-900">{{ $forum->username }}</p>
                            <p class="text-gray-500 text-xs">{{ $forum->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    <p class="text-gray-700 mb-4 text-sm">
                        {{ Str::limit($forum->description, 200) }}
                    </p>

                    <!-- Total Like -->
                    <div class="text-sm text-gray-600 mb-2">
                        ❤️ {{ $forum->likes->count() }} likes
                    </div>

                    <a href="{{ route('forum.show', $forum->id) }}">
                        <div
                            class="bg-yellow-400 h-10 w-1/6 rounded-lg flex justify-center items-center hover:bg-yellow-300">
                            <p class="text-black font-semibold">Read More</p>
                        </div>
                    </a>
                </div>
            @endforeach
        @endif
    </div>
@endsection
