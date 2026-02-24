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

            // 2. Family Details
            if ($request->has('family_detail')) {
                $donor->familyDetail()->update($request->family_detail);
            }

            // 3. Children Details
            // Note: If your model has 'protected $casts = ['children_details' => 'array']', 
            // you can pass the array directly. If not, use json_encode.
            if ($request->has('children')) {
                $donor->familyDetail()->update([
                    'children_details' => $request->children // Laravel casts handle this automatically
                ]);
            }

            // 4. Nominee Details
            if ($request->has('nominee_detail')) {
                $donor->nomineeDetail()->update($request->nominee_detail);
            }

            // 5. Professional Details
            if ($request->has('professional_detail')) {
                $donor->professionalDetail()->update($request->professional_detail);
            }

            // 6. Membership Options
            if ($request->has('membership_options') && $donor->membershipDetail) {
                // Explode string from textarea into array
                $options = array_filter(explode("\n", $request->membership_options));

                $donor->membershipDetail()->update([
                    'payment_options' => array_values($options) // Laravel casts handle this automatically
                ]);
            }





            // 7. File Uploads (FIXED)
            // We check if the 'document' relationship exists. If not, you might need to create it first.
            if ($donor->document) {

                if ($request->hasFile('pan_member_file')) {
                    // Delete old file if it exists to save space
                    if ($donor->document->pan_member_file && file_exists(public_path($donor->document->pan_member_file))) {
                        unlink(public_path($donor->document->pan_member_file));
                    }
                    // Store in 'public/uploads/documents' so asset() can find it
                    $file = $request->file('pan_member_file');
                    $filename = time() . '_pan_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads/documents'), $filename);
                    $path = 'uploads/documents/' . $filename;

                    $donor->document()->update(['pan_member_file' => $path]);
                }

                if ($request->hasFile('photo_file')) {
                    if ($donor->document->photo_file && file_exists(public_path($donor->document->photo_file))) {
                        unlink(public_path($donor->document->photo_file));
                    }
                    $file = $request->file('photo_file');
                    $filename = time() . '_photo_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads/documents'), $filename);
                    $path = 'uploads/documents/' . $filename;

                    $donor->document()->update(['photo_file' => $path]);
                }

                if ($request->hasFile('address_proof_file')) {
                    if ($donor->document->address_proof_file && file_exists(public_path($donor->document->address_proof_file))) {
                        unlink(public_path($donor->document->address_proof_file));
                    }
                    $file = $request->file('address_proof_file');
                    $filename = time() . '_address_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads/documents'), $filename);
                    $path = 'uploads/documents/' . $filename;

                    $donor->document()->update(['address_proof_file' => $path]);
                }
            }




            // 8. Payment Entries
            if ($request->has('payments') && $donor->paymentDetail) {
                $donor->paymentDetail()->update([
                    'payment_entries' => $request->payments // Laravel casts handle this automatically
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
}
