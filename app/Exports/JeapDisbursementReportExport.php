<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JeapDisbursementReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $globalSrNo = 0;
    protected $studentSrNo = 0;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::with([
            'workingCommitteeApproval',
            'workflowStatus',
            'pdcDetail'
        ])->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Sr No',
            'Meeting No',
            'Stu. Sr No',
            'File Type',
            'Students Name',
            'Application Number',
            'DISBURSEMENT DATES',
            'AMOUNT',
            'FILE STATUS',
            'DISBURSEMENT STATUS',
            'JEAP REMARKS',
        ];
    }

    /**
     * @param User $user
     * @return array
     */
    public function map($user): array
    {
        $rows = [];
        $approval = $user->workingCommitteeApproval;
        $pdcDetail = $user->pdcDetail;

        // Skip if no approval data
        if (!$approval) {
            return [];
        }

        // Get disbursement system and dates/amounts
        $disbursementSystem = $approval->disbursement_system ?? '';
        $dates = [];
        $amounts = [];

        if ($disbursementSystem === 'yearly') {
            $dates = $approval->yearly_dates ?? [];
            $amounts = $approval->yearly_amounts ?? [];
        } elseif ($disbursementSystem === 'half_yearly') {
            $dates = $approval->half_yearly_dates ?? [];
            $amounts = $approval->half_yearly_amounts ?? [];
        }

        // Skip if no installments
        if (empty($dates) || empty($amounts)) {
            return [];
        }

        // Increment student serial number
        $this->studentSrNo++;

        // Get file status and remarks from pdc_details
        $fileStatus = $pdcDetail->courier_receive_status ?? '';
        $remarks = '';

        // If status is hold, show hold remark in JEAP REMARKS column
        if (strtolower($fileStatus) === 'hold') {
            $remarks = $pdcDetail->courier_receive_hold_remark ?? '';
        }

        // Generate rows for each installment
        foreach ($dates as $index => $date) {
            $this->globalSrNo++;

            // Determine file type
            $fileType = ($index === 0) ? 'Fresh' : 'Multiple';

            // Determine student serial number (only show on first row)
            $studentSrNoDisplay = ($index === 0) ? $this->studentSrNo : '';

            // Get amount
            $amount = $amounts[$index] ?? 0;

            // Format amount
            $formattedAmount = number_format($amount);

            // Format date
            $formattedDate = '';
            if (!empty($date)) {
                try {
                    $formattedDate = \Carbon\Carbon::parse($date)->format('d-m-Y');
                } catch (\Exception $e) {
                    $formattedDate = $date;
                }
            }

            // Determine disbursement status
            $disbursementStatus = $this->getDisbursementStatus($fileStatus, $date);

            $rows[] = [
                $this->globalSrNo,
                $approval->meeting_no ?? '',
                $studentSrNoDisplay,
                $fileType,
                $user->name ?? '',
                $user->application_number ?? '',
                $formattedDate,
                $formattedAmount,
                $fileStatus,
                $disbursementStatus,
                $remarks,
            ];
        }

        return $rows;
    }

    /**
     * Determine disbursement status based on file status and date
     *
     * @param string $fileStatus
     * @param string $date
     * @return string
     */
    protected function getDisbursementStatus($fileStatus, $date): string
    {
        // Check if file status is hold or physical file pending
        if (strtolower($fileStatus) === 'hold' || $fileStatus === 'PHYSICAL FILE PENDING') {
            return 'HOLD';
        }

        if (empty($date)) {
            return 'FUTURE';
        }

        try {
            $disbursementDate = \Carbon\Carbon::parse($date);
            $today = \Carbon\Carbon::today();

            if ($disbursementDate->lte($today)) {
                return 'PAID';
            }
        } catch (\Exception $e) {
            // If date parsing fails, return FUTURE
        }

        return 'FUTURE';
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        // Style the header row
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'FFFF00', // Yellow background
                ],
            ],
        ]);

        // Auto-size columns
        foreach (range('A', 'K') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Optional: Alternate row coloring
        $highestRow = $sheet->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) {
            if ($row % 2 == 0) {
                $sheet->getStyle('A' . $row . ':K' . $row)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'F0F0F0', // Light gray for even rows
                        ],
                    ],
                ]);
            }
        }
    }
}