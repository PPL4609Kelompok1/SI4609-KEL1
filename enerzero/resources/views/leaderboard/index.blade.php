@extends('layouts.app')
@section('title', 'Leaderboard')

@section('content')
    <div class="bg-gradient-to-br from-slate-900 to-green-950 h-screen text-green p-6 flex flex-col">
        <h1 class="text-3xl font-bold text-center mb-6">Leaderboards</h1>

        <!-- Tabs for Categories -->
        <div class="flex justify-center space-x-4 mb-4">
            <a href="{{ route('leaderboard.index', ['category' => 'individu']) }}"
                class="px-4 py-2 rounded-full font-semibold {{ $category === 'individu' ? 'bg-green-600 text-white' : 'bg-green-900 text-green-200 hover:bg-green-800' }}">
                Individu
            </a>
            <a href="{{ route('leaderboard.index', ['category' => 'komunitas']) }}"
                class="px-4 py-2 rounded-full font-semibold {{ $category === 'komunitas' ? 'bg-green-600 text-white' : 'bg-green-900 text-green-200 hover:bg-green-800' }}">
                Komunitas
            </a>
            <a href="{{ route('leaderboard.index', ['category' => 'wilayah']) }}"
                class="px-4 py-2 rounded-full font-semibold {{ $category === 'wilayah' ? 'bg-green-600 text-white' : 'bg-green-900 text-green-200 hover:bg-green-800' }}">
                Wilayah
            </a>
        </div>

        <!-- Leaderboard Table -->
        <div class="bg-green-800 rounded-xl overflow-hidden shadow-lg flex flex-col" style="height: calc(100vh - 200px);">

            <!-- Header Row -->
            @if ($category !== 'komunitas' && $category !== 'wilayah')
                <div class="grid grid-cols-4 gap-4 px-4 py-3 border-b border-green-600 text-sm font-semibold bg-green-700 flex-shrink-0">
                    <div class="text-center">Rank</div>
                    <div class="text-center">Avatar</div>
                    <div class="text-center">Name</div>
                    <div class="text-center">Score</div>
                </div>
            @else
                <div class="grid grid-cols-4 gap-4 px-4 py-3 border-b border-green-600 text-sm font-semibold bg-green-700 flex-shrink-0">
                    <div class="text-center">Rank</div>
                    <div class="text-center">Logo</div>
                    <div class="text-center">Name</div>
                    <div class="text-center">Score</div>
                </div>
            @endif

            <!-- Scrollable Content Area -->
            <div class="flex-1 overflow-y-auto">
                <!-- Leaderboard Entries -->
                @foreach ($ranked as $entry)
                    <div class="grid grid-cols-4 gap-4 px-4 py-2 items-center 
                    {{ $entry['name'] === Auth::user()->name
                        ? 'bg-green-600 text-black font-bold'
                        : ($entry['name'] === '[Community]' || $entry['name'] === '[Region]'
                            ? 'bg-green-600 text-black'
                            : 'hover:bg-green-600') }}">

                        <!-- Rank -->
                        <div class="flex justify-center items-center">
                            @if ($entry['rank'] == 1)
                                🥇
                            @elseif ($entry['rank'] == 2)
                                🥈
                            @elseif ($entry['rank'] == 3)
                                🥉
                            @else
                                {{ $entry['rank'] }}
                            @endif
                        </div>

                        <!-- Avatar (Only for Individuals) -->
                        @if ($category === 'individu')
                            <div class="flex justify-center">
                                <img src="{{ $entry['avatar'] }}" alt="avatar"
                                    class="w-12 h-12 rounded-full border-2 border-white">
                            </div>
                        @else
                            <!-- Display Logo for Komunitas and Wilayah -->
                            <div class="flex justify-center">
                                <img src="{{ $entry['avatar'] }}" alt="logo"
                                    class="w-12 h-12 rounded-full border-2 border-white">
                            </div>
                        @endif

                        <!-- Name -->
                        <div class="flex justify-center">
                            {{ $entry['name'] === Auth::user()->name ? auth()->user()->username : $entry['name'] }}</div>

                        <!-- Score -->
                        <div class="flex justify-center">{{ $entry['score'] }}</div>
                    </div>
                @endforeach
            </div>

            <!-- My Rank Fixed at bottom -->
            @if ($category === 'komunitas')
                <div class="grid grid-cols-4 gap-4 px-4 py-2 items-center bg-green-600 text-black font-bold border-t border-green-500 flex-shrink-0">
                    <div class="flex justify-center">
                        {{ $userRank ? $userRank['rank'] : '4' }}
                    </div>
                    <div class="flex justify-center">
                        <!-- Display Logo for Community -->
                        <img src="{{ $userRank ? $userRank['avatar'] : 'https://i.pravatar.cc/150?img=19' }}"
                            alt="Community Logo" class="w-12 h-12 rounded-full border-2 border-white">
                    </div>
                    <div class="flex justify-center">
                        {{ '[Community]' }}
                    </div>
                    <div class="flex justify-center">
                        {{ $userRank ? $userRank['score'] : '13500' }}
                    </div>
                </div>
            @elseif($category === 'wilayah')
                <div class="grid grid-cols-4 gap-4 px-4 py-2 items-center bg-green-600 text-black font-bold border-t border-green-500 flex-shrink-0">
                    <div class="flex justify-center">
                        {{ $userRank ? $userRank['rank'] : '1' }}
                    </div>
                    <div class="flex justify-center">
                        <!-- Display Logo for Region -->
                        <img src="{{ $userRank ? $userRank['avatar'] : 'https://i.pravatar.cc/150?img=31' }}"
                            alt="Region Logo" class="w-12 h-12 rounded-full border-2 border-white">
                    </div>
                    <div class="flex justify-center">
                        {{ '[Region]' }}
                    </div>
                    <div class="flex justify-center">
                        {{ $userRank ? $userRank['score'] : '17000' }}
                    </div>
                </div>
            @else
                <div class="grid grid-cols-4 gap-4 px-4 py-2 items-center bg-green-600 text-black font-bold border-t border-green-500 flex-shrink-0">
                    <div class="flex justify-center">
                        {{ $userRank ? $userRank['rank'] : 'My Rank' }}
                    </div>
                    <div class="flex justify-center">
                        <img src="{{ $userRank['avatar'] }}" alt="avatar"
                            class="w-12 h-12 rounded-full border-2 border-white">
                    </div>
                    <div class="flex justify-center">{{ $userRank['name'] }}</div>
                    <div class="flex justify-center">{{ $userRank['score'] }}</div>
                </div>
            @endif
        </div>
    </div>
@endsection