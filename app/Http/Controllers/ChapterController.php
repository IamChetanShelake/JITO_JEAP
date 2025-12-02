<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Zone;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    /**
     * Display a listing of the chapters.
     */
    public function index()
    {
        $chapters = Chapter::with('zone')->orderBy('created_at', 'desc')->get();
        return view('admin.chapters.index', compact('chapters'));
    }

    /**
     * Show the form for creating a new chapter.
     */
    public function create()
    {
        $zones = Zone::where('status', true)->get();
        return view('admin.chapters.create', compact('zones'));
    }

    /**
     * Store a newly created chapter in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'zone_id' => 'required|exists:admin_panel.zones,id',
            'chapter_name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:admin_panel.chapters,code',
            'city' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
            'state' => 'required|string|max:255',
            'chairman' => 'required|string|max:255',
            'contact_no' => 'required|string|max:20',
            'status' => 'nullable|boolean',
        ]);

        Chapter::create($validated);

        return redirect()->route('admin.chapters.index')
            ->with('success', 'Chapter created successfully');
    }

    /**
     * Display the specified chapter.
     */
    public function show(Chapter $chapter)
    {
        $chapter->load('zone');
        return view('admin.chapters.show', compact('chapter'));
    }

    /**
     * Show the form for editing the specified chapter.
     */
    public function edit(Chapter $chapter)
    {
        $zones = Zone::where('status', true)->get();
        return view('admin.chapters.edit', compact('chapter', 'zones'));
    }

    /**
     * Update the specified chapter in storage.
     */
    public function update(Request $request, Chapter $chapter)
    {
        $validated = $request->validate([
            'zone_id' => 'required|exists:admin_panel.zones,id',
            'chapter_name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:admin_panel.chapters,code,' . $chapter->id,
            'city' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
            'state' => 'required|string|max:255',
            'chairman' => 'required|string|max:255',
            'contact_no' => 'required|string|max:20',
            'status' => 'nullable|boolean',
        ]);

        $chapter->update($validated);

        return redirect()->route('admin.chapters.index')
            ->with('success', 'Chapter updated successfully');
    }

    /**
     * Remove the specified chapter from storage.
     */
    public function destroy(Chapter $chapter)
    {
        $chapter->delete();

        return redirect()->route('admin.chapters.index')
            ->with('success', 'Chapter deleted successfully');
    }
}
