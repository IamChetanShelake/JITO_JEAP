<?php

namespace App\Http\Controllers;


use App\Models\Bank;
use App\Models\Logs;
use App\Models\User;
use App\Models\Subcast;
use App\Models\Document;
use App\Models\PdcDetail;
use App\Models\ThirdStageDocument;
use App\Models\Familydetail;
use App\Models\ReviewSubmit;
use App\Models\EditBankDetailRequest;
use App\Models\JitoJeapBank;
use Illuminate\Http\Request;
use App\Models\FundingDetail;
use App\Models\Loan_category;
use App\Mail\ApplicationSubmittedSuccessfullyMail;
use Illuminate\Support\Carbon;
use App\Models\EducationDetail;
use App\Models\GuarantorDetail;
use Illuminate\Validation\Rule;
use App\Traits\LogsUserActivity;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\ApplicationWorkflowStatus;
use App\Models\UniversityWebsite;
use App\Models\CollegeWebsite;
use Barryvdh\DomPDF\Facade\Pdf;


class UserController extends Controller
{
    use LogsUserActivity;
    public function index()
    {
        $user_id = Auth::id();

        $existingLoan = Loan_category::where('user_id', $user_id)->latest()->first();
        if ($existingLoan) {
            // Load all user details
            $user = User::find($user_id);
            $educationDetail = EducationDetail::where('user_id', $user_id)->first();
            $familyDetail = Familydetail::where('user_id', $user_id)->first();
            $fundingDetail = FundingDetail::where('user_id', $user_id)->first();
            $guarantorDetail = GuarantorDetail::where('user_id', $user_id)->first();
            $document = Document::where('user_id', $user_id)->first();

            // Check if loan category is below 1 lakh
            $isBelowOneLakh = $existingLoan->type === 'below';

            // Check progression and redirect to next incomplete step
            // Step 1 - Personal Details
            if (!$user || $user->submit_status !== 'submited') {
                return redirect()->route('user.step1');
            }

            // Step 2 - Education Details (for Postgrad) or Family Details (for others)
            if (!$educationDetail || $educationDetail->submit_status !== 'submited') {
                return redirect()->route('user.step2');
            }

            // Step 3 - Family Details
            if (!$familyDetail || $familyDetail->submit_status !== 'submited') {
                return redirect()->route('user.step3');
            }

            // Step 4 - Funding Details
            if (!$fundingDetail || $fundingDetail->submit_status !== 'submited') {
                return redirect()->route('user.step4');
            }

            // Step 5 - Guarantor Details (skip for below 1 lakh)
            if (!$isBelowOneLakh) {
                if (!$guarantorDetail || $guarantorDetail->submit_status !== 'submited') {
                    return redirect()->route('user.step5');
                }
            }

            // Step 6 - Document Upload
            if (!$document || $document->submit_status !== 'submited') {
                return redirect()->route('user.step6');
            }

            // All steps completed - redirect to Step 7 (Review & Submit)
            return redirect()->route('user.step7');
        }
        $user = Auth::user();
        return view('user.home', compact('user'));
    }

    public function applyLoan(Request $request, $type)
    {
        $user_id = Auth::id();
        // dd($type, $user_id);
        $loancategory = Loan_category::where('user_id', $user_id)->first();

        if ($loancategory) {
            $loancategory->type = $type;
            $loancategory->save();
        } else {
            $loancategory = new Loan_category();
            $loancategory->user_id = $user_id;
            $loancategory->type = $type;
            $loancategory->save();
        }
        // $loancategory = new Loan_category();
        // $loancategory->user_id = $user_id;
        // $loancategory->type = $type;
        // $loancategory->save();

        // Log application submission
        $user = User::find($user_id);
        if ($user) {
            $this->logUserActivity(
                processType: 'Loan Category ' . $type . ' 1 lakh submitted',
                processAction: 'Loan Category submitted',
                processDescription: 'User submitted loan category selection for ' . $type . '1 lakh.',
                module: 'loan Ctegory selection',
                oldValues: null,
                newValues: null,
                additionalData: [
                    'user_id' => $user_id,
                    'loan_type' => $type
                ],

                // 🎯 TARGET → Shivam
                targetUserId: $user->id,

                // 👮 ACTOR → Ramesh
                actorId: $user->id,
                actorName: $user->name,
                actorRole: $user->role
            );
        }

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
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image' => $user->image
                ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
                : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',

            'financial_asset_type' => 'required|in:domestic,foreign_finance_assistant',
            'financial_asset_for' => 'required|in:graduation,post_graduation',

            'aadhar_card_number' => 'required|digits:12',
            'pan_card' => 'required|string|max:10',

            'phone' => 'required|string|max:15|unique:users,phone,' . auth()->id(),
            'alternate_phone' => 'nullable|string|max:15',

            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
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
            'chapter_id' => 'required|integer',
            'zone' => 'required|string|max:100',
            'chapter_chairman' => 'required|string|max:100',
            'chapter_contact' => 'required|string|max:15',
            'nationality' => 'required|in:indian,foreigner',

            'aadhar_address' => 'required|string',
            'postal_address' => 'required|string',

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

        $isResubmission = $this->isStepResubmission('step1');

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
            'chapter_id' => $request->chapter_id,
            'zone' => $request->zone,
            'chapter_chairman' => $request->chapter_chairman,
            'chapter_contact' => $request->chapter_contact,
            'nationality' => $request->nationality,
            'aadhar_address' => $request->aadhar_address,
            'postal_address' => $request->postal_address,
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

        // Log step completion
        if ($user) {
            $this->logUserActivity(
                processType: $isResubmission
                    ? 'step1_resubmission'
                    : 'step1_completion',

                processAction: $isResubmission
                    ? 'resubmitted'
                    : 'completed',

                processDescription: $isResubmission
                    ? 'User resubmitted Personal Details after correction'
                    : 'User submitted Personal Details step1',
                module: 'application',
                oldValues: null,
                newValues: null,
                additionalData: [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'step' => 'step1',
                    'step_name' => 'Personal Details',
                    'financial_asset_type' => $request->financial_asset_type,
                    'financial_asset_for' => $request->financial_asset_for,
                    'aadhar_card_number' => $request->aadhar_card_number,
                    'pan_card' => $request->pan_card,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'chapter' => $request->chapter,
                    'nationality' => $request->nationality
                ],

                // 🎯 TARGET → Shivam
                targetUserId: $user->id,

                // 👮 ACTOR → Ramesh
                actorId: $user->id,
                actorName: $user->name,
                actorRole: $user->role
            );
        }

        // Handle image upload (only once)
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = 'images/' . $imageName;
        }

        $user->update($data);

        // Check if all steps are submitted (no resubmit remaining)
        $this->checkAndUpdateWorkflowStatus();

        // Check if workflow status already exists for this user
        $user_id = Auth::id();
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
            $updateData = [
                'current_stage' => 'apex_1',
                'final_status' => 'in_progress',
            ];
            $workflow->update($updateData);
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
        
        // Fetch universities based on financial_asset_type
        $universityType = ($user->financial_asset_type == 'domestic') ? 'domestic' : 'foreign';
        $universities = UniversityWebsite::where('university_type', $universityType)
            ->where('status', true)
            ->orderBy('university_name', 'asc')
            ->get();
        
        // Fetch colleges based on financial_asset_type
        $colleges = CollegeWebsite::where('college_type', $universityType)
            ->where('status', true)
            ->orderBy('college_name', 'asc')
            ->get();
        
        if ($user->financial_asset_type == 'domestic' && $user->financial_asset_for == 'graduation') {
            return view('user.step2_ug', compact('type', 'user', 'familyDetail', 'fundingDetail', 'educationDetail', 'universities', 'colleges'));
        } else if ($user->financial_asset_type == 'domestic' && $user->financial_asset_for == 'post_graduation') {
            return view('user.step2_pg', compact('type', 'user', 'familyDetail', 'fundingDetail', 'educationDetail', 'universities', 'colleges'));
        } else if ($user->financial_asset_type == 'foreign_finance_assistant' && $user->financial_asset_for == 'post_graduation') {
            return view('user.step2_pg_foreign', compact('type', 'user', 'familyDetail', 'fundingDetail', 'educationDetail', 'universities', 'colleges'));
        }
        //  return view('user.step2', compact('type', 'familyDetail', 'fundingDetail', 'user'));
    }







    public function step2UGstore(Request $request)
    {
        // Validation for education details
        $rules = [
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
            'school_name' => 'required|string|max:255',
            'school_board' => 'required|string|max:100',
            'school_completion_year' => 'required|string|max:50',
            'school_grade_system' => 'required',

            // Junior College (12th Grade)
            'jc_college_name' => 'required|string|max:255',
            'jc_stream' => 'required|string|max:100',
            'jc_board' => 'required|string|max:100',
            'jc_completion_year' => 'required|string|max:50',
            'jc_grade_system' => 'required',
        ];

        // Conditional validation based on school_grade_system
        if ($request->school_grade_system == 'percentage') {
            $rules['10th_mark_obtained'] = 'required|integer|min:0';
            $rules['10th_mark_out_of'] = 'required|integer|min:0';
            $rules['school_percentage'] = 'required|string|max:50';
        } elseif ($request->school_grade_system == 'cgpa') {
            $rules['school_cgpa_out_of'] = 'required';
            $rules['school_CGPA'] = 'required|string|max:50';
        }

        // Conditional validation based on jc_grade_system
        if ($request->jc_grade_system == 'percentage') {
            $rules['12th_mark_obtained'] = 'required|integer|min:0';
            $rules['12th_mark_out_of'] = 'required|integer|min:0';
            $rules['jc_percentage'] = 'required|string|max:50';
        } elseif ($request->jc_grade_system == 'cgpa') {
            $rules['jc_cgpa_out_of'] = 'required';
            $rules['jc_CGPA'] = 'required|string|max:50';
        }

        $request->validate($rules);

        $user_id = Auth::id();
        $loanCategory = Loan_category::where('user_id', $user_id)->latest()->first();
        $isBelowOneLakh = $loanCategory && $loanCategory->type === 'below';
        $totalExpenses = (float) ($request->group_4_year1 ?: 0) + (float) ($request->group_4_year2 ?: 0) + (float) ($request->group_4_year3 ?: 0) + (float) ($request->group_4_year4 ?: 0) + (float) ($request->group_4_year5 ?: 0);

        if ($isBelowOneLakh && $totalExpenses > 100000) {
            return back()->withInput()->withErrors([
                'group_4_total' => 'For Below 1,00,000 category, Total Expenses cannot exceed 1,00,000.'
            ]);
        }

        $isResubmission = $this->isStepResubmission('step2');

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
            'school_grade_system' => $request->school_grade_system,
            'school_completion_year' => $request->school_completion_year ? $request->school_completion_year . '-01' : null,
            '10th_mark_obtained' => $request->input('10th_mark_obtained'),
            '10th_mark_out_of' => $request->input('10th_mark_out_of'),
            'school_percentage' => $request->school_percentage,
            'school_cgpa_out_of' => $request->school_cgpa_out_of,
            'school_CGPA' => $request->school_CGPA,

            // Junior College (12th Grade)
            'jc_college_name' => $request->jc_college_name,
            'jc_stream' => $request->jc_stream,
            'jc_board' => $request->jc_board,
            'jc_grade_system' => $request->jc_grade_system,
            'jc_completion_year' => $request->jc_completion_year,
            '12th_mark_obtained' => $request->input('12th_mark_obtained'),
            '12th_mark_out_of' => $request->input('12th_mark_out_of'),
            'jc_percentage' => $request->jc_percentage,
            'jc_cgpa_out_of' => $request->jc_cgpa_out_of,
            'jc_CGPA' => $request->jc_CGPA,

            'status' => 'step2_completed',
            'submit_status' => 'submited',
        ];

        // Get user for logging
        $user = User::find($user_id);

        // Log step completion
        $this->logUserActivity(
            processType: $isResubmission
                ? 'step2_resubmission'
                : 'step2_completion',

            processAction: $isResubmission
                ? 'resubmitted'
                : 'completed',

            processDescription: $isResubmission
                ? 'User resubmitted Education Details after correction'
                : 'User submitted Education Details step2',
            module: 'application',
            oldValues: null,
            newValues: null,
            additionalData: [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'step' => 'step2',
                'step_name' => 'Education Details',
                'course_name' => $request->course_name,
                'university_name' => $request->university_name,
                'college_name' => $request->college_name,
                'country' => $request->country,
                'city_name' => $request->city_name,
                'start_year' => $request->start_year,
                'expected_year' => $request->expected_year,
                'school_name' => $request->school_name,
                'school_board' => $request->school_board,
                'jc_college_name' => $request->jc_college_name,
                'jc_stream' => $request->jc_stream,
                'jc_board' => $request->jc_board
            ],

            // 🎯 TARGET → Shivam
            targetUserId: $user->id,

            // 👮 ACTOR → Ramesh
            actorId: $user->id,
            actorName: $user->name,
            actorRole: $user->role
        );

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

        // Check if all steps are submitted (no resubmit remaining)
        $this->checkAndUpdateWorkflowStatus();

        return redirect()->route('user.step3')->with('success', $message);
    }







    public function step2PGstore(Request $request)
    {
        // Validation for education details
        // dd($request->all());

        // Add workflow update here for simplicity
        $rules = [
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
            'school_name' => 'required|string|max:255',
            'school_board' => 'required|string|max:100',
            'school_completion_year' => 'required|string|max:50',
            'school_grade_system' => 'required',
            // '10th_mark_obtained' => 'nullable|integer|min:0',
            // '10th_mark_out_of' => 'nullable|integer|min:0',
            // 'school_percentage' => 'nullable|string|max:50',
            // 'school_CGPA' => 'nullable|string|max:50',
            // 'school_sgpa' => 'nullable|string|max:50',

            // Junior College (12th Grade)
            'jc_college_name' => 'required|string|max:255',
            'jc_stream' => 'required|string|max:100',
            'jc_board' => 'required|string|max:100',
            'jc_completion_year' => 'required|string|max:50',
            'jc_grade_system' => 'required',


            // Completed Qualifications
            'qualifications' => 'required|string',
            'qualification_institution' => 'required|string|max:255',
            'qualification_university' => 'nullable|string|max:255',
            'qualification_course_name' => 'required|string|max:255',
            'qualification_start_year' => 'required|date',
            'qualification_end_year' => 'required|date',
            'marksheet_type' => 'required|array',
            'marks_obtained' => 'nullable|array',
            'out_of' => 'nullable|array',
            'percentage' => 'nullable|array',
            'cgpa' => 'nullable|array',

            // Work Experience
            'have_work_experience' => 'required|in:yes,no',
            'organization_name' => 'nullable|string|max:255',
            'work_profile' => 'nullable|string|max:255',
            'duration_start_year' => 'nullable|date',
            'duration_end_year'   => 'nullable|date|after_or_equal:duration_start_year',

            'work_location_city' => 'nullable|string|max:100',
            'work_country' => 'nullable|string|max:100',
            'work_type' => 'nullable|in:full-time,internship,freelance,volunteer,stipend-based',
            'mention_your_salary' => 'nullable|in:monthly,yearly,ctc',
            'salary_amount' => 'nullable|numeric|min:0',
            'yearly_gross_income' => 'nullable|numeric|min:0',

        ];

        // Conditional validation based on school_grade_system
        if ($request->school_grade_system == 'percentage') {
            $rules['10th_mark_obtained'] = 'required|integer|min:0';
            $rules['10th_mark_out_of'] = 'required|integer|min:0';
            $rules['school_percentage'] = 'required|string|max:50';
        } elseif ($request->school_grade_system == 'cgpa') {
            $rules['school_CGPA'] = 'required|string|max:50';
            $rules['school_cgpa_out_of'] = 'required|string|max:50';
        }

        // Conditional validation based on jc_grade_system
        if ($request->jc_grade_system == 'percentage') {
            $rules['12th_mark_obtained'] = 'required|integer|min:0';
            $rules['12th_mark_out_of'] = 'required|integer|min:0';
            $rules['jc_percentage'] = 'required|string|max:50';
        } elseif ($request->jc_grade_system == 'cgpa') {
            $rules['jc_CGPA'] = 'required|string|max:50';
            $rules['jc_cgpa_out_of'] = 'required|string|max:50';
        }

        $request->validate($rules);

        $user_id = Auth::id();
        $loanCategory = Loan_category::where('user_id', $user_id)->latest()->first();
        $isBelowOneLakh = $loanCategory && $loanCategory->type === 'below';
        $totalExpenses = (float) ($request->group_4_year1 ?: 0) + (float) ($request->group_4_year2 ?: 0) + (float) ($request->group_4_year3 ?: 0) + (float) ($request->group_4_year4 ?: 0) + (float) ($request->group_4_year5 ?: 0);

        if ($isBelowOneLakh && $totalExpenses > 100000) {
            return back()->withInput()->withErrors([
                'group_4_total' => 'For Below 1,00,000 category, Total Expenses cannot exceed 1,00,000.'
            ]);
        }
        $isResubmission = $this->isStepResubmission('step2');

        $data = [
            'user_id' => $user_id,

            // Financial Need Overview
            'course_name' => $request->course_name,
            'university_name' => $request->university_name,
            'college_name' => $request->college_name,
            'country' => $request->country,
            'city_name' => $request->city_name,
            'start_year' => $request->start_year ? $request->start_year  : null, // Convert month to full date
            'expected_year' => $request->expected_year ? $request->expected_year  : null, // Convert month to full date
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
            'school_grade_system' => $request->school_grade_system,
            'school_completion_year' => $request->school_completion_year ? $request->school_completion_year . '-01' : null,

            '10th_mark_obtained' => $request->input('10th_mark_obtained'),
            '10th_mark_out_of' => $request->input('10th_mark_out_of'),
            'school_percentage' => $request->school_percentage,
            'school_CGPA' => $request->school_CGPA,
            'school_cgpa_out_of' => $request->school_cgpa_out_of,

            // Junior College (12th Grade)
            'jc_college_name' => $request->jc_college_name,
            'jc_stream' => $request->jc_stream,
            'jc_board' => $request->jc_board,
            'jc_grade_system' => $request->jc_grade_system,
            'jc_completion_year' => $request->jc_completion_year,

            '12th_mark_obtained' => $request->input('12th_mark_obtained'),
            '12th_mark_out_of' => $request->input('12th_mark_out_of'),
            'jc_percentage' => $request->jc_percentage,
            'jc_CGPA' => $request->jc_CGPA,
            'jc_cgpa_out_of' => $request->jc_cgpa_out_of,

            // Completed Qualifications
            'qualifications' => $request->qualifications,
            'qualification_institution' => $request->qualification_institution,
            'qualification_university' => $request->qualification_university,
            'qualification_course_name' => $request->qualification_course_name,
            // 'qualification_start_year' => $request->qualification_start_year,
            // 'qualification_end_year' => $request->qualification_end_year,
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
            'yearly_gross_income' => $request->yearly_gross_income,

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




        // Get user for logging
        $user = User::find($user_id);

        $this->logUserActivity(
            processType: $isResubmission
                ? 'step2_resubmission'
                : 'step2_completion',

            processAction: $isResubmission
                ? 'resubmitted'
                : 'completed',

            processDescription: $isResubmission
                ? 'User resubmitted Education Details after correction'
                : 'User submitted Education Details step2',
            module: 'application',
            oldValues: null,
            newValues: null,
            additionalData: [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'step' => 'step2',
                'step_name' => 'Education Details',
                'course_name' => $request->course_name,
                'university_name' => $request->university_name,
                'college_name' => $request->college_name,
                'country' => $request->country,
                'city_name' => $request->city_name,
                'start_year' => $request->start_year,
                'expected_year' => $request->expected_year,
                'school_name' => $request->school_name,
                'school_board' => $request->school_board,
                'jc_college_name' => $request->jc_college_name,
                'jc_stream' => $request->jc_stream,
                'jc_board' => $request->jc_board
            ],

            // 🎯 TARGET → Shivam
            targetUserId: $user->id,

            // 👮 ACTOR → Ramesh
            actorId: $user->id,
            actorName: $user->name,
            actorRole: $user->role
        );

        // Check if all steps are submitted (no resubmit remaining)
        $this->checkAndUpdateWorkflowStatus();
        return redirect()->route('user.step3')->with('success', $message);
    }


    public function step2_foreign_pg_store(Request $request)
    {
        // Validation for education details
       // dd($request->all());

        // Add workflow update here for simplicity
        $rules = [
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
            'school_name' => 'required|string|max:255',
            'school_board' => 'required|string|max:100',
            'school_completion_year' => 'required|string|max:50',
            'school_grade_system' => 'required',
            // '10th_mark_obtained' => 'nullable|integer|min:0',
            // '10th_mark_out_of' => 'nullable|integer|min:0',
            // 'school_percentage' => 'nullable|string|max:50',
            // 'school_CGPA' => 'nullable|string|max:50',
            // 'school_sgpa' => 'nullable|string|max:50',

            // Junior College (12th Grade)
            'jc_college_name' => 'required|string|max:255',
            'jc_stream' => 'required|string|max:100',
            'jc_board' => 'required|string|max:100',
            'jc_completion_year' => 'required|string|max:50',
            'jc_grade_system' => 'required',


            // Completed Qualifications
            'qualifications' => 'required|string',
            'qualification_institution' => 'required|string|max:255',
            'qualification_university' => 'nullable|string|max:255',
            'qualification_course_name' => 'required|string|max:255',
            'qualification_start_year' => 'required|date',
            'qualification_end_year' => 'required|date',
            'marksheet_type' => 'required|array',
            'marks_obtained' => 'nullable|array',
            'out_of' => 'nullable|array',
            'percentage' => 'nullable|array',
            'cgpa' => 'nullable|array',

            // Work Experience
            'have_work_experience' => 'required|in:yes,no',
            'organization_name' => 'nullable|string|max:255',
            'work_profile' => 'nullable|string|max:255',
            'duration_start_year' => 'nullable|date',
            'duration_end_year'   => 'nullable|date|after_or_equal:duration_start_year',

            'work_location_city' => 'nullable|string|max:100',
            'work_country' => 'nullable|string|max:100',
            'work_type' => 'nullable|in:full-time,internship,freelance,volunteer,stipend-based',
            'mention_your_salary' => 'nullable|in:monthly,yearly,ctc',
            'salary_amount' => 'nullable|numeric|min:0',
            'yearly_gross_income' => 'nullable|numeric|min:0',

            // Additional Curriculum
            'ielts_overall_band_year' => 'nullable|string|max:100',
            'toefl_score_year' => 'nullable|string|max:100',
            'duolingo_det_score_year' => 'nullable|string|max:100',
            'gre_score_year' => 'nullable|string|max:100',
            'gmat_score_year' => 'nullable|string|max:100',
            'sat_score_year' => 'nullable|string|max:100',

        ];

        // Conditional validation based on school_grade_system
        if ($request->school_grade_system == 'percentage') {
            $rules['10th_mark_obtained'] = 'required|integer|min:0';
            $rules['10th_mark_out_of'] = 'required|integer|min:0';
            $rules['school_percentage'] = 'required|string|max:50';
        } elseif ($request->school_grade_system == 'cgpa') {
            $rules['school_cgpa_out_of'] = 'required|string|max:50';
            $rules['school_CGPA'] = 'required|string|max:50';
        }

        // Conditional validation based on jc_grade_system
        if ($request->jc_grade_system == 'percentage') {
            $rules['12th_mark_obtained'] = 'required|integer|min:0';
            $rules['12th_mark_out_of'] = 'required|integer|min:0';
            $rules['jc_percentage'] = 'required|string|max:50';
        } elseif ($request->jc_grade_system == 'cgpa') {
            $rules['jc_cgpa_out_of'] = 'required|string|max:50';
            $rules['jc_CGPA'] = 'required|string|max:50';
        }

        $request->validate($rules);

        $user_id = Auth::id();

        $isResubmission = $this->isStepResubmission('step2');

        $data = [
            'user_id' => $user_id,

            // Financial Need Overview
            'course_name' => $request->course_name,
            'university_name' => $request->university_name,
            'college_name' => $request->college_name,
            'country' => $request->country,
            'city_name' => $request->city_name,
            'start_year' => $request->start_year ? $request->start_year  : null, // Convert month to full date
            'expected_year' => $request->expected_year ? $request->expected_year  : null, // Convert month to full date
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
            'school_grade_system' => $request->school_grade_system,
            'school_completion_year' => $request->school_completion_year ? $request->school_completion_year . '-01' : null,
            '10th_mark_obtained' => $request->input('10th_mark_obtained'),
            '10th_mark_out_of' => $request->input('10th_mark_out_of'),
            'school_percentage' => $request->school_percentage,
            'school_CGPA' => $request->school_CGPA,
            'school_cgpa_out_of' => $request->school_cgpa_out_of,

            // Junior College (12th Grade)
            'jc_college_name' => $request->jc_college_name,
            'jc_stream' => $request->jc_stream,
            'jc_board' => $request->jc_board,
            'jc_grade_system' => $request->jc_grade_system,
            'jc_completion_year' => $request->jc_completion_year,
            '12th_mark_obtained' => $request->input('12th_mark_obtained'),
            '12th_mark_out_of' => $request->input('12th_mark_out_of'),
            'jc_percentage' => $request->jc_percentage,
            'jc_CGPA' => $request->jc_CGPA,
            'jc_cgpa_out_of' => $request->jc_cgpa_out_of,

            // Completed Qualifications
            'qualifications' => $request->qualifications,
            'qualification_institution' => $request->qualification_institution,
            'qualification_university' => $request->qualification_university,
            'qualification_course_name' => $request->qualification_course_name,
            // 'qualification_start_year' => $request->qualification_start_year,
            // 'qualification_end_year' => $request->qualification_end_year,
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
            'yearly_gross_income' => $request->yearly_gross_income,

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



        // Get user for logging
        $user = User::find($user_id);

        // Log step completion
        $this->logUserActivity(
            processType: $isResubmission
                ? 'step2_resubmission'
                : 'step2_completion',

            processAction: $isResubmission
                ? 'resubmitted'
                : 'completed',

            processDescription: $isResubmission
                ? 'User resubmitted Education Details after correction'
                : 'User submitted Education Details step2',
            module: 'application',
            oldValues: null,
            newValues: null,
            additionalData: [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'step' => 'step2',
                'step_name' => 'Education Details',
                'course_name' => $request->course_name,
                'university_name' => $request->university_name,
                'college_name' => $request->college_name,
                'country' => $request->country,
                'city_name' => $request->city_name,
                'start_year' => $request->start_year,
                'expected_year' => $request->expected_year,
                'school_name' => $request->school_name,
                'school_board' => $request->school_board,
                'jc_college_name' => $request->jc_college_name,
                'jc_stream' => $request->jc_stream,
                'jc_board' => $request->jc_board
            ],

            // 🎯 TARGET → Shivam
            targetUserId: $user->id,

            // 👮 ACTOR → Ramesh
            actorId: $user->id,
            actorName: $user->name,
            actorRole: $user->role
        );

        // Check if all steps are submitted (no resubmit remaining)
        $this->checkAndUpdateWorkflowStatus();


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

        $isResubmission = $this->isStepResubmission('step3');

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
                'pan_card' => $request->input('family_' . $i . '_pan_card'),
                'aadhar_no' => $request->input('family_' . $i . '_aadhar_no'),
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
            'current_year_itr' => $request->current_year_itr,
            'last_year_itr' => $request->last_year_itr,
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

        // Get user for logging
        $user = User::find($user_id);

        // Log step completion
        $this->logUserActivity(
            processType: $isResubmission
                ? 'step3_resubmission'
                : 'step3_completion',

            processAction: $isResubmission
                ? 'resubmitted'
                : 'completed',

            processDescription: $isResubmission
                ? 'User resubmitted Family Details after correction'
                : 'User submitted Family Details step3',
            module: 'application',
            oldValues: null,
            newValues: null,
            additionalData: [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'step' => 'step3',
                'step_name' => 'Family Details',
                'number_family_members' => $request->number_family_members,
                'total_family_income' => $request->total_family_income,
                'total_students' => $request->total_students,
                'family_member_diksha' => $request->family_member_diksha,
                'total_insurance_coverage' => $request->total_insurance_coverage,
                'total_premium_paid' => $request->total_premium_paid,
                'recent_electricity_amount' => $request->recent_electricity_amount,
                'total_monthly_emi' => $request->total_monthly_emi,
                'mediclaim_insurance_amount' => $request->mediclaim_insurance_amount
            ],

            // 🎯 TARGET → Shivam
            targetUserId: $user->id,

            // 👮 ACTOR → Ramesh
            actorId: $user->id,
            actorName: $user->name,
            actorRole: $user->role
        );

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

        // Check if all steps are submitted (no resubmit remaining)
        $this->checkAndUpdateWorkflowStatus();

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

        // Check if loan category is below 1 lakh
        $isBelowOneLakh = $type === 'below';

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

        return view('user.step4', compact('type', 'familyDetail', 'fundingDetail', 'existingFundingData', 'user', 'banks', 'isBelowOneLakh'));
    }





    public function step4store(Request $request)
    {
        //dd($request->all());
        $user_id = Auth::id();
        $type = Loan_category::where('user_id', $user_id)->latest()->first()->type;
        $isBelowOneLakh = $type === 'below';

        // Build validation rules based on loan category
        $rules = [];

        // Bank cheque declaration is required for all loan types
        $rules['bank_cheque_declaration'] = 'required|accepted';

        // Only validate funding details and sibling assistance for loans above 1 lakh
        if (!$isBelowOneLakh) {
            $rules['funding'] = 'nullable|array';
            $rules['funding.*.status'] = 'nullable|in:applied,approved,received,pending';
            $rules['funding.*.institute_name'] = 'nullable|string|max:255';
            $rules['funding.*.contact_person'] = 'nullable|string|max:255';
            $rules['funding.*.contact_no'] = 'nullable|string|max:15';
            $rules['funding.*.amount'] = 'nullable|numeric|min:0';

            // Sibling Assistance
            $rules['sibling_assistance'] = 'required|in:yes,no';
            $rules['sibling_name'] = 'nullable|required_if:sibling_assistance,yes|string|max:255';
            $rules['sibling_number'] = 'nullable|required_if:sibling_assistance,yes|string|max:255';
            $rules['sibling_ngo_name'] = 'nullable|required_if:sibling_assistance,yes|string|max:255';
            $rules['ngo_number'] = 'nullable|required_if:sibling_assistance,yes|string|max:15';
            $rules['sibling_loan_status'] = 'nullable|required_if:sibling_assistance,yes|string|max:255';
            $rules['sibling_applied_year'] = 'nullable|required_if:sibling_assistance,yes|string|max:255';
            $rules['sibling_applied_amount'] = 'nullable|required_if:sibling_assistance,yes|numeric|min:0';
        }

        $request->validate($rules);
        // dd($request->all());
        $funding = $request->funding ?? [];

        $total_funding_amount = collect($funding)->sum(function ($row) {
            return $row['amount'] ?? 0;
        });

        $user_id = Auth::id();


        $data = [
            'user_id' => $user_id,
            'status' => 'step4_completed',
            'submit_status' => 'submited',
        ];

        // Only save funding details and sibling assistance for loans above 1 lakh
        if (!$isBelowOneLakh) {
            $data = array_merge($data, [
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
            ]);
        }

        $isResubmission = $this->isStepResubmission('step4');

        // Get user for logging
        $user = User::find($user_id);
        // Log step completion
        $this->logUserActivity(
            processType: $isResubmission
                ? 'step4_resubmission'
                : 'step4_completion',

            processAction: $isResubmission
                ? 'resubmitted'
                : 'completed',

            processDescription: $isResubmission
                ? 'User resubmitted Funding Details after correction'
                : 'User submitted Funding Details step4',
            module: 'application',
            oldValues: null,
            newValues: null,
            additionalData: [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'step' => 'step4',
                'step_name' => 'Funding Details',
                'total_funding_amount' => $total_funding_amount,
                'sibling_assistance' => $request->sibling_assistance,
                'sibling_name' => $request->sibling_name,
                'sibling_ngo_name' => $request->sibling_ngo_name,
                'sibling_loan_status' => $request->sibling_loan_status,
                'sibling_applied_year' => $request->sibling_applied_year,
                'sibling_applied_amount' => $request->sibling_applied_amount,
                'bank_name' => $request->bank_name,
                'account_holder_name' => $request->account_holder_name,
                'account_number' => $request->account_number,
                'ifsc_code' => $request->ifsc_code
            ],

            // 🎯 TARGET → Shivam
            targetUserId: $user->id,

            // 👮 ACTOR → Ramesh
            actorId: $user->id,
            actorName: $user->name,
            actorRole: $user->role
        );

        // Check if funding details already exist for this user
        $fundingDetail = FundingDetail::where('user_id', $user_id)->first();

        if ($fundingDetail) {
            // Update existing record
            $fundingDetail->update($data);
            $message = 'Funding details updated successfully!';
        } else {
            // Create new record
            FundingDetail::create($data);
            $message = 'Funding details saved successfully!';
        }

        // Check if all steps are submitted (no resubmit remaining)
        $this->checkAndUpdateWorkflowStatus();

        // Redirect to step5 for loans above 1 lakh, or step6 for below 1 lakh
        $redirectRoute = $isBelowOneLakh ? 'user.step6' : 'user.step5';
        return redirect()->route($redirectRoute)
            ->with('success', $message);
    }


    public function verify(Request $request)
    {
        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . env('SUREPASS_TOKEN'),
        ])->post('https://kyc-api.surepass.io/api/v1/bank-verification/', [
            'id_number'    => $request->account_number,
            'ifsc'         => $request->ifsc_code,
            'ifsc_details' => true
        ]);

        $result = $response->json();

        if (
            isset($result['success']) &&
            $result['success'] === true &&
            ($result['data']['account_exists'] ?? false) === true
        ) {
            return response()->json([
                'success'   => true,
                'full_name' => $result['data']['full_name'] ?? '',
                'branch'    => $result['data']['ifsc_details']['branch'] ?? '',
                'address'   => $result['data']['ifsc_details']['address'] ?? '',
                'raw'       => $result // optional: full response
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Bank verification failed',
            'raw'     => $result
        ], 422);
    }
    public function verifyPan(Request $request)
    {
        $request->validate([
            'pan'  => 'required|string|size:10',
            'type' => 'required|in:first,second' // 👈 important
        ]);

        try {
            $token = config('services.surepass.token');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept'        => 'application/json',
            ])->post('https://kyc-api.surepass.io/api/v1/pan/pan-comprehensive', [
                'id_number' => $request->pan
            ]);

            if ($response->successful()) {
                $data = $response->json();

                // 🔐 masked_aadhaar session मध्ये store
                if (!empty($data['data']['masked_aadhaar'])) {

                    if ($request->type === 'first') {
                        session([
                            'g_one_masked_aadhaar' => $data['data']['masked_aadhaar']
                        ]);
                    } else {
                        session([
                            'g_two_masked_aadhaar' => $data['data']['masked_aadhaar']
                        ]);
                    }
                }

                return response()->json([
                    'status'  => $data['success'] ?? false,
                    'data'    => $data['data'] ?? null,
                    'message' => $data['message'] ?? null
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => $response->status() === 401
                    ? 'Invalid API Token. Check SUREPASS_TOKEN'
                    : ($response->json()['message'] ?? 'API error')
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    //     public function verifyPan(Request $request)
    // {
    //     $request->validate([
    //         'pan' => 'required|string|size:10'
    //     ]);

    //     try {
    //         $token = config('services.surepass.token');

    //         $response = Http::withHeaders([
    //             'Authorization' => 'Bearer ' . $token,
    //             'Accept'        => 'application/json',
    //         ])->post('https://kyc-api.surepass.io/api/v1/pan/pan-comprehensive', [
    //             'id_number' => $request->pan
    //         ]);

    //         if ($response->successful()) {
    //             $data = $response->json();

    //             return response()->json([
    //                 'status'  => $data['success'] ?? false,
    //                 'data'    => $data['data'] ?? null,
    //                 'message' => $data['message'] ?? null
    //             ]);
    //         }

    //         return response()->json([
    //             'status' => false,
    //             'message' => $response->status() === 401
    //                 ? 'Invalid API Token. Check SUREPASS_TOKEN'
    //                 : ($response->json()['message'] ?? 'API error')
    //         ], $response->status());

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }




    public function verifyAadhaarLast4(Request $request)
    {
        $request->validate([
            'aadhaar' => 'required|digits:12',
            'type' => 'required|in:first,second'
        ]);

        $enteredLast4 = substr($request->aadhaar, -4);

        $masked = $request->type === 'first'
            ? session('g_one_masked_aadhaar')
            : session('g_two_masked_aadhaar');

        if (!$masked) {
            return response()->json([
                'status' => false,
                'message' => 'PAN not verified yet'
            ]);
        }

        // masked_aadhaar example: XXXXXXXX1234
        $maskedLast4 = substr($masked, -4);

        if ($enteredLast4 === $maskedLast4) {
            return response()->json([
                'status' => true,
                'message' => 'Aadhaar validated successfully'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Aadhaar number does not match PAN records'
        ]);
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

        // Check if loan category is below 1 lakh - skip guarantor details
        if ($type === 'below') {
            // Auto-create guarantor detail record with skipped status
            $guarantorDetail = GuarantorDetail::where('user_id', $user_id)->first();
            if (!$guarantorDetail) {
                GuarantorDetail::create([
                    'user_id' => $user_id,
                    'submit_status' => 'skipped',
                    'status' => 'step5_skipped',
                ]);
            }
            // Redirect to step6 (Document Upload)
            return redirect()->route('user.step6');
        }

        $familyDetail = Familydetail::where('user_id', $user_id)->first();
        $fundingDetail = FundingDetail::where('user_id', $user_id)->first();
        $guarantorDetail = GuarantorDetail::where('user_id', $user_id)->first();

        return view('user.step5', compact('type', 'familyDetail', 'fundingDetail', 'user', 'guarantorDetail'));
    }


    // public function checkDuplicate(Request $request)
    // {
    //     $user = Auth::user();
    //     $value = trim($request->value);
    //     $field = $request->field; // mobile, email, pan, aadhar, name

    //     // ===== USERS TABLE FIELD MAP =====
    //     $userFieldMap = [
    //         'name'   => 'name',
    //         'email'  => 'email',
    //         'mobile' => 'phone',          // 👈 mapping
    //         'pan'    => 'pan_card',
    //         'aadhar' => 'aadhar_card_number',
    //     ];

    //     if (isset($userFieldMap[$field])) {
    //         $userColumn = $userFieldMap[$field];

    //         if (!empty($user->$userColumn) && $user->$userColumn === $value) {
    //             return response()->json([
    //                 'exists' => true,
    //                 'source' => 'user'
    //             ]);
    //         }
    //     }

    //     // ===== FAMILY JSON FIELD MAP =====
    //     $familyFieldMap = [
    //         'name'   => 'name',
    //         'email'  => 'email',
    //         'mobile' => 'mobile',         // 👈 JSON key
    //         'pan'    => 'pan_card',
    //         'aadhar' => 'aadhar_no',
    //     ];

    //     // if (isset($familyFieldMap[$field])) {
    //     //     $family = Familydetail::where('user_id', $user->id)->first();

    //     //     if ($family && is_array($family->additional_family_members)) {
    //     //         foreach ($family->additional_family_members as $member) {
    //     //             $jsonKey = $familyFieldMap[$field];

    //     //             if (
    //     //                 isset($member[$jsonKey]) &&
    //     //                 trim($member[$jsonKey]) === $value
    //     //             ) {
    //     //                 return response()->json([
    //     //                     'exists' => true,
    //     //                     'source' => 'family'
    //     //                 ]);
    //     //             }
    //     //         }
    //     //     }
    //     // }

    //     if ($family) {
    //         $members = is_array($family->additional_family_members)
    //             ? $family->additional_family_members
    //             : json_decode($family->additional_family_members, true);

    //         if (is_array($members)) {
    //             foreach ($members as $member) {
    //                 $jsonKey = $familyFieldMap[$field];

    //                 if (
    //                     isset($member[$jsonKey]) &&
    //                     trim($member[$jsonKey]) === $value
    //                 ) {
    //                     return response()->json([
    //                         'exists' => true,
    //                         'source' => 'family'
    //                     ]);
    //                 }
    //             }
    //         }
    //     }


    //     return response()->json(['exists' => false]);
    // }


    // public function checkDuplicate(Request $request)
    // {
    //     $user = Auth::user();
    //     $value = trim($request->value);
    //     $field = $request->field;

    //     // ===== USERS TABLE FIELD MAP =====
    //     $userFieldMap = [
    //         'name'   => 'name',
    //         'email'  => 'email',
    //         'mobile' => 'phone',
    //         'pan'    => 'pan_card',
    //         'aadhar' => 'aadhar_card_number',
    //     ];

    //     if (isset($userFieldMap[$field])) {
    //         $userColumn = $userFieldMap[$field];

    //         if (!empty($user->$userColumn) && trim($user->$userColumn) === $value) {
    //             return response()->json([
    //                 'exists' => true,
    //                 'source' => 'user'
    //             ]);
    //         }
    //     }

    //     // ===== FAMILY JSON FIELD MAP =====
    //     $familyFieldMap = [
    //         'name'   => 'name',
    //         'email'  => 'email',
    //         'mobile' => 'mobile',
    //         'pan'    => 'pan_card',
    //         'aadhar' => 'aadhar_no',
    //     ];

    //     if (isset($familyFieldMap[$field])) {

    //         // 🔑 MISSING LINE (IMPORTANT)
    //         $family = Familydetail::where('user_id', $user->id)->first();

    //         if ($family) {
    //             $members = is_array($family->additional_family_members)
    //                 ? $family->additional_family_members
    //                 : json_decode($family->additional_family_members, true);

    //             if (is_array($members)) {
    //                 foreach ($members as $member) {
    //                     $jsonKey = $familyFieldMap[$field];

    //                     if (
    //                         isset($member[$jsonKey]) &&
    //                         trim($member[$jsonKey]) === $value
    //                     ) {
    //                         return response()->json([
    //                             'exists' => true,
    //                             'source' => 'family'
    //                         ]);
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     return response()->json(['exists' => false]);
    // }

    public function checkDuplicate(Request $request)
    {
        $user = Auth::user();
        $value = trim($request->value);
        $field = $request->field;
        $guarantorId = $request->guarantor_id; // 👈 current guarantor

        // ===== USERS TABLE =====
        $userFieldMap = [
            'name'   => 'name',
            'email'  => 'email',
            'mobile' => 'phone',
            'pan'    => 'pan_card',
            'aadhar' => 'aadhar_card_number',
        ];

        if (isset($userFieldMap[$field])) {
            $col = $userFieldMap[$field];

            if (!empty($user->$col) && trim($user->$col) === $value) {
                return response()->json(['exists' => true, 'source' => 'user']);
            }
        }

        // ===== FAMILY JSON =====
        $familyFieldMap = [
            'name'   => 'name',
            'email'  => 'email',
            'mobile' => 'mobile',
            'pan'    => 'pan_card',
            'aadhar' => 'aadhar_no',
        ];

        if (isset($familyFieldMap[$field])) {
            $family = Familydetail::where('user_id', $user->id)->first();

            if ($family) {
                $members = is_array($family->additional_family_members)
                    ? $family->additional_family_members
                    : json_decode($family->additional_family_members, true);

                foreach ($members ?? [] as $member) {
                    if (
                        isset($member[$familyFieldMap[$field]]) &&
                        trim($member[$familyFieldMap[$field]]) === $value
                    ) {
                        return response()->json(['exists' => true, 'source' => 'family']);
                    }
                }
            }
        }

        // ===== GUARANTOR DETAILS (OVERALL SYSTEM CHECK) =====
        $guarantorFieldMap = [
            'name'   => 'name',
            'email'  => 'email',
            'mobile' => 'mobile',
            'pan'    => 'pan_card',
            'aadhar' => 'aadhar_no',
        ];

        if (isset($guarantorFieldMap[$field])) {

            $query = GuarantorDetail::where(
                $guarantorFieldMap[$field],
                $value
            );

            // ❗ self guarantor exclude
            if ($guarantorId) {
                $query->where('id', '!=', $guarantorId);
            }

            if ($query->exists()) {
                return response()->json([
                    'exists' => true,
                    'source' => 'guarantor'
                ]);
            }
        }

        return response()->json(['exists' => false]);
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



    // public function step5store(Request $request)
    // {
    //     // dd($request->all());
    //     $request->validate([
    //         // First Guarantor
    //         'g_one_name' => 'required|string|max:255',
    //         'g_one_gender' => 'required|in:male,female',
    //         'g_one_permanent_flat_no' => 'required|string',
    //         'g_one_permanent_address' => 'required|string',
    //         'g_one_city' => 'required|string|max:100',
    //         'g_one_district' => 'required|string|max:100',
    //         'g_one_state' => 'required|string|max:100',
    //         'g_one_pincode' => 'required|digits:6',
    //         'g_one_phone' => 'required|string|max:15|unique:guarantor_details,g_one_phone',
    //         'g_one_email' => 'required|email|max:255|unique:guarantor_details,g_one_email',
    //         'g_one_relation_with_student' => 'required|string|max:255',
    //         'g_one_aadhar_card_number' => 'required|digits:12',
    //         'g_one_pan' => 'required|string|max:10',
    //         'g_one_d_o_b' => 'required|date',
    //         'g_one_srvice' => 'required|string|max:255',
    //         'g_one_income' => 'required|numeric|min:0',


    //         // Second Guarantor
    //         'g_two_name' => 'required|string|max:255',
    //         'g_two_gender' => 'required|in:male,female',
    //         'g_two_permanent_flat_no' => 'required|string',
    //         'g_two_permanent_address' => 'required|string',
    //         'g_two_city' => 'required|string|max:100',
    //         'g_two_district' => 'required|string|max:100',
    //         'g_two_state' => 'required|string|max:100',
    //         'g_two_pincode' => 'required|digits:6',
    //         'g_two_phone' => 'required|string|max:15|unique:guarantor_details,g_two_phone',
    //         'g_two_email' => 'required|email|max:255|unique:guarantor_details,g_two_email',
    //         'g_two_relation_with_student' => 'required|string|max:255',
    //         'g_two_aadhar_card_number' => 'required|digits:12',
    //         'g_two_pan' => 'required|string|max:10',
    //         'g_two_d_o_b' => 'required|date',
    //         'g_two_srvice' => 'required|string|max:255',
    //         'g_two_income' => 'required|numeric|min:0',

    //     ]);

    //     $user_id = Auth::id();
    //     $guarantorDetail = GuarantorDetail::where('user_id', $user_id)->first();

    //     $data = [
    //         'user_id' => $user_id,

    //         // First Guarantor
    //         'g_one_name' => $request->g_one_name,
    //         'g_one_gender' => $request->g_one_gender,
    //         'g_one_permanent_flat_no' => $request->g_one_permanent_flat_no,
    //         'g_one_permanent_address' => $request->g_one_permanent_address,
    //         'g_one_permanent_city' => $request->g_one_city,
    //         'g_one_permanent_district' => $request->g_one_district,
    //         'g_one_permanent_state' => $request->g_one_state,
    //         'g_one_permanent_pincode' => $request->g_one_pincode,
    //         // 'g_one_phone' => $request->g_one_phone,
    //         // 'g_one_email' => $request->g_one_email,
    //         'g_one_phone' => [
    //             'required',
    //             'string',
    //             'max:15',
    //             Rule::unique('guarantor_details', 'g_one_phone')->ignore(optional($guarantorDetail)->id),
    //         ],

    //         'g_one_email' => [
    //             'required',
    //             'email',
    //             'max:255',
    //             Rule::unique('guarantor_details', 'g_one_email')->ignore(optional($guarantorDetail)->id),
    //         ],

    //         'g_one_relation_with_student' => $request->g_one_relation_with_student,
    //         'g_one_aadhar_card_number' => $request->g_one_aadhar_card_number,
    //         'g_one_pan' => $request->g_one_pan,
    //         'g_one_d_o_b' => $request->g_one_d_o_b,

    //         'g_one_srvice' => $request->g_one_srvice,
    //         'g_one_income' => $request->g_one_income,

    //         // Second Guarantor
    //         'g_two_name' => $request->g_two_name,
    //         'g_two_gender' => $request->g_two_gender,
    //         'g_two_permanent_flat_no' => $request->g_two_permanent_flat_no,
    //         'g_two_permanent_address' => $request->g_two_permanent_address,
    //         'g_two_permanent_city' => $request->g_two_city,
    //         'g_two_permanent_district' => $request->g_two_district,
    //         'g_two_permanent_state' => $request->g_two_state,
    //         'g_two_permanent_pincode' => $request->g_two_pincode,
    //         // 'g_two_phone' => $request->g_two_phone,
    //         // 'g_two_email' => $request->g_two_email,
    //         'g_two_phone' => [
    //             'required',
    //             'string',
    //             'max:15',
    //             Rule::unique('guarantor_details', 'g_two_phone')->ignore(optional($guarantorDetail)->id),
    //         ],

    //         'g_two_email' => [
    //             'required',
    //             'email',
    //             'max:255',
    //             Rule::unique('guarantor_details', 'g_two_email')->ignore(optional($guarantorDetail)->id),
    //         ],
    //         'g_two_relation_with_student' => $request->g_two_relation_with_student,
    //         'g_two_aadhar_card_number' => $request->g_two_aadhar_card_number,
    //         'g_two_pan' => $request->g_two_pan,
    //         'g_two_d_o_b' =>  $request->g_two_d_o_b,
    //         'g_two_srvice' => $request->g_two_srvice,
    //         'g_two_income' => $request->g_two_income,

    //         'status' => 'step5_completed',
    //         'submit_status' => 'submited',
    //     ];

    //     // Check if guarantor details already exist for this user
    //     $guarantorDetail = GuarantorDetail::where('user_id', $user_id)->first();

    //     if ($guarantorDetail) {
    //         // Update existing record
    //         $guarantorDetail->update($data);
    //         $message = 'Guarantor details updated successfully!';
    //     } else {
    //         // Create new record
    //         GuarantorDetail::create($data);
    //         $message = 'Guarantor details saved successfully!';
    //     }

    //     // Get user for logging
    //     $user = User::find($user_id);

    //     // Log step completion
    //     $this->logUserActivity(
    //         'step_completion',
    //         'completed',
    //         'User submitted Guarantor Details step',
    //         'application',
    //         null,
    //         null,
    //         [
    //             'user_id' => $user->id,
    //             'user_name' => $user->name,
    //             'user_email' => $user->email,
    //             'step' => 'step5',
    //             'step_name' => 'Guarantor Details',
    //             'g_one_name' => $request->g_one_name,
    //             'g_one_gender' => $request->g_one_gender,
    //             'g_one_phone' => $request->g_one_phone,
    //             'g_one_email' => $request->g_one_email,
    //             'g_one_relation_with_student' => $request->g_one_relation_with_student,
    //             'g_one_aadhar_card_number' => $request->g_one_aadhar_card_number,
    //             'g_one_pan' => $request->g_one_pan,
    //             'g_one_income' => $request->g_one_income,
    //             'g_two_name' => $request->g_two_name,
    //             'g_two_gender' => $request->g_two_gender,
    //             'g_two_phone' => $request->g_two_phone,
    //             'g_two_email' => $request->g_two_email,
    //             'g_two_relation_with_student' => $request->g_two_relation_with_student,
    //             'g_two_aadhar_card_number' => $request->g_two_aadhar_card_number,
    //             'g_two_pan' => $request->g_two_pan,
    //             'g_two_income' => $request->g_two_income
    //         ],
    //         $user->id
    //     );

    //     // Check if all steps are submitted (no resubmit remaining)
    //     $this->checkAndUpdateWorkflowStatus();

    //     return redirect()->route('user.step6')->with('success', $message);
    // }


    public function step5store(Request $request)
    {
        $user_id = Auth::id();

        // Fetch existing guarantor detail (for update case)
        $guarantorDetail = GuarantorDetail::where('user_id', $user_id)->first();

        // ================= VALIDATION =================
        $request->validate([

            // ---------- First Guarantor ----------
            'g_one_name' => 'required|string|max:255',
            'g_one_gender' => 'required|in:male,female',
            'g_one_permanent_flat_no' => 'required|string',
            'g_one_permanent_address' => 'required|string',
            'g_one_city' => 'required|string|max:100',
            'g_one_district' => 'required|string|max:100',
            'g_one_state' => 'required|string|max:100',
            'g_one_pincode' => 'required|digits:6',

            'g_one_phone' => [
                'required',
                'string',
                'max:15',
                Rule::unique('guarantor_details', 'g_one_phone')
                    ->ignore(optional($guarantorDetail)->id),
            ],

            'g_one_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('guarantor_details', 'g_one_email')
                    ->ignore(optional($guarantorDetail)->id),
            ],

            'g_one_relation_with_student' => 'required|string|max:255',
            'g_one_aadhar_card_number' => 'required|digits:12',
            'g_one_pan' => 'required|string|max:10',
            'g_one_d_o_b' => 'required|date',
            'g_one_srvice' => 'required|string|max:255',
            'g_one_income' => 'required|numeric|min:0',

            // ---------- Second Guarantor ----------
            'g_two_name' => 'required|string|max:255',
            'g_two_gender' => 'required|in:male,female',
            'g_two_permanent_flat_no' => 'required|string',
            'g_two_permanent_address' => 'required|string',
            'g_two_city' => 'required|string|max:100',
            'g_two_district' => 'required|string|max:100',
            'g_two_state' => 'required|string|max:100',
            'g_two_pincode' => 'required|digits:6',

            'g_two_phone' => [
                'required',
                'string',
                'max:15',
                Rule::unique('guarantor_details', 'g_two_phone')
                    ->ignore(optional($guarantorDetail)->id),
            ],

            'g_two_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('guarantor_details', 'g_two_email')
                    ->ignore(optional($guarantorDetail)->id),
            ],

            'g_two_relation_with_student' => 'required|string|max:255',
            'g_two_aadhar_card_number' => 'required|digits:12',
            'g_two_pan' => 'required|string|max:10',
            'g_two_d_o_b' => 'required|date',
            'g_two_srvice' => 'required|string|max:255',
            'g_two_income' => 'required|numeric|min:0',
        ]);

        $isResubmission = $this->isStepResubmission('step5');

        // ================= DATA ARRAY =================
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
            'g_one_pan' => $request->g_one_pan,
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
            'g_two_pan' => $request->g_two_pan,
            'g_two_d_o_b' => $request->g_two_d_o_b,
            'g_two_srvice' => $request->g_two_srvice,
            'g_two_income' => $request->g_two_income,

            'status' => 'step5_completed',
            'submit_status' => 'submited',
        ];


        // ================= SAVE / UPDATE =================
        if ($guarantorDetail) {
            $guarantorDetail->update($data);
            $message = 'Guarantor details updated successfully!';
        } else {
            GuarantorDetail::create($data);
            $message = 'Guarantor details saved successfully!';
        }

        // ================= LOG ACTIVITY =================
        $user = User::find($user_id);


        $this->logUserActivity(
            processType: $isResubmission
                ? 'step5_resubmission'
                : 'step5_completion',

            processAction: $isResubmission
                ? 'resubmitted'
                : 'completed',

            processDescription: $isResubmission
                ? 'User resubmitted Guarantor Details after correction'
                : 'User submitted Guarantor Details step5',
            module: 'application',
            oldValues: null,
            newValues: null,
            additionalData: [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'step' => 'step5',
                'step_name' => 'Guarantor Details',
                'g_one_phone' => $request->g_one_phone,
                'g_one_email' => $request->g_one_email,
                'g_two_phone' => $request->g_two_phone,
                'g_two_email' => $request->g_two_email,
            ],

            // 🎯 TARGET → Shivam
            targetUserId: $user->id,

            // 👮 ACTOR → Ramesh
            actorId: $user->id,
            actorName: $user->name,
            actorRole: $user->role
        );

        // ================= WORKFLOW STATUS =================
        $this->checkAndUpdateWorkflowStatus();

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
            // Workflow update will be added at the end
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
                'guarantor2_aadhaar',
                'guarantor2_pan',
                'student_handwritten_statement',
                'proof_funds_arranged',

            ];
            foreach ($requiredFields as $field) {
                $rules[$field] = (isset($existing->$field) ? 'nullable' : 'required') . '|file|mimes:jpg,jpeg,png,pdf|max:5120';
            }
            // $rules['guarantor2_pan'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            // $rules['student_handwritten_statement'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            // $rules['proof_funds_arranged'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            $rules['other_documents'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            $rules['extra_curricular'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';

            $request->validate($rules);

            $user_id = Auth::id();
            $isResubmission = $this->isStepResubmission('step6');

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

            // Get user for logging
            $user = User::find($user_id);

            // Log step completion
            $this->logUserActivity(
                processType: $isResubmission
                    ? 'step6_resubmission'
                    : 'step6_completion',

                processAction: $isResubmission
                    ? 'resubmitted'
                    : 'completed',

                processDescription: $isResubmission
                    ? 'User resubmitted Document Upload after correction'
                    : 'User submitted Document Upload step6',
                module: 'application',
                oldValues: null,
                newValues: null,
                additionalData: [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'step' => 'step6',
                    'step_name' => 'Document Upload',
                    'documents_uploaded' => array_keys(array_filter($data, function ($key) {
                        return strpos($key, '_') !== false && !in_array($key, ['user_id', 'status', 'submit_status']);
                    }, ARRAY_FILTER_USE_KEY)),
                    'total_documents' => count(array_filter($data, function ($key) {
                        return strpos($key, '_') !== false && !in_array($key, ['user_id', 'status', 'submit_status']);
                    }, ARRAY_FILTER_USE_KEY))
                ],

                // 🎯 TARGET → Shivam
                targetUserId: $user->id,

                // 👮 ACTOR → Ramesh
                actorId: $user->id,
                actorName: $user->name,
                actorRole: $user->role
            );

            // Check if all steps are submitted (no resubmit remaining)
            $this->checkAndUpdateWorkflowStatus();

            Log::info('Step6Store: Document created successfully', ['user_id' => $user_id, 'document_id' => Document::latest()->first()->id]);

            return redirect()->route('user.step7')->with('upload_success', $message);
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
                'guarantor2_aadhaar',
                'guarantor2_pan',
                'student_handwritten_statement',
                'proof_funds_arranged',

            ];
            foreach ($requiredFields as $field) {
                $rules[$field] = (isset($existing->$field) ? 'nullable' : 'required') . '|file|mimes:jpg,jpeg,png,pdf|max:5120';
            }
            // $rules['guarantor2_pan'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            // $rules['student_handwritten_statement'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            // $rules['proof_funds_arranged'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            $rules['other_documents'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            $rules['extra_curricular'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';

            $request->validate($rules);

            $user_id = Auth::id();
            $isResubmission = $this->isStepResubmission('step6');

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



            // Get user for logging
            $user = User::find($user_id);

            // Log step completion
            $this->logUserActivity(
                processType: $isResubmission
                    ? 'step6_resubmission'
                    : 'step6_completion',

                processAction: $isResubmission
                    ? 'resubmitted'
                    : 'completed',

                processDescription: $isResubmission
                    ? 'User resubmitted Document Upload after correction'
                    : 'User submitted Document Upload step6',
                module: 'application',
                oldValues: null,
                newValues: null,
                additionalData: [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'step' => 'step6',
                    'step_name' => 'Document Upload',
                    'documents_uploaded' => array_keys(array_filter($data, function ($key) {
                        return strpos($key, '_') !== false && !in_array($key, ['user_id', 'status', 'submit_status']);
                    }, ARRAY_FILTER_USE_KEY)),
                    'total_documents' => count(array_filter($data, function ($key) {
                        return strpos($key, '_') !== false && !in_array($key, ['user_id', 'status', 'submit_status']);
                    }, ARRAY_FILTER_USE_KEY))
                ],

                // 🎯 TARGET → Shivam
                targetUserId: $user->id,

                // 👮 ACTOR → Ramesh
                actorId: $user->id,
                actorName: $user->name,
                actorRole: $user->role
            );


            Log::info('Step6Store: Document created successfully', ['user_id' => $user_id, 'document_id' => Document::latest()->first()->id]);

            // Check if all steps are submitted (no resubmit remaining)
            $this->checkAndUpdateWorkflowStatus();

            return redirect()->route('user.step7')->with('upload_success', $message);
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
                'guarantor2_aadhaar',
                'guarantor2_pan',
                'student_handwritten_statement',
                'proof_funds_arranged'

            ];
            foreach ($requiredFields as $field) {
                $rules[$field] = (isset($existing->$field) ? 'nullable' : 'required') . '|file|mimes:jpg,jpeg,png,pdf|max:5120';
            }
            // $rules['guarantor2_pan'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            // $rules['student_handwritten_statement'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            // $rules['proof_funds_arranged'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            $rules['other_documents'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
            $rules['extra_curricular'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';

            $request->validate($rules);

            $user_id = Auth::id();
            $isResubmission = $this->isStepResubmission('step6');

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


            // Get user for logging
            $user = User::find($user_id);

            // Log step completion
            $this->logUserActivity(
                processType: $isResubmission
                    ? 'step6_resubmission'
                    : 'step6_completion',

                processAction: $isResubmission
                    ? 'resubmitted'
                    : 'completed',

                processDescription: $isResubmission
                    ? 'User resubmitted Document Upload after correction'
                    : 'User submitted Document Upload step6',
                module: 'application',
                oldValues: null,
                newValues: null,
                additionalData: [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'step' => 'step6',
                    'step_name' => 'Document Upload',
                    'documents_uploaded' => array_keys(array_filter($data, function ($key) {
                        return strpos($key, '_') !== false && !in_array($key, ['user_id', 'status', 'submit_status']);
                    }, ARRAY_FILTER_USE_KEY)),
                    'total_documents' => count(array_filter($data, function ($key) {
                        return strpos($key, '_') !== false && !in_array($key, ['user_id', 'status', 'submit_status']);
                    }, ARRAY_FILTER_USE_KEY))
                ],

                // 🎯 TARGET → Shivam
                targetUserId: $user->id,

                // 👮 ACTOR → Ramesh
                actorId: $user->id,
                actorName: $user->name,
                actorRole: $user->role
            );
            // Check if all steps are submitted (no resubmit remaining)
            $this->checkAndUpdateWorkflowStatus();

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
        } else {
            // Update if exists
            $workflow->update([
                'current_stage' => 'apex_1',
                'final_status' => 'in_progress',
            ]);
        }

        // Update user's application_status to 'submitted' or similar
        $user = User::find($user_id);
        $user->update(['application_status' => 'submitted']);

        // Get user for logging
        $user = User::find($user_id);

        try {
            Mail::to($user->email)->send(new ApplicationSubmittedSuccessfullyMail($user));
        } catch (\Throwable $e) {
            report($e);
        }
        $isResubmission = $this->isStepResubmission('step7');

        // Log step completion
        $this->logUserActivity(
            processType: $isResubmission
                ? 'Application_resubmission'
                : 'Application_submission',

            processAction: $isResubmission
                ? 'resubmitted'
                : 'completed',

            processDescription: $isResubmission
                ? 'User resubmitted Application after correction'
                : 'User submitted the Application',
            module: 'application',
            oldValues: null,
            newValues: null,
            additionalData: [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'step' => 'step7',
                'step_name' => 'Review & Submit',
                'application_status' => 'submitted',
                'workflow_stage' => 'apex_1',
                'final_status' => 'in_progress'
            ],

            // 🎯 TARGET → Shivam
            targetUserId: $user->id,

            // 👮 ACTOR → Ramesh
            actorId: $user->id,
            actorName: $user->name,
            actorRole: $user->role
        );

        // Set both success message for SweetAlert2 and step7_submitted flag
        return redirect()->route('user.step7')->with('success', 'Application submitted successfully!')->with('step7_submitted', true);
    }

    /**
     * Step 8 - PDC/Cheque Details
     */
    public function step8(Request $request)
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        $type = Loan_category::where('user_id', $user_id)->latest()->first()->type;

        // Get existing PDC details
        $pdcDetail = PdcDetail::where('user_id', $user_id)->first();

        // Get funding details to check bank_name
        $fundingDetail = FundingDetail::where('user_id', $user_id)->first();

        // Get number of cheques from working committee approval
        $noOfCheques = 11; // Default to 11 cheques
        $workingCommitteeApproval = \Illuminate\Support\Facades\DB::connection('admin_panel')
            ->table('working_committee_approvals')
            ->where('user_id', $user_id)
            ->first();

        if ($workingCommitteeApproval && $workingCommitteeApproval->no_of_cheques_to_be_collected) {
            $noOfCheques = $workingCommitteeApproval->no_of_cheques_to_be_collected;
        }

        // Get edit bank detail request if exists
        $editBankDetailRequest = EditBankDetailRequest::where('user_id', $user_id)->latest()->first();

        // Get all banks for dropdown
        $banks = Bank::all();

        return view('user.step8', compact('type', 'user', 'pdcDetail', 'noOfCheques', 'workingCommitteeApproval', 'fundingDetail', 'editBankDetailRequest', 'banks'));
    }

    /**
     * Store Bank Details from Step 8
     */
    public function step8BankDetailsStore(Request $request)
    {
        $user_id = Auth::id();

        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_holder_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'branch_name' => 'required|string|max:255',
            'ifsc_code' => 'required|string|max:20',
            'bank_address' => 'required|string|max:500',
        ]);

        $fundingDetail = FundingDetail::where('user_id', $user_id)->first();

        $bankData = [
            'bank_name' => $request->bank_name,
            'account_holder_name' => $request->account_holder_name,
            'account_number' => $request->account_number,
            'branch_name' => $request->branch_name,
            'ifsc_code' => $request->ifsc_code,
            'bank_address' => $request->bank_address,
        ];

        if ($fundingDetail) {
            $fundingDetail->update($bankData);
            $message = 'Bank details updated successfully!';
        } else {
            FundingDetail::create(array_merge([
                'user_id' => $user_id,
                'status' => 'step4_completed',
                'submit_status' => 'submited',
            ], $bankData));
            $message = 'Bank details saved successfully!';
        }

        return redirect()->route('user.step8')->with('bank_success', $message);
    }

    /**
     * Store Step 8 - PDC/Cheque Details
     */
    public function step8store(Request $request)
    {
        $user_id = Auth::id();
        // dd($request->all());

        $workflow = ApplicationWorkflowStatus::where('user_id', $user_id)->first();
        if ($workflow && $workflow->apex_2_status === 'approved') {
            return redirect()->route('user.step8')
                ->with('error', 'PDC details are already approved. You cannot update them.');
        }

        $fundingDetail = FundingDetail::where('user_id', $user_id)->first();
        if (
            !$fundingDetail ||
            !$fundingDetail->bank_name ||
            !$fundingDetail->account_holder_name ||
            !$fundingDetail->account_number ||
            !$fundingDetail->branch_name ||
            !$fundingDetail->ifsc_code ||
            !$fundingDetail->bank_address
        ) {
            return redirect()->route('user.step8')
                ->withErrors(['bank_details' => 'Please submit your bank details before submitting PDC details.']);
        }

        // Check if PDC details already exist for this user
        $pdcDetail = PdcDetail::where('user_id', $user_id)->first();

        // Conditional validation for first_cheque_image
        $validationRules = [
            'cheque_details' => 'required|array|min:1',
            'cheque_details.*.cheque_date' => 'required|date',
            'cheque_details.*.amount' => 'required|numeric|min:0',
            'cheque_details.*.bank_name' => 'required|string|max:255',
            'cheque_details.*.ifsc' => 'required|string|max:20',
            'cheque_details.*.account_number' => 'required|string|max:50',
            'cheque_details.*.cheque_number' => 'required|string|max:50',
        ];

        // Only require first_cheque_image if no existing image exists
        if (!$pdcDetail || !$pdcDetail->first_cheque_image) {
            $validationRules['first_cheque_image'] = 'required|mimes:jpeg,png,jpg,pdf|max:2048';
        } else {
            $validationRules['first_cheque_image'] = 'nullable|mimes:jpeg,png,jpg,pdf|max:2048';
        }

        $request->validate($validationRules);

        // Handle first cheque image upload
        $firstChequeImage = null;
        if ($request->hasFile('first_cheque_image')) {
            $fileName = time() . '_first_cheque.' . $request->first_cheque_image->extension();
            $request->first_cheque_image->move('pdc_cheques', $fileName);
            $firstChequeImage = 'pdc_cheques/' . $fileName;
        } elseif ($pdcDetail && $pdcDetail->first_cheque_image) {
            // Keep existing image if no new image uploaded
            $firstChequeImage = $pdcDetail->first_cheque_image;
        }

        // Process cheque details
        $chequeDetails = [];
        foreach ($request->cheque_details as $index => $cheque) {
            $chequeDetails[] = [
                'row_number' => $index + 1,
                'parents_jnt_ac_name' => $cheque['parents_jnt_ac_name'] ?? null,
                'cheque_date' => $cheque['cheque_date'],
                'amount' => $cheque['amount'],
                'bank_name' => $cheque['bank_name'],
                'ifsc' => $cheque['ifsc'],
                'account_number' => $cheque['account_number'],
                'cheque_number' => $cheque['cheque_number'],
            ];
        }

        $data = [
            'user_id' => $user_id,
            'first_cheque_image' => $firstChequeImage,
            'cheque_details' => json_encode($chequeDetails),
            'status' => 'submitted',
        ];

        if ($workflow) {
            $workflow->update([
                'apex_2_status' => 'pending'
            ]);
        }

        // Check if PDC details already exist for this user
        $pdcDetail = PdcDetail::where('user_id', $user_id)->first();

        if ($pdcDetail) {
            // Update existing record
            $pdcDetail->update($data);
            $message = 'PDC details updated successfully!';
        } else {
            // Create new record
            PdcDetail::create($data);
            $message = 'PDC details saved successfully!';
        }

        return redirect()->route('user.step8')->with('success', $message);
    }

    /**
     * Step 9 - Third Stage Documents
     */
    public function step9(Request $request)
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        $type = Loan_category::where('user_id', $user_id)->latest()->first()->type;
        $thirdStageDocument = ThirdStageDocument::where('user_id', $user_id)->first();
        $eligibility = $this->getThirdStageEligibility($user_id);

        if (!$eligibility['eligible']) {
            return redirect()->route('user.home')
                ->with('error', '3rd Stage Documents are not available yet.');
        }

        return view('user.step9', compact('type', 'user', 'thirdStageDocument', 'eligibility'));
    }

    /**
     * Store Step 9 - Third Stage Documents
     */
    public function step9store(Request $request)
    {
        $user_id = Auth::id();
        $user = Auth::user();
        $financialAssetType = $user?->financial_asset_type;
        $eligibility = $this->getThirdStageEligibility($user_id);

        if (!$eligibility['eligible']) {
            return back()->with('error', '3rd Stage Documents are not available yet.');
        }

        $thirdStageDocument = ThirdStageDocument::where('user_id', $user_id)->first();
        if ($thirdStageDocument && in_array($thirdStageDocument->status, ['submitted', 'approved'])) {
            return back()->with('error', '3rd Stage Documents are already submitted. You cannot update them until reviewed.');
        }

        $baseFileRule = 'file|mimes:pdf,jpg,jpeg,png|max:5120';
        $rules = [];

        if ($financialAssetType === 'domestic') {
            $hasMarksheets = $thirdStageDocument && !empty($thirdStageDocument->domestic_marksheets);
            $rules['domestic_marksheets'] = $hasMarksheets ? 'nullable|array' : 'required|array';
            $rules['domestic_marksheets.*'] = $baseFileRule;
            $rules['domestic_paid_fees_receipt'] = ($thirdStageDocument && $thirdStageDocument->domestic_paid_fees_receipt)
                ? 'nullable|' . $baseFileRule
                : 'required|' . $baseFileRule;
            $rules['domestic_cancelled_cheque'] = ($thirdStageDocument && $thirdStageDocument->domestic_cancelled_cheque)
                ? 'nullable|' . $baseFileRule
                : 'required|' . $baseFileRule;
        } elseif ($financialAssetType === 'foreign_finance_assistant') {
            $rules = [
                'foreign_address' => 'required|string|max:1000',
                'foreign_contact_number' => 'required|string|max:30',
                'foreign_ssn_or_country_id' => 'required|string|max:50',
                'foreign_bank_name' => 'required|string|max:255',
                'foreign_bank_account_number' => 'required|string|max:50',
                'foreign_immigration_copy' => ($thirdStageDocument && $thirdStageDocument->foreign_immigration_copy)
                    ? 'nullable|' . $baseFileRule
                    : 'required|' . $baseFileRule,
                'foreign_paid_fees_receipt' => ($thirdStageDocument && $thirdStageDocument->foreign_paid_fees_receipt)
                    ? 'nullable|' . $baseFileRule
                    : 'required|' . $baseFileRule,
            ];
        }

        $request->validate($rules);

        $uploadDir = public_path('third_stage_documents/' . $user_id);
        if (!File::exists($uploadDir)) {
            File::makeDirectory($uploadDir, 0755, true);
        }

        $storeFile = function ($file, string $prefix) use ($uploadDir, $user_id) {
            $safeName = time() . '_' . $prefix . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move($uploadDir, $safeName);
            return 'third_stage_documents/' . $user_id . '/' . $safeName;
        };

        $storeMultiple = function ($files, string $prefix) use ($storeFile) {
            $paths = [];
            foreach ($files as $index => $file) {
                if (!$file) {
                    continue;
                }
                $paths[] = $storeFile($file, $prefix . '_' . $index);
            }
            return $paths;
        };

        $data = [
            'user_id' => $user_id,
            'status' => 'submitted',
            'submitted_at' => now(),
            'admin_remark' => null,
            'processed_by' => null,
        ];

        if ($financialAssetType === 'domestic') {
            $marksheets = $thirdStageDocument?->domestic_marksheets ?? [];
            if ($request->hasFile('domestic_marksheets')) {
                $marksheets = $storeMultiple($request->file('domestic_marksheets'), 'marksheet');
            }

            $data['domestic_marksheets'] = $marksheets;

            $data['domestic_paid_fees_receipt'] = $thirdStageDocument?->domestic_paid_fees_receipt;
            if ($request->hasFile('domestic_paid_fees_receipt')) {
                $data['domestic_paid_fees_receipt'] = $storeFile($request->file('domestic_paid_fees_receipt'), 'paid_fees_receipt');
            }

            $data['domestic_cancelled_cheque'] = $thirdStageDocument?->domestic_cancelled_cheque;
            if ($request->hasFile('domestic_cancelled_cheque')) {
                $data['domestic_cancelled_cheque'] = $storeFile($request->file('domestic_cancelled_cheque'), 'cancelled_cheque');
            }

            $data['foreign_address'] = null;
            $data['foreign_contact_number'] = null;
            $data['foreign_ssn_or_country_id'] = null;
            $data['foreign_immigration_copy'] = null;
            $data['foreign_paid_fees_receipt'] = null;
            $data['foreign_bank_name'] = null;
            $data['foreign_bank_account_number'] = null;
        } elseif ($financialAssetType === 'foreign_finance_assistant') {
            $data['foreign_address'] = $request->foreign_address;
            $data['foreign_contact_number'] = $request->foreign_contact_number;
            $data['foreign_ssn_or_country_id'] = $request->foreign_ssn_or_country_id;
            $data['foreign_bank_name'] = $request->foreign_bank_name;
            $data['foreign_bank_account_number'] = $request->foreign_bank_account_number;

            $data['foreign_immigration_copy'] = $thirdStageDocument?->foreign_immigration_copy;
            if ($request->hasFile('foreign_immigration_copy')) {
                $data['foreign_immigration_copy'] = $storeFile($request->file('foreign_immigration_copy'), 'immigration_copy');
            }

            $data['foreign_paid_fees_receipt'] = $thirdStageDocument?->foreign_paid_fees_receipt;
            if ($request->hasFile('foreign_paid_fees_receipt')) {
                $data['foreign_paid_fees_receipt'] = $storeFile($request->file('foreign_paid_fees_receipt'), 'paid_fees_receipt');
            }

            $data['domestic_marksheets'] = null;
            $data['domestic_paid_fees_receipt'] = null;
            $data['domestic_cancelled_cheque'] = null;
        }

        if ($thirdStageDocument) {
            $thirdStageDocument->update($data);
        } else {
            ThirdStageDocument::create($data);
        }

        return redirect()->route('user.step9')->with('success', 'Third Stage Documents submitted successfully.');
    }

    private function getThirdStageEligibility(int $userId): array
    {
        $firstCompleted = DB::connection('admin_panel')
            ->table('disbursement_schedules')
            ->where('user_id', $userId)
            ->where('installment_no', 1)
            ->where('status', 'completed')
            ->exists();

        $secondSchedule = DB::connection('admin_panel')
            ->table('disbursement_schedules')
            ->where('user_id', $userId)
            ->where('installment_no', 2)
            ->first();

        if (!$secondSchedule || empty($secondSchedule->planned_date)) {
            return [
                'eligible' => false,
                'first_completed' => $firstCompleted,
                'second_date' => null,
                'open_date' => null,
            ];
        }

        $secondDate = Carbon::parse($secondSchedule->planned_date)->startOfDay();
        $openDate = $secondDate->copy()->subMonth()->startOfDay();
        $eligible = $firstCompleted && now()->startOfDay()->gte($openDate);

        return [
            'eligible' => $eligible,
            'first_completed' => $firstCompleted,
            'second_date' => $secondDate,
            'open_date' => $openDate,
        ];
    }

    /**
     * Submit Edit Bank Detail Request
     */
    // public function submitEditBankDetailRequest(Request $request)
    // {
    //     $request->validate([
    //         'reason' => 'required|string|max:1000',
    //     ]);

    //     $user_id = Auth::id();
    //     $user = User::find($user_id);

    //     // Check if Apex Stage 2 has approved PDC details
    //     $workflow = ApplicationWorkflowStatus::where('user_id', $user_id)->first();
    //     if ($workflow && $workflow->apex_2_status === 'approved') {
    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'PDC details have already been approved. You cannot submit a request now.'
    //             ], 422);
    //         }
    //         return redirect()->back()->with('error', 'PDC details have already been approved. You cannot submit a request now.');
    //     }

    //     // Check if there's already a pending request
    //     $existingRequest = EditBankDetailRequest::where('user_id', $user_id)
    //         ->where('status', 'pending')
    //         ->first();

    //     if ($existingRequest) {
    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'You already have a pending request.'
    //             ], 422);
    //         }
    //         return redirect()->back()->with('error', 'You already have a pending request.');
    //     }

    //     // Create new request
    //     EditBankDetailRequest::create([
    //         'user_id' => $user_id,
    //         'reason' => $request->reason,
    //         'status' => 'pending',
    //     ]);

    //     // Send notification to admin
    //     $this->sendAdminNotification(
    //         $user_id,
    //         'Edit Bank Detail Request',
    //         "User {$user->name} (Application No: {$user->application_no}) has submitted an edit bank detail request.",
    //         'edit_bank_detail_request'
    //     );

    //     if ($request->ajax()) {
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Your request has been submitted successfully!'
    //         ]);
    //     }

    //     return redirect()->back()->with('success', 'Your request has been submitted successfully!');
    // }

    public function submitEditBankDetailRequest(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $user_id = Auth::id();
        $user = User::find($user_id);

        // Check if Apex Stage 2 has approved PDC details
        $workflow = ApplicationWorkflowStatus::where('user_id', $user_id)->first();
        if ($workflow && $workflow->apex_2_status === 'approved') {

            return response()->json([
                'success' => false,
                'message' => 'PDC details have already been approved. You cannot submit a request now.'
            ], 422);
        }

        // Check if there's already a pending request
        $existingRequest = EditBankDetailRequest::where('user_id', $user_id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {

            return response()->json([
                'success' => false,
                'message' => 'You already have a pending request.'
            ], 422);
        }

        // Create new request
        EditBankDetailRequest::create([
            'user_id' => $user_id,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        // Send notification to admin
        $this->sendAdminNotification(
            $user_id,
            'Edit Bank Detail Request',
            "User {$user->name} (Application No: {$user->application_no}) has submitted an edit bank detail request.",
            'edit_bank_detail_request'
        );

        return response()->json([
            'success' => true,
            'message' => 'Your request has been submitted successfully!'
        ]);
    }

    /**
     * Update Bank Details (after request is approved)
     */
    public function updateBankDetails(Request $request)
    {
        $user_id = Auth::id();

        // Check if there's an approved request
        $editRequest = EditBankDetailRequest::where('user_id', $user_id)
            ->where('status', 'approved')
            ->latest()
            ->first();

        if (!$editRequest) {
            return response()->json([
                'success' => false,
                'message' => 'No approved request found. Please submit a request first.'
            ], 400);
        }

        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_holder_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'branch_name' => 'required|string|max:255',
            'ifsc_code' => 'required|string|max:20',
            'bank_address' => 'required|string|max:500',
        ]);

        // Get funding detail and update
        $fundingDetail = FundingDetail::where('user_id', $user_id)->first();
        $editbankdetail = EditBankDetailRequest::where('user_id', $user_id)->first();

        if ($fundingDetail) {
            $fundingDetail->update([
                'bank_name' => $request->bank_name,
                'account_holder_name' => $request->account_holder_name,
                'account_number' => $request->account_number,
                'branch_name' => $request->branch_name,
                'ifsc_code' => $request->ifsc_code,
                'bank_address' => $request->bank_address,
            ]);
            $editbankdetail->update([
                'bank_update_status' => 'submitted',
            ]);
        } else {
            FundingDetail::create([
                'user_id' => $user_id,
                'bank_name' => $request->bank_name,
                'account_holder_name' => $request->account_holder_name,
                'account_number' => $request->account_number,
                'branch_name' => $request->branch_name,
                'ifsc_code' => $request->ifsc_code,
                'bank_address' => $request->bank_address,
                'status' => 'step4_completed',
                'submit_status' => 'submited',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Bank details updated successfully!'
        ]);
    }

    /**
     * Send notification to admin
     */
    private function sendAdminNotification($userId, $title, $message, $type)
    {
        try {
            // Get all admin users
            $adminUsers = \DB::connection('admin_panel')
                ->table('admin_users')
                ->where('role', 'admin')
                ->get();

            foreach ($adminUsers as $admin) {
                \App\Models\AdminNotification::create([
                    'user_id' => $userId,
                    'admin_user_id' => $admin->id,
                    'title' => $title,
                    'message' => $message,
                    'type' => $type,
                    'is_read' => false,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send admin notification: ' . $e->getMessage());
        }
    }

    /**
     * Verify Bank Details API
     */
    public function verifyBankDetails(Request $request)
    {
        $request->validate([
            'account_number' => 'required|string',
            'ifsc_code' => 'required|string',
        ]);

        $accountNumber = $request->account_number;
        $ifscCode = $request->ifsc_code;

        try {
            // Get bank details from JitoJeapBank table
            $bank = JitoJeapBank::where('ifsc_code', $ifscCode)->first();

            if (!$bank) {
                return response()->json([
                    'success' => false,
                    'valid' => false,
                    'message' => 'Bank not found in JITO JEAP registered banks'
                ]);
            }

            // Note: Actual bank verification API would be called here
            // For now, we'll return a success message if the bank is in our system
            return response()->json([
                'success' => true,
                'valid' => true,
                'message' => 'Bank verified successfully! Branch: ' . ($bank->branch ?? 'N/A')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'valid' => false,
                'message' => 'Verification failed: ' . $e->getMessage()
            ]);
        }
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
            $chapterId = $result['chapter']?->id ?? null;
            $zoneName = $result['chapter']?->zone?->zone_name ?? null;
            $chairman = $result['chapter']?->chapter_head ?? null;
            $contact = $result['chapter']?->contact ?? null;
            $fallback = in_array($result['assigned_by'], ['nearest', 'nearest_pincode']);
            $fallback = in_array($result['assigned_by'], ['nearest_pincode_same_state', 'nearest_pincode_any_state', 'nearest_chapter']);

            // Include distance and location info for all assignments that have distance data
            $response = [
                'success' => true,
                'chapter' => $chapterName,
                'chapter_id' => $chapterId,
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

    public function validateAadhar(Request $request)
    {
        try {
            // Validate input
            $request->validate([
                'aadhar_card_number' => 'required|digits:12'
            ]);

            $enteredAadhar = $request->aadhar_card_number;
            $userId = Auth::id();
            $user = User::find($userId);

            // Check if the last 4 digits of entered Aadhaar match the user's stored Aadhaar last 4 digits
            if ($user && $user->aadhar_card_number) {
                $storedLast4Digits = substr($user->aadhar_card_number, -4);
                $enteredLast4Digits = substr($enteredAadhar, -4);

                if ($storedLast4Digits !== $enteredLast4Digits) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Aadhaar validation failed. Last 4 digits do not match your registered Aadhaar number.'
                    ], 400);
                }
            }

            // Check if this Aadhaar number is already used by another user
            $existingUser = User::where('aadhar_card_number', $enteredAadhar)
                ->where('id', '!=', $userId)
                ->first();

            if ($existingUser) {
                return response()->json([
                    'success' => false,
                    'message' => 'This Aadhaar number is already registered with another account.'
                ], 400);
            }

            // Extract last 4 digits as per requirement
            $last4Digits = substr($enteredAadhar, -4);

            return response()->json([
                'success' => true,
                'message' => 'Aadhaar validated successfully.',
                'last_4_digits' => $last4Digits
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Aadhaar number format. Must be exactly 12 digits.'
            ], 422);
        } catch (\Exception $e) {
            Log::error('Aadhaar validation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while validating Aadhaar number. Please try again.'
            ], 500);
        }
    }

    private function checkAndUpdateWorkflowStatus()
    {
        $userId = Auth::id();

        // Check all steps for resubmit status
        $steps = [
            Auth::user()->submit_status,
            EducationDetail::where('user_id', $userId)->first()?->submit_status,
            Familydetail::where('user_id', $userId)->first()?->submit_status,
            FundingDetail::where('user_id', $userId)->first()?->submit_status,
            GuarantorDetail::where('user_id', $userId)->first()?->submit_status,
            Document::where('user_id', $userId)->first()?->submit_status,
        ];

        $hasResubmit = in_array('resubmit', $steps);

        if (!$hasResubmit) {
            $workflow = ApplicationWorkflowStatus::where('user_id', $userId)->first();
            if ($workflow && $workflow->apex_1_status == 'rejected') {
                // Log the workflow status update
                $user = User::find($userId);
                if ($user) {
                    $this->logUserActivity(
                        processType: 'Application Resubmission after Send back for Correction',
                        processAction: 'Application Resubmission',
                        processDescription: 'User resubmitted all steps, application resubmitted after being sent back for correction',
                        module: 'application',
                        oldValues: ['apex_1_status' => 'rejected'],
                        newValues: ['apex_1_status' => 'pending'],
                        additionalData: [
                            'user_id' => $user->id,
                            'user_name' => $user->name,
                            'user_email' => $user->email,
                            'workflow_id' => $workflow->id,
                            'previous_status' => 'rejected',
                            'new_status' => 'pending',
                            'reason' => 'All steps resubmitted successfully'
                        ],

                        // 🎯 TARGET → Shivam
                        targetUserId: $user->id,

                        // 👮 ACTOR → Ramesh
                        actorId: $user->id,
                        actorName: $user->name,
                        actorRole: $user->role
                    );
                }

                $workflow->update(['apex_1_status' => 'pending']);
            }
        }
    }

    public function showUserLogs()
    {
        $user = Auth::user();
        $logs = Logs::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('user.logs', compact('logs', 'user'));
    }



    private function isStepResubmission(string $step): bool
    {
        $userId = Auth::id();

        // Step-wise submit_status mapping
        $stepStatusMap = [
            'step1' => Auth::user()->submit_status,
            'step2' => EducationDetail::where('user_id', $userId)->first()?->submit_status,
            'step3' => Familydetail::where('user_id', $userId)->first()?->submit_status,
            'step4' => FundingDetail::where('user_id', $userId)->first()?->submit_status,
            'step5' => GuarantorDetail::where('user_id', $userId)->first()?->submit_status,
            'step6' => Document::where('user_id', $userId)->first()?->submit_status,
        ];

        $workflow = ApplicationWorkflowStatus::where('user_id', $userId)->first();

        return ($stepStatusMap[$step] ?? null) === 'resubmit'
            && $workflow
            && $workflow->apex_1_status === 'rejected'
            && !empty($workflow->apex_1_reject_remarks);
    }

    /**
     * Generate Application PDF for user
     */
    public function generateApplicationPDF($user)
    {
        // Get the user by ID
        $user = User::find($user);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        // Get all related data for the PDF
        $educationDetail = EducationDetail::where('user_id', $user->id)->first();
        $familyDetail = Familydetail::where('user_id', $user->id)->first();
        $fundingDetail = FundingDetail::where('user_id', $user->id)->first();
        $guarantorDetail = GuarantorDetail::where('user_id', $user->id)->first();
        $document = Document::where('user_id', $user->id)->first();
        $loanCategory = Loan_category::where('user_id', $user->id)->latest()->first();

        // Get workflow status
        $workflow = ApplicationWorkflowStatus::where('user_id', $user->id)->first();

        // Create PDF using DomPDF
        $pdf = \PDF::loadView('user.pdf.application', compact(
            'user',
            'educationDetail',
            'familyDetail',
            'fundingDetail',
            'guarantorDetail',
            'document',
            'loanCategory',
            'workflow'
        ));

        return $pdf->download('application_' . $user->id . '.pdf');
    }

    /**
     * Generate Summary PDF for user
     */
    public function generateSummaryPDF($user)
    {
        // Get the user by ID
        $user = User::find($user);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        // Get all related data for the summary
        $educationDetail = EducationDetail::where('user_id', $user->id)->first();
        $familyDetail = Familydetail::where('user_id', $user->id)->first();
        $fundingDetail = FundingDetail::where('user_id', $user->id)->first();
        $guarantorDetail = GuarantorDetail::where('user_id', $user->id)->first();
        $loanCategory = Loan_category::where('user_id', $user->id)->latest()->first();

        // Create PDF using DomPDF
        $pdf = \PDF::loadView('user.pdf.summary', compact(
            'user',
            'educationDetail',
            'familyDetail',
            'fundingDetail',
            'guarantorDetail',
            'loanCategory'
        ));

        return $pdf->download('summary_' . $user->id . '.pdf');
    }

    /**
     * View Sanction Letter for user
     */
    public function viewSanctionLetter($user)
    {
        // Get the user by ID
        $user = User::find($user);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        // Get workflow status to check if user is approved
        $workflow = ApplicationWorkflowStatus::where('user_id', $user->id)->first();

        if (!$workflow || $workflow->final_status !== 'approved') {
            return redirect()->back()->with('error', 'Sanction letter not available. Application not yet approved.');
        }

        // Get all related data for the sanction letter
        $educationDetail = EducationDetail::where('user_id', $user->id)->first();
        $fundingDetail = FundingDetail::where('user_id', $user->id)->first();
        $loanCategory = Loan_category::where('user_id', $user->id)->latest()->first();

        // Create PDF using DomPDF
        $pdf = \PDF::loadView('user.pdf.sanction_letter', compact(
            'user',
            'educationDetail',
            'fundingDetail',
            'loanCategory',
            'workflow'
        ));

        return $pdf->stream('sanction_letter_' . $user->id . '.pdf');
    }

    /**
     * Handle redirection for above 1 lakh application
     */
    public function above1LakhApplication()
    {
        $user = Auth::user();
        // dd($user);
        // Check if user has a loan category
        $loanCategory = Loan_category::where('user_id', $user->id)->latest()->first();
        return view('user.home', compact('user', 'loanCategory'));

        // if (!$loanCategory) {
        //     return redirect()->route('user.home')->with('error', 'Please select a loan category first.');
        // }

        // // Check if user has completed step 1
        // if (!$user || $user->submit_status !== 'submited') {
        //     return redirect()->route('user.step1');
        // }

        // // Check if user has completed step 2
        // $educationDetail = EducationDetail::where('user_id', $user->id)->first();
        // if (!$educationDetail || $educationDetail->submit_status !== 'submited') {
        //     return redirect()->route('user.step2');
        // }

        // // Check if user has completed step 3
        // $familyDetail = Familydetail::where('user_id', $user->id)->first();
        // if (!$familyDetail || $familyDetail->submit_status !== 'submited') {
        //     return redirect()->route('user.step3');
        // }

        // // Check if user has completed step 4
        // $fundingDetail = FundingDetail::where('user_id', $user->id)->first();
        // if (!$fundingDetail || $fundingDetail->submit_status !== 'submited') {
        //     return redirect()->route('user.step4');
        // }

        // // Check if user has completed step 5 (guarantor details)
        // $guarantorDetail = GuarantorDetail::where('user_id', $user->id)->first();
        // if (!$guarantorDetail || $guarantorDetail->submit_status !== 'submited') {
        //     return redirect()->route('user.step5');
        // }

        // // Check if user has completed step 6 (document upload)
        // $document = Document::where('user_id', $user->id)->first();
        // if (!$document || $document->submit_status !== 'submited') {
        //     return redirect()->route('user.step6');
        // }

        // // All steps completed, redirect to step 7 (Review & Submit)
        // return redirect()->route('user.step7');
    }
}
