@extends('layouts.app')

@section('content')
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <form wire:submit.prevent="updateProfile">
            <div>
                <label>Nama</label>
                <input type="text" wire:model="name">
                @error('name') <span>{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Email</label>
                <input type="email" wire:model="email">
                @error('email') <span>{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Telepon</label>
                <input type="text" wire:model="phone">
            </div>

            <button type="submit">Simpan</button>
        </form>
    </div>
@endsection
