<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Familydetail;
use App\Models\EducationDetail;
use App\Models\FundingDetail;
use App\Models\GuarantorDetail;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\Loan_category;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $existingLoan = Loan_category::where('user_id', $user_id)->latest()->first();
        if ($existingLoan) {
            return redirect()->route('user.step1');
        }
        return view('user.home');
    }

    public function applyLoan(Request $request, $type)
    {
        $user_id = Auth::id();
        // dd($type, $user_id);
        $loancategory = new Loan_category();
        $loancategory->user_id = $user_id;
        $loancategory->type = $type;
        $loancategory->save();
        return redirect()->route('user.step1', ['type' => $type]);
    }

    public function step1(Request $request)
    {
        $user_id = Auth::id();
        $type = Loan_category::where('user_id', $user_id)->latest()->first()->type;
        $user = Auth::user();
        return view('user.step1', compact('type', 'user'));
    }




    public function step1store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'financial_asset_type' => 'required|in:domestic,foreign_finance_assistant',
            'financial_asset_for' => 'required|in:graduation,post_graduation',
            'aadhar_card_number' => 'required|string|max:12',
            'pan_card' => 'nullable|string|max:10',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'alternate_phone' => 'nullable|string|max:15',
            'address' => 'required|string',
            'address1' => 'required|string',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pin_code' => 'required|digits:6',
            'chapter' => 'required|string|max:100',
            'nationality' => 'required|in:indian,foreigner',
            'aadhar_address' => 'required|string',
            'alternate_email' => 'nullable|email|max:255',
            'd_o_b' => 'required|date_format:Y-m-d',
            'birth_place' => 'required|string|max:100',
            'gender' => 'required',
            'age' => 'required|integer|min:18',
            'marital_status' => 'required|in:married,unmarried',
            'religion' => 'required|string|max:50',
            'sub_cast' => 'required|string|max:50',
            'blood_group' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'specially_abled' => 'required|in:yes,no',
        ]);

        $user = User::find(Auth::user()->id);

        $data = [
            'name' => $request->name,
            'financial_asset_type' => $request->financial_asset_type,
            'financial_asset_for' => $request->financial_asset_for,
            'aadhar_card_number' => $request->aadhar_card_number,
            'pan_card' => $request->pan_card,
            'phone' => $request->phone,
            'email' => $request->email,
            'alternate_phone' => $request->alternate_phone,
            'address' => $request->address,
            'address1' => $request->address1,
            'city' => $request->city,
            'district' => $request->district,
            'state' => $request->state,
            'pin_code' => $request->pin_code,
            'chapter' => $request->chapter,
            'nationality' => $request->nationality,
            'aadhar_address' => $request->aadhar_address,
            'alternate_email' => $request->alternate_email,
            // 'd_o_b' => Carbon::createFromFormat('d-m-Y', $request->d_o_b)->format('Y-m-d'),
            'd_o_b' => $request->d_o_b,
            'birth_place' => $request->birth_place,
            'gender' => $request->gender,
            'age' => $request->age,
            'marital_status' => $request->marital_status,
            'religion' => $request->religion,
            'sub_cast' => $request->sub_cast,
            'blood_group' => $request->blood_group,
            'specially_abled' => $request->specially_abled,
            'submit_status' => 'submited',
        ];

        // Handle image upload (only once)
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = 'images/' . $imageName;
        }

        $user->update($data);

        return redirect()->route('user.step2')->with('success', 'Personal details saved successfully!');
    }




    public function step2(Request $request)
    {
        $user_id = Auth::id();
        $type = Loan_category::where('user_id', $user_id)->latest()->first()->type;
        $familyDetail = Familydetail::where('user_id', $user_id)->first();
        return view('user.step2', compact('type', 'familyDetail'));
    }


    public function step2store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'number_family_members' => 'required|integer|min:1',
            'total_family_income' => 'required|integer|min:0',
            'total_students' => 'required|integer|min:0',
            'family_member_diksha' => 'nullable|in:yes,no',
            'total_insurance_coverage' => 'required|integer|min:0',
            'total_premium_paid' => 'required|integer|min:0',
            // Father details
            'father_name' => 'required|string|max:255',
            'father_age' => 'required|integer|min:18|max:120',
            'father_marital_status' => 'required|in:married,unmarried',
            'father_qualification' => 'required|string|max:255',
            'father_occupation' => 'required|string|max:255',
            'father_mobile' => 'required|string|max:15',
            'father_email' => 'nullable|email|max:255',
            'father_yearly_gross_income' => 'required|integer|min:0',
            'father_individual_insurance_coverage' => 'nullable|integer|min:0',
            'father_individual_premium_paid' => 'nullable|integer|min:0',
            'father_aadhaar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'father_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Mother details
            'mother_name' => 'required|string|max:255',
            'mother_age' => 'required|integer|min:18|max:120',
            'mother_marital_status' => 'required|in:married,unmarried',
            'mother_qualification' => 'required|string|max:255',
            'mother_occupation' => 'required|string|max:255',
            'mother_mobile' => 'required|string|max:15',
            'mother_email' => 'nullable|email|max:255',
            'mother_yearly_gross_income' => 'required|integer|min:0',
            'mother_individual_insurance_coverage' => 'nullable|integer|min:0',
            'mother_individual_premium_paid' => 'nullable|integer|min:0',
            'mother_aadhaar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'mother_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Siblings
            'has_sibling' => 'required|in:yes,no',
            'number_of_siblings' => 'nullable|integer|min:0',
            'sibling_name_1' => 'nullable|string|max:255',
            'sibling_qualification' => 'nullable|string|max:255',
            'sibling_occupation' => 'nullable|string|max:255',
            'sibling_mobile' => 'nullable|string|max:15',
            'sibling_email' => 'nullable|email|max:255',
            'sibling_yearly_income' => 'nullable|integer|min:0',
            'sibling_insurance_coverage' => 'nullable|integer|min:0',
            'sibling_premium_paid' => 'nullable|integer|min:0',
            // Scholar details
            // 'additional_email' => 'nullable|email|max:255',
            // 'yearly_gross_income' => 'nullable|integer|min:0',
            // 'individual_insurance_coverage' => 'required|integer|min:0',
            // 'individual_premium_paid' => 'required|integer|min:0',
            // Relatives
            'paternal_uncle_name' => 'nullable|string|max:255',
            'paternal_uncle_mobile' => 'nullable|string|max:15',
            'paternal_uncle_email' => 'nullable|email|max:255',
            'paternal_aunt_name' => 'nullable|string|max:255',
            'paternal_aunt_mobile' => 'nullable|string|max:15',
            'paternal_aunt_email' => 'nullable|email|max:255',
            'maternal_uncle_name' => 'nullable|string|max:255',
            'maternal_uncle_mobile' => 'nullable|string|max:15',
            'maternal_uncle_email' => 'nullable|email|max:255',
            'maternal_aunt_name' => 'nullable|string|max:255',
            'maternal_aunt_mobile' => 'nullable|string|max:15',
            'maternal_aunt_email' => 'nullable|email|max:255',

        ]);

        $user_id = Auth::id();

        $data = [
            'user_id' => $user_id,
            'number_family_members' => $request->number_family_members,
            'total_family_income' => $request->total_family_income,
            'total_students' => $request->total_students,
            'family_member_diksha' => $request->family_member_diksha,
            'total_insurance_coverage' => $request->total_insurance_coverage,
            'total_premium_paid' => $request->total_premium_paid,
            // Father details
            'father_name' => $request->father_name,
            'father_age' => $request->father_age,
            'father_marital_status' => $request->father_marital_status,
            'father_qualification' => $request->father_qualification,
            'father_occupation' => $request->father_occupation,
            'father_mobile' => $request->father_mobile,
            'father_email' => $request->father_email,
            'father_yearly_gross_income' => $request->father_yearly_gross_income,
            'father_individual_insurance_coverage' => $request->father_individual_insurance_coverage,
            'father_individual_premium_paid' => $request->father_individual_premium_paid,
            // Mother details
            'mother_name' => $request->mother_name,
            'mother_age' => $request->mother_age,
            'mother_marital_status' => $request->mother_marital_status,
            'mother_qualification' => $request->mother_qualification,
            'mother_occupation' => $request->mother_occupation,
            'mother_mobile' => $request->mother_mobile,
            'mother_email' => $request->mother_email,
            'mother_yearly_gross_income' => $request->mother_yearly_gross_income,
            'mother_individual_insurance_coverage' => $request->mother_individual_insurance_coverage,
            'mother_individual_premium_paid' => $request->mother_individual_premium_paid,
            // Siblings
            'has_sibling' => $request->has_sibling,
            'number_of_siblings' => $request->number_of_siblings,
            'sibling_name_1' => $request->sibling_name_1,
            'sibling_qualification' => $request->sibling_qualification,
            'sibling_occupation' => $request->sibling_occupation,
            'sibling_mobile' => $request->sibling_mobile,
            'sibling_email' => $request->sibling_email,
            'sibling_yearly_income' => $request->sibling_yearly_income,
            'sibling_insurance_coverage' => $request->sibling_insurance_coverage,
            'sibling_premium_paid' => $request->sibling_premium_paid,
            // // Scholar details
            // 'additional_email' => $request->additional_email,
            // 'yearly_gross_income' => $request->yearly_gross_income,
            // 'individual_insurance_coverage' => $request->individual_insurance_coverage,
            // 'individual_premium_paid' => $request->individual_premium_paid,
            // Relatives
            'paternal_uncle_name' => $request->paternal_uncle_name,
            'paternal_uncle_mobile' => $request->paternal_uncle_mobile,
            'paternal_uncle_email' => $request->paternal_uncle_email,
            'paternal_aunt_name' => $request->paternal_aunt_name,
            'paternal_aunt_mobile' => $request->paternal_aunt_mobile,
            'paternal_aunt_email' => $request->paternal_aunt_email,
            'maternal_uncle_name' => $request->maternal_uncle_name,
            'maternal_uncle_mobile' => $request->maternal_uncle_mobile,
            'maternal_uncle_email' => $request->maternal_uncle_email,
            'maternal_aunt_name' => $request->maternal_aunt_name,
            'maternal_aunt_mobile' => $request->maternal_aunt_mobile,
            'maternal_aunt_email' => $request->maternal_aunt_email,
            'submit_status' => 'submited',
        ];

        // Handle file uploads
        if ($request->hasFile('father_aadhaar')) {
            $fatherAadhaarName = time() . '_father_aadhaar.' . $request->father_aadhaar->extension();
            $request->father_aadhaar->move('images', $fatherAadhaarName);
            $data['father_aadhaar'] = 'images/' . $fatherAadhaarName;
        }

        if ($request->hasFile('father_photo')) {
            $fatherPhotoName = time() . '_father.' . $request->father_photo->extension();
            $request->father_photo->move('images', $fatherPhotoName);
            $data['father_photo'] = 'images/' . $fatherPhotoName;
        }

        if ($request->hasFile('mother_aadhaar')) {
            $motherAadhaarName = time() . '_mother_aadhaar.' . $request->mother_aadhaar->extension();
            $request->mother_aadhaar->move('images', $motherAadhaarName);
            $data['mother_aadhaar'] = 'images/' . $motherAadhaarName;
        }

        if ($request->hasFile('mother_photo')) {
            $motherPhotoName = time() . '_mother.' . $request->mother_photo->extension();
            $request->mother_photo->move('images', $motherPhotoName);
            $data['mother_photo'] = 'images/' . $motherPhotoName;
        }

        Familydetail::create($data);

        return redirect()->route('user.step3')->with('success', 'Family details saved successfully!');
    }





    public function step3(Request $request)
    {
        $user_id = Auth::id();
        $type = Loan_category::where('user_id', $user_id)->latest()->first()->type;
        return view('user.step3', compact('type'));
    }




    public function step3store(Request $request)
    {
        //  dd($request->all());
        $request->validate([
            // Current Education
            'current_pursuing' => 'required|in:yes,no',
            'current_course_name' => 'nullable|string|max:255',
            'current_institution' => 'nullable|string|max:255',
            'current_university' => 'nullable|string|max:255',
            'current_start_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 10),
            'current_expected_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 10),
            'current_mode_of_study' => 'nullable|in:full-time,part-time,distance,online',

            // Completed Qualifications
            'qualifications' => 'nullable|string',
            'qualification_course_name' => 'nullable|string|max:255',
            'qualification_institution' => 'nullable|string|max:255',
            'qualification_university' => 'nullable|string|max:255',
            'qualification_specialization' => 'nullable|string|max:255',
            'qualification_years' => 'nullable|string|max:50',
            'qualification_percentage' => 'nullable|string|max:50',
            'qualification_mode_of_study' => 'nullable|in:full-time,part-time,distance,online',

            // Junior College (12th Grade)
            'jc_college_name' => 'nullable|string|max:255',
            'jc_stream' => 'nullable|string|max:100',
            'jc_board' => 'nullable|string|max:100',
            'jc_completion_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'jc_percentage' => 'nullable|string|max:50',

            // School / 10th Grade Information
            'school_name' => 'nullable|string|max:255',
            'school_board' => 'nullable|string|max:100',
            'school_completion_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'school_percentage' => 'nullable|string|max:50',

            // Additional Curriculum
            'ielts_overall_band_year' => 'nullable|string|max:100',
            'toefl_score_year' => 'nullable|string|max:100',
            'duolingo_det_score_year' => 'nullable|string|max:100',
            'gre_score_year' => 'nullable|string|max:100',
            'gmat_score_year' => 'nullable|string|max:100',
            'sat_score_year' => 'nullable|string|max:100',

            // Work Experience
            'have_work_experience' => 'nullable|in:yes,no',
            'organization_name' => 'nullable|string|max:255',
            'work_profile' => 'nullable|string|max:255',
            'work_duration' => 'nullable|string|max:100',
            'work_location_city' => 'nullable|string|max:100',
            'work_country' => 'nullable|string|max:100',
            'work_type' => 'nullable|in:full-time,internship,freelance,volunteer',

            // Additional Achievements
            'awards_recognition' => 'nullable|string|max:500',
            'volunteer_work' => 'nullable|string|max:500',
            'leadership_roles' => 'nullable|string|max:500',
            'sports_cultural' => 'nullable|string|max:500',

            // Financial Need Overview
            'institute_name' => 'nullable|string|max:255',
            'course_name' => 'nullable|string|max:255',
            'city_name' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'duration' => 'nullable|integer|min:1|max:10',

            // Financial Summary Table
            'tuition_fee_year1' => 'nullable|numeric|min:0',
            'tuition_fee_year2' => 'nullable|numeric|min:0',
            'tuition_fee_year3' => 'nullable|numeric|min:0',
            'tuition_fee_year4' => 'nullable|numeric|min:0',
            'group_2_year1' => 'nullable|numeric|min:0',
            'group_2_year2' => 'nullable|numeric|min:0',
            'group_2_year3' => 'nullable|numeric|min:0',
            'group_2_year4' => 'nullable|numeric|min:0',
            'group_3_year1' => 'nullable|numeric|min:0',
            'group_3_year2' => 'nullable|numeric|min:0',
            'group_3_year3' => 'nullable|numeric|min:0',
            'group_3_year4' => 'nullable|numeric|min:0',
            'group_4_year1' => 'nullable|numeric|min:0',
            'group_4_year2' => 'nullable|numeric|min:0',
            'group_4_year3' => 'nullable|numeric|min:0',
            'group_4_year4' => 'nullable|numeric|min:0',
        ]);

        $user_id = Auth::id();

        $data = [
            'user_id' => $user_id,

            // Current Education
            'current_pursuing' => $request->current_pursuing,
            'current_course_name' => $request->current_course_name,
            'current_institution' => $request->current_institution,
            'current_university' => $request->current_university,
            'current_start_year' => $request->current_start_year,
            'current_expected_year' => $request->current_expected_year,
            'current_mode_of_study' => $request->current_mode_of_study,

            // Completed Qualifications
            'qualifications' => $request->qualifications,
            'qualification_course_name' => $request->qualification_course_name,
            'qualification_institution' => $request->qualification_institution,
            'qualification_university' => $request->qualification_university,
            'qualification_specialization' => $request->qualification_specialization,
            'qualification_years' => $request->qualification_years,
            'qualification_percentage' => $request->qualification_percentage,
            'qualification_mode_of_study' => $request->qualification_mode_of_study,

            // Junior College (12th Grade)
            'jc_college_name' => $request->jc_college_name,
            'jc_stream' => $request->jc_stream,
            'jc_board' => $request->jc_board,
            'jc_completion_year' => $request->jc_completion_year,
            'jc_percentage' => $request->jc_percentage,

            // School / 10th Grade Information
            'school_name' => $request->school_name,
            'school_board' => $request->school_board,
            'school_completion_year' => $request->school_completion_year,
            'school_percentage' => $request->school_percentage,

            // Additional Curriculum
            'ielts_overall_band_year' => $request->ielts_overall_band_year,
            'toefl_score_year' => $request->toefl_score_year,
            'duolingo_det_score_year' => $request->duolingo_det_score_year,
            'gre_score_year' => $request->gre_score_year,
            'gmat_score_year' => $request->gmat_score_year,
            'sat_score_year' => $request->sat_score_year,

            // Work Experience
            'have_work_experience' => $request->have_work_experience,
            'organization_name' => $request->organization_name,
            'work_profile' => $request->work_profile,
            'work_duration' => $request->work_duration,
            'work_location_city' => $request->work_location_city,
            'work_country' => $request->work_country,
            'work_type' => $request->work_type,

            // Additional Achievements
            'awards_recognition' => $request->awards_recognition,
            'volunteer_work' => $request->volunteer_work,
            'leadership_roles' => $request->leadership_roles,
            'sports_cultural' => $request->sports_cultural,

            // Financial Need Overview
            'institute_name' => $request->institute_name,
            'course_name' => $request->course_name,
            'city_name' => $request->city_name,
            'country' => $request->country,
            'duration' => $request->duration,

            // Financial Summary Table
            'tuition_fee_year1' => $request->tuition_fee_year1,
            'tuition_fee_year2' => $request->tuition_fee_year2,
            'tuition_fee_year3' => $request->tuition_fee_year3,
            'tuition_fee_year4' => $request->tuition_fee_year4,
            'group_2_year1' => $request->group_2_year1,
            'group_2_year2' => $request->group_2_year2,
            'group_2_year3' => $request->group_2_year3,
            'group_2_year4' => $request->group_2_year4,
            'group_3_year1' => $request->group_3_year1,
            'group_3_year2' => $request->group_3_year2,
            'group_3_year3' => $request->group_3_year3,
            'group_3_year4' => $request->group_3_year4,
            'group_4_year1' => $request->group_4_year1,
            'group_4_year2' => $request->group_4_year2,
            'group_4_year3' => $request->group_4_year3,
            'group_4_year4' => $request->group_4_year4,

            'status' => 'step3_completed',
        ];

        EducationDetail::create($data);

        return redirect()->route('user.home')->with('success', 'Education details saved successfully!');
    }


    public function step4(Request $request)
    {
        $user_id = Auth::id();
        $type = Loan_category::where('user_id', $user_id)->latest()->first()->type;
        return view('user.step4', compact('type'));
    }




    public function step4store(Request $request)
    {
        dd($request->all());

        $request->validate([
            // Amount Requested
            'amount_requested_year' => 'required|in:year1,year2,year3,year4',
            'tuition_fees_amount' => 'required|numeric|min:0',

            // Funding Details Table (all optional)
            'family_funding_status' => 'nullable|in:applied,approved,received,pending',
            'family_funding_amount' => 'nullable|numeric|min:0',
            'bank_loan_status' => 'nullable|in:applied,approved,received,pending',
            'bank_loan_amount' => 'nullable|numeric|min:0',
            'other_assistance1_status' => 'nullable|in:applied,approved,received,pending',
            'other_assistance1_amount' => 'nullable|numeric|min:0',
            'other_assistance2_status' => 'nullable|in:applied,approved,received,pending',
            'other_assistance2_amount' => 'nullable|numeric|min:0',
            'local_assistance_status' => 'nullable|in:applied,approved,received,pending',
            'local_assistance_amount' => 'nullable|numeric|min:0',

            // Sibling Assistance
            'sibling_assistance' => 'required|in:yes,no',
            'sibling_ngo_name' => 'nullable|string|max:255',
            'sibling_loan_status' => 'nullable|string|max:255',
            'sibling_applied_year' => 'nullable|string|max:255',
            'sibling_applied_amount' => 'nullable|numeric|min:0',

            // Bank Details
            'account_holder_name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'branch_name' => 'required|string|max:255',
            'ifsc_code' => 'required|string|max:20',
            'bank_address' => 'required|string|max:500',
        ]);

        $user_id = Auth::id();

        // Additional validation for sibling assistance conditional fields
        if ($request->sibling_assistance === 'yes') {
            $request->validate([
                'sibling_ngo_name' => 'required|string|max:255',
                'sibling_loan_status' => 'required|string|max:255',
                'sibling_applied_year' => 'required|string|max:255',
                'sibling_applied_amount' => 'required|numeric|min:0',
            ]);
        }

        $data = [
            'user_id' => $user_id,

            // Amount Requested
            'amount_requested_year' => $request->amount_requested_year,
            'tuition_fees_amount' => $request->tuition_fees_amount,

            // Own family funding
            'family_funding_status' => $request->family_funding_status,
            'family_funding_trust' => $request->family_funding_trust,
            'family_funding_contact' => $request->family_funding_contact,
            'family_funding_mobile' => $request->family_funding_mobile,
            'family_funding_amount' => $request->family_funding_amount,

            // Bank Loan
            'bank_loan_status' => $request->bank_loan_status,
            'bank_loan_trust' => $request->bank_loan_trust,
            'bank_loan_contact' => $request->bank_loan_contact,
            'bank_loan_mobile' => $request->bank_loan_mobile,
            'bank_loan_amount' => $request->bank_loan_amount,

            // Other Assistance (1)
            'other_assistance1_status' => $request->other_assistance1_status,
            'other_assistance1_trust' => $request->other_assistance1_trust,
            'other_assistance1_contact' => $request->other_assistance1_contact,
            'other_assistance1_mobile' => $request->other_assistance1_mobile,
            'other_assistance1_amount' => $request->other_assistance1_amount,

            // Other Assistance (2)
            'other_assistance2_status' => $request->other_assistance2_status,
            'other_assistance2_trust' => $request->other_assistance2_trust,
            'other_assistance2_contact' => $request->other_assistance2_contact,
            'other_assistance2_mobile' => $request->other_assistance2_mobile,
            'other_assistance2_amount' => $request->other_assistance2_amount,

            // Local Assistance
            'local_assistance_status' => $request->local_assistance_status,
            'local_assistance_trust' => $request->local_assistance_trust,
            'local_assistance_contact' => $request->local_assistance_contact,
            'local_assistance_mobile' => $request->local_assistance_mobile,
            'local_assistance_amount' => $request->local_assistance_amount,

            // Total funding amount (calculate from table)
            'total_funding_amount' => ($request->family_funding_amount ?: 0) +
                ($request->bank_loan_amount ?: 0) +
                ($request->other_assistance1_amount ?: 0) +
                ($request->other_assistance2_amount ?: 0) +
                ($request->local_assistance_amount ?: 0),

            // Sibling Assistance
            'sibling_assistance' => $request->sibling_assistance,
            'sibling_ngo_name' => $request->sibling_ngo_name,
            'sibling_loan_status' => $request->sibling_loan_status,
            'sibling_applied_year' => $request->sibling_applied_year,
            'sibling_applied_amount' => $request->sibling_applied_amount,

            // Bank Details
            'account_holder_name' => $request->account_holder_name,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'branch_name' => $request->branch_name,
            'ifsc_code' => $request->ifsc_code,
            'bank_address' => $request->bank_address,

            'status' => 'step4_completed',
        ];

        FundingDetail::create($data);

        return redirect()->route('user.home')->with('success', 'Funding details saved successfully!');
    }

    public function step5(Request $request)
    {
        $user_id = Auth::id();
        $type = Loan_category::where('user_id', $user_id)->latest()->first()->type;
        return view('user.step5', compact('type'));
    }

    public function step5store(Request $request)
    {
        $request->validate([
            // First Guarantor
            'g_one_name' => 'required|string|max:255',
            'g_one_gender' => 'required|in:male,female',
            'g_one_permanent_address' => 'required|string|max:500',
            'g_one_phone' => 'required|string|max:15',
            'g_one_email' => 'required|email|max:255',
            'g_one_relation_with_student' => 'required|string|max:255',
            'g_one_aadhar_card_number' => 'required|string|max:12',
            'g_one_pan_card_no' => 'required|string|max:10',
            'g_one_d_o_b' => 'required|date_format:d-m-Y',
            'g_one_income' => 'required|string|max:50',
            'g_one_pan_card' => 'required|file|mimes:jpg,jpeg,png|max:2048',

            // Second Guarantor
            'g_two_name' => 'required|string|max:255',
            'g_two_gender' => 'required|in:male,female',
            'g_two_permanent_address' => 'required|string|max:500',
            'g_two_phone' => 'required|string|max:15',
            'g_two_email' => 'required|email|max:255',
            'g_two_relation_with_student' => 'required|string|max:255',
            'g_two_aadhar_card_number' => 'required|string|max:12',
            'g_two_pan_card_no' => 'required|string|max:10',
            'g_two_d_o_b' => 'required|date_format:d-m-Y',
            'g_two_income' => 'required|string|max:50',
            'g_two_pan_card' => 'required|file|mimes:jpg,jpeg,png|max:2048',

            // Power of Attorney
            'attorney_name' => 'required|string|max:255',
            'attorney_email' => 'required|email|max:255',
            'attorney_phone' => 'required|string|max:15',
            'attorney_address' => 'required|string|max:500',
            'attorney_relation_with_student' => 'required|string|max:255',
        ]);

        $user_id = Auth::id();

        $data = [
            'user_id' => $user_id,

            // First Guarantor
            'g_one_name' => $request->g_one_name,
            'g_one_gender' => $request->g_one_gender,
            'g_one_permanent_address' => $request->g_one_permanent_address,
            'g_one_phone' => $request->g_one_phone,
            'g_one_email' => $request->g_one_email,
            'g_one_relation_with_student' => $request->g_one_relation_with_student,
            'g_one_aadhar_card_number' => $request->g_one_aadhar_card_number,
            'g_one_pan_card_no' => $request->g_one_pan_card_no,
            'g_one_d_o_b' => Carbon::createFromFormat('d-m-Y', $request->g_one_d_o_b)->format('Y-m-d'),
            'g_one_income' => $request->g_one_income,

            // Second Guarantor
            'g_two_name' => $request->g_two_name,
            'g_two_gender' => $request->g_two_gender,
            'g_two_permanent_address' => $request->g_two_permanent_address,
            'g_two_phone' => $request->g_two_phone,
            'g_two_email' => $request->g_two_email,
            'g_two_relation_with_student' => $request->g_two_relation_with_student,
            'g_two_aadhar_card_number' => $request->g_two_aadhar_card_number,
            'g_two_pan_card_no' => $request->g_two_pan_card_no,
            'g_two_d_o_b' => Carbon::createFromFormat('d-m-Y', $request->g_two_d_o_b)->format('Y-m-d'),
            'g_two_income' => $request->g_two_income,

            // Power of Attorney
            'attorney_name' => $request->attorney_name,
            'attorney_email' => $request->attorney_email,
            'attorney_phone' => $request->attorney_phone,
            'attorney_address' => $request->attorney_address,
            'attorney_relation_with_student' => $request->attorney_relation_with_student,

            'status' => 'step5_completed',
        ];

        // Handle file uploads
        if ($request->hasFile('g_one_pan_card')) {
            $gOnePanName = time() . '_g_one_pan.' . $request->g_one_pan_card->extension();
            $request->g_one_pan_card->move('images', $gOnePanName);
            $data['g_one_pan_card_upload'] = 'images/' . $gOnePanName;
        }

        if ($request->hasFile('g_two_pan_card')) {
            $gTwoPanName = time() . '_g_two_pan.' . $request->g_two_pan_card->extension();
            $request->g_two_pan_card->move('images', $gTwoPanName);
            $data['g_two_pan_card_upload'] = 'images/' . $gTwoPanName;
        }

        GuarantorDetail::create($data);

        return redirect()->route('user.step6')->with('success', 'Guarantor details saved successfully!');
    }

    public function step6(Request $request)
    {
        $user_id = Auth::id();
        $type = Loan_category::where('user_id', $user_id)->latest()->first()->type;
        return view('user.step6', compact('type'));
    }

    public function step6store(Request $request)
    {
        $request->validate([
            // Education Documents
            'board' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'board2' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'graduation' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'post_graduation' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'fee_structure' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'admission_letter' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'statement' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            // Identity & Address Proof
            'visa' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'passport' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'applicant_aadhar' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'applicant_pan' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'birth_certificate' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'electricity_bill' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            // Financial Documents
            'father_itr' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'father_balanceSheet_pr_lss_stmnt' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'form16_salary_sleep' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'father_mother_income' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'loan_arrangement' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'father_bank_stmnt' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'mother_bank_stmnt' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'student_main_bank_details' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            // Additional Documents
            'jain_sangh_cert' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'jatf_recommendation' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'other_docs' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'extra_curri' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ]);

        $user_id = Auth::id();

        $data = [
            'user_id' => $user_id,
        ];

        // Handle file uploads
        $files = [
            'board',
            'board2',
            'graduation',
            'post_graduation',
            'fee_structure',
            'admission_letter',
            'statement',
            'visa',
            'passport',
            'applicant_aadhar',
            'applicant_pan',
            'birth_certificate',
            'electricity_bill',
            'father_itr',
            'father_balanceSheet_pr_lss_stmnt',
            'form16_salary_sleep',
            'father_mother_income',
            'loan_arrangement',
            'father_bank_stmnt',
            'mother_bank_stmnt',
            'student_main_bank_details',
            'jain_sangh_cert',
            'jatf_recommendation',
            'other_docs',
            'extra_curri'
        ];

        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                $fileName = time() . '_' . $file . '.' . $request->$file->extension();
                $request->$file->move('user_document_images', $fileName);
                $data[$file] = 'user_document_images/' . $fileName;
            }
        }

        Document::create($data);

        return redirect()->route('user.step7')->with('success', 'Documents uploaded successfully!');
    }

    public function step7(Request $request)
    {
        $user_id = Auth::id();
        $type = Loan_category::where('user_id', $user_id)->latest()->first()->type;
        return view('user.step7', compact('type'));
    }

    public function step7store()
    {
        dd('done');
    }
}
