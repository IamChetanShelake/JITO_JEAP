@extends('admin.layouts.master')

@section('title', 'Working Committee User Details - JitoJeap Admin')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('summernotes/summernote-lite.min.css') }}">
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
            overflow: hidden;
        }

        .user-avatar-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
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

        .user-info-footer {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.5rem;
        }

        .user-info-footer p {
            margin: 0.25rem 0;
            font-size: 0.9rem;
        }

        .steps-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            display: flex;
            align-items: flex-start;
        }

        .content-area {
            flex: 1;
            overflow-y: auto;
            min-height: 0;
            /* Allow shrinking */
        }

        .step-nav {
            background: var(--bg-light);
            display: flex;
            flex-direction: column;
            width: 250px;
            overflow-y: auto;
            scrollbar-width: thin;
        }

        .step-nav-item {
            text-align: center;
            padding: 1rem 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border-bottom: 1px solid var(--border-color);
            border-right: 3px solid transparent;
            position: relative;
        }

        .step-nav-item.active {
            background: white;
            border-right-color: var(--primary-purple);
            color: var(--primary-purple);
            font-weight: 600;
        }

        .step-nav-item.completed {
            background: #e8f5e9;
            border-right-color: var(--primary-green);
            color: var(--primary-green);
        }

        .step-nav-item.pending {
            background: #fff8e1;
            border-right-color: var(--primary-yellow);
            color: var(--primary-yellow);
        }

        .step-nav-item.hold {
            background: #ffebee;
            border-right-color: var(--primary-red);
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
            min-height: 500px;
        }

        .step-content.active {
            display: block;
            width: 1085px;
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

        .form-field2 {
            flex: 1;
            width: 33%;
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

            .steps-container {
                flex-direction: column;
            }

            .step-nav {
                width: auto;
                flex-direction: row;
                border-right: none;
                border-bottom: 1px solid var(--border-color);
                overflow-x: auto;
            }

            .step-nav-item {
                border-right: none;
                border-bottom: 3px solid transparent;
                flex: 1;
                min-width: 120px;
            }

            .step-nav-item.active {
                border-bottom-color: var(--primary-purple);
                border-right-color: transparent;
            }

            .step-nav-item.completed {
                border-bottom-color: var(--primary-green);
                border-right-color: transparent;
            }

            .step-nav-item.pending {
                border-bottom-color: var(--primary-yellow);
                border-right-color: transparent;
            }

            .step-nav-item.hold {
                border-bottom-color: var(--primary-red);
                border-right-color: transparent;
            }
        }

        .top-summary-layout {
            display: grid;
            grid-template-columns: 1fr 4fr;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .top-summary-layout .user-info-card {
            margin-bottom: 0 !important;
        }

        .top-card-user {
            order: 2;
        }

        .top-card-workflow {
            order: 1;
        }

        @media (max-width: 991.98px) {
            .top-summary-layout {
                grid-template-columns: 1fr;
            }

            .top-card-user,
            .top-card-workflow {
                order: unset;
            }
        }

        /* Document button highlighting styles */
        .doc-button {
            transition: all 0.3s ease;
        }

        .doc-button.active {
            background: var(--primary-purple) !important;
            color: white !important;
            font-weight: 600 !important;
            border-color: var(--primary-purple) !important;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-title-section">
            <h1 class="page-title">
                <i class="fas fa-users-cog" style="color: var(--primary-purple); margin-right: 0.5rem;"></i>
                Working Committee User Details
            </h1>
            <p class="page-subtitle">Review and approve working committee steps</p>
        </div>
        <div style="display: flex; gap: 1rem; align-items: center;">
            @php
                $jeapPdfDir = public_path('Jeap_pdfs');
                $referencePdfs = collect();
                if (is_dir($jeapPdfDir)) {
                    $referencePdfs = collect(\Illuminate\Support\Facades\File::files($jeapPdfDir))
                        ->map(fn($file) => $file->getFilename())
                        ->filter(fn($name) => str_ends_with($name, '.pdf'))
                        ->sort()
                        ->values();
                }
            @endphp
            <!-- Print Options Dropdown -->
            <div class="dropdown" style="position: relative;">
                <button class="back-btn" style="background-color: var(--primary-yellow); color: #333;"
                    onclick="toggleDropdown()">
                    <i class="fas fa-print"></i> Print Options <i class="fas fa-chevron-down"
                        style="margin-left: 0.5rem;"></i>
                </button>
                <div id="printDropdown" class="dropdown-content"
                    style="display: none; position: absolute; top: 100%; left: 0; background: white; border: 1px solid var(--border-color); border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 1000; min-width: 200px;">
                    <a href="{{ route('admin.user.generate.pdf', $user) }}" class="dropdown-item" target="_blank"
                        style="display: block; padding: 0.75rem 1rem; color: var(--text-dark); text-decoration: none; border-bottom: 1px solid var(--border-color);">
                        <i class="fas fa-download" style="margin-right: 0.5rem;"></i> Application PDF
                    </a>
                    <a href="{{ route('admin.user.generate.summary.pdf', $user) }}" class="dropdown-item" target="_blank"
                        style="display: block; padding: 0.75rem 1rem; color: var(--text-dark); text-decoration: none; border-bottom: 1px solid var(--border-color);">
                        <i class="fas fa-file-alt" style="margin-right: 0.5rem;"></i> Summary PDF
                    </a>
                    <a href="{{ route('admin.user.sanction.letter', $user) }}" target="_blank" class="dropdown-item"
                        style="display: block; padding: 0.75rem 1rem; color: var(--text-dark); text-decoration: none;">
                        <i class="fas fa-file-contract" style="margin-right: 0.5rem;"></i> Sanction Letter
                    </a>
                    <a href="{{ route('admin.user.generate.shortsummary.pdf', $user) }}" class="dropdown-item"
                        style="display: block; padding: 0.75rem 1rem; color: var(--text-dark); text-decoration: none; border-top: 1px solid var(--border-color);">
                        <i class="fas fa-file-alt" style="margin-right: 0.5rem;"></i> Short Summary PDF
                    </a>

                    <a href="{{ route('admin.user.generate.financial_closure.pdf', $user) }}" class="dropdown-item"
                        style="display: block; padding: 0.75rem 1rem; color: var(--text-dark); text-decoration: none;">
                        <i class="fas fa-file-alt" style="margin-right: 0.5rem;"></i> Financial Closure PDF
                    </a>
                    @if ($referencePdfs->isNotEmpty())
                        <div style="border-top: 1px solid var(--border-color); margin-top: 0.25rem;"></div>
                        <div style="padding: 0.5rem 1rem; font-size: 0.85rem; color: var(--text-light);">
                            JEAP Reference PDFs
                        </div>
                        @foreach ($referencePdfs as $pdfFile)
                            <a href="{{ asset('Jeap_pdfs/' . $pdfFile) }}" target="_blank" class="dropdown-item"
                                style="display: block; padding: 0.75rem 1rem; color: var(--text-dark); text-decoration: none;">
                                <i class="fas fa-file-pdf" style="margin-right: 0.5rem;"></i>{{ $pdfFile }}
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>

            <a href="{{ route('admin.home') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <!-- User Info Card -->
    <div class="top-summary-layout">
        <!-- User Info Card (Right) -->
        <div class="user-info-card top-card-user">
            <div class="user-info-header">
                <div class="user-avatar">
                    @if ($user->image)
                        <img src="{{ asset($user->image) }}" alt="Photo" class="user-avatar-img" style="width:90px;">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                </div>
                <div class="user-details">
                    <h3>{{ $user->name }}</h3>
                    <p>{{ $user->email }}</p>
                    <p>{{ $user->phone }}</p>
                    <p>{{ $user->application_no }}</p>
                </div>

            </div>
            <div style="text-align: right; margin-top: -2.5rem;">
                <a href="{{ route('admin.user.logs', ['user' => $user->id]) }}" class="back-btn"
                    style="background-color: var(--primary-blue); color: white; text-decoration: none; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease;">
                    <i class="fas fa-history"></i> Logs
                </a>
            </div>
            <div class="user-info-footer">
                <p><strong>Registration Date:</strong> {{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}
                </p>
                <p><strong>Financial Assistance Type:</strong>
                    {{ $user->financial_asset_type ? ucwords(str_replace('_', ' ', $user->financial_asset_type)) : 'N/A' }}
                </p>
                <p><strong>Financial Assistance For:</strong>
                    {{ $user->financial_asset_for ? ucwords(str_replace('_', ' ', $user->financial_asset_for)) : 'N/A' }}
                </p>
            </div>
        </div>

        <!-- Workflow Status Card (Left) -->
        <div class="user-info-card top-card-workflow">
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
        </div>
    </div>

    @php
        $isBelowLoan = $loanCategory && $loanCategory->type === 'below';
    @endphp


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
            @if (!$isBelowLoan)
                <div class="step-nav-item step-5" onclick="showStep(5)">
                    <span class="step-number">5</span>
                    <span class="step-title">Guarantor Details</span>
                </div>
            @endif
            <div class="step-nav-item step-6" onclick="showStep(6)">
                <span class="step-number">{{ $isBelowLoan ? 5 : 6 }}</span>
                <span class="step-title">Documents</span>
            </div>
            <div class="step-nav-item step-7" onclick="showStep(7)">
                <span class="step-number">{{ $isBelowLoan ? 6 : 7 }}</span>
                <span class="step-title">Final Submission</span>
            </div>
            <div class="step-nav-item step-8" onclick="showStep(8)">
                <span class="step-number">{{ $isBelowLoan ? 7 : 8 }}</span>
                <span class="step-title">Working Committee Decision</span>
            </div>
        </div>

        <div class="content-area">

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
                                    <input type="tel" class="form-input"
                                        value="{{ $user->alternate_phone ?? 'N/A' }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-input" value="{{ $user->email }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Alternate Email</label>
                                    <input type="email" class="form-input"
                                        value="{{ $user->alternate_email ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Marital Status</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->marital_status ?? 'N/A' }}" readonly>
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
                                    <input type="text" class="form-input" value="{{ $user->d_o_b ?? 'N/A' }}"
                                        readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Birth Place</label>
                                    <input type="text" class="form-input" value="{{ $user->birth_place ?? 'N/A' }}"
                                        readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Gender</label>
                                    <input type="text" class="form-input" value="{{ $user->gender ?? 'N/A' }}"
                                        readonly>
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
                                    <input type="text" class="form-input"
                                        value="{{ $user->specially_abled ?? 'N/A' }}" readonly>
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
                                    <input type="text" class="form-input" value="{{ $user->flat_no ?? 'N/A' }}"
                                        readonly>
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
                                    <input type="text" class="form-input" value="{{ $user->area ?? 'N/A' }}"
                                        readonly>
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
                                    <input type="text" class="form-input" value="{{ $user->city ?? 'N/A' }}"
                                        readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">District</label>
                                    <input type="text" class="form-input" value="{{ $user->district ?? 'N/A' }}"
                                        readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">State</label>
                                    <input type="text" class="form-input" value="{{ $user->state ?? 'N/A' }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Chapter</label>
                                    <input type="text" class="form-input" value="{{ $user->chapter ?? 'N/A' }}"
                                        readonly>
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
                                            value="{{ ucfirst($user->educationDetail->qualifications ?? 'N/A') }}"
                                            readonly>
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
                                            value="{{ $user->educationDetail->school_completion_year ?? 'N/A' }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-field">
                                        <label class="form-label">Marks Obtained</label>
                                        <input type="text" class="form-input"
                                            value="{{ $user->educationDetail->{'10th_mark_obtained'} ?? 'N/A' }}"
                                            readonly>
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
                                            value="{{ $user->educationDetail->{'12th_mark_obtained'} ?? 'N/A' }}"
                                            readonly>
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

                    </div> <!-- content-area -->
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
                                        value="₹{{ number_format($user->familyDetail->total_insurance_coverage) }}"
                                        readonly>
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
                                <div class="form-field">
                                    <label class="form-label">Current Year ITR</label>
                                    <input type="text" class="form-input"
                                        value="₹{{ number_format($user->familyDetail->current_year_itr ?? 0) }}"
                                        readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Last Year ITR</label>
                                    <input type="text" class="form-input"
                                        value="₹{{ number_format($user->familyDetail->last_year_itr ?? 0) }}" readonly>
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
                                            <input type="text" class="form-input"
                                                value="{{ $member['name'] ?? 'N/A' }}" readonly>
                                        </div>
                                        <div class="form-field">
                                            <label class="form-label">Relation</label>
                                            <input type="text" class="form-input"
                                                value="{{ $member['relation'] ?? 'N/A' }}" readonly>
                                        </div>
                                        <div class="form-field">
                                            <label class="form-label">Age</label>
                                            <input type="text" class="form-input"
                                                value="{{ $member['age'] ?? 'N/A' }}" readonly>
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
                </div>
            </div>

            @if ($user->fundingDetail)
                <div class="form-data">
                    <!-- Funding Sources Table -->
                    @if (!($loanCategory && $loanCategory->type === 'below'))
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
                                                ₹{{ number_format($user->fundingDetail->family_funding_amount ?? 0) }}
                                            </td>
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
                                                ₹{{ number_format($user->fundingDetail->other_assistance1_amount ?? 0) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Other Assistance (2)</td>
                                            <td>{{ ucfirst($user->fundingDetail->other_assistance2_status) }}</td>
                                            <td>{{ $user->fundingDetail->other_assistance2_trust ?? '-' }}</td>
                                            <td>{{ $user->fundingDetail->other_assistance2_contact ?? '-' }}</td>
                                            <td>{{ $user->fundingDetail->other_assistance2_mobile ?? '-' }}</td>
                                            <td class="amount-cell">
                                                ₹{{ number_format($user->fundingDetail->other_assistance2_amount ?? 0) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Local Assistance</td>
                                            <td>{{ ucfirst($user->fundingDetail->local_assistance_status) }}</td>
                                            <td>{{ $user->fundingDetail->local_assistance_trust ?? '-' }}</td>
                                            <td>{{ $user->fundingDetail->local_assistance_contact ?? '-' }}</td>
                                            <td>{{ $user->fundingDetail->local_assistance_mobile ?? '-' }}</td>
                                            <td class="amount-cell">
                                                ₹{{ number_format($user->fundingDetail->local_assistance_amount ?? 0) }}
                                            </td>
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
                    @endif

                    <div class="data-group">
                        <h4>Sibling Assistance</h4>
                        <div class="form-section">
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Sibling Assistance</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->fundingDetail->sibling_assistance ? ucfirst($user->fundingDetail->sibling_assistance) : 'N/A' }}"
                                        readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Sibling Name</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->fundingDetail->sibling_name ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Sibling Number</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->fundingDetail->sibling_number ?? 'N/A' }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Sibling NGO Name</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->fundingDetail->sibling_ngo_name ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">NGO Number</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->fundingDetail->ngo_number ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Sibling Loan Status</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->fundingDetail->sibling_loan_status ? ucfirst($user->fundingDetail->sibling_loan_status) : 'N/A' }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Sibling Applied Year</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->fundingDetail->sibling_applied_year ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Sibling Applied Amount (Rs)</label>
                                    <input type="text" class="form-input"
                                        value="@if (is_numeric($user->fundingDetail->sibling_applied_amount)) {{ number_format($user->fundingDetail->sibling_applied_amount) }} @else {{ $user->fundingDetail->sibling_applied_amount ?? 'N/A' }} @endif"
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
                                    <input type="text" class="form-input"
                                        value="{{ $user->fundingDetail->bank_name }}" readonly>
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
                                    <input type="text" class="form-input"
                                        value="{{ $user->fundingDetail->ifsc_code }}" readonly>
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

        @if (!$isBelowLoan)
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
                                            value="{{ ucfirst($user->guarantorDetail->g_one_gender ?? 'N/A') }}"
                                            readonly>
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
                                            value="{{ $user->guarantorDetail->g_one_relation_with_student ?? 'N/A' }}"
                                            readonly>
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
                                            value="{{ $user->guarantorDetail->g_one_aadhar_card_number ?? 'N/A' }}"
                                            readonly>
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
                                        <div class="form-input"
                                            style="padding:0.5rem; background:transparent; border:none;">
                                            @if (!empty($user->guarantorDetail->g_one_pan_card_upload))
                                                <a href="#"
                                                    onclick="openModal('{{ asset($user->guarantorDetail->g_one_pan_card_upload) }}')">View
                                                    PAN</a>
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
                                            value="{{ ucfirst($user->guarantorDetail->g_two_gender ?? 'N/A') }}"
                                            readonly>
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
                                            value="{{ $user->guarantorDetail->g_two_relation_with_student ?? 'N/A' }}"
                                            readonly>
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
                                            value="{{ $user->guarantorDetail->g_two_aadhar_card_number ?? 'N/A' }}"
                                            readonly>
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
                                        <div class="form-input"
                                            style="padding:0.5rem; background:transparent; border:none;">
                                            @if (!empty($user->guarantorDetail->g_two_pan_card_upload))
                                                <a href="#"
                                                    onclick="openModal('{{ asset($user->guarantorDetail->g_two_pan_card_upload) }}')">View
                                                    PAN</a>
                                            @else
                                                <span style="color:#6c757d;">N/A</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="no-data">
                        <p>Guarantor details not submitted yet.</p>
                    </div>
                @endif
            </div>
        @endif

        <!-- Step 6: Documents -->
        <div class="step-content" id="step-6">
            <div class="step-header">
                <h2 class="step-title-large">Step {{ $isBelowLoan ? 5 : 6 }}: Documents</h2>
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
                        <div class="form-section"
                            style="display: grid; grid-template-columns: 0.3fr 1fr; gap: 2rem; min-height: 500px;">
                            <!-- Document List -->
                            <div
                                style="border-right: 1px solid var(--border-color); padding-right: 1rem; overflow-y: auto; max-height: 500px;">
                                <h5 style="margin-bottom: 1rem; color: var(--text-dark); font-size: 1rem;">Document List
                                </h5>
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

                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    @foreach ($fields as $key => $label)
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
                                            <button class="doc-button"
                                                onclick="selectDocument(event, '{{ $href }}', '{{ $label }}')"
                                                style="text-align: left; padding: 0.75rem 1rem; background: white; color: var(--text-dark); border: 1px solid var(--border-color); border-radius: 6px; cursor: pointer; transition: all 0.3s ease; font-size: 0.9rem; font-weight: 400;">
                                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                    <i class="fas fa-file-alt" style="font-size: 0.8rem;"></i>
                                                    {{ $label }}
                                                </div>
                                            </button>
                                        @else
                                            <div
                                                style="padding: 0.75rem 1rem; color: var(--text-light); font-size: 0.9rem; opacity: 0.6;">
                                                <i class="fas fa-file-alt" style="margin-right: 0.5rem;"></i>
                                                {{ $label }} (Not uploaded)
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- Document Preview -->
                            <div style="padding-left: 1rem; display: flex; flex-direction: column;">
                                <h5
                                    style="margin-bottom: 1rem; color: var(--text-dark); font-size: 1rem; display: flex; justify-content: space-between; align-items: center;">
                                    Document Preview
                                    <button id="docDownloadBtn" onclick="downloadCurrentDoc()"
                                        style="display: none; padding: 0.4rem 0.8rem; background: var(--primary-purple); color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">
                                        <i class="fas fa-download"></i> Download
                                    </button>
                                </h5>
                                <div id="documentPreview"
                                    style="flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; background: var(--bg-light); border-radius: 8px; border: 1px solid var(--border-color); padding: 2rem;">
                                    <i class="fas fa-file-image"
                                        style="font-size: 4rem; color: var(--text-light); margin-bottom: 1rem;"></i>
                                    <p style="color: var(--text-light); font-size: 1rem;">Select a document from the left
                                        to preview</p>
                                    <p style="color: var(--text-light); font-size: 0.85rem; margin-top: 0.5rem;">Click on
                                        any document name to view its content</p>
                                </div>
                            </div>
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
                <h2 class="step-title-large">Step {{ $isBelowLoan ? 6 : 7 }}: Final Submission</h2>
                <div class="step-status">
                    <span
                        class="status-badge status-{{ $user->document ? ($user->document->submit_status == 'approved' ? 'approved' : ($user->document->submit_status == 'resubmit' ? 'hold' : 'pending')) : 'pending' }}">
                        <i class="fas fa-circle" style="font-size: 0.6rem;"></i>
                        {{ $user->document ? ucfirst($user->document->submit_status) : 'Pending' }}
                    </span>
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
                            @if ($user->document && $user->application_status == 'submitted')
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
                        <div class="data-value">{{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}
                        </div>
                    </div>
                    <div class="data-item">
                        <div class="data-label">Last Updated</div>
                        <div class="data-value">{{ $user->updated_at ? $user->updated_at->format('d M Y H:i') : 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 8: Working Committee Decision -->
        <div class="step-content" id="step-8">
            <div class="step-header">
                <h2 class="step-title-large">Step {{ $isBelowLoan ? 7 : 8 }}: Working Committee Decision</h2>
                <div class="step-status">
                    <span class="status-badge status-approved">
                        <i class="fas fa-circle" style="font-size: 0.6rem;"></i>
                        In Progress
                    </span>
                </div>
            </div>

            <!-- Inside step-8 content-area, after the if conditions for approved/hold/rejected -->

            @if (
                $user->workflowStatus &&
                    in_array($user->workflowStatus->working_committee_status, ['approved', 'hold', 'rejected']))
                <div style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 0.75rem; flex-wrap: wrap;">
                    @if ($user->workingCommitteeApproval)
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#editDisbursementDatesModal">
                            <i class="fas fa-calendar-alt"></i> Edit Disbursement Dates
                        </button>
                    @endif
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#editWorkingCommitteeModal">
                        <i class="fas fa-edit"></i> Edit Working Committee Decision
                    </button>
                </div>
            @endif

            @if ($user->workflowStatus && $user->workflowStatus->working_committee_status === 'approved')
                <!-- Display Submitted Working Committee Data -->
                <div class="form-data">
                    <div class="data-group">
                        <h4>Submitted Working Committee Decision</h4>
                        <div class="form-section">
                            <!-- Working Committee Approval Details -->
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Working Committee Approval Remark</label>
                                    <textarea class="form-textarea" readonly>{{ strip_tags($user->workflowStatus->working_committee_approval_remarks ?? 'N/A') }}</textarea>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Approval Date</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->workflowStatus->working_committee_updated_at ? \Carbon\Carbon::parse($user->workflowStatus->working_committee_updated_at)->format('d M Y') : 'N/A' }}"
                                        readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Meeting Number</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->workingCommitteeApproval->meeting_no ?? 'N/A' }}" readonly>
                                </div>
                                @if ($user->workingCommitteeApproval && $user->workingCommitteeApproval->document)
                                    <div class="form-field">
                                        <label class="form-label">Document</label>
                                        @php
                                            $documentPath = $user->workingCommitteeApproval->document;
                                            $extension = pathinfo($documentPath, PATHINFO_EXTENSION);
                                        @endphp
                                        @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                            <a href="{{ asset('working_committee_documents/' . $documentPath) }}"
                                                target="_blank">
                                                <img src="{{ asset('working_committee_documents/' . $documentPath) }}"
                                                    alt="Document"
                                                    style="max-width: 200px; max-height: 200px; border: 1px solid #ddd; border-radius: 4px;">
                                            </a>
                                        @elseif (strtolower($extension) === 'pdf')
                                            <a href="{{ asset('working_committee_documents/' . $documentPath) }}"
                                                target="_blank" class="btn btn-sm"
                                                style="background: #e74c3c; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; display: inline-block;">
                                                <i class="fas fa-file-pdf"></i> View PDF
                                            </a>
                                        @else
                                            <a href="{{ asset('storage/' . $documentPath) }}" target="_blank"
                                                class="btn btn-sm"
                                                style="background: #3498db; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; display: inline-block;">
                                                <i class="fas fa-file"></i> View Document
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Disbursement Schedules -->
                            @if (
                                $user->workingCommitteeApproval->disbursement_system === 'yearly' &&
                                    $user->workingCommitteeApproval->yearly_dates &&
                                    is_array($user->workingCommitteeApproval->yearly_dates))
                                @php
                                    $yearlyDates = $user->workingCommitteeApproval->yearly_dates;
                                    $yearlyAmounts = $user->workingCommitteeApproval->yearly_amounts;
                                @endphp
                                @if ($yearlyDates && $yearlyAmounts && is_array($yearlyDates) && is_array($yearlyAmounts))
                                    <div class="form-row">
                                        <div class="form-field form-field-full">
                                            <label class="form-label">Yearly Disbursement Schedule</label>
                                            <div class="table-container">
                                                <table class="custom-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Year</th>
                                                            <th>Disbursement Date</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($yearlyDates as $index => $date)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                                                                </td>
                                                                <td class="amount-cell">
                                                                    ₹{{ number_format($yearlyAmounts[$index] ?? 0, 2) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            <!-- Disbursement System and Financial Details -->
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Disbursement System</label>
                                    <input type="text" class="form-input"
                                        value="{{ ucfirst($user->workingCommitteeApproval->disbursement_system ?? 'N/A') }}"
                                        readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Approved Financial Assistance Amount</label>
                                    <input type="text" class="form-input"
                                        value="₹{{ number_format($user->workingCommitteeApproval->approval_financial_assistance_amount ?? 0, 2) }}"
                                        readonly>
                                </div>
                            </div>

                            <!-- Installment Details Table -->
                            @if (
                                $user->workingCommitteeApproval->installment_amount &&
                                    is_array($user->workingCommitteeApproval->installment_amount))
                                <div class="form-row">
                                    <div class="form-field form-field-full">
                                        <label class="form-label">Installment Details</label>
                                        <div class="table-container">
                                            <table class="custom-table">
                                                <thead>
                                                    <tr>
                                                        <th>Sr No</th>
                                                        <th>Installment Amount</th>
                                                        <th>No. of Months</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($user->workingCommitteeApproval->installment_amount as $index => $installmentAmount)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td class="amount-cell">
                                                                ₹{{ number_format($installmentAmount ?? 0, 2) }}</td>
                                                            <td>{{ $user->workingCommitteeApproval->no_of_months[$index] ?? 'N/A' }}
                                                            </td>
                                                            <td class="amount-cell">
                                                                ₹{{ number_format($user->workingCommitteeApproval->total[$index] ?? 0, 2) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Additional Installment Amount</label>
                                    <input type="text" class="form-input"
                                        value="₹{{ number_format($user->workingCommitteeApproval->additional_installment_amount ?? 0, 2) }}"
                                        readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Repayment Type</label>
                                    <input type="text" class="form-input"
                                        value="{{ ucfirst($user->workingCommitteeApproval->repayment_type ?? 'N/A') }}"
                                        readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">No. of Cheques to be Collected</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->workingCommitteeApproval->no_of_cheques_to_be_collected ?? 'N/A' }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Repayment Starting From</label>
                                    <input type="text" class="form-input"
                                        value="{{ optional($user->workingCommitteeApproval)->repayment_starting_from ? \Carbon\Carbon::parse(optional($user->workingCommitteeApproval)->repayment_starting_from)->format('d M Y') : 'N/A' }}"
                                        readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Processed By</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->workingCommitteeApproval->processed_by_name ?? 'N/A' }}"
                                        readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Can he/she be JITO Member?</label>
                                    <input type="text" class="form-input"
                                        value="{{ ucfirst($user->workingCommitteeApproval->can_be_jito_member ?? 'N/A') }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">JITO Member Date</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->workingCommitteeApproval->jito_member_date ? \Carbon\Carbon::parse($user->workingCommitteeApproval->jito_member_date)->format('d M Y') : 'N/A' }}"
                                        readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Can he/she be Donor for JEAP?</label>
                                    <input type="text" class="form-input"
                                        value="{{ ucfirst($user->workingCommitteeApproval->can_be_jeap_donor ?? 'N/A') }}"
                                        readonly>
                                </div>
                                <div class="form-field">
                                    <label class="form-label">JEAP Donor Date</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->workingCommitteeApproval->jeap_donor_date ? \Carbon\Carbon::parse($user->workingCommitteeApproval->jeap_donor_date)->format('d M Y') : 'N/A' }}"
                                        readonly>
                                </div>
                                {{--  <div class="form-field">
                                    <label class="form-label">Approval Status</label>
                                    <input type="text" class="form-input"
                                        value="{{ ucfirst($user->workingCommitteeApproval->working_committee_status ?? 'N/A') }}"
                                        readonly>
                                </div>  --}}
                            </div>

                            <!-- Remarks for Approval -->
                            @if ($user->workingCommitteeApproval->remarks_for_approval)
                                <div class="form-row">
                                    <div class="form-field form-field-full">
                                        <label class="form-label">Remarks for Approval</label>
                                        <textarea class="form-textarea" readonly>{{ strip_tags($user->workingCommitteeApproval->remarks_for_approval ?? 'N/A') }}</textarea>
                                    </div>
                                </div>
                            @endif



                            @if (
                                $user->workingCommitteeApproval->disbursement_system === 'half_yearly' &&
                                    $user->workingCommitteeApproval->half_yearly_dates &&
                                    is_array($user->workingCommitteeApproval->half_yearly_dates))
                                @php
                                    $halfYearlyDates = $user->workingCommitteeApproval->half_yearly_dates;
                                    $halfYearlyAmounts = $user->workingCommitteeApproval->half_yearly_amounts;
                                @endphp
                                @if ($halfYearlyDates && $halfYearlyAmounts && is_array($halfYearlyDates) && is_array($halfYearlyAmounts))
                                    <div class="form-row">
                                        <div class="form-field form-field-full">
                                            <label class="form-label">Half-Yearly Disbursement Schedule</label>
                                            <div class="table-container">
                                                <table class="custom-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Half Year</th>
                                                            <th>Disbursement Date</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($halfYearlyDates as $index => $date)
                                                            <tr>
                                                                <td>{{ $index + 1 }}
                                                                    ({{ $index % 2 === 0 ? '1st Half' : '2nd Half' }})
                                                                </td>
                                                                <td>{{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                                                                </td>
                                                                <td class="amount-cell">
                                                                    ₹{{ number_format($halfYearlyAmounts[$index] ?? 0, 2) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            <!-- Previous Approvals Info -->
                            <div class="form-row">
                                <div class="form-field form-field-full">
                                    <label class="form-label">Previous Approvals Information</label>
                                    <div
                                        style="background: rgba(76, 175, 80, 0.05); padding: 1rem; border-radius: 8px; border: 1px solid rgba(76, 175, 80, 0.2);">
                                        <div class="form-row">
                                            <div class="form-field">
                                                <label class="form-label">Apex 1 Approval Remark</label>
                                                <textarea class="form-input" readonly>{{ strip_tags($user->workflowStatus->apex_1_approval_remarks ?? 'N/A') }}</textarea>
                                            </div>
                                            <div class="form-field">
                                                <label class="form-label">Apex 1 Approval Date</label>
                                                <input type="text" class="form-input"
                                                    value="{{ $user->workflowStatus->apex_1_updated_at ? \Carbon\Carbon::parse($user->workflowStatus->apex_1_updated_at)->format('d M Y') : 'N/A' }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-field">
                                                <label class="form-label">Chapter Approval Remark</label>
                                                <textarea class="form-input" readonly>{{ strip_tags($user->workflowStatus->chapter_approval_remarks ?? 'N/A') }}</textarea>
                                            </div>
                                            <div class="form-field">
                                                <label class="form-label">Chapter Approval Date</label>
                                                <input type="text" class="form-input"
                                                    value="{{ $user->workflowStatus->chapter_updated_at ? \Carbon\Carbon::parse($user->workflowStatus->chapter_updated_at)->format('d M Y') : 'N/A' }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-field">
                                                <label class="form-label">Total Expenses of Student</label>
                                                <input type="text" class="form-input"
                                                    value="₹{{ number_format($user->educationDetail->group_4_total ?? 0) }}"
                                                    readonly>
                                            </div>
                                            <div class="form-field">
                                                <label class="form-label">Recommended Financial Amount by Chapter</label>
                                                <input type="text" class="form-input"
                                                    value="₹{{ number_format($user->workflowStatus->chapter_assistance_amount ?? 0) }}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @php
                $historyFieldLabels = [
                    'approval_financial_assistance_amount' => 'Approved Financial Assistance Amount',
                    'meeting_no' => 'Meeting Number',
                    'w_c_approval_date' => 'Approval Date',
                    'disbursement_system' => 'Disbursement System',
                    'disbursement_in_year' => 'Disbursement In Year',
                    'disbursement_in_half_year' => 'Disbursement In Half Year',
                    'yearly_dates' => 'Yearly Disbursement Dates',
                    'yearly_amounts' => 'Yearly Disbursement Amounts',
                    'half_yearly_dates' => 'Half-Yearly Disbursement Dates',
                    'half_yearly_amounts' => 'Half-Yearly Disbursement Amounts',
                    'installment_amount' => 'Installment Amounts',
                    'no_of_months' => 'No. of Months',
                    'total' => 'Total',
                    'additional_installment_amount' => 'Additional Installment Amount',
                    'repayment_type' => 'Repayment Type',
                    'repayment_starting_from' => 'Repayment Starting From',
                    'no_of_cheques_to_be_collected' => 'No. of Cheques to be Collected',
                    'w_c_approval_remark' => 'Working Committee Approval Remark',
                    'remarks_for_approval' => 'Remarks for Approval',
                    'can_be_jito_member' => 'Can be JITO Member',
                    'jito_member_date' => 'JITO Member Date',
                    'can_be_jeap_donor' => 'Can be JEAP Donor',
                    'jeap_donor_date' => 'JEAP Donor Date',
                ];

                $formatHistoryValue = function ($field, $value) {
                    if ($value === null || $value === '') {
                        return 'N/A';
                    }

                    if (is_array($value)) {
                        if (count($value) === 0) {
                            return 'N/A';
                        }
                        $formattedItems = [];
                        foreach ($value as $item) {
                            if ($item === null || $item === '') {
                                $formattedItems[] = 'N/A';
                                continue;
                            }
                            if (str_contains($field, 'date')) {
                                try {
                                    $formattedItems[] = \Carbon\Carbon::parse($item)->format('d M Y');
                                } catch (\Exception $e) {
                                    $formattedItems[] = $item;
                                }
                            } elseif (is_numeric($item)) {
                                $formattedItems[] = number_format((float) $item, 2);
                            } else {
                                $formattedItems[] = is_string($item) ? strip_tags($item) : $item;
                            }
                        }
                        return implode(', ', $formattedItems);
                    }

                    if (str_contains($field, 'date')) {
                        try {
                            return \Carbon\Carbon::parse($value)->format('d M Y');
                        } catch (\Exception $e) {
                            return $value;
                        }
                    }

                    if (is_numeric($value) && str_contains($field, 'amount')) {
                        return number_format((float) $value, 2);
                    }

                    return is_string($value) ? strip_tags($value) : $value;
                };
            @endphp

            @if (isset($approvalHistories) && $approvalHistories->count())
                <div class="form-data" style="margin-top: 2rem;">
                    <div class="data-group">
                        <h4>Working Committee Edit History</h4>
                        <div class="table-container">
                            <table class="custom-table">
                                <thead>
                                    <tr>
                                        <th>Edited At</th>
                                        <th>Edited By</th>
                                        <th>Changed Fields</th>
                                        <th>Previous Values</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($approvalHistories as $history)
                                        @php
                                            $changedFields = [];
                                            if (is_array($history->changed_fields ?? null)) {
                                                $changedFields = $history->changed_fields;
                                            } elseif (is_string($history->changed_fields ?? null)) {
                                                $decoded = json_decode($history->changed_fields, true);
                                                $changedFields = is_array($decoded) ? $decoded : [];
                                            }
                                        @endphp
                                        <tr>
                                            <td>
                                                {{ $history->created_at ? \Carbon\Carbon::parse($history->created_at)->format('d M Y H:i') : 'N/A' }}
                                            </td>
                                            <td>
                                                <div style="display: grid; gap: 0.25rem;">
                                                    <span>{{ $history->edited_by_name ?? 'N/A' }}</span>
                                                    @if (!empty($history->edited_by_email))
                                                        <small
                                                            style="color: var(--text-light);">{{ $history->edited_by_email }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if (count($changedFields))
                                                    {{ implode(', ', array_map(fn($field) => $historyFieldLabels[$field] ?? ucwords(str_replace('_', ' ', $field)), $changedFields)) }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                <div style="display: grid; gap: 0.35rem;">
                                                    @if (count($changedFields))
                                                        @foreach ($changedFields as $field)
                                                            @php
                                                                $oldKey = 'old_' . $field;
                                                                $oldValue = $history->$oldKey ?? null;
                                                                $label =
                                                                    $historyFieldLabels[$field] ??
                                                                    ucwords(str_replace('_', ' ', $field));
                                                                $formattedValue = $formatHistoryValue(
                                                                    $field,
                                                                    $oldValue,
                                                                );
                                                            @endphp
                                                            <div>
                                                                <strong>{{ $label }}:</strong>
                                                                {{ $formattedValue }}
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <span>N/A</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="form-data" style="margin-top: 2rem;">
                    <div class="data-group">
                        <h4>Working Committee Edit History</h4>
                        <p style="color: var(--text-light); margin: 0;">No edit history available.</p>
                    </div>
                </div>
            @endif

            @if ($user->workflowStatus && $user->workflowStatus->working_committee_status === 'rejected')
                <!-- Display Working Committee Rejection Remarks -->
                <div class="form-data">
                    <div class="data-group" style="background: #ffebee; border-color: #f44336;">
                        <h4 style="color: #c62828;">Working Committee Rejection Decision</h4>
                        <div class="form-section">
                            <div class="form-row">
                                <div class="form-field form-field-full">
                                    <label class="form-label" style="color: #c62828;">Rejection Remarks</label>
                                    <textarea class="form-textarea" readonly style="border-color: #f44336; background: rgba(244, 67, 54, 0.05);">{!! $user->workflowStatus->working_committee_reject_remarks !!}</textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Rejection Date</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->workflowStatus->working_committee_updated_at ? \Carbon\Carbon::parse($user->workflowStatus->working_committee_updated_at)->format('d M Y H:i') : 'N/A' }}"
                                        readonly style="border-color: #f44336;">
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Rejected By</label>
                                    <input type="text" class="form-input"
                                        value="{{ Auth::user()->name ?? 'N/A' }}" readonly
                                        style="border-color: #f44336;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($user->workflowStatus && $user->workflowStatus->working_committee_status === 'hold')
                <!-- Display Working Committee Hold Remarks -->
                <div class="form-data">
                    <div class="data-group" style="background: #fff8e1; border-color: #ffc107;">
                        <h4 style="color: #f57c00;">Working Committee Hold Status</h4>
                        <div class="form-section">
                            <div class="form-row">
                                <div class="form-field form-field-full">
                                    <label class="form-label" style="color: #f57c00;">Hold Remarks</label>
                                    <textarea class="form-textarea" readonly style="border-color: #ffc107; background: rgba(255, 193, 7, 0.05);">{!! $user->workflowStatus->working_committee_hold_remarks !!}</textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-field">
                                    <label class="form-label">Hold Date</label>
                                    <input type="text" class="form-input"
                                        value="{{ $user->workflowStatus->working_committee_updated_at ? \Carbon\Carbon::parse($user->workflowStatus->working_committee_updated_at)->format('d M Y H:i') : 'N/A' }}"
                                        readonly style="border-color: #ffc107;">
                                </div>
                                <div class="form-field">
                                    <label class="form-label">Held By</label>
                                    <input type="text" class="form-input"
                                        value="{{ Auth::user()->name ?? 'N/A' }}" readonly
                                        style="border-color: #ffc107;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Unhold Button -->
                <div class="form-data" style="margin-top: 1.5rem;">
                    <div class="data-group" style="background: #e8f5e9; border-color: #4CAF50;">
                        <h4 style="color: #2E7D32;">Unhold Application</h4>
                        <div class="form-section">
                            <form action="{{ route('admin.working_committee.user.unhold', ['user' => $user]) }}"
                                method="POST">
                                @csrf

                                <button type="submit" class="btn btn-approve" style="margin-top: 1rem;">
                                    <i class="fas fa-unlock"></i>
                                    Unhold Application
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

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
                        $user->workflowStatus->current_stage === 'working_committee' &&
                        $user->workflowStatus->final_status === 'in_progress')
                    <div class="data-group">
                        <h4>Final Working Committee Decision</h4>
                        <div class="form-section">
                            <div
                                style="padding: 2rem; background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%); border-radius: 12px; border: 1px solid rgba(57, 49, 133, 0.1); box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06); margin-top: 1.5rem;">
                                <h4 class="action-title">Working Committee Decision</h4>

                                <!-- Approve Form -->
                                <div
                                    style="flex: 1; min-width: 300px; padding: 2rem; border-radius: 12px; border: 2px solid #4CAF50;">
                                    <h6
                                        style="color: #2E7D32; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.5rem;">
                                        <i class="fas fa-check-circle"></i>
                                        Approve Application
                                    </h6>
                                    <form
                                        action="{{ route('admin.working_committee.user.approve', ['user' => $user, 'stage' => 'working_committee']) }}"
                                        method="POST" id="approval-form" enctype="multipart/form-data">
                                        @csrf
                                        <!-- Previous Approvals Info -->
                                        <div
                                            style="background: rgba(76, 175, 80, 0.05); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid rgba(76, 175, 80, 0.2);">
                                            <h6 style="color: #2E7D32; margin-bottom: 1rem;">Previous Approvals</h6>
                                            <div class="form-row">
                                                <div class="form-field">
                                                    <label class="form-label">Apex Approval Remark</label>
                                                    <textarea class="form-input" readonly>{{ $user->workflowStatus->apex_1_approval_remarks ?? 'N/A' }}</textarea>
                                                </div>
                                                <div class="form-field">
                                                    <label class="form-label">Apex Approval Date</label>
                                                    <input type="text" class="form-input"
                                                        value="{{ $user->workflowStatus->apex_1_updated_at ? \Carbon\Carbon::parse($user->workflowStatus->apex_1_updated_at)->format('d M Y') : 'N/A' }}"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-field">
                                                    <label class="form-label">Chapter Approval Remark</label>
                                                    <textarea class="form-input" readonly>{{ strip_tags($user->workflowStatus->chapter_approval_remarks ?? 'N/A') }}</textarea>
                                                </div>
                                                <div class="form-field">
                                                    <label class="form-label">Chapter Approval Date</label>
                                                    <input type="text" class="form-input"
                                                        value="{{ $user->workflowStatus->chapter_updated_at ? \Carbon\Carbon::parse($user->workflowStatus->chapter_updated_at)->format('d M Y') : 'N/A' }}"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-field">
                                                    <label class="form-label">Total Expenses of Student</label>
                                                    <input type="text" class="form-input"
                                                        value="₹{{ number_format($user->educationDetail->group_4_total ?? 0) }}"
                                                        readonly>
                                                </div>
                                                {{-- <div class="form-field">
                                                    <label class="form-label">Amount Requested for Year</label>
                                                    <input type="text" class="form-input"
                                                        value="₹{{ number_format($user->fundingDetail->total_funding_amount ?? 0) }}"
                                                        readonly>
                                                </div> --}}
                                                <div class="form-field ">
                                                    <label class="form-label">Recommended Financial Amount by
                                                        Chapter</label>
                                                    <input type="text" class="form-input"
                                                        value="₹{{ number_format($user->workflowStatus->chapter_assistance_amount ?? 0) }}"
                                                        readonly>
                                                </div>
                                            </div>
                                            {{-- <div class="form-row">
                                                <div class="form-field ">
                                                    <label class="form-label">Recommended Financial Amount by
                                                        Chapter</label>
                                                    <input type="text" class="form-input"
                                                        value="₹{{ number_format($user->workflowStatus->chapter_assistance_amount ?? 0) }}"
                                                        readonly>
                                                </div>
                                            </div> --}}
                                        </div>

                                        <div class="form-row">
                                            <div class="form-field form-field-full">
                                                <label class="form-label">Working Committee Approval Remark</label>
                                                <textarea name="w_c_approval_remark" placeholder="Provide approval remarks" rows="3" class="remark-input"
                                                    required></textarea>
                                            </div>
                                        </div>
                                        <!-- Working Committee Approval Form -->
                                        <div class="form-row">
                                            {{--  <div class="form-field">
                                                <label class="form-label">Working Committee Approval Date</label>
                                                <input type="date" name="w_c_approval_date" class="form-input"
                                                    required>
                                            </div>  --}}
                                            <div class="form-field">
                                                <label class="form-label">Working Committee Approval Date</label>
                                                <input type="date" name="w_c_approval_date" class="form-input"
                                                    min="{{ date('Y-m-d') }}" required>
                                            </div>
                                            <div class="form-field">
                                                <label class="form-label">Meeting Number</label>
                                                <input type="text" name="meeting_no" class="form-input"
                                                    placeholder="Enter meeting number" required>
                                            </div>
                                        </div>

                                        <!-- Disbursement Planning Card - Yearly Only -->
                                        <div
                                            style="background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%); border-radius: 12px; padding: 2rem; margin: 1.5rem 0; border: 1px solid rgba(57, 49, 133, 0.1); box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);">
                                            <h6
                                                style="color: #2E7D32; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                                                <i class="fas fa-money-check-alt"></i>
                                                Disbursement Planning (Yearly Only)
                                            </h6>

                                            <!-- Hidden field for disbursement system -->
                                            <input type="hidden" name="disbursement_system" value="yearly">

                                            <!-- Dynamic Disbursement Fields -->
                                            <div id="yearly-fields">
                                                <div class="form-row">
                                                    <div class="form-field">
                                                        <label class="form-label">Disbursement in Year</label>
                                                        <select name="disbursement_in_year" class="form-input"
                                                            id="disbursement-year-select">
                                                            <option value="">Select number of years</option>
                                                            @for ($i = 1; $i <= 8; $i++)
                                                                <option value="{{ $i }}">
                                                                    {{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="yearly-disbursements" style="display: none;">
                                                    <!-- Dynamic yearly fields will be added here -->
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-field">
                                                <label class="form-label">Approved Financial Assistance Amount</label>
                                                <input type="number" name="approval_financial_assistance_amount"
                                                    id="total-amount" class="form-input" step="0.01" readonly>
                                            </div>
                                            {{-- <div class="form-field">
                                                <label class="form-label">Installment Amount</label>
                                                <input type="number" name="installment_amount"
                                                    id="installment-amount" class="form-input" step="0.01">
                                            </div> --}}
                                        </div>


                                        <div id="installment-rows">

                                            <div style="text-align: end;">
                                                <button type="button" id="add-installment"
                                                    class="btn btn-sm btn-secondary">
                                                    + Add Installment
                                                </button>
                                            </div>
                                            <div class="form-row installment-row">
                                                <div class="form-field2">
                                                    <label>Installment Amount</label>
                                                    <input type="number" class="installment-amount form-input"
                                                        name="installment_amount[]" step="0.01">
                                                </div>

                                                <div class="form-field2">
                                                    <label>No of Months</label>
                                                    <input type="number" name="no_of_months[]"
                                                        class="installment-months form-input">
                                                </div>

                                                <div class="form-field2">
                                                    <label>Total</label>
                                                    <input type="number" name="total[]"
                                                        class="installment-total form-input" readonly>
                                                </div>
                                                <div class="form-field2" style="display:flex; align-items:end;">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger remove-installment">
                                                        Remove
                                                    </button>
                                                </div>
                                            </div>


                                            {{-- </div> --}}



                                            {{-- <div class="form-row"> --}}
                                            {{-- <div class="form-field">
                                                <label class="form-label">Installment Amount</label>
                                                <input type="number" name="installment_amount"
                                                    id="installment-amount" class="form-input" step="0.01">
                                            </div> --}}
                                            {{-- <div class="form-field">
                                                <label class="form-label">Additional Installment Amount</label>
                                                <input type="number" name="additional_installment_amount"
                                                    class="form-input" step="0.01">
                                            </div> --}}

                                        </div>

                                        <div class="form-row " style="margin-top:20px;">
                                            <div class="form-field ">
                                                <label class="form-label">Additional Installment Amount</label>
                                                <input type="number" name="additional_installment_amount"
                                                    class="form-input" step="0.01">
                                            </div>
                                            <div class="form-field ">
                                                <label class="form-label">No of Cheques to be Collected</label>
                                                <input type="number" name="no_of_cheques_to_be_collected"
                                                    class="form-input" min="1">
                                            </div>
                                            <div class="form-field">
                                                <label class="form-label">Repayment Type</label>
                                                <select name="repayment_type" class="form-input" required>
                                                    <option value="">Select repayment type</option>
                                                    <option value="yearly">Yearly</option>
                                                    <option value="6_months">6 Months</option>
                                                    <option value="3_months">3 Months</option>
                                                    <option value="2_months">2 Months</option>
                                                    <option value="monthly">Monthly</option>
                                                </select>
                                            </div>
                                            <div class="form-field">
                                                <label class="form-label">Repayment Starting From</label>
                                                <input type="date" name="repayment_starting_from"
                                                    class="form-input">
                                            </div>
                                            <div class="form-field">
                                                <label class="form-label">Can he/she be JITO Member?</label>
                                                <select name="can_be_jito_member" class="form-input"
                                                    id="can-be-jito-member">
                                                    <option value="">Select</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                            <div class="form-field" id="jito-member-date-field" style="display:none;">
                                                <label class="form-label">JITO Member Date</label>
                                                <input type="date" name="jito_member_date" class="form-input">
                                            </div>
                                            <div class="form-field">
                                                <label class="form-label">Can he/she be Donor for JEAP?</label>
                                                <select name="can_be_jeap_donor" class="form-input"
                                                    id="can-be-jeap-donor">
                                                    <option value="">Select</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                            <div class="form-field" id="jeap-donor-date-field" style="display:none;">
                                                <label class="form-label">JEAP Donor Date</label>
                                                <input type="date" name="jeap_donor_date" class="form-input">
                                            </div>
                                            <div class="form-field">
                                                <label class="form-label">Document (Image/PDF)</label>
                                                <input type="file" name="document" class="form-input"
                                                    accept="image/*,.pdf">
                                            </div>
                                            <div class="form-field">
                                                <label class="form-label">Processed By</label>
                                                <input type="text" name="processed_by_name" class="form-input"
                                                    value="{{ Auth::user()->name ?? 'N/A' }}" readonly>
                                            </div>
                                        </div>



                                        <div class="form-row">
                                            {{-- <div class="form-field">
                                                <label class="form-label">Processed By</label>
                                                <input type="text" name="processed_by" class="form-input"
                                                    value="{{ Auth::user()->name ?? 'N/A' }}" readonly>
                                            </div> --}}
                                            <div class="form-field">

                                                <label class="form-label">Remarks for Approval</label>
                                                <textarea name="remarks_for_approval" placeholder="Provide detailed remarks for approval" rows="4"
                                                    class="remark-input"></textarea>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-approve"
                                            style="width: 100%; margin-top: 1rem;">
                                            <i class="fas fa-check"></i>
                                            Approve & Move to Apex 2
                                        </button>
                                    </form>
                                </div>

                                <div class="divider"></div>

                                <!-- Hold Form -->
                                <div
                                    style="flex: 1; min-width: 300px; padding: 2rem; border-radius: 12px; border: 2px solid #FFC107;">
                                    <h6
                                        style="color: #f57c00; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.5rem;">
                                        <i class="fas fa-pause-circle"></i>
                                        Put Application on Hold
                                    </h6>
                                    <form
                                        action="{{ route('admin.user.hold', ['user' => $user, 'stage' => 'working_committee']) }}"
                                        method="POST">
                                        @csrf
                                        <div class="form-row" style="margin-bottom: 1rem;">
                                            <div class="form-field form-field-full">
                                                <label class="form-label" style="color: #f57c00;">Hold Remarks *</label>
                                                <textarea name="admin_remark" placeholder="Provide detailed hold remarks (required)" rows="4"
                                                    class="remark-input" style="border: 2px solid #FFC107; background: rgba(255, 193, 7, 0.05);" required></textarea>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn"
                                            style="width: 100%; background: linear-gradient(135deg, #FFC107, #ff9800); color: #212121;">
                                            <i class="fas fa-pause"></i>
                                            Put on Hold
                                        </button>
                                    </form>
                                </div>

                                <div class="divider"></div>

                                <!-- Reject Form -->
                                <div
                                    style="flex: 1; min-width: 300px; padding: 2rem; border-radius: 12px; border: 2px solid #f44336;">
                                    <h6
                                        style="color: #c62828; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.5rem;">
                                        <i class="fas fa-times-circle"></i>
                                        Reject Application
                                    </h6>
                                    <form
                                        action="{{ route('admin.user.reject', ['user' => $user, 'stage' => 'working_committee']) }}"
                                        method="POST">
                                        @csrf
                                        <div class="form-row" style="margin-bottom: 1rem;">
                                            <div class="form-field form-field-full">
                                                <label class="form-label" style="color: #c62828;">Rejection Remarks
                                                    *</label>
                                                <textarea name="admin_remark" placeholder="Provide detailed rejection remarks (required)" rows="4"
                                                    class="remark-input" style="border: 2px solid #f44336; background: rgba(244, 67, 54, 0.05);" required></textarea>
                                            </div>
                                        </div>



                                        <button type="submit" class="btn btn-reject" style="width: 100%;">
                                            <i class="fas fa-times"></i>
                                            Reject Application
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('printDropdown');
            if (dropdown) {
                dropdown.style.display = dropdown.style.display === 'none' || dropdown.style.display === '' ? 'block' :
                    'none';
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('printDropdown');
            const button = dropdown ? dropdown.previousElementSibling : null;

            if (dropdown && button) {
                if (!dropdown.contains(event.target) && !button.contains(event.target)) {
                    dropdown.style.display = 'none';
                }
            }
        });

        function showStep(stepNumber) {
            document.querySelectorAll('.step-content').forEach(content => {
                content.classList.remove('active');
            });

            document.querySelectorAll('.step-nav-item').forEach(item => {
                item.classList.remove('active');
            });

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

        // Disbursement System - Yearly only
        document.addEventListener('DOMContentLoaded', function() {
            // Show yearly fields by default
            const yearlyFields = document.getElementById('yearly-fields');
            if (yearlyFields) {
                yearlyFields.style.display = 'block';
            }

            // Yearly select handler
            const yearSelect = document.getElementById('disbursement-year-select');
            if (yearSelect) {
                yearSelect.addEventListener('change', function() {
                    generateYearlyFields(this.value);
                });
            }

            const canBeJitoMemberSelect = document.getElementById('can-be-jito-member');
            const jitoMemberDateField = document.getElementById('jito-member-date-field');
            const canBeJeapDonorSelect = document.getElementById('can-be-jeap-donor');
            const jeapDonorDateField = document.getElementById('jeap-donor-date-field');

            function toggleCreateExtraFields() {
                if (jitoMemberDateField) {
                    jitoMemberDateField.style.display = canBeJitoMemberSelect?.value === 'yes' ? 'block' : 'none';
                }
                if (jeapDonorDateField) {
                    jeapDonorDateField.style.display = canBeJeapDonorSelect?.value === 'yes' ? 'block' : 'none';
                }
            }

            canBeJitoMemberSelect?.addEventListener('change', toggleCreateExtraFields);
            canBeJeapDonorSelect?.addEventListener('change', toggleCreateExtraFields);
            toggleCreateExtraFields();
        });

        function clearYearlyFields() {
            document.getElementById('yearly-disbursements').innerHTML = '';
            document.getElementById('yearly-disbursements').style.display = 'none';
            const yearSelect = document.getElementById('disbursement-year-select');
            if (yearSelect) {
                yearSelect.value = '';
            }
            calculateTotal();
        }

        function generateYearlyFields(count) {
            const container = document.getElementById('yearly-disbursements');
            container.innerHTML = '';

            if (!count || count < 1) {
                container.style.display = 'none';
                calculateTotal();
                return;
            }

            container.style.display = 'block';

            for (let i = 1; i <= count; i++) {
                const fieldGroup = document.createElement('div');
                fieldGroup.className = 'form-row';
                fieldGroup.innerHTML = `
                    <div class="form-field">
                        <label class="form-label">Year ${i} Disbursement Date</label>
                        <input type="date" name="yearly_dates[]" class="form-input yearly-date" required>
                    </div>
                    <div class="form-field">
                        <label class="form-label">Year ${i} Amount</label>
                        <input type="number" name="yearly_amounts[]" class="form-input yearly-amount" step="0.01" min="0" required>
                    </div>
                `;
                container.appendChild(fieldGroup);
            }

            // Add event listeners to calculate total
            container.querySelectorAll('.yearly-amount').forEach(input => {
                input.addEventListener('input', calculateTotal);
            });
        }

        function calculateTotal() {
            let total = 0;

            // Sum yearly amounts
            document.querySelectorAll('.yearly-amount').forEach(input => {
                const value = parseFloat(input.value) || 0;
                total += value;
            });

            // Set total amount
            document.getElementById('total-amount').value = total.toFixed(2);

            // Calculate installment amount (total / number of installments)
            const yearlyCount = document.querySelectorAll('.yearly-amount').length;

            // if (yearlyCount > 0) {
            //  const installmentAmount = total / yearlyCount;
            //  document.getElementById('installment-amount').value = installmentAmount.toFixed(2);
            // } else {
            // document.getElementById('installment-amount').value = '0.00';
            // }
        }

        // Select document and highlight it
        function selectDocument(event, url, title) {
            event.preventDefault();

            // Remove active class from all buttons (CSS will handle styling)
            document.querySelectorAll('.doc-button').forEach(btn => {
                btn.classList.remove('active');
            });

            // Add active class to clicked button
            const clickedBtn = event.target.closest('.doc-button');
            if (clickedBtn) {
                clickedBtn.classList.add('active');
            }

            // Open the modal/preview
            openModal(url, title);
        }

        // Modal functions for document viewing
        let currentDocUrl = '';

        function openModal(url, title = 'Document Preview') {
            const previewContainer = document.getElementById('documentPreview');
            const downloadBtn = document.getElementById('docDownloadBtn');
            const isImage = /\.(jpg|jpeg|png|gif|webp|bmp|ico)$/i.test(url);

            // Store current URL for download
            currentDocUrl = url;

            // Clear existing preview content
            previewContainer.innerHTML = '';

            // Show download button in header
            if (downloadBtn) {
                downloadBtn.style.display = 'inline-flex';
            }

            // Create preview content
            if (isImage) {
                const img = document.createElement('img');
                img.src = url;
                img.alt = title;
                img.style.cssText = 'max-width: 100%; max-height: 400px; object-fit: contain; border-radius: 6px;';
                previewContainer.appendChild(img);
            } else {
                const iframe = document.createElement('iframe');
                iframe.src = url;
                iframe.style.cssText = 'width: 100%; height: 400px; border: none; border-radius: 6px;';
                previewContainer.appendChild(iframe);
            }
        }

        // Reset preview to initial state
        function resetPreview() {
            const previewContainer = document.getElementById('documentPreview');
            const downloadBtn = document.getElementById('docDownloadBtn');

            previewContainer.innerHTML = `
                <i class="fas fa-file-image" style="font-size: 4rem; color: var(--text-light); margin-bottom: 1rem;"></i>
                <p style="color: var(--text-light); font-size: 1rem;">Select a document from the left to preview</p>
                <p style="color: var(--text-light); font-size: 0.85rem; margin-top: 0.5rem;">Click on any document name to view its content</p>
            `;

            // Hide download button
            if (downloadBtn) {
                downloadBtn.style.display = 'none';
            }

            currentDocUrl = '';
        }

        // Download current document
        function downloadCurrentDoc() {
            if (currentDocUrl) {
                window.open(currentDocUrl, '_blank');
            }
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('documentModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('summernotes/summernote-lite.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Check for session success messages and show SweetAlert
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#393185'
                });
            @endif



            const totalAmountInput = document.getElementById('total-amount');
            const additionalInput = document.querySelector('input[name="additional_installment_amount"]');
            const chequesInput = document.querySelector('input[name="no_of_cheques_to_be_collected"]');
            const rowsContainer = document.getElementById('installment-rows');
            const addBtn = document.getElementById('add-installment');

            function toggleCreateRemoveButtons() {
                const rows = rowsContainer.querySelectorAll('.installment-row');
                rows.forEach((row, index) => {
                    const removeBtn = row.querySelector('.remove-installment');
                    if (!removeBtn) return;
                    removeBtn.disabled = rows.length === 1;
                    removeBtn.style.visibility = rows.length === 1 ? 'hidden' : 'visible';
                });
            }

            function recalculate() {
                let sanctionAmount = parseFloat(totalAmountInput.value) || 0;
                let usedAmount = 0;
                let totalMonths = 0;

                document.querySelectorAll('.installment-row').forEach(row => {
                    const amount = parseFloat(row.querySelector('.installment-amount').value) || 0;
                    const months = parseInt(row.querySelector('.installment-months').value) || 0;

                    const rowTotal = amount * months;
                    row.querySelector('.installment-total').value = rowTotal;

                    usedAmount += rowTotal;
                    totalMonths += months;
                });

                let remaining = sanctionAmount - usedAmount;
                if (remaining < 0) remaining = 0;

                additionalInput.value = remaining.toFixed(2);
                chequesInput.value = remaining > 0 ? totalMonths + 1 : totalMonths;
            }

            // Listen changes
            rowsContainer.addEventListener('input', recalculate);

            // Add new row
            addBtn.addEventListener('click', () => {
                const newRow = document.querySelector('.installment-row').cloneNode(true);
                newRow.querySelectorAll('input').forEach(input => input.value = '');
                rowsContainer.appendChild(newRow);
                toggleCreateRemoveButtons();
                recalculate();
            });

            rowsContainer.addEventListener('click', (event) => {
                const removeBtn = event.target.closest('.remove-installment');
                if (!removeBtn) return;

                const rows = rowsContainer.querySelectorAll('.installment-row');
                if (rows.length === 1) return;

                removeBtn.closest('.installment-row')?.remove();
                toggleCreateRemoveButtons();
                recalculate();
            });

            toggleCreateRemoveButtons();
            recalculate();



        });
    </script>

    <script>
        $(document).ready(function() {
            $('textarea:not([readonly]):not([disabled]):not(.swal2-textarea)').each(function() {
                const $textarea = $(this);
                if ($textarea.next('.note-editor').length) {
                    return;
                }

                $textarea.summernote({
                    height: 140,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline']],
                        ['fontsize', ['fontsize']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['link']],
                        ['view', ['codeview']]
                    ]
                });
            });
        });
    </script>



    <!-- Document Modal -->
    <div id="documentModal"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:1000; justify-content:center; align-items:center;">
        <div
            style="position:relative; max-width:90%; max-height:90%; background:white; border-radius:8px; overflow:hidden;">
            <button onclick="closeModal()"
                style="position:absolute; top:10px; right:10px; background:red; color:white; border:none; border-radius:50%; width:30px; height:30px; cursor:pointer; z-index:1001;">&times;</button>
            <iframe id="documentFrame" src=""
                style="width:100%; height:600px; border:none; display:block;"></iframe>
            <img id="documentImage" src=""
                style="max-width:100%; max-height:600px; display:none; object-fit:contain;" alt="Document Image">
        </div>
    </div>

    @php
        $completedScheduleMap = ($completedDisbursementSchedules ?? collect())->keyBy('installment_no');
    @endphp

    <div class="modal fade" id="editDisbursementDatesModal" tabindex="-1"
        aria-labelledby="editDisbursementDatesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                    <form
                        action="{{ route('admin.working_committee.user.update_disbursement_dates', ['user' => $user]) }}"
                        method="POST" id="edit-disbursement-dates-form">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="date_update_mode" value="disbursement_dates">

                        <div class="alert alert-info mb-3">
                            Completed disbursement installments are locked. Only pending installment dates can be updated
                            here.
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Disbursement System</label>
                                <input type="text" class="form-control"
                                    value="{{ ucfirst($user->workingCommitteeApproval->disbursement_system ?? 'N/A') }}"
                                    readonly>
                            </div>

                            @if (($user->workingCommitteeApproval->disbursement_system ?? null) === 'yearly')
                                @foreach ((array) ($user->workingCommitteeApproval->yearly_dates ?? []) as $index => $date)
                                    @php
                                        $installmentNo = $index + 1;
                                        $completedSchedule = $completedScheduleMap->get($installmentNo);
                                        $resolvedDate = $completedSchedule
                                            ? \Illuminate\Support\Str::of($completedSchedule->planned_date)->substr(
                                                0,
                                                10,
                                            )
                                            : \Carbon\Carbon::parse($date)->format('Y-m-d');
                                    @endphp
                                    <div class="col-md-6">
                                        <label class="form-label">Year {{ $installmentNo }} Date</label>
                                        @if ($completedSchedule)
                                            <input type="date" class="form-control"
                                                value="{{ old("yearly_dates.$index", $resolvedDate) }}" disabled>
                                            <input type="hidden" name="yearly_dates[]"
                                                value="{{ old("yearly_dates.$index", $resolvedDate) }}">
                                        @else
                                            <input type="date" name="yearly_dates[]" class="form-control"
                                                value="{{ old("yearly_dates.$index", $resolvedDate) }}" required>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Year {{ $installmentNo }} Amount</label>
                                        <input type="text" class="form-control"
                                            value="Rs. {{ number_format((float) ($user->workingCommitteeApproval->yearly_amounts[$index] ?? 0), 2) }}"
                                            readonly>
                                    </div>
                                @endforeach
                            @endif

                            @if (($user->workingCommitteeApproval->disbursement_system ?? null) === 'half_yearly')
                                @foreach ((array) ($user->workingCommitteeApproval->half_yearly_dates ?? []) as $index => $date)
                                    @php
                                        $installmentNo = $index + 1;
                                        $completedSchedule = $completedScheduleMap->get($installmentNo);
                                        $resolvedDate = $completedSchedule
                                            ? \Illuminate\Support\Str::of($completedSchedule->planned_date)->substr(
                                                0,
                                                10,
                                            )
                                            : \Carbon\Carbon::parse($date)->format('Y-m-d');
                                    @endphp
                                    <div class="col-md-6">
                                        <label class="form-label">Half-Year {{ $installmentNo }} Date</label>
                                        @if ($completedSchedule)
                                            <input type="date" class="form-control"
                                                value="{{ old("half_yearly_dates.$index", $resolvedDate) }}" disabled>
                                            <input type="hidden" name="half_yearly_dates[]"
                                                value="{{ old("half_yearly_dates.$index", $resolvedDate) }}">
                                        @else
                                            <input type="date" name="half_yearly_dates[]" class="form-control"
                                                value="{{ old("half_yearly_dates.$index", $resolvedDate) }}" required>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Half-Year {{ $installmentNo }} Amount</label>
                                        <input type="text" class="form-control"
                                            value="Rs. {{ number_format((float) ($user->workingCommitteeApproval->half_yearly_amounts[$index] ?? 0), 2) }}"
                                            readonly>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="modal-footer mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Update Dates
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Working Committee Modal -->
    <div class="modal fade" id="editWorkingCommitteeModal" tabindex="-1"
        aria-labelledby="editWorkingCommitteeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                {{-- <div class="modal-header" style="background: var(--primary-purple); color: white;">
                    <h5 class="modal-title" id="editWorkingCommitteeModalLabel">
                        Edit Working Committee Decision
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div> --}}
                <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">

                    <form action="{{ route('admin.working_committee.user.update', ['user' => $user]) }}"
                        method="POST" id="edit-working-committee-form">
                        @csrf
                        @method('PATCH')

                        <div class="alert alert-info mb-3" id="edit-disbursement-lock-note"
                            style="{{ isset($completedDisbursementSchedules) && $completedDisbursementSchedules->isNotEmpty() ? '' : 'display:none;' }}">
                            Only disbursement dates can be updated here. Completed installments stay locked.
                        </div>

                        <!-- Previous Approvals Info (read-only) -->
                        <div
                            style="background: rgba(76, 175, 80, 0.08); padding: 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; border: 1px solid rgba(76, 175, 80, 0.25);">
                            <h6 style="color: #2E7D32; margin-bottom: 1rem;">Previous Approvals (Read-only)</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Apex Approval Remark</label>
                                    <textarea class="form-control" readonly rows="2">{{ $user->workflowStatus->apex_1_approval_remarks ?? 'N/A' }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Apex Approval Date</label>
                                    <input type="text" class="form-control" readonly
                                        value="{{ $user->workflowStatus->apex_1_updated_at ? $user->workflowStatus->apex_1_updated_at->format('d M Y') : 'N/A' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Chapter Approval Remark</label>
                                    <textarea class="form-control" readonly rows="2">{{ strip_tags($user->workflowStatus->chapter_approval_remarks ?? 'N/A') }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Chapter Approval Date</label>
                                    <input type="text" class="form-control" readonly
                                        value="{{ $user->workflowStatus->chapter_updated_at ? $user->workflowStatus->chapter_updated_at->format('d M Y') : 'N/A' }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Total Expenses</label>
                                    <input type="text" class="form-control" readonly
                                        value="₹{{ number_format($user->educationDetail->group_4_total ?? 0) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Chapter Recommended Amount</label>
                                    <input type="text" class="form-control" readonly
                                        value="₹{{ number_format($user->workflowStatus->chapter_assistance_amount ?? 0) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Main Decision Fields -->
                        <div class="row g-3">

                            <div class="col-md-4">
                                <label class="form-label">Approval Date <span class="text-danger">*</span></label>
                                <input type="date" name="w_c_approval_date" class="form-control" required
                                    value="{{ old('w_c_approval_date', optional($user->workingCommitteeApproval)->w_c_approval_date?->format('Y-m-d') ?? '') }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Meeting Number <span class="text-danger">*</span></label>
                                <input type="text" name="meeting_no" class="form-control" required
                                    value="{{ old('meeting_no', $user->workingCommitteeApproval->meeting_no ?? '') }}">
                            </div>

                            {{-- <div class="col-md-4">
                                <label class="form-label">Approved Amount (₹) <span class="text-danger">*</span></label>
                                <input type="number" name="approval_financial_assistance_amount"
                                    id="edit-total-amount" class="form-control" step="0.01" readonly
                                    value="{{ old('approval_financial_assistance_amount', $user->workingCommitteeApproval->approval_financial_assistance_amount ?? 0) }}">
                            </div> --}}

                            <!-- Disbursement System -->
                            <div class="col-12">
                                <label class="form-label">Disbursement System</label>
                                <input type="hidden" name="disbursement_system"
                                    value="{{ old('disbursement_system', $user->workingCommitteeApproval->disbursement_system ?? '') }}">
                                <select name="disbursement_system_display" class="form-control"
                                    id="edit-disbursement-system" disabled>
                                    <option value="yearly"
                                        {{ old('disbursement_system', $user->workingCommitteeApproval->disbursement_system ?? '') == 'yearly' ? 'selected' : '' }}>
                                        Yearly</option>
                                    <option value="half_yearly"
                                        {{ old('disbursement_system', $user->workingCommitteeApproval->disbursement_system ?? '') == 'half_yearly' ? 'selected' : '' }}>
                                        Half-Yearly</option>
                                </select>
                            </div>

                            <!-- Yearly Disbursement (dynamic) -->
                            <div class="col-12" id="edit-yearly-section"
                                style="{{ ($user->workingCommitteeApproval->disbursement_system ?? 'yearly') !== 'yearly' ? 'display:none;' : '' }}">
                                <label class="form-label">Number of Years</label>
                                <select name="disbursement_in_year" class="form-control" id="edit-year-count">
                                    <option value="">Select</option>
                                    @for ($i = 1; $i <= 8; $i++)
                                        <option value="{{ $i }}"
                                            {{ count($user->workingCommitteeApproval->yearly_dates ?? []) == $i ? 'selected' : '' }}>
                                            {{ $i }} year{{ $i > 1 ? 's' : '' }}
                                        </option>
                                    @endfor
                                </select>

                                <div id="edit-yearly-fields" class="mt-3">
                                    <!-- Dynamically filled by JS -->
                                </div>
                            </div>

                            <div class="col-12" id="edit-half-yearly-section"
                                style="{{ ($user->workingCommitteeApproval->disbursement_system ?? 'yearly') !== 'half_yearly' ? 'display:none;' : '' }}">
                                <label class="form-label">Number of Half-Yearly Installments</label>
                                <input type="hidden" name="disbursement_in_half_year"
                                    value="{{ old('disbursement_in_half_year', count($user->workingCommitteeApproval->half_yearly_dates ?? [])) }}">
                                <select name="disbursement_in_half_year_display" class="form-control"
                                    id="edit-half-year-count" disabled>
                                    <option value="">Select</option>
                                    @for ($i = 1; $i <= 16; $i++)
                                        <option value="{{ $i }}"
                                            {{ count($user->workingCommitteeApproval->half_yearly_dates ?? []) == $i ? 'selected' : '' }}>
                                            {{ $i }} installment{{ $i > 1 ? 's' : '' }}
                                        </option>
                                    @endfor
                                </select>

                                <div id="edit-half-yearly-fields" class="mt-3">
                                    <!-- Dynamically filled by JS -->
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Approved Amount (₹) <span class="text-danger">*</span></label>
                                <input type="number" name="approval_financial_assistance_amount"
                                    id="edit-total-amount" class="form-control" step="0.01" readonly
                                    value="{{ old('approval_financial_assistance_amount', $user->workingCommitteeApproval->approval_financial_assistance_amount ?? 0) }}">
                            </div>

                            <!-- Installments -->
                            <div class="col-12">
                                <h6>Installment Planning</h6>
                                <div id="edit-installment-rows">
                                    @if ($user->workingCommitteeApproval && is_array($user->workingCommitteeApproval->installment_amount ?? []))
                                        @foreach ($user->workingCommitteeApproval->installment_amount as $idx => $amt)
                                            <div class="row g-3 installment-row mb-2">
                                                <div class="col-md-4">
                                                    <label>Amount (₹)</label>
                                                    <input type="number" name="installment_amount[]"
                                                        class="form-control installment-amount"
                                                        value="{{ old("installment_amount.$idx", $amt) }}"
                                                        step="0.01">
                                                </div>
                                                <div class="col-md-4">
                                                    <label>No. of Months</label>
                                                    <input type="number" name="no_of_months[]"
                                                        class="form-control installment-months"
                                                        value="{{ old("no_of_months.$idx", $user->workingCommitteeApproval->no_of_months[$idx] ?? '') }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Total (₹)</label>
                                                    <input type="number" class="form-control installment-total"
                                                        readonly
                                                        value="{{ old("total.$idx", $user->workingCommitteeApproval->total[$idx] ?? 0) }}">
                                                </div>
                                                <div class="col-md-12 text-end">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger remove-edit-installment">
                                                        Remove
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <button type="button" class="btn btn-sm btn-outline-secondary mt-2"
                                    id="edit-add-installment">
                                    + Add Installment
                                </button>
                            </div>

                            <!-- Additional & Cheques -->
                            <div class="col-md-4">
                                <label class="form-label">Additional Amount (₹)</label>
                                <input type="number" name="additional_installment_amount" id="edit-additional-amount"
                                    class="form-control" step="0.01" readonly
                                    value="{{ old('additional_installment_amount', $user->workingCommitteeApproval->additional_installment_amount ?? 0) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">No. of Cheques</label>
                                <input type="number" name="no_of_cheques_to_be_collected" class="form-control"
                                    value="{{ old('no_of_cheques_to_be_collected', $user->workingCommitteeApproval->no_of_cheques_to_be_collected ?? '') }}">
                            </div>

                            <!-- Repayment -->
                            <div class="col-md-4">
                                <label class="form-label">Repayment Type</label>
                                <select name="repayment_type" class="form-control">
                                    <option value="yearly"
                                        {{ old('repayment_type', $user->workingCommitteeApproval->repayment_type ?? '') == 'yearly' ? 'selected' : '' }}>
                                        Yearly</option>
                                    <option value="half_yearly"
                                        {{ old('repayment_type', $user->workingCommitteeApproval->repayment_type ?? '') == 'half_yearly' ? 'selected' : '' }}>
                                        Half-Yearly</option>
                                    <option value="quarterly"
                                        {{ old('repayment_type', $user->workingCommitteeApproval->repayment_type ?? '') == 'quarterly' ? 'selected' : '' }}>
                                        Quarterly</option>
                                    <option value="monthly"
                                        {{ old('repayment_type', $user->workingCommitteeApproval->repayment_type ?? '') == 'monthly' ? 'selected' : '' }}>
                                        Monthly</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Repayment Starting From</label>
                                <input type="date" name="repayment_starting_from" class="form-control"
                                    value="{{ old('repayment_starting_from', optional(optional($user->workingCommitteeApproval)->repayment_starting_from)->format('Y-m-d') ?? '') }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Can he/she be JITO Member?</label>
                                <select name="can_be_jito_member" class="form-control" id="edit-can-be-jito-member">
                                    <option value="">Select</option>
                                    <option value="yes"
                                        {{ old('can_be_jito_member', $user->workingCommitteeApproval->can_be_jito_member ?? '') == 'yes' ? 'selected' : '' }}>
                                        Yes</option>
                                    <option value="no"
                                        {{ old('can_be_jito_member', $user->workingCommitteeApproval->can_be_jito_member ?? '') == 'no' ? 'selected' : '' }}>
                                        No</option>
                                </select>
                            </div>

                            <div class="col-md-3" id="edit-jito-member-date-field"
                                style="{{ old('can_be_jito_member', $user->workingCommitteeApproval->can_be_jito_member ?? '') === 'yes' ? '' : 'display:none;' }}">
                                <label class="form-label">JITO Member Date</label>
                                <input type="date" name="jito_member_date" class="form-control"
                                    value="{{ old('jito_member_date', optional(optional($user->workingCommitteeApproval)->jito_member_date)->format('Y-m-d') ?? '') }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Can he/she be Donor for JEAP?</label>
                                <select name="can_be_jeap_donor" class="form-control" id="edit-can-be-jeap-donor">
                                    <option value="">Select</option>
                                    <option value="yes"
                                        {{ old('can_be_jeap_donor', $user->workingCommitteeApproval->can_be_jeap_donor ?? '') == 'yes' ? 'selected' : '' }}>
                                        Yes</option>
                                    <option value="no"
                                        {{ old('can_be_jeap_donor', $user->workingCommitteeApproval->can_be_jeap_donor ?? '') == 'no' ? 'selected' : '' }}>
                                        No</option>
                                </select>
                            </div>

                            <div class="col-md-3" id="edit-jeap-donor-date-field"
                                style="{{ old('can_be_jeap_donor', $user->workingCommitteeApproval->can_be_jeap_donor ?? '') === 'yes' ? '' : 'display:none;' }}">
                                <label class="form-label">JEAP Donor Date</label>
                                <input type="date" name="jeap_donor_date" class="form-control"
                                    value="{{ old('jeap_donor_date', optional(optional($user->workingCommitteeApproval)->jeap_donor_date)->format('Y-m-d') ?? '') }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Approval Remark</label>
                                <textarea name="w_c_approval_remark" class="form-control" rows="3" required>{{ old('w_c_approval_remark', $user->workflowStatus->working_committee_approval_remarks ?? '') }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Remarks for Approval</label>
                                <textarea name="remarks_for_approval" class="form-control" rows="4">{{ old('remarks_for_approval', $user->workingCommitteeApproval->remarks_for_approval ?? '') }}</textarea>
                            </div>

                        </div>

                        <div class="modal-footer mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        // Edit modal logic
        document.addEventListener('DOMContentLoaded', function() {

            const editModal = document.getElementById('editWorkingCommitteeModal');
            if (!editModal) return;

            const savedYearlyDates = @json(old('yearly_dates', $user->workingCommitteeApproval->yearly_dates ?? []));
            const savedYearlyAmounts = @json(old('yearly_amounts', $user->workingCommitteeApproval->yearly_amounts ?? []));
            const savedHalfYearlyDates = @json(old('half_yearly_dates', $user->workingCommitteeApproval->half_yearly_dates ?? []));
            const savedHalfYearlyAmounts = @json(old('half_yearly_amounts', $user->workingCommitteeApproval->half_yearly_amounts ?? []));
            const completedSchedules = @json(($completedDisbursementSchedules ?? collect())->values());
            const maxLockedInstallmentNo = completedSchedules.length ? Math.max(...completedSchedules.map(item =>
                Number(item.installment_no))) : 0;

            // Trigger when modal is shown
            editModal.addEventListener('shown.bs.modal', function() {

                const disbursementSystemSelect = document.getElementById('edit-disbursement-system');
                const yearCountSelect = document.getElementById('edit-year-count');
                const yearlySection = document.getElementById('edit-yearly-section');
                const yearlyFields = document.getElementById('edit-yearly-fields');
                const halfYearCountSelect = document.getElementById('edit-half-year-count');
                const halfYearlySection = document.getElementById('edit-half-yearly-section');
                const halfYearlyFields = document.getElementById('edit-half-yearly-fields');
                const lockNote = document.getElementById('edit-disbursement-lock-note');
                const editCanBeJitoMemberSelect = document.getElementById('edit-can-be-jito-member');
                const editJitoMemberDateField = document.getElementById('edit-jito-member-date-field');
                const editCanBeJeapDonorSelect = document.getElementById('edit-can-be-jeap-donor');
                const editJeapDonorDateField = document.getElementById('edit-jeap-donor-date-field');
                const addInstallmentBtn = document.getElementById('edit-add-installment');
                const rowsContainer = document.getElementById('edit-installment-rows');

                if (!disbursementSystemSelect || !yearCountSelect || !yearlySection || !yearlyFields ||
                    !halfYearCountSelect || !halfYearlySection || !halfYearlyFields || !rowsContainer) {
                    return;
                }

                function toggleEditExtraFields() {
                    if (editJitoMemberDateField) {
                        editJitoMemberDateField.style.display = editCanBeJitoMemberSelect?.value === 'yes' ?
                            '' : 'none';
                    }
                    if (editJeapDonorDateField) {
                        editJeapDonorDateField.style.display = editCanBeJeapDonorSelect?.value === 'yes' ?
                            '' : 'none';
                    }
                }

                function normalizeDate(value) {
                    return value ? String(value).slice(0, 10) : '';
                }

                function getCompletedSchedule(installmentNo) {
                    return completedSchedules.find(item => Number(item.installment_no) === installmentNo) ||
                        null;
                }

                function enforceLockedCount(selectElement) {
                    if (!selectElement) {
                        return;
                    }
                    const selectedCount = parseInt(selectElement.value || '0', 10);

                    if (maxLockedInstallmentNo > 0 && selectedCount > 0 && selectedCount <
                        maxLockedInstallmentNo) {
                        selectElement.value = String(maxLockedInstallmentNo);

                        if (lockNote) {
                            lockNote.classList.remove('alert-info');
                            lockNote.classList.add('alert-warning');
                            lockNote.textContent =
                                `Completed installments 1 to ${maxLockedInstallmentNo} are locked. The plan cannot be reduced below that.`;
                        }
                    } else if (lockNote && completedSchedules.length > 0) {
                        lockNote.classList.remove('alert-warning');
                        lockNote.classList.add('alert-info');
                        lockNote.textContent =
                            'Completed disbursement installments are locked. Only pending installments can be changed here.';
                    }
                }

                function buildLockedScheduleFields(type, installmentNo, dateValue, amountValue, label) {
                    const dateName = `${type}_dates[]`;
                    const amountName = `${type}_amounts[]`;

                    return `
                    <div class="col-md-6">
                        <label>${label} Date <span class="badge bg-secondary ms-1">Disbursed</span></label>
                        <input type="date" class="form-control" value="${normalizeDate(dateValue)}" disabled>
                        <input type="hidden" name="${dateName}" value="${normalizeDate(dateValue)}">
                    </div>
                    <div class="col-md-6">
                        <label>${label} Amount <span class="badge bg-secondary ms-1">Locked</span></label>
                        <input type="number" class="form-control" step="0.01" value="${amountValue ?? ''}" disabled>
                        <input type="hidden" name="${amountName}" value="${amountValue ?? ''}">
                    </div>
                `;
                }

                function lockCompletedScheduleRows(container, type) {
                    container.querySelectorAll('.row.g-3.mb-3').forEach((row, index) => {
                        const installmentNo = index + 1;
                        const completedSchedule = getCompletedSchedule(installmentNo);

                        if (!completedSchedule) {
                            return;
                        }

                        row.innerHTML = buildLockedScheduleFields(
                            type,
                            installmentNo,
                            completedSchedule.planned_date,
                            completedSchedule.planned_amount,
                            type === 'yearly' ? `Year ${installmentNo}` :
                            `Half-Year ${installmentNo}`
                        );
                    });
                }

                // Generate yearly fields based on saved data or selection
                function generateEditYearlyFields(count) {
                    yearlyFields.innerHTML = '';
                    if (!count || count < 1) {
                        updateEditTotal();
                        return;
                    }

                    for (let i = 0; i < count; i++) {
                        const div = document.createElement('div');
                        div.className = 'row g-3 mb-3';
                        div.innerHTML = `
                    <div class="col-md-6">
                        <label>Year ${i+1} Date</label>
                        <input type="date" name="yearly_dates[]" class="form-control"
                               value="${savedYearlyDates[i] || ''}">
                    </div>
                    <div class="col-md-6">
                        <label>Year ${i+1} Amount (₹)</label>
                        <input type="number" name="yearly_amounts[]" class="form-control yearly-amount-edit"
                               step="0.01" value="${savedYearlyAmounts[i] ?? ''}">
                    </div>
                `;
                        yearlyFields.appendChild(div);
                    }

                    lockCompletedScheduleRows(yearlyFields, 'yearly');

                    // Recalculate on change
                    document.querySelectorAll('.yearly-amount-edit').forEach(el => {
                        el.addEventListener('input', updateEditTotal);
                    });
                    updateEditTotal();
                }

                yearCountSelect?.addEventListener('change', () => {
                    enforceLockedCount(yearCountSelect);
                    generateEditYearlyFields(parseInt(yearCountSelect.value) || 0);
                });

                function generateEditHalfYearlyFields(count) {
                    halfYearlyFields.innerHTML = '';
                    if (!count || count < 1) {
                        updateEditTotal();
                        return;
                    }

                    for (let i = 0; i < count; i++) {
                        const div = document.createElement('div');
                        div.className = 'row g-3 mb-3';
                        div.innerHTML = `
                    <div class="col-md-6">
                        <label>Half-Year ${i+1} Date</label>
                        <input type="date" name="half_yearly_dates[]" class="form-control"
                               value="${savedHalfYearlyDates[i] || ''}">
                    </div>
                    <div class="col-md-6">
                        <label>Half-Year ${i+1} Amount </label>
                        <input type="number" name="half_yearly_amounts[]" class="form-control half-yearly-amount-edit"
                               step="0.01" value="${savedHalfYearlyAmounts[i] ?? ''}">
                    </div>
                `;
                        halfYearlyFields.appendChild(div);
                    }

                    lockCompletedScheduleRows(halfYearlyFields, 'half_yearly');

                    document.querySelectorAll('.half-yearly-amount-edit').forEach(el => {
                        el.addEventListener('input', updateEditTotal);
                    });
                    updateEditTotal();
                }

                halfYearCountSelect?.addEventListener('change', () => {
                    enforceLockedCount(halfYearCountSelect);
                    generateEditHalfYearlyFields(parseInt(halfYearCountSelect.value) || 0);
                });

                function toggleEditDisbursementSections() {
                    const selectedSystem = disbursementSystemSelect.value;
                    const isYearly = selectedSystem === 'yearly';

                    yearlySection.style.display = isYearly ? 'block' : 'none';
                    halfYearlySection.style.display = isYearly ? 'none' : 'block';

                    if (isYearly) {
                        const initialYearCount = parseInt(yearCountSelect.value, 10) || savedYearlyDates
                            .length || 0;
                        if (initialYearCount > 0) {
                            yearCountSelect.value = initialYearCount;
                        }
                        generateEditYearlyFields(initialYearCount);
                        halfYearlyFields.innerHTML = '';
                    } else {
                        const initialHalfYearCount = parseInt(halfYearCountSelect.value, 10) ||
                            savedHalfYearlyDates.length || 0;
                        if (initialHalfYearCount > 0) {
                            halfYearCountSelect.value = initialHalfYearCount;
                        }
                        generateEditHalfYearlyFields(initialHalfYearCount);
                        yearlyFields.innerHTML = '';
                    }
                }

                if (completedSchedules.length > 0) {
                    disbursementSystemSelect.dataset.originalValue = disbursementSystemSelect.value;
                }

                editCanBeJitoMemberSelect?.addEventListener('change', toggleEditExtraFields);
                editCanBeJeapDonorSelect?.addEventListener('change', toggleEditExtraFields);

                disbursementSystemSelect?.addEventListener('change', () => {
                    if (completedSchedules.length > 0) {
                        disbursementSystemSelect.value = disbursementSystemSelect.dataset
                            .originalValue || disbursementSystemSelect.value;
                        enforceLockedCount(disbursementSystemSelect.value === 'yearly' ?
                            yearCountSelect : halfYearCountSelect);
                        return;
                    }

                    toggleEditDisbursementSections();
                });

                // Installment logic (similar to main form)
                function toggleEditRemoveButtons() {
                    const rows = rowsContainer.querySelectorAll('.installment-row');
                    rows.forEach((row) => {
                        const removeBtn = row.querySelector('.remove-edit-installment');
                        if (!removeBtn) return;
                        removeBtn.disabled = rows.length === 1;
                        removeBtn.style.visibility = rows.length === 1 ? 'hidden' : 'visible';
                    });
                }

                addInstallmentBtn?.addEventListener('click', () => {
                    const row = document.createElement('div');
                    row.className = 'row g-3 installment-row mb-2';
                    row.innerHTML = `
                <div class="col-md-4">
                    <label>Amount (₹)</label>
                    <input type="number" name="installment_amount[]" class="form-control installment-amount" step="0.01">
                </div>
                <div class="col-md-4">
                    <label>No. of Months</label>
                    <input type="number" name="no_of_months[]" class="form-control installment-months">
                </div>
                <div class="col-md-4">
                    <label>Total (₹)</label>
                    <input type="number" class="form-control installment-total" readonly>
                </div>
                <div class="col-md-12 text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-edit-installment">
                        Remove
                    </button>
                </div>
            `;
                    rowsContainer.appendChild(row);
                    toggleEditRemoveButtons();
                    recalculateEditInstallments();
                });

                // Recalculate installments + additional
                function recalculateEditInstallments() {
                    let sanction = parseFloat(document.getElementById('edit-total-amount').value) || 0;
                    let used = 0;
                    let totalMonths = 0;

                    document.querySelectorAll('#edit-installment-rows .installment-row').forEach(row => {
                        const amt = parseFloat(row.querySelector('.installment-amount').value) || 0;
                        const months = parseInt(row.querySelector('.installment-months').value) ||
                            0;

                        const rowTotal = amt * months;
                        row.querySelector('.installment-total').value = rowTotal.toFixed(2);

                        used += rowTotal;
                        totalMonths += months;
                    });

                    let remaining = sanction - used;
                    if (remaining < 0) remaining = 0;

                    document.getElementById('edit-additional-amount').value = remaining.toFixed(2);

                    // ✅ Add 1 cheque if additional amount > 1
                    let extraCheque = remaining > 1 ? 1 : 0;

                    document.querySelector('input[name="no_of_cheques_to_be_collected"]').value =
                        totalMonths + extraCheque;
                }

                function updateEditTotal() {
                    let total = 0;
                    yearlyFields.querySelectorAll('input[name="yearly_amounts[]"]').forEach(input => {
                        total += parseFloat(input.value) || 0;
                    });
                    halfYearlyFields.querySelectorAll('input[name="half_yearly_amounts[]"]').forEach(
                        input => {
                            total += parseFloat(input.value) || 0;
                        });
                    document.getElementById('edit-total-amount').value = total.toFixed(2);
                    recalculateEditInstallments();
                }

                // Listen to all changes
                rowsContainer?.addEventListener('input', recalculateEditInstallments);
                rowsContainer?.addEventListener('click', (event) => {
                    const removeBtn = event.target.closest('.remove-edit-installment');
                    if (!removeBtn) return;

                    const rows = rowsContainer.querySelectorAll('.installment-row');
                    if (rows.length === 1) return;

                    removeBtn.closest('.installment-row')?.remove();
                    toggleEditRemoveButtons();
                    recalculateEditInstallments();
                });
                if (completedSchedules.length > 0) {
                    enforceLockedCount(disbursementSystemSelect.value === 'yearly' ? yearCountSelect :
                        halfYearCountSelect);
                }
                toggleEditDisbursementSections();
                toggleEditExtraFields();
                toggleEditRemoveButtons();
                recalculateEditInstallments();
            });
        });
    </script>

    @if ($errors->has('disbursement_system') || $errors->has('approval_financial_assistance_amount'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const editModal = document.getElementById('editWorkingCommitteeModal');
                if (!editModal || typeof bootstrap === 'undefined') return;

                const modalInstance = new bootstrap.Modal(editModal);
                modalInstance.show();
            });
        </script>
    @endif

    @if (old('date_update_mode') === 'disbursement_dates' &&
            ($errors->has('date_update_mode') || $errors->has('yearly_dates') || $errors->has('half_yearly_dates')))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const editDatesModal = document.getElementById('editDisbursementDatesModal');
                if (!editDatesModal || typeof bootstrap === 'undefined') return;

                const modalInstance = new bootstrap.Modal(editDatesModal);
                modalInstance.show();
            });
        </script>
    @endif
@endsection
