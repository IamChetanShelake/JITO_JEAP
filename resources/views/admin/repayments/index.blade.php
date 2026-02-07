@extends('admin.layouts.master')

@section('title', 'Repayment Dashboard - JITO JEAP')

@section('styles')
<style>
    .repayment-summary {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid #e0e0e0;
        margin-bottom: 1.5rem;
    }

    .summary-card {
        border-radius: 12px;
        padding: 1.25rem;
        text-align: center;
        height: 100%;
        transition: all 0.3s ease;
    }

    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .summary-label {
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
        opacity: 0.9;
    }

    .summary-value {
        font-size: 1.75rem;
        font-weight: 700;
    }

    .student-table-container {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid #e0e0e0;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .table-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
    }

    .status-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-ready {
        background: #e3f2fd;
        color: #1976d2;
    }

    .status-completed {
        background: #e8f5e9;
        color: #388e3c;
    }

    .status-in-progress {
        background: #fff8e1;
        color: #f57c00;
    }

    .btn-view {
        background: #393185;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-view:hover {
        background: #2d2d6b;
        transform: translateY(-2px);
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .alert-info {
        background: #e3f2fd;
        color: #1565c0;
        border: 1px solid #90caf9;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">
                <i class="fas fa-receipt me-2"></i>
                Repayment Dashboard
            </h1>
            <p class="dashboard-subtitle">Accounts Department</p>
        </div>
        <a href="{{ route('admin.home') }}" class="change-country-btn">
            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
        </a>
    </div>

    <div class="repayment-summary">
        <div class="row g-3">
            <div class="col-md-4">
                <a href="{{ route('admin.repayments.ready') }}" style="text-decoration: none; color: inherit; display: block;">
                    <div class="summary-card" style="background: #e3f2fd; color: #1976d2;">
                        <div class="summary-label">Ready for Repayment</div>
                        <div class="summary-value">{{ $readyCount }}</div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.repayments.in_progress') }}" style="text-decoration: none; color: inherit; display: block;">
                    <div class="summary-card" style="background: #fff8e1; color: #f57c00;">
                        <div class="summary-label">Repayment In Progress</div>
                        <div class="summary-value">{{ $inProgressCount }}</div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.repayments.completed') }}" style="text-decoration: none; color: inherit; display: block;">
                    <div class="summary-card" style="background: #e8f5e9; color: #388e3c;">
                        <div class="summary-label">Repayment Completed</div>
                        <div class="summary-value">{{ $completedCount }}</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="student-table-container">
        <div class="table-header">
            <div class="table-title">
                <i class="fas fa-users me-2"></i>
                @if(isset($filter) && $filter === 'completed')
                    Students with Repayment Completed
                @elseif(isset($filter) && $filter === 'in_progress')
                    Students with Repayment In Progress
                @elseif(isset($filter) && $filter === 'ready')
                    Students Ready for Repayment
                @else
                    All Students with Repayment Eligibility
                @endif
            </div>
            @if(isset($filter))
                <a href="{{ route('admin.repayments.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-times me-1"></i> Clear Filter
                </a>
            @endif
        </div>

        @if($students->isEmpty())
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                No students found for the selected filter.
            </div>
        @else
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Total Loan Amount</th>
                            <th>Total Disbursed</th>
                            <th>Total Repaid</th>
                            <th>Outstanding</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td><span class="fw-bold">{{ $student->user_id }}</span></td>
                            <td><div class="fw-bold">{{ $student->name }}</div></td>
                            <td class="fw-bold">Rs. {{ number_format($student->total_planned_amount, 2) }}</td>
                            <td>Rs. {{ number_format($student->total_disbursed_amount, 2) }}</td>
                            <td>Rs. {{ number_format($student->total_repaid_amount, 2) }}</td>
                            <td>Rs. {{ number_format($student->outstanding_amount, 2) }}</td>
                            <td>
                                @if($student->status === 'completed')
                                    <span class="status-badge status-completed">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Completed
                                    </span>
                                @elseif($student->status === 'in_progress')
                                    <span class="status-badge status-in-progress">
                                        <i class="fas fa-spinner me-1"></i>
                                        In Progress
                                    </span>
                                @else
                                    <span class="status-badge status-ready">
                                        <i class="fas fa-clipboard-check me-1"></i>
                                        Ready
                                    </span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn-view" onclick="window.location.href='{{ route('admin.repayments.show', ['user' => $student->user_id]) }}'">
                                    <i class="fas fa-eye me-1"></i> Show
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
