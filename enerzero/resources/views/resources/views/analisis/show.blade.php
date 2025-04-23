@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Analisis Energi</h1>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Periode: {{ $data->periode }}</h5>
            <p class="card-text"><strong>Penggunaan Listrik:</strong> {{ $data->penggunaan_listrik }} kWh</p>
            <p class="card-text"><strong>Penggunaan Air:</strong> {{ $data->penggunaan_air }} m³</p>
            <p class="card-text"><strong>Penggunaan Gas:</strong> {{ $data->penggunaan_gas }} m³</p>
            <p class="card-text"><strong>Total Energi:</strong> {{ $data->total_energi }} satuan</p>
            <p class="card-text"><strong>Saran:</strong> {{ $data->saran }}</p>
        </div>
    </div>

    <a href="{{ route('analisis.index') }}" class="btn btn-secondary mt-3">Kembali ke daftar analisis</a>
</div>
@endsection
