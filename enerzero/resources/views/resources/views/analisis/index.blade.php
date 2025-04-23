@extends('layouts.app')

@section('title', 'Analisis Energi')

@section('content')
    <h2 class="text-2xl font-semibold mb-6">Analisis Penggunaan Energi</h2>

    <a href="{{ route('laporan.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded mb-4 inline-block">+ Tambah Data</a>

    <table class="w-full bg-white rounded-lg shadow-md overflow-hidden">
        <thead class="bg-green-200 text-green-800">
            <tr>
                <th class="px-4 py-2 text-left">Tanggal Mulai</th>
                <th class="px-4 py-2 text-left">Tanggal Selesai</th>
                <th class="px-4 py-2 text-left">Total Daya</th>
                <th class="px-4 py-2 text-left">Periode</th>
                <th class="px-4 py-2 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporans as $laporan)
                <tr class="border-t hover:bg-green-50">
                    <td class="px-4 py-2">{{ $laporan->tanggal_mulai->format('d M Y') }}</td>
                    <td class="px-4 py-2">{{ $laporan->tanggal_selesai->format('d M Y') }}</td>
                    <td class="px-4 py-2">{{ $laporan->total_daya }} {{ $laporan->unit_pengukuran }}</td>
                    <td class="px-4 py-2 capitalize">{{ $laporan->periode }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('laporan.edit', $laporan->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus data ini?')" class="text-red-500 ml-2 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">Belum ada data analisis.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
