<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calculator;
use Illuminate\Support\Facades\Auth;

class CalculatorController extends Controller
{
    public function index()
    {
        $username = Auth::user()->username;
        $usages = Calculator::where('username', $username)->get();

        $average = $usages->avg('total_kwh');
        $recommendation = $this->generateRecommendation($average);

        return view('calculator.index', compact('usages', 'average', 'recommendation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_name' => 'required|string',
            'power_watt' => 'required|numeric|min:1',
            'hours_per_day' => 'required|numeric|min:0',
            'days' => 'required|numeric|min:1',
        ]);

        $username = Auth::user()->username;

        $total_kwh = ($request->power_watt * $request->hours_per_day * $request->days) / 1000;
        $cost_estimate = $total_kwh * 1500; // Tarif listrik per kWh

        Calculator::create([
            'username' => $username,
            'device_name' => $request->device_name,
            'power_watt' => $request->power_watt,
            'hours_per_day' => $request->hours_per_day,
            'days' => $request->days,
            'total_kwh' => $total_kwh,
            'cost_estimate' => $cost_estimate,
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    private function generateRecommendation($average_kwh)
    {
        if ($average_kwh < 5) {
            return "Penggunaan energimu tergolong sangat hemat, pertahankan!";
        } elseif ($average_kwh < 15) {
            return "Penggunaan energi cukup baik. Tetap awasi penggunaan alat elektronik.";
        } else {
            return "Penggunaan energimu tinggi. Pertimbangkan untuk mengurangi durasi atau jumlah perangkat.";
        }
    }
}
