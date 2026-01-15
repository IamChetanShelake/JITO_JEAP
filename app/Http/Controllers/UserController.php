<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Document;
use App\Models\Familydetail;
use App\Models\ReviewSubmit;
use App\Models\ApplicationWorkflowStatus;
use Illuminate\Http\Request;
use App\Models\FundingDetail;
use App\Models\Loan_category;
use Illuminate\Support\Carbon;
use App\Models\EducationDetail;
use App\Models\GuarantorDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Subcast;
use App\Models\Bank;


class UserController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();

        $existingLoan = Loan_category::where('user_id', $user_id)->latest()->first();
        if ($existingLoan) {
            return redirect()->route('user.step1');
        }
        $user = Auth::user()->load(['familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document']);
        return view('user.home', compact('user'));
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
        $user = User::find($user_id);
        $type = Loan_category::where('user_id', $user_id)->latest()->first()->type;
        // $user = Auth::user();
        $familyDetail = Familydetail::where('user_id', $user_id)->first();
        $fundingDetail = FundingDetail::where('user_id', $user_id)->first();
        $subcasts = Subcast::all();
        return view('user.step1', compact('type', 'user', 'familyDetail', 'fundingDetail', 'subcasts'));
    }




    public function step1store(Request $request)
    {
        // dd($request->all());
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        //     'financial_asset_type' => 'required|in:domestic,foreign_finance_assistant',
        //     'financial_asset_for' => 'required|in:graduation,post_graduation',
        //     'aadhar_card_number' => 'required|string|max:12',
        //     'pan_card' => 'nullable|string|max:10',
        //     'phone' => 'required|string|max:15',
        //     'email' => 'required|email|max:255',
        //     'alternate_phone' => 'nullable|string|max:15',
        //     'address' => 'required|string',
        //     'address1' => 'required|string',
        //     'city' => 'required|string|max:100',
        //     'district' => 'required|string|max:100',
        //     'state' => 'required|string|max:100',
        //     'pin_code' => 'required|digits:6',
        //     'chapter' => 'required|string|max:100',
        //     'nationality' => 'required|in:indian,foreigner',
        //     'aadhar_address' => 'required|string',
        //     'alternate_email' => 'nullable|email|max:255',
        //     'd_o_b' => 'required|date_format:Y-m-d',
        //     'birth_place' => 'required|string|max:100',
        //     'gender' => 'required',
        //     'age' => 'required|integer|min:18',
        //     'marital_status' => 'required|in:married,unmarried',
        //     'religion' => 'required|string|max:50',
        //     'sub_cast' => 'required|string|max:50',
        //     'blood_group' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        //     'specially_abled' => 'required|in:yes,no',
        // ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'financial_asset_type' => 'required|in:domestic,foreign_finance_assistant',
            'financial_asset_for' => 'required|in:graduation,post_graduation',

            'aadhar_card_number' => 'required|digits:12',
            'pan_card' => 'nullable|string|max:10',

            'phone' => 'required|string|max:15',
            'alternate_phone' => 'nullable|string|max:15',

            'email' => 'required|email|max:255',
            'alternate_email' => 'nullable|email|max:255',

            'flat_no' => 'nullable|string',
            'building_no' => 'nullable|string',
            'street_name' => 'nullable|string',
            'area' => 'nullable|string',
            'landmark' => 'nullable|string',

            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pin_code' => 'required|digits:6',

            'chapter' => 'required|string|max:100',
            'nationality' => 'required|in:indian,foreigner',

            'aadhar_address' => 'required|string',

            'd_o_b' => 'required|date',
            'birth_place' => 'required|string|max:100',

            'gender' => 'required|in:male,female,other',
            'age' => 'required|numeric|min:18',

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
            // 'address' => $request->address,
            // 'address1' => $request->address1,
            'flat_no' => $request->flat_no,
            'building_no' => $request->building_no,
            'street_name' => $request->street_name,
            'area' => $request->area,
            'landmark' => $request->landmark,

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

        // Check if workflow status already exists for this user
        $workflow = ApplicationWorkflowStatus::where('user_id', $user->id)->first();

        if (!$workflow) {
            // Create new workflow entry
            ApplicationWorkflowStatus::create([
                'user_id' => $user->id,
                'current_stage' => 'apex_1',
                'final_status' => 'in_progress',
            ]);
            $message = 'Application submitted successfully!';
        } else {
            // Update if exists
            $workflow->update([
                'current_stage' => 'apex_1',
                'final_status' => 'in_progress',
            ]);
            $message = 'Application resubmitted successfully!';
        }

        return redirect()->route('user.step2')->with('success', 'Personal details saved successfully!');
    }

    public function step2(Request $request)
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        $type = Loan_category::where('user_id', $user_id)->latest()->first()->type;
        $familyDetail = Familydetail::where('user_id', $user_id)->first();
        $fundingDetail = FundingDetail::where('user_id', $user_id)->first();
        $educationDetail = EducationDetail::where('user_id', $user_id)->first();
        if ($user->financial_asset_type == 'domestic' && $user->financial_asset_for == 'graduation') {
            return view('user.step2_ug', compact('type', 'user', 'familyDetail', 'fundingDetail', 'educationDetail'));
        } else if ($user->financial_asset_type == 'domestic' && $user->financial_asset_for == 'post_graduation') {
            return view('user.step2_pg', compact('type', 'user', 'familyDetail', 'fundingDetail', 'educationDetail'));
        } else if ($user->financial_asset_type == 'foreign_finance_assistant' && $user->financial_asset_for == 'post_graduation') {
            return view('user.step2_pg_foreign', compact('type', 'user', 'familyDetail', 'fundingDetail', 'educationDetail'));
        }
        //  return view('user.step2', compact('type', 'familyDetail', 'fundingDetail', 'user'));
    }




    // public function step2store(Request $request)
    // {
    //     //  dd($request->all());
    //     $request->validate([
    //         // Current Education
    //         'current_pursuing' => 'required|in:yes,no',
    //         'current_course_name' => 'nullable|string|max:255',
    //         'current_institution' => 'nullable|string|max:255',
    //         'current_university' => 'nullable|string|max:255',
    //         'current_start_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 10),
    //         'current_expected_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 10),
    //         'current_mode_of_study' => 'nullable|in:full-time,part-time,distance,online',

    //         // Completed Qualifications
    //         'qualifications' => 'nullable|string',
    //         'qualification_course_name' => 'nullable|string|max:255',
    //         'qualification_institution' => 'nullable|string|max:255',
    //         'qualification_university' => 'nullable|string|max:255',
    //         'qualification_specialization' => 'nullable|string|max:255',
    //         'qualification_years' => 'nullable|string|max:50',
    //         'qualification_percentage' => 'nullable|string|max:50',
    //         'qualification_mode_of_study' => 'nullable|in:full-time,part-time,distance,online',

    //         // Junior College (12th Grade)
    //         'jc_college_name' => 'nullable|string|max:255',
    //         'jc_stream' => 'nullable|string|max:100',
    //         'jc_board' => 'nullable|string|max:100',
    //         'jc_completion_year' => 'nullable|integer|min:1900|max:' . date('Y'),
    //         'jc_percentage' => 'nullable|string|max:50',

    //         // School / 10th Grade Information
    //         'school_name' => 'nullable|string|max:255',
    //         'school_board' => 'nullable|string|max:100',
    //         'school_completion_year' => 'nullable|integer|min:1900|max:' . date('Y'),
    //         'school_percentage' => 'nullable|string|max:50',

    //         // Additional Curriculum
    //         'ielts_overall_band_year' => 'nullable|string|max:100',
    //         'toefl_score_year' => 'nullable|string|max:100',
    //         'duolingo_det_score_year' => 'nullable|string|max:100',
    //         'gre_score_year' => 'nullable|string|max:100',
    //         'gmat_score_year' => 'nullable|string|max:100',
    //         'sat_score_year' => 'nullable|string|max:100',

    //         // Work Experience
    //         'have_work_experience' => 'nullable|in:yes,no',
    //         'organization_name' => 'nullable|string|max:255',
    //         'work_profile' => 'nullable|string|max:255',
    //         'work_duration' => 'nullable|string|max:100',
    //         'work_location_city' => 'nullable|string|max:100',
    //         'work_country' => 'nullable|string|max:100',
    //         'work_type' => 'nullable|in:full-time,internship,freelance,volunteer',

    //         // Additional Achievements
    //         'awards_recognition' => 'nullable|string|max:500',
    //         'volunteer_work' => 'nullable|string|max:500',
    //         'leadership_roles' => 'nullable|string|max:500',
    //         'sports_cultural' => 'nullable|string|max:500',

    //         // Financial Need Overview
    //         'institute_name' => 'nullable|string|max:255',
    //         'course_name' => 'nullable|string|max:255',
    //         'city_name' => 'nullable|string|max:100',
    //         'country' => 'nullable|string|max:100',
    //         'duration' => 'nullable|integer|min:1|max:10',

    //         // Financial Summary Table
    //         'tuition_fee_year1' => 'nullable|numeric|min:0',
    //         'tuition_fee_year2' => 'nullable|numeric|min:0',
    //         'tuition_fee_year3' => 'nullable|numeric|min:0',
    //         'tuition_fee_year4' => 'nullable|numeric|min:0',
    //         'group_2_year1' => 'nullable|numeric|min:0',
    //         'group_2_year2' => 'nullable|numeric|min:0',
    //         'group_2_year3' => 'nullable|numeric|min:0',
    //         'group_2_year4' => 'nullable|numeric|min:0',
    //         'group_3_year1' => 'nullable|numeric|min:0',
    //         'group_3_year2' => 'nullable|numeric|min:0',
    //         'group_3_year3' => 'nullable|numeric|min:0',
    //         'group_3_year4' => 'nullable|numeric|min:0',
    //         'group_4_year1' => 'nullable|numeric|min:0',
    //         'group_4_year2' => 'nullable|numeric|min:0',
    //         'group_4_year3' => 'nullable|numeric|min:0',
    //         'group_4_year4' => 'nullable|numeric|min:0',
    //     ]);

    //     $user_id = Auth::id();

    //     $data = [
    //         'user_id' => $user_id,

    //         // Current Education
    //         'current_pursuing' => $request->current_pursuing,
    //         'current_course_name' => $request->current_course_name,
    //         'current_institution' => $request->current_institution,
    //         'current_university' => $request->current_university,
    //         'current_start_year' => $request->current_start_year,
    //         'current_expected_year' => $request->current_expected_year,
    //         'current_mode_of_study' => $request->current_mode_of_study,

    //         // Completed Qualifications
    //         'qualifications' => $request->qualifications,
    //         'qualification_course_name' => $request->qualification_course_name,
    //         'qualification_institution' => $request->qualification_institution,
    //         'qualification_university' => $request->qualification_university,
    //         'qualification_specialization' => $request->qualification_specialization,
    //         'qualification_years' => $request->qualification_years,
    //         'qualification_percentage' => $request->qualification_percentage,
    //         'qualification_mode_of_study' => $request->qualification_mode_of_study,

    //         // Junior College (12th Grade)
    //         'jc_college_name' => $request->jc_college_name,
    //         'jc_stream' => $request->jc_stream,
    //         'jc_board' => $request->jc_board,
    //         'jc_completion_year' => $request->jc_completion_year,
    //         'jc_percentage' => $request->jc_percentage,

    //         // School / 10th Grade Information
    //         'school_name' => $request->school_name,
    //         'school_board' => $request->school_board,
    //         'school_completion_year' => $request->school_completion_year,
    //         'school_percentage' => $request->school_percentage,

    //         // Additional Curriculum
    //         'ielts_overall_band_year' => $request->ielts_overall_band_year,
    //         'toefl_score_year' => $request->toefl_score_year,
    //         'duolingo_det_score_year' => $request->duolingo_det_score_year,
    //         'gre_score_year' => $request->gre_score_year,
    //         'gmat_score_year' => $request->gmat_score_year,
    //         'sat_score_year' => $request->sat_score_year,

    //         // Work Experience
    //         'have_work_experience' => $request->have_work_experience,
    //         'organization_name' => $request->organization_name,
    //         'work_profile' => $request->work_profile,
    //         'work_duration' => $request->work_duration,
    //         'work_location_city' => $request->work_location_city,
    //         'work_country' => $request->work_country,
    //         'work_type' => $request->work_type,

    //         // Additional Achievements
    //         'awards_recognition' => $request->awards_recognition,
    //         'volunteer_work' => $request->volunteer_work,
    //         'leadership_roles' => $request->leadership_roles,
    //         'sports_cultural' => $request->sports_cultural,

    //         // Financial Need Overview
    //         'institute_name' => $request->institute_name,
    //         'course_name' => $request->course_name,
    //         'city_name' => $request->city_name,
    //         'country' => $request->country,
    //         'duration' => $request->duration,

    //         // Financial Summary Table
    //         'tuition_fee_year1' => $request->tuition_fee_year1,
    //         'tuition_fee_year2' => $request->tuition_fee_year2,
    //         'tuition_fee_year3' => $request->tuition_fee_year3,
    //         'tuition_fee_year4' => $request->tuition_fee_year4,
    //         'group_2_year1' => $request->group_2_year1,
    //         'group_2_year2' => $request->group_2_year2,
    //         'group_2_year3' => $request->group_2_year3,
    //         'group_2_year4' => $request->group_2_year4,
    //         'group_3_year1' => $request->group_3_year1,
    //         'group_3_year2' => $request->group_3_year2,
    //         'group_3_year3' => $request->group_3_year3,
    //         'group_3_year4' => $request->group_3_year4,
    //         'group_4_year1' => $request->group_4_year1,
    //         'group_4_year2' => $request->group_4_year2,
    //         'group_4_year3' => $request->group_4_year3,
    //         'group_4_year4' => $request->group_4_year4,

    //         'status' => 'step3_completed',
    //     ];

    //     // Check if education details already exist for this user
    //     $educationDetail = EducationDetail::where('user_id', $user_id)->first();

    //     if ($educationDetail) {
    //         // Update existing record
    //         $educationDetail->update($data);
    //         $message = 'Education details updated successfully!';
    //     } else {
    //         // Create new record
    //         EducationDetail::create($data);
    //         $message = 'Education details saved successfully!';
    //     }

    //     return redirect()->route('user.home')->with('success', $message);
    // }





    public function step2UGstore(Request $request)
    {
        // dd($request->all());
        // Validation for education details
        $request->validate([
            // Financial Need Overview
            'course_name' => 'required|string|max:255',
            'university_name' => 'required|string|max:255',
            'college_name' => 'required|string|max:255',
            'country' => 'required|string|max:100',
            'city_name' => 'required|string|max:100',
            'start_year' => 'required|string',
            'expected_year' => 'required|string',
            'nirf_ranking' => 'nullable|string|max:50',

            // Financial Summary Table
            'group_1_year1' => 'nullable|numeric|min:0',
            'group_1_year2' => 'nullable|numeric|min:0',
            'group_1_year3' => 'nullable|numeric|min:0',
            'group_1_year4' => 'nullable|numeric|min:0',
            'group_1_year5' => 'nullable|numeric|min:0',
            'group_2_year1' => 'nullable|numeric|min:0',
            'group_2_year2' => 'nullable|numeric|min:0',
            'group_2_year3' => 'nullable|numeric|min:0',
            'group_2_year4' => 'nullable|numeric|min:0',
            'group_2_year5' => 'nullable|numeric|min:0',
            'group_3_year1' => 'nullable|numeric|min:0',
            'group_3_year2' => 'nullable|numeric|min:0',
            'group_3_year3' => 'nullable|numeric|min:0',
            'group_3_year4' => 'nullable|numeric|min:0',
            'group_3_year5' => 'nullable|numeric|min:0',
            'group_4_year1' => 'nullable|numeric|min:0',
            'group_4_year2' => 'nullable|numeric|min:0',
            'group_4_year3' => 'nullable|numeric|min:0',
            'group_4_year4' => 'nullable|numeric|min:0',
            'group_4_year5' => 'nullable|numeric|min:0',

            // School / 10th Grade Information
            'school_name' => 'nullable|string|max:255',
            'school_board' => 'nullable|string|max:100',
            'school_completion_year' => 'nullable|string|max:50',
            '10th_mark_obtained' => 'nullable|integer|min:0',
            '10th_mark_out_of' => 'nullable|integer|min:0',
            'school_percentage' => 'nullable|string|max:50',
            'school_CGPA' => 'nullable|string|max:50',

            // Junior College (12th Grade)
            'jc_college_name' => 'nullable|string|max:255',
            'jc_stream' => 'nullable|string|max:100',
            'jc_board' => 'nullable|string|max:100',
            'jc_completion_year' => 'nullable|string|max:50',
            '12th_mark_obtained' => 'nullable|integer|min:0',
            '12th_mark_out_of' => 'nullable|integer|min:0',
            'jc_percentage' => 'nullable|string|max:50',
            'jc_CGPA' => 'nullable|string|max:50',
        ]);

        $user_id = Auth::id();

        $data = [
            'user_id' => $user_id,

            // Financial Need Overview
            'course_name' => $request->course_name,
            'university_name' => $request->university_name,
            'college_name' => $request->college_name,
            'country' => $request->country,
            'city_name' => $request->city_name,
            'start_year' => $request->start_year,
            'expected_year' => $request->expected_year,
            'nirf_ranking' => $request->nirf_ranking,

            // Financial Summary Table
            'group_1_year1' => $request->group_1_year1,
            'group_1_year2' => $request->group_1_year2,
            'group_1_year3' => $request->group_1_year3,
            'group_1_year4' => $request->group_1_year4,
            'group_1_year5' => $request->group_1_year5,
            'group_2_year1' => $request->group_2_year1,
            'group_2_year2' => $request->group_2_year2,
            'group_2_year3' => $request->group_2_year3,
            'group_2_year4' => $request->group_2_year4,
            'group_2_year5' => $request->group_2_year5,
            'group_3_year1' => $request->group_3_year1,
            'group_3_year2' => $request->group_3_year2,
            'group_3_year3' => $request->group_3_year3,
            'group_3_year4' => $request->group_3_year4,
            'group_3_year5' => $request->group_3_year5,
            'group_4_year1' => $request->group_4_year1,
            'group_4_year2' => $request->group_4_year2,
            'group_4_year3' => $request->group_4_year3,
            'group_4_year4' => $request->group_4_year4,
            'group_4_year5' => $request->group_4_year5,

            // Calculate totals
            'group_1_total' => ($request->group_1_year1 ?: 0) + ($request->group_1_year2 ?: 0) + ($request->group_1_year3 ?: 0) + ($request->group_1_year4 ?: 0) + ($request->group_1_year5 ?: 0),
            'group_2_total' => ($request->group_2_year1 ?: 0) + ($request->group_2_year2 ?: 0) + ($request->group_2_year3 ?: 0) + ($request->group_2_year4 ?: 0) + ($request->group_2_year5 ?: 0),
            'group_3_total' => ($request->group_3_year1 ?: 0) + ($request->group_3_year2 ?: 0) + ($request->group_3_year3 ?: 0) + ($request->group_3_year4 ?: 0) + ($request->group_3_year5 ?: 0),
            'group_4_total' => ($request->group_4_year1 ?: 0) + ($request->group_4_year2 ?: 0) + ($request->group_4_year3 ?: 0) + ($request->group_4_year4 ?: 0) + ($request->group_4_year5 ?: 0),

            // School / 10th Grade Information
            'school_name' => $request->school_name,
            'school_board' => $request->school_board,
            'school_completion_year' => $request->school_completion_year,
            '10th_mark_obtained' => $request->input('10th_mark_obtained'),
            '10th_mark_out_of' => $request->input('10th_mark_out_of'),
            'school_percentage' => $request->school_percentage,
            'school_CGPA' => $request->school_CGPA,

            // Junior College (12th Grade)
            'jc_college_name' => $request->jc_college_name,
            'jc_stream' => $request->jc_stream,
            'jc_board' => $request->jc_board,
            'jc_completion_year' => $request->jc_completion_year,
            '12th_mark_obtained' => $request->input('12th_mark_obtained'),
            '12th_mark_out_of' => $request->input('12th_mark_out_of'),
            'jc_percentage' => $request->jc_percentage,
            'jc_CGPA' => $request->jc_CGPA,

            'status' => 'step2_completed',
            'submit_status' => 'submited',
        ];

        // Check if education details already exist for this user
        $educationDetail = EducationDetail::where('user_id', $user_id)->first();

        if ($educationDetail) {
            // Update existing record
            $educationDetail->update($data);
            $message = 'Education details updated successfully!';
        } else {
            // Create new record
            EducationDetail::create($data);
            $message = 'Education details saved successfully!';
        }

        return redirect()->route('user.step3')->with('success', $message);
    }






    // public function step2PGstore(Request $request)
    // {
    //     //dd($request->all());
    //     $request->validate([
    //         'number_family_members' => 'required|integer|min:1',
    //         'total_family_income' => 'required|integer|min:0',
    //         'total_students' => 'required|integer|min:0',
    //         'family_member_diksha' => 'nullable|in:yes,no',
    //         'total_insurance_coverage' => 'required|integer|min:0',
    //         'total_premium_paid' => 'required|integer|min:0',
    //         'recent_electricity_amount' => 'required|integer|min:0',
    //         'total_monthly_emi' => 'required|integer|min:0',
    //         'mediclaim_insurance_amount' => 'required|integer|min:0',
    //         // Relatives

    //         'paternal_uncle_name' => 'nullable|string|max:255',
    //         'paternal_uncle_mobile' => 'nullable|string|max:15',
    //         'paternal_uncle_email' => 'nullable|email|max:255',
    //         'paternal_aunt_name' => 'nullable|string|max:255',
    //         'paternal_aunt_mobile' => 'nullable|string|max:15',
    //         'paternal_aunt_email' => 'nullable|email|max:255',
    //         'maternal_uncle_name' => 'nullable|string|max:255',
    //         'maternal_uncle_mobile' => 'nullable|string|max:15',
    //         'maternal_uncle_email' => 'nullable|email|max:255',
    //         'maternal_aunt_name' => 'nullable|string|max:255',
    //         'maternal_aunt_mobile' => 'nullable|string|max:15',
    //         'maternal_aunt_email' => 'nullable|email|max:255',
    //     ]);

    //     // Custom validation: At least one complete relative set must be filled
    //     $paternalUncleComplete = !empty($request->paternal_uncle_name) &&
    //         !empty($request->paternal_uncle_mobile) &&
    //         !empty($request->paternal_uncle_email);

    //     $paternalAuntComplete = !empty($request->paternal_aunt_name) &&
    //         !empty($request->paternal_aunt_mobile) &&
    //         !empty($request->paternal_aunt_email);

    //     $maternalUncleComplete = !empty($request->maternal_uncle_name) &&
    //         !empty($request->maternal_uncle_mobile) &&
    //         !empty($request->maternal_uncle_email);

    //     $maternalAuntComplete = !empty($request->maternal_aunt_name) &&
    //         !empty($request->maternal_aunt_mobile) &&
    //         !empty($request->maternal_aunt_email);

    //     if (!$paternalUncleComplete && !$paternalAuntComplete && !$maternalUncleComplete && !$maternalAuntComplete) {
    //         return back()->withErrors(['relatives' => 'At least one complete relative set (name, mobile, and email) must be filled.'])->withInput();
    //     }

    //     $user_id = Auth::id();

    //     // Collect additional family members from dynamic table
    //     $additional_family_members = [];
    //     $i = 1;
    //     while ($request->has('family_' . $i . '_name')) {
    //         $additional_family_members[] = [
    //             'relation' => $request->input('family_' . $i . '_relation'),
    //             'name' => $request->input('family_' . $i . '_name'),
    //             'age' => $request->input('family_' . $i . '_age'),
    //             'marital_status' => $request->input('family_' . $i . '_marital_status'),
    //             'qualification' => $request->input('family_' . $i . '_qualification'),
    //             'occupation' => $request->input('family_' . $i . '_occupation'),
    //             'mobile' => $request->input('family_' . $i . '_mobile'),
    //             'email' => $request->input('family_' . $i . '_email'),
    //             'yearly_income' => $request->input('family_' . $i . '_yearly_income'),
    //         ];
    //         $i++;
    //     }

    //     $data = [
    //         'user_id' => $user_id,
    //         'number_family_members' => $request->number_family_members,
    //         'total_family_income' => $request->total_family_income,
    //         'total_students' => $request->total_students,
    //         'family_member_diksha' => $request->family_member_diksha,
    //         'total_insurance_coverage' => $request->total_insurance_coverage,
    //         'total_premium_paid' => $request->total_premium_paid,
    //         'recent_electricity_amount' => $request->recent_electricity_amount,
    //         'total_monthly_emi' => $request->total_monthly_emi,
    //         'mediclaim_insurance_amount' => $request->mediclaim_insurance_amount,
    //         'additional_family_members' => json_encode($additional_family_members),
    //         // Relatives
    //         'paternal_uncle_name' => $request->paternal_uncle_name,
    //         'paternal_uncle_mobile' => $request->paternal_uncle_mobile,
    //         'paternal_uncle_email' => $request->paternal_uncle_email,
    //         'paternal_aunt_name' => $request->paternal_aunt_name,
    //         'paternal_aunt_mobile' => $request->paternal_aunt_mobile,
    //         'paternal_aunt_email' => $request->paternal_aunt_email,
    //         'maternal_uncle_name' => $request->maternal_uncle_name,
    //         'maternal_uncle_mobile' => $request->maternal_uncle_mobile,
    //         'maternal_uncle_email' => $request->maternal_uncle_email,
    //         'maternal_aunt_name' => $request->maternal_aunt_name,
    //         'maternal_aunt_mobile' => $request->maternal_aunt_mobile,
    //         'maternal_aunt_email' => $request->maternal_aunt_email,
    //         'submit_status' => 'submited',
    //     ];

    //     // Check if family details already exist for this user
    //     $familyDetail = Familydetail::where('user_id', $user_id)->first();

    //     if ($familyDetail) {
    //         // Update existing record
    //         $familyDetail->update($data);
    //         $message = 'Family details updated successfully!';
    //     } else {
    //         // Create new record
    //         Familydetail::create($data);
    //         $message = 'Family details saved successfully!';
    //     }

    //     return redirect()->route('user.step3')->with('success', $message);
    // }

    public function step2PGstore(Request $request)
    {
        // Validation for education details
        //  dd($request->all());
        $request->validate([
            // Financial Need Overview
            'course_name' => 'required|string|max:255',
            'university_name' => 'required|string|max:255',
            'college_name' => 'required|string|max:255',
            'country' => 'required|string|max:100',
            'city_name' => 'required|string|max:100',
            'start_year' => 'required|string',
            'expected_year' => 'required|string',
            'nirf_ranking' => 'nullable|string|max:50',

            // Financial Summary Table
            'group_1_year1' => 'nullable|numeric|min:0',
            'group_1_year2' => 'nullable|numeric|min:0',
            'group_1_year3' => 'nullable|numeric|min:0',
            'group_1_year4' => 'nullable|numeric|min:0',
            'group_1_year5' => 'nullable|numeric|min:0',
            'group_2_year1' => 'nullable|numeric|min:0',
            'group_2_year2' => 'nullable|numeric|min:0',
            'group_2_year3' => 'nullable|numeric|min:0',
            'group_2_year4' => 'nullable|numeric|min:0',
            'group_2_year5' => 'nullable|numeric|min:0',
            'group_3_year1' => 'nullable|numeric|min:0',
            'group_3_year2' => 'nullable|numeric|min:0',
            'group_3_year3' => 'nullable|numeric|min:0',
            'group_3_year4' => 'nullable|numeric|min:0',
            'group_3_year5' => 'nullable|numeric|min:0',
            'group_4_year1' => 'nullable|numeric|min:0',
            'group_4_year2' => 'nullable|numeric|min:0',
            'group_4_year3' => 'nullable|numeric|min:0',
            'group_4_year4' => 'nullable|numeric|min:0',
            'group_4_year5' => 'nullable|numeric|min:0',

            // School / 10th Grade Information
            'school_name' => 'nullable|string|max:255',
            'school_board' => 'nullable|string|max:100',
            'school_completion_year' => 'nullable|string|max:50',
            '10th_mark_obtained' => 'nullable|integer|min:0',
            '10th_mark_out_of' => 'nullable|integer|min:0',
            'school_percentage' => 'nullable|string|max:50',
            'school_CGPA' => 'nullable|string|max:50',

            // Junior College (12th Grade)
            'jc_college_name' => 'nullable|string|max:255',
            'jc_stream' => 'nullable|string|max:100',
            'jc_board' => 'nullable|string|max:100',
            'jc_completion_year' => 'nullable|string|max:50',
            '12th_mark_obtained' => 'nullable|integer|min:0',
            '12th_mark_out_of' => 'nullable|integer|min:0',
            'jc_percentage' => 'nullable|string|max:50',
            'jc_CGPA' => 'nullable|string|max:50',


            // Completed Qualifications
            'qualifications' => 'nullable|string',
            'qualification_institution' => 'nullable|string|max:255',
            'qualification_university' => 'nullable|string|max:255',
            'qualification_start_year' => 'nullable|date',
            'qualification_end_year' => 'nullable|date',
            'marksheet_type' => 'nullable|array',
            'marks_obtained' => 'nullable|array',
            'out_of' => 'nullable|array',
            'percentage' => 'nullable|array',
            'cgpa' => 'nullable|array',

            // Work Experience
            'have_work_experience' => 'nullable|in:yes,no',
            'organization_name' => 'nullable|string|max:255',
            'work_profile' => 'nullable|string|max:255',
            'duration_start_year' => 'nullable|string|max:50',
            'duration_end_year' => 'nullable|string|max:50',
            'work_location_city' => 'nullable|string|max:100',
            'work_country' => 'nullable|string|max:100',
            'work_type' => 'nullable|in:full-time,internship,freelance,volunteer',
            'mention_your_salary' => 'nullable|in:monthly,yearly,ctc',
            'salary_amount' => 'nullable|numeric|min:0',


        ]);

        $user_id = Auth::id();

        $data = [
            'user_id' => $user_id,

            // Financial Need Overview
            'course_name' => $request->course_name,
            'university_name' => $request->university_name,
            'college_name' => $request->college_name,
            'country' => $request->country,
            'city_name' => $request->city_name,
            'start_year' => $request->start_year ? $request->start_year . '-01' : null, // Convert month to full date
            'expected_year' => $request->expected_year ? $request->expected_year . '-01' : null, // Convert month to full date
            'nirf_ranking' => $request->nirf_ranking,

            // Financial Summary Table
            'group_1_year1' => $request->group_1_year1,
            'group_1_year2' => $request->group_1_year2,
            'group_1_year3' => $request->group_1_year3,
            'group_1_year4' => $request->group_1_year4,
            'group_1_year5' => $request->group_1_year5,
            'group_2_year1' => $request->group_2_year1,
            'group_2_year2' => $request->group_2_year2,
            'group_2_year3' => $request->group_2_year3,
            'group_2_year4' => $request->group_2_year4,
            'group_2_year5' => $request->group_2_year5,
            'group_3_year1' => $request->group_3_year1,
            'group_3_year2' => $request->group_3_year2,
            'group_3_year3' => $request->group_3_year3,
            'group_3_year4' => $request->group_3_year4,
            'group_3_year5' => $request->group_3_year5,
            'group_4_year1' => $request->group_4_year1,
            'group_4_year2' => $request->group_4_year2,
            'group_4_year3' => $request->group_4_year3,
            'group_4_year4' => $request->group_4_year4,
            'group_4_year5' => $request->group_4_year5,

            // Calculate totals
            'group_1_total' => ($request->group_1_year1 ?: 0) + ($request->group_1_year2 ?: 0) + ($request->group_1_year3 ?: 0) + ($request->group_1_year4 ?: 0) + ($request->group_1_year5 ?: 0),
            'group_2_total' => ($request->group_2_year1 ?: 0) + ($request->group_2_year2 ?: 0) + ($request->group_2_year3 ?: 0) + ($request->group_2_year4 ?: 0) + ($request->group_2_year5 ?: 0),
            'group_3_total' => ($request->group_3_year1 ?: 0) + ($request->group_3_year2 ?: 0) + ($request->group_3_year3 ?: 0) + ($request->group_3_year4 ?: 0) + ($request->group_3_year5 ?: 0),
            'group_4_total' => ($request->group_4_year1 ?: 0) + ($request->group_4_year2 ?: 0) + ($request->group_4_year3 ?: 0) + ($request->group_4_year4 ?: 0) + ($request->group_4_year5 ?: 0),

            // School / 10th Grade Information
            'school_name' => $request->school_name,
            'school_board' => $request->school_board,
            'school_completion_year' => $request->school_completion_year,
            '10th_mark_obtained' => $request->input('10th_mark_obtained'),
            '10th_mark_out_of' => $request->input('10th_mark_out_of'),
            'school_percentage' => $request->school_percentage,
            'school_CGPA' => $request->school_CGPA,

            // Junior College (12th Grade)
            'jc_college_name' => $request->jc_college_name,
            'jc_stream' => $request->jc_stream,
            'jc_board' => $request->jc_board,
            'jc_completion_year' => $request->jc_completion_year,
            '12th_mark_obtained' => $request->input('12th_mark_obtained'),
            '12th_mark_out_of' => $request->input('12th_mark_out_of'),
            'jc_percentage' => $request->jc_percentage,
            'jc_CGPA' => $request->jc_CGPA,

            // Completed Qualifications
            'qualifications' => $request->qualifications,
            'qualification_institution' => $request->qualification_institution,
            'qualification_university' => $request->qualification_university,
            'qualification_start_year' => $request->qualification_start_year ? Carbon::createFromFormat('Y-m', $request->qualification_start_year)->firstOfMonth()->format('Y-m-d') : null,
            'qualification_end_year' => $request->qualification_end_year ? Carbon::createFromFormat('Y-m', $request->qualification_end_year)->firstOfMonth()->format('Y-m-d') : null,
            'marksheet_type' => json_encode($request->marksheet_type),
            'marks_obtained' => json_encode($request->marks_obtained),
            'out_of' => json_encode($request->out_of),
            'percentage' => json_encode($request->percentage),
            'cgpa' => json_encode($request->cgpa),

            // Work Experience
            'have_work_experience' => $request->have_work_experience,
            'organization_name' => $request->organization_name,
            'work_profile' => $request->work_profile,
            'duration_start_year' => $request->duration_start_year,
            'duration_end_year' => $request->duration_end_year,
            'work_location_city' => $request->work_location_city,
            'work_country' => $request->work_country,
            'work_type' => $request->work_type,
            'mention_your_salary' => $request->mention_your_salary,
            'salary_amount' => $request->salary_amount,

            'status' => 'step2_completed',
            'submit_status' => 'submited',
        ];

        // Check if education details already exist for this user
        $educationDetail = EducationDetail::where('user_id', $user_id)->first();

        if ($educationDetail) {
            // Update existing record
            $educationDetail->update($data);
            $message = 'Education details updated successfully!';
        } else {
            // Create new record
            EducationDetail::create($data);
            $message = 'Education details saved successfully!';
        }

        return redirect()->route('user.step3')->with('success', $message);
    }





    public function step2_foreign_pg_store(Request $request)
    {
        // Validation for education details
        //  dd($request->all());
        $request->validate([
            // Financial Need Overview
            'course_name' => 'required|string|max:255',
            'university_name' => 'required|string|max:255',
            'college_name' => 'required|string|max:255',
            'country' => 'required|string|max:100',
            'city_name' => 'required|string|max:100',
            'start_year' => 'required|string',
            'expected_year' => 'required|string',
            'nirf_ranking' => 'nullable|string|max:50',

            // Financial Summary Table
            'group_1_year1' => 'nullable|numeric|min:0',
            'group_1_year2' => 'nullable|numeric|min:0',
            'group_1_year3' => 'nullable|numeric|min:0',
            'group_1_year4' => 'nullable|numeric|min:0',
            'group_1_year5' => 'nullable|numeric|min:0',
            'group_2_year1' => 'nullable|numeric|min:0',
            'group_2_year2' => 'nullable|numeric|min:0',
            'group_2_year3' => 'nullable|numeric|min:0',
            'group_2_year4' => 'nullable|numeric|min:0',
            'group_2_year5' => 'nullable|numeric|min:0',
            'group_3_year1' => 'nullable|numeric|min:0',
            'group_3_year2' => 'nullable|numeric|min:0',
            'group_3_year3' => 'nullable|numeric|min:0',
            'group_3_year4' => 'nullable|numeric|min:0',
            'group_3_year5' => 'nullable|numeric|min:0',
            'group_4_year1' => 'nullable|numeric|min:0',
            'group_4_year2' => 'nullable|numeric|min:0',
            'group_4_year3' => 'nullable|numeric|min:0',
            'group_4_year4' => 'nullable|numeric|min:0',
            'group_4_year5' => 'nullable|numeric|min:0',

            // School / 10th Grade Information
            'school_name' => 'nullable|string|max:255',
            'school_board' => 'nullable|string|max:100',
            'school_completion_year' => 'nullable|string|max:50',
            '10th_mark_obtained' => 'nullable|integer|min:0',
            '10th_mark_out_of' => 'nullable|integer|min:0',
            'school_percentage' => 'nullable|string|max:50',
            'school_CGPA' => 'nullable|string|max:50',

            // Junior College (12th Grade)
            'jc_college_name' => 'nullable|string|max:255',
            'jc_stream' => 'nullable|string|max:100',
            'jc_board' => 'nullable|string|max:100',
            'jc_completion_year' => 'nullable|string|max:50',
            '12th_mark_obtained' => 'nullable|integer|min:0',
            '12th_mark_out_of' => 'nullable|integer|min:0',
            'jc_percentage' => 'nullable|string|max:50',
            'jc_CGPA' => 'nullable|string|max:50',


            // Completed Qualifications
            'qualifications' => 'nullable|string',
            'qualification_institution' => 'nullable|string|max:255',
            'qualification_university' => 'nullable|string|max:255',
            'qualification_start_year' => 'nullable|date',
            'qualification_end_year' => 'nullable|date',
            'marksheet_type' => 'nullable|array',
            'marks_obtained' => 'nullable|array',
            'out_of' => 'nullable|array',
            'percentage' => 'nullable|array',
            'cgpa' => 'nullable|array',

            // Work Experience
            'have_work_experience' => 'nullable|in:yes,no',
            'organization_name' => 'nullable|string|max:255',
            'work_profile' => 'nullable|string|max:255',
            'duration_start_year' => 'nullable|string|max:50',
            'duration_end_year' => 'nullable|string|max:50',
            'work_location_city' => 'nullable|string|max:100',
            'work_country' => 'nullable|string|max:100',
            'work_type' => 'nullable|in:full-time,internship,freelance,volunteer',
            'mention_your_salary' => 'nullable|in:monthly,yearly,ctc',
            'salary_amount' => 'nullable|numeric|min:0',

            // Additional Curriculum
            'ielts_overall_band_year' => 'nullable|string|max:100',
            'toefl_score_year' => 'nullable|string|max:100',
            'duolingo_det_score_year' => 'nullable|string|max:100',
            'gre_score_year' => 'nullable|string|max:100',
            'gmat_score_year' => 'nullable|string|max:100',
            'sat_score_year' => 'nullable|string|max:100',
        ]);

        $user_id = Auth::id();

        $data = [
            'user_id' => $user_id,

            // Financial Need Overview
            'course_name' => $request->course_name,
            'university_name' => $request->university_name,
            'college_name' => $request->college_name,
            'country' => $request->country,
            'city_name' => $request->city_name,
            'start_year' => $request->start_year ? $request->start_year . '-01' : null, // Convert month to full date
            'expected_year' => $request->expected_year ? $request->expected_year . '-01' : null, // Convert month to full date
            'nirf_ranking' => $request->nirf_ranking,

            // Financial Summary Table
            'group_1_year1' => $request->group_1_year1,
            'group_1_year2' => $request->group_1_year2,
            'group_1_year3' => $request->group_1_year3,
            'group_1_year4' => $request->group_1_year4,
            'group_1_year5' => $request->group_1_year5,
            'group_2_year1' => $request->group_2_year1,
            'group_2_year2' => $request->group_2_year2,
            'group_2_year3' => $request->group_2_year3,
            'group_2_year4' => $request->group_2_year4,
            'group_2_year5' => $request->group_2_year5,
            'group_3_year1' => $request->group_3_year1,
            'group_3_year2' => $request->group_3_year2,
            'group_3_year3' => $request->group_3_year3,
            'group_3_year4' => $request->group_3_year4,
            'group_3_year5' => $request->group_3_year5,
            'group_4_year1' => $request->group_4_year1,
            'group_4_year2' => $request->group_4_year2,
            'group_4_year3' => $request->group_4_year3,
            'group_4_year4' => $request->group_4_year4,
            'group_4_year5' => $request->group_4_year5,

            // Calculate totals
            'group_1_total' => ($request->group_1_year1 ?: 0) + ($request->group_1_year2 ?: 0) + ($request->group_1_year3 ?: 0) + ($request->group_1_year4 ?: 0) + ($request->group_1_year5 ?: 0),
            'group_2_total' => ($request->group_2_year1 ?: 0) + ($request->group_2_year2 ?: 0) + ($request->group_2_year3 ?: 0) + ($request->group_2_year4 ?: 0) + ($request->group_2_year5 ?: 0),
            'group_3_total' => ($request->group_3_year1 ?: 0) + ($request->group_3_year2 ?: 0) + ($request->group_3_year3 ?: 0) + ($request->group_3_year4 ?: 0) + ($request->group_3_year5 ?: 0),
            'group_4_total' => ($request->group_4_year1 ?: 0) + ($request->group_4_year2 ?: 0) + ($request->group_4_year3 ?: 0) + ($request->group_4_year4 ?: 0) + ($request->group_4_year5 ?: 0),

            // School / 10th Grade Information
            'school_name' => $request->school_name,
            'school_board' => $request->school_board,
            'school_completion_year' => $request->school_completion_year,
            '10th_mark_obtained' => $request->input('10th_mark_obtained'),
            '10th_mark_out_of' => $request->input('10th_mark_out_of'),
            'school_percentage' => $request->school_percentage,
            'school_CGPA' => $request->school_CGPA,

            // Junior College (12th Grade)
            'jc_college_name' => $request->jc_college_name,
            'jc_stream' => $request->jc_stream,
            'jc_board' => $request->jc_board,
            'jc_completion_year' => $request->jc_completion_year,
            '12th_mark_obtained' => $request->input('12th_mark_obtained'),
            '12th_mark_out_of' => $request->input('12th_mark_out_of'),
            'jc_percentage' => $request->jc_percentage,
            'jc_CGPA' => $request->jc_CGPA,

            // Completed Qualifications
            'qualifications' => $request->qualifications,
            'qualification_institution' => $request->qualification_institution,
            'qualification_university' => $request->qualification_university,
            'qualification_start_year' => $request->qualification_start_year ? Carbon::createFromFormat('Y-m', $request->qualification_start_year)->firstOfMonth()->format('Y-m-d') : null,
            'qualification_end_year' => $request->qualification_end_year ? Carbon::createFromFormat('Y-m', $request->qualification_end_year)->firstOfMonth()->format('Y-m-d') : null,
            'marksheet_type' => json_encode($request->marksheet_type),
            'marks_obtained' => json_encode($request->marks_obtained),
            'out_of' => json_encode($request->out_of),
            'percentage' => json_encode($request->percentage),
            'cgpa' => json_encode($request->cgpa),

            // Work Experience
            'have_work_experience' => $request->have_work_experience,
            'organization_name' => $request->organization_name,
            'work_profile' => $request->work_profile,
            'duration_start_year' => $request->duration_start_year,
            'duration_end_year' => $request->duration_end_year,
            'work_location_city' => $request->work_location_city,
            'work_country' => $request->work_country,
            'work_type' => $request->work_type,
            'mention_your_salary' => $request->mention_your_salary,
            'salary_amount' => $request->salary_amount,

            // Additional Curriculum
            'ielts_overall_band_year' => $request->ielts_overall_band_year,
            'toefl_score_year' => $request->toefl_score_year,
            'duolingo_det_score_year' => $request->duolingo_det_score_year,
            'gre_score_year' => $request->gre_score_year,
            'gmat_score_year' => $request->gmat_score_year,
            'sat_score_year' => $request->sat_score_year,

            'status' => 'step2_completed',
            'submit_status' => 'submited',
        ];

        // Check if education details already exist for this user
        $educationDetail = EducationDetail::where('user_id', $user_id)->first();

        if ($educationDetail) {
            // Update existing record
            $educationDetail->update($data);
            $message = 'Education details updated successfully!';
        } else {
            // Create new record
            EducationDetail::create($data);
            $message = 'Education details saved successfully!';
        }

        return redirect()->route('user.step3')->with('success', $message);
    }





    public function step3(Request $request)
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        $type = Loan_category::where('user_id', $user_id)->latest()->first()->type;
        $familyDetail = Familydetail::where('user_id', $user_id)->first();

        // Get existing family members from database if they exist
        $existingFamilyMembers = [];
        if ($familyDetail && $familyDetail->additional_family_members) {
            $existingFamilyMembers = json_decode($familyDetail->additional_family_members, true) ?? [];
        }

        return view('user.step3', compact('type', 'familyDetail', 'user', 'existingFamilyMembers'));
    }


    public function step3store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'number_family_members' => 'required|integer|min:1',
            'total_family_income' => 'required|integer|min:0',
            'total_students' => 'required|integer|min:0',
            'family_member_diksha' => 'required',
            'total_insurance_coverage' => 'required|integer|min:0',
            'total_premium_paid' => 'required|integer|min:0',
            'recent_electricity_amount' => 'required|integer|min:0',
            'total_monthly_emi' => 'required|integer|min:0',
            'mediclaim_insurance_amount' => 'required|integer|min:0',
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

        // Custom validation: At least one complete relative set must be filled
        $paternalUncleComplete = !empty($request->paternal_uncle_name) &&
            !empty($request->paternal_uncle_mobile) &&
            !empty($request->paternal_uncle_email);

        $paternalAuntComplete = !empty($request->paternal_aunt_name) &&
            !empty($request->paternal_aunt_mobile) &&
            !empty($request->paternal_aunt_email);

        $maternalUncleComplete = !empty($request->maternal_uncle_name) &&
            !empty($request->maternal_uncle_mobile) &&
            !empty($request->maternal_uncle_email);

        $maternalAuntComplete = !empty($request->maternal_aunt_name) &&
            !empty($request->maternal_aunt_mobile) &&
            !empty($request->maternal_aunt_email);

        if (!$paternalUncleComplete && !$paternalAuntComplete && !$maternalUncleComplete && !$maternalAuntComplete) {
            return back()->withErrors(['relatives' => 'At least one complete relative set (name, mobile, and email) must be filled.'])->withInput();
        }

        $user_id = Auth::id();

        // Collect additional family members from dynamic table
        $additional_family_members = [];
        $i = 1;
        while ($request->has('family_' . $i . '_name')) {
            $additional_family_members[] = [
                'relation' => $request->input('family_' . $i . '_relation'),
                'name' => $request->input('family_' . $i . '_name'),
                'age' => $request->input('family_' . $i . '_age'),
                'marital_status' => $request->input('family_' . $i . '_marital_status'),
                'qualification' => $request->input('family_' . $i . '_qualification'),
                'occupation' => $request->input('family_' . $i . '_occupation'),
                'mobile' => $request->input('family_' . $i . '_mobile'),
                'email' => $request->input('family_' . $i . '_email'),
                'yearly_income' => $request->input('family_' . $i . '_yearly_income'),
            ];
            $i++;
        }

        $data = [
            'user_id' => $user_id,
            'number_family_members' => $request->number_family_members,
            'total_family_income' => $request->total_family_income,
            'total_students' => $request->total_students,
            'family_member_diksha' => $request->family_member_diksha,
            'diksha_member_name' => $request->diksha_member_name,
            'diksha_member_relation' => $request->diksha_member_relation,
            'total_insurance_coverage' => $request->total_insurance_coverage,
            'total_premium_paid' => $request->total_premium_paid,
            'recent_electricity_amount' => $request->recent_electricity_amount,
            'total_monthly_emi' => $request->total_monthly_emi,
            'mediclaim_insurance_amount' => $request->mediclaim_insurance_amount,
            'additional_family_members' => json_encode($additional_family_members),
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

        // Check if family details already exist for this user
        $familyDetail = Familydetail::where('user_id', $user_id)->first();

        if ($familyDetail) {
            // Update existing record
            $familyDetail->update($data);
            $message = 'Family details updated successfully!';
        } else {
            // Create new record
            Familydetail::create($data);
            $message = 'Family details saved successfully!';
        }

        return redirect()->route('user.step4')->with('success', $message);
    }





    public function step4(Request $request)
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        $familyDetail = Familydetail::where('user_id', $user_id)->first();
        $fundingDetail = FundingDetail::where('user_id', $user_id)->first();
        $type = Loan_category::where('user_id', $user_id)->latest()->first()->type;
        $banks = Bank::all();

        // Get existing funding data from database if they exist
        $existingFundingData = [];
        if ($fundingDetail) {
            $existingFundingData = [
                [
                    'status' => $fundingDetail->family_funding_status,
                    'institute_name' => $fundingDetail->family_funding_trust,
                    'contact_person' => $fundingDetail->family_funding_contact,
                    'contact_no' => $fundingDetail->family_funding_mobile,
                    'amount' => $fundingDetail->family_funding_amount,
                ],
                [
                    'status' => $fundingDetail->bank_loan_status,
                    'institute_name' => $fundingDetail->bank_loan_trust,
                    'contact_person' => $fundingDetail->bank_loan_contact,
                    'contact_no' => $fundingDetail->bank_loan_mobile,
                    'amount' => $fundingDetail->bank_loan_amount,
                ],
                [
                    'status' => $fundingDetail->other_assistance1_status,
                    'institute_name' => $fundingDetail->other_assistance1_trust,
                    'contact_person' => $fundingDetail->other_assistance1_contact,
                    'contact_no' => $fundingDetail->other_assistance1_mobile,
                    'amount' => $fundingDetail->other_assistance1_amount,
                ],
                [
                    'status' => $fundingDetail->other_assistance2_status,
                    'institute_name' => $fundingDetail->other_assistance2_trust,
                    'contact_person' => $fundingDetail->other_assistance2_contact,
                    'contact_no' => $fundingDetail->other_assistance2_mobile,
                    'amount' => $fundingDetail->other_assistance2_amount,
                ],
                [
                    'status' => $fundingDetail->local_assistance_status,
                    'institute_name' => $fundingDetail->local_assistance_trust,
                    'contact_person' => $fundingDetail->local_assistance_contact,
                    'contact_no' => $fundingDetail->local_assistance_mobile,
                    'amount' => $fundingDetail->local_assistance_amount,
                ],
            ];
        }

        return view('user.step4', compact('type', 'familyDetail', 'fundingDetail', 'existingFundingData', 'user', 'banks'));
    }





    public function step4store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'funding' => 'nullable|array',

            'funding.*.status' => 'nullable|in:applied,approved,received,pending',
            'funding.*.institute_name' => 'nullable|string|max:255',
            'funding.*.contact_person' => 'nullable|string|max:255',
            'funding.*.contact_no' => 'nullable|string|max:15',
            'funding.*.amount' => 'nullable|numeric|min:0',

            // Sibling Assistance
            'sibling_assistance' => 'required|in:yes,no',

            'sibling_name' => 'required_if:sibling_assistance,yes|string|max:255',
            'sibling_number' => 'required_if:sibling_assistance,yes|string|max:255',
            'sibling_ngo_name' => 'required_if:sibling_assistance,yes|string|max:255',
            'ngo_number' => 'required_if:sibling_assistance,yes|string|max:15',
            'sibling_loan_status' => 'required_if:sibling_assistance,yes|string|max:255',
            'sibling_applied_year' => 'required_if:sibling_assistance,yes|string|max:255',
            'sibling_applied_amount' => 'required_if:sibling_assistance,yes|numeric|min:0',

            // Bank Details
            'bank_name' => 'required|string|max:255',
            'account_holder_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'branch_name' => 'required|string|max:255',
            'ifsc_code' => 'required|string|max:20',
            'bank_address' => 'required|string|max:500',
        ]);
        // dd($request->all());
        $funding = $request->funding ?? [];

        $total_funding_amount = collect($funding)->sum(function ($row) {
            return $row['amount'] ?? 0;
        });

        $data = [
            'user_id' => Auth::id(),

            // Own Family Funding (Row 0)
            'family_funding_status'  => $funding[0]['status'] ?? null,
            'family_funding_trust'   => $funding[0]['institute_name'] ?? null,
            'family_funding_contact' => $funding[0]['contact_person'] ?? null,
            'family_funding_mobile'  => $funding[0]['contact_no'] ?? null,
            'family_funding_amount'  => $funding[0]['amount'] ?? null,

            // Bank Loan (Row 1)
            'bank_loan_status'  => $funding[1]['status'] ?? null,
            'bank_loan_trust'   => $funding[1]['institute_name'] ?? null,
            'bank_loan_contact' => $funding[1]['contact_person'] ?? null,
            'bank_loan_mobile'  => $funding[1]['contact_no'] ?? null,
            'bank_loan_amount'  => $funding[1]['amount'] ?? null,

            // Other Assistance 1 (Row 2)
            'other_assistance1_status'  => $funding[2]['status'] ?? null,
            'other_assistance1_trust'   => $funding[2]['institute_name'] ?? null,
            'other_assistance1_contact' => $funding[2]['contact_person'] ?? null,
            'other_assistance1_mobile'  => $funding[2]['contact_no'] ?? null,
            'other_assistance1_amount'  => $funding[2]['amount'] ?? null,

            // Other Assistance 2 (Row 3)
            'other_assistance2_status'  => $funding[3]['status'] ?? null,
            'other_assistance2_trust'   => $funding[3]['institute_name'] ?? null,
            'other_assistance2_contact' => $funding[3]['contact_person'] ?? null,
            'other_assistance2_mobile'  => $funding[3]['contact_no'] ?? null,
            'other_assistance2_amount'  => $funding[3]['amount'] ?? null,

            // Local Assistance (Row 4)
            'local_assistance_status'  => $funding[4]['status'] ?? null,
            'local_assistance_trust'   => $funding[4]['institute_name'] ?? null,
            'local_assistance_contact' => $funding[4]['contact_person'] ?? null,
            'local_assistance_mobile'  => $funding[4]['contact_no'] ?? null,
            'local_assistance_amount'  => $funding[4]['amount'] ?? null,

            'total_funding_amount' => $total_funding_amount,

            // Sibling Assistance
            'sibling_assistance' => $request->sibling_assistance,
            'sibling_name' => $request->sibling_name,
            'sibling_number' => $request->sibling_number,
            'sibling_ngo_name' => $request->sibling_ngo_name,
            'ngo_number' => $request->ngo_number,
            'sibling_loan_status' => $request->sibling_loan_status,
            'sibling_applied_year' => $request->sibling_applied_year,
            'sibling_applied_amount' => $request->sibling_applied_amount,

            // Bank Details
            'bank_name' => $request->bank_name,
            'account_holder_name' => $request->account_holder_name,
            'account_number' => $request->account_number,
            'branch_name' => $request->branch_name,
            'ifsc_code' => $request->ifsc_code,
            'bank_address' => $request->bank_address,

            'status' => 'step4_completed',
            'submit_status' => 'submited',
        ];

        // Check if funding details already exist for this user
        $fundingDetail = FundingDetail::where('user_id', Auth::id())->first();

        if ($fundingDetail) {
            // Update existing record
            $fundingDetail->update($data);
            $message = 'Funding details updated successfully!';
        } else {
            // Create new record
            FundingDetail::create($data);
            $message = 'Funding details saved successfully!';
        }

        return redirect()->route('user.step5')
            ->with('success', $message);
    }


    // public function step4store(Request $request)
    // {
    //     dd($request->all());

    //     $request->validate([
    //         // Amount Requested
    //         'amount_requested_year' => 'required|in:year1,year2,year3,year4',
    //         'tuition_fees_amount' => 'required|numeric|min:0',

    //         // Funding Details Table (all optional)
    //         'family_funding_status' => 'nullable|in:applied,approved,received,pending',
    //         'family_funding_amount' => 'nullable|numeric|min:0',
    //         'bank_loan_status' => 'nullable|in:applied,approved,received,pending',
    //         'bank_loan_amount' => 'nullable|numeric|min:0',
    //         'other_assistance1_status' => 'nullable|in:applied,approved,received,pending',
    //         'other_assistance1_amount' => 'nullable|numeric|min:0',
    //         'other_assistance2_status' => 'nullable|in:applied,approved,received,pending',
    //         'other_assistance2_amount' => 'nullable|numeric|min:0',
    //         'local_assistance_status' => 'nullable|in:applied,approved,received,pending',
    //         'local_assistance_amount' => 'nullable|numeric|min:0',

    //         // Sibling Assistance
    //         'sibling_assistance' => 'required|in:yes,no',
    //         'sibling_ngo_name' => 'nullable|string|max:255',
    //         'sibling_loan_status' => 'nullable|string|max:255',
    //         'sibling_applied_year' => 'nullable|string|max:255',
    //         'sibling_applied_amount' => 'nullable|numeric|min:0',

    //         // Bank Details
    //         'account_holder_name' => 'required|string|max:255',
    //         'bank_name' => 'required|string|max:255',
    //         'account_number' => 'required|string|max:50',
    //         'branch_name' => 'required|string|max:255',
    //         'ifsc_code' => 'required|string|max:20',
    //         'bank_address' => 'required|string|max:500',
    //     ]);

    //     $user_id = Auth::id();

    //     // Additional validation for sibling assistance conditional fields
    //     if ($request->sibling_assistance === 'yes') {
    //         $request->validate([
    //             'sibling_ngo_name' => 'required|string|max:255',
    //             'sibling_loan_status' => 'required|string|max:255',
    //             'sibling_applied_year' => 'required|string|max:255',
    //             'sibling_applied_amount' => 'required|numeric|min:0',
    //         ]);
    //     }

    //     $data = [
    //         'user_id' => $user_id,

    //         // Amount Requested
    //         'amount_requested_year' => $request->amount_requested_year,
    //         'tuition_fees_amount' => $request->tuition_fees_amount,

    //         // Own family funding
    //         'family_funding_status' => $request->family_funding_status,
    //         'family_funding_trust' => $request->family_funding_trust,
    //         'family_funding_contact' => $request->family_funding_contact,
    //         'family_funding_mobile' => $request->family_funding_mobile,
    //         'family_funding_amount' => $request->family_funding_amount,

    //         // Bank Loan
    //         'bank_loan_status' => $request->bank_loan_status,
    //         'bank_loan_trust' => $request->bank_loan_trust,
    //         'bank_loan_contact' => $request->bank_loan_contact,
    //         'bank_loan_mobile' => $request->bank_loan_mobile,
    //         'bank_loan_amount' => $request->bank_loan_amount,

    //         // Other Assistance (1)
    //         'other_assistance1_status' => $request->other_assistance1_status,
    //         'other_assistance1_trust' => $request->other_assistance1_trust,
    //         'other_assistance1_contact' => $request->other_assistance1_contact,
    //         'other_assistance1_mobile' => $request->other_assistance1_mobile,
    //         'other_assistance1_amount' => $request->other_assistance1_amount,

    //         // Other Assistance (2)
    //         'other_assistance2_status' => $request->other_assistance2_status,
    //         'other_assistance2_trust' => $request->other_assistance2_trust,
    //         'other_assistance2_contact' => $request->other_assistance2_contact,
    //         'other_assistance2_mobile' => $request->other_assistance2_mobile,
    //         'other_assistance2_amount' => $request->other_assistance2_amount,

    //         // Local Assistance
    //         'local_assistance_status' => $request->local_assistance_status,
    //         'local_assistance_trust' => $request->local_assistance_trust,
    //         'local_assistance_contact' => $request->local_assistance_contact,
    //         'local_assistance_mobile' => $request->local_assistance_mobile,
    //         'local_assistance_amount' => $request->local_assistance_amount,

    //         // Total funding amount (calculate from table)
    //         'total_funding_amount' => ($request->family_funding_amount ?: 0) +
    //             ($request->bank_loan_amount ?: 0) +
    //             ($request->other_assistance1_amount ?: 0) +
    //             ($request->other_assistance2_amount ?: 0) +
    //             ($request->local_assistance_amount ?: 0),

    //         // Sibling Assistance
    //         'sibling_assistance' => $request->sibling_assistance,
    //         'sibling_ngo_name' => $request->sibling_ngo_name,
    //         'sibling_loan_status' => $request->sibling_loan_status,
    //         'sibling_applied_year' => $request->sibling_applied_year,
    //         'sibling_applied_amount' => $request->sibling_applied_amount,

    //         // Bank Details
    //         'account_holder_name' => $request->account_holder_name,
    //         'bank_name' => $request->bank_name,
    //         'account_number' => $request->account_number,
    //         'branch_name' => $request->branch_name,
    //         'ifsc_code' => $request->ifsc_code,
    //         'bank_address' => $request->bank_address,

    //         'status' => 'step4_completed',
    //     ];

    //     FundingDetail::create($data);

    //     return redirect()->route('user.home')->with('success', 'Funding details saved successfully!');
    // }

    public function step5(Request $request)
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        $type = Loan_category::where('user_id', $user_id)->latest()->first()->type;
        $familyDetail = Familydetail::where('user_id', $user_id)->first();
        $fundingDetail = FundingDetail::where('user_id', $user_id)->first();
        $guarantorDetail = GuarantorDetail::where('user_id', $user_id)->first();

        return view('user.step5', compact('type', 'familyDetail', 'fundingDetail', 'user', 'guarantorDetail'));
    }

    // public function step5store(Request $request)
    // {
    //     $request->validate([
    //         // First Guarantor
    //         'g_one_name' => 'required|string|max:255',
    //         'g_one_gender' => 'required|in:male,female',
    //         'g_one_permanent_address' => 'required|string|max:500',
    //         'g_one_phone' => 'required|string|max:15',
    //         'g_one_email' => 'required|email|max:255',
    //         'g_one_relation_with_student' => 'required|string|max:255',
    //         'g_one_aadhar_card_number' => 'required|string|max:12',
    //         'g_one_pan_card_no' => 'required|string|max:10',
    //         'g_one_d_o_b' => 'required|date_format:d-m-Y',
    //         'g_one_income' => 'required|string|max:50',
    //         'g_one_pan_card' => 'required|file|mimes:jpg,jpeg,png|max:2048',

    //         // Second Guarantor
    //         'g_two_name' => 'required|string|max:255',
    //         'g_two_gender' => 'required|in:male,female',
    //         'g_two_permanent_address' => 'required|string|max:500',
    //         'g_two_phone' => 'required|string|max:15',
    //         'g_two_email' => 'required|email|max:255',
    //         'g_two_relation_with_student' => 'required|string|max:255',
    //         'g_two_aadhar_card_number' => 'required|string|max:12',
    //         'g_two_pan_card_no' => 'required|string|max:10',
    //         'g_two_d_o_b' => 'required|date_format:d-m-Y',
    //         'g_two_income' => 'required|string|max:50',
    //         'g_two_pan_card' => 'required|file|mimes:jpg,jpeg,png|max:2048',

    //         // Power of Attorney
    //         // 'attorney_name' => 'required|string|max:255',
    //         // 'attorney_email' => 'required|email|max:255',
    //         // 'attorney_phone' => 'required|string|max:15',
    //         // 'attorney_address' => 'required|string|max:500',
    //         // 'attorney_relation_with_student' => 'required|string|max:255',
    //     ]);

    //     $user_id = Auth::id();

    //     $data = [
    //         'user_id' => $user_id,

    //         // First Guarantor
    //         'g_one_name' => $request->g_one_name,
    //         'g_one_gender' => $request->g_one_gender,
    //         'g_one_permanent_address' => $request->g_one_permanent_address,
    //         'g_one_phone' => $request->g_one_phone,
    //         'g_one_email' => $request->g_one_email,
    //         'g_one_relation_with_student' => $request->g_one_relation_with_student,
    //         'g_one_aadhar_card_number' => $request->g_one_aadhar_card_number,
    //         'g_one_pan_card_no' => $request->g_one_pan_card_no,
    //         'g_one_d_o_b' => Carbon::createFromFormat('d-m-Y', $request->g_one_d_o_b)->format('Y-m-d'),
    //         'g_one_income' => $request->g_one_income,

    //         // Second Guarantor
    //         'g_two_name' => $request->g_two_name,
    //         'g_two_gender' => $request->g_two_gender,
    //         'g_two_permanent_address' => $request->g_two_permanent_address,
    //         'g_two_phone' => $request->g_two_phone,
    //         'g_two_email' => $request->g_two_email,
    //         'g_two_relation_with_student' => $request->g_two_relation_with_student,
    //         'g_two_aadhar_card_number' => $request->g_two_aadhar_card_number,
    //         'g_two_pan_card_no' => $request->g_two_pan_card_no,
    //         'g_two_d_o_b' => Carbon::createFromFormat('d-m-Y', $request->g_two_d_o_b)->format('Y-m-d'),
    //         'g_two_income' => $request->g_two_income,

    //         // Power of Attorney
    //         // 'attorney_name' => $request->attorney_name,
    //         // 'attorney_email' => $request->attorney_email,
    //         // 'attorney_phone' => $request->attorney_phone,
    //         // 'attorney_address' => $request->attorney_address,
    //         // 'attorney_relation_with_student' => $request->attorney_relation_with_student,

    //         'status' => 'step5_completed',
    //     ];

    //     // Handle file uploads
    //     if ($request->hasFile('g_one_pan_card')) {
    //         $gOnePanName = time() . '_g_one_pan.' . $request->g_one_pan_card->extension();
    //         $request->g_one_pan_card->move('images', $gOnePanName);
    //         $data['g_one_pan_card_upload'] = 'images/' . $gOnePanName;
    //     }

    //     if ($request->hasFile('g_two_pan_card')) {
    //         $gTwoPanName = time() . '_g_two_pan.' . $request->g_two_pan_card->extension();
    //         $request->g_two_pan_card->move('images', $gTwoPanName);
    //         $data['g_two_pan_card_upload'] = 'images/' . $gTwoPanName;
    //     }

    //     GuarantorDetail::create($data);

    //     return redirect()->route('user.step6')->with('success', 'Guarantor details saved successfully!');
    // }


    public function step5store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            // First Guarantor
            'g_one_name' => 'required|string|max:255',
            'g_one_gender' => 'required|in:male,female',
            'g_one_permanent_flat_no' => 'required|string',
            'g_one_permanent_address' => 'required|string',
            'g_one_city' => 'required|string|max:100',
            'g_one_district' => 'required|string|max:100',
            'g_one_state' => 'required|string|max:100',
            'g_one_pincode' => 'required|digits:6',
            'g_one_phone' => 'required|string|max:15|unique:guarantor_details,g_one_phone',
            'g_one_email' => 'required|email|max:255|unique:guarantor_details,g_one_email',
            'g_one_relation_with_student' => 'required|string|max:255',
            'g_one_aadhar_card_number' => 'required|digits:12',
            'g_one_d_o_b' => 'required|date',
            'g_one_srvice' => 'required|string|max:255',
            'g_one_income' => 'required|numeric|min:0',


            // Second Guarantor
            'g_two_name' => 'required|string|max:255',
            'g_two_gender' => 'required|in:male,female',
            'g_two_permanent_flat_no' => 'required|string',
            'g_two_permanent_address' => 'required|string',
            'g_two_city' => 'required|string|max:100',
            'g_two_district' => 'required|string|max:100',
            'g_two_state' => 'required|string|max:100',
            'g_two_pincode' => 'required|digits:6',
            'g_two_phone' => 'required|string|max:15|unique:guarantor_details,g_two_phone',
            'g_two_email' => 'required|email|max:255|unique:guarantor_details,g_two_email',
            'g_two_relation_with_student' => 'required|string|max:255',
            'g_two_aadhar_card_number' => 'required|digits:12',
            'g_two_d_o_b' => 'required|date',
            'g_two_srvice' => 'required|string|max:255',
            'g_two_income' => 'required|numeric|min:0',

        ]);

        $user_id = Auth::id();

        $data = [
            'user_id' => $user_id,

            // First Guarantor
            'g_one_name' => $request->g_one_name,
            'g_one_gender' => $request->g_one_gender,
            'g_one_permanent_flat_no' => $request->g_one_permanent_flat_no,
            'g_one_permanent_address' => $request->g_one_permanent_address,
            'g_one_permanent_city' => $request->g_one_city,
            'g_one_permanent_district' => $request->g_one_district,
            'g_one_permanent_state' => $request->g_one_state,
            'g_one_permanent_pincode' => $request->g_one_pincode,
            'g_one_phone' => $request->g_one_phone,
            'g_one_email' => $request->g_one_email,
            'g_one_relation_with_student' => $request->g_one_relation_with_student,
            'g_one_aadhar_card_number' => $request->g_one_aadhar_card_number,
            'g_one_d_o_b' => $request->g_one_d_o_b,

            'g_one_srvice' => $request->g_one_srvice,
            'g_one_income' => $request->g_one_income,

            // Second Guarantor
            'g_two_name' => $request->g_two_name,
            'g_two_gender' => $request->g_two_gender,
            'g_two_permanent_flat_no' => $request->g_two_permanent_flat_no,
            'g_two_permanent_address' => $request->g_two_permanent_address,
            'g_two_permanent_city' => $request->g_two_city,
            'g_two_permanent_district' => $request->g_two_district,
            'g_two_permanent_state' => $request->g_two_state,
            'g_two_permanent_pincode' => $request->g_two_pincode,
            'g_two_phone' => $request->g_two_phone,
            'g_two_email' => $request->g_two_email,
            'g_two_relation_with_student' => $request->g_two_relation_with_student,
            'g_two_aadhar_card_number' => $request->g_two_aadhar_card_number,
            'g_two_d_o_b' =>  $request->g_two_d_o_b,
            'g_two_srvice' => $request->g_two_srvice,
            'g_two_income' => $request->g_two_income,

            'status' => 'step5_completed',
            'submit_status' => 'submited',
        ];

        // Check if guarantor details already exist for this user
        $guarantorDetail = GuarantorDetail::where('user_id', $user_id)->first();

        if ($guarantorDetail) {
            // Update existing record
            $guarantorDetail->update($data);
            $message = 'Guarantor details updated successfully!';
        } else {
            // Create new record
            GuarantorDetail::create($data);
            $message = 'Guarantor details saved successfully!';
        }

        return redirect()->route('user.step6')->with('success', $message);
    }

    public function step6(Request $request)
    {
        $user_id = Auth::id();
        $type = Loan_category::where('user_id', $user_id)->latest()->first()->type;
        $user = User::find($user_id);
        $documents = Document::where('user_id', $user_id)->first();
        if ($user->financial_asset_type == 'domestic' && $user->financial_asset_for == 'graduation') {
            return view('user.step6_ug', compact('type', 'user', 'documents'));
        } else if ($user->financial_asset_type == 'domestic' && $user->financial_asset_for == 'post_graduation') {
            return view('user.step6_pg', compact('type', 'user', 'documents'));
        } else if ($user->financial_asset_type == 'foreign_finance_assistant' && $user->financial_asset_for == 'post_graduation') {
            return view('user.step6_pg_foreign', compact('type', 'user', 'documents'));
        }
        // return view('user.step6', compact('type', 'user'));
    }

    public function step6store(Request $request)
    {
        Log::info('Step6Store: Method called', [
            'user_id' => Auth::id(),
            'request_method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'files_count' => count($request->allFiles()),
            'all_files' => array_keys($request->allFiles()),
            'has_csrf' => $request->has('_token'),
            'csrf_token' => $request->input('_token') ? 'present' : 'missing'
        ]);

        try {
            $existing = Document::where('user_id', Auth::id())->first();
            $rules = [];
            $requiredFields = [
                'ssc_cbse_icse_ib_igcse',
                'hsc_diploma_marksheet',
                'graduate_post_graduate_marksheet',
                'admission_letter_fees_structure',
                'aadhaar_applicant',
                'pan_applicant',
                'student_bank_details_statement',
                'jito_group_recommendation',
                'jain_sangh_certificate',
                'electricity_bill',
                'itr_acknowledgement_father',
                'itr_computation_father',
                'form16_salary_income_father',
                'bank_statement_father_12months',
                'bank_statement_mother_12months',
                'aadhaar_father_mother',
                'pan_father_mother',
                'guarantor1_aadhaar',
                'guarantor1_pan',
                'guarantor2_aadhaar'
            ];
            foreach ($requiredFields as $field) {
                $rules[$field] = (isset($existing->$field) ? 'nullable' : 'required') . '|file|mimes:jpg,jpeg,png,pdf|max:5120';
            }
            $rules['guarantor2_pan'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            $rules['student_handwritten_statement'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            $rules['proof_funds_arranged'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            $rules['other_documents'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            $rules['extra_curricular'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';

            $request->validate($rules);

            $user_id = Auth::id();

            $data = [
                'user_id' => $user_id,
                'status' => 'step6_completed',
                'submit_status' => 'submited',
            ];

            // Handle file uploads
            $files = [
                'ssc_cbse_icse_ib_igcse',
                'hsc_diploma_marksheet',
                'graduate_post_graduate_marksheet',
                'admission_letter_fees_structure',
                'aadhaar_applicant',
                'pan_applicant',
                'student_bank_details_statement',
                'jito_group_recommendation',
                'jain_sangh_certificate',
                'electricity_bill',
                'itr_acknowledgement_father',
                'itr_computation_father',
                'form16_salary_income_father',
                'bank_statement_father_12months',
                'bank_statement_mother_12months',
                'aadhaar_father_mother',
                'pan_father_mother',
                'guarantor1_aadhaar',
                'guarantor1_pan',
                'guarantor2_aadhaar',
                'guarantor2_pan',
                'student_handwritten_statement',
                'proof_funds_arranged',
                'other_documents',
                'extra_curricular'
            ];

            foreach ($files as $file) {
                if ($request->hasFile($file)) {
                    $fileName = time() . '_' . $file . '.' . $request->$file->extension();
                    $request->$file->move('user_document_images', $fileName);
                    $data[$file] = 'user_document_images/' . $fileName;
                }
            }

            $document = Document::where('user_id', $user_id)->first();

            if ($document) {
                $document->update($data);
                $message = 'Documents updated successfully!';
            } else {
                Document::create($data);
                $message = 'Documents uploaded successfully!';
            }

            Log::info('Step6Store: Document created successfully', ['user_id' => $user_id, 'document_id' => Document::latest()->first()->id]);

            return redirect()->route('user.step7')->with('success', $message);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Step6Store: Validation failed', [
                'user_id' => Auth::id(),
                'errors' => $e->errors()
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Step6Store: Unexpected error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }


    public function step6storeug(Request $request)
    {
        Log::info('Step6Store: Method called', [
            'user_id' => Auth::id(),
            'request_method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'files_count' => count($request->allFiles()),
            'all_files' => array_keys($request->allFiles()),
            'has_csrf' => $request->has('_token'),
            'csrf_token' => $request->input('_token') ? 'present' : 'missing'
        ]);

        try {
            $existing = Document::where('user_id', Auth::id())->first();
            $rules = [];
            $requiredFields = [
                'ssc_cbse_icse_ib_igcse',
                'hsc_diploma_marksheet',
                'admission_letter_fees_structure',
                'aadhaar_applicant',
                'pan_applicant',
                'student_bank_details_statement',
                'jito_group_recommendation',
                'jain_sangh_certificate',
                'electricity_bill',
                'itr_acknowledgement_father',
                'itr_computation_father',
                'form16_salary_income_father',
                'bank_statement_father_12months',
                'bank_statement_mother_12months',
                'aadhaar_father_mother',
                'pan_father_mother',
                'guarantor1_aadhaar',
                'guarantor1_pan',
                'guarantor2_aadhaar'
            ];
            foreach ($requiredFields as $field) {
                $rules[$field] = (isset($existing->$field) ? 'nullable' : 'required') . '|file|mimes:jpg,jpeg,png,pdf|max:5120';
            }
            $rules['guarantor2_pan'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            $rules['student_handwritten_statement'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            $rules['proof_funds_arranged'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            $rules['other_documents'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            $rules['extra_curricular'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';

            $request->validate($rules);

            $user_id = Auth::id();

            $data = [
                'user_id' => $user_id,
                'status' => 'step6_completed',
                'submit_status' => 'submited',
            ];

            // Handle file uploads
            $files = [
                'ssc_cbse_icse_ib_igcse',
                'hsc_diploma_marksheet',

                'admission_letter_fees_structure',
                'aadhaar_applicant',
                'pan_applicant',
                'student_bank_details_statement',
                'jito_group_recommendation',
                'jain_sangh_certificate',
                'electricity_bill',
                'itr_acknowledgement_father',
                'itr_computation_father',
                'form16_salary_income_father',
                'bank_statement_father_12months',
                'bank_statement_mother_12months',
                'aadhaar_father_mother',
                'pan_father_mother',
                'guarantor1_aadhaar',
                'guarantor1_pan',
                'guarantor2_aadhaar',
                'guarantor2_pan',
                'student_handwritten_statement',
                'proof_funds_arranged',
                'other_documents',
                'extra_curricular'
            ];

            foreach ($files as $file) {
                if ($request->hasFile($file)) {
                    $fileName = time() . '_' . $file . '.' . $request->$file->extension();
                    $request->$file->move('user_document_images', $fileName);
                    $data[$file] = 'user_document_images/' . $fileName;
                }
            }

            $document = Document::where('user_id', $user_id)->first();

            if ($document) {
                $document->update($data);
                $message = 'Documents updated successfully!';
            } else {
                Document::create($data);
                $message = 'Documents uploaded successfully!';
            }

            Log::info('Step6Store: Document created successfully', ['user_id' => $user_id, 'document_id' => Document::latest()->first()->id]);

            return redirect()->route('user.step7')->with('success', $message);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Step6Store: Validation failed', [
                'user_id' => Auth::id(),
                'errors' => $e->errors()
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Step6Store: Unexpected error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }


    public function step6storeforeign(Request $request)
    {
        Log::info('Step6Store: Method called', [
            'user_id' => Auth::id(),
            'request_method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'files_count' => count($request->allFiles()),
            'all_files' => array_keys($request->allFiles()),
            'has_csrf' => $request->has('_token'),
            'csrf_token' => $request->input('_token') ? 'present' : 'missing'
        ]);

        try {
            $existing = Document::where('user_id', Auth::id())->first();
            $rules = [];
            $requiredFields = [
                'ssc_cbse_icse_ib_igcse',
                'hsc_diploma_marksheet',
                'graduate_post_graduate_marksheet',
                'admission_letter_fees_structure',
                'passport_applicant',
                'visa_applicant',
                'aadhaar_applicant',
                'pan_applicant',
                'student_bank_details_statement',
                'jito_group_recommendation',
                'jain_sangh_certificate',
                'electricity_bill',
                'itr_acknowledgement_father',
                'itr_computation_father',
                'form16_salary_income_father',
                'bank_statement_father_12months',
                'bank_statement_mother_12months',
                'aadhaar_father_mother',
                'pan_father_mother',
                'guarantor1_aadhaar',
                'guarantor1_pan',
                'guarantor2_aadhaar'
            ];
            foreach ($requiredFields as $field) {
                $rules[$field] = (isset($existing->$field) ? 'nullable' : 'required') . '|file|mimes:jpg,jpeg,png,pdf|max:5120';
            }
            $rules['guarantor2_pan'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            $rules['student_handwritten_statement'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            $rules['proof_funds_arranged'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            $rules['other_documents'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            $rules['extra_curricular'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';

            $request->validate($rules);

            $user_id = Auth::id();

            $data = [
                'user_id' => $user_id,
                'status' => 'step6_completed',
                'submit_status' => 'submited',
            ];

            // Handle file uploads
            $files = [
                'ssc_cbse_icse_ib_igcse',
                'hsc_diploma_marksheet',
                'graduate_post_graduate_marksheet',
                'admission_letter_fees_structure',
                'passport_applicant',
                'visa_applicant',
                'aadhaar_applicant',
                'pan_applicant',
                'student_bank_details_statement',
                'jito_group_recommendation',
                'jain_sangh_certificate',
                'electricity_bill',
                'itr_acknowledgement_father',
                'itr_computation_father',
                'form16_salary_income_father',
                'bank_statement_father_12months',
                'bank_statement_mother_12months',
                'aadhaar_father_mother',
                'pan_father_mother',
                'guarantor1_aadhaar',
                'guarantor1_pan',
                'guarantor2_aadhaar',
                'guarantor2_pan',
                'student_handwritten_statement',
                'proof_funds_arranged',
                'other_documents',
                'extra_curricular'
            ];

            foreach ($files as $file) {
                if ($request->hasFile($file)) {
                    $fileName = time() . '_' . $file . '.' . $request->$file->extension();
                    $request->$file->move('user_document_images', $fileName);
                    $data[$file] = 'user_document_images/' . $fileName;
                }
            }

            $document = Document::where('user_id', $user_id)->first();

            if ($document) {
                $document->update($data);
                $message = 'Documents updated successfully!';
            } else {
                Document::create($data);
                $message = 'Documents uploaded successfully!';
            }

            Log::info('Step6Store: Document created successfully', ['user_id' => $user_id, 'document_id' => Document::latest()->first()->id]);

            return redirect()->route('user.step7')->with('success', $message);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Step6Store: Validation failed', [
                'user_id' => Auth::id(),
                'errors' => $e->errors()
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Step6Store: Unexpected error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function step7(Request $request)
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        $type = Loan_category::where('user_id', $user_id)->latest()->first()->type;
        return view('user.step7', compact('type', 'user'));
    }

    public function step7store(Request $request)
    {
        $user_id = Auth::id();

        // Check if workflow status already exists for this user
        $workflow = ApplicationWorkflowStatus::where('user_id', $user_id)->first();

        if (!$workflow) {
            // Create new workflow entry
            ApplicationWorkflowStatus::create([
                'user_id' => $user_id,
                'current_stage' => 'apex_1',
                'final_status' => 'in_progress',
            ]);
            $message = 'Application submitted successfully!';
        } else {
            // Update if exists
            $workflow->update([
                'current_stage' => 'apex_1',
                'final_status' => 'in_progress',
            ]);
            $message = 'Application resubmitted successfully!';
        }

        // Update user's application_status to 'submitted' or similar
        $user = User::find($user_id);
        $user->update(['application_status' => 'submitted']);

        return redirect()->route('user.home')->with('success', $message);
    }

    public function getChapters(Request $request, $pincode)
    {
        try {
            Log::info('getChapters called with pincode: ' . $pincode);

            $service = new \App\Services\PincodeService();
            $result = $service->resolveChapter($pincode);

            Log::info('getChapters - resolveChapter result', [
                'pincode' => $pincode,
                'assigned_by' => $result['assigned_by'],
                'chapter' => $result['chapter']?->chapter_name ?? null,
                'chapter_id' => $result['chapter']?->id ?? null,
                'nearest_pincode' => $result['nearest_pincode'] ?? null,
                'distance' => $result['distance'] ?? null,
                'state' => $result['state'] ?? null
            ]);

            $chapterName = $result['chapter']?->chapter_name ?? null;
            $zoneName = $result['chapter']?->zone?->zone_name ?? null;
            $chairman = $result['chapter']?->chapter_head ?? null;
            $contact = $result['chapter']?->contact ?? null;
            $fallback = in_array($result['assigned_by'], ['nearest', 'nearest_pincode']);
            $fallback = in_array($result['assigned_by'], ['nearest_pincode_same_state', 'nearest_pincode_any_state', 'nearest_chapter']);

            // Include distance and location info for all assignments that have distance data
            $response = [
                'success' => true,
                'chapter' => $chapterName,
                'zone' => $zoneName,
                'chairman' => $chairman,
                'contact' => $contact,
                'fallback' => $fallback,
                'assigned_by' => $result['assigned_by'],
            ];

            if (isset($result['distance']) && $result['distance'] !== null) {
                $response['distance'] = round($result['distance'], 1);
                $response['nearest_pincode'] = $result['nearest_pincode'] ?? null;
                $response['state'] = $result['state'] ?? null;
            }

            Log::info('getChapters response', [
                'pincode' => $pincode,
                'response' => $response
            ]);

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('getChapters error: ' . $e->getMessage(), [
                'pincode' => $pincode,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error fetching chapter: ' . $e->getMessage(),
                'chapter' => null
            ], 500);
        }
    }
}
