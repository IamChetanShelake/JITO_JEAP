<?php

namespace App\Http\Controllers;

use App\Exports\JeapDisbursementReportExport;
use App\Exports\DynamicReportExport;
use App\Models\Donor;
use App\Models\DonorPaymentDetail;
use App\Models\Repayment;
use App\Models\ReportTemplate;
use App\Models\DisbursementSchedule;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;

class ReportController extends Controller
{
    /**
     * Display the dynamic report builder page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $predefinedReports = ReportTemplate::predefined()->get();
        $customReports = ReportTemplate::custom()->latest()->get();

        return view('admin.reports.index', compact('predefinedReports', 'customReports'));
    }

    /**
     * Get all available fields for report building
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableFields()
    {
        $fields = [
            'Student Information' => [
                'id' => 'ID',
                'name' => 'Student Name',
                'email' => 'Email',
                'mobile' => 'Mobile',
                'application_number' => 'Application Number',
                'date_of_birth' => 'Date of Birth',
                'gender' => 'Gender',
                'religion' => 'Religion',
                'caste' => 'Caste',
                'sub_caste' => 'Sub Caste',
                'aadhaar_number' => 'Aadhaar Number',
                'pan_number' => 'PAN Number',
                'address' => 'Address',
                'city' => 'City',
                'state' => 'State',
                'pincode' => 'Pincode',
                'postal_address' => 'Postal Address',
                'application_status' => 'Application Status',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',

                // Additional stored user fields (step1 and related)
                'role' => 'Role',
                'phone' => 'Phone (DB)',
                'alternate_phone' => 'Alternate Phone',
                'alternate_email' => 'Alternate Email',
                'marital_status' => 'Marital Status',
                'nationality' => 'Nationality',
                'birth_place' => 'Birth Place',
                'age' => 'Age',
                'blood_group' => 'Blood Group',
                'specially_abled' => 'Specially Abled',
                'aadhar_card_number' => 'Aadhaar Card Number (DB)',
                'pan_card' => 'PAN Card (DB)',
                'd_o_b' => 'DOB (DB)',
                'sub_cast' => 'Sub Cast (DB)',
                'aadhar_address' => 'Aadhaar Address',
                'current_address' => 'Current Address',
                'district' => 'District',
                'new_zone' => 'New Zone',
                'status' => 'User Status',
                'register_date' => 'Register Date',
                'image' => 'Image',
                'flat_no' => 'Flat No',
                'building_no' => 'Building No',
                'street_name' => 'Street Name',
                'area' => 'Area',
                'landmark' => 'Landmark',
                'address1' => 'Address 2',
                'chapter' => 'Chapter (Text)',
                'chapter_id' => 'Chapter ID',
                'zone' => 'Zone (Text)',
                'chapter_chairman' => 'Chapter Chairman',
                'chapter_contact' => 'Chapter Contact',
                'submit_status' => 'Submit Status (DB)',
            ],
            'Family Details' => [
                'family.father_name' => 'Father Name',
                'family.father_mobile' => 'Father Mobile',
                'family.father_occupation' => 'Father Occupation',
                'family.father_annual_income' => 'Father Annual Income',
                'family.mother_name' => 'Mother Name',
                'family.mother_mobile' => 'Mother Mobile',
                'family.mother_occupation' => 'Mother Occupation',
                'family.mother_annual_income' => 'Mother Annual Income',
                'family.total_family_members' => 'Total Family Members',
                'family.annual_family_income' => 'Annual Family Income',

                // All stored familydetails fields (step2)
                'family.number_family_members' => 'Number Family Members (DB)',
                'family.total_family_income' => 'Total Family Income (DB)',
                'family.total_students' => 'Total Students',
                'family.family_member_diksha' => 'Family Member Diksha',
                'family.total_insurance_coverage' => 'Total Insurance Coverage',
                'family.total_premium_paid' => 'Total Premium Paid',
                'family.father_age' => 'Father Age',
                'family.father_marital_status' => 'Father Marital Status',
                'family.father_qualification' => 'Father Qualification',
                'family.father_email' => 'Father Email',
                'family.father_yearly_gross_income' => 'Father Yearly Gross Income (DB)',
                'family.father_individual_insurance_coverage' => 'Father Individual Insurance Coverage',
                'family.father_individual_premium_paid' => 'Father Individual Premium Paid',
                'family.father_aadhaar' => 'Father Aadhaar',
                'family.father_photo' => 'Father Photo',
                'family.mother_age' => 'Mother Age',
                'family.mother_marital_status' => 'Mother Marital Status',
                'family.mother_qualification' => 'Mother Qualification',
                'family.mother_email' => 'Mother Email',
                'family.mother_yearly_gross_income' => 'Mother Yearly Gross Income (DB)',
                'family.mother_individual_insurance_coverage' => 'Mother Individual Insurance Coverage',
                'family.mother_individual_premium_paid' => 'Mother Individual Premium Paid',
                'family.mother_aadhaar' => 'Mother Aadhaar',
                'family.mother_photo' => 'Mother Photo',
                'family.has_sibling' => 'Has Sibling',
                'family.number_of_siblings' => 'Number Of Siblings',
                'family.sibling_name_1' => 'Sibling Name 1',
                'family.sibling_qualification' => 'Sibling Qualification',
                'family.sibling_occupation' => 'Sibling Occupation',
                'family.sibling_mobile' => 'Sibling Mobile',
                'family.sibling_email' => 'Sibling Email',
                'family.sibling_yearly_income' => 'Sibling Yearly Income',
                'family.sibling_insurance_coverage' => 'Sibling Insurance Coverage',
                'family.sibling_premium_paid' => 'Sibling Premium Paid',
                'family.additional_email' => 'Additional Email',
                'family.yearly_gross_income' => 'Yearly Gross Income',
                'family.individual_insurance_coverage' => 'Individual Insurance Coverage',
                'family.individual_premium_paid' => 'Individual Premium Paid',
                'family.paternal_uncle_name' => 'Paternal Uncle Name',
                'family.paternal_uncle_mobile' => 'Paternal Uncle Mobile',
                'family.paternal_uncle_email' => 'Paternal Uncle Email',
                'family.paternal_aunt_name' => 'Paternal Aunt Name',
                'family.paternal_aunt_mobile' => 'Paternal Aunt Mobile',
                'family.paternal_aunt_email' => 'Paternal Aunt Email',
                'family.maternal_uncle_name' => 'Maternal Uncle Name',
                'family.maternal_uncle_mobile' => 'Maternal Uncle Mobile',
                'family.maternal_uncle_email' => 'Maternal Uncle Email',
                'family.maternal_aunt_name' => 'Maternal Aunt Name',
                'family.maternal_aunt_mobile' => 'Maternal Aunt Mobile',
                'family.maternal_aunt_email' => 'Maternal Aunt Email',
                'family.submit_status' => 'Family Submit Status',
            ],
            'Education Details' => [
                'education.course_name' => 'Course Name',
                'education.course_type' => 'Course Type',
                'education.institution_name' => 'Institution Name',
                'education.university_name' => 'University Name',
                'education.start_year' => 'Start Year',
                'education.expected_year' => 'Expected Year',
                'education.course_duration' => 'Course Duration',
                'education.tuition_fee' => 'Tuition Fee',
                'education.hostel_fee' => 'Hostel Fee',
                'education.other_fee' => 'Total Fee',
                'education.sgpa' => 'SGPA',
                'education.percentage' => 'Percentage',

                // All stored education_details fields (step3)
                'education.current_pursuing' => 'Currently Pursuing',
                'education.current_course_name' => 'Current Course Name',
                'education.current_institution' => 'Current Institution',
                'education.current_university' => 'Current University',
                'education.current_start_year' => 'Current Start Year',
                'education.current_expected_year' => 'Current Expected Year',
                'education.current_mode_of_study' => 'Current Mode Of Study',
                'education.qualifications' => 'Qualifications',
                'education.qualification_course_name' => 'Qualification Course Name',
                'education.qualification_institution' => 'Qualification Institution',
                'education.qualification_university' => 'Qualification University',
                'education.qualification_specialization' => 'Qualification Specialization',
                'education.qualification_percentage' => 'Qualification Percentage',
                'education.qualification_mode_of_study' => 'Qualification Mode Of Study',
                'education.jc_college_name' => 'JC College Name',
                'education.jc_stream' => 'JC Stream',
                'education.jc_board' => 'JC Board',
                'education.jc_completion_year' => 'JC Completion Year',
                'education.jc_percentage' => 'JC Percentage',
                'education.school_name' => 'School Name',
                'education.school_board' => 'School Board',
                'education.school_completion_year' => 'School Completion Year',
                'education.school_percentage' => 'School Percentage',
                'education.ielts_overall_band_year' => 'IELTS Overall Band/Year',
                'education.toefl_score_year' => 'TOEFL Score/Year',
                'education.duolingo_det_score_year' => 'Duolingo DET Score/Year',
                'education.gre_score_year' => 'GRE Score/Year',
                'education.gmat_score_year' => 'GMAT Score/Year',
                'education.sat_score_year' => 'SAT Score/Year',
                'education.have_work_experience' => 'Have Work Experience',
                'education.organization_name' => 'Organization Name',
                'education.work_profile' => 'Work Profile',
                'education.work_duration' => 'Work Duration',
                'education.work_location_city' => 'Work Location City',
                'education.work_country' => 'Work Country',
                'education.work_type' => 'Work Type',
                'education.awards_recognition' => 'Awards/Recognition',
                'education.volunteer_work' => 'Volunteer Work',
                'education.leadership_roles' => 'Leadership Roles',
                'education.sports_cultural' => 'Sports/Cultural',
                'education.institute_name' => 'Institute Name (DB)',
                'education.city_name' => 'City Name (Education)',
                'education.country' => 'Country',
                'education.duration' => 'Duration (DB)',
                'education.college_name' => 'College Name',
                'education.nirf_ranking' => 'NIRF Ranking',
                'education.10th_mark_obtained' => '10th Mark Obtained',
                'education.10th_mark_out_of' => '10th Mark Out Of',
                'education.school_CGPA' => 'School CGPA',
                'education.school_sgpa' => 'School SGPA',
                'education.12th_mark_obtained' => '12th Mark Obtained',
                'education.12th_mark_out_of' => '12th Mark Out Of',
                'education.jc_CGPA' => 'JC CGPA',
                'education.jc_sgpa' => 'JC SGPA',
                'education.qualification_start_year' => 'Qualification Start Year',
                'education.qualification_end_year' => 'Qualification End Year',
                'education.marksheet_type' => 'Marksheet Type (JSON)',
                'education.marks_obtained' => 'Marks Obtained (JSON)',
                'education.out_of' => 'Out Of (JSON)',
                'education.cgpa' => 'CGPA (JSON)',
                'education.group_1_year1' => 'Group 1 Year 1',
                'education.group_1_year2' => 'Group 1 Year 2',
                'education.group_1_year3' => 'Group 1 Year 3',
                'education.group_1_year4' => 'Group 1 Year 4',
                'education.group_1_year5' => 'Group 1 Year 5',
                'education.group_1_total' => 'Group 1 Total',
                'education.group_2_year1' => 'Group 2 Year 1',
                'education.group_2_year2' => 'Group 2 Year 2',
                'education.group_2_year3' => 'Group 2 Year 3',
                'education.group_2_year4' => 'Group 2 Year 4',
                'education.group_2_year5' => 'Group 2 Year 5',
                'education.group_2_total' => 'Group 2 Total',
                'education.group_3_year1' => 'Group 3 Year 1',
                'education.group_3_year2' => 'Group 3 Year 2',
                'education.group_3_year3' => 'Group 3 Year 3',
                'education.group_3_year4' => 'Group 3 Year 4',
                'education.group_3_year5' => 'Group 3 Year 5',
                'education.group_3_total' => 'Group 3 Total',
                'education.group_4_year1' => 'Group 4 Year 1',
                'education.group_4_year2' => 'Group 4 Year 2',
                'education.group_4_year3' => 'Group 4 Year 3',
                'education.group_4_year4' => 'Group 4 Year 4',
                'education.group_4_year5' => 'Group 4 Year 5',
                'education.group_4_total' => 'Group 4 Total',
                'education.status' => 'Education Status',
                'education.submit_status' => 'Education Submit Status',
            ],
            'Funding Details' => [
                'funding.loan_amount_requested' => 'Loan Amount Requested',
                'funding.loan_category' => 'Loan Category',
                'funding.funds_arranged' => 'Funds Arranged',
                'funding.funds_source' => 'Funds Source',
                'funding.scholarship_amount' => 'Scholarship Amount',

                // All stored funding_details fields (step4)
                'funding.amount_requested_year' => 'Amount Requested Year',
                'funding.tuition_fees_amount' => 'Tuition Fees Amount (DB)',
                'funding.family_funding_status' => 'Family Funding Status',
                'funding.family_funding_trust' => 'Family Funding Trust',
                'funding.family_funding_contact' => 'Family Funding Contact',
                'funding.family_funding_mobile' => 'Family Funding Mobile',
                'funding.family_funding_amount' => 'Family Funding Amount',
                'funding.bank_loan_status' => 'Bank Loan Status',
                'funding.bank_loan_trust' => 'Bank Loan Trust',
                'funding.bank_loan_contact' => 'Bank Loan Contact',
                'funding.bank_loan_mobile' => 'Bank Loan Mobile',
                'funding.bank_loan_amount' => 'Bank Loan Amount',
                'funding.other_assistance1_status' => 'Other Assistance 1 Status',
                'funding.other_assistance1_trust' => 'Other Assistance 1 Trust',
                'funding.other_assistance1_contact' => 'Other Assistance 1 Contact',
                'funding.other_assistance1_mobile' => 'Other Assistance 1 Mobile',
                'funding.other_assistance1_amount' => 'Other Assistance 1 Amount',
                'funding.other_assistance2_status' => 'Other Assistance 2 Status',
                'funding.other_assistance2_trust' => 'Other Assistance 2 Trust',
                'funding.other_assistance2_contact' => 'Other Assistance 2 Contact',
                'funding.other_assistance2_mobile' => 'Other Assistance 2 Mobile',
                'funding.other_assistance2_amount' => 'Other Assistance 2 Amount',
                'funding.local_assistance_status' => 'Local Assistance Status',
                'funding.local_assistance_trust' => 'Local Assistance Trust',
                'funding.local_assistance_contact' => 'Local Assistance Contact',
                'funding.local_assistance_mobile' => 'Local Assistance Mobile',
                'funding.local_assistance_amount' => 'Local Assistance Amount',
                'funding.total_funding_amount' => 'Total Funding Amount (DB)',
                'funding.sibling_assistance' => 'Sibling Assistance',
                'funding.sibling_name' => 'Sibling Name',
                'funding.sibling_number' => 'Sibling Number',
                'funding.sibling_ngo_name' => 'Sibling NGO Name',
                'funding.ngo_number' => 'NGO Number',
                'funding.sibling_loan_status' => 'Sibling Loan Status',
                'funding.sibling_applied_year' => 'Sibling Applied Year',
                'funding.sibling_applied_amount' => 'Sibling Applied Amount',
                'funding.account_holder_name' => 'Account Holder Name',
                'funding.bank_name' => 'Bank Name',
                'funding.account_number' => 'Account Number',
                'funding.branch_name' => 'Branch Name',
                'funding.ifsc_code' => 'IFSC Code',
                'funding.bank_address' => 'Bank Address',
                'funding.funding_details' => 'Funding Details (JSON)',
                'funding.status' => 'Funding Status',
                'funding.submit_status' => 'Funding Submit Status',
            ],
            'Workflow Status' => [
                'workflow.stage' => 'Current Stage',
                'workflow.status' => 'Workflow Status',
                'workflow.final_status' => 'Final Status',
                'workflow.assistance_amount' => 'Assistance Amount',

                // All stored application_workflow_statuses fields (admin workflow)
                'workflow.current_stage' => 'Current Stage (DB)',
                'workflow.apex_1_status' => 'Apex 1 Status',
                'workflow.apex_1_approval_remarks' => 'Apex 1 Approval Remarks',
                'workflow.apex_1_reject_remarks' => 'Apex 1 Reject Remarks',
                'workflow.apex_1_updated_at' => 'Apex 1 Updated At',
                'workflow.chapter_status' => 'Chapter Status',
                'workflow.chapter_remarks' => 'Chapter Remarks',
                'workflow.chapter_updated_at' => 'Chapter Updated At',
                'workflow.working_committee_status' => 'Working Committee Status',
                'workflow.working_committee_remarks' => 'Working Committee Remarks',
                'workflow.working_committee_updated_at' => 'Working Committee Updated At',
                'workflow.apex_2_status' => 'Apex 2 Status',
                'workflow.apex_2_remarks' => 'Apex 2 Remarks',
                'workflow.apex_2_updated_at' => 'Apex 2 Updated At',
            ],
            'PDC Details' => [
                'pdc.courier_receive_status' => 'Courier Receive Status',
                'pdc.courier_receive_date' => 'Courier Receive Date',
                'pdc.courier_receive_hold_remark' => 'Hold Remark',
                'pdc.courier_received_by' => 'Courier Received By',
                'pdc.courier_receive_processed_at' => 'Courier Processed At',
                'pdc.status' => 'PDC Status',
                'pdc.first_cheque_image' => 'First Cheque Image',
                'pdc.admin_approve_remark' => 'PDC Approve Remark',
                'pdc.admin_reject_remark' => 'PDC Reject Remark',

                // All stored pdc_details fields
                'pdc.cheque_details' => 'Cheque Details (JSON)',
                'pdc.processed_by' => 'Processed By',
                'pdc.courier_receive_processed_by' => 'Courier Processed By',
                'pdc.courier_receive_verified_documents' => 'Courier Verified Documents (JSON)',
            ],
            'Approval Details' => [
                'approval.meeting_no' => 'Meeting No',
                'approval.disbursement_system' => 'Disbursement System',
                'approval.approved_amount' => 'Approved Amount',

                // Additional stored approval fields
                'approval.w_c_approval_date' => 'WC Approval Date',
                'approval.w_c_approval_remark' => 'WC Approval Remark',
                'approval.w_c_rejection_remark' => 'WC Rejection Remark',
                'approval.disbursement_in_year' => 'Disbursement In Year',
                'approval.disbursement_in_half_year' => 'Disbursement In Half Year',
                'approval.yearly_dates' => 'Yearly Dates (JSON)',
                'approval.yearly_amounts' => 'Yearly Amounts (JSON)',
                'approval.half_yearly_dates' => 'Half Yearly Dates (JSON)',
                'approval.half_yearly_amounts' => 'Half Yearly Amounts (JSON)',
                'approval.approval_financial_assistance_amount' => 'Approval Financial Assistance Amount',
                'approval.installment_amount' => 'Installment Amount',
                'approval.additional_installment_amount' => 'Additional Installment Amount',
                'approval.repayment_type' => 'Repayment Type',
                'approval.no_of_cheques_to_be_collected' => 'No Of Cheques To Be Collected',
                'approval.repayment_starting_from' => 'Repayment Starting From',
                'approval.remarks_for_approval' => 'Remarks For Approval',
                'approval.processed_by' => 'Approval Processed By',
                'approval.approval_status' => 'Approval Status',
            ],
            'Chapter Details' => [
                'chapter.name' => 'Chapter Name',
                'chapter.zone' => 'Zone',
                'chapter.chapter_head' => 'Chapter Head',
                'chapter.chapter_name' => 'Chapter Name (DB)',
                'chapter.city' => 'Chapter City',
                'chapter.pincode' => 'Chapter Pincode',
                'chapter.state' => 'Chapter State',
                'chapter.email' => 'Chapter Email',
                'chapter.contact' => 'Chapter Contact',
            ],
            'Third Stage Documents' => [
                'third_stage.foreign_address' => 'Foreign Address',
                'third_stage.foreign_contact_number' => 'Foreign Contact Number',
                'third_stage.foreign_ssn_or_country_id' => 'Foreign SSN / Country ID',
                'third_stage.foreign_bank_name' => 'Foreign Bank Name',
                'third_stage.foreign_bank_account_number' => 'Foreign Bank Account Number',
                'third_stage.status' => 'Third Stage Status',
                'third_stage.admin_remark' => 'Admin Remark',
            ],
        ];

        return response()->json($fields);
    }

    /**
     * Generate and export dynamic report
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function generateDynamicReport(Request $request)
    {
        $request->validate([
            'selected_fields' => 'required|array|min:1',
            'selected_fields.*' => 'string',
            'filters' => 'array',
            'filters.*.field' => 'required|string',
            'filters.*.operator' => 'required|string',
            'filters.*.value' => 'nullable',
        ]);

        $selectedFields = $request->input('selected_fields', []);
        $filters = $request->input('filters', []);

        $fileName = 'Dynamic_Report_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(
            new DynamicReportExport($selectedFields, $filters),
            $fileName
        );
    }

    /**
     * Save report template
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveTemplate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'selected_fields' => 'required|array|min:1',
            'filters' => 'array',
            'category' => 'nullable|string',
        ]);

        $template = ReportTemplate::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'selected_fields' => $request->input('selected_fields'),
            'filters' => $request->input('filters', []),
            'is_predefined' => false,
            'category' => $request->input('category'),
            'created_by' => Auth::guard('admin')->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Report template saved successfully',
            'template' => $template,
        ]);
    }

    /**
     * Load report template
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function loadTemplate($id)
    {
        $template = ReportTemplate::findOrFail($id);

        return response()->json([
            'success' => true,
            'template' => $template,
        ]);
    }

    /**
     * Export report from template
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportFromTemplate($id)
    {
        $template = ReportTemplate::findOrFail($id);

        $fileName = str_replace(' ', '_', $template->name) . '_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(
            new DynamicReportExport($template->selected_fields, $template->filters ?? []),
            $fileName
        );
    }

    /**
     * Delete report template
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteTemplate($id)
    {
        $template = ReportTemplate::findOrFail($id);

        // Prevent deletion of predefined reports
        if ($template->is_predefined) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete predefined reports',
            ], 403);
        }

        $template->delete();

        return response()->json([
            'success' => true,
            'message' => 'Report template deleted successfully',
        ]);
    }

    /**
     * Export JEAP Disbursement Report
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function jeapDisbursement()
    {
        $fileName = 'JEAP_Disbursement_Report_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(
            new JeapDisbursementReportExport(),
            $fileName
        );
    }

    /**
     * Graph-based financial assistance report (HTML preview + PDF download).
     */
    public function financialGraphReport(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date', '2023-07-01'))->startOfDay();
        $endDate   = Carbon::parse($request->input('end_date', now()->toDateString()))->endOfDay();

        $applications = User::with([
            'educationDetail',
            'chapterMaster.zone',
            'workflowStatus',
            'workingCommitteeApproval',
        ])->where('role', 'user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $courseTypeStats = [
            'Domestic' => ['UG' => 0, 'PG' => 0],
            'Foreign'  => ['UG' => 0, 'PG' => 0],
        ];
        foreach ($applications as $user) {
            $courseType = $this->resolveCourseType($user->educationDetail);
            $faType     = $this->resolveFaType($user->educationDetail);
            if (isset($courseTypeStats[$faType][$courseType])) {
                $courseTypeStats[$faType][$courseType]++;
            }
        }

        $totalApplications = $applications->count();

        $zoneCounts = $applications->groupBy(function ($user) {
            return $user->chapterMaster?->zone?->zone_name ?? $user->zone ?? 'N/A';
        })->map->count()->sortDesc();

        $chapterCounts = $applications->groupBy(function ($user) {
            return $user->chapterMaster?->chapter_name ?? $user->chapter ?? 'N/A';
        })->map->count()->sortDesc();

        $rejected = $applications->filter(function ($user) {
            return ($user->workflowStatus?->final_status ?? null) === 'rejected';
        });

        $rejectedByZone = $rejected->groupBy(function ($user) {
            return $user->chapterMaster?->zone?->zone_name ?? $user->zone ?? 'N/A';
        })->map->count()->sortDesc();

        $totalSanctioned = (float) $applications->sum(function ($user) {
            return (float) ($user->workingCommitteeApproval?->approval_financial_assistance_amount ?? 0);
        });

        $totalDisbursed = (float) \App\Models\Repayment::query()
            ->whereNotNull('payment_date')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->sum('amount');

        $totalDonations = (float) \App\Models\DonorPaymentDetail::query()
            ->whereNotNull('payment_date')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->sum('amount');

        $financialSummary = [
            'donations'  => $totalDonations,
            'sanctioned' => $totalSanctioned,
            'disbursed'  => $totalDisbursed,
        ];

        $committeeMembers = \App\Models\Donor::query()
            ->leftJoin('donor_personal_details as dpd', 'dpd.donor_id', '=', 'donors.id')
            ->where('donors.donor_type', \App\Models\Donor::TYPE_MEMBER)
            ->orderBy('donors.id', 'desc')
            ->take(15)
            ->get([
                'donors.id',
                'donors.name',
                'dpd.title',
                'dpd.first_name',
                'dpd.middle_name',
                'dpd.surname',
                'dpd.zone',
            ])
            ->map(function ($donor) {
                $name = trim(implode(' ', array_filter([
                    $donor->title ?? null,
                    $donor->first_name ?? null,
                    $donor->middle_name ?? null,
                    $donor->surname ?? null,
                ])));
                return [
                    'name' => $name ?: ($donor->name ?? 'Member'),
                    'zone' => $donor->zone ?: 'N/A',
                ];
            });

        // Pass raw ISO dates to avoid Carbon re-parsing formatted strings
        $viewData = compact(
            'courseTypeStats',
            'totalApplications',
            'zoneCounts',
            'chapterCounts',
            'rejectedByZone',
            'financialSummary',
            'committeeMembers'
        );
        $viewData['startDate'] = $startDate->toDateString(); // "2023-07-01"
        $viewData['endDate']   = $endDate->toDateString();   // "2026-03-17"

        // ---- Normal web view ----
        if ($request->query('format') !== 'pdf' && ! $request->boolean('download')) {
            return view('admin.reports.financial_graph_report', $viewData + ['renderForPdf' => false]);
        }

        // Build display-formatted dates only for the PDF blade
        $pdfViewData = $viewData;
        $pdfViewData['startDate'] = '1st ' . $startDate->format('M') . "'" . $startDate->format('Y');
        $pdfViewData['endDate']   = $endDate->day . $endDate->format('S') . ' ' . $endDate->format('M') . "'" . $endDate->format('y');

        // ---- PDF via mPDF ----
        $html = view('admin.reports.financial_graph_report_pdf', $pdfViewData)->render();

        $mpdf = new Mpdf([
            'mode'              => 'utf-8',
            'format'            => 'A4',
            'margin_top'        => 10,
            'margin_right'      => 10,
            'margin_bottom'     => 10,
            'margin_left'       => 10,
            'default_font_size' => 10,
            'default_font'      => 'dejavusans',
            'tempDir'           => storage_path('app/mpdf_tmp'),
        ]);

        $mpdf->SetTitle('JITO JEAP Graphwise Report');
        $mpdf->WriteHTML($html);

        $fileName = 'GRAPHWISE_DETAILS_REPORT_'
            . $startDate->format('Ymd') . '_to_' . $endDate->format('Ymd') . '.pdf';

        return response()->streamDownload(function () use ($mpdf) {
            echo $mpdf->Output('', 'S');
        }, $fileName, ['Content-Type' => 'application/pdf']);
    }


    protected function resolveCourseType($education): string
    {
        $qual = strtolower((string) ($education->qualifications ?? ''));
        if (in_array($qual, ['masters', 'phd'], true)) {
            return 'PG';
        }
        if (in_array($qual, ['graduation', 'diploma'], true)) {
            return 'UG';
        }
        return 'UG';
    }

    protected function resolveFaType($education): string
    {
        $country = strtolower(trim((string) ($education->country ?? '')));
        if ($country && !in_array($country, ['india', 'in', 'bharat'], true)) {
            return 'Foreign';
        }
        return 'Domestic';
    }

    /**
     * Files Report - Student loan workflow status report
     */
    public function filesReport(Request $request)
    {
        $fromDate = $request->input('from_date') ? Carbon::parse($request->input('from_date'))->startOfDay() : null;
        $toDate = $request->input('to_date') ? Carbon::parse($request->input('to_date'))->endOfDay() : null;

        // Base query for users with role 'user'
        $baseQuery = User::where('role', 'user');

        // 1. STUDENTS FILES NOT RECEIVED:
        // Working committee approved but PDC details NOT submitted
        $filesNotReceivedQuery = clone $baseQuery;
        $filesNotReceivedQuery->whereHas('workflowStatus', function ($q) {
            $q->where('working_committee_status', 'approved');
        })->whereDoesntHave('pdcDetail', function ($q) {
            $q->whereIn('status', ['submitted', 'approved']);
        });

        if ($fromDate && $toDate) {
            $filesNotReceivedQuery->whereBetween('created_at', [$fromDate, $toDate]);
        } elseif ($fromDate) {
            $filesNotReceivedQuery->where('created_at', '>=', $fromDate);
        } elseif ($toDate) {
            $filesNotReceivedQuery->where('created_at', '<=', $toDate);
        }

        $filesNotReceivedCount = $filesNotReceivedQuery->count();
        $filesNotReceivedAmount = (clone $filesNotReceivedQuery)->get()->sum(function ($user) {
            return $user->workingCommitteeApproval->approval_financial_assistance_amount ?? 0;
        });

        // 2. STUDENTS FILES RECEIVED BUT CHEQUES / DOCUMENT PENDING:
        // PDC submitted and courier received, but documents incomplete or not approved
        $filesPendingQuery = clone $baseQuery;
        $filesPendingQuery->whereHas('pdcDetail', function ($q) {
            $q->whereIn('status', ['submitted'])
                ->where('courier_receive_status', 'approved');
        })->whereDoesntHave('pdcDetail', function ($q) {
            $q->where('status', 'approved');
        });

        if ($fromDate && $toDate) {
            $filesPendingQuery->whereBetween('created_at', [$fromDate, $toDate]);
        } elseif ($fromDate) {
            $filesPendingQuery->where('created_at', '>=', $fromDate);
        } elseif ($toDate) {
            $filesPendingQuery->where('created_at', '<=', $toDate);
        }

        $filesPendingCount = $filesPendingQuery->count();
        $filesPendingAmount = (clone $filesPendingQuery)->get()->sum(function ($user) {
            return $user->workingCommitteeApproval->approval_financial_assistance_amount ?? 0;
        });

        // 3. FILES CHECKING PENDING:
        // PDC submitted and courier received, but under checking (not approved)
        $filesCheckingQuery = clone $baseQuery;
        $filesCheckingQuery->whereHas('pdcDetail', function ($q) {
            $q->where('status', 'submitted')
                ->where('courier_receive_status', 'approved');
        });

        if ($fromDate && $toDate) {
            $filesCheckingQuery->whereBetween('created_at', [$fromDate, $toDate]);
        } elseif ($fromDate) {
            $filesCheckingQuery->where('created_at', '>=', $fromDate);
        } elseif ($toDate) {
            $filesCheckingQuery->where('created_at', '<=', $toDate);
        }

        $filesCheckingCount = $filesCheckingQuery->count();
        $filesCheckingAmount = (clone $filesCheckingQuery)->get()->sum(function ($user) {
            return $user->workingCommitteeApproval->approval_financial_assistance_amount ?? 0;
        });

        // 4. DISBURSEMENT IN QUE (FRESH / FOREIGN / MULTIPLE):
        // PDC and courier documents approved and ready for disbursement
        // Filter based on disbursement_schedules.planned_date
        $disbursementInQueQuery = clone $baseQuery;
        $disbursementInQueQuery->whereHas('pdcDetail', function ($q) {
            $q->where('status', 'approved')
                ->where('courier_receive_status', 'approved');
        });

        // Get user IDs from the base query first
        $disbursementInQueUserIds = (clone $disbursementInQueQuery)->pluck('id')->toArray();

        // Apply disbursement schedule date filter if dates are provided
        if ($fromDate || $toDate) {
            $scheduleQuery = DB::connection('admin_panel')->table('disbursement_schedules')
                ->where('installment_no', 1);

            if ($fromDate && $toDate) {
                $scheduleQuery->whereBetween('planned_date', [$fromDate, $toDate]);
            } elseif ($fromDate) {
                $scheduleQuery->where('planned_date', '>=', $fromDate);
            } elseif ($toDate) {
                $scheduleQuery->where('planned_date', '<=', $toDate);
            }

            $scheduledUserIds = $scheduleQuery->pluck('user_id')->toArray();
            $disbursementInQueUserIds = array_intersect($disbursementInQueUserIds, $scheduledUserIds);
        }

        $disbursementInQueCount = count($disbursementInQueUserIds);

        // Calculate amount as sum of first disbursement (installment_no = 1) from disbursement_schedules
        $disbursementInQueAmount = 0;
        if (!empty($disbursementInQueUserIds)) {
            $disbursementAmountQuery = DB::connection('admin_panel')->table('disbursement_schedules')
                ->whereIn('user_id', $disbursementInQueUserIds)
                ->where('installment_no', 1);

            // Apply date filter to the amount query as well
            if ($fromDate && $toDate) {
                $disbursementAmountQuery->whereBetween('planned_date', [$fromDate, $toDate]);
            } elseif ($fromDate) {
                $disbursementAmountQuery->where('planned_date', '>=', $fromDate);
            } elseif ($toDate) {
                $disbursementAmountQuery->where('planned_date', '<=', $toDate);
            }

            $disbursementInQueAmount = $disbursementAmountQuery->sum('planned_amount');
        }

        // 5. NO. OF STUDENTS REPAYMENT COMPLETED:
        // Students who have repayments and all repayments have payment_date (meaning completed)
        // First get all user_ids who have any repayment entries
        $usersWithRepayments = \App\Models\Repayment::on('admin_panel')
            ->whereNotNull('payment_date')
            ->distinct()
            ->pluck('user_id')
            ->toArray();

        // Get users whose all expected repayments are completed
        $repaymentCompletedQuery = clone $baseQuery;
        $repaymentCompletedQuery->whereIn('id', $usersWithRepayments);

        if ($fromDate && $toDate) {
            $repaymentCompletedQuery->whereBetween('created_at', [$fromDate, $toDate]);
        } elseif ($fromDate) {
            $repaymentCompletedQuery->where('created_at', '>=', $fromDate);
        } elseif ($toDate) {
            $repaymentCompletedQuery->where('created_at', '<=', $toDate);
        }

        if ($fromDate) {
            $repaymentCompletedQuery->whereBetween('created_at', [$fromDate, $toDate]);
        }

        $repaymentCompletedCount = $repaymentCompletedQuery->count();

        $reportData = [
            [
                'category' => 'Students Files Not Received',
                'file_count' => $filesNotReceivedCount,
                'amount' => $filesNotReceivedAmount,
            ],
            [
                'category' => 'Students Files Received But Cheques/Document Pending',
                'file_count' => $filesPendingCount,
                'amount' => $filesPendingAmount,
            ],
            [
                'category' => 'Files Checking Pending',
                'file_count' => $filesCheckingCount,
                'amount' => $filesCheckingAmount,
            ],
            [
                'category' => 'Disbursement In Que (Fresh/Foreign/Multiple)',
                'file_count' => $disbursementInQueCount,
                'amount' => $disbursementInQueAmount,
            ],
            [
                'category' => 'No. Of Students Repayment Completed',
                'file_count' => $repaymentCompletedCount,
                'amount' => 0,
            ],
        ];

        // Check if export is requested
        if ($request->input('export') === 'excel') {
            return $this->exportFilesReport($reportData, $fromDate, $toDate);
        }

        return view('admin.files_report', compact('reportData', 'fromDate', 'toDate'));
    }

    /**
     * Export Files Report to Excel
     */
    protected function exportFilesReport($reportData, $fromDate, $toDate)
    {
        $fileName = 'Files_Report_' . date('Y-m-d') . '.xlsx';

        return Excel::download(new class($reportData) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $data;

            public function __construct($data)
            {
                $this->data = $data;
            }

            public function array(): array
            {
                return array_map(function ($row) {
                    return [
                        $row['category'],
                        $row['file_count'],
                        $row['amount'],
                    ];
                }, $this->data);
            }

            public function headings(): array
            {
                return ['Category', 'File Count', 'Amount'];
            }
        }, $fileName);
    }
}
