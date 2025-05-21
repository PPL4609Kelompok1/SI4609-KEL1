<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class EnergyUsageReportController extends Controller
{
    // Show all reports
    public function index()
    {
        $reports = Report::all();

        // Ambil 2 data terakhir untuk perbandingan
        $latest = $reports->sortByDesc('id')->take(2);
        $current = $latest->first()->usage ?? 0;
        $previous = $latest->skip(1)->first()->usage ?? 0;

        $percentageChange = $previous ? number_format((($current - $previous) / $previous) * 100, 2) : 0;
        $trend = $current >= $previous ? 'increase' : 'decrease';

        $comparisonData = [
            'current_month' => $current,
            'previous_month' => $previous,
            'percentage_change' => $percentageChange,
            'trend' => $trend
        ];

        // Kelompokkan data usage per bulan
        $monthlyUsage = $reports->groupBy('month')->map(function ($group) {
            return $group->sum('usage');
        });

        return view('energy-usage.report', compact('reports', 'comparisonData', 'monthlyUsage'));
    }

    // Form create
    public function create()
    {
        return view('energy-usage.create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'month' => 'required|string',
            'usage' => 'required|integer',
        ]);

        Report::create($request->only(['month', 'usage']));

        return redirect()->route('energy.index')->with('success', 'Data added successfully!');
    }

    // Edit data
    public function edit($id)
    {
        $report = Report::findOrFail($id);
        return view('energy-usage.edit', compact('report'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'month' => 'required|string',
            'usage' => 'required|integer',
        ]);

        $report = Report::findOrFail($id);
        $report->update($request->only(['month', 'usage']));

        return redirect()->route('energy.index')->with('success', 'Data updated successfully!');
    }

    // Hapus data
    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect()->route('energy.index')->with('success', 'Data deleted successfully!');
    }
}
