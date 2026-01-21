<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subcast;

class SubcastController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcasts = Subcast::all();
        return view('admin.subcast.index', compact('subcasts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subcast.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Subcast::create($request->only('name'));

        return redirect()->route('admin.subcasts.index')->with('success', 'Subcast created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subcast = Subcast::findOrFail($id);
        return view('admin.subcast.edit', compact('subcast'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subcast = Subcast::findOrFail($id);
        $subcast->update($request->only('name'));

        return redirect()->route('admin.subcasts.index')->with('success', 'Subcast updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subcast = Subcast::findOrFail($id);
        $subcast->delete();

        return redirect()->route('admin.subcasts.index')->with('success', 'Subcast deleted successfully');
    }
}
