@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-slate-900 to-blue-950 min-h-screen text-blue p-6">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-center mb-6">Leaderboards</h1>

        <!-- Tabs for Categories -->
        <div class="flex justify-center space-x-4 mb-4">
            <a href="{{ route('leaderboard.index', ['category' => 'individu']) }}"
               class="px-4 py-2 rounded-full font-semibold {{ $category === 'individu' ? 'bg-blue-600 text-white' : 'bg-blue-900 text-blue-200 hover:bg-blue-800' }}">
                Individu
            </a>
            <a href="{{ route('leaderboard.index', ['category' => 'komunitas']) }}"
               class="px-4 py-2 rounded-full font-semibold {{ $category === 'komunitas' ? 'bg-blue-600 text-white' : 'bg-blue-900 text-blue-200 hover:bg-blue-800' }}">
                Komunitas
            </a>
            <a href="{{ route('leaderboard.index', ['category' => 'wilayah']) }}"
               class="px-4 py-2 rounded-full font-semibold {{ $category === 'wilayah' ? 'bg-blue-600 text-white' : 'bg-blue-900 text-blue-200 hover:bg-blue-800' }}">
                Wilayah
            </a>
        </div>

        <!-- Leaderboard Table -->
        <div class="bg-blue-800 rounded-xl overflow-hidden shadow-lg max-h-96 overflow-y-scroll">

            <!-- Header Row -->
            @if($category !== 'komunitas' && $category !== 'wilayah')
            <div class="grid grid-cols-4 gap-4 px-4 py-3 border-b border-blue-600 text-sm font-semibold bg-blue-700 sticky top-0">
                <div class="text-center">Rank</div>
                <div class="text-center">Avatar</div>
                <div class="text-center">Name</div>
                <div class="text-center">Score</div>
            </div>
            @else
            <div class="grid grid-cols-4 gap-4 px-4 py-3 border-b border-blue-600 text-sm font-semibold bg-blue-700 sticky top-0">
                <div class="text-center">Rank</div>
                <div class="text-center">Logo</div>
                <div class="text-center">Name</div>
                <div class="text-center">Score</div>
            </div>
            @endif

            <!-- Leaderboard Entries -->
            @foreach ($ranked as $entry)
            <div class="grid grid-cols-4 gap-4 px-4 py-2 items-center 
                {{ $entry['name'] === '[username]' ? 'bg-yellow-500 text-black font-bold' : 
                ($entry['name'] === '[Community]' || $entry['name'] === '[Region]' ? 'bg-yellow-500 text-black' : 'hover:bg-blue-600') }}">

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
                @if($category === 'individu')
                <div class="flex justify-center">
                    <img src="{{ $entry['avatar'] }}" alt="avatar" class="w-12 h-12 rounded-full border-2 border-white">
                </div>
                @else
                <!-- Display Logo for Komunitas and Wilayah -->
                <div class="flex justify-center">
                    <img src="{{ $entry['avatar'] }}" alt="logo" class="w-12 h-12 rounded-full border-2 border-white">
                </div>
                @endif

                <!-- Name -->
                <div class="flex justify-center">{{ $entry['name'] }}</div>

                <!-- Score -->
                <div class="flex justify-center">{{ $entry['score'] }}</div>
            </div>
            @endforeach

            <!-- My Rank Fixed inside the leaderboard scroll -->
            @if($category === 'komunitas')
            <div class="grid grid-cols-4 gap-4 px-4 py-2 items-center bg-yellow-500 text-black font-bold sticky bottom-0 z-20">
                <div class="flex justify-center">
                    {{ $userRank ? $userRank['rank'] : '4' }}
                </div>
                <div class="flex justify-center">
                    <!-- Display Logo for Community -->
                    <img src="{{ $userRank ? $userRank['avatar'] : 'https://i.pravatar.cc/150?img=19' }}" alt="Community Logo" class="w-12 h-12 rounded-full border-2 border-white">
                </div>
                <div class="flex justify-center">
                    {{ '[Community]' }}
                </div>
                <div class="flex justify-center">
                    {{ $userRank ? $userRank['score'] : '13500' }}
                </div>
            </div>
            @elseif($category === 'wilayah')
            <div class="grid grid-cols-4 gap-4 px-4 py-2 items-center bg-yellow-500 text-black font-bold sticky bottom-0 z-20">
                <div class="flex justify-center">
                    {{ $userRank ? $userRank['rank'] : '1' }}
                </div>
                <div class="flex justify-center">
                    <!-- Display Logo for Region -->
                    <img src="{{ $userRank ? $userRank['avatar'] : 'https://i.pravatar.cc/150?img=31' }}" alt="Region Logo" class="w-12 h-12 rounded-full border-2 border-white">
                </div>
                <div class="flex justify-center">
                    {{ '[Region]' }}
                </div>
                <div class="flex justify-center">
                    {{ $userRank ? $userRank['score'] : '17000' }}
                </div>
            </div>
            @else
            <div class="grid grid-cols-4 gap-4 px-4 py-2 items-center bg-yellow-500 text-black font-bold sticky bottom-0 z-20">
                <div class="flex justify-center">
                    {{ $userRank ? $userRank['rank'] : 'My Rank' }}
                </div>
                <div class="flex justify-center">
                    <img src="{{ $userRank['avatar'] }}" alt="avatar" class="w-12 h-12 rounded-full border-2 border-white">
                </div>
                <div class="flex justify-center">{{ $userRank['name'] }}</div>
                <div class="flex justify-center">{{ $userRank['score'] }}</div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
