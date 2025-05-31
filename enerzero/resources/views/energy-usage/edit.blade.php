@extends('layouts.app')

@section('content')
    <h1>Edit Energy Usage Report</h1>
    <form method="POST" action="{{ route('reports.update', $report->id) }}">
        @csrf @method('PUT')
        <label>Month:</label>
        <input type="text" name="month" value="{{ $report->month }}" required>

        <label>Usage (kWh):</label>
        <input type="number" name="usage" value="{{ $report->usage }}" required>

        <button type="submit">Update</button>
    </form>
@endsection
