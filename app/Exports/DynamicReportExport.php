<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class DynamicReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $selectedFields;
    protected $filters;
    protected $query;

    /**
     * Create a new export instance.
     *
     * @param array $selectedFields
     * @param array $filters
     */
    public function __construct(array $selectedFields, array $filters = [])
    {
        $this->selectedFields = $selectedFields;
        $this->filters = $filters;
        $this->query = $this->buildQuery();
    }

    /**
     * Build the dynamic query based on selected fields and filters.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildQuery()
    {
        $query = User::query();

        // Eager load relationships based on selected fields
        $relationships = $this->getRequiredRelationships();
        if (!empty($relationships)) {
            $query->with($relationships);
        }

        // Apply filters if provided
        if (!empty($this->filters)) {
            $this->applyFilters($query);
        }

        return $query;
    }

    /**
     * Get required relationships based on selected fields.
     *
     * @return array
     */
    protected function getRequiredRelationships(): array
    {
        $relationships = [];

        foreach ($this->selectedFields as $field) {
            if (strpos($field, 'family.') === 0) {
                $relationships[] = 'familyDetail';
            } elseif (strpos($field, 'education.') === 0) {
                $relationships[] = 'educationDetail';
            } elseif (strpos($field, 'funding.') === 0) {
                $relationships[] = 'fundingDetail';
            } elseif (strpos($field, 'guarantor.') === 0) {
                $relationships[] = 'guarantorDetail';
            } elseif (strpos($field, 'workflow.') === 0) {
                $relationships[] = 'workflowStatus';
            } elseif (strpos($field, 'pdc.') === 0) {
                $relationships[] = 'pdcDetail';
            } elseif (strpos($field, 'approval.') === 0) {
                $relationships[] = 'workingCommitteeApproval';
            } elseif (strpos($field, 'chapter.') === 0) {
                $relationships[] = 'chapter';
            }
        }

        return array_unique($relationships);
    }

    /**
     * Apply filters to the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    protected function applyFilters($query): void
    {
        foreach ($this->filters as $filter) {
            $field = $filter['field'] ?? null;
            $operator = $filter['operator'] ?? '=';
            $value = $filter['value'] ?? null;

            if (!$field || $value === null || $value === '') {
                continue;
            }

            // Handle relationship fields
            if (strpos($field, '.') !== false) {
                $parts = explode('.', $field);
                $relation = $parts[0];
                $column = $parts[1];

                $relationMap = [
                    'family' => 'familyDetail',
                    'education' => 'educationDetail',
                    'funding' => 'fundingDetail',
                    'guarantor' => 'guarantorDetail',
                    'workflow' => 'workflowStatus',
                    'pdc' => 'pdcDetail',
                    'approval' => 'workingCommitteeApproval',
                ];

                if (isset($relationMap[$relation])) {
                    $query->whereHas($relationMap[$relation], function ($q) use ($column, $operator, $value) {
                        if ($operator === 'like') {
                            $q->where($column, 'like', '%' . $value . '%');
                        } else {
                            $q->where($column, $operator, $value);
                        }
                    });
                }
            } else {
                // Direct user table fields
                if ($operator === 'like') {
                    $query->where($field, 'like', '%' . $value . '%');
                } else {
                    $query->where($field, $operator, $value);
                }
            }
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $headings = [];
        $fieldLabels = $this->getFieldLabels();

        foreach ($this->selectedFields as $field) {
            $headings[] = $fieldLabels[$field] ?? $field;
        }

        return $headings;
    }

    /**
     * Get human-readable labels for fields.
     *
     * @return array
     */
    protected function getFieldLabels(): array
    {
        return [
            // User fields
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

            // Family fields
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

            // Education fields
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

            // Funding fields
            'funding.loan_amount_requested' => 'Loan Amount Requested',
            'funding.loan_category' => 'Loan Category',
            'funding.funds_arranged' => 'Funds Arranged',
            'funding.funds_source' => 'Funds Source',
            'funding.scholarship_amount' => 'Scholarship Amount',

            // Workflow fields
            'workflow.stage' => 'Current Stage',
            'workflow.status' => 'Workflow Status',
            'workflow.final_status' => 'Final Status',
            'workflow.assistance_amount' => 'Assistance Amount',

            // PDC fields
            'pdc.courier_receive_status' => 'Courier Receive Status',
            'pdc.courier_receive_date' => 'Courier Receive Date',
            'pdc.courier_receive_hold_remark' => 'Hold Remark',

            // Approval fields
            'approval.meeting_no' => 'Meeting No',
            'approval.disbursement_system' => 'Disbursement System',
            'approval.approved_amount' => 'Approved Amount',

            // Chapter fields
            'chapter.name' => 'Chapter Name',
            'chapter.zone' => 'Zone',
        ];
    }

    /**
     * @param User $user
     * @return array
     */
    public function map($user): array
    {
        $row = [];

        foreach ($this->selectedFields as $field) {
            $row[] = $this->getFieldValue($user, $field);
        }

        return $row;
    }

    /**
     * Get the value for a specific field from the user model.
     *
     * @param User $user
     * @param string $field
     * @return mixed
     */
    protected function getFieldValue(User $user, string $field)
    {
        // Handle relationship fields
        if (strpos($field, '.') !== false) {
            $parts = explode('.', $field);
            $relation = $parts[0];
            $column = $parts[1];

            $relationMap = [
                'family' => 'familyDetail',
                'education' => 'educationDetail',
                'funding' => 'fundingDetail',
                'guarantor' => 'guarantorDetail',
                'workflow' => 'workflowStatus',
                'pdc' => 'pdcDetail',
                'approval' => 'workingCommitteeApproval',
                'chapter' => 'chapter',
            ];

            if (isset($relationMap[$relation])) {
                $related = $user->{$relationMap[$relation]};
                if ($related) {
                    return $this->formatValue($related->$column);
                }
            }

            return '';
        }

        // Direct user table fields
        return $this->formatValue($user->$field);
    }

    /**
     * Format a value for display in the report.
     *
     * @param mixed $value
     * @return string
     */
    protected function formatValue($value): string
    {
        if ($value === null || $value === '') {
            return '';
        }

        // Format dates
        if ($value instanceof \DateTime || $value instanceof \Carbon\Carbon) {
            return $value->format('d-m-Y');
        }

        // Format currency
        if (is_numeric($value) && in_array(substr(strrchr(debug_backtrace()[0]['function'], '_'), 1), ['fee', 'amount', 'income'])) {
            return number_format($value, 2);
        }

        return (string) $value;
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        // Get the last column letter based on selected fields count
        $lastColumn = chr(64 + count($this->selectedFields));

        // Style the header row
        $sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '4472C4', // Blue background
                ],
            ],
            'font' => [
                'color' => [
                    'rgb' => 'FFFFFF', // White text
                ],
            ],
        ]);

        // Auto-size columns
        foreach (range('A', $lastColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Alternate row coloring
        $highestRow = $sheet->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) {
            if ($row % 2 == 0) {
                $sheet->getStyle('A' . $row . ':' . $lastColumn . $row)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'F2F2F2', // Light gray for even rows
                        ],
                    ],
                ]);
            }
        }

        // Freeze header row
        $sheet->freezePane('A2');
    }
}