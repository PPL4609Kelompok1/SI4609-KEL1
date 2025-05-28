<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnergySimulation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Device;
// We might need other models or services later, e.g., for electricity tariffs or user data.

class EnergySimulationController extends Controller
{
    private $tariffGroups = [
        'R1' => [
            'name' => 'R1 - Rumah Tangga 450 VA',
            'tariff' => 415
        ],
        'R2' => [
            'name' => 'R2 - Rumah Tangga 900 VA',
            'tariff' => 605
        ],
        'R3' => [
            'name' => 'R3 - Rumah Tangga 1300 VA',
            'tariff' => 1444
        ],
        'R4' => [
            'name' => 'R4 - Rumah Tangga 2200 VA',
            'tariff' => 1444
        ],
        'B1' => [
            'name' => 'B1 - Bisnis 450 VA',
            'tariff' => 605
        ],
        'B2' => [
            'name' => 'B2 - Bisnis 900 VA',
            'tariff' => 1444
        ],
        'B3' => [
            'name' => 'B3 - Bisnis 1300 VA',
            'tariff' => 1444
        ]
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the energy simulation form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $user = Auth::user();
            $devices = $user->devices;
            $tariffGroups = $this->tariffGroups;
            return view('energy_simulation.index', compact('devices', 'tariffGroups'));
        } catch (\Exception $e) {
            \Log::error('Error in EnergySimulationController@index: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengambil data perangkat.');
        }
    }

    /**
     * Calculate energy consumption and savings based on user input.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View // Or JSON response
     */
    public function calculate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'current_devices' => 'required|array',
                'current_devices.*' => 'required|exists:user_devices,id',
                'current_hours' => 'required|array',
                'current_hours.*' => 'required|numeric|min:0|max:24',
                'current_days' => 'required|array',
                'current_days.*' => 'required|numeric|min:1|max:31',
                'changed_devices' => 'required|array',
                'changed_devices.*' => 'required|exists:user_devices,id',
                'changed_hours' => 'required|array',
                'changed_hours.*' => 'required|numeric|min:0|max:24',
                'changed_days' => 'required|array',
                'changed_days.*' => 'required|numeric|min:1|max:31',
                'tariff_group' => 'required|in:' . implode(',', array_keys($this->tariffGroups))
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $user = Auth::user();
            $tariffGroup = $this->tariffGroups[$request->tariff_group];
            $tariff = (float) $tariffGroup['tariff'];
            
            // Get devices using the relationship
            $currentDevices = $user->devices()->whereIn('id', $request->current_devices)->get();
            $changedDevices = $user->devices()->whereIn('id', $request->changed_devices)->get();

            // Approx days in a month for calculation (52 weeks / 12 months * 7 days/week for weekly input)
            $weeksPerMonth = 52 / 12; // Approximately 4.333

            // Calculate current consumption
            $currentConsumption = 0;
            $currentData = [];
            foreach ($currentDevices as $index => $device) {
                $hours = (float) $request->current_hours[$index];
                $days = (float) $request->current_days[$index];
                $powerKw = (float) $device->wattage / 1000;
                // Monthly kWh = kW * hours/day * days/week * weeks/month
                $consumption = $powerKw * $hours * $days * $weeksPerMonth;
                $currentConsumption += $consumption;
                $currentData[] = [
                    'device' => $device->name,
                    'wattage' => $device->wattage,
                    'hours' => $hours,
                    'days' => $days,
                    'consumption' => $consumption
                ];
            }

            // Calculate changed consumption
            $changedConsumption = 0;
            $changedData = [];
            foreach ($changedDevices as $index => $device) {
                $hours = (float) $request->changed_hours[$index];
                $days = (float) $request->changed_days[$index];
                $powerKw = (float) $device->wattage / 1000;
                // Monthly kWh = kW * hours/day * days/week * weeks/month
                $consumption = $powerKw * $hours * $days * $weeksPerMonth;
                $changedConsumption += $consumption;
                $changedData[] = [
                    'device' => $device->name,
                    'wattage' => $device->wattage,
                    'hours' => $hours,
                    'days' => $days,
                    'consumption' => $consumption
                ];
            }

            // Calculate savings
            $savings = $currentConsumption - $changedConsumption;
            $costSavings = $savings * $tariff;

            // Generate a better simulation name
            $simulationName = 'Simulasi Hemat Energi - ' . now()->format('Y-m-d H:i');

            // Save simulation result
            $simulation = EnergySimulation::create([
                'user_id' => $user->id,
                'simulation_name' => $simulationName,
                'data_before' => json_encode($currentData),
                'data_after' => json_encode($changedData),
                'energy_consumption_before_kwh' => $currentConsumption,
                'energy_consumption_after_kwh' => $changedConsumption,
                'energy_saved_kwh' => $savings,
                'cost_before' => $currentConsumption * $tariff,
                'cost_after' => $changedConsumption * $tariff,
                'cost_saved' => $costSavings,
                'electricity_tariff' => $tariff,
                'tariff_group' => $request->tariff_group
            ]);

            // Pass all necessary data to the view
            return view('energy_simulation.results', [
                'simulation' => $simulation,
                'currentDevices' => $currentDevices,
                'changedDevices' => $changedDevices,
                'currentHours' => $request->current_hours,
                'currentDays' => $request->current_days,
                'changedHours' => $request->changed_hours,
                'changedDays' => $request->changed_days,
                'tariffGroup' => $tariffGroup
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in EnergySimulationController@calculate: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menghitung simulasi: ' . $e->getMessage());
        }
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
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Gagal menyimpan simulasi. Data tidak valid.');
        }

        $validatedDataToSave = $validator->validated();

        // Generate a better simulation name if not provided
        $simulationName = $validatedDataToSave['simulation_name'] ?? 'Simulasi Hemat Energi - ' . now()->format('Y-m-d H:i');

        EnergySimulation::create([
            'user_id' => Auth::user()->id,
            'simulation_name' => $simulationName,
            'data_before' => json_decode($validatedDataToSave['data_before'], true),
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
        try {
            $user = Auth::user();
            $simulations = EnergySimulation::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10); // Use pagination instead of get()
            return view('energy_simulation.history', compact('simulations'));
        } catch (\Exception $e) {
            \Log::error('Error in EnergySimulationController@history: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengambil riwayat simulasi.');
        }
    }

    /**
     * Display the details of a specific saved simulation.
     *
     * @param  \App\Models\EnergySimulation  $simulation
     * @return \Illuminate\View\View
     */
    public function showDetails($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk melihat simulasi.');
        }

        $user = auth()->user();
        $simulation = EnergySimulation::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$simulation) {
            return redirect()->route('energy.simulation.history')
                ->with('error', 'Anda tidak diizinkan untuk melihat simulasi ini.');
        }

        $dataBefore = json_decode($simulation->data_before, true);
        $dataAfter = json_decode($simulation->data_after, true);

        return view('energy_simulation.history_detail', [
            'simulation' => $simulation,
            'dataBefore' => $dataBefore,
            'dataAfter' => $dataAfter
        ]);
    }

    /**
     * Delete a simulation.
     *
     * @param  \App\Models\EnergySimulation  $simulation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk menghapus simulasi.');
        }

        $user = auth()->user();
        $simulation = EnergySimulation::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$simulation) {
            return redirect()->route('energy.simulation.history')
                ->with('error', 'Anda tidak diizinkan untuk menghapus simulasi ini.');
        }

        $simulation->delete();

        return redirect()->route('energy.simulation.history')
            ->with('success', 'Simulasi berhasil dihapus.');
    }
} 