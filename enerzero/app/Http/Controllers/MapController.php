<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        return view('map.index');
    }

    public function favorites()
    {
        return view('map.favorites');
    }

    public function getChargingStations(Request $request)
    {
        try {
            $lat = $request->input('lat', -6.200000);
            $lng = $request->input('lng', 106.816666);

            $response = Http::get("https://api.openchargemap.io/v3/poi", [
                'output' => 'json',
                'latitude' => $lat,
                'longitude' => $lng,
                'distance' => 50,
                'distanceunit' => 'KM',
                'maxresults' => 100,
                'compact' => true,
                'verbose' => false,
                'key' => '26ca725b-c9ba-458a-b65a-83ba078ecf38',
            ]);

            if (!$response->successful()) {
                Log::error('OpenChargeMap API error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new \Exception('Failed to fetch charging stations data');
            }

            $data = $response->json();
            
            Log::info('OpenChargeMap API response', [
                'count' => count($data),
                'first_item' => isset($data[0]) ? $data[0]['ID'] : null
            ]);

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error fetching charging stations', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Failed to load charging stations data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getChargingStation($id)
    {
        try {
            $response = Http::get("https://api.openchargemap.io/v3/poi/{$id}", [
                'output' => 'json',
                'compact' => false,
                'verbose' => true,
                'key' => '26ca725b-c9ba-458a-b65a-83ba078ecf38',
            ]);

            if (!$response->successful()) {
                Log::error('OpenChargeMap API error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new \Exception('Failed to fetch station details');
            }

            $data = $response->json();
            if (is_array($data) && count($data) > 0) {
                $data = $data[0];
            }
            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error fetching station details', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Failed to load station details: ' . $e->getMessage()
            ], 500);
        }
    }
}
    