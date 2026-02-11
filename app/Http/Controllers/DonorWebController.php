<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Models\DonorDocument;
use App\Models\DonorFamilyDetail;
use App\Models\DonorNomineeDetail;
use App\Models\DonorPaymentDetail;
use App\Models\DonorPersonalDetail;
use Illuminate\Support\Facades\Auth;
use App\Models\DonorMembershipDetail;
use App\Models\DonorProfessionalDetail;

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

        return view("donor.step1", compact("donor", "personalDetail", "chapters"));
    }

    public function step2()
    {
        $donor = Auth::guard("donor")->user();
        $familyDetail = DonorFamilyDetail::where("donor_id", $donor->id)->first();

        return view("donor.step2", compact("donor", "familyDetail"));
    }

    public function step3()
    {
        $donor = Auth::guard("donor")->user();
        $nomineeDetail = DonorNomineeDetail::where("donor_id", $donor->id)->first();

        return view("donor.step3", compact("donor", "nomineeDetail"));
    }

    public function step4()
    {
        $donor = Auth::guard("donor")->user();
        $membershipDetail = DonorMembershipDetail::where("donor_id", $donor->id)->first();

        return view("donor.step4", compact("donor", "membershipDetail"));
    }

    public function step5()
    {
        $donor = Auth::guard("donor")->user();
        $professionalDetail = DonorProfessionalDetail::where("donor_id", $donor->id)->first();

        return view("donor.step5", compact("donor", "professionalDetail"));
    }

    public function step6()
    {
        $donor = Auth::guard("donor")->user();
        $document = DonorDocument::where("donor_id", $donor->id)->first();

        return view("donor.step6", compact("donor", "document"));
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
        $request->validate([
            "title" => "nullable|string|max:10",
            "first_name" => "required|string|max:255",
            "middle_name" => "nullable|string|max:255",
            "surname" => "required|string|max:255",
            "complete_address" => "required|string",
            "city" => "required|string|max:100",
            "state" => "required|string|max:100",
            "pin_code" => "required|digits:6",
            "resi_landline" => "nullable|string|max:20",
            "mobile_no" => "required|digits:10",
            "whatsapp_no" => "required|digits:10",
            "email_id_1" => "required|email",
            "email_id_2" => "nullable|email",
            "preferred_residence_address" => "nullable|string",
            "preferred_office_address" => "nullable|string",
            "pan_no" => "required|string|size:10",
            "chapter_name" => "required|max:255",
            "date_of_birth" => "required|date",
            "anniversary_date" => "nullable|date",
            "blood_group" => "required|in:A+,A-,B+,B-,AB+,AB-,O+,O-",
            "mother_tongue" => "required|string|max:100",
            "district_of_native_place" => "required|string|max:100",
            "fathers_name" => "required|string|max:255",
            "hobby_1" => "nullable|string|max:255",
            "hobby_2" => "nullable|string|max:255",
        ]);

        $donor = Auth::guard("donor")->user();

        $data = [
            "donor_id" => $donor->id,
            "title" => $request->title,
            "first_name" => $request->first_name,
            "middle_name" => $request->middle_name,
            "surname" => $request->surname,
            "complete_address" => $request->complete_address,
            "city" => $request->city,
            "state" => $request->state,
            "pin_code" => $request->pin_code,
            "resi_landline" => $request->resi_landline,
            "mobile_no" => $request->mobile_no,
            "whatsapp_no" => $request->whatsapp_no,
            "email_id_1" => $request->email_id_1,
            "email_id_2" => $request->email_id_2,
            "preferred_residence_address" => $request->preferred_residence_address,
            "preferred_office_address" => $request->preferred_office_address,
            "pan_no" => $request->pan_no,
            "chapter_name" => $request->chapter_name,
            "date_of_birth" => $request->date_of_birth,
            "anniversary_date" => $request->anniversary_date,
            "blood_group" => $request->blood_group,
            "mother_tongue" => $request->mother_tongue,
            "district_of_native_place" => $request->district_of_native_place,
            "fathers_name" => $request->fathers_name,
            "hobby_1" => $request->hobby_1,
            "hobby_2" => $request->hobby_2,
            "submit_status" => "submited",
        ];

        $existing = DonorPersonalDetail::where("donor_id", $donor->id)->first();

        if ($existing) {
            $existing->update($data);
        } else {
            DonorPersonalDetail::create($data);
        }

        return redirect()->route("donor.step2")->with("success", "Personal details saved successfully!");
    }

    public function storestep2(Request $request)
    {
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

        $donor = Auth::guard("donor")->user();

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
        $request->validate([
            "nominee_title" => "nullable|string|max:10",
            "nominee_name" => "required|string|max:255",
            "nominee_relationship" => "required|string|max:255",
            "nominee_mobile" => "required|digits:10",
            "nominee_address" => "required|string",
            "nominee_city" => "required|string|max:100",
            "nominee_pincode" => "required|digits:6",
        ]);

        $donor = Auth::guard("donor")->user();

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

        return redirect()->route("donor.step5")->with("success", "Membership details saved successfully!");
    }

    public function storestep5(Request $request)
    {
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
            "pan_no" => "required|string|size:10",
            "coordinator_name" => "nullable|string|max:255",
            "coordinator_mobile" => "nullable|digits:10",
            "coordinator_email_1" => "nullable|email",
            "coordinator_email_2" => "nullable|email",
        ]);

        $donor = Auth::guard("donor")->user();

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

        return redirect()->route("donor.step6")->with("success", "Professional details saved successfully!");
    }

    public function storestep6(Request $request)
    {
        $donor = Auth::guard("donor")->user();
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

        // Handle file uploads
        $files = ["pan_member_file", "pan_donor_file", "photo_file", "address_proof_file", "authorization_letter_file"];

        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                $fileName = time() . "_" . $file . "." . $request->$file->extension();
                $request->$file->move("donor_documents", $fileName);
                $data[$file] = "donor_documents/" . $fileName;
            }
        }

        if ($existing) {
            $existing->update($data);
        } else {
            DonorDocument::create($data);
        }

        return redirect()->route("donor.step7")->with("success", "Documents uploaded successfully!");
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
