@extends('admin.layouts.master')

@section('title', 'Total Applications - JitoJeap Admin')

@section('styles')
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

    .page-title-section {
        display: flex;
        flex-direction: column;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--primary-purple);
        margin-bottom: 0.25rem;
        display: flex;
        align-items: center;
    }

    @media (min-width: 768px) {
        .page-title {
            font-size: 1.75rem;
        }
    }

    .page-subtitle {
        color: var(--text-light);
        font-size: 0.9rem;
    }

    @media (min-width: 768px) {
        .page-subtitle {
            font-size: 0.95rem;
        }
    }

    .back-btn {
        background-color: var(--primary-purple);
        color: white;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: 0 2px 8px rgba(57, 49, 133, 0.3);
        width: 100%;
        font-size: 0.9rem;
    }

    @media (min-width: 768px) {
        .back-btn {
            width: auto;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
        }
    }

    .back-btn:hover {
        background-color: #4a40a8;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(57, 49, 133, 0.4);
    }

    .back-btn i {
        font-size: 0.9rem;
    }

    .card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .table-container {
        position: relative;
        width: 100%;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: var(--primary-green) transparent;
    }

    .table-responsive::-webkit-scrollbar {
        height: 6px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background-color: var(--primary-purple);
        border-radius: 3px;
    }

    .table {
        width: 100%;
        min-width: 1000px;
        margin-bottom: 0;
        color: var(--text-dark);
    }

    .table thead th {
        background-color: var(--bg-light);
        color: var(--text-light);
        font-weight: 500;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--border-color);
        padding: 1rem;
        vertical-align: middle;
        white-space: nowrap;
        position: sticky;
        top: 0;
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
        color: #555;
        font-size: 0.9rem;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s ease;
    }

    .status-badge {
        padding: 0.35rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .status-approved {
        background: #e8f5e9;
        color: var(--primary-green);
    }

    .status-pending {
        background: #fff8e1;
        color: var(--primary-yellow);
    }

    .status-hold {
        background: #ffebee;
        color: var(--primary-red);
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #999;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #e0e0e0;
    }

    .actions-cell {
        display: flex;
        justify-content: center;
        gap: 0.2rem;
    }

    .action-btn.view-btn {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 0.1rem;
        transition: all 0.2s ease;
        cursor: pointer;
        font-size: 0.9rem;
        background-color: #e3f2fd;
        color: var(--primary-blue);
    }

    .action-btn.view-btn:hover {
        background-color: var(--primary-blue);
        color: white;
    }

    /* Mobile specific styles */
    @media (max-width: 767.98px) {
        .table-container {
            border-radius: 10px;
            overflow: hidden;
        }

        .table-responsive {
            border-radius: 10px;
        }

        .table {
            min-width: 100%;
        }

        /* Add shadow to indicate scrollability */
        .table-responsive {
            -webkit-mask-image: linear-gradient(to right, transparent 0%, black 5%, black 95%, transparent 100%);
            mask-image: linear-gradient(to right, transparent 0%, black 5%, black 95%, transparent 100%);
        }

        /* Scroll hint for mobile users */
        .scroll-hint {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.9);
            padding: 0.5rem;
            border-radius: 50% 0 0 50%;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
            z-index: 10;
            display: none;
        }

        .table-responsive:hover .scroll-hint {
            display: block;
        }
    }

    @media (min-width: 768px) {
        .scroll-hint {
            display: none !important;
        }
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="page-title-section">
        <h1 class="page-title">
            <i class="fas fa-users" style="color: var(--primary-purple); margin-right: 0.5rem;"></i>
            Total Applications
        </h1>
        <p class="page-subtitle">List of all applications</p>
    </div>
    <a href="{{ route('admin.home') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</div>

<div class="card">
    <div class="table-container">
        <div class="table-responsive">
            <div class="scroll-hint">
                <i class="fas fa-chevron-right" style="color: var(--primary-purple);"></i>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 5%;">Sr. No</th>
                        <th style="width: 15%;">Name</th>
                        <th style="width: 20%;">Aadhar Number</th>
                        <th style="width: 15%;">Financial Assistance Type</th>
                        <th style="width: 15%;">Financial Assistance For</th>
                        <th style="width: 15%;">Current Stage</th>
                        <th style="width: 10%;">Status</th>
                        {{-- <th style="width: 10%;">Actions</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @php
                        $users = \App\Models\User::with('workflowStatus')->where('role', 'user')->get();
                    @endphp
                    @forelse($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $user->name }}</strong>
                        </td>
                        <td>{{ $user->aadhar_card_number ?? $user->aadhar_number ?? 'N/A' }}</td>
                        <td>{{ $user->financial_asset_type ?? $user->financial_assistance_type ?? 'N/A' }}</td>
                        <td>{{ $user->financial_asset_for ?? $user->financial_assistance_for ?? 'N/A' }}</td>
                        <td>{{ $user->workflowStatus ? ucfirst(str_replace('_', ' ', $user->workflowStatus->current_stage)) : 'N/A' }}</td>
                        <td>
                            @if($user->workflowStatus)
                                @if($user->workflowStatus->final_status == 'approved')
                                    <span class="status-badge status-approved">
                                        <i class="fas fa-check-circle" style="font-size: 0.6rem;"></i>
                                        Approved
                                    </span>
                                @elseif($user->workflowStatus->final_status == 'rejected')
                                    <span class="status-badge status-hold">
                                        <i class="fas fa-exclamation-triangle" style="font-size: 0.6rem;"></i>
                                        Hold
                                    </span>
                                @else
                                    <span class="status-badge status-pending">
                                        <i class="fas fa-clock" style="font-size: 0.6rem;"></i>
                                        Pending
                                    </span>
                                @endif
                            @else
                                <span class="status-badge" style="background: #f0f0f0; color: #666;">N/A</span>
                            @endif
                        </td>
                        {{-- <td class="actions-cell">
                            <a href="{{ route('admin.user.detail', $user) }}" class="action-btn view-btn" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td> --}}
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>No applications found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
