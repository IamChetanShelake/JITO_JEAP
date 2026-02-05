@extends('admin.layouts.master')

@section('title', 'Disbursement Dashboard - JITO JEAP')

@section('styles')
<style>
    .disbursement-summary {
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
        color: white;
    }

    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .summary-card.total {
        background: linear-gradient(135deg, #393185 0%, #5b5ba8 100%);
    }

    .summary-card.disbursed {
        background: linear-gradient(135deg, #009846 0%, #00b359 100%);
    }

    .summary-card.remaining {
        background: linear-gradient(135deg, #FBBA00 0%, #ffcd33 100%);
        color: #333;
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

    .status-pending {
        background: #fff8e1;
        color: #f57c00;
    }

    .status-completed {
        background: #e8f5e9;
        color: #388e3c;
    }

    .status-in-progress {
        background: #e3f2fd;
        color: #1976d2;
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

    .student-row {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .student-row:hover {
        background-color: #f8f9fa !important;
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
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">
                <i class="fas fa-money-bill-wave me-2"></i>
                Disbursement Dashboard
            </h1>
            <p class="dashboard-subtitle">Accounts Department</p>
        </div>
        <a href="{{ route('admin.home') }}" class="change-country-btn">
            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
        </a>
    </div>

    <!-- Status Summary Cards -->
    <div class="disbursement-summary">
        <div class="row g-3">
            <div class="col-md-4">
                <a href="{{ route('admin.disbursement.pending') }}" style="text-decoration: none; color: inherit; display: block;">
                    <div class="summary-card" style="background: #fff8e1; color: #f57c00;">
                        <div class="summary-label">Ready for Disbursement</div>
                        <div class="summary-value">{{ $pendingCount }}</div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.disbursement.in_progress') }}" style="text-decoration: none; color: inherit; display: block;">
                    <div class="summary-card" style="background: #e3f2fd; color: #1976d2;">
                        <div class="summary-label">In Progress</div>
                        <div class="summary-value">{{ $inProgressCount }}</div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.disbursement.completed') }}" style="text-decoration: none; color: inherit; display: block;">
                    <div class="summary-card" style="background: #e8f5e9; color: #388e3c;">
                        <div class="summary-label">Completed</div>
                        <div class="summary-value">{{ $completedCount }}</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Section 2: Student List Table -->
    <div class="student-table-container">
        <div class="table-header">
            <div class="table-title">
                <i class="fas fa-users me-2"></i>
                @if(isset($filter) && $filter === 'completed')
                    Students with Completed Disbursement
                @elseif(isset($filter) && $filter === 'in_progress')
                    Students with Disbursement In Progress
                @elseif(isset($filter) && $filter === 'pending')
                    Students Ready for Disbursement
                @else
                    All Students Ready for Disbursement
                @endif
            </div>
            @if(isset($filter))
                <a href="{{ route('admin.disbursement.index') }}" class="btn btn-secondary btn-sm">
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
                            <th>Total Installments</th>
                            <th>Planned Amount</th>
                            <th>Disbursed Amount</th>
                            <th>Remaining Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr class="student-row" onclick="window.location.href='/admin/disbursement/user/{{ $student->user_id }}'">
                            <td>
                                <span class="fw-bold">{{ $student->user_id }}</span>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $student->name }}</div>
                            </td>
                            <td>{{ $student->total_installments }}</td>
                            <td class="fw-bold">₹{{ number_format($student->total_planned_amount, 2) }}</td>
                            <td>
                                @if($student->total_disbursed_amount > 0)
                                    <span class="text-success">₹{{ number_format($student->total_disbursed_amount, 2) }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($student->remaining_amount > 0)
                                    <span class="text-warning">₹{{ number_format($student->remaining_amount, 2) }}</span>
                                @else
                                    -
                                @endif
                            </td>
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
                                    <span class="status-badge status-pending">
                                        <i class="fas fa-clock me-1"></i>
                                        Ready
                                    </span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn-view" onclick="event.stopPropagation(); window.location.href='/admin/disbursement/user/{{ $student->user_id }}'">
                                    <i class="fas fa-eye me-1"></i> View & Disburse
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
