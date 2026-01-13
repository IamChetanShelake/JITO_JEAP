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
            ]);

        if (! $response->successful()) {
            throw new \Exception('Geocoding API failed');
        }

        $data = $response->json();

        if (empty($data[0]['lat']) || empty($data[0]['lon'])) {
            throw new \Exception('Invalid geocoding response');
        }

        return [
            'lat' => (float) $data[0]['lat'],
            'lng' => (float) $data[0]['lon'],
        ];
    }

    /**
     * Resolve chapter: exact match → nearest pincode → nearest chapter
     */
    public function resolveChapter(string $pincode): array
    {
        // 1. Check for exact pincode match
        $exact = Chapter::whereHas(
            'pincodes',
            fn($q) =>
            $q->where('pincode', $pincode)
        )
            ->where('status', true)
            ->where('show_hide', true)
            ->with('zone')
            ->first();

        if ($exact) {
            return [
                'chapter' => $exact,
                'assigned_by' => 'exact',
            ];
        }

        // 2. Try to geocode the user pincode
        try {
            Log::info('Attempting to geocode user pincode: ' . $pincode);
            $userCoords = $this->resolveCoordinates($pincode);
            Log::info('User pincode geocoded successfully', ['coords' => $userCoords, 'pincode' => $pincode]);

            // 3. Find nearest pincode in our database (excluding user's own pincode)
            $nearestPincodeData = $this->findNearestPincode($userCoords['lat'], $userCoords['lng'], $pincode);
            Log::info('Nearest pincode search result', ['nearest' => $nearestPincodeData, 'user_coords' => $userCoords]);

            if ($nearestPincodeData) {
                // 4. Get chapter associated with nearest pincode
                $chapter = Chapter::whereHas(
                    'pincodes',
                    fn($q) =>
                    $q->where('pincode', $nearestPincodeData['pincode'])
                )
                    ->where('status', true)
                    ->where('show_hide', true)
                    ->with('zone')
                    ->first();

                if ($chapter) {
                    return [
                        'chapter' => $chapter,
                        'assigned_by' => 'nearest_pincode',
                        'nearest_pincode' => $nearestPincodeData['pincode'],
                        'distance' => round($nearestPincodeData['distance'], 2),
                    ];
                }
            }
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

    private function findNearestChapterSQL(float $lat, float $lng): ?Chapter
    {
        $maxRadius = 100; // km

        return Chapter::select('chapters.*')
            ->join('chapter_pincodes', 'chapter_pincodes.chapter_id', '=', 'chapters.id')
            ->join('pincodes', 'pincodes.pincode', '=', 'chapter_pincodes.pincode')
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
