<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; 
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

    // Fix: Check if it's already an array, otherwise decode it
    $children = [];
    if (!empty($donor->familyDetail?->children_details)) {
        $children = is_array($donor->familyDetail->children_details) 
            ? $donor->familyDetail->children_details 
            : json_decode($donor->familyDetail->children_details, true);
    }

    $paymentOptions = [];
    if (!empty($donor->membershipDetail?->payment_options)) {
        $paymentOptions = is_array($donor->membershipDetail->payment_options)
            ? $donor->membershipDetail->payment_options
            : json_decode($donor->membershipDetail->payment_options, true);
    }

    $paymentEntries = [];
    if (!empty($donor->paymentDetail?->payment_entries)) {
        $paymentEntries = is_array($donor->paymentDetail->payment_entries)
            ? $donor->paymentDetail->payment_entries
            : json_decode($donor->paymentDetail->payment_entries, true);
    }
    
    // Ensure they are valid arrays (handle potential null/invalid JSON)
    $children = $children ?: [];
    $paymentOptions = $paymentOptions ?: [];
    $paymentEntries = $paymentEntries ?: [];

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

    /**
     * Handle detailed donor application update.
     */
   public function updatedonor(Request $request, Donor $donor)
{
    $request->validate([
        'personal_detail.email_id_1' => 'required|email',
    ]);

    try {
        DB::beginTransaction();

        // 1. Personal Details
        if ($request->has('personal_detail')) {
            $donor->personalDetail()->update($request->personal_detail);
        }

        // 2. Family Details & Children (Merged for efficiency)
        if ($request->has('family_detail') || $request->has('children')) {
            $familyData = $request->input('family_detail', []);
            
            // CRITICAL: This saves the children array into the 'children_details' JSON column
            if ($request->has('children')) {
                $familyData['children_details'] = $request->children;
            }

            // Use updateOrCreate to ensure record exists
            $donor->familyDetail()->updateOrCreate(
                ['donor_id' => $donor->id], // Match condition
                $familyData // Data to update
            );
        }

        // 3. Nominee Details
        if ($request->has('nominee_detail')) {
            $donor->nomineeDetail()->updateOrCreate(
                ['donor_id' => $donor->id],
                $request->nominee_detail
            );
        }

        // 4. Professional Details
        if ($request->has('professional_detail')) {
            $donor->professionalDetail()->updateOrCreate(
                ['donor_id' => $donor->id],
                $request->professional_detail
            );
        }

        // 5. Membership Options
        if ($request->has('membership_options') && $donor->membershipDetail) {
            $options = array_filter(explode("\n", $request->membership_options));
            $donor->membershipDetail()->update([
                'payment_options' => array_values($options)
            ]);
        }

        // 6. Documents Upload
        if ($donor->document) {
            $files = [
                'pan_member_file',
                'photo_file',
                'address_proof_file',
                'pan_donor_file',
                'authorization_letter_file'
            ];

            foreach ($files as $fileInputName) {
                if ($request->hasFile($fileInputName)) {
                    // Delete old file
                    $existingFile = $donor->document->{$fileInputName};
                    if ($existingFile && file_exists(public_path($existingFile))) {
                        unlink(public_path($existingFile));
                    }

                    // Upload new file
                    $file = $request->file($fileInputName);
                    $filename = time() . '_' . $fileInputName . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/documents'), $filename);
                    
                    // Update specific column
                    $donor->document()->update([$fileInputName => 'uploads/documents/' . $filename]);
                }
            }
        }

        // 7. Payment Entries
        if ($request->has('payments') && $donor->paymentDetail) {
            $donor->paymentDetail()->update([
                'payment_entries' => $request->payments
            ]);
        }

        DB::commit();

        $step = $request->input('current_step', 1);
        return redirect()
            ->route('admin.donors.dashboard.show', ['donor' => $donor->id, 'step' => $step])
            ->with('success', 'Donor Application updated successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Error updating donor: ' . $e->getMessage());
    }
}
}