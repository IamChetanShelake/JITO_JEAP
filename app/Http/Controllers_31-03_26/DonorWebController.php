<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Models\DonorDocument;
use App\Models\Zone;

use App\Models\DonorFamilyDetail;
use App\Models\DonorNomineeDetail;
use App\Models\DonorPaymentDetail;
use App\Models\DonorPersonalDetail;
use Illuminate\Support\Facades\Auth;
use App\Models\DonorMembershipDetail;
use App\Models\DonorProfessionalDetail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class DonorWebController extends Controller
{
    public function index()
    {
        $donor = Auth::guard("donor")->user();
        if (!$donor) {
            return redirect()->route("donor.login");
        }

        // Get next incomplete step
        $nextStep = $donor->getNextStep();

        // Load all details
        $donor->load([
            "personalDetail",
            "familyDetail",
            "nomineeDetail",
            "membershipDetail",
            "professionalDetail",
            "document",
            "paymentDetail"
        ]);

        return view("donor.dashboard", compact("donor", "nextStep"));
    }

    public function step1()
    {
        $donor = Auth::guard("donor")->user();
        $personalDetail = DonorPersonalDetail::where("donor_id", $donor->id)->first();
        $chapters = Chapter::get();
        $states = Zone::select('state')->distinct()->orderBy('state')->pluck('state');
        $zonesByState = Zone::all()->groupBy('state');

        // Get chapters grouped by zone_id for cascading dropdown
        $chaptersByZone = Chapter::whereNotNull('zone_id')->get()->groupBy('zone_id');

        $zone_id = null;
        if ($personalDetail && $personalDetail->zone) {
            // Find the zone ID based on the stored zone name
            $zone = Zone::where('zone_name', $personalDetail->zone)->first();
            $zone_id = $zone ? $zone->id : null;
        }

        return view("donor.step1", compact("donor", "personalDetail", "chapters", "states", "zonesByState", "chaptersByZone", "zone_id"));
    }
    public function getZones($state)
    {
        $zones = Zone::where('state', $state)->get(['id', 'zone_name']);

        return response()->json($zones);
    }
    public function getChapters($zone_id)
    {
        // Return chapters for the selected zone_id
        $chapters = Chapter::where('zone_id', $zone_id)->get(['id', 'chapter_name']);
        return response()->json($chapters);
    }

    public function step2()
    {
        $donor = Auth::guard("donor")->user();

        // Only member donors can access family details
        if ($donor->donor_type !== 'member') {
            abort(403, 'This section is only available for member donors.');
        }

        $familyDetail = DonorFamilyDetail::where("donor_id", $donor->id)->first();

        return view("donor.step2", compact("donor", "familyDetail"));
    }

    public function step3()
    {
        $donor = Auth::guard("donor")->user();

        // Only member donors can access nominee details
        if ($donor->donor_type !== 'member') {
            abort(403, 'This section is only available for member donors.');
        }

        $nomineeDetail = DonorNomineeDetail::where("donor_id", $donor->id)->first();

        return view("donor.step3", compact("donor", "nomineeDetail"));
    }

    public function step4()
    {
        $donor = Auth::guard("donor")->user();

        // Only member donors can access professional details
        if ($donor->donor_type !== 'member') {
            abort(403, 'This section is only available for member donors.');
        }

        $professionalDetail = DonorProfessionalDetail::where("donor_id", $donor->id)->first();

        return view("donor.step4", compact("donor", "professionalDetail"));
    }

    public function step5()
    {
        $donor = Auth::guard("donor")->user();

        // Only member donors can access documents
        if ($donor->donor_type !== 'member') {
            abort(403, 'This section is only available for member donors.');
        }

        $document = DonorDocument::where("donor_id", $donor->id)->first();

        return view("donor.step5", compact("donor", "document"));
    }

    public function step6()
    {
        $donor = Auth::guard("donor")->user();

        // Only member donors can access membership details
        if ($donor->donor_type !== 'member') {
            abort(403, 'This section is only available for member donors.');
        }

        $membershipDetail = DonorMembershipDetail::where("donor_id", $donor->id)->first();

        return view("donor.step6", compact("donor", "membershipDetail"));
    }

    public function step7()
    {
        $donor = Auth::guard("donor")->user();
        $paymentDetail = DonorPaymentDetail::where("donor_id", $donor->id)->first();

        return view("donor.step7", compact("donor", "paymentDetail"));
    }

    public function step8()
    {
        $donor = Auth::guard("donor")->user();

        return view("donor.step8", compact("donor"));
    }

    public function storestep1(Request $request)
    {
        $donor = Auth::guard("donor")->user();
        $existing = DonorPersonalDetail::where("donor_id", $donor->id)->first();

        // 1. Validation
        $rules = [
            "title" => "nullable|string|max:10",
            "first_name" => "required|string|max:255",
            "surname" => "required|string|max:255",
            "complete_address" => "required|string",
            "city" => "required|string|max:100",
            "state" => "required|string|max:100",
            "zone" => "required|string|max:100",
            "pin_code" => "required|digits:6",
            "resi_pin_code" => "required|digits:6",
            "mobile_no" => "required|digits:10",
            "whatsapp_no" => "required|digits:10",
            "email_id_1" => "required|email",
            "pan_no" => "required|string|size:10",
            "chapter" => "required|max:255",
            "date_of_birth" => "required|date",
            "blood_group" => "required",
            "mother_tongue" => "required|string|max:100",
            "district_of_native_place" => "required|string|max:100",
            "fathers_name" => "required|string|max:255",
            "jito_member" => "required|in:yes,no",
            "jatf_member" => "required|in:yes,no",
            "arogyam_member" => "required|in:yes,no",

            "birth_photo" => "nullable|array",
            "birth_photo.*" => "file|mimes:jpg,jpeg,png,pdf|max:2048",

            "anniversary_date" => "nullable|date",
            "anniversary_photo" => "nullable|array",
            "anniversary_photo.*" => "file|mimes:jpg,jpeg,png,pdf|max:2048",
        ];
        //     $validator = Validator::make($request->all(), $rules);
        //     if ($validator->fails()) {

        //     $errorArray = $validator->errors()->all(); 

        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Validation failed',
        //         'errors' => $errorArray
        //     ], 422);

        // }

        $request->validate($rules);

        // Define the public path for documents
        $uploadPath = public_path('uploads/documents');

        // Create directory if it doesn't exist
        if (!File::isDirectory($uploadPath)) {
            File::makeDirectory($uploadPath, 0777, true, true);
        }

        // 2. HANDLE BIRTH PHOTOS
        $birthPhotoPaths = [];

        // Get existing photos from DB
        if ($existing && !empty($existing->birth_photo)) {
            $birthPhotoPaths = is_array($existing->birth_photo) ? $existing->birth_photo : json_decode($existing->birth_photo, true) ?? [];
        }

        // Handle deletion of existing photos
        if ($request->has('delete_birth_photo')) {
            foreach ($request->delete_birth_photo as $fileToDelete) {
                // Remove from array
                $key = array_search($fileToDelete, $birthPhotoPaths);
                if ($key !== false) {
                    unset($birthPhotoPaths[$key]);
                }

                // Delete file from public path
                $filePath = public_path($fileToDelete);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            // Re-index array
            $birthPhotoPaths = array_values($birthPhotoPaths);
        }

        // Process new uploads
        if ($request->hasFile('birth_photo')) {
            foreach ($request->file('birth_photo') as $file) {
                if ($file && $file->isValid()) {
                    // Generate unique filename
                    $fileName = time() . '_birth_' . uniqid() . '.' . $file->getClientOriginalExtension();

                    // Move file to public/uploads/documents
                    $file->move($uploadPath, $fileName);

                    // Save path relative to public folder (for easy access in views)
                    $birthPhotoPaths[] = 'uploads/documents/' . $fileName;
                }
            }
        }

        // Ensure birth_photo is an empty array if no photos
        if (!is_array($birthPhotoPaths)) {
            $birthPhotoPaths = [];
        }

        // 3. HANDLE ANNIVERSARY PHOTOS
        $anniversaryPhotoPaths = [];

        // Get existing photos from DB
        if ($existing && !empty($existing->anniversary_photo)) {
            $anniversaryPhotoPaths = is_array($existing->anniversary_photo) ? $existing->anniversary_photo : json_decode($existing->anniversary_photo, true) ?? [];
        }

        // Handle deletion of existing photos
        if ($request->has('delete_anniversary_photo')) {
            foreach ($request->delete_anniversary_photo as $fileToDelete) {
                // Remove from array
                $key = array_search($fileToDelete, $anniversaryPhotoPaths);
                if ($key !== false) {
                    unset($anniversaryPhotoPaths[$key]);
                }

                // Delete file from public path
                $filePath = public_path($fileToDelete);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            // Re-index array
            $anniversaryPhotoPaths = array_values($anniversaryPhotoPaths);
        }

        // Process new uploads
        if ($request->hasFile('anniversary_photo')) {

            foreach ($request->file('anniversary_photo') as $file) {
                if ($file && $file->isValid()) {
                    // Generate unique filename
                    $fileName = time() . '_anniversary_' . uniqid() . '.' . $file->getClientOriginalExtension();


                    // Move file to public/uploads/documents
                    $file->move($uploadPath, $fileName);

                    // Save path relative to public folder
                    $anniversaryPhotoPaths[] = 'uploads/documents/' . $fileName;
                }
            }
        }


        // Ensure anniversary_photo is an empty array if no photos
        if (!is_array($anniversaryPhotoPaths)) {
            $anniversaryPhotoPaths = [];
        }

        // 4. PREPARE DATA
        $data = [
            "donor_id" => $donor->id,
            "title" => $request->title,
            "first_name" => $request->first_name,
            "middle_name" => $request->middle_name,
            "surname" => $request->surname,
            "complete_address" => $request->complete_address,
            "city" => $request->city,
            "state" => $request->state,
            "zone" => $request->zone,
            "pin_code" => $request->pin_code,
            "resi_landline" => $request->resi_landline,
            "mobile_no" => $request->mobile_no,
            "whatsapp_no" => $request->whatsapp_no,
            "email_id_1" => $request->email_id_1,
            "email_id_2" => $request->email_id_2,
            "preferred_residence_address" => $request->preferred_residence_address,
            "resi_pin_code" => $request->resi_pin_code,
            "preferred_office_address" => $request->preferred_office_address,
            "pan_no" => $request->pan_no,
            "chapter_name" => $request->chapter,
            "date_of_birth" => $request->date_of_birth,

            "birth_photo" => $birthPhotoPaths,
            "anniversary_date" => $request->anniversary_date,
            "anniversary_photo" => $anniversaryPhotoPaths,

            "blood_group" => $request->blood_group,
            "mother_tongue" => $request->mother_tongue,
            "district_of_native_place" => $request->district_of_native_place,
            "fathers_name" => $request->fathers_name,
            "hobby_1" => $request->hobby_1,
            "hobby_2" => $request->hobby_2,
            "jito_member" => $request->jito_member,
            "jatf_member" => $request->jatf_member,
            "arogyam_member" => $request->arogyam_member,
            "jito_uid" => $request->jito_member === 'yes' ? $request->jito_uid : null,
            "submit_status" => "submited",
        ];

        // dd($data);

        // 5. UPDATE OR CREATE
        if ($existing) {
            $existing->update($data);
        } else {
            DonorPersonalDetail::create($data);
        }

        return redirect()->route("donor.step2")->with("success", "Personal details saved successfully!");
    }

    public function storestep2(Request $request)
    {
        $donor = Auth::guard("donor")->user();

        // Only member donors can save family details
        if ($donor->donor_type !== 'member') {
            abort(403, 'This section is only available for member donors.');
        }

        $request->validate([
            "spouse_title" => "nullable|string|max:10",
            "spouse_name" => "required|string|max:255",
            "spouse_birth_date" => "required|date",
            "jito_member" => "required|in:yes,no",
            "jito_uid" => "nullable|required_if:jito_member,yes|string|max:50",
            "spouse_blood_group" => "required|in:A+,A-,B+,B-,AB+,AB-,O+,O-",
            "number_of_kids" => "required|integer|min:0",
            "child_name" => "nullable|array",
            "child_gender" => "nullable|array",
            "child_dob" => "nullable|array",
            "child_blood_group" => "nullable|array",
            "child_marital_status" => "nullable|array",
        ]);

        // Build children array
        $children = [];
        if ($request->number_of_kids > 0 && $request->child_name) {
            foreach ($request->child_name as $index => $childName) {
                $children[] = [
                    "name" => $childName,
                    "gender" => $request->child_gender[$index] ?? "",
                    "dob" => $request->child_dob[$index] ?? "",
                    "blood_group" => $request->child_blood_group[$index] ?? "",
                    "marital_status" => $request->child_marital_status[$index] ?? "",
                ];
            }
        }

        $data = [
            "donor_id" => $donor->id,
            "spouse_title" => $request->spouse_title,
            "spouse_name" => $request->spouse_name,
            "spouse_birth_date" => $request->spouse_birth_date,
            "jito_member" => $request->jito_member,
            "jito_uid" => $request->jito_uid,
            "spouse_blood_group" => $request->spouse_blood_group,
            "number_of_kids" => $request->number_of_kids,
            "children_details" => json_encode($children),
            "submit_status" => "submited",
        ];

        $existing = DonorFamilyDetail::where("donor_id", $donor->id)->first();

        if ($existing) {
            $existing->update($data);
        } else {
            DonorFamilyDetail::create($data);
        }

        return redirect()->route("donor.step3")->with("success", "Family details saved successfully!");
    }

    public function storestep3(Request $request)
    {
        $donor = Auth::guard("donor")->user();

        // Only member donors can save nominee details
        if ($donor->donor_type !== 'member') {
            abort(403, 'This section is only available for member donors.');
        }

        $request->validate([
            "nominee_title" => "nullable|string|max:10",
            "nominee_name" => "required|string|max:255",
            "nominee_relationship" => "required|string|max:255",
            "nominee_mobile" => "required|digits:10",
            "nominee_address" => "required|string",
            "nominee_city" => "required|string|max:100",
            "nominee_pincode" => "required|digits:6",
        ]);

        $data = [
            "donor_id" => $donor->id,
            "nominee_title" => $request->nominee_title,
            "nominee_name" => $request->nominee_name,
            "nominee_relationship" => $request->nominee_relationship,
            "nominee_mobile" => $request->nominee_mobile,
            "nominee_address" => $request->nominee_address,
            "nominee_city" => $request->nominee_city,
            "nominee_pincode" => $request->nominee_pincode,
            "submit_status" => "submited",
        ];

        $existing = DonorNomineeDetail::where("donor_id", $donor->id)->first();

        if ($existing) {
            $existing->update($data);
        } else {
            DonorNomineeDetail::create($data);
        }

        return redirect()->route("donor.step4")->with("success", "Nominee details saved successfully!");
    }

    public function storestep4(Request $request)
    {
        $donor = Auth::guard("donor")->user();

        // Only member donors can save professional details
        if ($donor->donor_type !== 'member') {
            abort(403, 'This section is only available for member donors.');
        }

        $request->validate([
            "company_name" => "required|string|max:255",
            "company_activity_details" => "required|string",
            "designation" => "required|string|max:255",
            "company_website" => "nullable|url",
            "office_address" => "required|string",
            "office_state" => "required|string|max:100",
            "office_city" => "required|string|max:100",
            "office_pincode" => "required|digits:6",
            "office_telephone" => "nullable|string|max:20",
            "office_mobile" => "required|digits:10",
            "pan_no" => "string|size:10",
            "coordinator_name" => "nullable|string|max:255",
            "coordinator_mobile" => "nullable|digits:10",
            "coordinator_email_1" => "nullable|email",
            "coordinator_email_2" => "nullable|email",
        ]);

        $data = [
            "donor_id" => $donor->id,
            "company_name" => $request->company_name,
            "company_activity_details" => $request->company_activity_details,
            "designation" => $request->designation,
            "company_website" => $request->company_website,
            "office_address" => $request->office_address,
            "office_state" => $request->office_state,
            "office_city" => $request->office_city,
            "office_pincode" => $request->office_pincode,
            "office_telephone" => $request->office_telephone,
            "office_mobile" => $request->office_mobile,
            "pan_no" => $request->pan_no,
            "coordinator_name" => $request->coordinator_name,
            "coordinator_mobile" => $request->coordinator_mobile,
            "coordinator_email_1" => $request->coordinator_email_1,
            "coordinator_email_2" => $request->coordinator_email_2,
            "submit_status" => "submited",
        ];

        $existing = DonorProfessionalDetail::where("donor_id", $donor->id)->first();

        if ($existing) {
            $existing->update($data);
        } else {
            DonorProfessionalDetail::create($data);
        }

        return redirect()->route("donor.step5")->with("success", "Professional details saved successfully!");
    }

    public function storestep5(Request $request)
    {
        $donor = Auth::guard("donor")->user();

        // Only member donors can save documents
        if ($donor->donor_type !== 'member') {
            abort(403, 'This section is only available for member donors.');
        }

        $existing = DonorDocument::where("donor_id", $donor->id)->first();

        // Validation for required files (only if not already uploaded)
        $rules = [
            "pan_member_file" => ($existing && $existing->pan_member_file) ? "nullable|file|mimes:jpg,jpeg,png,pdf|max:5120" : "required|file|mimes:jpg,jpeg,png,pdf|max:5120",
            "photo_file" => ($existing && $existing->photo_file) ? "nullable|file|mimes:jpg,jpeg,png,pdf|max:2048" : "required|file|mimes:jpg,jpeg,png,pdf|max:2048",
            "address_proof_file" => ($existing && $existing->address_proof_file) ? "nullable|file|mimes:jpg,jpeg,png,pdf|max:5120" : "required|file|mimes:jpg,jpeg,png,pdf|max:5120",
            "authorization_letter_file" => ($existing && $existing->authorization_letter_file) ? "nullable|file|mimes:jpg,jpeg,png,pdf|max:5120" : "required|file|mimes:jpg,jpeg,png,pdf|max:5120",
            "pan_donor_file" => "nullable|file|mimes:jpg,jpeg,png,pdf|max:5120",
        ];

        $request->validate($rules);

        $data = [
            "donor_id" => $donor->id,
            "check_signature" => $request->has("check_signature"),
            "check_contact" => $request->has("check_contact"),
            "check_nominee" => $request->has("check_nominee"),
            "check_pan" => $request->has("check_pan"),
            "check_payment" => $request->has("check_payment"),
            "submit_status" => "submited",
        ];

        // Define the public path for donor documents
        $docPath = public_path('donor_documents');

        // Create directory if it doesn't exist
        if (!File::isDirectory($docPath)) {
            File::makeDirectory($docPath, 0777, true, true);
        }

        // Handle file uploads
        $files = ["pan_member_file", "pan_donor_file", "photo_file", "address_proof_file", "authorization_letter_file"];

        foreach ($files as $fileInputName) {
            if ($request->hasFile($fileInputName)) {
                // Generate unique filename
                $fileName = time() . "_" . $fileInputName . "_" . uniqid() . "." . $request->$fileInputName->extension();

                // Move file to public/donor_documents
                $request->$fileInputName->move($docPath, $fileName);

                // Save path relative to public folder
                $data[$fileInputName] = "donor_documents/" . $fileName;
            }
        }

        if ($existing) {
            $existing->update($data);
        } else {
            DonorDocument::create($data);
        }

        return redirect()->route("donor.step6")->with("success", "Document saved successfully!");
    }

    public function storestep6(Request $request)
    {
        $donor = Auth::guard("donor")->user();

        // Only member donors can save membership details
        if ($donor->donor_type !== 'member') {
            abort(403, 'This section is only available for member donors.');
        }

        $request->validate([
            "payment_options" => "required|array|min:1",
            "payment_options.*" => "in:54_lakhs,1_year,2_year,3_year",
        ]);

        $donor = Auth::guard("donor")->user();

        $data = [
            "donor_id" => $donor->id,
            "payment_options" => json_encode($request->payment_options),
            "submit_status" => "submited",
        ];

        $existing = DonorMembershipDetail::where("donor_id", $donor->id)->first();

        if ($existing) {
            $existing->update($data);
        } else {
            DonorMembershipDetail::create($data);
        }

        return redirect()->route("donor.step7")->with("success", "Membership details saved successfully!");
    }

    public function storestep7(Request $request)
    {
        $donor = Auth::guard("donor")->user();

        // Build payment entries array
        $paymentEntries = [];
        if ($request->utr_no) {
            foreach ($request->utr_no as $index => $utrNo) {
                $paymentEntries[] = [
                    "utr_no" => $utrNo ?? "",
                    "cheque_date" => $request->cheque_date[$index] ?? "",
                    "amount" => $request->amount[$index] ?? "",
                    "bank_branch" => $request->bank_branch[$index] ?? "",
                    "issued_by" => $request->issued_by[$index] ?? "",
                ];
            }
        }

        $data = [
            "donor_id" => $donor->id,
            "payment_entries" => json_encode($paymentEntries),
            "submit_status" => "submited",
        ];

        $existing = DonorPaymentDetail::where("donor_id", $donor->id)->first();

        if ($existing) {
            $existing->update($data);
        } else {
            DonorPaymentDetail::create($data);
        }

        return redirect()->route("donor.step8")->with("successs", "Payment details saved successfully!");
    }

    public function storestep8(Request $request)
    {
        $request->validate([
            "agree_terms" => "required|accepted",
        ]);

        $donor = Auth::guard("donor")->user();

        // Update donor status to completed
        $donor->update(["submit_status" => "completed"]);

        return redirect()->route('donor.step8')
            ->with("success", "Congratulations! Your donor application has been submitted successfully!")
            ->with("application_completed", true);
    }
}
