@extends('layouts.dashboard')

@section('content')
    <h1>Create Energy Usage Report</h1>
    <form method="POST" action="{{ route('energy.store') }}">
        @csrf
        <label>Month:</label>
        <input type="text" name="month" required>

        <label>Usage (kWh):</label>
        <input type="number" name="usage" required>

        <button type="submit">Save</button>
    </form>
@endsectionz
