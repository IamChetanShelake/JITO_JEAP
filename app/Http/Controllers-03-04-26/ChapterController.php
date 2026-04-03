<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Zone;
use App\Models\Pincode;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chapters = Chapter::with('zone')->orderBy('created_at', 'desc')->get();
        return view('admin.chapters.index', compact('chapters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $zones = Zone::where('status', true)->get();
        $pincodes = Pincode::orderBy('pincode')->get();
        return view('admin.chapters.create', compact('zones', 'pincodes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'zone_id' => 'required|exists:admin_panel.zones,id',
            'chapter_head' => 'required|string|max:255',
            'chapter_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'pincodes' => 'required|array|min:1',
            'pincodes.*' => 'required|string|max:20',
            'state' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_panel.chapters,email',
            'contact' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'status' => 'nullable|boolean',
            'show_hide' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;
        $validated['show_hide'] = $request->has('show_hide') ? 1 : 0;
        $validated['role'] = 'chapter';
        $validated['password'] = bcrypt($validated['password']);

        // Store pincodes as comma-separated string for backward compatibility
        $pincodesArray = $validated['pincodes'];
        $validated['pincode'] = implode(',', $pincodesArray);

        $chapter = Chapter::create($validated);

        // Attach pincodes to pivot table and ensure coordinates are cached
        foreach ($pincodesArray as $pincodeStr) {
            $pincode = \App\Models\Pincode::firstOrCreate(['pincode' => $pincodeStr]);

            // Ensure coordinates are cached for new pincodes
            if (!$pincode->latitude || !$pincode->longitude) {
                try {
                    $service = new \App\Services\PincodeService();
                    $coords = $service->resolveCoordinates($pincodeStr);

                    $pincode->update([
                        'latitude' => $coords['lat'],
                        'longitude' => $coords['lng'],
                        'cached_at' => now(),
                    ]);

                    \Illuminate\Support\Facades\Log::info('Coordinates cached for pincode from chapter: ' . $pincodeStr);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::warning('Failed to cache coordinates for pincode from chapter: ' . $pincodeStr . ' - ' . $e->getMessage());
                }
            }

            $chapter->pincodes()->attach($pincode->id);
        }

        return redirect()->route('admin.chapters.index')
            ->with('success', 'Chapter added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Chapter $chapter)
    {
        $chapter->load('zone');
        return view('admin.chapters.show', compact('chapter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chapter $chapter)
    {
        $zones = Zone::where('status', true)->get();
        $pincodes = Pincode::orderBy('pincode')->get();
        return view('admin.chapters.edit', compact('chapter', 'zones', 'pincodes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chapter $chapter)
    {
        $validated = $request->validate([
            'zone_id' => 'required|exists:admin_panel.zones,id',
            'chapter_head' => 'required|string|max:255',
            'chapter_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'pincodes' => 'required|array|min:1',
            'pincodes.*' => 'required|string|max:20',
            'state' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_panel.chapters,email,' . $chapter->id,
            'contact' => 'required|string|max:20',
            'password' => 'nullable|string|min:8',
            'status' => 'nullable|boolean',
            'show_hide' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;
        $validated['show_hide'] = $request->has('show_hide') ? 1 : 0;

        // Store pincodes as comma-separated string for backward compatibility
        $pincodesArray = $validated['pincodes'];
        $validated['pincode'] = implode(',', $pincodesArray);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $chapter->update($validated);

        // Sync pincodes and ensure coordinates are cached
        $pincodeIds = [];
        foreach ($pincodesArray as $pincodeStr) {
            $pincode = \App\Models\Pincode::firstOrCreate(['pincode' => $pincodeStr]);

            // Ensure coordinates are cached for new pincodes
            if (!$pincode->latitude || !$pincode->longitude) {
                try {
                    $service = new \App\Services\PincodeService();
                    $coords = $service->resolveCoordinates($pincodeStr);

                    $pincode->update([
                        'latitude' => $coords['lat'],
                        'longitude' => $coords['lng'],
                        'cached_at' => now(),
                    ]);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::warning('Failed to cache coordinates for updated pincode: ' . $pincodeStr . ' - ' . $e->getMessage());
                }
            }

            $pincodeIds[] = $pincode->id;
        }
        $chapter->pincodes()->sync($pincodeIds);

        return redirect()->route('admin.chapters.index')
            ->with('success', 'Chapter updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chapter $chapter)
    {
        $chapter->delete();

        return redirect()->route('admin.chapters.index')
            ->with('success', 'Chapter deleted successfully');
    }
}
