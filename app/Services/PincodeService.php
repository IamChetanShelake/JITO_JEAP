<?php

namespace App\Services;

use App\Models\Pincode;
use App\Models\Chapter;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PincodeService
{
    /**
     * Resolve latitude & longitude for a pincode (cached).
     */
    public function resolveCoordinates(string $pincode): array
    {
        $cached = Pincode::where('pincode', $pincode)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->first();

        if ($cached) {
            return [
                'lat' => $cached->latitude,
                'lng' => $cached->longitude,
            ];
        }

        // Create pincode record if it doesn't exist
        $pincodeRecord = Pincode::firstOrCreate(['pincode' => $pincode]);

        $coords = $this->fetchFromNominatim($pincode);

        Pincode::updateOrCreate(
            ['pincode' => $pincode],
            [
                'latitude'  => $coords['lat'],
                'longitude' => $coords['lng'],
                'source'    => 'nominatim',
                'cached_at' => now(),
            ]
        );

        return $coords;
    }

    /**
     * Primary geo provider (free & reliable)
     */
    private function fetchFromNominatim(string $pincode): array
    {
        $response = Http::withHeaders([
            'User-Agent' => 'JITO-JEAP/1.0 (admin@yourdomain.com)',
        ])
        ->timeout(15)
        ->get('https://nominatim.openstreetmap.org/search', [
            'q' => "India {$pincode}",
            'format' => 'json',
            'limit' => 1,
            'countrycodes' => 'IN',
            'addressdetails' => 1, // Include address details
        ]);

        if (! $response->successful()) {
            throw new \Exception('Geocoding API failed');
        }

        $data = $response->json();

        if (empty($data[0]['lat']) || empty($data[0]['lon'])) {
            throw new \Exception('Invalid geocoding response');
        }

        // Extract state information
        $address = $data[0]['address'] ?? [];
        $state = $address['state'] ?? $address['state_district'] ?? null;

        return [
            'lat' => (float) $data[0]['lat'],
            'lng' => (float) $data[0]['lon'],
            'state' => $state,
        ];
    }

    /**
     * Resolve chapter with hierarchical logic: exact → same state → any state
     */
    public function resolveChapter(string $pincode): array
    {
        Log::info('resolveChapter called', ['pincode' => $pincode]);

        // 1. Check for exact pincode match
        Log::info('Checking for exact pincode match', ['pincode' => $pincode]);

        $exactQuery = Chapter::where(function ($query) use ($pincode) {
            $query->whereHas('pincodes', fn ($q) => $q->where('pincode', $pincode))
                  ->orWhere('pincode', $pincode) // Exact match
                  ->orWhere('pincode', 'like', $pincode . ',%') // Starts with pincode,
                  ->orWhere('pincode', 'like', '%,' . $pincode . ',%') // Contains ,pincode,
                  ->orWhere('pincode', 'like', '%,' . $pincode); // Ends with ,pincode
        })
        ->where('status', true)
        ->where('show_hide', true);

        Log::info('Exact match query SQL', ['sql' => $exactQuery->toSql(), 'bindings' => $exactQuery->getBindings()]);

        $exact = $exactQuery->first();

        Log::info('Exact match result', [
            'found' => $exact ? true : false,
            'chapter' => $exact ? $exact->chapter_name : null,
            'chapter_id' => $exact ? $exact->id : null,
            'pincode_column' => $exact ? $exact->pincode : null
        ]);

        if ($exact) {
            Log::info('Returning exact match', ['chapter' => $exact->chapter_name]);
            return [
                'chapter' => $exact,
                'assigned_by' => 'exact',
            ];
        }

        Log::info('No exact match found, proceeding to nearby search', ['pincode' => $pincode]);

        // 2. Try to geocode the user pincode and get state
        try {
            Log::info('Attempting to geocode user pincode: ' . $pincode);
            $userCoords = $this->fetchFromNominatim($pincode);
            $userState = $userCoords['state'];
            Log::info('User pincode geocoded successfully', [
                'coords' => ['lat' => $userCoords['lat'], 'lng' => $userCoords['lng']],
                'state' => $userState,
                'pincode' => $pincode
            ]);

            // 3. First try: Find nearest pincode within the same state
            if ($userState) {
                $nearestSameState = $this->findNearestPincodeInState(
                    $userCoords['lat'], $userCoords['lng'], $userState, $pincode
                );

                if ($nearestSameState) {
                    $chapter = Chapter::whereHas('pincodes', fn ($q) =>
                        $q->where('pincode', $nearestSameState['pincode'])
                    )
                    ->where('status', true)
                    ->where('show_hide', true)
                    ->first();

                    if ($chapter) {
                        Log::info('Found chapter in same state', [
                            'chapter' => $chapter->chapter_name,
                            'pincode' => $nearestSameState['pincode'],
                            'state' => $userState
                        ]);

                        return [
                            'chapter' => $chapter,
                            'assigned_by' => 'nearest_pincode_same_state',
                            'nearest_pincode' => $nearestSameState['pincode'],
                            'distance' => round($nearestSameState['distance'], 2),
                            'state' => $userState,
                        ];
                    }
                }
            }

            // 4. If no chapter found in same state, return null (no cross-state assignments)
            Log::info('No suitable chapter found within same state, not assigning cross-state chapter', [
                'user_state' => $userState,
                'pincode' => $pincode
            ]);

        } catch (\Exception $e) {
            Log::warning('Failed to geocode user pincode ' . $pincode . ': ' . $e->getMessage());
        }

        return [
            'chapter' => null,
            'assigned_by' => 'none',
        ];
    }
    /**
     * Find nearest pincode with coordinates
     */
    private function findNearestPincode(float $lat, float $lng, string $excludePincode = null): ?array
    {
        $maxRadius = 100; // km

        $query = DB::connection('admin_panel')
            ->table('pincodes')
            ->select('pincodes.pincode', 'pincodes.latitude', 'pincodes.longitude')
            ->selectRaw(
                '(6371 * acos(
                    cos(radians(?)) * cos(radians(pincodes.latitude)) *
                    cos(radians(pincodes.longitude) - radians(?)) +
                    sin(radians(?)) * sin(radians(pincodes.latitude))
                )) AS distance',
                [$lat, $lng, $lat]
            )
            ->whereNotNull('pincodes.latitude')
            ->whereNotNull('pincodes.longitude');

        // Exclude the user's own pincode if specified
        if ($excludePincode) {
            $query->where('pincodes.pincode', '!=', $excludePincode);
        }

        $query->having('distance', '<=', $maxRadius);

        $result = $query->orderBy('distance')
            ->limit(1)
            ->first();

        return $result ? [
            'pincode' => $result->pincode,
            'distance' => $result->distance,
            'latitude' => $result->latitude,
            'longitude' => $result->longitude,
        ] : null;
    }

    /**
     * Find nearest pincode within the same state
     */
    private function findNearestPincodeInState(float $lat, float $lng, string $userState, string $excludePincode = null): ?array
    {
        $maxRadius = 100; // km

        $query = DB::connection('admin_panel')
            ->table('pincodes')
            ->join('chapter_pincodes', 'chapter_pincodes.pincode_id', '=', 'pincodes.id')
            ->join('chapters', 'chapters.id', '=', 'chapter_pincodes.chapter_id')
            ->select('pincodes.pincode', 'pincodes.latitude', 'pincodes.longitude', 'chapters.state')
            ->selectRaw(
                '(6371 * acos(
                    cos(radians(?)) * cos(radians(pincodes.latitude)) *
                    cos(radians(pincodes.longitude) - radians(?)) +
                    sin(radians(?)) * sin(radians(pincodes.latitude))
                )) AS distance',
                [$lat, $lng, $lat]
            )
            ->whereNotNull('pincodes.latitude')
            ->whereNotNull('pincodes.longitude')
            ->where('chapters.status', true)
            ->where('chapters.show_hide', true);

        // Match state (case-insensitive)
        $query->whereRaw('LOWER(chapters.state) = LOWER(?)', [$userState]);

        // Exclude the user's own pincode if specified
        if ($excludePincode) {
            $query->where('pincodes.pincode', '!=', $excludePincode);
        }

        $query->having('distance', '<=', $maxRadius);

        $result = $query->orderBy('distance')
            ->limit(1)
            ->first();

        return $result ? [
            'pincode' => $result->pincode,
            'distance' => $result->distance,
            'latitude' => $result->latitude,
            'longitude' => $result->longitude,
            'state' => $result->state,
        ] : null;
    }

    private function findNearestChapterSQL(float $lat, float $lng): ?Chapter
    {
        $maxRadius = 100; // km

        return Chapter::select('chapters.*')
            ->join('chapter_pincodes', 'chapter_pincodes.chapter_id', '=', 'chapters.id')
            ->join('pincodes', 'pincodes.id', '=', 'chapter_pincodes.pincode_id')
            ->selectRaw(
                '(6371 * acos(
                    cos(radians(?)) * cos(radians(pincodes.latitude)) *
                    cos(radians(pincodes.longitude) - radians(?)) +
                    sin(radians(?)) * sin(radians(pincodes.latitude))
                )) AS distance',
                [$lat, $lng, $lat]
            )
            ->whereNotNull('pincodes.latitude')
            ->whereNotNull('pincodes.longitude')
            ->where('chapters.status', true)
            ->where('chapters.show_hide', true)
            ->having('distance', '<=', $maxRadius)
            ->orderBy('distance')
            ->limit(1)
            ->first();
    }

}
