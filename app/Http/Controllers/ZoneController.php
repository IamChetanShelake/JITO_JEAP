<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Display a listing of the zones.
     */
    public function index()
    {
        $zones = Zone::orderBy('created_at', 'desc')->get();
        return view('admin.zones.index', compact('zones'));
    }

    /**
     * Show the form for creating a new zone.
     */
    public function create()
    {
        return view('admin.zones.create');
    }

    /**
     * Store a newly created zone in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'zone_name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:admin_panel.zones,code',
            'state' => 'required|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        Zone::create($validated);

        return redirect()->route('admin.zones.index')
            ->with('success', 'Zone created successfully');
    }

    /**
     * Display the specified zone.
     */
    public function show(Zone $zone)
    {
        $zone->load('chapters');
        return view('admin.zones.show', compact('zone'));
    }

    /**
     * Show the form for editing the specified zone.
     */
    public function edit(Zone $zone)
    {
        return view('admin.zones.edit', compact('zone'));
    }

    /**
     * Update the specified zone in storage.
     */
    public function update(Request $request, Zone $zone)
    {
        $validated = $request->validate([
            'zone_name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:admin_panel.zones,code,' . $zone->id,
            'state' => 'required|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        $zone->update($validated);

        return redirect()->route('admin.zones.index')
            ->with('success', 'Zone updated successfully');
    }

    /**
     * Remove the specified zone from storage.
     */
    public function destroy(Zone $zone)
    {
        $zone->delete();

        return redirect()->route('admin.zones.index')
            ->with('success', 'Zone deleted successfully');
    }
}
