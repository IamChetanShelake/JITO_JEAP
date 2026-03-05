<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\Zone;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

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
        ])->where('donor_type', 'member')->orderByDesc('id')->get();

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

    /**
     * Display general donors dashboard.
     */
    public function generalDonorsDashboard()
    {
        $donors = Donor::with([
            'personalDetail',
            'paymentDetail',
        ])->where('donor_type', 'general')->orderByDesc('id')->get();

        return view('admin.donors.general_dashboard', compact('donors'));
    }

    /**
     * Display general donor details for editing.
     */
    public function generalDonorShow(Donor $donor)
    {
        // Ensure this is a general donor
        if ($donor->donor_type !== 'general') {
            return redirect()->route('admin.donors.dashboard');
        }

        $donor->load(['personalDetail', 'paymentDetail']);

        $paymentEntries = [];
        if (!empty($donor->paymentDetail?->payment_entries)) {
            $paymentEntries = is_array($donor->paymentDetail->payment_entries)
                ? $donor->paymentDetail->payment_entries
                : json_decode($donor->paymentDetail->payment_entries, true);
        }
        $paymentEntries = $paymentEntries ?: [];

        return redirect()->route('admin.donors.dashboard.show', $donor->id);
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
            'donationCommitments',
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

        // Get zones grouped by state for cascading dropdown
        $zonesByState = Zone::all()->groupBy('state');

        // Get chapters grouped by zone_id for cascading dropdown
        $chaptersByZone = Chapter::whereNotNull('zone_id')->get()->groupBy('zone_id');

        // Get zone_id for the saved zone
        $zone_id = null;
        if ($donor->personalDetail && $donor->personalDetail->zone) {
            $zone = Zone::where('zone_name', $donor->personalDetail->zone)->first();
            $zone_id = $zone ? $zone->id : null;
        }

        // Get active commitments for the donor
        $donorCommitments = $donor->donationCommitments ?? collect();
        $activeCommitments = $donorCommitments->where('status', 'active');

        return view('admin.donors.dashboard_show', compact('donor', 'children', 'paymentOptions', 'paymentEntries', 'zonesByState', 'chaptersByZone', 'zone_id', 'donorCommitments', 'activeCommitments'));
    }

    public function index()
    {
        $donors = Donor::orderBy('name')->get();

        return view('admin.donors.index', compact('donors'));
    }

    public function create(Request $request)
    {
        $donorType = $request->get('donor_type', 'member');
        return view('admin.donors.create', compact('donorType'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admin_panel.donors,email',
            'phone' => 'nullable|string|max:20',
            'donor_type' => 'nullable|in:member,general',
        ];

        // Only require password for member donors
        if ($request->donor_type !== 'general') {
            $rules['password'] = 'required|string|min:8|confirmed';
        } else {
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }

        $request->validate($rules);

        $donorData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'donor_type' => $request->donor_type ?? 'member',
            'can_login' => $request->donor_type === 'general' ? false : true,
            'status' => 'active',
        ];

        // Only set password for member donors
        if ($request->filled('password')) {
            $donorData['password'] = Hash::make($request->password);
        }

        Donor::create($donorData);

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
     * Convert a member donor to a general donor.
     * This will:
     * - Set donor_type to 'general'
     * - Set can_login to false
     * - Set status to 'converted'
     * - Clear password
     * - Cancel all active commitments
     * - Keep historical data intact
     */
    public function convertToGeneral(Donor $donor)
    {
        if ($donor->donor_type === 'general') {
            return back()->with('error', 'This donor is already a general donor.');
        }

        try {
            DB::beginTransaction();

            // Use the donor's convertToGeneral method
            $donor->convertToGeneral();

            DB::commit();

            return back()->with('success', 'Donor successfully converted to general donor. Login access has been revoked.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error converting donor: ' . $e->getMessage());
        }
    }

    /**
     * Create a donation commitment for a member donor.
     */
    public function createCommitment(Request $request, Donor $donor)
    {
        Log::info('createCommitment called', [
            'donor_id' => $donor->id,
            'donor_name' => $donor->name,
            'request_data' => $request->all(),
        ]);

        $validated = $request->validate([
            'committed_amount' => 'required|numeric|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        Log::info('Validation passed', $validated);

        // Check if donor exists
        if (!$donor || !$donor->exists) {
            Log::error('Donor not found', ['donor_id' => $donor->id]);
            return response()->json([
                'success' => false,
                'message' => 'Donor not found.'
            ], 404);
        }

        // Check donor type
        $donorType = $donor->donor_type ?? 'member';
        if ($donorType !== 'member') {
            Log::warning('Non-member donor attempting to create commitment', [
                'donor_id' => $donor->id,
                'donor_type' => $donorType,
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Only member donors can have donation commitments.'
            ], 403);
        }

        try {
            Log::info('Creating commitment for donor', ['donor_id' => $donor->id]);

            // Use the commitments relationship (not donationCommitments)
            $commitment = $donor->commitments()->create([
                'committed_amount' => $validated['committed_amount'],
                'start_date' => $validated['start_date'] ?? null,
                'end_date' => $validated['end_date'] ?? null,
                'status' => 'active',
            ]);

            Log::info('Commitment created successfully', [
                'commitment_id' => $commitment->id,
                'donor_id' => $donor->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Donation commitment created successfully.',
                'commitment' => [
                    'id' => $commitment->id,
                    'committed_amount' => $commitment->committed_amount,
                    'start_date' => $commitment->start_date,
                    'end_date' => $commitment->end_date,
                    'status' => $commitment->status,
                ]
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating commitment', [
                'donor_id' => $donor->id,
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'error_trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error creating commitment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update payment for a specific commitment via modal form.
     */
    public function updatePayment(Request $request, Donor $donor)
    {
        try {
            DB::beginTransaction();

            // Get or create payment detail
            $paymentDetail = $donor->paymentDetail()->firstOrNew(['donor_id' => $donor->id]);

            // Get existing payments
            $existingPayments = [];
            if (!empty($paymentDetail->payment_entries)) {
                $existingPayments = is_array($paymentDetail->payment_entries)
                    ? $paymentDetail->payment_entries
                    : json_decode($paymentDetail->payment_entries, true);
            }
            if (!is_array($existingPayments)) {
                $existingPayments = [];
            }

            // Handle General Donor payment (no commitment)
            if ($donor->donor_type === 'general' && $request->has('general_payment')) {
                $generalPayment = $request->input('general_payment');
                $generalPaymentData = [
                    'commitment_id' => null,
                    'utr_no' => $generalPayment['utr_no'] ?? '',
                    'cheque_date' => $generalPayment['cheque_date'] ?? '',
                    'amount' => $generalPayment['amount'] ?? 0,
                    'bank_branch' => $generalPayment['bank_branch'] ?? '',
                    'issued_by' => $generalPayment['issued_by'] ?? '',
                ];

                // If an index is provided, update that payment, else append as new
                $generalPaymentIndex = $request->input('general_payment_index');
                if ($generalPaymentIndex !== null && $generalPaymentIndex !== '' && isset($existingPayments[$generalPaymentIndex])) {
                    $existingPayments[$generalPaymentIndex] = $generalPaymentData;
                } else {
                    $existingPayments[] = $generalPaymentData;
                }
            }
            // Handle Member Donor payments (by commitment)
            elseif ($request->has('payments')) {
                $payments = $request->input('payments', []);

                // Build a commitment-indexed map to avoid numeric-index collisions.
                $memberPayments = [];
                $nonCommitmentPayments = [];
                foreach ($existingPayments as $entry) {
                    $entryCommitmentId = $entry['commitment_id'] ?? null;
                    if ($entryCommitmentId !== null && $entryCommitmentId !== '') {
                        $memberPayments[(string) $entryCommitmentId] = $entry;
                    } else {
                        $nonCommitmentPayments[] = $entry;
                    }
                }

                foreach ($payments as $commitmentId => $paymentData) {
                    $memberPayments[(string) $commitmentId] = [
                        'commitment_id' => $paymentData['commitment_id'] ?? $commitmentId,
                        'utr_no' => $paymentData['utr_no'] ?? '',
                        'cheque_date' => $paymentData['cheque_date'] ?? '',
                        'amount' => $paymentData['amount'] ?? 0,
                        'bank_branch' => $paymentData['bank_branch'] ?? '',
                        'issued_by' => $paymentData['issued_by'] ?? '',
                    ];
                }

                $existingPayments = array_values(array_merge($nonCommitmentPayments, array_values($memberPayments)));
            }

            // Save payment entries
            $paymentDetail->payment_entries = array_values($existingPayments);
            $paymentDetail->save();

            DB::commit();

            return redirect()->back()->with('success', 'Payment updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error updating payment: ' . $e->getMessage());
        }
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
            if ($request->has('payments') || $request->has('general_payment')) {
                $paymentDetail = $donor->paymentDetail()->firstOrNew(['donor_id' => $donor->id]);

                $existingPayments = [];
                if (!empty($paymentDetail->payment_entries)) {
                    $existingPayments = is_array($paymentDetail->payment_entries)
                        ? $paymentDetail->payment_entries
                        : json_decode($paymentDetail->payment_entries, true);
                }
                if (!is_array($existingPayments)) {
                    $existingPayments = [];
                }

                // General donor payment add/edit
                if ($request->has('general_payment')) {
                    $generalPayment = $request->input('general_payment');
                    $generalPaymentData = [
                        'commitment_id' => null,
                        'utr_no' => $generalPayment['utr_no'] ?? '',
                        'cheque_date' => $generalPayment['cheque_date'] ?? '',
                        'amount' => $generalPayment['amount'] ?? 0,
                        'bank_branch' => $generalPayment['bank_branch'] ?? '',
                        'issued_by' => $generalPayment['issued_by'] ?? '',
                    ];

                    $generalPaymentIndex = $request->input('general_payment_index');
                    if ($generalPaymentIndex !== null && $generalPaymentIndex !== '' && isset($existingPayments[$generalPaymentIndex])) {
                        $existingPayments[$generalPaymentIndex] = $generalPaymentData;
                    } else {
                        $existingPayments[] = $generalPaymentData;
                    }
                }

                // Member donor payments (by commitment)
                if ($request->has('payments')) {
                    $payments = $request->input('payments', []);

                    // Build a commitment-indexed map to avoid numeric-index collisions.
                    $memberPayments = [];
                    $nonCommitmentPayments = [];
                    foreach ($existingPayments as $entry) {
                        $entryCommitmentId = $entry['commitment_id'] ?? null;
                        if ($entryCommitmentId !== null && $entryCommitmentId !== '') {
                            $memberPayments[(string) $entryCommitmentId] = $entry;
                        } else {
                            $nonCommitmentPayments[] = $entry;
                        }
                    }

                    foreach ($payments as $commitmentId => $paymentData) {
                        $memberPayments[(string) $commitmentId] = [
                            'commitment_id' => $paymentData['commitment_id'] ?? $commitmentId,
                            'utr_no' => $paymentData['utr_no'] ?? '',
                            'cheque_date' => $paymentData['cheque_date'] ?? '',
                            'amount' => $paymentData['amount'] ?? 0,
                            'bank_branch' => $paymentData['bank_branch'] ?? '',
                            'issued_by' => $paymentData['issued_by'] ?? '',
                        ];
                    }

                    $existingPayments = array_values(array_merge($nonCommitmentPayments, array_values($memberPayments)));
                }

                $paymentDetail->payment_entries = array_values($existingPayments);
                $paymentDetail->save();
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
