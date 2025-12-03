<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Zone;
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
        return view('admin.chapters.create', compact('zones'));
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
            'pincode' => 'required|string|max:20',
            'state' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_panel.chapters,email',
            'contact' => 'required|string|max:20',
            'status' => 'nullable|boolean',
            'show_hide' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;
        $validated['show_hide'] = $request->has('show_hide') ? 1 : 0;

        Chapter::create($validated);

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
        return view('admin.chapters.edit', compact('chapter', 'zones'));
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
            'pincode' => 'required|string|max:20',
            'state' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_panel.chapters,email,' . $chapter->id,
            'contact' => 'required|string|max:20',
            'status' => 'nullable|boolean',
            'show_hide' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;
        $validated['show_hide'] = $request->has('show_hide') ? 1 : 0;

        $chapter->update($validated);

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
