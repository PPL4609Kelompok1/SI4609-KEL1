<?php

namespace App\Http\Controllers;

use App\Models\Map;
use App\Services\ChargingStationService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MapController extends Controller
{
    protected $chargingStationService;

    public function __construct(ChargingStationService $chargingStationService)
    {
        $this->chargingStationService = $chargingStationService;
    }

    /**
     * Display a listing of the resource.
     * untuk display
     */
    public function index()
    {
        $maps = Map::all();
        $stations = [];
        
        // Get charging stations for each saved location
        foreach ($maps as $map) {
            $stations[$map->id] = $this->chargingStationService->getNearbyStations(
                $map->latitude,
                $map->longitude
            );
        }

        return view('maps.index', compact('maps', 'stations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('maps.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        Map::create($validated);

        return redirect()->route('maps.index')
            ->with('success', 'Location created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Map $map)
    {
        $stations = $this->chargingStationService->getNearbyStations(
            $map->latitude,
            $map->longitude
        );

        return view('maps.show', compact('map', 'stations'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Map $map)
    {
        return view('maps.edit', compact('map'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Map $map)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $map->update($validated);

        return redirect()->route('maps.index')
            ->with('success', 'Location updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Map $map)
    {
        $map->delete();

        return redirect()->route('maps.index')
            ->with('success', 'Location deleted successfully.');
    }

    /**
     * Get charging station details.
     */
    public function getStationDetails($id)
    {
        $station = $this->chargingStationService->getStationDetails($id);
        
        if (!$station) {
            return response()->json(['error' => 'Station not found'], 404);
        }

        return response()->json($station);
    }
}
