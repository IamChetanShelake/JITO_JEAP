<?php

namespace App\Http\Controllers;

use App\Exports\JeapDisbursementReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ReportController extends Controller
{
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