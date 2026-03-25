<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Financial Closure Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .container {
            width: 100%;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .details-table td {
            padding: 8px;
            vertical-align: top;
        }

        .details-table td.label {
            font-weight: bold;
            width: 40%;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .data-table th {
            background-color: #f2f2f2;
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .data-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .status-completed {
            color: green;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
        }

        .footer-left {
            float: left;
        }

        .footer-right {
            float: right;
        }

        .clearfix {
            clear: both;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- HEADER -->
        <div class="header">
            <h2>Financial Closure Report</h2>
            <p><strong>Team JEAP</strong></p>
        </div>

        <!-- ACCOUNT DETAILS -->
        <div class="section-title">Financial Assistance Account Details</div>

        <table class="details-table">
            <tr>
                <td class="label">Financial Assistance Account Number</td>
                <td>{{ $userNumber }}</td>
            </tr>
            <tr>
                <td class="label">Applicant Name</td>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <td class="label">Financial Assistance Sanction Amount</td>
                <td>₹ {{ number_format($totalExpected, 2) }}</td>
            </tr>
        </table>

        <!-- TRANSACTION DETAILS -->
        <div class="section-title">Closure Details</div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Principal Amount Received</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ \Carbon\Carbon::parse($closureDate)->format('d/m/Y') }}</td>
                    <td>₹ {{ number_format($totalPaid, 2) }}</td>
                    <td class="status-completed">Completed</td>
                </tr>
            </tbody>
        </table>

        <!-- SUMMARY -->
        <div class="section-title">Summary</div>

        <table class="details-table">
            <tr>
                <td class="label">Closure Date</td>
                <td>{{ \Carbon\Carbon::parse($closureDate)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="label">Total Paid</td>
                <td>₹ {{ number_format($totalPaid, 2) }}</td>
            </tr>
            <tr>
                <td class="label">Outstanding</td>
                <td>₹ 0.00</td>
            </tr>
        </table>

        <!-- FOOTER -->
        <div class="footer">
            <div class="footer-left">
                <p><strong>Team JEAP</strong></p>
            </div>



            <div class="clearfix"></div>
        </div>

    </div>

</body>

</html>
