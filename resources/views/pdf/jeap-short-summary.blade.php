<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>JITO JEAP Application Summary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
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
            margin: 8px 0;
            font-size: 10px;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 4px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f5f5f5;
            font-weight: bold;
            font-size: 9px;
        }

        .page-break {
            page-break-before: always;
        }

        .amount-highlight {
            font-weight: bold;
            color: #000;
        }

        .remarks-section {
            margin: 10px 0;
            padding: 8px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <img src="/home/jitojeap/public_html/jitojeaplogo.png" alt="JITO JEAP Logo" style="height: 60px; margin-bottom: 10px;">
        <h1>JITO EDUCATION ASSISTANCE PROGRAM</h1>
        <h2>SUMMARY</h2>
        <p><strong>Application no.: {{ str_pad($user->application_no, 4, '0', STR_PAD_LEFT) }}</strong></p>
    </div>

    <!-- PART[1]: Student Details -->
    <div class="section">
        <h2>PART[1]:- Student Details</h2>
        <table>
            <tr>
                <th width="20%">Course:</th>
                <td width="30%">{{ $educationDetail->course_name ?? 'N/A' }}</td>
                <th width="20%">Religion Details:</th>
                <td width="30%">{{ $user->religion ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $user->name }}</td>
                <th>Contact Nos.</th>
                <td>{{ $user->phone }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
                <th>Birth Date</th>
                <td>{{ $user->d_o_b ? \Carbon\Carbon::parse($user->d_o_b)->format('d/m/Y') : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Native Place</th>
                <td>{{ $user->state }}</td>
                <th>City</th>
                <td>{{ $user->city }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td colspan="3">
                    {{ $user->flat_no }} {{ $user->building_no }} {{ $user->street_name }}
                    {{ $user->area }} {{ $user->landmark }} PIN CODE : {{ $user->pin_code }}
                </td>
            </tr>
        </table>
    </div>

    <!-- PART[2]: Working Committee Details -->
    <div class="section">
        <h2>PART [2]: Working Committee Details</h2>
        <table>
            <tr>
                <th>Approval Date</th>
                <td>
                    {{ $workingCommitteeApproval->w_c_approval_date
                        ? \Carbon\Carbon::parse($workingCommitteeApproval->w_c_approval_date)->format('d/m/Y')
                        : 'N/A' }}
                </td>
            </tr>
            <tr>
                <th>Approved Amount</th>
                <td>Rs. {{ number_format($workingCommitteeApproval->approval_financial_assistance_amount ?? 0, 2) }}</td>
            </tr>
            <tr>
                <th>Meeting No.</th>
                <td>{{ $workingCommitteeApproval->meeting_no ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <!-- PART [3]: Disbursement Details -->
    <div class="section">
        <h2>PART [3]: Disbursement Details</h2>

        <table>
            <tr>
                <th>Disbursement Type</th>
                <td>{{ $workingCommitteeApproval->disbursement_system ?? 'N/A' }}</td>
            </tr>

            @php
                // Safe array handling
                $dates = is_array($workingCommitteeApproval->yearly_dates)
                    ? $workingCommitteeApproval->yearly_dates
                    : json_decode($workingCommitteeApproval->yearly_dates, true);

                $amounts = is_array($workingCommitteeApproval->yearly_amounts)
                    ? $workingCommitteeApproval->yearly_amounts
                    : json_decode($workingCommitteeApproval->yearly_amounts, true);

                function ordinal($number)
                {
                    $suffixes = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
                    if ($number % 100 >= 11 && $number % 100 <= 13) {
                        return $number . 'th';
                    }
                    return $number . $suffixes[$number % 10];
                }
            @endphp

            @forelse ($dates as $index => $date)
                <tr>
                    <th>{{ ordinal($index + 1) }} Disbursement Date</th>
                    <td>
                        {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                    </td>
                </tr>

                <tr>
                    <th>{{ ordinal($index + 1) }} Disbursed Amount</th>
                    <td>
                        Rs. {{ number_format((float) ($amounts[$index] ?? 0), 2) }}
                    </td>
                </tr>

            @empty
                <tr>
                    <th>Disbursement</th>
                    <td>No disbursement data available</td>
                </tr>
            @endforelse

        </table>
    </div>

    <!-- PART [4]: Paid Details -->
    <div class="section">
        <h2>PART [4]: Paid Details</h2>
        <table style="margin-top: 12px;">
            <thead>
                <tr>
                    <th>Disbursements</th>
                    <th>Planned Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Disbursed Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($disbursementSchedules as $schedule)
                    @php
                        $scheduleDisbursement = $schedule->disbursement;
                        $plannedDate = $schedule->planned_date ? $schedule->planned_date->format('d/m/Y') : 'N/A';
                        $actualDate =
                            $scheduleDisbursement && $scheduleDisbursement->disbursement_date
                                ? $scheduleDisbursement->disbursement_date->format('d/m/Y')
                                : 'N/A';
                        $amount = $scheduleDisbursement->amount ?? ($schedule->planned_amount ?? 0);
                        $statusLabel = $scheduleDisbursement ? 'Paid' : ucfirst($schedule->status ?? 'pending');
                        $installmentLabel = $schedule->installment_no
                            ? 'Disbursement ' . $schedule->installment_no
                            : $loop->iteration . ' Disbursement';
                    @endphp
                    <tr>
                        <td>{{ $installmentLabel }}</td>
                        <td>{{ $plannedDate }}</td>
                        <td>Rs. {{ number_format($amount, 2) }}</td>
                        <td>{{ $statusLabel }}</td>
                        <td>{{ $actualDate }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No disbursement schedule available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PART [5]: Repayment Paid -->
    <div class="section">
        <h2>PART [5]: Repayment Schedule</h2>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Expected Amount</th>
                    <th>Paid Amount</th>
                    <th>Outstanding</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($repaymentRows as $row)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($row['date'])->format('d/m/Y') }}</td>

                        <td>Rs. {{ number_format($row['expected'], 2) }}</td>

                        <td>Rs. {{ number_format($row['paid'], 2) }}</td>

                        <td>Rs. {{ number_format($row['outstanding'], 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No repayment schedule available</td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot>
                <tr>
                    <th>Total</th>
                    <th>Rs. {{ number_format($totalExpected, 2) }}</th>
                    <th>Rs. {{ number_format($totalPaid, 2) }}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>



</body>

</html>
