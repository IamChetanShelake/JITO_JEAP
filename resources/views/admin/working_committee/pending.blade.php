@extends('admin.layouts.master')

@section('title', 'Working Committee - Pending Forms - JitoJeap Admin')

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
            min-width: 1200px;
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

        .below-one-lakh-row {
            background-color: #e8f1ff;
        }

        .below-one-lakh-row:hover {
            background-color: #d7e8ff !important;
        }

        .loan-type-badge {
            display: inline-block;
            padding: 0.3rem 0.7rem;
            border-radius: 14px;
            font-size: 0.8rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .loan-type-below {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .loan-type-above {
            background: #f3f4f6;
            color: #374151;
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

        .status-draft {
            background: #f5f5f5;
            color: #9e9e9e;
        }

        .action-btn {
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
        }

        .action-btn.view-btn {
            background-color: #e3f2fd;
            color: var(--primary-blue);
        }

        .action-btn.view-btn:hover {
            background-color: var(--primary-blue);
            color: white;
        }

        .action-btn.approve-btn {
            background-color: #e8f5e9;
            color: var(--primary-green);
        }

        .action-btn.approve-btn:hover {
            background-color: var(--primary-green);
            color: white;
        }

        .action-btn.reject-btn {
            background-color: #ffebee;
            color: var(--primary-red);
        }

        .action-btn.reject-btn:hover {
            background-color: var(--primary-red);
            color: white;
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

        . {
            display: flex;
            justify-content: center;
            gap: 0.2rem;
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
                <i class="fas fa-clock" style="color: var(--primary-yellow); margin-right: 0.5rem;"></i>
                Working Committee - Pending Forms
            </h1>
            <p class="page-subtitle">List of pending user forms from working committee stage</p>
        </div>
        <a href="{{ route('admin.home') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <div class="card">
        <div class="card-body" style="padding: 1.5rem; border-bottom: 1px solid var(--border-color);">
            <form method="GET" action="{{ route('admin.working_committee.pending') }}" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label" style="font-weight: 500; color: var(--text-dark);">Search</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               placeholder="Search by name, Aadhar number or application number..." 
                               value="{{ request('search') }}"
                               style="border-radius: 8px; border: 1px solid var(--border-color); padding: 0.6rem 1rem;">
                    </div>
                    <div class="col-md-3">
                        <label for="category" class="form-label" style="font-weight: 500; color: var(--text-dark);">Category</label>
                        <select class="form-select" id="category" name="category" 
                                style="border-radius: 8px; border: 1px solid var(--border-color); padding: 0.6rem 1rem;">
                            <option value="">All Categories</option>
                            <option value="above" {{ request('category') == 'above' ? 'selected' : '' }}>Above 100000</option>
                            <option value="below" {{ request('category') == 'below' ? 'selected' : '' }}>Below 100000</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="financial_assistance_type" class="form-label" style="font-weight: 500; color: var(--text-dark);">Foreign</label>
                        <select class="form-select" id="financial_assistance_type" name="financial_assistance_type" 
                                style="border-radius: 8px; border: 1px solid var(--border-color); padding: 0.6rem 1rem;">
                            <option value="">All Types</option>
                            <option value="domestic" {{ request('financial_assistance_type') == 'domestic' ? 'selected' : '' }}>Domestic</option>
                            <option value="foreign" {{ request('financial_assistance_type') == 'foreign' ? 'selected' : '' }}>Foreign Finance Assistant</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn w-100" 
                                style="background-color: var(--primary-purple); color: white; border-radius: 8px; padding: 0.6rem 1rem; font-weight: 500;">
                            <i class="fas fa-search me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="table-container">
            <div class="table-responsive">
                <div class="scroll-hint">
                    <i class="fas fa-chevron-right" style="color: var(--primary-purple);"></i>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">Seq</th>
                            <th style="width: 15%;">Name</th>
                            <th style="width: 18%;">Aadhar Number</th>
                            <th style="width: 12%;">Financial Assistance Type</th>
                            <th style="width: 12%;">Financial Assistance For</th>
                            <th style="width: 12%;">Category</th>
                            <th style="width: 10%;">Submitted Date</th>
                            <th style="width: 8%;">Status</th>
                            <th style="width: 10%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                            <tr class="{{ $user->loan_category_type === 'below' ? 'below-one-lakh-row' : '' }}">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                </td>
                                <td>{{ $user->aadhar_card_number }}</td>
                                <td>{{ $user->financial_asset_type
                    ? ucwords(str_replace('_', ' ', $user->financial_asset_type)) 
                    : 'N/A' }}</td>
                                <td>{{ $user->financial_asset_for 
                    ? ucwords(str_replace('_', ' ', $user->financial_asset_for)) 
                    : 'N/A' }}</td>
                                <td>
                                    <span
                                        class="loan-type-badge {{ $user->loan_category_type === 'below' ? 'loan-type-below' : ($user->loan_category_type === 'above' ? 'loan-type-above' : '') }}">
                                        {{ $user->loan_category_type === 'below' ? 'Below 1 Lakh' : ($user->loan_category_type === 'above' ? 'Above 1 Lakh' : 'N/A') }}
                                    </span>
                                </td>
                                <td>
                                    @if ($user->created_at)
                                        {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $status = 'Unknown';
                                        $statusClass = 'status-pending';
                                        $statusIcon = 'fas fa-clock';

                                        // Check workflow statuses first (highest priority)
                                        if (
                                            $user->workflowStatus &&
                                            $user->workflowStatus->final_status === 'approved'
                                        ) {
                                            $status = 'Final Approved';
                                            $statusClass = 'status-approved';
                                            $statusIcon = 'fas fa-check-double';
                                        } elseif (
                                            $user->workflowStatus &&
                                            $user->workflowStatus->working_committee_status === 'approved'
                                        ) {
                                            $status = 'Working Committee Approved';
                                            $statusClass = 'status-approved';
                                            $statusIcon = 'fas fa-check-circle';
                                        } elseif (
                                            $user->workflowStatus &&
                                            $user->workflowStatus->chapter_status === 'approved'
                                        ) {
                                            $status = 'Chapter Approved';
                                            $statusClass = 'status-approved';
                                            $statusIcon = 'fas fa-user-tie';
                                        } elseif (
                                            $user->workflowStatus &&
                                            $user->workflowStatus->apex_1_status === 'approved'
                                        ) {
                                            $status = 'Apex Approved';
                                            $statusClass = 'status-approved';
                                            $statusIcon = 'fas fa-user-check';
                                        } elseif (
                                            $user->workflowStatus &&
                                            $user->workflowStatus->final_status === 'rejected'
                                        ) {
                                            $status = 'Rejected';
                                            $statusClass = 'status-hold';
                                            $statusIcon = 'fas fa-times-circle';
                                        } elseif (
                                            $user->workflowStatus &&
                                            $user->workflowStatus->current_stage === 'apex_2'
                                        ) {
                                            $status = 'Apex 2 Pending';
                                            $statusClass = 'status-pending';
                                            $statusIcon = 'fas fa-user-tie';
                                        } elseif (
                                            $user->workflowStatus &&
                                            $user->workflowStatus->current_stage === 'working_committee'
                                        ) {
                                            $status = 'Working Committee Pending';
                                            $statusClass = 'status-pending';
                                            $statusIcon = 'fas fa-clock';
                                        } elseif (
                                            $user->workflowStatus &&
                                            $user->workflowStatus->current_stage === 'chapter'
                                        ) {
                                            $status = 'Chapter Pending';
                                            $statusClass = 'status-pending';
                                            $statusIcon = 'fas fa-clock';
                                        } elseif (
                                            $user->application_status === 'submitted' &&
                                            $user->submit_status === 'submited'
                                        ) {
                                            $status = 'Submitted';
                                            $statusClass = 'status-pending';
                                            $statusIcon = 'fas fa-paper-plane';
                                        } elseif ($user->application_status === 'draft') {
                                            $status = 'Draft';
                                            $statusClass = 'status-draft';
                                            $statusIcon = 'fas fa-edit';
                                        }
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">
                                        <i class="{{ $statusIcon }}" style="font-size: 0.6rem;"></i>
                                        {{ $status }}
                                    </span>
                                </td>
                                <td class="">
                                    <a href="{{ route('admin.working_committee.user.detail', $user) }}"
                                        class="action-btn view-btn" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    {{-- @if ((Auth::guard('committee')->check() && Auth::guard('committee')->user()->role == 'working-committee') || (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role == 'admin') || (Auth::guard('apex')->check() && Auth::guard('apex')->user()->role == 'apex'))
                            <form action="{{ route('admin.user.approve', ['user' => $user, 'stage' => 'working_committee']) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('POST')
                                <button type="submit" class="action-btn approve-btn" title="Approve" onclick="return confirm('Are you sure you want to approve this application?')">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <button type="button" class="action-btn reject-btn" title="Reject" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $user->id }}">
                                <i class="fas fa-times"></i>
                            </button>
                            @endif --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="empty-state">
                                    <i class="fas fa-clock"></i>
                                    <p>No pending forms found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($users as $user)
        <!-- Reject Modal -->
        <div class="modal fade" id="rejectModal{{ $user->id }}" tabindex="-1"
            aria-labelledby="rejectModalLabel{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel{{ $user->id }}">Reject Application -
                            {{ $user->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.user.reject', ['user' => $user, 'stage' => 'working_committee']) }}"
                        method="POST">
                        @csrf
                        @method('POST')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="admin_remark{{ $user->id }}" class="form-label">Admin Remark <span
                                        style="color: red;">*</span></label>
                                <textarea class="form-control" id="admin_remark{{ $user->id }}" name="admin_remark" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Resubmit Steps (Optional)</label>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="personal"
                                                id="personal{{ $user->id }}" name="resubmit_steps[]">
                                            <label class="form-check-label" for="personal{{ $user->id }}">
                                                Personal Details
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="education"
                                                id="education{{ $user->id }}" name="resubmit_steps[]">
                                            <label class="form-check-label" for="education{{ $user->id }}">
                                                Education Details
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="family"
                                                id="family{{ $user->id }}" name="resubmit_steps[]">
                                            <label class="form-check-label" for="family{{ $user->id }}">
                                                Family Details
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="funding"
                                                id="funding{{ $user->id }}" name="resubmit_steps[]">
                                            <label class="form-check-label" for="funding{{ $user->id }}">
                                                Funding Details
                                            </label>
                                        </div>
                                        @if($user->loan_category_type !== 'below')
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="guarantor"
                                                id="guarantor{{ $user->id }}" name="resubmit_steps[]">
                                            <label class="form-check-label" for="guarantor{{ $user->id }}">
                                                Guarantor Details
                                            </label>
                                        </div>
                                        @endif
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="documents"
                                                id="documents{{ $user->id }}" name="resubmit_steps[]">
                                            <label class="form-check-label" for="documents{{ $user->id }}">
                                                Documents
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Reject Application</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
