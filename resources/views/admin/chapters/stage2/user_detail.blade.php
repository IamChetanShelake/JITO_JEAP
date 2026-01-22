
@extends('admin.layouts.master')


@section('title', 'Chapter User Details - JitoJeap Admin')

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

        .user-info-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(57, 49, 133, 0.1);
        }

        .user-info-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary-purple);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .user-details h3 {
            margin: 0;
            color: var(--text-dark);
            font-size: 1.25rem;
        }

        .user-details p {
            margin: 0.25rem 0;
            color: var(--text-light);
        }

        .steps-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .step-nav {
            background: var(--bg-light);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            overflow-x: auto;
            scrollbar-width: thin;
        }

        .step-nav-item {
            flex: 1;
            min-width: 120px;
            text-align: center;
            padding: 1rem 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
            position: relative;
        }

        .step-nav-item.active {
            background: white;
            border-bottom-color: var(--primary-purple);
            color: var(--primary-purple);
            font-weight: 600;
        }

        .step-nav-item.completed {
            background: #e8f5e9;
            border-bottom-color: var(--primary-green);
            color: var(--primary-green);
        }

        .step-nav-item.pending {
            background: #fff8e1;
            border-bottom-color: var(--primary-yellow);
            color: var(--primary-yellow);
        }

        .step-nav-item.hold {
            background: #ffebee;
            border-bottom-color: var(--primary-red);
            color: var(--primary-red);
        }

        .step-number {
            display: block;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.25rem;
        }

        .step-title {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .step-content {
            padding: 2rem;
            display: none;
        }

        .step-content.active {
            display: block;
        }

        .step-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .step-title-large {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .step-status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-badge {
            padding: 0.5rem 1rem;
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

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn-approve {
            background: var(--primary-green);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-approve:hover {
            background: #45a049;
            transform: translateY(-1px);
        }

        .btn-hold {
            background: var(--primary-red);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-hold:hover {
            background: #d32f2f;
            transform: translateY(-1px);
        }

        .form-data {
            background: white;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .data-group {
            border-bottom: 1px solid var(--border-color);
        }

        .data-group:last-child {
            border-bottom: none;
        }

        .data-group h4 {
            background: var(--primary-purple);
            color: white;
            margin: 0;
            padding: 1rem 1.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .form-section {
            padding: 1.5rem;
        }

        .form-row {
            display: flex;
            gap: 2rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .form-row:last-child {
            margin-bottom: 0;
        }

        .form-field {
            flex: 1;
            min-width: 250px;
        }

        .form-field-full {
            width: 100%;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input,
        .form-textarea,
        .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            font-size: 0.9rem;
            color: var(--text-dark);
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }

        .form-input:focus,
        .form-textarea:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--primary-purple);
            background-color: white;
            box-shadow: 0 0 0 3px rgba(57, 49, 133, 0.1);
        }

        .form-input[readonly],
        .form-textarea[readonly],
        .form-select[readonly] {
            background-color: #f8f9fa;
            cursor: not-allowed;
            border-color: #dee2e6;
        }

        .form-textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-link {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .form-link:hover {
            color: var(--primary-purple);
            text-decoration: underline;
        }

        .form-image {
            max-width: 120px;
            max-height: 120px;
            border: 2px solid #dee2e6;
            border-radius: 6px;
            object-fit: cover;
        }

        .table-container {
            margin-top: 1rem;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        .custom-table th,
        .custom-table td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .custom-table th {
            background-color: var(--bg-light);
            font-weight: 600;
            color: var(--text-dark);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.8rem;
        }

        .custom-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .amount-cell {
            font-weight: 600;
            color: var(--primary-green);
        }

        .status-cell {
            font-weight: 500;
        }

        .status-approved {
            color: var(--primary-green);
        }

        .status-pending {
            color: var(--primary-yellow);
        }

        .status-rejected {
            color: var(--primary-red);
        }

        .no-data {
            text-align: center;
            padding: 2rem;
            color: var(--text-light);
            font-style: italic;
        }

        .data-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #e9ecef;
        }

        .data-item:last-child {
            border-bottom: none;
        }

        .data-label {
            font-weight: 600;
            color: var(--text-dark);
            flex: 1;
        }

        .data-value {
            color: var(--text-light);
            flex: 1;
            text-align: right;
        }

        .table-container {
            margin-top: 1rem;
            overflow-x: auto;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        .custom-table th,
        .custom-table td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .custom-table th {
            background-color: var(--bg-light);
            font-weight: 600;
            color: var(--text-dark);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.8rem;
        }

        .custom-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Professional Workflow Status Styles */
        .workflow-status-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--bg-light);
        }

        .workflow-status-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-purple), var(--primary-blue));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(57, 49, 133, 0.3);
        }

        .workflow-stage-info h3 {
            margin: 0;
            color: var(--text-dark);
            font-size: 1.4rem;
            font-weight: 600;
        }

        .workflow-stage-info p {
            margin: 0.25rem 0;
            color: var(--text-light);
            font-size: 0.95rem;
        }

        .workflow-stage-info .status-highlight {
            font-weight: 600;
            color: var(--primary-purple);
        }

        .workflow-action-card {
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            border-radius: 12px;
            padding: 2rem;
            margin-top: 1.5rem;
            border: 1px solid rgba(57, 49, 133, 0.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
        }

        .action-title {
            color: var(--primary-purple);
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .action-title::before {
            content: "⚖️";
            font-size: 1.2rem;
        }

        .action-form {
            margin-bottom: 1.5rem;
        }

        .remark-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 0.9rem;
            color: var(--text-dark);
            background-color: #f8f9fa;
            transition: all 0.3s ease;
            resize: vertical;
            min-height: 80px;
        }

        .remark-input:focus {
            outline: none;
            border-color: var(--primary-purple);
            background-color: white;
            box-shadow: 0 0 0 3px rgba(57, 49, 133, 0.1);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            min-width: 140px;
            justify-content: center;
        }

        .btn-approve {
            background: linear-gradient(135deg, var(--primary-green), #4caf50);
            color: white;
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
        }

        .btn-approve:hover {
            background: linear-gradient(135deg, #4caf50, #45a049);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(76, 175, 80, 0.4);
        }

        .btn-reject {
            background: linear-gradient(135deg, var(--primary-red), #e53935);
            color: white;
            box-shadow: 0 4px 12px rgba(244, 67, 54, 0.3);
        }

        .btn-reject:hover {
            background: linear-gradient(135deg, #e53935, #d32f2f);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(244, 67, 54, 0.4);
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(57, 49, 133, 0.2), transparent);
            margin: 1.5rem 0;
            position: relative;
        }

        .divider::after {
            content: "OR";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 0 1rem;
            color: var(--text-light);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .action-form-row {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .action-form-row .remark-input {
            flex: 1;
            min-width: 250px;
        }

        .action-form-row .btn {
            align-self: flex-end;
        }

        @media (max-width: 768px) {
            .action-form-row {
                flex-direction: column;
            }

            .action-form-row .btn {
                align-self: stretch;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-title-section">
            <h1 class="page-title">
                <i class="fas fa-user" style="color: var(--primary-purple); margin-right: 0.5rem;"></i>
                Chapter User Details
            </h1>
            <p class="page-subtitle">Review and approve chapter steps</p>
        </div>
        <a href="{{ route('admin.home') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <!-- User Info Card -->
    <div class="user-info-card">
        <div class="user-info-header">
            <div class="user-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="user-details">
                <h3>{{ $user->name }}</h3>
                <p>{{ $user->email }}</p>
                <p>{{ $user->mobile }}</p>
            </div>
        </div>
    </div>

    <!-- Workflow Status Card -->
    <div class="user-info-card">
        <div class="workflow-status-header">
            <div class="workflow-status-icon">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="workflow-stage-info">
                <h3>Workflow Status</h3>
                <p><strong>Current Stage:</strong> <span
                        class="status-highlight">{{ $user->workflowStatus ? ucfirst(str_replace('_', ' ', $user->workflowStatus->current_stage)) : 'N/A' }}</span>
                </p>
                <p><strong>Final Status:</strong> <span
                        class="status-highlight">{{ $user->workflowStatus ? ucfirst($user->workflowStatus->final_status) : 'N/A' }}</span>
                </p>
            </div>
        </div>

        @if (
            $user->workflowStatus &&
                (($user->workflowStatus->current_stage === 'chapter' &&
                    $user->workflowStatus->final_status === 'in_progress') ||
                    in_array($user->workflowStatus->chapter_status, ['approved', 'rejected'])))

            <div class="data-group">
                {{-- <h4>Final Chapter Decision</h4> --}}
                <div class="form-section">

                    {{-- Show decision result if already decided --}}
                    @if ($user->workflowStatus->chapter_status === 'approved')
                        <div class="workflow-action-card">
                            <h4 class="action-title">Chapter Decision - Approved</h4>
                            <div
                                style="padding: 2rem; background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); border-radius: 12px; border: 2px solid #4CAF50;">
                                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                                    <i class="fas fa-check-circle" style="color: #2E7D32; font-size: 2rem;"></i>
                                    <div>
                                        <h5 style="color: #2E7D32; margin: 0; font-size: 1.2rem;">Application Approved</h5>
                                        <p style="color: #2E7D32; margin: 0.25rem 0 0 0;">Chapter decision has been made
                                            successfully</p>
                                    </div>
                                </div>

                                <div
                                    style="background: rgba(76, 175, 80, 0.1); padding: 1rem; border-radius: 8px; margin-top: 1rem;">
                                    <div
                                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                                        <div>
                                            <strong style="color: #2E7D32;">Interview Date:</strong><br>
                                            {{ $inter_date ? \Carbon\Carbon::parse($inter_date->updated_at)->format('d M Y') : 'N/A' }}
                                        </div>
                                        <div>
                                            <strong style="color: #2E7D32;">Total Expense:</strong><br>
                                            ₹{{ $data ? number_format($data->group_4_total) : 'N/A' }}
                                        </div>
                                        <div>
                                            <strong style="color: #2E7D32;">Assistance Amount:</strong><br>
                                            ₹{{ $user->workflowStatus->chapter_assistance_amount ? number_format($user->workflowStatus->chapter_assistance_amount) : 'N/A' }}
                                        </div>
                                    </div>
                                </div>



                                <div
                                    style="margin-top: 1rem; padding: 0.5rem; background: rgba(255,255,255,0.6); border-radius: 6px; text-align: center;">
                                    <small style="color: #666;">Approved on:
                                        {{ $user->workflowStatus->chapter_updated_at ? \Carbon\Carbon::parse($user->workflowStatus->chapter_updated_at)->format('d M Y H:i') : 'N/A' }}</small>
                                </div>
                            </div>
                        @elseif($user->workflowStatus->chapter_status === 'rejected')
                            <div class="workflow-action-card">
                                <h4 class="action-title">Chapter Decision - Rejected</h4>
                                <div
                                    style="padding: 2rem; background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%); border-radius: 12px; border: 2px solid #f44336;">
                                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                                        <i class="fas fa-times-circle" style="color: #c62828; font-size: 2rem;"></i>
                                        <div>
                                            <h5 style="color: #c62828; margin: 0; font-size: 1.2rem;">Application Rejected
                                            </h5>
                                            <p style="color: #c62828; margin: 0.25rem 0 0 0;">Chapter decision has been made
                                            </p>
                                        </div>
                                    </div>

                                    @if ($user->workflowStatus->chapter_reject_remarks)
                                        <div
                                            style="margin-top: 1rem; padding: 1rem; background: rgba(255,255,255,0.8); border-radius: 8px;">
                                            <strong style="color: #c62828;">Rejection Remarks:</strong><br>
                                            <p style="margin: 0.5rem 0 0 0; color: #2c3e50;">
                                                {{ $user->workflowStatus->chapter_reject_remarks }}</p>
                                        </div>
                                    @endif

                                    <div
                                        style="margin-top: 1rem; padding: 0.5rem; background: rgba(255,255,255,0.6); border-radius: 6px; text-align: center;">
                                        <small style="color: #666;">Rejected on:
                                            {{ $user->workflowStatus->chapter_updated_at ? \Carbon\Carbon::parse($user->workflowStatus->chapter_updated_at)->format('d M Y H:i') : 'N/A' }}</small>
                                    </div>
                                </div>
                            @else
                                {{-- Show the decision form for pending approval --}}
                                <div
                                    style="padding: 2rem; background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%); border-radius: 12px; border: 1px solid rgba(57, 49, 133, 0.1); box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06); margin-top: 1.5rem;">
                                    <h4 class="action-title">Chapter Decision</h4> --}}

                                    <!-- Approve Form -->
                                    {{-- <div class="action-form-row">
                <textarea name="admin_remark"
                          placeholder="Approval remark (optional but recommended)"
                          rows="3"
                          class="remark-input"></textarea>
                <form action="{{ route('admin.user.approve', ['user' => $user, 'stage' => 'chapter']) }}"
                      method="POST">
                    @csrf
                    <input type="hidden" name="admin_remark" id="approve_remark">
                    <button type="submit" class="btn btn-approve">
                        <i class="fas fa-check"></i>
                        Approve Chapter
                    </button>
                </form>
            </div>

            <div class="divider"></div>

            <!-- Reject Form -->
            <div class="action-form-row">
                <textarea name="admin_remark"
                          placeholder="Rejection remark (required)"
                          rows="3"
                          class="remark-input"
                          required></textarea>
                <form action="{{ route('admin.user.reject', ['user' => $user, 'stage' => 'chapter']) }}"
                      method="POST">
                    @csrf
                    <input type="hidden" name="admin_remark" id="reject_remark">
                    <button type="submit" class="btn btn-reject">
                        <i class="fas fa-times"></i>
                        Reject Chapter
                    </button>
                </form>
            </div> --}}
                                </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Success/Error Messages Display -->


    <!-- Steps Container -->
    <div class="steps-container">
        <!-- Step Navigation -->
        <div class="step-nav">

            <div class="step-nav-item active step-1" onclick="showStep(1)">
                <span class="step-number">1</span>
                <span class="step-title">Personal Details</span>
            </div>
            <div class="step-nav-item step-2" onclick="showStep(2)">
                <span class="step-number">2</span>
                <span class="step-title">Education Details</span>
            </div>
            <div class="step-nav-item step-3" onclick="showStep(3)">
                <span class="step-number">3</span>
                <span class="step-title">Family Details</span>
            </div>
            <div class="step-nav-item step-4" onclick="showStep(4)">
                <span class="step-number">4</span>
                <span class="step-title">Funding Details</span>
            </div>
            <div class="step-nav-item step-5" onclick="showStep(5)">
                <span class="step-number">5</span>
                <span class="step-title">Guarantor Details</span>
            </div>
            <div class="step-nav-item step-6" onclick="showStep(6)">
                <span class="step-number">6</span>
                <span class="step-title">Documents</span>
            </div>
            <div class="step-nav-item step-7" onclick="showStep(7)">
                <span class="step-number">7</span>
                <span class="step-title">Final Submission</span>
            </div>
            <div class="step-nav-item step-interview" onclick="showStep('interview')">
                <span class="step-number"><i class="fas fa-microphone" style="font-size: 0.8rem;"></i></span>
                <span class="step-title">Interview</span>
            </div>
            <div class="step-nav-item step-decision" onclick="showStep('decision')">
                <span class="step-number"><i class="fas fa-gavel" style="font-size: 0.8rem;"></i></span>
                <span class="step-title">Decision</span>
            </div>
        </div>

        <!-- Interview Step -->
        <div class="step-content" id="step-interview">
            <div class="step-header">
                <h2 class="step-title-large">Chapter Interview</h2>
                <div class="step-status">
                    <span class="status-badge status-approved">
                        <i class="fas fa-microphone" style="font-size: 0.6rem;"></i>
                        Interview Required
                    </span>
                </div>
            </div>

            <div class="data-group">
                <h4>Interview Assessment</h4>
                <div class="form-section">
                    <div
                        style="margin-bottom: 2rem; padding: 2rem; background: linear-gradient(135deg, #f3e5f5 0%, #e3f2fd 100%); border-radius: 12px; border: 2px solid #7B1FA2;">
                        <h5
                            style="color: #7B1FA2; margin: 0 0 1.5rem 0; font-size: 1.1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-comments"></i>
                            Pre-Interview Questions & Answers
                        </h5>

                        <form id="interview-form">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <input type="hidden" name="workflow_id" value="{{ $user->workflowStatus->id ?? '' }}">

                            <div id="interview-questions">
                                <!-- Questions will be loaded here -->
                            </div>

                            <div
                                style="margin-top: 3rem; padding-top: 1.5rem; border-top: 2px solid rgba(123, 31, 162, 0.2); display: flex; gap: 1rem; justify-content: center;">
                                <button type="button" onclick="saveInterviewAnswers()" class="btn"
                                    style="background: linear-gradient(135deg, #7B1FA2, #1976D2); color: white; border: none; padding: 1rem 2rem; font-size: 1rem;">
                                    <i class="fas fa-save"></i>
                                    Save Interview Answers
                                </button>
                                {{-- <button type="button" onclick="loadInterviewAnswers()" class="btn" style="background: #757575; color: white; border: none; padding: 1rem 2rem; font-size: 1rem;">
                                <i class="fas fa-sync"></i>
                                Refresh Answers
                            </button> --}}
                            </div>
                        </form>
                    </div>

                    <!-- Interview Summary -->
                    <div class="data-item"
                        style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin-top: 2rem;">
                        <div class="data-label" style="font-weight: 600; color: #7B1FA2; font-size: 1.1rem;">
                            <i class="fas fa-clipboard-check"></i>
                            Interview Status
                        </div>
                        <div class="data-value" style="text-align: right;">
                            @php
                                $interviewCount = \App\Models\ChapterInterviewAnswer::where('user_id', $user->id)
                                    ->where('workflow_id', $user->workflowStatus->id ?? 0)
                                    ->count();
                            @endphp
                            <span style="font-weight: 600; color: {{ $interviewCount > 0 ? '#4CAF50' : '#FF9800' }};">
                                {{ $interviewCount }}/15 Questions Answered
                            </span>
                            @if ($interviewCount > 0)
                                <br><small style="color: #666;">Last updated:
                                    {{ \App\Models\ChapterInterviewAnswer::where('user_id', $user->id)->where('workflow_id', $user->workflowStatus->id ?? 0)->latest()->first()?->updated_at?->format('d M Y H:i') ?? 'N/A' }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 1: Personal Details -->

        <div class="step-content active" id="step-1">
            <div class="step-header">
                <h2 class="step-title-large">Step 1: Personal Details</h2>
                <div class="step-status">
                    <span
                        class="status-badge status-{{ $user->submit_status == 'approved' ? 'approved' : ($user->submit_status == 'resubmit' ? 'hold' : 'pending') }}">
                        <i class="fas fa-circle" style="font-size: 0.6rem;"></i>
                        {{ ucfirst($user->submit_status ?? 'Pending') }}
                    </span>

                </div>
            </div>
            <div class="form-data">
                <div class="data-group">
                    <h4>Personal Information</h4>
                    <div class="form-section">
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-input" value="{{ $user->name }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Photo</label>
                                <div class="form-input" style="padding:0.5rem;">
                                    @if ($user->image)
                                        <img src="{{ asset($user->image) }}" alt="Photo" class="form-image">
                                    @else
                                        <span style="color:#6c757d;">N/A</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Aadhar Card Number</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->aadhar_card_number ?? 'N/A' }}" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">PAN Card</label>
                                <input type="text" class="form-input" value="{{ $user->pan_card ?? 'N/A' }}"
                                    readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Mobile</label>
                                <input type="tel" class="form-input" value="{{ $user->phone ?? $user->mobile }}"
                                    readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Alternate Phone</label>
                                <input type="tel" class="form-input" value="{{ $user->alternate_phone ?? 'N/A' }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-input" value="{{ $user->email }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Alternate Email</label>
                                <input type="email" class="form-input" value="{{ $user->alternate_email ?? 'N/A' }}"
                                    readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Marital Status</label>
                                <input type="text" class="form-input" value="{{ $user->marital_status ?? 'N/A' }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">Religion</label>
                                <input type="text" class="form-input" value="{{ $user->religion ?? 'N/A' }}"
                                    readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Sub Caste</label>
                                <input type="text" class="form-input" value="{{ $user->sub_cast ?? 'N/A' }}"
                                    readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Blood Group</label>
                                <input type="text" class="form-input" value="{{ $user->blood_group ?? 'N/A' }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">Date of Birth</label>
                                <input type="text" class="form-input" value="{{ $user->d_o_b ?? 'N/A' }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Birth Place</label>
                                <input type="text" class="form-input" value="{{ $user->birth_place ?? 'N/A' }}"
                                    readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Gender</label>
                                <input type="text" class="form-input" value="{{ $user->gender ?? 'N/A' }}" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">Age</label>
                                <input type="text" class="form-input" value="{{ $user->age ?? 'N/A' }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Nationality</label>
                                <input type="text" class="form-input" value="{{ $user->nationality ?? 'N/A' }}"
                                    readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Specially Abled</label>
                                <input type="text" class="form-input" value="{{ $user->specially_abled ?? 'N/A' }}"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-group">
                    <h4>Address Information</h4>
                    <div class="form-section">
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">Flat No</label>
                                <input type="text" class="form-input" value="{{ $user->flat_no ?? 'N/A' }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Building No</label>
                                <input type="text" class="form-input" value="{{ $user->building_no ?? 'N/A' }}"
                                    readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Street Name</label>
                                <input type="text" class="form-input" value="{{ $user->street_name ?? 'N/A' }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">Area</label>
                                <input type="text" class="form-input" value="{{ $user->area ?? 'N/A' }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Landmark</label>
                                <input type="text" class="form-input" value="{{ $user->landmark ?? 'N/A' }}"
                                    readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Pin Code</label>
                                <input type="text" class="form-input" value="{{ $user->pin_code ?? 'N/A' }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">City</label>
                                <input type="text" class="form-input" value="{{ $user->city ?? 'N/A' }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">District</label>
                                <input type="text" class="form-input" value="{{ $user->district ?? 'N/A' }}"
                                    readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">State</label>
                                <input type="text" class="form-input" value="{{ $user->state ?? 'N/A' }}" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">Chapter</label>
                                <input type="text" class="form-input" value="{{ $user->chapter ?? 'N/A' }}" readonly>
                            </div>
                            <div class="form-field form-field-full">
                                <label class="form-label">Aadhar/Pan Address</label>
                                <textarea class="form-textarea" readonly>{{ $user->aadhar_address ?? 'N/A' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Education Details -->
        <div class="step-content" id="step-2">
            <div class="step-header">
                <h2 class="step-title-large">Step 2: Education Details</h2>
                <div class="step-status">
                    <span
                        class="status-badge status-{{ $user->educationDetail ? ($user->educationDetail->submit_status == 'approved' ? 'approved' : ($user->educationDetail->submit_status == 'resubmit' ? 'hold' : 'pending')) : 'pending' }}">
                        <i class="fas fa-circle" style="font-size: 0.6rem;"></i>
                        {{ $user->educationDetail ? ucfirst($user->educationDetail->submit_status) : 'Pending' }}
                    </span>

                </div>
            </div>

            @if ($user->educationDetail)
                <div class="form-data">
                    <!-- Financial Need Overview -->
                    <div class="data-group">
                        <h4>Your Financial Need Overview</h4>
                        <div class="form-section">
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Course Name</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->course_name ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">University Name</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->university_name ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">College Name</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->college_name ?? 'N/A' }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Country</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->country ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->city_name ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">NIRF Ranking</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->nirf_ranking ?? 'N/A' }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Start Year</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->start_year ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Expected Completion Year</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->expected_year ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Qualifications</label>
                                    <input type="text" class="form-input"
                                        value="{{ ucfirst($user->educationDetail->qualifications ?? 'N/A') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Summary Table -->
                    <div class="data-group">
                        <h4>Financial Summary Table</h4>
                        <div class="table-container">
                            <table class="custom-table">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Group Name</th>
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
                                        <td>1</td>
                                        <td>Tuition Fees</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_1_year1 ?? 0) }}</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_1_year2 ?? 0) }}</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_1_year3 ?? 0) }}</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_1_year4 ?? 0) }}</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_1_year5 ?? 0) }}</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_1_total ?? 0) }}</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Living Expenses</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_2_year1 ?? 0) }}</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_2_year2 ?? 0) }}</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_2_year3 ?? 0) }}</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_2_year4 ?? 0) }}</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_2_year5 ?? 0) }}</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_2_total ?? 0) }}</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Other Expenses</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_3_year1 ?? 0) }}</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_3_year2 ?? 0) }}</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_3_year3 ?? 0) }}</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_3_year4 ?? 0) }}</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_3_year5 ?? 0) }}</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_3_total ?? 0) }}</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Total Expenses</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_4_year1 ?? 0) }}</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_4_year2 ?? 0) }}</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_4_year3 ?? 0) }}</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_4_year4 ?? 0) }}</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_4_year5 ?? 0) }}</td>
                                        <td class="amount-cell">
                                            ₹{{ number_format($user->educationDetail->group_4_total ?? 0) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- School Information -->
                    <div class="data-group">
                        <h4>School / 10th Grade Information</h4>
                        <div class="form-section">
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">School Name</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->school_name ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Board</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->school_board ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Completion Year</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->school_completion_year ?? 'N/A' }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Marks Obtained</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->{'10th_mark_obtained'} ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Out Of</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->{'10th_mark_out_of'} ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Percentage</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->school_percentage ?? 'N/A' }}%" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">CGPA</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->school_CGPA ?? 'N/A' }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Junior College Information -->
                    <div class="data-group">
                        <h4>Junior College (12th Grade)</h4>
                        <div class="form-section">
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">College Name</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->jc_college_name ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Stream</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->jc_stream ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Board</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->jc_board ?? 'N/A' }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Completion Year</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->jc_completion_year ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Marks Obtained</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->{'12th_mark_obtained'} ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Out Of</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->{'12th_mark_out_of'} ?? 'N/A' }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Percentage</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->jc_percentage ?? 'N/A' }}%" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">CGPA</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->jc_CGPA ?? 'N/A' }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="data-group">
                        <h4>Additional Information</h4>
                        <div class="form-section">
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Work Experience</label>
                                    <input type="text" class="form-input"
                                        value="{{ ucfirst($user->educationDetail->have_work_experience ?? 'no') }}"
                                        readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Organization Name</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->organization_name ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Work Profile</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->educationDetail->work_profile ?? 'N/A' }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    @else
        <div class="no-data">
            <p>Education details not submitted yet.</p>
        </div>
        @endif
    </div>

    <!-- Step 3: Family Details -->
    <div class="step-content" id="step-3">
        <div class="step-header">
            <h2 class="step-title-large">Step 3: Family Details</h2>
            <div class="step-status">
                <span
                    class="status-badge status-{{ $user->familyDetail ? ($user->familyDetail->submit_status == 'approved' ? 'approved' : ($user->familyDetail->submit_status == 'resubmit' ? 'hold' : 'pending')) : 'pending' }}">
                    <i class="fas fa-circle" style="font-size: 0.6rem;"></i>
                    {{ $user->familyDetail ? ucfirst($user->familyDetail->submit_status) : 'Pending' }}
                </span>
                {{-- <div class="action-buttons">
                    <form action="{{ route('admin.user.approve', ['user' => $user, 'stage' => 'apex_1']) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-approve">Approve</button>
                    </form>
                    <form action="{{ route('admin.user.reject', ['user' => $user, 'stage' => 'apex_1']) }}" method="POST" style="display: inline-flex; gap:8px; align-items:center;">
                        @csrf
                        <textarea name="admin_remark" placeholder="Hold remark" required rows="1" style="padding:6px;border-radius:6px;border:1px solid #ddd;resize:vertical;width:40rem;box-sizing:border-box;"></textarea>
                        <button type="submit" class="btn-hold">Hold</button>
                    </form>
                </div> --}}
            </div>
        </div>
        @if ($user->familyDetail)
            <div class="form-data">
                <!-- Family Summary -->
                <div class="data-group">
                    <h4>Family Summary</h4>
                    <div class="form-section">
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">Number of Family Members</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->familyDetail->number_family_members }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Total Family Income</label>
                                <input type="text" class="form-input"
                                    value="₹{{ number_format($user->familyDetail->total_family_income) }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Total Students</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->familyDetail->total_students }}" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">Family Member Taken Diksha</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->familyDetail->family_member_diksha ?? 'N/A' }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Total Insurance Coverage</label>
                                <input type="text" class="form-input"
                                    value="₹{{ number_format($user->familyDetail->total_insurance_coverage) }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Total Premium Paid (Year)</label>
                                <input type="text" class="form-input"
                                    value="₹{{ number_format($user->familyDetail->total_premium_paid) }}" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">Recent Electricity Bill Amount</label>
                                <input type="text" class="form-input"
                                    value="₹{{ number_format($user->familyDetail->recent_electricity_amount) }}"
                                    readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Total Monthly EMI</label>
                                <input type="text" class="form-input"
                                    value="₹{{ number_format($user->familyDetail->total_monthly_emi) }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Family Members -->
                <div class="data-group">
                    <h4>Additional Family Members</h4>
                    <div class="form-section">
                        @if ($user->familyDetail->additional_family_members)
                            @php $addMembers = json_decode($user->familyDetail->additional_family_members, true); @endphp
                            @foreach ($addMembers as $index => $member)
                                <div class="form-row"
                                    style="border: 1px solid #e9ecef; padding: 1rem; margin-bottom: 1rem; border-radius: 6px; background: #f8f9fa;">
                                    <div class="form-field">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-input" value="{{ $member['name'] ?? 'N/A' }}"
                                            readonly>
                                    </div>
                                    <div class="form-field">
                                        <label class="form-label">Relation</label>
                                        <input type="text" class="form-input"
                                            value="{{ $member['relation'] ?? 'N/A' }}" readonly>
                                    </div>
                                    <div class="form-field">
                                        <label class="form-label">Age</label>
                                        <input type="text" class="form-input" value="{{ $member['age'] ?? 'N/A' }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-field">
                                        <label class="form-label">Marital Status</label>
                                        <input type="text" class="form-input"
                                            value="{{ $member['marital_status'] ?? 'N/A' }}" readonly>
                                    </div>
                                    <div class="form-field">
                                        <label class="form-label">Qualification</label>
                                        <input type="text" class="form-input"
                                            value="{{ $member['qualification'] ?? 'N/A' }}" readonly>
                                    </div>
                                    <div class="form-field">
                                        <label class="form-label">Occupation</label>
                                        <input type="text" class="form-input"
                                            value="{{ $member['occupation'] ?? 'N/A' }}" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-field">
                                        <label class="form-label">Mobile</label>
                                        <input type="text" class="form-input"
                                            value="{{ $member['mobile'] ?? 'N/A' }}" readonly>
                                    </div>
                                    <div class="form-field">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-input"
                                            value="{{ $member['email'] ?? 'N/A' }}" readonly>
                                    </div>
                                    <div class="form-field">
                                        <label class="form-label">Yearly Income</label>
                                        <input type="text" class="form-input"
                                            value="₹{{ isset($member['yearly_income']) ? number_format($member['yearly_income']) : 'N/A' }}"
                                            readonly>
                                    </div>
                                </div>
                                @if (!$loop->last)
                                    <hr style="margin: 1rem 0; border: none; border-top: 1px solid #dee2e6;">
                                @endif
                            @endforeach
                        @else
                            <div class="form-row">
                                <div class="form-field form-field-full">
                                    <label class="form-label">Additional Family Members</label>
                                    <input type="text" class="form-input"
                                        value="No additional family members data available" readonly>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Paternal & Maternal Side -->
                @php $f = $user->familyDetail; @endphp
                @if (
                    ($f->paternal_uncle_name ?? false) ||
                        ($f->paternal_uncle_mobile ?? false) ||
                        ($f->paternal_uncle_email ?? false) ||
                        ($f->paternal_aunt_name ?? false) ||
                        ($f->paternal_aunt_mobile ?? false) ||
                        ($f->paternal_aunt_email ?? false))
                    <div class="data-group">
                        <h4>Paternal Side</h4>
                        <div class="form-section">
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Uncle Name</label>
                                    <input type="text" class="form-input"
                                        value="{{ $f->paternal_uncle_name ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Uncle Mobile</label>
                                    <input type="text" class="form-input"
                                        value="{{ $f->paternal_uncle_mobile ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Uncle Email</label>
                                    <input type="text" class="form-input"
                                        value="{{ $f->paternal_uncle_email ?? 'N/A' }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Aunt Name</label>
                                    <input type="text" class="form-input"
                                        value="{{ $f->paternal_aunt_name ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Aunt Mobile</label>
                                    <input type="text" class="form-input"
                                        value="{{ $f->paternal_aunt_mobile ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Aunt Email</label>
                                    <input type="text" class="form-input"
                                        value="{{ $f->paternal_aunt_email ?? 'N/A' }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if (
                    ($f->maternal_uncle_name ?? false) ||
                        ($f->maternal_uncle_mobile ?? false) ||
                        ($f->maternal_uncle_email ?? false) ||
                        ($f->maternal_aunt_name ?? false) ||
                        ($f->maternal_aunt_mobile ?? false) ||
                        ($f->maternal_aunt_email ?? false))
                    <div class="data-group">
                        <h4>Maternal Side</h4>
                        <div class="form-section">
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Uncle Name</label>
                                    <input type="text" class="form-input"
                                        value="{{ $f->maternal_uncle_name ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Uncle Mobile</label>
                                    <input type="text" class="form-input"
                                        value="{{ $f->maternal_uncle_mobile ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Uncle Email</label>
                                    <input type="text" class="form-input"
                                        value="{{ $f->maternal_uncle_email ?? 'N/A' }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Aunt Name</label>
                                    <input type="text" class="form-input"
                                        value="{{ $f->maternal_aunt_name ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Aunt Mobile</label>
                                    <input type="text" class="form-input"
                                        value="{{ $f->maternal_aunt_mobile ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Aunt Email</label>
                                    <input type="text" class="form-input"
                                        value="{{ $f->maternal_aunt_email ?? 'N/A' }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @else
            <div class="no-data">
                <p>Family details not submitted yet.</p>
            </div>
        @endif
    </div>

    <!-- Step 4: Funding Details -->
    <div class="step-content" id="step-4">
        <div class="step-header">
            <h2 class="step-title-large">Step 4: Funding Details</h2>
            <div class="step-status">
                <span
                    class="status-badge status-{{ $user->fundingDetail ? ($user->fundingDetail->submit_status == 'approved' ? 'approved' : ($user->fundingDetail->submit_status == 'resubmit' ? 'hold' : 'pending')) : 'pending' }}">
                    <i class="fas fa-circle" style="font-size: 0.6rem;"></i>
                    {{ $user->fundingDetail ? ucfirst($user->fundingDetail->submit_status) : 'Pending' }}
                </span>
                {{-- <div class="action-buttons">
                    <form action="{{ route('admin.user.approve', ['user' => $user, 'stage' => 'apex_1']) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-approve">Approve</button>
                    </form>
                    <form action="{{ route('admin.user.reject', ['user' => $user, 'stage' => 'apex_1']) }}" method="POST" style="display: inline-flex; gap:8px; align-items:center;">
                        @csrf
                        <textarea name="admin_remark" placeholder="Hold remark" required rows="1" style="padding:6px;border-radius:6px;border:1px solid #ddd;resize:vertical;width:40rem;box-sizing:border-box;"></textarea>
                        <button type="submit" class="btn-hold">Hold</button>
                    </form>
                </div> --}}
            </div>
        </div>

        @if ($user->fundingDetail)
            <div class="form-data">
                <!-- Funding Sources Table -->
                <div class="data-group">
                    <h4>Funding Sources</h4>
                    <div class="table-container">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Particulars</th>
                                    <th>Status</th>
                                    <th>Name of Trust/Institute</th>
                                    <th>Name of Contact Person</th>
                                    <th>Contact No</th>
                                    <th>Amount (Rs)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Own family funding (Father + Mother)</td>
                                    <td>{{ ucfirst($user->fundingDetail->family_funding_status) }}</td>
                                    <td>{{ $user->fundingDetail->family_funding_trust ?? '-' }}</td>
                                    <td>{{ $user->fundingDetail->family_funding_contact ?? '-' }}</td>
                                    <td>{{ $user->fundingDetail->family_funding_mobile ?? '-' }}</td>
                                    <td class="amount-cell">
                                        ₹{{ number_format($user->fundingDetail->family_funding_amount ?? 0) }}</td>
                                </tr>
                                <tr>
                                    <td>Bank Loan</td>
                                    <td>{{ ucfirst($user->fundingDetail->bank_loan_status) }}</td>
                                    <td>{{ $user->fundingDetail->bank_loan_trust ?? '-' }}</td>
                                    <td>{{ $user->fundingDetail->bank_loan_contact ?? '-' }}</td>
                                    <td>{{ $user->fundingDetail->bank_loan_mobile ?? '-' }}</td>
                                    <td class="amount-cell">
                                        ₹{{ number_format($user->fundingDetail->bank_loan_amount ?? 0) }}</td>
                                </tr>
                                <tr>
                                    <td>Other Assistance (1)</td>
                                    <td>{{ ucfirst($user->fundingDetail->other_assistance1_status) }}</td>
                                    <td>{{ $user->fundingDetail->other_assistance1_trust ?? '-' }}</td>
                                    <td>{{ $user->fundingDetail->other_assistance1_contact ?? '-' }}</td>
                                    <td>{{ $user->fundingDetail->other_assistance1_mobile ?? '-' }}</td>
                                    <td class="amount-cell">
                                        ₹{{ number_format($user->fundingDetail->other_assistance1_amount ?? 0) }}</td>
                                </tr>
                                <tr>
                                    <td>Other Assistance (2)</td>
                                    <td>{{ ucfirst($user->fundingDetail->other_assistance2_status) }}</td>
                                    <td>{{ $user->fundingDetail->other_assistance2_trust ?? '-' }}</td>
                                    <td>{{ $user->fundingDetail->other_assistance2_contact ?? '-' }}</td>
                                    <td>{{ $user->fundingDetail->other_assistance2_mobile ?? '-' }}</td>
                                    <td class="amount-cell">
                                        ₹{{ number_format($user->fundingDetail->other_assistance2_amount ?? 0) }}</td>
                                </tr>
                                <tr>
                                    <td>Local Assistance</td>
                                    <td>{{ ucfirst($user->fundingDetail->local_assistance_status) }}</td>
                                    <td>{{ $user->fundingDetail->local_assistance_trust ?? '-' }}</td>
                                    <td>{{ $user->fundingDetail->local_assistance_contact ?? '-' }}</td>
                                    <td>{{ $user->fundingDetail->local_assistance_mobile ?? '-' }}</td>
                                    <td class="amount-cell">
                                        ₹{{ number_format($user->fundingDetail->local_assistance_amount ?? 0) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="text-align:right;font-weight:600">Total</td>
                                    <td class="amount-cell">
                                        ₹{{ number_format((float) ($user->fundingDetail->family_funding_amount ?? 0) + (float) ($user->fundingDetail->bank_loan_amount ?? 0) + (float) ($user->fundingDetail->other_assistance1_amount ?? 0) + (float) ($user->fundingDetail->other_assistance2_amount ?? 0) + (float) ($user->fundingDetail->local_assistance_amount ?? 0)) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Total Funding -->
                <div class="data-group">
                    <h4>Total Funding</h4>
                    <div class="form-section">
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">Total Amount (Rs)</label>
                                <input type="text" class="form-input"
                                    value="₹{{ isset($user->fundingDetail->total_funding_amount) ? number_format($user->fundingDetail->total_funding_amount) : '0' }}"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bank Details of Applicant -->
                <div class="data-group">
                    <h4>Bank Details of Applicant</h4>
                    <div class="form-section">
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">Account Holder</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->fundingDetail->account_holder_name }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Bank Name</label>
                                <input type="text" class="form-input" value="{{ $user->fundingDetail->bank_name }}"
                                    readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Account Number</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->fundingDetail->account_number }}" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">Branch Name</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->fundingDetail->branch_name }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">IFSC Code</label>
                                <input type="text" class="form-input" value="{{ $user->fundingDetail->ifsc_code }}"
                                    readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Bank Address</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->fundingDetail->bank_address }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="no-data">
                <p>Funding details not submitted yet.</p>
            </div>
        @endif
    </div>

    <!-- Step 5: Guarantor Details -->
    <div class="step-content" id="step-5">
        <div class="step-header">
            <h2 class="step-title-large">Step 5: Guarantor Details</h2>
            <div class="step-status">
                <span
                    class="status-badge status-{{ $user->guarantorDetail ? ($user->guarantorDetail->submit_status == 'approved' ? 'approved' : ($user->guarantorDetail->submit_status == 'resubmit' ? 'hold' : 'pending')) : 'pending' }}">
                    <i class="fas fa-circle" style="font-size: 0.6rem;"></i>
                    {{ $user->guarantorDetail ? ucfirst($user->guarantorDetail->submit_status) : 'Pending' }}
                </span>
                {{-- <div class="action-buttons">
                    <form action="{{ route('admin.user.approve', ['user' => $user, 'stage' => 'apex_1']) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-approve">Approve</button>
                    </form>
                    <form action="{{ route('admin.user.reject', ['user' => $user, 'stage' => 'apex_1']) }}" method="POST" style="display: inline-flex; gap:8px; align-items:center;">
                        @csrf
                        <textarea name="admin_remark" placeholder="Hold remark" required rows="1" style="padding:6px;border-radius:6px;border:1px solid #ddd;resize:vertical;width:40rem;box-sizing:border-box;"></textarea>
                        <button type="submit" class="btn-hold">Hold</button>
                    </form>
                </div> --}}
            </div>
        </div>

        @if ($user->guarantorDetail)
            <div class="form-data">
                <div class="data-group">
                    <h4>Guarantor 1</h4>
                    <div class="form-section">
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->guarantorDetail->g_one_name ?? 'N/A' }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Gender</label>
                                <input type="text" class="form-input"
                                    value="{{ ucfirst($user->guarantorDetail->g_one_gender ?? 'N/A') }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Date of Birth</label>
                                <input type="text" class="form-input"
                                    value="{{ optional($user->guarantorDetail->g_one_d_o_b)->format ? $user->guarantorDetail->g_one_d_o_b : $user->guarantorDetail->g_one_d_o_b ?? 'N/A' }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">Relation</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->guarantorDetail->g_one_relation_with_student ?? 'N/A' }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->guarantorDetail->g_one_phone ?? 'N/A' }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->guarantorDetail->g_one_email ?? 'N/A' }}" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-field form-field-full">
                                <label class="form-label">Permanent Address</label>
                                <textarea class="form-textarea" readonly>{{ $user->guarantorDetail->g_one_permanent_flat_no ?? '' }} {{ $user->guarantorDetail->g_one_permanent_address ?? '' }} {{ $user->guarantorDetail->g_one_permanent_city ?? '' }}, {{ $user->guarantorDetail->g_one_permanent_district ?? '' }} {{ $user->guarantorDetail->g_one_permanent_state ?? '' }} - {{ $user->guarantorDetail->g_one_permanent_pincode ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">Service / Business</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->guarantorDetail->g_one_srvice ?? 'N/A' }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Annual Income</label>
                                <input type="text" class="form-input"
                                    value="@if (is_numeric($user->guarantorDetail->g_one_income)) ₹{{ number_format($user->guarantorDetail->g_one_income) }} @else {{ $user->guarantorDetail->g_one_income ?? 'N/A' }} @endif"
                                    readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Aadhaar</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->guarantorDetail->g_one_aadhar_card_number ?? 'N/A' }}" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">PAN Card No</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->guarantorDetail->g_one_pan_card_no ?? 'N/A' }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">PAN Upload</label>
                                <div class="form-input" style="padding:0.5rem; background:transparent; border:none;">
                                    @if (!empty($user->guarantorDetail->g_one_pan_card_upload))
                                        <a href="{{ asset($user->guarantorDetail->g_one_pan_card_upload) }}"
                                            target="_blank">View PAN</a>
                                    @else
                                        <span style="color:#6c757d;">N/A</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="data-group">
                    <h4>Guarantor 2</h4>
                    <div class="form-section">
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->guarantorDetail->g_two_name ?? 'N/A' }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Gender</label>
                                <input type="text" class="form-input"
                                    value="{{ ucfirst($user->guarantorDetail->g_two_gender ?? 'N/A') }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Date of Birth</label>
                                <input type="text" class="form-input"
                                    value="{{ optional($user->guarantorDetail->g_two_d_o_b)->format ? $user->guarantorDetail->g_two_d_o_b : $user->guarantorDetail->g_two_d_o_b ?? 'N/A' }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">Relation</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->guarantorDetail->g_two_relation_with_student ?? 'N/A' }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->guarantorDetail->g_two_phone ?? 'N/A' }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->guarantorDetail->g_two_email ?? 'N/A' }}" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-field form-field-full">
                                <label class="form-label">Permanent Address</label>
                                <textarea class="form-textarea" readonly>{{ $user->guarantorDetail->g_two_permanent_flat_no ?? '' }} {{ $user->guarantorDetail->g_two_permanent_address ?? '' }} {{ $user->guarantorDetail->g_two_permanent_city ?? '' }}, {{ $user->guarantorDetail->g_two_permanent_district ?? '' }} {{ $user->guarantorDetail->g_two_permanent_state ?? '' }} - {{ $user->guarantorDetail->g_two_permanent_pincode ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">Service / Business</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->guarantorDetail->g_two_srvice ?? 'N/A' }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Annual Income</label>
                                <input type="text" class="form-input"
                                    value="@if (is_numeric($user->guarantorDetail->g_two_income)) ₹{{ number_format($user->guarantorDetail->g_two_income) }} @else {{ $user->guarantorDetail->g_two_income ?? 'N/A' }} @endif"
                                    readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Aadhaar</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->guarantorDetail->g_two_aadhar_card_number ?? 'N/A' }}" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label">PAN Card No</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->guarantorDetail->g_two_pan_card_no ?? 'N/A' }}" readonly>
                            </div>
                            <div class="form-field">
                                <label class="form-label">PAN Upload</label>
                                <div class="form-input" style="padding:0.5rem; background:transparent; border:none;">
                                    @if (!empty($user->guarantorDetail->g_two_pan_card_upload))
                                        <a href="{{ asset($user->guarantorDetail->g_two_pan_card_upload) }}"
                                            target="_blank">View PAN</a>
                                    @else
                                        <span style="color:#6c757d;">N/A</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="data-group">
                <h4>Power of Attorney</h4>
                <div class="data-item"><div class="data-label">Name</div><div class="data-value">{{ $user->guarantorDetail->attorney_name ?? 'N/A' }}</div></div>
                <div class="data-item"><div class="data-label">Relation</div><div class="data-value">{{ $user->guarantorDetail->attorney_relation_with_student ?? 'N/A' }}</div></div>
                <div class="data-item"><div class="data-label">Phone</div><div class="data-value">{{ $user->guarantorDetail->attorney_phone ?? 'N/A' }}</div></div>
                <div class="data-item"><div class="data-label">Email</div><div class="data-value">{{ $user->guarantorDetail->attorney_email ?? 'N/A' }}</div></div>
                <div class="data-item"><div class="data-label">Address</div><div class="data-value">{{ $user->guarantorDetail->attorney_address ?? 'N/A' }}</div></div>
            </div> --}}
            </div>
        @else
            <div class="no-data">
                <p>Guarantor details not submitted yet.</p>
            </div>
        @endif
    </div>

    <!-- Step 6: Documents -->
    <div class="step-content" id="step-6">
        <div class="step-header">
            <h2 class="step-title-large">Step 6: Documents</h2>
            <div class="step-status">
                <span
                    class="status-badge status-{{ $user->document ? ($user->document->submit_status == 'approved' ? 'approved' : ($user->document->submit_status == 'resubmit' ? 'hold' : 'pending')) : 'pending' }}">
                    <i class="fas fa-circle" style="font-size: 0.6rem;"></i>
                    {{ $user->document ? ucfirst($user->document->submit_status) : 'Pending' }}
                </span>
                {{-- <div class="action-buttons">
                    <form action="{{ route('admin.user.approve', ['user' => $user, 'stage' => 'apex_1']) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-approve">Approve</button>
                    </form>
                    <form action="{{ route('admin.user.reject', ['user' => $user, 'stage' => 'apex_1']) }}" method="POST" style="display: inline-flex; gap:8px; align-items:center;">
                        @csrf
                        <textarea name="admin_remark" placeholder="Hold remark" required rows="1" style="padding:6px;border-radius:6px;border:1px solid #ddd;resize:vertical;width:40rem;box-sizing:border-box;"></textarea>
                        <button type="submit" class="btn-hold">Hold</button>
                    </form>
                </div> --}}
            </div>
        </div>

        @if ($user->document)
            <div class="form-data">
                <div class="data-group">
                    <h4>All Documents</h4>
                    <div class="form-section">
                        @php
                            $doc = $user->document;
                            $fields = [
                                'ssc_cbse_icse_ib_igcse' => 'SSC/CBSE/ICSE/IB/IGCSE',
                                'hsc_diploma_marksheet' => 'HSC/Diploma Marksheet',
                                'graduate_post_graduate_marksheet' => 'Graduate/Post Graduate Marksheet',
                                'admission_letter_fees_structure' => 'Admission Letter / Fees Structure',
                                'aadhaar_applicant' => 'Applicant Aadhaar',
                                'pan_applicant' => 'Applicant PAN',
                                'passport' => 'Passport',
                                'student_bank_details_statement' => 'Student Bank Statement',
                                'jito_group_recommendation' => 'JITO Group Recommendation',
                                'jain_sangh_certificate' => 'Jain Sangh Certificate',
                                'electricity_bill' => 'Electricity Bill',
                                'itr_acknowledgement_father' => 'Father ITR Acknowledgement',
                                'itr_computation_father' => 'Father ITR Computation',
                                'form16_salary_income_father' => 'Form16 / Salary Slip (Father)',
                                'bank_statement_father_12months' => 'Father Bank Statement (12 months)',
                                'bank_statement_mother_12months' => 'Mother Bank Statement (12 months)',
                                'aadhaar_father_mother' => 'Father/Mother Aadhaar',
                                'pan_father_mother' => 'Father/Mother PAN',
                                'guarantor1_aadhaar' => 'Guarantor1 Aadhaar',
                                'guarantor1_pan' => 'Guarantor1 PAN',
                                'guarantor2_aadhaar' => 'Guarantor2 Aadhaar',
                                'guarantor2_pan' => 'Guarantor2 PAN',
                                'student_handwritten_statement' => 'Student Handwritten Statement',
                                'proof_funds_arranged' => 'Proof of Funds Arranged',
                                'other_documents' => 'Other Documents',
                                'extra_curricular' => 'Extra Curricular',
                            ];
                        @endphp

                        @foreach ($fields as $key => $label)
                            <div class="form-row" style="align-items:center;">
                                <div class="form-field" style="min-width:250px;">
                                    <label class="form-label">{{ $label }}</label>
                                </div>
                                <div class="form-field form-field-full" style="flex:1;text-align:left;">
                                    @if (!empty($doc->$key))
                                        @php
                                            $p = $doc->$key;
                                            if (strpos($p, 'http') === 0) {
                                                $href = $p;
                                            } else {
                                                $trimmed = ltrim($p, '/');
                                                if (file_exists(public_path($trimmed))) {
                                                    $href = asset($trimmed);
                                                } elseif (file_exists(public_path('storage/' . $trimmed))) {
                                                    $href = asset('storage/' . $trimmed);
                                                } elseif (
                                                    file_exists(public_path('user_document_images/' . $trimmed))
                                                ) {
                                                    $href = asset('user_document_images/' . $trimmed);
                                                } else {
                                                    $href = asset($trimmed);
                                                }
                                            }
                                        @endphp
                                        <a href="{{ $href }}" target="_blank">View Document</a>
                                    @else
                                        <input type="text" class="form-input" value="Not uploaded" readonly>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="no-data">
                <p>Documents not submitted yet.</p>
            </div>
        @endif
    </div>

    <!-- Step 7: Final Submission -->
    <div class="step-content" id="step-7">
        <div class="step-header">
            <h2 class="step-title-large">Step 7: Final Submission</h2>
            <div class="step-status">
                <span
                    class="status-badge status-{{ $user->document ? ($user->document->submit_status == 'approved' ? 'approved' : ($user->document->submit_status == 'resubmit' ? 'hold' : 'pending')) : 'pending' }}">
                    <i class="fas fa-circle" style="font-size: 0.6rem;"></i>
                    {{ $user->document ? ucfirst($user->document->submit_status) : 'Pending' }}
                </span>
                {{-- <div class="action-buttons">
                    <form action="{{ route('admin.user.approve', ['user' => $user, 'stage' => 'apex_1']) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-approve">Approve</button>
                    </form>
                    <form action="{{ route('admin.user.reject', ['user' => $user, 'stage' => 'apex_1']) }}" method="POST" style="display: inline-flex; gap:8px; align-items:center;">
                        @csrf
                        <textarea name="admin_remark" placeholder="Hold remark" required rows="1" style="padding:6px;border-radius:6px;border:1px solid #ddd;resize:vertical;width:40rem;box-sizing:border-box;"></textarea>
                        <button type="submit" class="btn-hold">Hold</button>
                    </form>
                </div> --}}
            </div>
        </div>

        <div class="form-data">
            <div class="data-group">
                <h4>Submission Summary</h4>
                <div class="data-item">
                    <div class="data-label">Overall Status</div>
                    <div class="data-value">{{ ucfirst($user->submit_status) }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Terms & Conditions Approved</div>
                    <div class="data-value">
                        @if ($user->document && $user->document->submit_status == 'approved')
                            Yes (approved)
                        @elseif($user->document && $user->document->submit_status == 'resubmit')
                            No (needs resubmission)
                        @else
                            No
                        @endif
                    </div>
                </div>
                <div class="data-item">
                    <div class="data-label">Submitted Date</div>
                    <div class="data-value">{{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Last Updated</div>
                    <div class="data-value">{{ $user->updated_at ? $user->updated_at->format('d M Y H:i') : 'N/A' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chapter Decision Step -->
    <div class="step-content" id="step-decision">
        <div class="step-header">
            <h2 class="step-title-large">Chapter Decision</h2>
            <div class="step-status">
                <span class="status-badge status-approved">
                    <i class="fas fa-gavel" style="font-size: 0.6rem;"></i>
                    Decision Required
                </span>
            </div>
        </div>

        <div class="data-group">
            <h4>Final Chapter Decision</h4>
            <div class="form-section">
                @if (!in_array($user->workflowStatus->chapter_status ?? '', ['approved', 'rejected']))
                    <div style="margin-bottom: 2rem; padding: 2rem; border-radius: 12px; border: 2px solid #4CAF50;">
                        <h5
                            style="color: #2E7D32; margin: 0 0 1.5rem 0; font-size: 1.1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-balance-scale"></i>
                            Make Your Final Decision
                        </h5>

                        <!-- Decision Forms Container -->
                        <div style="display: flex; gap: 2rem; flex-wrap: wrap;">

                            <!-- Approve Form -->
                            <div
                                style="flex: 1; min-width: 300px; padding: 2rem;  border-radius: 12px; border: 2px solid #4CAF50;">
                                <h6
                                    style="color: #2E7D32; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.5rem;">
                                    <i class="fas fa-check-circle"></i>
                                    Approve Application
                                </h6>
                            <form action="{{ route('admin.user.approve', ['user' => $user, 'stage' => 'chapter']) }}"
                                method="POST">
                                @csrf
                                <div class="form-row" style="margin-bottom: 1rem;">
                                    <div class="form-field form-field-full">
                                        <label class="form-label" style="color: #2E7D32;">Interview Date</label>
                                        <input type="date" name="interview_date" class="form-input" required
                                            value="{{ $inter_date ? \Carbon\Carbon::parse($inter_date->updated_at)->format('Y-m-d') : '' }}"
                                            style="border: 2px solid #4CAF50; background: rgba(76, 175, 80, 0.05);">
                                    </div>
                                </div>

                                <div class="form-row" style="margin-bottom: 1rem;">
                                    <div class="form-field form-field-full">
                                        <label class="form-label" style="color: #2E7D32;">Total Expence</label>
                                        <input type="text" class="form-input" value="{{ $data->group_4_total ?? 'NA' }}"
                                            readonly
                                            style="border: 2px solid #4CAF50; background: rgba(76, 175, 80, 0.05);">
                                    </div>
                                </div>

                                <div class="form-row" style="margin-bottom: 1rem;">
                                    <div class="form-field form-field-full">
                                        <label class="form-label" style="color: #2E7D32;">Chapter Remarks (Question 14)</label>
                                        <textarea class="remark-input" readonly style="border: 2px solid #4CAF50; background: rgba(76, 175, 80, 0.05); resize: vertical; min-height: 80px;">{{ \App\Models\ChapterInterviewAnswer::where('user_id', $user->id)->where('workflow_id', $user->workflowStatus->id ?? 0)->where('question_no', 14)->first()?->answer_text ?? 'Not answered' }}</textarea>
                                    </div>
                                </div>

                                <div class="form-row" style="margin-bottom: 1rem;">
                                    <div class="form-field form-field-full">
                                        <label class="form-label" style="color: #2E7D32;">Recommended Finantial Assistance
                                            Amount</label>
                                        <input type="number" name="assistance_amount" class="form-input"
                                            placeholder="Provide Assistance Amount" required
                                            style="border: 2px solid #4CAF50; background: rgba(76, 175, 80, 0.05);">
                                    </div>
                                </div>

                                <div class="form-row" style="margin-bottom: 1rem;">
                                    <div class="form-field form-field-full">
                                        <label class="form-label" style="color: #2E7D32;">Approval Remarks</label>
                                        <textarea name="admin_remark" placeholder="Provide approval remarks (optional but recommended)" rows="4"
                                            class="remark-input" style="border: 2px solid #4CAF50; background: rgba(76, 175, 80, 0.05);"></textarea>
                                    </div>
                                </div>


                                <!-- Approval Checkboxes -->
                                {{-- <div
                                    style="margin-bottom: 1.5rem; padding: 1rem; background: rgba(76, 175, 80, 0.1); border-radius: 8px; border: 1px solid rgba(76, 175, 80, 0.3);">
                                    <h6 style="color: #2E7D32; margin: 0 0 0.5rem 0; font-size: 0.9rem;">Verify before
                                        approval:</h6>
                                    <div
                                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 0.5rem;">
                                        <label
                                            style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: #2E7D32;">
                                            <input type="checkbox" name="approved_steps[]" value="personal"
                                                style="width: 16px; height: 16px;" required>
                                            Personal Details
                                        </label>
                                        <label
                                            style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: #2E7D32;">
                                            <input type="checkbox" name="approved_steps[]" value="education"
                                                style="width: 16px; height: 16px;" required>
                                            Education Details
                                        </label>
                                        <label
                                            style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: #2E7D32;">
                                            <input type="checkbox" name="approved_steps[]" value="family"
                                                style="width: 16px; height: 16px;" required>
                                            Family Details
                                        </label>
                                        <label
                                            style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: #2E7D32;">
                                            <input type="checkbox" name="approved_steps[]" value="funding"
                                                style="width: 16px; height: 16px;" required>
                                            Funding Details
                                        </label>
                                        <label
                                            style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: #2E7D32;">
                                            <input type="checkbox" name="approved_steps[]" value="guarantor"
                                                style="width: 16px; height: 16px;" required>
                                            Guarantor Details
                                        </label>
                                        <label
                                            style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: #2E7D32;">
                                            <input type="checkbox" name="approved_steps[]" value="documents"
                                                style="width: 16px; height: 16px;" required>
                                            Documents
                                        </label>
                                        <label
                                            style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: #2E7D32;">
                                            <input type="checkbox" name="approved_steps[]" value="final"
                                                style="width: 16px; height: 16px;" required>
                                            Final Submission
                                        </label>
                                    </div>
                                    <p
                                        style="font-size: 0.75rem; color: #2E7D32; margin: 0.5rem 0 0 0; font-style: italic;">
                                        All steps must be verified before approval
                                    </p>
                                </div> --}}

                                <button type="submit" class="btn btn-approve" style="width: 100%;">
                                    <i class="fas fa-check"></i>
                                    Approve & Move to Working Committee
                                </button>
                            </form>
                        </div>

                        <!-- Reject Form -->
                        {{-- <div
                            style="flex: 1; min-width: 300px; padding: 2rem;  border-radius: 12px; border: 2px solid #f44336;">
                            <h6
                                style="color: #c62828; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-times-circle"></i>
                                Reject Application
                            </h6>
                            <form action="{{ route('admin.user.reject', ['user' => $user, 'stage' => 'chapter']) }}"
                                method="POST">
                                @csrf
                                <div class="form-row" style="margin-bottom: 1rem;">
                                    <div class="form-field form-field-full">
                                        <label class="form-label" style="color: #c62828;">Rejection Remarks *</label>
                                        <textarea name="admin_remark" placeholder="Provide detailed rejection remarks (required)" rows="4"
                                            class="remark-input" style="border: 2px solid #f44336; background: rgba(244, 67, 54, 0.05);" required></textarea>
                                    </div>
                                </div>

                                <!-- Rejection Checkboxes -->
                                <div
                                    style="margin-bottom: 1.5rem; padding: 1rem; background: rgba(244, 67, 54, 0.1); border-radius: 8px; border: 1px solid rgba(244, 67, 54, 0.3);">
                                    <h6 style="color: #c62828; margin: 0 0 0.5rem 0; font-size: 0.9rem;">Select steps to
                                        resubmit:</h6>
                                    <div
                                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 0.5rem;">
                                        <label
                                            style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: #c62828;">
                                            <input type="checkbox" name="resubmit_steps[]" value="personal"
                                                style="width: 16px; height: 16px;">
                                            Personal Details
                                        </label>
                                        <label
                                            style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: #c62828;">
                                            <input type="checkbox" name="resubmit_steps[]" value="education"
                                                style="width: 16px; height: 16px;">
                                            Education Details
                                        </label>
                                        <label
                                            style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: #c62828;">
                                            <input type="checkbox" name="resubmit_steps[]" value="family"
                                                style="width: 16px; height: 16px;">
                                            Family Details
                                        </label>
                                        <label
                                            style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: #c62828;">
                                            <input type="checkbox" name="resubmit_steps[]" value="funding"
                                                style="width: 16px; height: 16px;">
                                            Funding Details
                                        </label>
                                        <label
                                            style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: #c62828;">
                                            <input type="checkbox" name="resubmit_steps[]" value="guarantor"
                                                style="width: 16px; height: 16px;">
                                            Guarantor Details
                                        </label>
                                        <label
                                            style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: #c62828;">
                                            <input type="checkbox" name="resubmit_steps[]" value="documents"
                                                style="width: 16px; height: 16px;">
                                            Documents
                                        </label>
                                        <label
                                            style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: #c62828;">
                                            <input type="checkbox" name="resubmit_steps[]" value="final"
                                                style="width: 16px; height: 16px;">
                                            Final Submission
                                        </label>
                                    </div>
                                    <p
                                        style="font-size: 0.75rem; color: #c62828; margin: 0.5rem 0 0 0; font-style: italic;">
                                        Leave unchecked to reject permanently
                                    </p>
                                </div>

                                <button type="submit" class="btn btn-reject" style="width: 100%;">
                                    <i class="fas fa-times"></i>
                                    Reject Application
                                </button>
                            </form>
                        </div> --}}
                    </div>

                    <!-- Decision Summary -->
                    <div class="data-item"
                        style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin-top: 2rem; border: 1px solid #e9ecef;">
                        <div class="data-label" style="font-weight: 600; color: #1976D2; font-size: 1.1rem;">
                            <i class="fas fa-chart-line"></i>
                            Application Summary
                        </div>
                        <div class="data-value" style="text-align: left;">
                            <div
                                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; margin-top: 0.5rem;">
                                <div style="text-align: center;">
                                    <div style="font-size: 1.2rem; font-weight: bold; color: #4CAF50;">
                                        @php
                                            $approvedCount = 0;
                                            if ($user->submit_status === 'approved') {
                                                $approvedCount++;
                                            }
                                            if (
                                                $user->educationDetail &&
                                                $user->educationDetail->submit_status === 'approved'
                                            ) {
                                                $approvedCount++;
                                            }
                                            if (
                                                $user->familyDetail &&
                                                $user->familyDetail->submit_status === 'approved'
                                            ) {
                                                $approvedCount++;
                                            }
                                            if (
                                                $user->fundingDetail &&
                                                $user->fundingDetail->submit_status === 'approved'
                                            ) {
                                                $approvedCount++;
                                            }
                                            if (
                                                $user->guarantorDetail &&
                                                $user->guarantorDetail->submit_status === 'approved'
                                            ) {
                                                $approvedCount++;
                                            }
                                            if ($user->document && $user->document->submit_status === 'approved') {
                                                $approvedCount++;
                                            }
                                            if ($user->document && $user->document->submit_status === 'approved') {
                                                $approvedCount++;
                                            } // final
                                        @endphp
                                        {{ $approvedCount }}/7
                                    </div>
                                    <div style="font-size: 0.8rem; color: #666;">Steps Approved</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="font-size: 1.2rem; font-weight: bold; color: #FF9800;">
                                        @php
                                            $interviewCount = \App\Models\ChapterInterviewAnswer::where(
                                                'user_id',
                                                $user->id,
                                            )
                                                ->where('workflow_id', $user->workflowStatus->id ?? 0)
                                                ->count();
                                        @endphp
                                        {{ $interviewCount }}/15
                                    </div>
                                    <div style="font-size: 0.8rem; color: #666;">Interview Q&A</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="font-size: 1.2rem; font-weight: bold; color: #1976D2;">
                                        {{ $user->workflowStatus ? ucfirst(str_replace('_', ' ', $user->workflowStatus->current_stage)) : 'N/A' }}
                                    </div>
                                    <div style="font-size: 0.8rem; color: #666;">Current Stage</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Show submitted decision details -->
                    <div style="margin-bottom: 2rem; padding: 2rem; border-radius: 12px; border: 2px solid #4CAF50;">
                        <h5 style="color: #2E7D32; margin: 0 0 1.5rem 0; font-size: 1.1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-check-circle"></i>
                            Decision Submitted - {{ ucfirst($user->workflowStatus->chapter_status ?? 'N/A') }}
                        </h5>

                        <div class="form-row" style="margin-bottom: 1rem;">
                            <div class="form-field form-field-full">
                                <label class="form-label" style="color: #2E7D32;">Interview Date</label>
                                <input type="date" class="form-input"
                                    value="{{ $user->workflowStatus->chapter_interview_date ? \Carbon\Carbon::parse($user->workflowStatus->chapter_interview_date)->format('Y-m-d') : '' }}"
                                    readonly
                                    style="border: 2px solid #4CAF50; background: rgba(76, 175, 80, 0.05);">
                            </div>
                        </div>

                        <div class="form-row" style="margin-bottom: 1rem;">
                            <div class="form-field form-field-full">
                                <label class="form-label" style="color: #2E7D32;">Total Expense</label>
                                <input type="text" class="form-input" value="{{ $data->group_4_total ?? 'NA' }}"
                                    readonly
                                    style="border: 2px solid #4CAF50; background: rgba(76, 175, 80, 0.05);">
                            </div>
                        </div>

                        <div class="form-row" style="margin-bottom: 1rem;">
                            <div class="form-field form-field-full">
                                <label class="form-label" style="color: #2E7D32;">Chapter Remarks (Question 14)</label>
                                <textarea class="remark-input" readonly style="border: 2px solid #4CAF50; background: rgba(76, 175, 80, 0.05); resize: vertical; min-height: 80px;">{{ \App\Models\ChapterInterviewAnswer::where('user_id', $user->id)->where('workflow_id', $user->workflowStatus->id ?? 0)->where('question_no', 14)->first()?->answer_text ?? 'Not answered' }}</textarea>
                            </div>
                        </div>

                        <div class="form-row" style="margin-bottom: 1rem;">
                            <div class="form-field form-field-full">
                                <label class="form-label" style="color: #2E7D32;">Recommended Financial Assistance Amount</label>
                                <input type="text" class="form-input"
                                    value="{{ $user->workflowStatus->chapter_assistance_amount ? '₹' . number_format($user->workflowStatus->chapter_assistance_amount) : '' }}"
                                    readonly
                                    style="border: 2px solid #4CAF50; background: rgba(76, 175, 80, 0.05);">
                            </div>
                        </div>

                        <div class="form-row" style="margin-bottom: 1rem;">
                            <div class="form-field form-field-full">
                                <label class="form-label" style="color: #2E7D32;">Approval Remarks</label>
                                <textarea readonly rows="4" class="remark-input" style="border: 2px solid #4CAF50; background: rgba(76, 175, 80, 0.05);">{{ $user->workflowStatus->chapter_approval_remarks ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
@endsection

<script>
    function showStep(stepNumber) {
        document.querySelectorAll('.step-content').forEach(content => {
            content.classList.remove('active');
        });

        document.querySelectorAll('.step-nav-item').forEach(item => {
            item.classList.remove('active');
        });

        // Handle both numeric steps (1, 2, 3...) and string steps (interview)
        const stepId = (typeof stepNumber === 'string') ? stepNumber : stepNumber;
        const stepElement = document.getElementById('step-' + stepId);
        const navElement = document.querySelector('.step-' + stepId);

        if (stepElement) {
            stepElement.classList.add('active');
        }
        if (navElement) {
            navElement.classList.add('active');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const activeStep = document.querySelector('.step-nav-item.active');
        if (activeStep) {
            activeStep.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest',
                inline: 'center'
            });
        }

        // Sync textarea values to hidden inputs for workflow forms
        const approveForm = document.querySelector('form[action*="approve"]');
        const rejectForm = document.querySelector('form[action*="reject"]');
        const approveTextarea = document.querySelector('.action-form-row textarea');
        const rejectTextarea = document.querySelectorAll('.action-form-row textarea')[1];

        if (approveForm && approveTextarea) {
            approveForm.addEventListener('submit', function() {
                document.getElementById('approve_remark').value = approveTextarea.value;
            });
        }

        if (rejectForm && rejectTextarea) {
            rejectForm.addEventListener('submit', function() {
                document.getElementById('reject_remark').value = rejectTextarea.value;
            });
        }



        // Load interview questions and answers
        loadInterviewQuestions();
        loadInterviewAnswers();
    });

    // Chapter Interview Functions
    const interviewQuestions = [
        "Please introduce about your family?",
        "What is father's occupation? And his monthly earning?",
        "What is mother's occupation? And her monthly earning?",
        "Share details about other family (bro/sis) (if joint family -uncle) if any?",
        "Please speak about yourself?",
        "Course you are going to pursue, reason to choose such course what is the job opportunity in this?",
        "Basic questions on Family expenses if any?",
        "Own/Rented house, EMI/Rent detail?",
        "Also ask if any loan applied from any other organization /NGO/ or bank and what is the amount?",
        "Why did you choose to apply for a loan from JITO JEAP organization and what is expectation?",
        "Is there anything else you would like to share or discuss regarding your loan application?",
        "Please call to both guarantor and confirm that they are standing as a guarantor for the students, and they know them both?",
        "Please call to reference for the family check details?",
        "Remarks / Reports from Chapter?"
    ];

    function loadInterviewQuestions() {
        const container = document.getElementById('interview-questions');
        if (!container) return;

        let html = '';
        interviewQuestions.forEach((question, index) => {
            const questionNo = index + 1;
            html += `
            <div class="form-row" style="margin-bottom: 1.5rem; padding: 1.5rem; background: rgba(255,255,255,0.95); border-radius: 10px; border-left: 5px solid #7B1FA2; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="form-field form-field-full">
                    <label class="form-label" style="font-weight: 600; color: #7B1FA2; margin-bottom: 0.75rem; font-size: 1rem; display: block;">
                        <span style="background: #7B1FA2; color: white; padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.75rem; margin-right: 0.5rem;">Q${questionNo}</span>
                        ${question}
                    </label>
                    <textarea
                        name="answers[${questionNo}]"
                        class="form-input interview-answer"
                        data-question-no="${questionNo}"
                        data-question-text="${question}"
                        rows="4"
                        placeholder="Enter your detailed answer here..."
                        style="resize: vertical; min-height: 100px; border: 2px solid #e9ecef; border-radius: 8px; padding: 1rem;"
                    ></textarea>
                </div>
            </div>
        `;
        });

        container.innerHTML = html;
    }

    async function loadInterviewAnswers() {
        const userId = document.querySelector('input[name="user_id"]').value;
        const workflowId = document.querySelector('input[name="workflow_id"]').value;

        if (!userId || !workflowId) return;

        try {
            const response = await fetch(`/admin/chapter/interview/answers/${userId}/${workflowId}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const answers = await response.json();

                // Fill in the answers
                answers.forEach(answer => {
                    const textarea = document.querySelector(
                        `textarea[data-question-no="${answer.question_no}"]`);
                    if (textarea) {
                        textarea.value = answer.answer_text;
                    }
                });
            }
        } catch (error) {
            console.error('Error loading interview answers:', error);
        }
    }

    async function saveInterviewAnswers() {
        const userId = document.querySelector('input[name="user_id"]').value;
        const workflowId = document.querySelector('input[name="workflow_id"]').value;

        if (!userId || !workflowId) {
            alert('User or workflow information is missing');
            return;
        }

        const answers = [];
        const textareas = document.querySelectorAll('.interview-answer');

        textareas.forEach(textarea => {
            const answerText = textarea.value.trim();
            if (answerText) {
                answers.push({
                    question_no: parseInt(textarea.dataset.questionNo),
                    question_text: textarea.dataset.questionText,
                    answer_text: answerText
                });
            }
        });

        if (answers.length === 0) {
            alert('Please provide at least one answer');
            return;
        }

        try {
            const saveButton = document.querySelector('button[onclick="saveInterviewAnswers()"]');
            const originalText = saveButton.innerHTML;
            saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            saveButton.disabled = true;

            const response = await fetch('/admin/chapter/interview/save', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    user_id: userId,
                    workflow_id: workflowId,
                    answers: answers,
                    answered_by: 'chapter' // or 'admin' based on user role
                })
            });

            if (response.ok) {
                const result = await response.json();
                alert('Interview answers saved successfully!');
            } else {
                const error = await response.json();
                alert('Error saving answers: ' + (error.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error saving interview answers:', error);
            alert('Error saving answers. Please try again.');
        } finally {
            const saveButton = document.querySelector('button[onclick="saveInterviewAnswers()"]');
            saveButton.innerHTML = '<i class="fas fa-save"></i> Save Interview Answers';
            saveButton.disabled = false;
        }
    }
</script>
