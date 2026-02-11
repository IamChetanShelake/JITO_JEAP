<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DonorController extends Controller
{
    public function dashboard()
    {
        $donors = Donor::with([
            'personalDetail',
            'familyDetail',
            'nomineeDetail',
            'membershipDetail',
            'professionalDetail',
            'document',
            'paymentDetail',
        ])->orderByDesc('id')->get();

        $donors = $donors->filter(function ($donor) {
            return $donor->personalDetail
                || $donor->familyDetail
                || $donor->nomineeDetail
                || $donor->membershipDetail
                || $donor->professionalDetail
                || $donor->document
                || $donor->paymentDetail
                || $donor->submit_status === 'completed';
        });

        return view('admin.donors.dashboard', compact('donors'));
    }

    public function dashboardShow(Donor $donor)
    {
        $donor->load([
            'personalDetail',
            'familyDetail',
            'nomineeDetail',
            'membershipDetail',
            'professionalDetail',
            'document',
            'paymentDetail',
        ]);

        $children = [];
        if (!empty($donor->familyDetail?->children_details)) {
            $children = json_decode($donor->familyDetail->children_details, true) ?: [];
        }

        $paymentOptions = [];
        if (!empty($donor->membershipDetail?->payment_options)) {
            $paymentOptions = json_decode($donor->membershipDetail->payment_options, true) ?: [];
        }

        $paymentEntries = [];
        if (!empty($donor->paymentDetail?->payment_entries)) {
            $paymentEntries = json_decode($donor->paymentDetail->payment_entries, true) ?: [];
        }

        return view('admin.donors.dashboard_show', compact('donor', 'children', 'paymentOptions', 'paymentEntries'));
    }

    public function index()
    {
        $donors = Donor::orderBy('name')->get();

        return view('admin.donors.index', compact('donors'));
    }

    public function create()
    {
        return view('admin.donors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admin_panel.donors,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Donor::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.donors.index')->with('success', 'Donor created successfully.');
    }

    public function show(Donor $donor)
    {
        return view('admin.donors.show', compact('donor'));
    }

    public function edit(Donor $donor)
    {
        return view('admin.donors.edit', compact('donor'));
    }

    public function update(Request $request, Donor $donor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admin_panel.donors,email,' . $donor->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $donor->update($updateData);

        return redirect()->route('admin.donors.index')->with('success', 'Donor updated successfully.');
    }

    public function destroy(Donor $donor)
    {
        $donor->delete();

        return redirect()->route('admin.donors.index')->with('success', 'Donor deleted successfully.');
    }
}
