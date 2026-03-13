<?php

namespace App\Http\Controllers;

use App\Exports\JeapDisbursementReportExport;
use App\Exports\DynamicReportExport;
use App\Models\ReportTemplate;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            ],
            'Funding Details' => [
                'funding.loan_amount_requested' => 'Loan Amount Requested',
                'funding.loan_category' => 'Loan Category',
                'funding.funds_arranged' => 'Funds Arranged',
                'funding.funds_source' => 'Funds Source',
                'funding.scholarship_amount' => 'Scholarship Amount',
            ],
            'Workflow Status' => [
                'workflow.stage' => 'Current Stage',
                'workflow.status' => 'Workflow Status',
                'workflow.final_status' => 'Final Status',
                'workflow.assistance_amount' => 'Assistance Amount',
            ],
            'PDC Details' => [
                'pdc.courier_receive_status' => 'Courier Receive Status',
                'pdc.courier_receive_date' => 'Courier Receive Date',
                'pdc.courier_receive_hold_remark' => 'Hold Remark',
            ],
            'Approval Details' => [
                'approval.meeting_no' => 'Meeting No',
                'approval.disbursement_system' => 'Disbursement System',
                'approval.approved_amount' => 'Approved Amount',
            ],
            'Chapter Details' => [
                'chapter.name' => 'Chapter Name',
                'chapter.zone' => 'Zone',
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
}
