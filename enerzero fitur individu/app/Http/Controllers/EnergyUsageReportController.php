<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class EnergyUsageReportController extends Controller
{
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

        // ==== Analysis Section ====

        $averageUsage = $monthlyUsage->avg();
        $usagePattern = 'No clear pattern detected';
        $areasOfConcern = [];

        if ($current > $averageUsage) {
            $usagePattern = 'Your energy consumption shows an increase compared to the average.';
        } elseif ($current < $averageUsage) {
            $usagePattern = 'Your energy consumption is below average this month.';
        } else {
            $usagePattern = 'Your energy consumption is stable compared to the average.';
        }

        foreach ($monthlyUsage as $month => $usage) {
            if ($usage > ($averageUsage * 1.5)) {
                $areasOfConcern[] = "High consumption detected in $month.";
            }
        }

        // Recommendations
        $recommendations = [
            'Consider using smart power strips to reduce standby power consumption.',
            'Adjust your thermostat settings during peak hours.',
            'Replace any remaining incandescent bulbs with LED alternatives.'
        ];

        if ($current > ($averageUsage * 1.5)) {
            $recommendations[] = 'Investigate appliances that might be consuming too much energy this month.';
        }

        $analysis = [
            'usage_pattern' => $usagePattern,
            'areas_of_concern' => $areasOfConcern,
            'recommendations' => $recommendations
        ];

        return view('energy-usage.report', compact('reports', 'comparisonData', 'monthlyUsage', 'analysis'));
    }

    public function create()
    {
        return view('energy-usage.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'month' => 'required|string',
            'usage' => 'required|integer',
        ]);

        Report::create($request->only(['month', 'usage']));

        return redirect()->route('energy.index')->with('success', 'Data added successfully!');
    }

    public function edit($id)
    {
        $report = Report::findOrFail($id);
        return view('energy-usage.edit', compact('report'));
    }

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

    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect()->route('energy.index')->with('success', 'Data deleted successfully!');
    }
}
