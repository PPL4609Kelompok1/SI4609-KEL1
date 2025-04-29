@extends('layouts.app')
@section('title', 'Enerzero | Forum Detail')

<!-- Main Content -->
@section('content')
    <!-- In show.blade.php, replace the existing edit/delete buttons section -->
    <div class="w-90/100 p-4 bg-white rounded-lg shadow mb-4">

        <!-- Title section with dropdown menu -->
        <div class="flex justify-between items-start mb-2">

            <!-- Grup panah dan judul -->
            <div class="flex items-center gap-x-2">
                <!-- Tombol Back -->
                <a href="{{ route('forum') }}" class="text-black hover:text-green-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M15 19l-7-7 7-7" />
                    </svg>
                </a>

                <!-- Judul -->
                <h1 class="text-xl font-bold text-black-800">{{ $forum->title }}</h1>
            </div>

            @if ($forum->username)
                <div class="relative" x-data="{ open: false }">

                    <!-- Three dots button -->
                    <button @click="open = !open" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                        <div class="py-1">
                            <a href="{{ route('forum.edit', $forum->id) }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                            <form method="POST" action="{{ route('forum.destroy', $forum->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100"
                                    onclick="return confirm('Yakin ingin menghapus forum ini?');">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="flex items-center mb-4">
            <img alt="User avatar" class="rounded-full mr-2" src="https://placehold.co/40x40" />
            <div>
                <p class="text-gray-900">{{ $forum->username }}</p>
                <p class="text-gray-500 text-xs">{{ $forum->created_at->diffForHumans() }}</p>
            </div>
        </div>

        <!-- Isi dari forum -->
        <p class="text-gray-700 whitespace-pre-line mb-6">{{ $forum->description }}</p>

        <!-- like function -->
        <form action="{{ route('forum.like', $forum->id) }}" method="POST" class="mb-2">
            @csrf
            <button type="submit" class="flex items-center gap-2 text-pink-600">
                ❤️ Like ({{ $forum->likes->count() }})
            </button>
        </form>

        <h2 class="text-lg font-semibold mb-1 mt-4">REPLY</h2>

        <!-- Form untuk reply -->
        <form method="POST" action="{{ route('forum.reply', $forum->id) }}" class="mb-2">
            @csrf
            <textarea name="reply" class="w-full p-2 border rounded mb-2" placeholder="Tulis balasan..." required></textarea>
            <div class='flex justify-end'>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-400">Kirim</button>
            </div>
        </form>
    </div>

    <div class="flex items-center gap-4 mb-2">
        <h1 class="font-semibold text-lg">
            REPLIES
        </h1>
        <div class="flex-grow h-1 bg-white"></div>
    </div>
    
    <!-- Daftar reply with avatars -->
    @foreach ($forum->replies as $reply)
        <div class="bg-gray-100 p-3 rounded-lg mb-4">
            <div class="flex items-start mb-2">
                <img alt="User avatar" class="rounded-full mr-2 w-10 h-10" src="https://placehold.co/40x40" />
                <div>
                    <p class="font-semibold">{{ $reply->username }}</p>
                    <p class="text-sm text-gray-600">{{ $reply->created_at->diffForHumans() }}</p>
                </div>
            </div>
            <p class='text-sm'>{{ $reply->reply }}</p>
        </div>
    @endforeach
@endsection
