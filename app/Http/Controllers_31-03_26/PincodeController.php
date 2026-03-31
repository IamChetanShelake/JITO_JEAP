<?php

namespace App\Http\Controllers;

use App\Models\Pincode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PincodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pincodes = Pincode::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.pincodes.index', compact('pincodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pincodes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pincode' => 'required|string|max:10|unique:admin_panel.pincodes,pincode',
        ]);

        $pincode = Pincode::create($validated);

        // Fetch and cache coordinates
        try {
            $service = new \App\Services\PincodeService();
            $coords = $service->resolveCoordinates($validated['pincode']);


            $pincode->update([
                'latitude' => $coords['lat'],
                'longitude' => $coords['lng'],
                'cached_at' => now(),
            ]);

        } catch (\Exception $e) {
            // Log error but don't fail the creation
            Log::warning('Failed to fetch coordinates for pincode: ' . $validated['pincode'] . ' - ' . $e->getMessage());
        }

        return redirect()->route('admin.pincodes.index')
            ->with('success', 'Pincode added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pincode $pincode)
    {
        return view('admin.pincodes.show', compact('pincode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pincode $pincode)
    {
        return view('admin.pincodes.edit', compact('pincode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pincode $pincode)
    {
        $validated = $request->validate([
            'pincode' => 'required|string|max:10|unique:admin_panel.pincodes,pincode,' . $pincode->id,
        ]);

        $oldPincode = $pincode->pincode;
        $pincode->update($validated);

        // If pincode changed, refetch coordinates
        if ($oldPincode !== $validated['pincode']) {
            try {
                $service = new \App\Services\PincodeService();
                $coords = $service->resolveCoordinates($validated['pincode']);

                $pincode->update([
                    'latitude' => $coords['lat'],
                    'longitude' => $coords['lng'],
                    'cached_at' => now(),
                ]);

            } catch (\Exception $e) {
                Log::warning('Failed to fetch coordinates for updated pincode: ' . $validated['pincode'] . ' - ' . $e->getMessage());
                // Clear old coordinates
                $pincode->update([
                    'latitude' => null,
                    'longitude' => null,
                    'cached_at' => null,
                ]);
            }
        }

        return redirect()->route('admin.pincodes.index')
            ->with('success', 'Pincode updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pincode $pincode)
    {
        $pincode->delete();

        return redirect()->route('admin.pincodes.index')
            ->with('success', 'Pincode deleted successfully');
    }
}
