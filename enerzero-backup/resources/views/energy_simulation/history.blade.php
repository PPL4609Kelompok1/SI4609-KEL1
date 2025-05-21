@extends('layouts.app')

@section('title', 'Riwayat Simulasi Hemat Energi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <header class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-green-900">Riwayat Simulasi Hemat Energi</h1>
            <p class="text-gray-600">Lihat kembali hasil simulasi yang telah Anda simpan.</p>
        </div>
        <a href="{{ route('energy.simulation.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-plus mr-2"></i> Buat Simulasi Baru
        </a>
    </header>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow-md">
        @if($simulations->total() == 0)
            <div class="text-center py-12">
                <i class="fas fa-folder-open text-5xl text-gray-400 mb-4"></i>
                <p class="text-gray-600 text-lg">Anda belum memiliki riwayat simulasi.</p>
                <p class="text-gray-500">Mulai <a href="{{ route('energy.simulation.index') }}" class="text-green-600 hover:underline">buat simulasi baru</a> untuk melihat hasilnya di sini.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nama Simulasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Energi Dihemat (kWh/bln)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Biaya Dihemat (Rp/bln)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($simulations as $simulation)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $simulation->simulation_name ?? 'Simulasi Tanpa Nama' }}
                                    @if($simulation->notes)
                                        <p class="text-xs text-gray-500">{{ Str::limit($simulation->notes, 50) }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $simulation->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $simulation->energy_saved_kwh > 0 ? 'text-green-600' : ($simulation->energy_saved_kwh < 0 ? 'text-red-600' : 'text-gray-700') }}">
                                    {{ number_format($simulation->energy_saved_kwh, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $simulation->cost_saved > 0 ? 'text-green-600' : ($simulation->cost_saved < 0 ? 'text-red-600' : 'text-gray-700') }}">
                                    Rp {{ number_format($simulation->cost_saved, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('energy.simulation.showDetails', $simulation) }}" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-eye mr-1"></i> Lihat Detail
                                    </a>
                                    {{-- Add Edit/Delete links here later if needed --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $simulations->links() }} 
            </div>
        @endif
    </div>
</div>
@endsection 