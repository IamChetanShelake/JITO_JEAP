<?php

namespace App\Http\Controllers;

use App\Models\ApexLeadership;
use Illuminate\Http\Request;

class ApexLeadershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = ApexLeadership::orderBy('created_at', 'desc')->get();
        return view('admin.apex.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.apex.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_panel.apex_leadership,email',
            'contact' => 'required|string|max:20',
            'status' => 'nullable|boolean',
            'show_hide' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;
        $validated['show_hide'] = $request->has('show_hide') ? 1 : 0;

        ApexLeadership::create($validated);

        return redirect()->route('admin.apex.index')
            ->with('success', 'Member added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(ApexLeadership $apex)
    {
        return view('admin.apex.show', compact('apex'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApexLeadership $apex)
    {
        return view('admin.apex.edit', compact('apex'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ApexLeadership $apex)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_panel.apex_leadership,email,' . $apex->id,
            'contact' => 'required|string|max:20',
            'status' => 'nullable|boolean',
            'show_hide' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;
        $validated['show_hide'] = $request->has('show_hide') ? 1 : 0;

        $apex->update($validated);

        return redirect()->route('admin.apex.index')
            ->with('success', 'Member updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApexLeadership $apex)
    {
        $apex->delete();

        return redirect()->route('admin.apex.index')
            ->with('success', 'Member deleted successfully');
    }

    /**
     * Toggle show/hide status
     */
    public function toggleShowHide(ApexLeadership $apex)
    {
        $apex->update(['show_hide' => !$apex->show_hide]);
        return response()->json(['success' => true, 'show_hide' => $apex->show_hide]);
    }
}
