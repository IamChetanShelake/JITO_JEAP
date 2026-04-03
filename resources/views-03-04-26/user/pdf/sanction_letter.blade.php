<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>JEAP Sanction Letter</title>

<style>
* {
  box-sizing: border-box;
  font-family: 'Times New Roman', Times, serif;
}

body {
  margin: 0;
  background: white;
  color: #000;
  line-height: 1.3;
}



/* HEADER */
.header {
  position: relative;
  margin-bottom: 20px;
}

.header-left {
  font-size: 14px;
  line-height: 1.4;
  color: #333;
}

.header-left h1 {
  font-size: 15px;
  color: #8B0000;
  margin-bottom: 3px;
  font-weight: bold;
  letter-spacing: 0.5px;
}

.header-right {
  position: absolute;
  top: 0;
  right: 0;
}

.header-right img {
  height: 50px;
  opacity: 0.9;
}

/* TITLE */
.center-title {
  text-align: start;
  font-weight: bold;
  font-size: 18px;
  margin: 25px 0 18px;
  color: #1a1a1a;
  letter-spacing: 1px;
  text-transform: uppercase;
}

/* INFO ROW */
.info-row {
  display: flex;
  justify-content: space-between;
  font-size: 16px;
  margin-bottom: 12px;
  color: #444;
}

/* CONTENT */
.content p {
  font-size: 18px;
  margin: 5px 0;
  line-height: 1.4;
  color: #333;
}

.bold {
  font-weight: bold;
}

.underline {
  text-decoration: underline;
  text-underline-offset: 2px;
}

/* TABLE */
table {
  width: 100%;
  border-collapse: collapse;
  margin: 12px 0;
  font-size: 14px;
  table-layout: auto;
  border: 1px solid #666;
}

th, td {
  border: 1px solid #666;
  padding: 5px 6px;
  word-wrap: break-word;
}

th {
  background: #f8f8f8;
  text-align: left;
  font-weight: bold;
  color: #333;
  font-size: 14px;
}

/* Document table specific */
/* Removed fixed widths for doc-table to use colgroup for responsive columns */

/* PDC Table - horizontal scroll if needed */
.pdc-table {
  font-size: 13px;
}

.pdc-table th,
.pdc-table td {
  padding: 3px 4px;
}

/* HIGHLIGHT */
.note {
  font-size: 14px;
  color: #2563eb;
  font-weight: bold;
  font-style: italic;
}

/* LIST */
ul {
  padding-left: 15px;
  font-size: 16px;
  line-height: 1.4;
}

ul li {
  margin-bottom: 2px;
}

/* RESPONSIVE - Removed table block display for PDF compatibility */
@media (max-width: 768px) {
  .header {
    flex-direction: column;
    gap: 10px;
  }

  .info-row {
    flex-direction: column;
    gap: 5px;
  }
}

/* PRINT */
@media print {
  body {
    background: #fff;
  }
  .page {
    border: none;
    margin: 0;
    padding-bottom: 30px; /* Space for footer */
  }

  /* PDF Footer using @page */
  @page {
    margin: 20mm 15mm 25mm 15mm; /* Top, Right, Bottom, Left */
    @bottom-center {
      content: "Page " counter(page) " / " counter(pages);
      font-size: 12px;
      font-family: 'Times New Roman', Times, serif;
      color: #666;
      text-align: start;
      border-top: 1px solid #666;
      padding-top: 5px;
      margin-top: 10px;
    }
  }

  /* Ensure tables display as tables in print */
  table, thead, tbody, th, td, tr {
    display: table !important;
  }
  thead {
    display: table-header-group !important;
  }
  tbody {
    display: table-row-group !important;
  }
  tr {
    display: table-row !important;
  }
  th, td {
    display: table-cell !important;
  }
  /* Override responsive styles for print */
  .header {
    position: relative !important;
  }
  .header-right {
    position: absolute !important;
    top: 0 !important;
    right: 0 !important;
  }
  .info-row {
    flex-direction: row !important;
  }

  /* Hide inline footers in print */
  .footer {
    display: none !important;
  }
}
</style>
</head>

<body>

<div class="page">

@php
$currentPage = 1;
@endphp

  <!-- HEADER -->
  <div class="header">
    <div class="header-left">
      <h1>JITO EDUCATION ASSISTANCE FOUNDATION</h1>
      JITO HOUSE,<br>
      Plot No. A-56, Road No. 1, MIDC MAROL,<br>
      Near International Tunga Hotel,<br>
      Andheri (East), Mumbai - 400 093<br>
      Email: support.jitojeap@jito.org<br>
      Website: www.jitojeap.in
    </div>

    <div class="header-right">
      <img src="{{ public_path('jitojeaplogo.png') }}" alt="JITO Logo">
    </div>
  </div>

  <!-- TITLE -->
  <div class="center-title">
    JITO EDUCATION ASSISTANCE PROGRAM
  </div>

  <!-- INFO -->
  <div class="info-row">
    <div><strong>Student Application No.:</strong> JITO-JEAP/2025/{{ $user->id }}</div>
    <div><strong>Date:</strong> {{ $workingCommitteeApproval->w_c_approval_date ? $workingCommitteeApproval->w_c_approval_date->format('d/m/Y') : now()->format('d/m/Y') }}</div>
  </div>

  <p class="content bold">
    Financial Asst Type: <span class="underline">{{ $educationDetail && $educationDetail->course_type ? strtoupper($educationDetail->course_type) . ' FINANCIAL ASSISTANCE' : 'FINANCIAL ASSISTANCE' }}</span>
  </p>

  <p class="content">
    Dear Mr/Ms. <span class="underline bold">{{ $user->name }}</span>,
  </p>

  <div style="page-break-inside: avoid;">
    <p class="content bold">CONGRATULATIONS:</p>

    <p class="content">
      We are pleased to inform you that an amount of
      <strong>Rs. {{ number_format($workingCommitteeApproval->approval_financial_assistance_amount, 0) }}</strong> has been sanctioned against your application
      for Higher Education under JEAP.
    </p>

    <!-- TABLE -->
    <table class="disbursement-table" style="page-break-inside: avoid;">
      <thead style="display: table-header-group;">
        <tr>
          <th>Disbursement</th>
          <th>Amount</th>
          <th>Disbursement Date</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        @php
          $disbursementSchedules = \Illuminate\Support\Facades\DB::connection('admin_panel')
              ->table('disbursement_schedules')
              ->where('user_id', $user->id)
              ->select('installment_no', 'status')
              ->get()
              ->keyBy('installment_no');
        @endphp
        @if($workingCommitteeApproval->disbursement_system === 'yearly' && $workingCommitteeApproval->yearly_dates && $workingCommitteeApproval->yearly_amounts)
          @foreach($workingCommitteeApproval->yearly_dates as $index => $date)
            @php
              $installmentNo = $index + 1;
              $scheduleStatus = $disbursementSchedules->get($installmentNo)->status ?? 'pending';
              $paymentLabel = $scheduleStatus === 'completed' ? 'Paid' : 'Unpaid';
            @endphp
            <tr>
              <td>{{ $index + 1 }}{{ $index == 0 ? 'st' : ($index == 1 ? 'nd' : ($index == 2 ? 'rd' : 'th')) }} Disbursement</td>
              <td>Rs. {{ number_format($workingCommitteeApproval->yearly_amounts[$index] ?? 0, 0) }} ({{ $paymentLabel }})</td>
              <td>{{ $index + 1 }}{{ $index == 0 ? 'st' : ($index == 1 ? 'nd' : ($index == 2 ? 'rd' : 'th')) }} Disbursement Date</td>
              <td>{{ $date ? \Carbon\Carbon::parse($date)->format('d/m/Y') : '-' }}</td>
            </tr>
          @endforeach
        @elseif($workingCommitteeApproval->disbursement_system === 'half_yearly' && $workingCommitteeApproval->half_yearly_dates && $workingCommitteeApproval->half_yearly_amounts)
          @foreach($workingCommitteeApproval->half_yearly_dates as $index => $date)
            @php
              $installmentNo = $index + 1;
              $scheduleStatus = $disbursementSchedules->get($installmentNo)->status ?? 'pending';
              $paymentLabel = $scheduleStatus === 'completed' ? 'Paid' : 'Unpaid';
            @endphp
            <tr>
              <td>{{ $index + 1 }}{{ $index == 0 ? 'st' : ($index == 1 ? 'nd' : ($index == 2 ? 'rd' : 'th')) }} Disbursement</td>
              <td>Rs. {{ number_format($workingCommitteeApproval->half_yearly_amounts[$index] ?? 0, 0) }} ({{ $paymentLabel }})</td>
              <td>{{ $index + 1 }}{{ $index == 0 ? 'st' : ($index == 1 ? 'nd' : ($index == 2 ? 'rd' : 'th')) }} Disbursement Date</td>
              <td>{{ $date ? \Carbon\Carbon::parse($date)->format('d/m/Y') : '-' }}</td>
            </tr>
          @endforeach
        @else
          <tr>
            <td>1st Disbursement</td>
            <td>₹ {{ number_format($workingCommitteeApproval->approval_financial_assistance_amount ?? 0, 0) }} (Paid)</td>
            <td>1st Disbursement Date</td>
            <td>{{ $workingCommitteeApproval->w_c_approval_date ? $workingCommitteeApproval->w_c_approval_date->format('d/m/Y') : '-' }}</td>
          </tr>
          <tr>
            <td>2nd Disbursement</td>
            <td>₹ 0.00</td>
            <td>2nd Disbursement Date</td>
            <td>-</td>
          </tr>
          <tr>
            <td>3rd Disbursement</td>
            <td>₹ 0.00</td>
            <td>3rd Disbursement Date</td>
            <td>-</td>
          </tr>
          <tr>
            <td>4th Disbursement</td>
            <td>₹ 0.00</td>
            <td>4th Disbursement Date</td>
            <td>-</td>
          </tr>
          <tr>
            <td>5th Disbursement</td>
            <td>₹ 0.00</td>
            <td>5th Disbursement Date</td>
            <td>-</td>
          </tr>
          <tr>
            <td>6th Disbursement</td>
            <td>₹ 0.00</td>
            <td>6th Disbursement Date</td>
            <td>-</td>
          </tr>
        @endif
      </tbody>
    </table>

    <p class="content">
      The repayment of Financial Assistance is in
      <strong>{{$workingCommitteeApproval->no_of_cheques_to_be_collected}} equal {{$workingCommitteeApproval->repayment_type}} installments of Rs. {{number_format($workingCommitteeApproval->installment_amount,0)}}</strong>
      commencing from <strong>{{$workingCommitteeApproval->repayment_starting_from ? \Carbon\Carbon::parse($date)->format('d/m/Y') : '-'}}</strong>.
        @if($workingCommitteeApproval->additional_installment_amount != 0 || $workingCommitteeApproval->additional_installment_amount != null)
            After the completion of the above installments, there will be an additional installment of Rs. {{ number_format($workingCommitteeApproval->additional_installment_amount, 0) }} to be paid in the last month of repayment.
        @endif
    </p>

    <p class="note">
      If we have approved the Financial assistance for the 2nd year,
      you will need to submit the required documents in 2nd year for
      disbursement of Financial assistance.
    </p>
  </div>

  <!-- STEPS -->
  <p class="bold underline">HOW TO START DOCUMENTATION PROCESS</p>

  <p class="bold">STEP 1:</p>
  <ul>
    <li>Read your Sanction Letter</li>
    <li>Download all attachments</li>
    <li>Go through the List of Documents PDF</li>
    <li>Submit all documents in A4 size file along with PDCs</li>
  </ul>

</div>
<!-- ================= PAGE 2 ================= -->
<div class="page">

  <!-- STEP 2 -->
  <p class="bold">STEP 2: For Any Queries</p>
  <ul>
    <li>Send a clear and proper email to:
      <strong>support.jeap1@jito.org</strong>
    </li>
    <li>We will respond within 24–48 working hours.</li>
    <li>If no reply within timeframe, send a gentle email reminder only.</li>
  </ul>

  <!-- STEP 3 -->
  <p class="bold">STEP 3: For Phone Calls</p>
  <ul>
    <li>
      Calls will be answered only on:
      <strong>Monday to Friday | 4:00 PM to 5:00 PM</strong><br>
      Please contact <strong>Mr. Guruprasad Ganapuram</strong> at
      <strong>8879519845</strong>
    </li>
    <li>Outside these hours, please email your concerns.</li>
  </ul>

  <!-- ADDRESS -->
  <p class="content">
    <strong>Physical File Sending Address: JITO HOUSE, Plot No. A-56, Road No. 1, MIDC MAROL, Near International Tunga Hotel,Andheri (East), Mumbai – 400 093</strong><br>
    {{-- JITO HOUSE, Plot No. A-56, Road No. 1, MIDC MAROL,<br> --}}
    {{-- Near International Tunga Hotel,<br>
    Andheri (East), Mumbai – 400 093 --}}
  </p>

  <!-- IMPORTANT NOTES -->
  <p class="bold underline">IMPORTANT NOTES:</p>
  <ul>
    <li>
      Read your sanction letter thoroughly before contacting us.
      Avoid calling or mailing without understanding the contents of the letter.
    </li>
    <li>
      Do not send documents, cheque images, or approval requests on WhatsApp.
      All official communication must be sent via email only.
    </li>
    <li>
      We are continuously learning and striving to make our processes more
      efficient and transparent. Your cooperation helps us serve you better.
    </li>
  </ul>

  <p class="content">
    Thank you for your understanding and support.
  </p>

  <!-- DOCUMENT LIST -->
  <p class="bold underline">
    PLEASE SUBMIT THE FOLLOWING DOCUMENTS IN AN A4 SIZE
    ALONG WITH POST DATED CHEQUES (PDCs):
  </p>

  <ol>
    <li>List of Documents (Do's and Don'ts)</li>
    <li>Sanction Letter</li>
    <li>Payment Letter</li>
    <li>Affidavit cum Undertaking – Form A</li>
    <li>Promissory Note – Form B</li>
    <li>Advance Receipt – Form C</li>
    <li>Guarantor Form – Form D</li>
    <li>Bank Verification</li>
  </ol>

  <!-- DISBURSEMENT -->
  <p class="bold underline">
    HOW YOU WILL GET DISBURSEMENT?
  </p>
  <p class="content">
    Once we receive the complete set of Documents and Post-Dated Cheques
    arranged properly as per the sanction letter, disbursement will be done
    as below:
  </p>

  <ul>
    <li><strong>Domestic Disbursement:</strong> Full Amount</li>
    <li>
      <strong>Foreign Disbursement:</strong>
      50% before travel and remaining 50% after student reaches the foreign
      country and uploads Immigration copy and College fee receipt under
      "Third Stage Document Tab".
    </li>
  </ul>

  <!-- PDC STEPS -->
  <p class="bold underline">
    How to Fill Cheque Details in 'POST DATED CHEQUE DETAILS' TAB?
  </p>

  <ol>
    <li>Go to JITO JEAP website</li>
    <li>Login to your application</li>
    <li>Click on Application number or Applicant Name</li>
    <li>Click on Edit button</li>
    <li>Go to 'POST DATED CHEQUE DETAILS'</li>
    <li>Scroll down and click on "Add a line"</li>
    <li>Enter cheque details as per columns</li>
    <li>
       Once you have entered all the cheque details then click on
      SUBMIT POST DATED CHEQUE DETAILS
      and then Save button.

    </li>
  </ol>

  <!-- PDC CHEQUE DETAILS TABLE -->
  <table class="pdc-table">
    <thead>
      <tr>
        <th>Sr No</th>
        <th>Student Name</th>
        <th>Account Name</th>
        <th>Repayment Date</th>
        <th>Amount</th>
        <th>Bank</th>
        <th>IFSC</th>
        <th>Account No</th>
        <th>Cheque No</th>
        <th>Application No</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td colspan="10" style="text-align:center;color:#666;">
          (To be filled by applicant in PDC Details Tab)
        </td>
      </tr>
    </tbody>
  </table>

  <!-- WARNING -->
  <p style="color:red;font-weight:bold;font-size:17px;">
    9) WARNING: IF WE FOUND THE PDC CHEQUE DETAILS UNDER POST DATED CHEQUES DETAILS
    TAB IS EMPTY THEN DISBURSEMENT WILL BE DELAYED BY 15–20 WORKING DAYS, STRICTLY.
  </p>



</div>

@php
$currentPage++;
@endphp
<!-- ================= PAGE 3 ================= -->
<div class="page">

  <!-- INTRO NOTES -->
  <ol style="font-size:16px;">
    <li>
      Please note that <strong>'FORM A'</strong> has to be printed on
      <strong>Rs. 500 stamp paper</strong> for Maharashtra Applicants and
      others it will be <strong>Rs. 100</strong> and also compulsory to be
      registered and notarized.
    </li>
    <li>
      If we receive the documents without the file then there can be delay in
      the disbursement of the funds.
    </li>
    <li>
      When you send the documents please make an <strong>A4 size file</strong>
      and arrange the documents as per the list attached in this sanction letter
      and number each document accordingly.
    </li>
  </ol>

  <!-- IMPORTANT CHEQUE RULES -->
  <p class="bold" style="color:red;">
    IMPORTANT POINTS TO KEEP IN MIND WHILE PREPARING CHEQUES:
  </p>

  <ol style="color:red;font-size:17px;">
    <li>
      Cheques must be submitted only from the <strong>Student bank account</strong>.
      It should be a Major account (Age 18+), Single or Joint account with parent.
      If joint, the primary name must be of the Student.
    </li>
    <li>
      Cheques must be written with a <strong>BLUE BALL PEN ONLY</strong>
      (Do not use Gel Pens).
    </li>
    <li>
      PDC (Post Dated Cheques) must be written in favor of:
      <strong>JITO Education Assistance Foundation</strong>.
    </li>
    <li>
      Cheques must include all details:
      Account Payee, Repayment Date, Payee Name, Amount in Words,
      Amount in Figures, Signature of Student/Parent (if joint account).
    </li>
    <li>
      Only Government Nationalized and Private Banks are accepted
      (HDFC, ICICI, Kotak, Axis, IDBI, Yes Bank, IDFC First Bank, etc.).
    </li>
    <li>
      If cheques are more than 15, make a rubber stamp of Payee name and stamp on it.
    </li>
    <li>
      Do not send cheque books. Send only cheque leaves as per dates.
    </li>
    <li>
      Overwriting, scribbling, and double signatures are not allowed.
    </li>
    <li>Do not staple the cheques.</li>
    <li>Submit only individual cheque leaves.</li>
    <li>Cheque books will not be accepted.</li>
  </ol>

  <!-- NOTE -->
  <p style="font-size:16px;">
    <strong>NOTE:</strong> Please fill the cheque neatly using a blue ball pen only.
    Cheques filled with any other color will be strictly returned.
    Ensure the signature matches the bank verification letter.
    Do not copy any information from the example cheque shown below.
  </p>

  <!-- CHEQUE IMAGE -->
  <div style="text-align:center;margin:20px 0;">
    <img
      src="{{ public_path('user/cheque.jpeg') }}"
      alt="Cheque Sample"
      style="max-width:100%;border:1px solid #ccc;"
    >
  </div>

  <!-- PRINT NOTE -->
  <p style="font-size:16px;text-align:center;">
    <strong>NOTE:</strong> If you are printing the cheque, ensure that all
    details are formatted and aligned exactly as shown in the example above.
    This cheque image is for reference only.
  </p>

</div>

<!-- ================= PAGE 4 ================= -->
<div class="page">

  <!-- CHEQUE IMAGE -->
  <div style="text-align:center;margin-bottom:20px;">
    <img
      src="{{ public_path('user/cheque2.jpeg') }}"
      alt="Payment Letter Cheque Sample"
      style="max-width:100%;border:1px solid #ccc;"
    >
  </div>

  <!-- PAYMENT LETTER -->
  <p class="bold" style="color:red;">WHAT IS PAYMENT LETTER?</p>

  <ol style="color:red;font-size:17px;">
    <li>
      Payment letter is the proof that you have submitted the cheques
      with complete information as per your sanctioned amount.
    </li>
    <li>
      You must mention the 1st PDC Date, Sanctioned amount, Bank Name,
      all cheques dates, Cheque number, Amount of equal installment,
      Applicant name, Applicant signature and Applicant Indian address.
    </li>
    <li>
      Kindly take the photo of the 1st cheque date and upload the Payment
      Letter for reference to fill all cheque details under
      <strong>Post Dated Cheques Details</strong>.
    </li>
  </ol>

  <!-- DOCUMENT FORMS -->
  <ol style="font-size:17px;">
    <li>
      Affidavit cum Undertaking (Form A)
      <br>
      <small>
        (FORM A must be printed on Rs. 500 stamp paper for Maharashtra
        Applicants, others Rs. 100, registered & notarized)
      </small>
    </li>
    <li>
      Promissory Note (Form B)
      <small>(Signed by applicant across Rs. 1 revenue stamp)</small>
    </li>
    <li>
      Advance Receipt (Form C)
      <small>(Signed by applicant across Rs. 1 revenue stamp)</small>
    </li>
    <li>
      Guarantor Form (Form D)
      <small>(Guarantors must be Jain, earning & aged 18–65)</small>
    </li>
    <li>
      Disbursed Approval Letter
      <small>(Applicant Name, Application Number, Full Sanction Amount)</small>
    </li>
    <li>
      Payment Letter
      <small>
        (Must be filled completely and signed by Student/Parent –
        Parent signature applicable only if POA submitted)
      </small>
    </li>
  </ol>

  <!-- FOREIGN APPLICANTS -->
  <p class="bold" style="color:red;">ONLY FOR FOREIGN APPLICANTS:</p>

  <ol style="color:red;font-size:17px;">
    <li>
      If you do not have VISA or Flight ticket now, you can submit later.
      Email VISA and Flight ticket to
      <strong>support.jeap1@jito.org</strong>
      with Application Number and Applicant Name.
      Disbursement will be done only after submission.
    </li>
    <li>
      After receiving 50% disbursement, you will receive an email within
      5 working days to submit Third Stage Documents.
    </li>
  </ol>

  <!-- THIRD STAGE -->
  <p class="bold underline">
    HOW TO UPDATE THIRD STAGE DETAILS IN
    'THIRD STAGE DOCUMENT TAB'?
  </p>

  <ol style="font-size:17px;">
    <li>Go to JITO JEAP website</li>
    <li>Login to your application</li>
    <li>Click Application Number or Applicant Name</li>
    <li>Click on Edit button</li>
    <li>Go to 'Third Stage Documents Tab'</li>
    <li>
      Scroll down to upload Immigration Copy,
      College paid fees receipt and basic details
    </li>
    <li>Update information as mentioned</li>
    <li>
      Click on <strong>Submit Third Stage Document</strong>
      and then Save
    </li>
  </ol>

  <!-- DISCLAIMER -->
  <p style="font-size:16px;">
    <strong>Disclaimer:</strong>
    JEAP reserves the right to hold, cancel or modify the sanctioned
    amount in case of policy or management changes.
    This sanction letter is valid for <strong>30 days only</strong>.
  </p>

  <p style="font-size:17px;">
    Dear Students / Parents,
  </p>



</div>

@php
$currentPage++;
@endphp

<!-- ================= PAGE 5 ================= -->
<div class="page page-break">

  <p class="text">
    Please note that Calls and WhatsApp messages will not be entertained for
    general queries unless it is an emergency. To ensure smooth workflow and
    maintain focus on our responsibilities related to disbursements and
    accounting, we request you to kindly follow the below communication protocol:
  </p>

  <!-- QUERIES -->
  <p class="heading">For All Queries:</p>
  <ul class="list">
    <li>Email your queries in proper sequence/order to
      <strong>support.jeap1@jito.org</strong>
    </li>
    <li>We aim to respond within <strong>24–48 working hours</strong>.</li>
    <li>If no reply is received within this timeframe, feel free to send a gentle reminder via email.</li>
  </ul>

  <!-- PHONE -->
  <p class="heading">For Phone Discussions:</p>
  <ul class="list">
    <li>
      Calls will be attended only between
      <strong>4:00 PM – 5:00 PM</strong> (Monday to Friday)
    </li>
    <li>
      Please contact <strong>Mr. Guruprasad Ganapuram</strong> at
      <strong>8879519845</strong> for any queries or further assistance
    </li>
    <li>Outside these hours, email is the only accepted communication mode.</li>
  </ul>

  <!-- COURIER -->
  <p class="text">
    You have to send courier from your choice like any normal courier,
    post, speed post, air, etc.
  </p>

  <!-- ADDRESS -->
  <p class="text">
    <strong>Physical File Sending Address:</strong><br>
    JITO HOUSE, Plot No. A-56, Road No. 1, MIDC MAROL,<br>
    Near International Tunga Hotel,<br>
    Andheri (East), Mumbai – 400 093
  </p>

  <!-- IMPORTANT NOTES -->
  <p class="heading">Important Notes:</p>
  <ul class="list">
    <li>
      Read your sanction letter thoroughly before contacting us.
      Avoid calling or mailing without understanding the contents.
    </li>
    <li>
      Do not send documents, cheque images, or approval requests on WhatsApp.
      All official communication must be sent via email only.
    </li>
    <li>
      We are continuously learning and striving to make our processes more
      efficient and transparent. Your cooperation helps us serve you better.
    </li>
  </ul>

  <!-- SIGN OFF -->
  <p class="text">Thank you for your understanding and support.</p>
  <p class="text"><strong>Wishing you best of luck,</strong></p>
  <p class="text">Thanks and Regards,</p>
  <p class="text"><strong>Hon. Secretary</strong></p>

  <!-- DOCUMENT TABLE -->
  <table class="doc-table" style="page-break-inside: avoid;">
    <colgroup>
      <col style="width: 5%;">
      <col style="width: 85%;">
      <col style="width: 10%;">
    </colgroup>
    <thead style="display: table-header-group;">
      <tr>
        <th>#</th>
        <th>List of Documents</th>
        <th>Submitted</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>
          JEAP SANCTION LETTER
          (Login → Application → Print & Download)
        </td>
        <td>☐</td>
      </tr>
      <tr>
        <td>2</td>
        <td>VISA Copy (Foreign Applicants Only)</td>
        <td>☐</td>
      </tr>
      <tr>
        <td>3</td>
        <td>
          Flight Ticket
          (Submit immediately or once booked – Foreign Applicants Only)
        </td>
        <td>☐</td>
      </tr>
      <tr>
        <td>4</td>
        <td>
          Payment Letter
          (Must be filled completely and signed by Student)
        </td>
        <td>☐</td>
      </tr>
      <tr>
        <td>5</td>
        <td>Student Bank Verification</td>
        <td>☐</td>
      </tr>
      <tr>
        <td>6</td>
        <td>
          Recommendation of JITO Member
          (Website format + Member Signature & UID compulsory)
        </td>
        <td>☐</td>
      </tr>

      <tr>
        <td>7</td>
        <td>
          Jain Sangh Certificate of Applicant
          (If already available, submit it or download format from website
          and submit with Sangh Stamp & Signature of Head Authority)
        </td>
        <td>☐</td>
      </tr>

      <tr>
        <td>8</td>
        <td>
          Affidavit cum Undertaking (Form A)
          (Printed on Rs. 500 stamp paper for Maharashtra Applicants,
          Rs. 100 for others, compulsory registration & notarization)
        </td>
        <td>☐</td>
      </tr>

      <tr>
        <td>9</td>
        <td>
          Promissory Note (Form B)
          (Signed by applicant across Rs. 1/- revenue stamp)
        </td>
        <td>☐</td>
      </tr>

      <tr>
        <td>10</td>
        <td>
          Advance Receipt (Form C)
          (Signed by applicant across Rs. 1/- revenue stamp)
        </td>
        <td>☐</td>
      </tr>

      <tr>
        <td>11</td>
        <td>Guarantor Form (Form D)</td>
        <td>☐</td>
      </tr>

      <tr>
        <td>12</td>
        <td>
          JEAP EF ASST. APPLICATION FORM
          (Login → Application → Click on Print and Download)
        </td>
        <td>☐</td>
      </tr>

      <tr>
        <td>13</td>
        <td>SSC Marksheet</td>
        <td>☐</td>
      </tr>

      <tr>
        <td>14</td>
        <td>HSC / Diploma Marksheet</td>
        <td>☐</td>
      </tr>

      <tr>
        <td>15</td>
        <td>
          Graduation Marksheet
          (Only for Post Graduation Applicant)
        </td>
        <td>☐</td>
      </tr>

      <tr>
        <td>16</td>
        <td>
          I-20 (Foreign Applicants Only)
          & Admission Letter & Fees Structure
        </td>
        <td>☐</td>
      </tr>

      <tr>
        <td>17</td>
        <td>
          Admission Letter & Fees Structure
          (Domestic Applicants Only)
        </td>
        <td>☐</td>
      </tr>

      <tr>
        <td>18</td>
        <td>
          Passport Copy – Student
          (Foreign Applicants Only)
        </td>
        <td>☐</td>
      </tr>

      <tr>
        <td>19</td>
        <td>PAN Card – Applicant (2 Copies)</td>
        <td>☐</td>
      </tr>

      <tr>
        <td>20</td>
        <td>Aadhaar Card – Applicant (2 Copies)</td>
        <td>☐</td>
      </tr>

      <tr>
        <td>21</td>
        <td>
          Student Main Bank Account Details and Statement
          for last 6 months / 1 year
          (If not available, submit passbook copy)
        </td>
        <td>☐</td>
      </tr>

      <tr>
        <td>22</td>
        <td>
          Latest Electricity Bill
          (If not self-owned house, submit Rent Agreement Xerox copy)
        </td>
        <td>☐</td>
      </tr>

      <tr>
        <td>23</td>
        <td>Aadhaar Card – Father / Mother / Guardian</td>
        <td>☐</td>
      </tr>

      <tr>
        <td>24</td>
        <td>PAN Card – Father / Mother / Guardian</td>
        <td>☐</td>
      </tr>

      <tr>
        <td>25</td>
        <td>
          ITR Acknowledgement + Computation of Income
          along with Profit & Loss and Balance Sheet
          of Father (Last 1 year – If Business)
        </td>
        <td>☐</td>
      </tr>

      <tr>
        <td>26</td>
        <td>
          Form No. 16 for Salary Income of Father
          (Last 1 year – If Salary)
        </td>
        <td>☐</td>
      </tr>
      <tr>
        <td>27</td>
        <td>
          Bank Statement of Father & Mother of Last 1 year
          (If not bank statement, submit passbook copy of last 1 year)
        </td>
        <td>☐</td>
      </tr>

      <tr>
        <td>28</td>
        <td>Aadhaar Card – Guarantor 1</td>
        <td>☐</td>
      </tr>

      <tr>
        <td>29</td>
        <td>PAN Card – Guarantor 1</td>
        <td>☐</td>
      </tr>

      <tr>
        <td>30</td>
        <td>Aadhaar Card – Guarantor 2</td>
        <td>☐</td>
      </tr>

      <tr>
        <td>31</td>
        <td>PAN Card – Guarantor 2</td>
        <td>☐</td>
      </tr>

      <tr>
        <td>32</td>
        <td>
          Proof of Funds Arranged / Taken / Approved
          other than JITO JEAP
        </td>
        <td>☐</td>
      </tr>

      <tr>
        <td>33</td>
        <td>
          Student handwritten statement stating reason
          for choosing course and institutes
        </td>
        <td>☐</td>
      </tr>

      <tr>
        <td>34</td>
        <td>
          Extra Curricular or Other Documents
          (If any achievements)
        </td>
        <td>☐</td>
      </tr>
    </tbody>
  </table>

</div>

<!-- ================= PAGE 6 ================= -->

<!-- ================= PAGE 7 ================= -->
<div class="page page-break">


  <!-- IMPORTANT NOTE -->
  <p class="heading" style="color:red;margin-top:16px;">
    IMPORTANT NOTE:
  </p>

  <ol style="color:red;font-size:17px;padding-left:18px;">
    <li>
      Request you to submit the documents in above given sequence only,
      along with numbering or bookmark with pen/pencil.
    </li>
    <li>
      Please make an <strong>A4 size file</strong> and keep all documents
      in a single bunch, arranged number-wise.
    </li>
    <li>
      If documents are not arranged properly,
      <strong>disbursement may be delayed</strong>.
    </li>
    <li>
      You might not have submitted all documents properly online,
      but after receiving the sanction letter you must submit documents
      as per this sanction list.
    </li>
    <li>
      Unless all documents are submitted physically as per the list above,
      <strong>JEAP will not be able to disburse the amount</strong>.
    </li>
  </ol>

</div>

</body>
</html>