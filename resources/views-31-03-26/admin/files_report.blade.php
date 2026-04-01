@extends('admin.layouts.master')

@section('title', 'Files Report - JitoJeap Admin')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        :root {
            --primary-green: #4CAF50;
            --primary-purple: #393185;
            --primary-blue: #2196F3;
            --primary-yellow: #FFC107;
            --primary-red: #f44336;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
            --bg-light: #f8f9fa;
            --border-color: #e9ecef;
        }

        .page-header {
            margin-bottom: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        @media (min-width: 768px) {
            .page-header {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-purple);
            margin: 0;
        }

        .filter-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: flex-end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-label {
            font-weight: 500;
            color: var(--text-dark);
            font-size: 0.9rem;
        }

        .form-input {
            padding: 0.6rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: border-color 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-purple);
        }

        .btn {
            padding: 0.6rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-search {
            background: var(--primary-purple);
            color: white;
        }

        .btn-search:hover {
            background: #4a40a8;
        }

        .btn-export {
            background: var(--primary-green);
            color: white;
        }

        .btn-export:hover {
            background: #43a047;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .report-table th {
            background: var(--primary-yellow);
            color: var(--text-dark);
            font-weight: 600;
            padding: 1rem;
            text-align: left;
            border-bottom: 2px solid rgba(0, 0, 0, 0.1);
        }

        .report-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .report-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .report-table tr:nth-child(odd) {
            background: white;
        }

        .report-table tr:last-child td {
            border-bottom: none;
        }

        .amount-cell {
            font-weight: 600;
            color: var(--primary-green);
        }

        .count-cell {
            font-weight: 600;
        }

        .total-row {
            background: #e9ecef !important;
            font-weight: 700;
        }

        .total-row td {
            border-top: 2px solid var(--primary-purple);
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .summary-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border-left: 4px solid var(--primary-purple);
        }

        .summary-card-title {
            font-size: 0.85rem;
            color: var(--text-light);
            margin-bottom: 0.5rem;
        }

        .summary-card-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .summary-card-value.amount {
            color: var(--primary-green);
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <h1 class="page-title">Files Report</h1>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <form method="GET" action="{{ route('admin.files.report') }}" class="filter-form">
                <div class="form-group">
                    <label class="form-label">From Date</label>
                    <input type="date" name="from_date" class="form-input"
                        value="{{ $fromDate ? $fromDate->toDateString() : '' }}">
                </div>
                <div class="form-group">
                    <label class="form-label">To Date</label>
                    <input type="date" name="to_date" class="form-input"
                        value="{{ $toDate ? $toDate->toDateString() : '' }}">
                </div>
                <button type="submit" class="btn btn-search">
                    <i class="fas fa-search"></i> Search
                </button>
                <a href="{{ route('admin.files.report') }}" class="btn" style="background: #6c757d; color: white;">
                    <i class="fas fa-times"></i> Clear
                </a>
                @if ($reportData)
                    <button type="submit" name="export" value="excel" class="btn btn-export">
                        <i class="fas fa-file-excel"></i> Download Report
                    </button>
                @endif
            </form>
        </div>

        @if ($reportData)
            <!-- Summary Cards -->
            <div class="summary-cards">
                @php
                    $totalFiles = collect($reportData)->sum('file_count');
                    $totalAmount = collect($reportData)->sum('amount');
                @endphp
                <div class="summary-card">
                    <div class="summary-card-title">Total Files</div>
                    <div class="summary-card-value">{{ $totalFiles }}</div>
                </div>
                <div class="summary-card">
                    <div class="summary-card-title">Total Amount</div>
                    <div class="summary-card-value amount">₹{{ number_format($totalAmount, 2) }}</div>
                </div>
            </div>

            <!-- Report Table -->
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Category</th>
                        <th>File Count</th>
                        <th>Amount (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reportData as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row['category'] }}</td>
                            <td class="count-cell">{{ $row['file_count'] }}</td>
                            <td class="amount-cell">{{ number_format($row['amount'], 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="2"><strong>Total</strong></td>
                        <td class="count-cell"><strong>{{ $totalFiles }}</strong></td>
                        <td class="amount-cell"><strong>₹{{ number_format($totalAmount, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        @else
            <div class="text-center" style="padding: 3rem; color: var(--text-light);">
                <i class="fas fa-folder-open" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <p>Select date range and click Search to view the report</p>
            </div>
        @endif
    </div>
@endsection
