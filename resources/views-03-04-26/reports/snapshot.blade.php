<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>JEAP Snapshot</title>
    <style>
        body {
            font-family: "Helvetica Neue", Arial, sans-serif;
            color: #111;
            margin: 0;
            padding: 0 24px 30px;
            line-height: 1.3;
            background: white;
        }

        .header-text {
            text-align: center;
            margin: 0;
            padding-top: 10px;
            line-height: 1.1;
        }

        .header-text h1 {
            font-size: 26px;
            letter-spacing: 2px;
            margin: 2px 0;
        }

        .header-text h2 {
            font-size: 18px;
            letter-spacing: 1px;
            margin: 2px 0;
            text-transform: uppercase;
        }

        .header-text .muted {
            font-size: 11px;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }

        .logo-table {
            width: 100%;
            margin-top: 0;
            margin-bottom: 4px;
        }

        .logo-table td {
            border: none;
            padding: 0;
        }

        .logo-table img {
            display: block;
            height: auto;
            max-width: 140px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 14px;
            page-break-inside: avoid;
        }

        th,
        td {
            border: 1px solid #222;
            padding: 6px 8px;
            font-size: 11px;
        }

        th {
            background: #111;
            color: #fff;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 10px;
        }

        .section-title {
            margin-top: 20px;
            font-size: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: 600;
            border-bottom: 2px solid #111;
            padding-bottom: 4px;
        }

        .footer {
            margin-top: 30px;
            font-size: 10px;
        }

        .footer .signatures {
            display: table;
            width: 100%;
            margin-top: 12px;
        }

        .footer .signatures .signature {
            display: table-cell;
            text-align: center;
            border: none;
            padding: 6px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .footer .contact {
            margin-top: 12px;
            font-size: 10px;
            letter-spacing: 0.5px;
        }

        .small-text {
            font-size: 10px;
            letter-spacing: 0.4px;
        }
    </style>
</head>

<body>
    @php
        $logoLeft = public_path('image 1.png');
        $logoRight = public_path('jitojeaplogo.png');
        $formatCurrency = fn($value) => 'Rs ' . number_format(max(0, $value), 0, '.', ',');
        $formatNumber = fn($value) => number_format(max(0, $value));
        $members = $donationCategories;
    @endphp

    <table class="logo-table">
        <tr>
            <td style="text-align: left;">
                <img src="{{ $logoLeft }}" alt="Header left">
            </td>
            <div class="header-text">
                <p class="muted">॥ बंदे श्री कपमं वीरं ॥</p>

                <h4>SNAPSHOT</h4>
                <h2>JITO EDUCATION </br>ASSISTANCE FOUNDATION</h2>
                <p class="muted">EDUCATION ASSISTANCE PROGRAM </p>
                <p class="muted">PERIOD: {{ $periodLabel }} · AS ON {{ $asOfLabel }}</p>
            </div>
            <td style="text-align: right;">
                <img src="{{ $logoRight }}" alt="Header right">
            </td>
        </tr>
    </table>



    <div class="section-title">Members Contribution</div>
    <table>
        <thead>
            <tr>
                <th>Period</th>
                <th>No. of Donors</th>
                <th>Amount Rs.</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($memberContributions['rows'] as $row)
                <tr>
                    <td>{{ $row['label'] }}</td>
                    <td class="text-right">{{ $formatNumber($row['count']) }}</td>
                    <td class="text-right">{{ $formatCurrency($row['amount']) }}</td>
                </tr>
            @endforeach
            <tr>
                <td>General Donation (general role)</td>
                <td class="text-right"></td>
                <td class="text-right">{{ $formatCurrency($memberContributions['general_amount']) }}</td>
            </tr>
            <tr>
                <td>Total Paid Donors</td>
                <td class="text-right">{{ $formatNumber($memberContributions['total_paid_donors']) }}</td>
                <td class="text-right">{{ $formatCurrency($memberContributions['total_paid_amount']) }}</td>
            </tr>
            <tr>
                <td>Total Unpaid Donors</td>
                <td class="text-right">{{ $formatNumber($memberContributions['total_unpaid_donors']) }}</td>
                <td class="text-right"></td>
            </tr>
            <tr>
                <td>Total JEAP Donors</td>
                <td class="text-right">{{ $formatNumber($memberContributions['total_donors']) }}</td>
                <td class="text-right"></td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">Students Application Details</div>
    <table>
        <tbody>
            <tr>
                <td>TOTAL APPLICATIONS</td>
                <td class="text-right">{{ $formatNumber($applicationStats['total']) }}</td>
            </tr>
            <tr>
                <td>COMPLETE APPLICATIONS</td>
                <td class="text-right">{{ $formatNumber($applicationStats['complete']) }}</td>
            </tr>
            <tr>
                <td>INCOMPLETE APPLICATIONS</td>
                <td class="text-right">{{ $formatNumber($applicationStats['incomplete']) }}</td>
            </tr>
            <tr>
                <td>APPLICATIONS SENT BACK FOR CORRECTION</td>
                <td class="text-right">{{ $formatNumber($applicationStats['sent_back_for_correction']) }}</td>
            </tr>
            <tr>
                <td>APPLICATIONS PROCESSED BY APEX</td>
                <td class="text-right">{{ $formatNumber($applicationStats['apex_approved']) }}</td>
            </tr>
            <tr>
                <td>CHAPTER APPROVED APPLICATIONS</td>
                <td class="text-right">{{ $formatNumber($applicationStats['chapter_approved']) }}</td>
            </tr>
            <tr>
                <td>CHAPTER APPROVAL PENDING</td>
                <td class="text-right">
                    {{ $formatNumber($applicationStats['under_scrutiny'] + $applicationStats['on_hold']) }}</td>
            </tr>
            {{-- <tr>
            <td>APPLICATIONS APPROVED BY JEAP WORKING COMMITTEE</td>
            <td class="text-right">{{ $formatNumber($disbursementStats['disbursed_applications']) }}</td>
        </tr>
        <tr>
            <td>APPLICATIONS REJECTED</td>
            <td class="text-right">{{ $formatNumber($applicationStats['rejected']) }}</td>
        </tr>
        <tr>
            <td>APPLICATIONS UNDER APEX SCRUTINY</td>
            <td class="text-right">{{ $formatNumber($applicationStats['under_scrutiny']) }}</td>
        </tr>
        <tr>
            <td>APPLICATIONS ON HOLD</td>
            <td class="text-right">{{ $formatNumber($applicationStats['on_hold']) }}</td>
        </tr>
        <tr>
            <td>SECOND STAGE DOCUMENT PENDING</td>
            <td class="text-right">{{ $formatNumber($applicationStats['second_stage_pending']) }}</td>
        </tr> --}}
        </tbody>
    </table>

    <div class="section-title">Working Committee Details</div>
    <table>
        <tbody>
            <tr>
                <td>APPLICATIONS APPROVED BY JEAP WORKING COMMITTEE</td>
                <td class="text-right">{{ $formatNumber($workingCommitteeCounts['approved']) }}</td>
            </tr>
            <tr>
                <td>APPLICATIONS PENDING </td>
                <td class="text-right">{{ $formatNumber($workingCommitteeCounts['pending']) }}</td>
            </tr>
            <tr>
                <td>APPLICATIONS ON HOLD</td>
                <td class="text-right">{{ $formatNumber($workingCommitteeCounts['hold']) }}</td>
            </tr>
            <tr>
                <td>APPLICATIONS REJECTED</td>
                <td class="text-right">{{ $formatNumber($workingCommitteeCounts['rejected']) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">Apex Stage 2 (Post Dated Cheques Details)</div>
    <table>
        <tbody>
            <tr>
                <td>SECOND STAGE DOCUMENT Approved</td>
                <td class="text-right">{{ $formatNumber($apexStage2Counts['approved']) }}</td>
            </tr>
            <tr>
                <td>SECOND STAGE DOCUMENT Pending</td>
                <td class="text-right">{{ $formatNumber($apexStage2Counts['pending']) }}</td>
            </tr>
            <tr>
                <td>SECOND STAGE DOCUMENT Send back for Correction</td>
                <td class="text-right">{{ $formatNumber($apexStage2Counts['send_back']) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">DISBURSEMENT Details</div>
    <table>
        <tbody>
        <tr>
            <td>READY FOR DISBURSEMENT</td>
            <td class="text-right">{{ $formatNumber($disbursementApplicationCounts['ready']) }}</td>
        </tr>
        <tr>
            <td>DISBURSED APPLICATIONS</td>
            <td class="text-right">{{ $formatNumber($disbursementApplicationCounts['completed']) }}</td>
        </tr>
        </tbody>
    </table>

    <div class="section-title">Financial Disbursal Summary</div>
    <table>
        <tbody>
            <tr>
                <td>FUNDS SANCTIONED UP TO {{ $asOfLabel }}</td>
                <td class="text-right">{{ $formatCurrency($disbursementStats['sanctioned']['till_date']) }}</td>
            </tr>
            <tr>
                <td>FUNDS SANCTIONED THIS MONTH ({{ $monthLabel }})</td>
                <td class="text-right">{{ $formatCurrency($disbursementStats['sanctioned']['current_month']) }}</td>
            </tr>
            <tr>
                <td>TOTAL FUNDS SANCTIONED</td>
                <td class="text-right">{{ $formatCurrency($disbursementStats['sanctioned']['total']) }}</td>
            </tr>
            <tr>
                <td>FUNDS DISBURSED UP TO {{ $asOfLabel }}</td>
                <td class="text-right">{{ $formatCurrency($disbursementStats['disbursed']['till_date']) }}</td>
            </tr>
            <tr>
                <td>FUNDS DISBURSED THIS MONTH ({{ $monthLabel }})</td>
                <td class="text-right">{{ $formatCurrency($disbursementStats['disbursed']['current_month']) }}</td>
            </tr>
            <tr>
                <td>TOTAL FUNDS DISBURSED</td>
                <td class="text-right">{{ $formatCurrency($disbursementStats['disbursed']['total']) }}</td>
            </tr>
            <tr>
                <td>STUDENT DONATIONS UP TO {{ $asOfLabel }}</td>
                <td class="text-right">{{ $formatCurrency($studentContribution['till_date']) }}</td>
            </tr>
            <tr>
                <td>STUDENT DONATIONS THIS MONTH ({{ $monthLabel }})</td>
                <td class="text-right">{{ $formatCurrency($studentContribution['current_month']) }}</td>
            </tr>
            <tr>
                <td>TOTAL STUDENT CONTRIBUTIONS</td>
                <td class="text-right">{{ $formatCurrency($studentContribution['total']) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div class="signatures">
            <div class="signature">Hitesh Doshi<br><span class="small-text">Chairman</span></div>
            <div class="signature">CA Satish Hiran<br><span class="small-text">Chief Secretary</span></div>
            <div class="signature">Dilip Nabera<br><span class="small-text">Treasurer</span></div>
        </div>
        <div class="contact">
            <strong>Contact for JEAP (JITO Apex Office)</strong><br>
            Salloni Gandhi<br>
            Mobile no : 8655988411<br>
            Email: support.jitojeap@jito.org<br>
            Website: https://jitojeap.in/
        </div>
    </div>
</body>

</html>
