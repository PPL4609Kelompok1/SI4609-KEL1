@extends('layouts.app')
@section('title', 'Enerzero | Forum - Edit')

@section('content')
    <div class="bg-white p-4 rounded-lg shadow w-3/4 mx-auto">
        <h1 class="text-xl font-bold mb-4">Edit Forum</h1>
        <form method="POST" action="{{ route('forum.update', $forum->id) }}">
            @csrf
            @method('PUT')

            <input name="title" type="text" value="{{ $forum->title }}"
                class="w-full p-2 border rounded mb-2" required />

            <textarea name="description" class="w-full p-2 border rounded mb-2" required>{{ $forum->description }}</textarea>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>
@endsection
