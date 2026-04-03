<?php

namespace App\Http\Controllers;

use App\Models\Accountant;
use Illuminate\Http\Request;

class AccountantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Accountant::orderBy('created_at', 'desc')->get();
        return view('admin.accountants.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.accountants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'email' => 'required|email|unique:admin_panel.accountants,email',
            'contact' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'status' => 'nullable|boolean',
            'show_hide' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? 1 : 0;
        $validated['show_hide'] = $request->has('show_hide') ? 1 : 0;
        $validated['role'] = 'accountant';
        $validated['password'] = bcrypt($validated['password']);

        Accountant::create($validated);

        return redirect()->route('admin.accountants.index')
            ->with('success', 'Accountant created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Accountant $accountant)
    {
        return view('admin.accountants.show', compact('accountant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Accountant $accountant)
    {
        return view('admin.accountants.edit', compact('accountant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Accountant $accountant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'email' => 'required|email|unique:admin_panel.accountants,email,' . $accountant->id,
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

        $accountant->update($validated);

        return redirect()->route('admin.accountants.index')
            ->with('success', 'Accountant updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Accountant $accountant)
    {
        $accountant->delete();

        return redirect()->route('admin.accountants.index')
            ->with('success', 'Accountant deleted successfully');
    }
}
