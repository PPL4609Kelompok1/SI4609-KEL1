<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ChargingStationService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.openchargemap.io/v3';

    public function __construct()
    {
        $this->apiKey = '76557557-2764-473b-8000-500f78b0e999';
    }

    public function getNearbyStations($latitude, $longitude, $distance = 10)
    {
        $cacheKey = "stations_{$latitude}_{$longitude}_{$distance}";
        
        return Cache::remember($cacheKey, now()->addHours(1), function () use ($latitude, $longitude, $distance) {
            try {
                $response = Http::get("{$this->baseUrl}/poi", [
                    'key' => $this->apiKey,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'distance' => $distance,
                    'distanceunit' => 'KM',
                    'maxresults' => 50,
                    'compact' => true,
                    'verbose' => false,
                    'includecomments' => false,
                    'includeconnectiontypes' => true,
                    'includeoperatorinfo' => true,
                    'includeaddressinfo' => true
                ]);

                if ($response->successful()) {
                    return $response->json();
                }

                Log::error('OpenChargeMap API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return [];
            } catch (\Exception $e) {
                Log::error('OpenChargeMap API Exception', [
                    'message' => $e->getMessage()
                ]);
                return [];
            }
        });
    }

    public function getStationDetails($id)
    {
        $cacheKey = "station_details_{$id}";
        
        return Cache::remember($cacheKey, now()->addHours(1), function () use ($id) {
            try {
                $response = Http::get("{$this->baseUrl}/poi/{$id}", [
                    'key' => $this->apiKey,
                    'compact' => true,
                    'verbose' => false,
                    'includecomments' => true,
                    'includeconnectiontypes' => true,
                    'includeoperatorinfo' => true,
                    'includeaddressinfo' => true
                ]);

                if ($response->successful()) {
                    return $response->json();
                }

                Log::error('OpenChargeMap API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return null;
            } catch (\Exception $e) {
                Log::error('OpenChargeMap API Exception', [
                    'message' => $e->getMessage()
                ]);
                return null;
            }
        });
    }
} 