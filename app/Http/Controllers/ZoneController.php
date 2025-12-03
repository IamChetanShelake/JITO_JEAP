<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zones = Zone::orderBy('created_at', 'desc')->get();
        return view('admin.zones.index', compact('zones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.zones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'zone_head' => 'required|string|max:255',
            'zone_name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'state' => 'required|string|max:100',
            'email' => 'required|email|unique:admin_panel.zones,email',
            'contact' => 'required|string|max:20',
            'status' => 'nullable|boolean',
            'show_hide' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;
        $validated['show_hide'] = $request->has('show_hide') ? 1 : 0;

        Zone::create($validated);

        return redirect()->route('admin.zones.index')
            ->with('success', 'Zone added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Zone $zone)
    {
        return view('admin.zones.show', compact('zone'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zone $zone)
    {
        return view('admin.zones.edit', compact('zone'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Zone $zone)
    {
        $validated = $request->validate([
            'zone_head' => 'required|string|max:255',
            'zone_name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'state' => 'required|string|max:100',
            'email' => 'required|email|unique:admin_panel.zones,email,' . $zone->id,
            'contact' => 'required|string|max:20',
            'status' => 'nullable|boolean',
            'show_hide' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;
        $validated['show_hide'] = $request->has('show_hide') ? 1 : 0;

        $zone->update($validated);

        return redirect()->route('admin.zones.index')
            ->with('success', 'Zone updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zone $zone)
    {
        $zone->delete();

        return redirect()->route('admin.zones.index')
            ->with('success', 'Zone deleted successfully');
    }
}
