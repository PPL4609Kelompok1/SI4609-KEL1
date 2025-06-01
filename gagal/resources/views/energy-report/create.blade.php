@extends('layouts.app')

@section('title', 'Enerzzero | Energy Usage Report')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-green-700">Create Energy Usage Report</h1>

        <form method="POST" action="{{ route('energy.store') }}">
            @csrf

            <div class="mb-4">
                <label for="month" class="block font-semibold text-gray-700">Month:</label>
                <select id="month" name="month" class="w-full border border-gray-300 p-2 rounded mt-1" required>
                    <option value="">-- Select Month --</option>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="usage" class="block font-semibold text-gray-700">Usage (kWh):</label>
                <input type="number" id="usage" name="usage" class="w-full border border-gray-300 p-2 rounded mt-1" required>
            </div>

            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                Save
            </button>
        </form>
    </div>
@endsection

