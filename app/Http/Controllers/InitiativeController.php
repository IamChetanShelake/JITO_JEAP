<?php

namespace App\Http\Controllers;

use App\Models\Initiative;
use Illuminate\Http\Request;

class InitiativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $initiatives = Initiative::orderBy('created_at', 'desc')->get();
        return view('admin.initiatives.index', compact('initiatives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.initiatives.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'initiative_leader' => 'required|string|max:255',
            'initiative_name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_panel.initiatives,email',
            'contact' => 'required|string|max:20',
            'status' => 'nullable|boolean',
            'show_hide' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;
        $validated['show_hide'] = $request->has('show_hide') ? 1 : 0;

        Initiative::create($validated);

        return redirect()->route('admin.initiatives.index')
            ->with('success', 'Initiative added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Initiative $initiative)
    {
        return view('admin.initiatives.show', compact('initiative'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Initiative $initiative)
    {
        return view('admin.initiatives.edit', compact('initiative'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Initiative $initiative)
    {
        $validated = $request->validate([
            'initiative_leader' => 'required|string|max:255',
            'initiative_name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_panel.initiatives,email,' . $initiative->id,
            'contact' => 'required|string|max:20',
            'status' => 'nullable|boolean',
            'show_hide' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;
        $validated['show_hide'] = $request->has('show_hide') ? 1 : 0;

        $initiative->update($validated);

        return redirect()->route('admin.initiatives.index')
            ->with('success', 'Initiative updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Initiative $initiative)
    {
        $initiative->delete();

        return redirect()->route('admin.initiatives.index')
            ->with('success', 'Initiative deleted successfully');
    }
}
