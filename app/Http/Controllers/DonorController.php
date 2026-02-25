<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\File;

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
     // Ensure this is imported at the top of your controller

  

public function updatedonor(Request $request, Donor $donor)
{
    $request->validate([
        'personal_detail.email_id_1' => 'required|email',
    ]);

    try {
        DB::beginTransaction();

        // ============================================================
        // 1. Personal Details (Text + Birth/Anniversary Photos)
        // ============================================================
        
        // Get existing personal detail record
        $personalDetail = $donor->personalDetail()->firstOrNew(['donor_id' => $donor->id]);
        
        // Start with the text data provided in the form
        $personalData = $request->input('personal_detail', []);

        // Define upload path
        $uploadPath = public_path('uploads/documents');
        if (!File::isDirectory($uploadPath)) {
            File::makeDirectory($uploadPath, 0777, true, true);
        }

        // --- A. Handle Birth Photos ---
        $currentBirthPhotos = $personalDetail->birth_photo ?? [];
        // Ensure it's an array (decode if stored as JSON string in DB without cast)
        if (is_string($currentBirthPhotos)) {
            $currentBirthPhotos = json_decode($currentBirthPhotos, true) ?? [];
        }
        if (!is_array($currentBirthPhotos)) $currentBirthPhotos = [];

        // 1. Handle Deletions
        if ($request->has('delete_birth_photo')) {
            foreach ($request->delete_birth_photo as $fileToDelete) {
                $key = array_search($fileToDelete, $currentBirthPhotos);
                if ($key !== false) {
                    // Delete from disk
                    $filePath = public_path($fileToDelete);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                    // Remove from array
                    unset($currentBirthPhotos[$key]);
                }
            }
            // Re-index array keys
            $currentBirthPhotos = array_values($currentBirthPhotos);
        }

        // 2. Handle New Uploads
        if ($request->hasFile('birth_photo')) {
            foreach ($request->file('birth_photo') as $file) {
                if ($file->isValid()) {
                    $filename = time() . '_birth_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move($uploadPath, $filename);
                    $currentBirthPhotos[] = 'uploads/documents/' . $filename;
                }
            }
        }
        
        // Save back to personal data array
        $personalData['birth_photo'] = $currentBirthPhotos;

        // --- B. Handle Anniversary Photos ---
        $currentAnnPhotos = $personalDetail->anniversary_photo ?? [];
        if (is_string($currentAnnPhotos)) {
            $currentAnnPhotos = json_decode($currentAnnPhotos, true) ?? [];
        }
        if (!is_array($currentAnnPhotos)) $currentAnnPhotos = [];

        // 1. Handle Deletions
        if ($request->has('delete_anniversary_photo')) {
            foreach ($request->delete_anniversary_photo as $fileToDelete) {
                $key = array_search($fileToDelete, $currentAnnPhotos);
                if ($key !== false) {
                    // Delete from disk
                    $filePath = public_path($fileToDelete);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                    // Remove from array
                    unset($currentAnnPhotos[$key]);
                }
            }
            $currentAnnPhotos = array_values($currentAnnPhotos);
        }

        // 2. Handle New Uploads
        if ($request->hasFile('anniversary_photo')) {
            foreach ($request->file('anniversary_photo') as $file) {
                if ($file->isValid()) {
                    $filename = time() . '_anniversary_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move($uploadPath, $filename);
                    $currentAnnPhotos[] = 'uploads/documents/' . $filename;
                }
            }
        }

        // Save back to personal data array
        $personalData['anniversary_photo'] = $currentAnnPhotos;

        // Update/Create Personal Detail Record
        $donor->personalDetail()->updateOrCreate(
            ['donor_id' => $donor->id],
            $personalData
        );

        // ============================================================
        // 2. Family Details & Children
        // ============================================================
        if ($request->has('family_detail') || $request->has('children')) {
            $familyData = $request->input('family_detail', []);
            if ($request->has('children')) {
                $familyData['children_details'] = json_encode($request->children);
            }
            $donor->familyDetail()->updateOrCreate(
                ['donor_id' => $donor->id],
                $familyData
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
        if ($request->has('membership_options')) {
            $options = array_filter(explode("\n", $request->membership_options));
            $donor->membershipDetail()->updateOrCreate(
                ['donor_id' => $donor->id],
                ['payment_options' => json_encode(array_values($options))]
            );
        }

        // ============================================================
        // 6. Standard Documents (PAN, Photo, Address Proof etc.)
        // ============================================================
        $standardFiles = ['pan_member_file', 'photo_file', 'address_proof_file', 'pan_donor_file', 'authorization_letter_file'];
        $hasFiles = false;

        foreach ($standardFiles as $fileInputName) {
            if ($request->hasFile($fileInputName)) {
                $hasFiles = true;
                break;
            }
        }

        if ($hasFiles) {
            $document = $donor->document()->firstOrNew(['donor_id' => $donor->id]);

            foreach ($standardFiles as $fileInputName) {
                if ($request->hasFile($fileInputName)) {
                    // Delete old file
                    $existingFile = $document->{$fileInputName};
                    if ($existingFile) {
                        $oldPath = public_path($existingFile);
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }

                    // Upload new file
                    $file = $request->file($fileInputName);
                    $filename = time() . '_' . $fileInputName . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move($uploadPath, $filename);

                    $document->{$fileInputName} = 'uploads/documents/' . $filename;
                }
            }
            $document->save();
        }

        // 7. Payment Details
        if ($request->has('payments')) {
            $donor->paymentDetail()->updateOrCreate(
                ['donor_id' => $donor->id],
                ['payment_entries' => json_encode($request->payments)]
            );
        }

        DB::commit();

        $step = $request->input('current_step', 1);
        return redirect()
            ->route('admin.donors.dashboard.show', ['donor' => $donor->id, 'step' => $step])
            ->with('success', 'Donor Application updated successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Error updating donor: ' . $e->getMessage())->withInput();
    }
}
}