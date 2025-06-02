@extends('layouts.app')


@section('content')
    <h1>Energy Usage Reports</h1>

    <a href="{{ route('energy.create') }}" class="btn btn-success">+ Add Report</a>

    <table>
        <thead>
            <tr>
                <th>Month</th>
                <th>Usage (kWh)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
                <tr>
                    <td>{{ $report->month }}</td>
                    <td>{{ $report->usage }}</td>
                    <td>
                        <a href="{{ route('energy.edit', $report->id) }}">Edit</a> |
                        <form action="{{ route('energy.destroy', $report->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
