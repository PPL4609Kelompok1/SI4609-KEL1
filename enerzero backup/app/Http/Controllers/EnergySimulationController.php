<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnergySimulation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// We might need other models or services later, e.g., for electricity tariffs or user data.

class EnergySimulationController extends Controller
{
    /**
     * Display the energy simulation form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('energy_simulation.index');
    }

    /**
     * Calculate energy consumption and savings based on user input.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View // Or JSON response
     */
    public function calculate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_appliances' => 'required|array|min:1',
            'current_appliances.*.name' => 'required|string|max:255',
            'current_appliances.*.power' => 'required|numeric|min:0',
            'current_appliances.*.hours_per_day' => 'required|numeric|min:0|max:24',
            'current_appliances.*.days_per_week' => 'required|numeric|min:0|max:7',
            
            'changed_appliances' => 'required|array|min:1',
            'changed_appliances.*.name' => 'required|string|max:255',
            'changed_appliances.*.power' => 'required|numeric|min:0',
            'changed_appliances.*.hours_per_day' => 'required|numeric|min:0|max:24',
            'changed_appliances.*.days_per_week' => 'required|numeric|min:0|max:7',
            
            'electricity_tariff' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('energy.simulation.index')
                        ->withErrors($validator)
                        ->withInput();
        }

        $validatedData = $validator->validated();

        $tariff = (float) $validatedData['electricity_tariff'];
        // Approx days in a month for calculation (52 weeks / 12 months * 7 days/week for weekly input)
        // Or more simply, average days per month ~30.44. For weekly usage, it's hours/day * days/week * 4.33 weeks/month
        $weeksPerMonth = 52 / 12; // Approximately 4.333

        $calculateMonthlyKwh = function ($appliances) use ($weeksPerMonth) {
            $totalKwh = 0;
            foreach ($appliances as $appliance) {
                $powerKw = (float) $appliance['power'] / 1000;
                $hoursPerDay = (float) $appliance['hours_per_day'];
                $daysPerWeek = (float) $appliance['days_per_week'];
                // Monthly kWh = kW * hours/day * days/week * weeks/month
                $totalKwh += $powerKw * $hoursPerDay * $daysPerWeek * $weeksPerMonth;
            }
            return $totalKwh;
        };

        $energyBeforeKwh = $calculateMonthlyKwh($validatedData['current_appliances']);
        $energyAfterKwh = $calculateMonthlyKwh($validatedData['changed_appliances']);
        $energySavedKwh = $energyBeforeKwh - $energyAfterKwh;

        $costBefore = $energyBeforeKwh * $tariff;
        $costAfter = $energyAfterKwh * $tariff;
        $costSaved = $costBefore - $costAfter;

        $results = [
            'input_data' => $validatedData, // To pass back to the save form
            'energy_consumption_before_kwh' => $energyBeforeKwh,
            'energy_consumption_after_kwh' => $energyAfterKwh,
            'energy_saved_kwh' => $energySavedKwh,
            'cost_before' => $costBefore,
            'cost_after' => $costAfter,
            'cost_saved' => $costSaved,
            'electricity_tariff' => $tariff,
        ];

        return view('energy_simulation.results', compact('results'));
    }

    /**
     * Save simulation results.
     */
    public function save(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk menyimpan simulasi.');
        }

        $validator = Validator::make($request->all(), [
            'simulation_name' => 'nullable|string|max:255',
            'data_before' => 'required|json',
            'data_after' => 'required|json',
            'energy_consumption_before_kwh' => 'required|numeric',
            'energy_consumption_after_kwh' => 'required|numeric',
            'energy_saved_kwh' => 'required|numeric',
            'cost_before' => 'required|numeric',
            'cost_after' => 'required|numeric',
            'cost_saved' => 'required|numeric',
            'electricity_tariff' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            // This should ideally not happen if data comes from results page hidden fields correctly
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Gagal menyimpan simulasi. Data tidak valid.');
        }

        $validatedDataToSave = $validator->validated();

        EnergySimulation::create([
            'user_id' => Auth::user()->id,
            'simulation_name' => $validatedDataToSave['simulation_name'] ?? 'Simulasi '.now()->toDateTimeString(),
            'data_before' => json_decode($validatedDataToSave['data_before'], true), // Ensure it's an array for the JSON field
            'data_after' => json_decode($validatedDataToSave['data_after'], true),
            'energy_consumption_before_kwh' => $validatedDataToSave['energy_consumption_before_kwh'],
            'energy_consumption_after_kwh' => $validatedDataToSave['energy_consumption_after_kwh'],
            'energy_saved_kwh' => $validatedDataToSave['energy_saved_kwh'],
            'cost_before' => $validatedDataToSave['cost_before'],
            'cost_after' => $validatedDataToSave['cost_after'],
            'cost_saved' => $validatedDataToSave['cost_saved'],
            'electricity_tariff' => $validatedDataToSave['electricity_tariff'],
            'notes' => $validatedDataToSave['notes'] ?? null,
        ]);

        return redirect()->route('energy.simulation.history')->with('success', 'Simulasi berhasil disimpan!');
    }

    /**
     * Display the user's simulation history.
     *
     * @return \Illuminate\View\View
     */
    public function history()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk melihat riwayat simulasi.');
        }
        $simulations = EnergySimulation::where('user_id', Auth::user()->id)
                                      ->orderBy('created_at', 'desc')
                                      ->paginate(10); // Paginate for better performance
        
        // --- TEMPORARY DEBUGGING --- 
        // dd('User ID:', Auth::user()->id, 'Simulations Fetched:', $simulations);
        // --- END TEMPORARY DEBUGGING ---

        return view('energy_simulation.history', compact('simulations'));
    }

    /**
     * Display the details of a specific saved simulation.
     *
     * @param  \App\Models\EnergySimulation  $simulation
     * @return \Illuminate\View\View
     */
    public function showDetails(EnergySimulation $simulation)
    {
        // Authorize that the logged-in user owns this simulation
        if (Auth::user()->id !== $simulation->user_id) {
            // Or redirect with an error, or show a 403 Forbidden page
            return redirect()->route('energy.simulation.history')->with('error', 'Anda tidak diizinkan untuk melihat simulasi ini.');
        }

        // The $simulation model is already fetched by route model binding
        return view('energy_simulation.history_detail', compact('simulation'));
    }
} 