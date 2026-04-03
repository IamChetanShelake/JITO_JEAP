<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Third Stage Documents</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            background-color: #ffffff;
            color: #111;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header img {
            height: 60px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .header h2 {
            margin: 2px 0;
            font-size: 14px;
            letter-spacing: 0.5px;
        }

        .section {
            margin: 15px 0;
            page-break-inside: avoid;
        }

        .section h2 {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 8px;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 11px;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        table th {
            background-color: #f2f2f2;
            font-weight: bold;
            width: 25%;
        }

        .checklist {
            margin: 0;
            padding-left: 18px;
        }

        .checklist li {
            margin-bottom: 6px;
        }

        .upload-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 8px;
        }

        .upload-card {
            border: 1px solid #000;
            padding: 8px;
            min-height: 50px;
        }

        .small-label {
            font-size: 10px;
            color: #555;
        }

        .signature-block {
            margin-top: 20px;
            text-align: center;
            border-top: 1px dashed #000;
            padding-top: 12px;
        }

        .signature-block p {
            margin: 2px 0;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    @php
        $domesticMarksheets = $thirdStageDocument->domestic_marksheets ?? [];
        $additionalDocuments = $thirdStageDocument->documents ?? [];
        $hasDomesticMarksheets = !empty($domesticMarksheets);
        $approvedAmount = $workingCommitteeApproval->approval_financial_assistance_amount ?? 0;
        $workingCommitteeDate = optional($workingCommitteeApproval->w_c_approval_date)->format('d/m/Y');
    @endphp

    <div class="header">
        <img src="/home/jitojeap/public_html/jitojeaplogo.png" alt="JITO JEAP Logo">
        <h1>JITO EDUCATION ASSISTANCE PROGRAM</h1>
        <h2>THIRD STAGE DOCUMENTS REPORT</h2>
        <p><strong>{{ strtoupper($user->financial_asset_type === 'foreign_finance_assistant' ? 'FOREIGN SECOND DISBURSEMENT' : 'DOMESTIC') }}</strong>
        </p>
    </div>

    <div class="section">
        <h2>Student Snapshot</h2>
        <table>
            <tr>
                <th>Student Name</th>
                <td>{{ $user->name }}</td>
                <th>Student Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Application #</th>
                <td>{{ str_pad($user->application_no ?? $user->id, 4, '0', STR_PAD_LEFT) }}</td>
                <th>Phone</th>
                <td>{{ $user->phone ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Chapter</th>
                <td>{{ $user->chapter ?? 'N/A' }}</td>
                <th>Third Stage Approved</th>
                <td>{{ optional($thirdStageDocument->approved_at)->format('d/m/Y H:i') ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td colspan="3">
                    {{ trim(
                        implode(
                            ' ',
                            array_filter([
                                $user->flat_no,
                                $user->building_no,
                                $user->street_name,
                                $user->area,
                                $user->landmark,
                                $user->city,
                                $user->state,
                                $user->pin_code ? 'PIN ' . $user->pin_code : null,
                            ]),
                        ),
                    ) ?:
                        'N/A' }}
                </td>
            </tr>
        </table>
    </div>

    @if ($user->financial_asset_type === 'foreign_finance_assistant')
        <div class="section">
            <h2>Foreign Finance Assistant Details</h2>
            <ol class="checklist">
                <li><strong>Student Name:</strong> {{ $user->name }}</li>
                <li><strong>Student Mail ID:</strong> {{ $user->email }}</li>
                <li><strong>Applicant New Address (Overseas):</strong>
                    {{ $thirdStageDocument->foreign_address ?? 'N/A' }}</li>
                <li><strong>Foreign Contact Number:</strong> {{ $thirdStageDocument->foreign_contact_number ?? 'N/A' }}
                </li>
                <li><strong>SSN / Country ID Details:</strong>
                    {{ $thirdStageDocument->foreign_ssn_or_country_id ?? 'N/A' }}</li>
                <li><strong>Immigration Copy:</strong>
                    {{ $thirdStageDocument->foreign_immigration_copy ? 'Uploaded and Approved' : 'Not provided' }}
                </li>
                <li><strong>Paid Fees Receipt:</strong>
                    {{ $thirdStageDocument->foreign_paid_fees_receipt ? 'Uploaded and Approved' : 'Not provided' }}
                </li>
                <li><strong>Foreign Bank Account Name:</strong> {{ $thirdStageDocument->foreign_bank_name ?? 'N/A' }}
                </li>
                <li><strong>Foreign Bank Account Number:</strong>
                    {{ $thirdStageDocument->foreign_bank_account_number ?? 'N/A' }}</li>
                <li><strong>Working Committee Approved Amount:</strong>
                    Rs. {{ number_format($approvedAmount ?? 0, 2) }}
                </li>
                <li><strong>First Disbursed Amount:</strong>
                    Rs. {{ number_format($firstDisbursementAmount ?? 0, 2) }}
                </li>
                <li><strong>Second Disbursed Amount:</strong>
                    Rs. {{ number_format($secondDisbursementAmount ?? 0, 2) }}
                </li>
            </ol>
            <p class="small-label">Working Committee Approval Date: {{ $workingCommitteeDate ?? 'N/A' }}</p>
        </div>
    @else
        <div class="section">
            <h2>Domestic Checklist</h2>
            <ol class="checklist">
                <li><strong>Student Name:</strong> {{ $user->name }}</li>
                <li><strong>Student Mail ID:</strong> {{ $user->email }}</li>
                <li><strong>Applicant Address:</strong>
                    {{ $thirdStageDocument->documents['applicant_address'] ?? 'N/A' }}
                </li>
                <li><strong>Contact Number:</strong> {{ $user->phone ?? 'N/A' }}</li>
                <li><strong>Domestic Marksheets:</strong>
                    {{ $hasDomesticMarksheets ? 'Uploaded and Approved' : 'Not submitted' }}
                </li>
                <li><strong>Paid Fees Receipt:</strong>
                    {{ $thirdStageDocument->domestic_paid_fees_receipt ? 'Uploaded and Approved' : 'Not provided' }}
                </li>
                <li><strong>Cancelled Cheque:</strong>
                    {{ $thirdStageDocument->domestic_cancelled_cheque ? 'Uploaded and Approved' : 'Not provided' }}
                </li>
                <li><strong>Working Committee Approved Amount:</strong>
                    Rs. {{ number_format($approvedAmount ?? 0, 2) }}
                </li>
                <li><strong>First Disbursed Amount:</strong>
                    Rs. {{ number_format($firstDisbursementAmount ?? 0, 2) }}
                </li>
                <li><strong>Second Disbursed Amount:</strong>
                    Rs. {{ number_format($secondDisbursementAmount ?? 0, 2) }}
                </li>
            </ol>
            <p class="small-label">Working Committee Approval Date: {{ $workingCommitteeDate ?? 'N/A' }}</p>
        </div>
    @endif


    <div class="section">
        <h2>Disbursement Summary</h2>
        <table>
            <tr>
                <th>Financial Assistance Approved</th>
                <td>Rs. {{ number_format($approvedAmount ?? 0, 2) }}</td>
            </tr>
            <tr>
                <th>First Disbursed Amount</th>
                <td>Rs. {{ number_format($firstDisbursementAmount ?? 0, 2) }}</td>
            </tr>
            <tr>
                <th>Second Disbursed Amount</th>
                <td>Rs. {{ number_format($secondDisbursementAmount ?? 0, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="signature-block">
        <p>Signature:_____________________________________________________</p>
        <p>JITO EDUCATION ASSISTANCE PROGRAM</p>
        <p>
            THIRD STAGE DOCUMENTS DETAILS FOR
            {{ $user->financial_asset_type === 'foreign_finance_assistant' ? 'FOREIGN SECOND DISBURSEMENT' : 'DOMESTIC DISBURSEMENT' }}
        </p>
    </div>
</body>

</html>
