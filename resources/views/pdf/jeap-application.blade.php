<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>JITO JEAP Application Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
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
            font-size: 18px;
            font-weight: bold;
        }
        .address {
            font-size: 11px;
            margin: 5px 0;
        }
        .form-info {
            margin: 15px 0;
            padding: 10px;
            border: 1px solid #ccc;
        }
        .section {
            margin: 20px 0;
            page-break-inside: avoid;
        }
        .section h2 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .amount-section {
            float: right;
            width: 320px;
            margin-top: 20px;
        }
        .amount-box {
            border: 1px solid #000;
            padding: 10px;
            font-size: 11px;
        }
        .amount-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            padding: 4px 0;
        }
        .amount-row:last-child {
            margin-bottom: 0;
        }
        .amount-label {
            font-weight: bold;
            text-align: left;
            flex: 1;
            line-height: 1.3;
        }
        .amount-value {
            font-weight: bold;
            text-align: right;
            color: #000;
            margin-left: 10px;
        }
        .approved-by {
            border-top: 1px solid #000;
            padding-top: 8px;
            margin-top: 8px;
        }
        .approved-by .amount-label {
            font-weight: normal;
        }
        .declaration {
            margin-top: 30px;
            line-height: 1.6;
        }
        .signature-section {
            margin-top: 40px;
            border-top: 1px solid #000;
            padding-top: 20px;
        }
        .page-break {
            page-break-before: always;
        }
        .inline-fields {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }
        .field-group {
            flex: 1;
            margin: 0 10px;
        }
        .field-label {
            font-weight: bold;
            display: inline-block;
            min-width: 120px;
        }

    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
         <img src="{{ public_path('jitojeaplogo.png') }}" alt="JITO JEAP Logo" style="height: 60px; margin-bottom: 10px;">
        <h1>JITO EDUCATION ASSISTANCE PROGRAM</h1>
        <h2>Application Form Report</h2>

    </div>

    <div class="address">
            To,<br>
            The Honorary Secretaries,<br>
            JITO HOUSE, Plot No. A-56, Road No. 1, MIDC MAROL,<br>
            Near International by Tunga Hotel,<br>
            Mulgaon, Andheri (East), Mumbai - 400 093/ 86559 88411<br>
            Email: support.jitojeap@jito.org Website: www.jitojeap.in
        </div>

    <p>Dear Sir,</p>
    <p>I, hereby apply for JITO JEAP Educational Assistance Program for study.</p>

    <!-- Form Information -->
    <style>
    .form-info {
        display: table;
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .form-row {
        display: table-row;
    }

    .form-label, .form-value {
        display: table-cell;
        padding: 4px 8px;
        vertical-align: top;
    }

    .form-label {
        width: 30%;       /* Fixed width for labels */
        font-weight: 600;
    }

    .form-value {
        width: 70%;       /* Remaining width for values */
    }
</style>

<div class="form-info">
    <div class="form-row">
        <div class="form-label">Form No:</div>
        <div class="form-value">JITO-JEAP/2025/{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
    </div>
    <div class="form-row">
        <div class="form-label">Request Date:</div>
        <div class="form-value">{{ now()->format('d-m-Y') }}</div>
    </div>
    <div class="form-row">
        <div class="form-label">Educational Assistance Type:</div>
        <div class="form-value">{{ $user->financial_asset_type == 'domestic' ? 'DOMESTIC' : 'FOREIGN FINANCIAL ASSISTANCE' }}</div>
    </div>
</div>




   <table class="table table-bordered text-center" style="width:100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>Recommended Educational Assistance Amount</th>
            <th>Approved Educational Assistance Amount</th>
            <th>Disbursed Educational Assistance Amount</th>

        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Rs.{{ $workflow->chapter_assistance_amount ?? 'N/A' }}</td>
            <td>
                Rs.{{ $workflow->working_committee_assistance_amount ?? 'N/A'}}
            </td>
            <td>
                Rs.{{ number_format($workflow->final_status == 'approved' ? 1500000 : 0, 2) }}
            </td>
        </tr>
    </tbody>
</table>







    <div style="clear: both;"></div>

    <h2 style="margin-top:20px;">PART (1): Student Details</h2>

<table class="table table-bordered" style="width:100%; border-collapse:collapse;">
    <tbody>
        <tr>
            <th style="width:25%;">Course</th>
            <td style="width:75%;" colspan="3">
                {{ $educationDetail->course_name ?? 'N/A' }}
            </td>
        </tr>

        <tr>
            <th>Name</th>
            <td>{{ $user->name }}</td>
            <th>Contact No.</th>
            <td>{{ $user->phone }}</td>
        </tr>

        <tr>
            <th>Email</th>
            <td>{{ $user->email }}</td>
            <th>Birth Date</th>
            <td>
                {{ $user->d_o_b ? \Carbon\Carbon::parse($user->d_o_b)->format('d/m/Y') : 'N/A' }}
            </td>
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
                {{ $user->flat_no }}
                {{ $user->building_no }}
                {{ $user->street_name }}
                {{ $user->area }}
                {{ $user->landmark }}
            </td>
        </tr>

        <tr>
            <th>PIN Code</th>
            <td colspan="3">{{ $user->pin_code }}</td>
        </tr>
    </tbody>
</table>


    <!-- PART(2): Family Details -->
    <div class="section">
        <h2>PART(2): Family Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Relation</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Qualification</th>
                    <th>Occupation</th>
                    <th>PAN Card No</th>
                    <th>Office Phone Number</th>
                    <th>Email</th>
                    <th>Total Yearly Gross</th>
                    <th>Total Family Insurance</th>
                    <th>Total Family Premium</th>
                </tr>
            </thead>
            <tbody>
                @if($familyDetail)
                    @php
                        $familyMembers = json_decode($familyDetail->additional_family_members ?? '[]', true);
                        // $familyMembers = array_merge([
                        //     [
                        //         'relation' => 'Father',
                        //         'name' => $familyDetail->father_name ?? '',
                        //         'age' => $familyDetail->father_age ?? '',
                        //         'qualification' => $familyDetail->father_qualification ?? '',
                        //         'occupation' => $familyDetail->father_occupation ?? '',
                        //         'pan' => $familyDetail->father_pan ?? '',
                        //         'phone' => $familyDetail->father_phone ?? '',
                        //         'email' => $familyDetail->father_email ?? '',
                        //         'income' => $familyDetail->father_income ?? 0,
                        //         'insurance' => $familyDetail->father_insurance ?? 0,
                        //         'premium' => $familyDetail->father_premium ?? 0,
                        //     ],
                        //     [
                        //         'relation' => 'Mother',
                        //         'name' => $familyDetail->mother_name ?? '',
                        //         'age' => $familyDetail->mother_age ?? '',
                        //         'qualification' => $familyDetail->mother_qualification ?? '',
                        //         'occupation' => $familyDetail->mother_occupation ?? '',
                        //         'pan' => $familyDetail->mother_pan ?? '',
                        //         'phone' => $familyDetail->mother_phone ?? '',
                        //         'email' => $familyDetail->mother_email ?? '',
                        //         'income' => $familyDetail->mother_income ?? 0,
                        //         'insurance' => $familyDetail->mother_insurance ?? 0,
                        //         'premium' => $familyDetail->mother_premium ?? 0,
                        //     ]
                        // ], $familyMembers);
                    @endphp

                    @foreach($familyMembers as $member)
                        <tr>
                            <td>{{ $member['relation'] ?? '' }}</td>
                            <td>{{ $member['name'] ?? '' }}</td>
                            <td>{{ $member['age'] ?? '' }}</td>
                            <td>{{ $member['qualification'] ?? '' }}</td>
                            <td>{{ $member['occupation'] ?? '' }}</td>
                            <td>{{ $member['pan'] ?? '' }}</td>
                            <td>{{ $member['phone'] ?? '' }}</td>
                            <td>{{ $member['email'] ?? '' }}</td>
                            <td>{{ number_format($member['income'] ?? 0, 2) }}</td>
                            <td>{{ number_format($member['insurance'] ?? 0, 2) }}</td>
                            <td>{{ number_format($member['premium'] ?? 0, 2) }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <p><strong>** I/We hereby give consent to my Son / Daughter to apply for the Educational Assistance.</strong></p>
        <p><strong>Signature(Parents):</strong> ___________________________</p>
    </div>

    <style>
    .info-box {
        border: 1px solid #000;
        padding: 8px;
        margin-top: 0; /* Remove top margin to eliminate gap */
    }

    .info-box + .info-box {
        border-top: none; /* Optional: merge borders for continuous look */
    }

    .info-row {
        display: table;
        width: 100%;
        border-collapse: collapse;
    }

    .info-label,
    .info-value {
        display: table-cell;
        vertical-align: top;
        padding: 0;
        margin: 0;
    }

    .info-label {
        width: 75%;
        font-weight: 600;
    }

    .info-value {
        width: 25%;
        text-align: left;
    }
</style>



<div class="section">
    <h2>PART (3): Association with JITO</h2>

    <div class="info-box">
        <div class="info-row">
            <div class="info-label">
                Are you Current / Past Student of JITO-JEAP? Please mention Branch:
            </div>
            <div class="info-value">
                {{ $user->chapter ?? 'N/A' }}
            </div>
        </div>
    </div>

    <div class="info-box">
        <div class="info-row">
            <div class="info-label">
                Any close relative associated with JITO-JEAP? Name:
            </div>
            <div class="info-value">
                {{ $familyDetail->relative_jito_association ?? 'N/A' }}
            </div>
        </div>
    </div>
</div>





    <!-- PART(4): Education Details -->
    <div class="section">
        <h2>PART(4): Education Details:</h2>
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
                    <!-- Add more education rows as needed -->
                @endif
            </tbody>
        </table>

        <p><strong>Please specify if any extra curricular activities at school/college/University level:</strong> {{ $educationDetail->extra_curricular ?? 'N/A' }}</p>
        <p><strong>Please specify if any research and development projects undertaken:</strong> {{ $educationDetail->projects ?? 'N/A' }}</p>
        <p><strong>Please specify work experience if any:</strong> {{ $educationDetail->have_work_experience == 'yes' ? $educationDetail->work_duration . ' years' : 'None' }}</p>
        @if($educationDetail && $educationDetail->have_work_experience == 'yes')
            <p><strong>Name of Company:</strong> {{ $educationDetail->organization_name }}</p>
            <p><strong>Package Rs:</strong> {{ number_format($educationDetail->salary_amount ?? 0, 2) }}</p>
            <p><strong>Work Profile:</strong> {{ $educationDetail->work_profile }}</p>
        @endif
    </div>

    <!-- PART(5): Courses Details -->
    <div class="section">
        <h2>PART(5): Courses Details for which Educational Assistance is applied</h2>
        <table>
            <thead>
                <tr>
                    <th>Name of Course</th>
                    <th>Commencement Month/Year</th>
                    <th>Completion Month/Year</th>
                    <th>University/Institute</th>
                    <th>City</th>
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
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- PART(6): Cost of Course Details -->
    <div class="section">
        <h2>PART(6): Cost of Course Details for which Educational Assistance is applied</h2>
        <p><strong>Requested Year: 1st Year Amount Requested tuition fees amount:</strong> {{ number_format($educationDetail->group_1_year1 ?? 0, 2) }}</p>

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

    <!-- PART(7): Funding Details -->
    <div class="section">
        <h2>PART(7): Funding Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Particulars</th>
                    <th>Status</th>
                    <th>Trust Name</th>
                    <th>Contact Person</th>
                    <th>Contact No</th>
                    <th>Amount(Rs)</th>
                </tr>
            </thead>
            <tbody>
                @if($fundingDetail)
                    <tr>
                        <td>Own family funding (Father+Mother)</td>
                        <td>{{ $fundingDetail->family_funding_status ?? '' }}</td>
                        <td>{{ $fundingDetail->family_funding_trust ?? '' }}</td>
                        <td>{{ $fundingDetail->family_funding_contact ?? '' }}</td>
                        <td>{{ $fundingDetail->family_funding_mobile ?? '' }}</td>
                        <td>{{ number_format($fundingDetail->family_funding_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Bank Loan</td>
                        <td>{{ $fundingDetail->bank_loan_status ?? '' }}</td>
                        <td>{{ $fundingDetail->bank_loan_trust ?? '' }}</td>
                        <td>{{ $fundingDetail->bank_loan_contact ?? '' }}</td>
                        <td>{{ $fundingDetail->bank_loan_mobile ?? '' }}</td>
                        <td>{{ number_format($fundingDetail->bank_loan_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Other Assistance(1)</td>
                        <td>{{ $fundingDetail->other_assistance1_status ?? '' }}</td>
                        <td>{{ $fundingDetail->other_assistance1_trust ?? '' }}</td>
                        <td>{{ $fundingDetail->other_assistance1_contact ?? '' }}</td>
                        <td>{{ $fundingDetail->other_assistance1_mobile ?? '' }}</td>
                        <td>{{ number_format($fundingDetail->other_assistance1_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Other Assistance(2)</td>
                        <td>{{ $fundingDetail->other_assistance2_status ?? '' }}</td>
                        <td>{{ $fundingDetail->other_assistance2_trust ?? '' }}</td>
                        <td>{{ $fundingDetail->other_assistance2_contact ?? '' }}</td>
                        <td>{{ $fundingDetail->other_assistance2_mobile ?? '' }}</td>
                        <td>{{ number_format($fundingDetail->other_assistance2_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Local Assistance</td>
                        <td>{{ $fundingDetail->local_assistance_status ?? '' }}</td>
                        <td>{{ $fundingDetail->local_assistance_trust ?? '' }}</td>
                        <td>{{ $fundingDetail->local_assistance_contact ?? '' }}</td>
                        <td>{{ $fundingDetail->local_assistance_mobile ?? '' }}</td>
                        <td>{{ number_format($fundingDetail->local_assistance_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td colspan="5"><strong>{{ number_format($fundingDetail->total_funding_amount ?? 0, 2) }}</strong></td>
                    </tr>
                @endif
            </tbody>
        </table>

        <p><strong>As on today is there any unpaid Educational Assistance of JITO by you or your family members? if yes</strong> {{ $fundingDetail->unpaid_assistance ?? 'No' }}</p>
    </div>

    <!-- PART(8): Other Contacts Detail -->
    <div class="section">
        <h2>PART(8): Other Contacts Detail</h2>
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

    <!-- PART(9): Recommendation Member details -->
    <div class="section">
        <h2>PART(9): Recommendation Member details</h2>
        <table>
            <thead>
                <tr>
                    <th>Name of Jito Member</th>
                    <th>Mobile Number of Jito Member</th>
                    <th>Membership Type</th>
                    <th>Chapter</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $user->chapter_chairman ?? 'N/A' }}</td>
                    <td>{{ $user->chapter_contact ?? 'N/A' }}</td>
                    <td>Chapter Chairman</td>
                    <td>{{ $user->chapter ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- PART(10): Declaration By Parent and Applicant -->
  <style>
    /* Declaration Boxes */
    .info-box {
        border: 1px solid #000;
        padding: 5px;
        margin: 0; /* No vertical gap */
    }

    .info-box + .info-box {
        margin-top: 0; /* No gap between boxes */
    }

    /* Signature Box */
    .signature-box {
        display: table;
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #000; /* outer box border */
        margin-top: 0;
    }

    .signature-cell {
        display: table-cell;
        border-left: 1px solid #000; /* inner compartments */
        padding: 8px;
        vertical-align: middle;
    }

    .signature-cell:first-child {
        border-left: none; /* no double border on leftmost cell */
    }

    .signature-left {
        width: 40%;
    }

    .signature-center {
        width: 35%;
        text-align: center;
    }

    .signature-right {
        width: 25%;
        text-align: center;
    }

    /* Section Heading */
    .section h2 {
        margin-top: 20px;
        margin-bottom: 10px;
    }
</style>

<div class="section declaration">
    <h2>PART(10): Declaration By Parent and Applicant</h2>

    <!-- Box 1 -->
    <div class="info-box">
        <p>
            I hereby declare that the details in this form are true and correct to the best of my knowledge.
            I hereby give my consent to my son / daughter / ward for going to: {{ $educationDetail->course_name ?? 'N/A' }} for further studies.
        </p>
    </div>

    <!-- Box 2 -->
    <div class="info-box">
        <p>
            If my Educational Assistance is approved, I agree to abide by the terms and conditions of the JEAP EDUCATION ASSISTANCE PROGRAM.
            I also undertake to keep the office bearers/Trustees informed of my correct address and that of my Parents/Guarantors and recommenders from time to time.
            I will send my second stage documents duly completed.
            I hereby declare that amount of Educational Assistance will be utilized for education purpose only.
        </p>
    </div>

    <!-- Signature Box -->
    <div class="signature-box">
        <div class="signature-cell signature-left">
            <strong>Name of Applicant:</strong> {{ $user->name }}
        </div>
        <div class="signature-cell signature-center">
            <strong>Signature of Applicant:</strong> ___________________________
        </div>
        <div class="signature-cell signature-right">
            <strong>Date:</strong> {{ now()->format('d/m/Y') }}
        </div>
    </div>
</div>


</body>
</html>
