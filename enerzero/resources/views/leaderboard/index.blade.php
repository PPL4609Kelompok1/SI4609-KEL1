@extends('layouts.app')

@section('content')
<div class="bg-gray-900 min-h-screen text-white p-6">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-center mb-6">Rankings</h1>

        <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg max-h-96 overflow-y-scroll">
            <div class="grid grid-cols-4 px-4 py-3 border-b border-gray-700 text-sm font-semibold bg-gray-700 sticky top-0">
                <div>Rank</div>
                <div>Avatar</div>
                <div>Name</div>
                <div>Total Rating</div>
            </div>

            @foreach ($ranked as $entry)
            <div class="grid grid-cols-4 px-4 py-2 items-center
                {{ $entry['name'] === '[username]' ? 'bg-yellow-500 text-black font-bold sticky bottom-0 z-10' : 'hover:bg-gray-700' }}">

                <div>
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

                <div>
                    <img src="{{ $entry['avatar'] }}" alt="avatar" class="w-10 h-10 rounded-full border-2 border-white">
                </div>

                <div>{{ $entry['name'] }}</div>

                <div class="font-mono">{{ $entry['score'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection