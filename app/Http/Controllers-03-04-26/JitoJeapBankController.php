<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JitoJeapBank;

class JitoJeapBankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jitoJeapBanks = JitoJeapBank::all();
        return view('admin.jito-jeap-bank.index', compact('jitoJeapBanks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.jito-jeap-bank.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'account_name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'account_type' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'ifsc_code' => 'required|string|max:255',
        ]);

        JitoJeapBank::create($request->all());

        return redirect()->route('admin.jito-jeap-banks.index')->with('success', 'Bank details created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jitoJeapBank = JitoJeapBank::findOrFail($id);
        return view('admin.jito-jeap-bank.show', compact('jitoJeapBank'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jitoJeapBank = JitoJeapBank::findOrFail($id);
        return view('admin.jito-jeap-bank.edit', compact('jitoJeapBank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'account_name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'account_type' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'ifsc_code' => 'required|string|max:255',
        ]);

        $jitoJeapBank = JitoJeapBank::findOrFail($id);
        $jitoJeapBank->update($request->all());

        return redirect()->route('admin.jito-jeap-banks.index')->with('success', 'Bank details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jitoJeapBank = JitoJeapBank::findOrFail($id);
        $jitoJeapBank->delete();

        return redirect()->route('admin.jito-jeap-banks.index')->with('success', 'Bank details deleted successfully');
    }
}
