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

    protected function getUserFieldAlias(string $field): ?string
    {
        // Keep report field keys stable, map to actual DB columns.
        return [
            'mobile' => 'phone',
            'application_number' => 'application_no',
            'date_of_birth' => 'd_o_b',
            'sub_caste' => 'sub_cast',
            'aadhaar_number' => 'aadhar_card_number',
            'pan_number' => 'pan_card',
            'pincode' => 'pin_code',
            // `address` is handled via a computed resolver.
            // `caste` is not present in current schema; handled via fallbacks.
            'application_status' => 'submit_status',
        ][$field] ?? null;
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
                if ($field === 'workflow.assistance_amount') {
                    $relationships[] = 'workingCommitteeApproval';
                }
            } elseif (strpos($field, 'pdc.') === 0) {
                $relationships[] = 'pdcDetail';
            } elseif (strpos($field, 'approval.') === 0) {
                $relationships[] = 'workingCommitteeApproval';
            } elseif (strpos($field, 'chapter.') === 0) {
                $relationships[] = 'chapterMaster';
                $relationships[] = 'chapterMaster.zone';
            } elseif ($field === 'funding.loan_category') {
                $relationships[] = 'loanCategory';
            }
        }

        return array_unique($relationships);
    }

    protected function resolveFamilyColumnAlias(string $column): string
    {
        return [
            'father_annual_income' => 'father_yearly_gross_income',
            'mother_annual_income' => 'mother_yearly_gross_income',
            'total_family_members' => 'number_family_members',
            'annual_family_income' => 'total_family_income',
        ][$column] ?? $column;
    }

    protected function resolveEducationColumnAlias(string $column): string
    {
        return [
            // UI key => best-fit column in schema
            'course_type' => 'qualifications',
            'institution_name' => 'college_name',
            'course_duration' => 'duration',
        ][$column] ?? $column;
    }

    protected function resolveFundingColumnAlias(string $column): string
    {
        return [
            'loan_amount_requested' => 'tuition_fees_amount',
            'funds_arranged' => 'total_funding_amount',
        ][$column] ?? $column;
    }

    protected function resolveWorkflowColumnAlias(string $column): string
    {
        return [
            'stage' => 'current_stage',
            // `status` is computed based on current stage.
        ][$column] ?? $column;
    }

    protected function resolvePdcColumnAlias(string $column): string
    {
        return [
            'courier_receive_date' => 'courier_received_date',
        ][$column] ?? $column;
    }

    protected function resolveApprovalColumnAlias(string $column): string
    {
        return [
            'approved_amount' => 'approval_financial_assistance_amount',
        ][$column] ?? $column;
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
                    if ($relation === 'family') {
                        $column = $this->resolveFamilyColumnAlias($column);
                    } elseif ($relation === 'education') {
                        $column = $this->resolveEducationColumnAlias($column);
                    } elseif ($relation === 'funding') {
                        $column = $this->resolveFundingColumnAlias($column);
                    } elseif ($relation === 'workflow') {
                        $column = $this->resolveWorkflowColumnAlias($column);
                    } elseif ($relation === 'pdc') {
                        $column = $this->resolvePdcColumnAlias($column);
                    } elseif ($relation === 'approval') {
                        $column = $this->resolveApprovalColumnAlias($column);
                    }

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
                $aliased = $this->getUserFieldAlias($field);
                if ($aliased) {
                    $field = $aliased;
                }
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
            $headings[] = $fieldLabels[$field] ?? $this->humanizeFieldHeading($field);
        }

        return $headings;
    }

    protected function humanizeFieldHeading(string $field): string
    {
        $parts = explode('.', $field, 2);
        if (count($parts) === 2) {
            return $this->titleize($parts[0]) . ' ' . $this->titleize($parts[1]);
        }
        return $this->titleize($field);
    }

    protected function titleize(string $value): string
    {
        $value = str_replace(['_', '-'], ' ', trim($value));
        $value = preg_replace('/\s+/', ' ', $value);
        return ucwords($value);
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
            'pdc.courier_received_by' => 'Courier Received By',
            'pdc.courier_receive_processed_at' => 'Courier Processed At',
            'pdc.status' => 'PDC Status',
            'pdc.first_cheque_image' => 'First Cheque Image',
            'pdc.admin_approve_remark' => 'PDC Approve Remark',
            'pdc.admin_reject_remark' => 'PDC Reject Remark',

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
        // Direct user-field aliases / computed fields
        if (strpos($field, '.') === false) {
            $alias = $this->getUserFieldAlias($field);
            if ($alias) {
                return $this->formatValue($user->{$alias});
            }

            if ($field === 'address') {
                $address =
                    $user->current_address
                    ?? $user->address
                    ?? $user->aadhar_address
                    ?? $user->address1
                    ?? null;

                if (!$address) {
                    $parts = array_filter([
                        $user->flat_no ?? null,
                        $user->building_no ?? null,
                        $user->street_name ?? null,
                        $user->area ?? null,
                        $user->landmark ?? null,
                    ]);
                    $address = !empty($parts) ? implode(', ', $parts) : null;
                }

                return $this->formatValue($address);
            }

            if ($field === 'caste') {
                // Current schema does not store a distinct caste field; best-effort fallback.
                return $this->formatValue($user->caste ?? $user->cast ?? $user->sub_cast ?? null);
            }

            return $this->formatValue($user->{$field});
        }

        // Handle relationship fields
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
                'chapter' => 'chapterMaster',
            ];

        if (!isset($relationMap[$relation])) {
            return '';
        }

        if ($relation === 'workflow' && $column === 'status') {
            $workflow = $user->workflowStatus;
            if (!$workflow) {
                return '';
            }
            $stage = $workflow->current_stage ?? null;
            if (!$stage) {
                return '';
            }
            $stageStatusColumn = $stage . '_status';
            return $this->formatValue($workflow->{$stageStatusColumn} ?? null);
        }

        if ($relation === 'workflow' && $column === 'assistance_amount') {
            $approval = $user->workingCommitteeApproval;
            return $this->formatValue($approval?->approval_financial_assistance_amount);
        }

        if ($relation === 'education') {
            $education = $user->educationDetail;
            if (!$education) {
                return '';
            }

            if ($column === 'tuition_fee') {
                $total =
                    $education->group_1_total
                    ?? $education->tuition_fee_total
                    ?? $this->sumNumbers([
                        $education->group_1_year1 ?? null,
                        $education->group_1_year2 ?? null,
                        $education->group_1_year3 ?? null,
                        $education->group_1_year4 ?? null,
                        $education->group_1_year5 ?? null,
                        $education->tuition_fee_year1 ?? null,
                        $education->tuition_fee_year2 ?? null,
                        $education->tuition_fee_year3 ?? null,
                        $education->tuition_fee_year4 ?? null,
                        $education->tuition_fee_year5 ?? null,
                    ]);

                return $this->formatValue($total);
            }

            if ($column === 'hostel_fee') {
                $total =
                    $education->group_2_total
                    ?? $this->sumNumbers([
                        $education->group_2_year1 ?? null,
                        $education->group_2_year2 ?? null,
                        $education->group_2_year3 ?? null,
                        $education->group_2_year4 ?? null,
                        $education->group_2_year5 ?? null,
                    ]);

                return $this->formatValue($total);
            }

            if ($column === 'other_fee') {
                // Report label is "Total Fee" for this key.
                $total = $this->sumNumbers([
                    $education->group_1_total ?? $education->tuition_fee_total ?? null,
                    $education->group_2_total ?? null,
                    $education->group_3_total ?? null,
                    $education->group_4_total ?? null,
                ]);

                if (!$total) {
                    $total = $this->sumNumbers([
                        $education->group_1_year1 ?? null,
                        $education->group_1_year2 ?? null,
                        $education->group_1_year3 ?? null,
                        $education->group_1_year4 ?? null,
                        $education->group_1_year5 ?? null,
                        $education->tuition_fee_year1 ?? null,
                        $education->tuition_fee_year2 ?? null,
                        $education->tuition_fee_year3 ?? null,
                        $education->tuition_fee_year4 ?? null,
                        $education->tuition_fee_year5 ?? null,
                        $education->group_2_year1 ?? null,
                        $education->group_2_year2 ?? null,
                        $education->group_2_year3 ?? null,
                        $education->group_2_year4 ?? null,
                        $education->group_2_year5 ?? null,
                        $education->group_3_year1 ?? null,
                        $education->group_3_year2 ?? null,
                        $education->group_3_year3 ?? null,
                        $education->group_3_year4 ?? null,
                        $education->group_3_year5 ?? null,
                        $education->group_4_year1 ?? null,
                        $education->group_4_year2 ?? null,
                        $education->group_4_year3 ?? null,
                        $education->group_4_year4 ?? null,
                        $education->group_4_year5 ?? null,
                    ]);
                }

                return $this->formatValue($total);
            }

            if ($column === 'sgpa') {
                // Best effort: use JSON cgpa/sgpa arrays if present, else school/jc sgpa.
                $value = $education->sgpa
                    ?? $education->cgpa
                    ?? $education->jc_sgpa
                    ?? $education->school_sgpa
                    ?? null;

                return $this->formatValue($value);
            }

            if ($column === 'percentage') {
                // Stored as JSON array in schema (`percentage`).
                return $this->formatValue($education->percentage ?? null);
            }

            $column = $this->resolveEducationColumnAlias($column);
            return $this->formatValue($education->{$column} ?? null);
        }

        if ($relation === 'funding' && $column === 'loan_category') {
            return $this->formatValue($user->loanCategory?->type);
        }

        if ($relation === 'funding' && $column === 'funds_source') {
            $funding = $user->fundingDetail;
            if (!$funding) {
                return '';
            }

            $sources = [];
            $this->addFundingSource($sources, 'Family', $funding->family_funding_trust ?? null, $funding->family_funding_amount ?? null);
            $this->addFundingSource($sources, 'Bank Loan', $funding->bank_loan_trust ?? null, $funding->bank_loan_amount ?? null);
            $this->addFundingSource($sources, 'Other 1', $funding->other_assistance1_trust ?? null, $funding->other_assistance1_amount ?? null);
            $this->addFundingSource($sources, 'Other 2', $funding->other_assistance2_trust ?? null, $funding->other_assistance2_amount ?? null);
            $this->addFundingSource($sources, 'Local', $funding->local_assistance_trust ?? null, $funding->local_assistance_amount ?? null);

            if (empty($sources) && !empty($funding->funding_details)) {
                return $this->formatValue($funding->funding_details);
            }

            return $this->formatValue(implode(' | ', $sources));
        }

        if ($relation === 'approval') {
            $approval = $user->workingCommitteeApproval;
            if (!$approval) {
                return '';
            }
            $column = $this->resolveApprovalColumnAlias($column);
            return $this->formatValue($approval->{$column} ?? null);
        }

        if ($relation === 'pdc') {
            $pdc = $user->pdcDetail;
            if (!$pdc) {
                return '';
            }
            $column = $this->resolvePdcColumnAlias($column);

            if ($column === 'cheque_details') {
                return $this->formatChequeDetails($pdc->cheque_details ?? null);
            }
            if ($column === 'courier_receive_verified_documents') {
                return $this->formatList($pdc->courier_receive_verified_documents ?? null);
            }

            return $this->formatValue($pdc->{$column} ?? null);
        }

        if ($relation === 'family') {
            $family = $user->familyDetail;
            if (!$family) {
                return '';
            }
            $column = $this->resolveFamilyColumnAlias($column);
            return $this->formatValue($family->{$column} ?? null);
        }

        if ($relation === 'workflow') {
            $workflow = $user->workflowStatus;
            if (!$workflow) {
                return '';
            }
            $column = $this->resolveWorkflowColumnAlias($column);
            return $this->formatValue($workflow->{$column} ?? null);
        }

        if ($relation === 'funding') {
            $funding = $user->fundingDetail;
            if (!$funding) {
                return '';
            }
            $column = $this->resolveFundingColumnAlias($column);
            return $this->formatValue($funding->{$column} ?? null);
        }

        if ($relation === 'chapter') {
            $chapter = $user->chapterMaster;
            if (!$chapter) {
                // fall back to user's own columns if chapter master is missing
                if ($column === 'name') {
                    return $this->formatValue($user->chapter ?? null);
                }
                if ($column === 'zone') {
                    return $this->formatValue($user->zone ?? null);
                }
                return '';
            }
            if ($column === 'name') {
                return $this->formatValue($chapter->chapter_name ?? null);
            }
            if ($column === 'zone') {
                return $this->formatValue($chapter->zone?->zone_name ?? $user->zone ?? null);
            }
            return $this->formatValue($chapter->{$column} ?? null);
        }

        $related = $user->{$relationMap[$relation]};
        if (!$related) {
            return '';
        }
        return $this->formatValue($related->{$column} ?? null);
    }

    protected function sumNumbers(array $values): ?float
    {
        $sum = 0.0;
        $count = 0;
        foreach ($values as $value) {
            if ($value === null || $value === '') {
                continue;
            }
            if (is_numeric($value)) {
                $sum += (float) $value;
                $count++;
            }
        }
        return $count > 0 ? $sum : null;
    }

    protected function addFundingSource(array &$sources, string $label, $trust, $amount): void
    {
        $trust = is_string($trust) ? trim($trust) : $trust;
        $amountStr = (is_numeric($amount) && (float) $amount > 0) ? number_format((float) $amount, 2) : null;

        if ($trust || $amountStr) {
            $name = $trust ?: $label;
            $sources[] = $amountStr ? ($label . ': ' . $name . ' (' . $amountStr . ')') : ($label . ': ' . $name);
        }
    }

    protected function formatList($value): string
    {
        if ($value === null || $value === '') {
            return '';
        }
        if (is_string($value)) {
            $trimmed = trim($value);
            if ($trimmed !== '' && ($trimmed[0] === '[' || $trimmed[0] === '{')) {
                $decoded = json_decode($trimmed, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $value = $decoded;
                }
            }
        }
        if (!is_array($value)) {
            return $this->formatValue($value);
        }
        $items = [];
        foreach ($value as $v) {
            if ($v === null || $v === '') {
                continue;
            }
            if (is_scalar($v)) {
                $items[] = (string) $v;
                continue;
            }
            $items[] = (string) json_encode($v, JSON_UNESCAPED_UNICODE);
        }
        return implode(', ', $items);
    }

    protected function formatChequeDetails($chequeDetails): string
    {
        if ($chequeDetails === null || $chequeDetails === '') {
            return '';
        }

        if (is_string($chequeDetails)) {
            $trimmed = trim($chequeDetails);
            if ($trimmed !== '' && ($trimmed[0] === '[' || $trimmed[0] === '{')) {
                $decoded = json_decode($trimmed, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $chequeDetails = $decoded;
                }
            }
        }

        if (!is_array($chequeDetails)) {
            return $this->formatValue($chequeDetails);
        }

        $rows = [];
        foreach ($chequeDetails as $idx => $row) {
            if (!is_array($row)) {
                $rows[] = 'Row ' . ($idx + 1) . ': ' . $this->formatValue($row);
                continue;
            }

            $rowNo = $row['row_number'] ?? ($idx + 1);
            $parts = array_filter([
                $this->kv('Name', $row['parents_jnt_ac_name'] ?? null),
                $this->kv('Cheque No', $row['cheque_number'] ?? null),
                $this->kv('Date', $row['cheque_date'] ?? null),
                $this->kv('Amount', $row['amount'] ?? null),
                $this->kv('Bank', $row['bank_name'] ?? null),
                $this->kv('IFSC', $row['ifsc'] ?? null),
                $this->kv('Account', $row['account_number'] ?? null),
            ]);

            $rows[] = 'Row ' . $rowNo . ': ' . implode('; ', $parts);
        }

        // New lines render nicely in Excel cells.
        return implode("\n", $rows);
    }

    protected function kv(string $label, $value): ?string
    {
        $value = $this->formatValue($value);
        if ($value === '') {
            return null;
        }
        return $label . '=' . $value;
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

        // Arrays / JSON
        if (is_array($value)) {
            // If it contains nested arrays/objects, encode to JSON to avoid "Array to string conversion".
            foreach ($value as $v) {
                if (is_array($v) || is_object($v)) {
                    return (string) json_encode($value, JSON_UNESCAPED_UNICODE);
                }
            }

            $flat = array_map(function ($v) {
                if ($v instanceof \DateTime || $v instanceof \Carbon\Carbon) {
                    return $v->format('d-m-Y');
                }
                return (string) $v;
            }, $value);
            $flat = array_filter($flat, fn($v) => $v !== '');
            return implode(', ', $flat);
        }

        // Objects (stdClass, collections, etc.)
        if (is_object($value)) {
            if ($value instanceof \DateTime || $value instanceof \Carbon\Carbon) {
                return $value->format('d-m-Y');
            }
            if ($value instanceof \JsonSerializable) {
                return (string) json_encode($value, JSON_UNESCAPED_UNICODE);
            }
            if (method_exists($value, 'toArray')) {
                return (string) json_encode($value->toArray(), JSON_UNESCAPED_UNICODE);
            }
            if (method_exists($value, '__toString')) {
                return (string) $value;
            }
            return (string) json_encode($value, JSON_UNESCAPED_UNICODE);
        }

        if (is_string($value)) {
            $trimmed = trim($value);
            if ($trimmed !== '' && ($trimmed[0] === '[' || $trimmed[0] === '{')) {
                $decoded = json_decode($trimmed, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    return $this->formatValue($decoded);
                }
            }
        }

        return (string) $value;
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        $columnCount = count($this->selectedFields);
        $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(
            max(1, $columnCount)
        );

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
        for ($i = 1; $i <= $columnCount; $i++) {
            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i);
            $sheet->getColumnDimension($col)->setAutoSize(true);
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
