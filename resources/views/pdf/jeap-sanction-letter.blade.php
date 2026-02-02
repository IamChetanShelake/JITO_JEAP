<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>JEAP Sanction Letter</title>

    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
            line-height: 1.45;
            color: #000;
            margin: 0;
            padding: 30px;
        }

        .page {
            max-width: 800px;
            margin: auto;
        }

        .center {
            text-align: center;
        }

        .header h1 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header p {
            margin: 2px 0;
        }

        .section-title {
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 18px;
            margin-bottom: 6px;
        }

        p {
            margin: 6px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        th {
            font-weight: bold;
            text-align: left;
        }

        ol,
        ul {
            margin: 6px 0 6px 20px;
        }

        li {
            margin-bottom: 4px;
        }

        .page-footer {
            margin-top: 30px;
            font-size: 11px;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <div class="page">

        <div class="center">
            <img src="{{ public_path('jitojeaplogo.png') }}" height="70"><br><br>
            <div class="header">
                <h1>JITO EDUCATION ASSISTANCE FOUNDATION</h1>
                <p>JITO HOUSE, Plot No. A-56, Road No. 1, MIDC MAROL</p>
                <p>Near International Tunga Hotel, Andheri (East)</p>
                <p>Mumbai - 400 093</p>
                <p>Email: support.jitojeap@jito.org | Website: www.jitojeap.in</p>
                <p><strong>JITO EDUCATION ASSISTANCE PROGRAM</strong></p>
            </div>
        </div>

        <p><strong>Financial Asst Type:</strong> {{ $educationDetail->course_type ?? 'FOREIGN FINANCIAL ASSISTANCE' }}
        </p>
        <p><strong>Dear Mr/Ms.</strong> {{ $user->name }},</p>

        <p class="section-title">CONGRATULATIONS:</p>

        <p>
            We are pleased to inform you that an amount of
            <strong>Rs.
                {{ number_format($workingCommitteeApproval->approval_financial_assistance_amount ?? 0) }}</strong>
            has been sanctioned against your application for Higher Education under JEAP.
        </p>

        <p class="section-title">YEAR WISE SANCTIONED AMOUNT</p>

        <table>
            <tr>
                <th>Disbursement</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
            @for ($i = 0; $i < 6; $i++)
                <tr>
                    <td>{{ $i + 1 }}{{ ['st', 'nd', 'rd', 'th', 'th', 'th'][$i] }} Disbursement</td>
                    <td>₹ {{ number_format($workingCommitteeApproval->yearly_amounts[$i] ?? 0) }}</td>
                    <td>{{ $workingCommitteeApproval->yearly_dates[$i] ?? '' }}</td>
                </tr>
            @endfor
        </table>

        <!-- STEP 2 & STEP 3 -->
        <p class="section-title">STEP 2: FOR ANY QUERIES</p>
        <p>Send a clear and proper email to: <strong>support.jeap1@jito.org</strong></p>
        <p>We will respond within 24–48 working hours.</p>
        <p>If no reply within timeframe, send a gentle email reminder only.</p>

        <p class="section-title">STEP 3: FOR PHONE CALLS</p>
        <p>
            Calls will be answered only on: Monday to Friday | 4:00 PM to 5:00 PM<br>
            Please contact Mr. Guruprasad Ganapuram at <strong>8879519845</strong>
            for any queries or further assistance.
        </p>
        <p>Outside these hours, please email your concerns.</p>

        <p>
            <strong>Physical file Sending Address :</strong><br>
            JITO HOUSE, Plot No. A-56, Road No. 1, MIDC MAROL,<br>
            Near International Tunga Hotel, Mulgaon,<br>
            Andheri (East), Mumbai - 400 093
        </p>

        <p class="section-title">IMPORTANT NOTES:</p>
        <p>
            Read your sanction letter thoroughly before contacting us.
            Avoid calling or mailing without understanding the contents of the letter.
            Do not send documents, cheque images, or approval requests on WhatsApp.
            All official communication must be sent via email only.
        </p>
        <p>
            We are continuously learning and striving to make our processes more efficient
            and transparent. Your cooperation in following these guidelines helps us serve you better.
        </p>
        <p>Thank you for your understanding and support.</p>

        <p class="section-title">
            PLEASE SUBMIT THE FOLLOWING DOCUMENTS IN AN A4 SIZE ALONG WITH POST DATED CHEQUES (PDCs):
        </p>

        <ol>
            <li>List Of Documents (Do's and Don'ts): Submit all documents mentioned in this list</li>
            <li>Sanction Letter</li>
            <li>Payment Letter</li>
            <li>Affidavit cum Undertaking – Form A</li>
            <li>Promissory Note – Form B</li>
            <li>Advance Receipt – Form C</li>
            <li>Guarantor Form – Form D</li>
            <li>Bank Verification</li>
        </ol>

        <p class="section-title">HOW YOU WILL GET DISBURSEMENT?</p>
        <p>
            Once we receive the set of Documents & Post-Dated Cheques in a file
            with proper sequence in order as per our sanction letter,
            we will do the disbursement stated below.
        </p>
        <p>Domestic Disbursement – Full amount</p>
        <p>
            Foreign Disbursement – Partly 50% before and remaining 50% after
            student reaching other country after uploading Immigration copy +
            College fees receipt on JEAP application portal under
            ‘Third Stage Document Tab’.
        </p>

        <p class="section-title">
            HOW TO FILL CHEQUES DETAILS IN ‘POST DATED CHEQUE DETAILS’ TAB?
        </p>

        <ol>
            <li>Go to JITO JEAP website</li>
            <li>Login to your application</li>
            <li>To open the application, click on Application Number or Applicant Name</li>
            <li>Click on Edit button</li>
            <li>Go to ‘POST DATED CHEQUE DETAILS’</li>
            <li>Scroll down and click on Add a line button</li>
            <li>Enter cheque details as per mentioned columns</li>
            <li>
                Click on ‘SUBMIT POST DATED CHEQUE DETAILS’ and then click on Save
            </li>
        </ol>

        <table>
            <tr>
                <th>Sr No.</th>
                <th>Student Name</th>
                <th>If Parent Jnt A/c Name</th>
                <th>Repayment Date</th>
                <th>Amount in Rupees</th>
                <th>Bank Name</th>
                <th>IFSC Code</th>
                <th>Account Number</th>
                <th>Cheque Number</th>
                <th>Application Number</th>
            </tr>
        </table>

        <p>
            <strong>WARNING:</strong>
            If PDC cheque details under POST DATED CHEQUE DETAILS tab are found empty,
            disbursement will be delayed by 15–20 working days strictly.
        </p>

        <div class="page-break"></div>

        <p class="section-title">HOW TO SEND DOCUMENTS?</p>

        <ol>
            <li>
                ‘FORM A’ must be printed on Rs. 500 stamp paper for Maharashtra applicants
                and Rs. 100 for others, and must be registered and notarized.
            </li>
            <li>
                If documents are received without a file, disbursement may be delayed.
            </li>
            <li>
                Arrange documents in an A4 size file strictly as per the list and number each document.
            </li>
        </ol>

        <p class="section-title">
            IMPORTANT POINTS TO KEEP IN MIND WHILE PREPARING CHEQUES
        </p>

        <ol>
            <li>
                Cheques must be from student’s bank account (18+),
                single or joint with parent (student name first).
            </li>
            <li>Cheques must be written using BLUE BALL PEN only.</li>
            <li>Cheque payee name: JITO Education Assistance Foundation.</li>
            <li>All cheque details must be complete and clearly visible.</li>
            <li>Only nationalized and approved private banks are accepted.</li>
            <li>Do not send cheque book — only individual cheque leaves.</li>
            <li>Overwritten or stapled cheques will be rejected.</li>
        </ol>

        <p>
            <strong>NOTE:</strong>
            Cheques filled in any color other than blue ink will be returned.
            Signature must match the bank verification letter.
        </p>

        <div class="page-break"></div>

        <p class="section-title">WHAT IS PAYMENT LETTER?</p>

        <ol>
            <li>Proof of submission of cheques with complete information.</li>
            <li>
                Must include first PDC date, sanctioned amount, bank name,
                cheque numbers, installment amount, applicant details.
            </li>
            <li>
                Upload photo of first cheque and payment letter for reference.
            </li>
        </ol>

        <p class="section-title">ONLY FOR FOREIGN APPLICANTS</p>

        <ol>
            <li>
                VISA and flight ticket can be submitted later,
                but disbursement happens only after submission.
            </li>
            <li>
                After 50% disbursement, third stage documents must be submitted.
            </li>
        </ol>

        <p class="section-title">
            HOW TO UPDATE THIRD STAGE DETAILS IN ‘THIRD STAGE DOCUMENT TAB’?
        </p>

        <ol>
            <li>Login to JITO JEAP website</li>
            <li>Open your application</li>
            <li>Click Edit</li>
            <li>Go to ‘Third Stage Documents Tab’</li>
            <li>Upload immigration copy and fees receipt</li>
            <li>Submit and save</li>
        </ol>

        <p>
            <strong>Disclaimer:</strong>
            JEAP reserves the right to modify or cancel the sanctioned amount.
            This sanction letter is valid for 30 days only.
        </p>

        <p><strong>Wishing you best of luck,</strong></p>
        <p>Thanks and Regards,<br><strong>Hon. Secretary</strong></p>


    </div>
</body>

</html>
