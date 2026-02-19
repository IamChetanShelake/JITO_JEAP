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
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
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
        <img src="{{ public_path('jitojeaplogo.png') }}" alt="JITO JEAP Logo" style="height: 60px; margin-bottom: 10px;">
        <h1>JITO EDUCATION ASSISTANCE PROGRAM</h1>
        <h2>SUMMARY</h2>
        <p><strong>Application no.: JITO-JEAP/2025/{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</strong></p>
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

    <!-- PART[2]: Family Details -->
    <div class="section">
        <h2>PART[2]:-Family Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Qualification</th>
                    <th>Occupation</th>
                    <th>PAN Card No</th>
                    <th>Office Phone Number</th>
                    <th>Email</th>
                    <th>Total Yearly Gross</th>
                    <th>Total Insurance Coverage Of Family</th>
                    <th>Total Premium paid in Rupees per/Year</th>
                </tr>
            </thead>
            <tbody>
                @if($familyDetail && $familyDetail->additional_family_members)
                    @php
                        $familyMembers = is_array($familyDetail->additional_family_members)
                            ? $familyDetail->additional_family_members
                            : json_decode($familyDetail->additional_family_members, true);
                    @endphp
                    @foreach($familyMembers as $member)
                        <tr>
                            <td>{{ $member['relation'] ?? '' }}</td>
                            <td>{{ $member['age'] ?? '' }}</td>
                            <td>{{ $member['qualification'] ?? '' }}</td>
                            <td>{{ $member['occupation'] ?? '' }}</td>
                            <td>{{ $member['pan_card'] ?? '' }}</td>
                            <td>{{ $member['phone'] ?? '' }}</td>
                            <td>{{ $member['email'] ?? '' }}</td>
                            <td>{{ $member['yearly_income'] ?? 0 }}</td>
                            <td>{{ $familyDetail->total_insurance_coverage ?? 0 }}</td>
                            <td>{{ $familyDetail->total_premium_paid ?? 0 }}</td>
                        </tr>
                    @endforeach
                        <tr>
                            <td>{{ $user->namee ?? '' }}</td>
                            <td>{{ $user->age ?? '' }}</td>
                            <td>{{ $user->qualification ?? '' }}</td>
                            <td>{{ $user->occupation ?? '' }}</td>
                            <td>{{ $user->pan_card ?? '' }}</td>
                            <td>{{ $user->phone ?? '' }}</td>
                            <td>{{ $user->email ?? '' }}</td>
                            <td>{{ $user->yearly_income ?? 0 }}</td>
                            <td>{{ $user->total_insurance_coverage ?? 0 }}</td>
                            <td>{{ $user->total_premium_paid ?? 0 }}</td>
                        </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- PART [3]: Financial Assistance Details -->
    <div class="section">
        <h2>PART [3]: Financial Assistance Details</h2>
        <table>
            <tr>
                <th width="30%">Approve Financial Assistance Amount</th>
                <td width="70%" class="amount-highlight">
                    Rs. {{ number_format($workingCommitteeApproval->approval_financial_assistance_amount ?? 0, 2) }}
                </td>
            </tr>
            <tr>
                <th>First Disbursed Amount</th>
                <td class="amount-highlight">
                    Rs. {{ number_format($workingCommitteeApproval->approval_financial_assistance_amount ?? 0, 2) }}
                </td>
            </tr>
        </table>
    </div>

    <!-- PART [4]: Education Details -->
    <div class="section">
        <h2>PART [4]: Education Details:</h2>
        <table>
            <thead>
                <tr>
                    <th>Exam Name</th>
                    <th>Pass Year</th>
                    <th>Marks Obtained</th>
                    <th>Out Of Marks</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @if($educationDetail)
                    <tr>
                        <td>S.S.C</td>
                        <td>{{ $educationDetail->school_completion_year ? \Carbon\Carbon::parse($educationDetail->school_completion_year)->format('Y') : '' }}</td>
                        <td>{{ $educationDetail->school_percentage ? $educationDetail->school_percentage . '%' : '' }}</td>
                        <td>100</td>
                        <td>{{ $educationDetail->school_percentage ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>H.S.C.</td>
                        <td>{{ $educationDetail->jc_completion_year ?? '' }}</td>
                        <td>{{ $educationDetail->jc_percentage ? $educationDetail->jc_percentage . '%' : '' }}</td>
                        <td>100</td>
                        <td>{{ $educationDetail->jc_percentage ?? '' }}</td>
                    </tr>
                    @if($educationDetail->qualifications)
                        <tr>
                            <td>{{ $educationDetail->qualifications }}</td>
                            <td>{{ $educationDetail->qualification_end_year ? \Carbon\Carbon::parse($educationDetail->qualification_end_year)->format('Y') : '' }}</td>
                            <td>{{ $educationDetail->qualification_percentage ? $educationDetail->qualification_percentage . '%' : '' }}</td>
                            <td>100</td>
                            <td>{{ $educationDetail->qualification_percentage ?? '' }}</td>
                        </tr>
                    @endif
                    @if($educationDetail->ielts_overall_band_year)
                        <tr>
                            <td>IELTS</td>
                            <td>{{ $educationDetail->ielts_overall_band_year }}</td>
                            <td></td>
                            <td>9</td>
                            <td></td>
                        </tr>
                    @endif
                    @if($educationDetail->toefl_score_year)
                        <tr>
                            <td>TOEFL</td>
                            <td>{{ $educationDetail->toefl_score_year }}</td>
                            <td></td>
                            <td>120</td>
                            <td></td>
                        </tr>
                    @endif
                    @if($educationDetail->gre_score_year)
                        <tr>
                            <td>GRE</td>
                            <td>{{ $educationDetail->gre_score_year }}</td>
                            <td></td>
                            <td>340</td>
                            <td></td>
                        </tr>
                    @endif
                    @if($educationDetail->gmat_score_year)
                        <tr>
                            <td>GMAT</td>
                            <td>{{ $educationDetail->gmat_score_year }}</td>
                            <td></td>
                            <td>800</td>
                            <td></td>
                        </tr>
                    @endif
                    @if($educationDetail->sat_score_year)
                        <tr>
                            <td>SAT</td>
                            <td>{{ $educationDetail->sat_score_year }}</td>
                            <td></td>
                            <td>1600</td>
                            <td></td>
                        </tr>
                    @endif
                @endif
            </tbody>
        </table>
    </div>

    <!-- PART [5]: Courses Details -->
    <div class="section">
        <h2>PART [5]: Courses Details for which Educational Finance Assistance is applied</h2>
        <table>
            <thead>
                <tr>
                    <th>Name of Course</th>
                    <th>Commencement Month/Year</th>
                    <th>Completion Month/Year</th>
                    <th>University/Institute</th>
                    <th>City</th>
                    <th>Country</th>
                </tr>
            </thead>
            <tbody>
                @if($educationDetail)
                    <tr>
                        <td>{{ $educationDetail->course_name }}</td>
                        <td>{{ $educationDetail->start_year ? \Carbon\Carbon::parse($educationDetail->start_year)->format('m/Y') : '' }}</td>
                        <td>{{ $educationDetail->expected_year ? \Carbon\Carbon::parse($educationDetail->expected_year)->format('m/Y') : '' }}</td>
                        <td>{{ $educationDetail->university_name }}</td>
                        <td>{{ $educationDetail->city_name }}</td>
                        <td>{{ $educationDetail->country }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- PART [6]: Cost of Course Details -->
    <div class="section">
        <h2>PART [6]: Cost of Course Details for which Educational Finance Assistance is applied</h2>
        <table>
            <thead>
                <tr>
                    <th>Name of Course</th>
                    <th>1 Year</th>
                    <th>2 Year</th>
                    <th>3 Year</th>
                    <th>4 Year</th>
                    <th>5 Year</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Tuition Fee</td>
                    <td>{{ number_format($educationDetail->group_1_year1 ?? 0, 2) }}</td>
                    <td>{{ number_format($educationDetail->group_1_year2 ?? 0, 2) }}</td>
                    <td>{{ number_format($educationDetail->group_1_year3 ?? 0, 2) }}</td>
                    <td>{{ number_format($educationDetail->group_1_year4 ?? 0, 2) }}</td>
                    <td>{{ number_format($educationDetail->group_1_year5 ?? 0, 2) }}</td>
                    <td>{{ number_format($educationDetail->group_1_total ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td>Living Expenses</td>
                    <td>{{ number_format($educationDetail->group_2_year1 ?? 0, 2) }}</td>
                    <td>{{ number_format($educationDetail->group_2_year2 ?? 0, 2) }}</td>
                    <td>{{ number_format($educationDetail->group_2_year3 ?? 0, 2) }}</td>
                    <td>{{ number_format($educationDetail->group_2_year4 ?? 0, 2) }}</td>
                    <td>{{ number_format($educationDetail->group_2_year5 ?? 0, 2) }}</td>
                    <td>{{ number_format($educationDetail->group_2_total ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td>Other Expenses</td>
                    <td>{{ number_format($educationDetail->group_3_year1 ?? 0, 2) }}</td>
                    <td>{{ number_format($educationDetail->group_3_year2 ?? 0, 2) }}</td>
                    <td>{{ number_format($educationDetail->group_3_year3 ?? 0, 2) }}</td>
                    <td>{{ number_format($educationDetail->group_3_year4 ?? 0, 2) }}</td>
                    <td>{{ number_format($educationDetail->group_3_year5 ?? 0, 2) }}</td>
                    <td>{{ number_format($educationDetail->group_3_total ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Total Expenses Rs</strong></td>
                    <td><strong>{{ number_format(($educationDetail->group_1_year1 ?? 0) + ($educationDetail->group_2_year1 ?? 0) + ($educationDetail->group_3_year1 ?? 0), 2) }}</strong></td>
                    <td><strong>{{ number_format(($educationDetail->group_1_year2 ?? 0) + ($educationDetail->group_2_year2 ?? 0) + ($educationDetail->group_3_year2 ?? 0), 2) }}</strong></td>
                    <td><strong>{{ number_format(($educationDetail->group_1_year3 ?? 0) + ($educationDetail->group_2_year3 ?? 0) + ($educationDetail->group_3_year3 ?? 0), 2) }}</strong></td>
                    <td><strong>{{ number_format(($educationDetail->group_1_year4 ?? 0) + ($educationDetail->group_2_year4 ?? 0) + ($educationDetail->group_3_year4 ?? 0), 2) }}</strong></td>
                    <td><strong>{{ number_format(($educationDetail->group_1_year5 ?? 0) + ($educationDetail->group_2_year5 ?? 0) + ($educationDetail->group_3_year5 ?? 0), 2) }}</strong></td>
                    <td><strong>{{ number_format(($educationDetail->group_1_total ?? 0) + ($educationDetail->group_2_total ?? 0) + ($educationDetail->group_3_total ?? 0), 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- PART [7]: Funding Details -->
    <div class="section">
        <h2>PART [7]: Funding Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Particulars</th>
                    <th>Applied/Approved</th>
                    <th>Amount(Rs)</th>
                </tr>
            </thead>
            <tbody>
                @if($fundingDetail)
                    <tr>
                        <td>Own family funding (Father+Mother)</td>
                        <td>{{ $fundingDetail->family_funding_status ?? '' }}</td>
                        <td>{{ number_format($fundingDetail->family_funding_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Bank Loan</td>
                        <td>{{ $fundingDetail->bank_loan_status ?? '' }}</td>
                        <td>{{ number_format($fundingDetail->bank_loan_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Other Assistance(1)</td>
                        <td>{{ $fundingDetail->other_assistance1_status ?? '' }}</td>
                        <td>{{ number_format($fundingDetail->other_assistance1_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Other Assistance(2)</td>
                        <td>{{ $fundingDetail->other_assistance2_status ?? '' }}</td>
                        <td>{{ number_format($fundingDetail->other_assistance2_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Local Assistance</td>
                        <td>{{ $fundingDetail->local_assistance_status ?? '' }}</td>
                        <td>{{ number_format($fundingDetail->local_assistance_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td></td>
                        <td><strong>{{ number_format($fundingDetail->total_funding_amount ?? 0, 2) }}</strong></td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- PART [8]: Other Contacts Detail -->
    <div class="section">
        <h2>PART [8]: Other Contacts Detail</h2>
        <table>
            <thead>
                <tr>
                    <th>Relation</th>
                    <th>Name</th>
                    <th>Mobile No</th>
                    <th>Email ID</th>
                </tr>
            </thead>
            <tbody>
                @if($familyDetail)
                    <tr>
                        <td>Paternal Uncle</td>
                        <td>{{ $familyDetail->paternal_uncle_name ?? '' }}</td>
                        <td>{{ $familyDetail->paternal_uncle_mobile ?? '' }}</td>
                        <td>{{ $familyDetail->paternal_uncle_email ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>Maternal Uncle</td>
                        <td>{{ $familyDetail->maternal_uncle_name ?? '' }}</td>
                        <td>{{ $familyDetail->maternal_uncle_mobile ?? '' }}</td>
                        <td>{{ $familyDetail->maternal_uncle_email ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>Paternal Aunty</td>
                        <td>{{ $familyDetail->paternal_aunt_name ?? '' }}</td>
                        <td>{{ $familyDetail->paternal_aunt_mobile ?? '' }}</td>
                        <td>{{ $familyDetail->paternal_aunt_email ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>Maternal Aunty</td>
                        <td>{{ $familyDetail->maternal_aunt_name ?? '' }}</td>
                        <td>{{ $familyDetail->maternal_aunt_mobile ?? '' }}</td>
                        <td>{{ $familyDetail->maternal_aunt_email ?? '' }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- PART [9]: Gaurantor Details -->
    {{-- <div class="section">
        <h2>PART [9]:Gaurantor Details</h2>
        <table>
            <tr>
                <th width="25%">First guaranter Name</th>
                <td width="25%">{{ $guarantorDetail->g_one_name ?? 'N/A' }}</td>
                <th width="25%">Mobile no</th>
                <td width="25%">{{ $guarantorDetail->g_one_phone ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Income</th>
                <td>{{ number_format($guarantorDetail->g_one_income ?? 0, 2) }}</td>
                <th>Second guaranter Name</th>
                <td>{{ $guarantorDetail->g_two_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Mobile no</th>
                <td>{{ $guarantorDetail->g_two_phone ?? 'N/A' }}</td>
                <th>Income</th>
                <td>{{ number_format($guarantorDetail->g_two_income ?? 0, 2) }}</td>
            </tr>
        </table>
    </div> --}}

    <!-- PART [9]:Recommendation Details -->
    <div class="section">
        <h2>PART [9]:Recommendation Details</h2>
        <table>
            <tr>
                <th width="25%">Name Of Jito Member</th>
                <td width="25%">{{ $user->chapter_chairman ?? 'N/A' }}</td>
                <th width="25%">Mobile Number Of Jito Member</th>
                <td width="25%">{{ $user->chapter_contact ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Membership Type</th>
                <td>Chapter Chairman</td>
                <th>Chapter Name</th>
                <td>{{ $user->chapter ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <!-- PART [10]:Chapter Remarks -->
    <div class="section">
        <h2>PART [10]:Chapter Remarks</h2>
        <div class="remarks-section">
            <p><strong>Chapter Remarks:</strong></p>
            <p>{!! $workflow->chapter_approval_remarks ?? 'No chapter remarks available.' !!}</p>
        </div>
    </div>

    <!-- PART [11]:Apex Working Scrutiny team Remarks -->
    <div class="section">
        <h2>PART [11]:Apex Working Scrutiny team Remarks</h2>
        <div class="remarks-section">
            <p><strong>Apex Working Comittee Remarks:</strong></p>
            <p>{!! $workflow->working_committee_approval_remarks ?? 'No apex remarks available.' !!}</p>
            <p><strong>Apex Working Comittee Approval Date:</strong> {{ $workflow->working_committee_updated_at ? \Carbon\Carbon::parse($workflow->working_committee_updated_at)->format('d/m/Y') : 'N/A' }}</p>
        </div>
    </div>

    <!-- PART [12]:Working Commitee Details -->
    <div class="section">
        <h2>PART [12]:Working Commitee Details</h2>
        <table>
            <tr>
                <th width="30%">Working Commitee Approval Date</th>
                <td width="70%">{{ $workingCommitteeApproval->w_c_approval_date ? \Carbon\Carbon::parse($workingCommitteeApproval->w_c_approval_date)->format('d/m/Y') : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Approve Financial Assistance</th>
                <td>Rs. {{ number_format($workingCommitteeApproval->approval_financial_assistance_amount ?? 0, 2) }}</td>
            </tr>
            <tr>
                <th>Meeting No.</th>
                <td>{{ $workingCommitteeApproval->meeting_no ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <!-- PART [13]:Disbursement Details -->
    <div class="section">
        <h2>PART [13]:Disbursement Details</h2>
        <table>
            <tr>
                <th width="30%">Disbursement System</th>
                <td width="70%">{{ $workingCommitteeApproval->disbursement_system ?? 'N/A' }}</td>
            </tr>
            @if($workingCommitteeApproval && $workingCommitteeApproval->disbursement_system === 'yearly')
                @php
                    $yearlyDates = is_array($workingCommitteeApproval->yearly_dates)
                        ? $workingCommitteeApproval->yearly_dates
                        : json_decode($workingCommitteeApproval->yearly_dates, true);
                    $yearlyAmounts = is_array($workingCommitteeApproval->yearly_amounts)
                        ? $workingCommitteeApproval->yearly_amounts
                        : json_decode($workingCommitteeApproval->yearly_amounts, true);
                @endphp
                @if($yearlyDates && $yearlyAmounts)
                    @foreach($yearlyDates as $index => $date)
                        <tr>
                            <th>Disbursement Date {{ $index + 1 }}</th>
                            <td>{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }} - Rs. {{ number_format($yearlyAmounts[$index] ?? 0, 2) }}</td>
                        </tr>
                    @endforeach
                @endif
            @elseif($workingCommitteeApproval && $workingCommitteeApproval->disbursement_system === 'half_yearly')
                @php
                    $halfYearlyDates = is_array($workingCommitteeApproval->half_yearly_dates)
                        ? $workingCommitteeApproval->half_yearly_dates
                        : json_decode($workingCommitteeApproval->half_yearly_dates, true);
                    $halfYearlyAmounts = is_array($workingCommitteeApproval->half_yearly_amounts)
                        ? $workingCommitteeApproval->half_yearly_amounts
                        : json_decode($workingCommitteeApproval->half_yearly_amounts, true);
                @endphp
                @if($halfYearlyDates && $halfYearlyAmounts)
                    @foreach($halfYearlyDates as $index => $date)
                        <tr>
                            <th>Disbursement Date {{ $index + 1 }}</th>
                            <td>{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }} - Rs. {{ number_format($halfYearlyAmounts[$index] ?? 0, 2) }}</td>
                        </tr>
                    @endforeach
                @endif
            @endif
        </table>
    </div>

</body>
</html>
