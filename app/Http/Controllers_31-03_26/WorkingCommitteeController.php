<?php

namespace App\Http\Controllers;

use App\Models\WorkingCommittee;
use Illuminate\Http\Request;

class WorkingCommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = WorkingCommittee::orderBy('created_at', 'desc')->get();
        return view('admin.committee.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.committee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_panel.working_committee,email',
            'contact' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'status' => 'nullable|boolean',
            'show_hide' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;
        $validated['show_hide'] = $request->has('show_hide') ? 1 : 0;
        $validated['role'] = 'working-committee';
        $validated['password'] = bcrypt($validated['password']);

        WorkingCommittee::create($validated);

        return redirect()->route('admin.committee.index')
            ->with('success', 'Committee member added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkingCommittee $committee)
    {
        return view('admin.committee.show', compact('committee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkingCommittee $committee)
    {
        return view('admin.committee.edit', compact('committee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkingCommittee $committee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_panel.working_committee,email,' . $committee->id,
            'contact' => 'required|string|max:20',
            'password' => 'nullable|string|min:8',
            'status' => 'nullable|boolean',
            'show_hide' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;
        $validated['show_hide'] = $request->has('show_hide') ? 1 : 0;

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $committee->update($validated);

        return redirect()->route('admin.committee.index')
            ->with('success', 'Committee member updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkingCommittee $committee)
    {
        $committee->delete();

        return redirect()->route('admin.committee.index')
            ->with('success', 'Committee member deleted successfully');
    }
}
