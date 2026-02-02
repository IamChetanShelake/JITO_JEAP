@section('styles')
<style>
    body {
        font-family: 'Times New Roman', Times, serif;
        font-size: 12px;
        line-height: 1.4;
        color: #000;
        margin: 0;
        padding: 20px;
        background: white;
    }

    .letter-container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        padding: 20px;
    }

    .header-section {
        text-align: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #000;
        padding-bottom: 20px;
    }

    .logo {
        height: 60px;
        margin-bottom: 10px;
    }

    .header-title {
        font-size: 18px;
        font-weight: bold;
        margin: 5px 0;
        text-transform: uppercase;
    }

    .header-subtitle {
        font-size: 14px;
        margin: 5px 0;
    }

    .date-section {
        text-align: right;
        margin-bottom: 20px;
        font-size: 12px;
    }

    .recipient-section {
        margin-bottom: 20px;
    }

    .recipient-section p {
        margin: 5px 0;
        line-height: 1.6;
    }

    .subject-section {
        text-align: center;
        margin: 20px 0;
        font-weight: bold;
        font-size: 14px;
        text-decoration: underline;
    }

    .content-section {
        margin: 20px 0;
        text-align: justify;
    }

    .content-section p {
        margin: 10px 0;
        text-align: justify;
    }

    .amount-highlight {
        font-weight: bold;
        font-size: 14px;
        color: #000;
    }

    .table-section {
        margin: 20px 0;
    }

    .sanction-table {
        width: 100%;
        border-collapse: collapse;
        margin: 15px 0;
        font-size: 11px;
    }

    .sanction-table th,
    .sanction-table td {
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
    }

    .sanction-table th {
        background: #f0f0f0;
        font-weight: bold;
    }

    .terms-section {
        margin: 20px 0;
    }

    .terms-section h4 {
        font-size: 13px;
        font-weight: bold;
        margin: 15px 0 10px 0;
        text-decoration: underline;
    }

    .terms-section ul {
        margin: 0;
        padding-left: 20px;
    }

    .terms-section li {
        margin: 5px 0;
        line-height: 1.4;
    }

    .signature-section {
        margin-top: 40px;
        text-align: right;
    }

    .signature-line {
        border-bottom: 1px solid #000;
        width: 200px;
        display: inline-block;
        margin-bottom: 5px;
    }

    .signature-title {
        font-size: 12px;
        font-weight: bold;
        margin-top: 10px;
    }

    .footer-note {
        margin-top: 20px;
        font-size: 10px;
        text-align: center;
        border-top: 1px solid #000;
        padding-top: 10px;
    }

    @media print {
        body {
            padding: 0;
        }
        .letter-container {
            padding: 15px;
        }
    }
</style>
@endsection

@section('content')
<div class="letter-container">
    <!-- Header Section -->
    <div class="header-section">
        <img src="{{ asset('jitojeaplogo.png') }}" alt="JITO JEAP Logo" class="logo">
        <div class="header-title">JITO EDUCATION ASSISTANCE PROGRAM</div>
        <div class="header-subtitle">JEAP Sanction Letter</div>
    </div>

    <!-- Date and Reference -->
    <div class="date-section">
        <p>Date: {{ now()->format('d/m/Y') }}</p>
        <p>Ref: JITO-JEAP/{{ now()->format('Y') }}/{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</p>
    </div>

    <!-- Recipient Details -->
    <div class="recipient-section">
        <p>To,</p>
        <p><strong>{{ $user->name }}</strong></p>
        <p>{{ $user->flat_no ?? '' }} {{ $user->building_no ?? '' }} {{ $user->street_name ?? '' }}</p>
        <p>{{ $user->area ?? '' }}, {{ $user->city ?? '' }}, {{ $user->district ?? '' }}</p>
        <p>{{ $user->state ?? '' }} - {{ $user->pin_code ?? '' }}</p>
        <p>Email: {{ $user->email }}</p>
        <p>Mobile: {{ $user->phone ?? $user->mobile }}</p>
    </div>

    <!-- Subject -->
    <div class="subject-section">
        <p>SUBJECT: SANCTION OF FINANCIAL ASSISTANCE UNDER JEAP</p>
    </div>

    <!-- Main Content -->
    <div class="content-section">
        <p>Dear <strong>{{ $user->name }}</strong>,</p>

        <p>We are pleased to inform you that your application for financial assistance under the JITO Education Assistance Program (JEAP) has been reviewed and approved by the Working Committee.</p>

        <p>Based on the evaluation of your application and supporting documents, we have sanctioned financial assistance of <span class="amount-highlight">Rs. {{ number_format($workingCommitteeApproval->approval_financial_assistance_amount, 2) }}</span> for your higher education.</p>

        <div class="table-section">
            <table class="sanction-table">
                <thead>
                    <tr>
                        <th>Particulars</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Application Number</td>
                        <td>JITO-JEAP/{{ now()->format('Y') }}/{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</td>
                    </tr>
                    <tr>
                        <td>Student Name</td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td>Course</td>
                        <td>{{ $educationDetail->course_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>University/Institution</td>
                        <td>{{ $educationDetail->university_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Financial Assistance Type</td>
                        <td>{{ $user->financial_asset_type == 'domestic' ? 'DOMESTIC' : 'FOREIGN' }}</td>
                    </tr>
                    <tr>
                        <td>Sanctioned Amount</td>
                        <td>Rs. {{ number_format($workingCommitteeApproval->approval_financial_assistance_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Number of Installments</td>
                        <td>{{ $workingCommitteeApproval->no_of_cheques_to_be_collected ?? 15 }}</td>
                    </tr>
                    <tr>
                        <td>Installment Amount</td>
                        <td>Rs. {{ number_format($workingCommitteeApproval->installment_amount ?? 0, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="terms-section">
            <h4>TERMS AND CONDITIONS:</h4>
            <ul>
                <li>This sanction letter is valid for 30 days from the date of issue.</li>
                <li>The sanctioned amount will be disbursed in {{ $workingCommitteeApproval->no_of_cheques_to_be_collected ?? 15 }} equal installments.</li>
                <li>Repayment will commence from {{ $workingCommitteeApproval->repayment_starting_from ? \Carbon\Carbon::parse($workingCommitteeApproval->repayment_starting_from)->format('d/m/Y') : 'N/A' }}.</li>
                <li>All required documents must be submitted within the validity period.</li>
                <li>The applicant must maintain satisfactory academic progress.</li>
                <li>JEAP reserves the right to modify or cancel the sanction based on policy changes.</li>
            </ul>
        </div>

        <div class="terms-section">
            <h4>NEXT STEPS:</h4>
            <ul>
                <li>Submit all required documents along with post-dated cheques within 30 days.</li>
                <li>Contact support.jeap1@jito.org for any queries.</li>
                <li>Visit www.jitojeap.in for detailed documentation requirements.</li>
                <li>Complete the documentation process as per the guidelines provided.</li>
            </ul>
        </div>

        <p>We wish you success in your educational endeavors and look forward to your continued progress.</p>

        <p>For any assistance, please contact us at:</p>
        <p><strong>JITO House:</strong> Plot No. A-56, Road No. 1, MIDC MAROL, Near International Tunga Hotel, Mulgaon, Andheri (East), Mumbai - 400 093</p>
        <p><strong>Email:</strong> support.jitojeap@jito.org | support.jeap1@jito.org</p>
        <p><strong>Phone:</strong> 86559 88411 | Mr. Guruprasad Ganapuram: 8879519845</p>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-line"></div>
        <div class="signature-title">Hon. Secretary</div>
        <div class="signature-title">JITO Education Assistance Foundation</div>
    </div>

    <!-- Footer Note -->
    <div class="footer-note">
        <p>This is a system-generated sanction letter. For verification, contact JITO JEAP office.</p>
        <p>Generated on: {{ now()->format('d M Y H:i:s') }}</p>
    </div>
</div>
@endsection
