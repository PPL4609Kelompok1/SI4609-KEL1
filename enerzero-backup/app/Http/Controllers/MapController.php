<?php

namespace App\Http\Controllers;

use App\Models\Map;
use App\Services\ChargingStationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        try {
            $maps = Map::latest()->get();
            $stations = [];
            $stationStats = [
                'total' => 0,
                'available' => 0,
                'types' => []
            ];
            
            foreach ($maps as $map) {
                $nearbyStations = $this->chargingStationService->getNearbyStations(
                    $map->latitude,
                    $map->longitude,
                    20 // Search radius in KM
                );
                
                $stations[$map->id] = $nearbyStations;
                
                // Calculate statistics
                if (is_array($nearbyStations)) {
                    $stationStats['total'] += count($nearbyStations);
                    
                    foreach ($nearbyStations as $station) {
                        if (isset($station['Connections'])) {
                            foreach ($station['Connections'] as $connection) {
                                $type = $connection['ConnectionType']['Title'] ?? 'Unknown';
                                if (!isset($stationStats['types'][$type])) {
                                    $stationStats['types'][$type] = 0;
                                }
                                $stationStats['types'][$type]++;
                            }
                        }
                        
                        // Count available stations
                        $isAvailable = true;
                        if (isset($station['StatusType'])) {
                            $isAvailable = $station['StatusType']['IsOperational'] ?? true;
                        }
                        if ($isAvailable) {
                            $stationStats['available']++;
                        }
                    }
                }
            }

            return view('maps.index', compact('maps', 'stations', 'stationStats'));
        } catch (\Exception $e) {
            Log::error('Error in MapController@index', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return view('maps.index', [
                'maps' => [],
                'stations' => [],
                'stationStats' => [],
                'error' => 'Error loading map data. Please try again later.'
            ]);
        }
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
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
            ]);

            $map = Map::create($validated);

            // Get nearby stations for the new location
            $stations = $this->chargingStationService->getNearbyStations(
                $map->latitude,
                $map->longitude
            );

            return redirect()->route('maps.index')
                ->with('success', 'Location added successfully! Found ' . count($stations) . ' charging stations nearby.');
        } catch (\Exception $e) {
            Log::error('Error in MapController@store', [
                'message' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error saving location. Please try again.']);
        }
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
        $stations = $this->chargingStationService->getNearbyStations(
            $map->latitude,
            $map->longitude
        );

        return view('maps.edit', compact('map', 'stations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Map $map)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
            ]);

            $map->update($validated);

            return redirect()->route('maps.index')
                ->with('success', 'Location updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error in MapController@update', [
                'message' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error updating location. Please try again.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Map $map)
    {
        try {
            $map->delete();
            return redirect()->route('maps.index')
                ->with('success', 'Location deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error in MapController@destroy', [
                'message' => $e->getMessage(),
                'map_id' => $map->id
            ]);

            return redirect()->back()
                ->withErrors(['error' => 'Error deleting location. Please try again.']);
        }
    }

    /**
     * Get charging station details.
     */
    public function getStationDetails($id)
    {
        try {
            $station = $this->chargingStationService->getStationDetails($id);
            
            if (!$station) {
                return response()->json([
                    'error' => 'Station not found',
                    'message' => 'The requested charging station could not be found.'
                ], 404);
            }

            // Enhance station details with additional information
            $stationDetails = [
                'id' => $station['ID'],
                'name' => $station['AddressInfo']['Title'],
                'address' => [
                    'street' => $station['AddressInfo']['AddressLine1'],
                    'town' => $station['AddressInfo']['Town'],
                    'state' => $station['AddressInfo']['StateOrProvince'],
                    'country' => $station['AddressInfo']['Country']['Title'],
                    'coordinates' => [
                        'lat' => $station['AddressInfo']['Latitude'],
                        'lng' => $station['AddressInfo']['Longitude']
                    ]
                ],
                'connections' => collect($station['Connections'])->map(function($conn) {
                    return [
                        'type' => $conn['ConnectionType']['Title'],
                        'power' => $conn['PowerKW'] ? $conn['PowerKW'] . ' kW' : 'N/A',
                        'status' => $conn['StatusType']['Title'] ?? 'Unknown',
                        'isOperational' => $conn['StatusType']['IsOperational'] ?? true
                    ];
                })->toArray(),
                'operator' => [
                    'name' => $station['OperatorInfo']['Title'] ?? 'Unknown',
                    'contact' => $station['OperatorInfo']['PhoneNumber'] ?? null,
                    'website' => $station['OperatorInfo']['WebsiteURL'] ?? null
                ],
                'usage' => [
                    'isPayAtLocation' => $station['UsageType']['IsPayAtLocation'] ?? false,
                    'isMembershipRequired' => $station['UsageType']['IsMembershipRequired'] ?? false,
                    'isAccessKeyRequired' => $station['UsageType']['IsAccessKeyRequired'] ?? false
                ],
                'status' => [
                    'isOperational' => $station['StatusType']['IsOperational'] ?? true,
                    'title' => $station['StatusType']['Title'] ?? 'Unknown'
                ]
            ];

            return response()->json($stationDetails);
        } catch (\Exception $e) {
            Log::error('Error fetching station details', [
                'station_id' => $id,
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Error fetching station details',
                'message' => 'An error occurred while fetching the station details.'
            ], 500);
        }
    }
}
