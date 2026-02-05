@extends('admin.layouts.master')

@section('title', 'Admin Dashboard - JitoJeap')

@section('styles')
    <style>
        /* Mobile-first base styles */
        .container {
            width: 100%;
            padding: 0 1rem;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .dashboard-title {
            font-size: clamp(1.5rem, 4vw, 2rem);
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        .dashboard-subtitle {
            color: #666;
            font-size: clamp(0.85rem, 2.5vw, 0.95rem);
        }

        .change-country-btn {
            color: #E31E24;
            text-decoration: none;
            font-weight: 500;
            font-size: clamp(0.85rem, 2.5vw, 0.95rem);
            min-height: 44px;
            display: inline-flex;
            align-items: center;
        }

        /* Navigation - Mobile hamburger menu */
        .nav-tabs-custom {
            border: none;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            flex-wrap: wrap;
            /* overflow-x: auto; */
        }

        .nav-tabs-custom .nav-item {
            flex: 1;
            min-width: 120px;
        }

        .nav-tabs-custom .nav-link {
            border: none;
            border-radius: 25px;
            padding: 0.5rem 1rem;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;

            width: 100%;
            height: 44px;
            text-align: center;
            white-space: nowrap;
            min-width: 44px;
            min-height: 44px;
        }

        .nav-tabs-custom .nav-link:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Dashboard - Purple */
        .nav-tabs-custom .nav-link.tab-dashboard {
            background: #393185;
        }

        /* Apex - Green */
        .nav-tabs-custom .nav-link.tab-apex {
            background: #009846;
        }

        /* Working Committee - Yellow */
        .nav-tabs-custom .nav-link.tab-committee {
            background: #FBBA00;
        }

        /* Zone - Red */
        .nav-tabs-custom .nav-link.tab-zone {
            background: #E31E24;
        }

        /* Chapter - Purple */
        .nav-tabs-custom .nav-link.tab-chapter {
            background: #393185;
        }

        /* Initiatives - Green */
        .nav-tabs-custom .nav-link.tab-initiatives {
            background: #009846;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1rem;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .stat-card-title {
            font-size: clamp(0.8rem, 2vw, 0.9rem);
            color: #666;
            margin-bottom: 0.75rem;
        }

        .stat-card-value {
            font-size: clamp(1.5rem, 4vw, 2rem);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-card-subtitle {
            font-size: clamp(0.75rem, 2vw, 0.85rem);
            margin: 0;
        }

        .stat-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-left: auto;
        }

        .approval-section {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            border: 1px solid #e0e0e0;
            margin-bottom: 1rem;
        }

        .approval-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .approval-title {
            font-size: clamp(1rem, 3vw, 1.1rem);
            font-weight: 600;
            color: #333;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .approval-title i {
            font-size: clamp(1rem, 3vw, 1.2rem);
        }

        .approval-total {
            color: #999;
            font-size: clamp(0.8rem, 2vw, 0.9rem);
            font-weight: 400;
        }

        /* Section Title Colors */
        .approval-title.apex-title,
        .approval-title.apex-title i {
            color: #393185;
        }

        .approval-title.working-committee-title,
        .approval-title.working-committee-title i {
            color: #009846;
        }

        .approval-title.zone-title,
        .approval-title.zone-title i {
            color: #FBBA00;
        }

        .approval-title.chapter-title,
        .approval-title.chapter-title i {
            color: #E31E24;
        }

        .approval-title.initiatives-title,
        .approval-title.initiatives-title i {
            color: #393185;
        }

        .approval-rate {
            font-size: clamp(0.75rem, 2vw, 0.85rem);
            color: #666;
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: space-between;
        }

        .progress-custom {
            height: 8px;
            border-radius: 10px;
            background: #f0f0f0;
            margin-bottom: 1rem;
        }

        .progress-bar-custom {
            height: 100%;
            border-radius: 10px;
            transition: width 0.6s ease;
        }

        .status-badges {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .status-badge {
            border-radius: 12px;
            padding: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .status-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Desktop large screens (1280px and above) */
        @media (min-width: 1280px) {
            .status-badges {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .status-badge.approved {
            background: #e8f5e9;
            border-color: #c8e6c9;
        }

        .status-badge.pending {
            background: #fff8e1;
            border-color: #ffe082;
        }

        .status-badge.hold {
            background: #ffebee;
            border-color: #ffcdd2;
        }
        .status-badge.ready {
            background: #e3f2fd;
            border-color: #90caf9;
        }

        .status-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            border: 2px solid;
            background: transparent;
        }

        .status-icon.approved {
            border-color: #4caf50;
            color: #4caf50;
        }

        .status-icon.pending {
            border-color: #ffc107;
            color: #ffc107;
        }

        .status-icon.hold {
            border-color: #f44336;
            color: #f44336;
        }

        .status-label {
            font-size: clamp(0.7rem, 2vw, 0.85rem);
            color: #666;
            margin-bottom: 0.25rem;
        }

        .status-value {
            font-size: clamp(0.9rem, 3vw, 1.1rem);
            font-weight: 600;
            color: #333;
        }

        .recent-applications {
            background: white;
            border-radius: 15px;
            padding: 1rem;
            border: 1px solid #e0e0e0;
            margin-top: 1rem;
        }

        .recent-app-header {
            font-size: clamp(0.9rem, 3vw, 1rem);
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .recent-app-subtitle {
            font-size: clamp(0.75rem, 2vw, 0.85rem);
            color: #999;
            margin-bottom: 1rem;
        }

        .application-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .application-item:last-child {
            border-bottom: none;
        }

        .app-name {
            font-weight: 600;
            color: #333;
            font-size: clamp(0.8rem, 2.5vw, 0.95rem);
            margin-bottom: 0.1rem;
        }

        .app-category {
            color: #999;
            font-size: clamp(0.7rem, 2vw, 0.85rem);
        }

        .app-time {
            color: #999;
            font-size: clamp(0.7rem, 2vw, 0.85rem);
            min-width: 44px;
            min-height: 44px;
            display: flex;
            align-items: center;
        }

        /* Touch-friendly interactive elements */
        button,
        a,
        .tap-target {
            min-width: 44px;
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Fluid typography */
        html {
            font-size: clamp(1rem, -0.875rem + 8.333vw, 1.125rem);
        }

        /* Responsive heading scale */
        h1 {
            font-size: clamp(1.75rem, 4vw, 2.5rem);
        }

        h2 {
            font-size: clamp(1.5rem, 3.5vw, 2rem);
        }

        h3 {
            font-size: clamp(1.25rem, 3vw, 1.75rem);
        }

        /* Responsive spacing */
        .sp-1 {
            margin: 8px;
        }

        .sp-2 {
            margin: 16px;
        }

        /* Responsive images with lazy loading */
        img {
            max-width: 100%;
            height: auto;
        }

        /* Scrollable tables on mobile */
        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-wrapper table {
            min-width: 600px;
            width: 100%;
        }

        /* Orientation-aware layouts */
        .gallery {
            display: flex;
            flex-direction: column;
        }

        /* Prefers-reduced-motion support */
        @media (prefers-reduced-motion: reduce) {
            .animatable {
                animation: none !important;
                transition: none !important;
            }
        }

        /* Responsive form layouts */
        input,
        select,
        textarea {
            width: 100%;
            padding: 0.75rem;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .form-row>* {
            flex: 1;
            min-width: 0;
        }

        /* Accessible button styling */
        button {
            min-height: 44px;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            background: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:focus {
            outline: 2px solid #ffb400;
            box-shadow: 0 0 0 3px rgba(255, 180, 0, 0.3);
        }

        /* Content prioritization */
        .secondary {
            display: none;
        }

        /* Tablet-specific styles (600px - 1023px) */
        @media (min-width: 600px) and (max-width: 1023px) {
            .container {
                max-width: 720px;
                margin: auto;
            }

            .nav-tabs-custom .nav-link {
                padding: 0.75rem 1.5rem;
                height: 50px;
            }

            .status-badges {
                grid-template-columns: repeat(2, 1fr);
            }

            .stat-card {
                padding: 1.25rem;
            }

            .approval-section {
                padding: 1.75rem;
            }

            .recent-applications {
                padding: 1.5rem;
            }

            .sp-4 {
                margin: 32px;
            }

            .sp-5 {
                margin: 40px;
            }

            .secondary {
                display: block;
            }

            /* Tablet landscape orientation */
            @media (orientation: landscape) and (max-width: 1023px) {
                .gallery {
                    flex-direction: row;
                }
            }

            /* Form layouts for tablets */
            .form-row {
                display: flex;
                gap: 1rem;
            }

            .form-row>* {
                flex: 1;
            }
        }

        /* Tablet landscape specific (1024px - 1279px) */
        @media (min-width: 1024px) and (max-width: 1279px) {
            .grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 1.5rem;
            }

            .status-badges {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* Desktop large screens (1280px and above) */
        @media (min-width: 1280px) {
            .status-badges {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* Conditional stylesheet loading */
        @media (min-width: 600px) and (max-width: 1023px) {
            /* Tablet-specific CSS would be loaded here */
        }
    </style>
@endsection

@section('content')



    <!-- Dashboard Header -->
    <div class="container">
        <div class="dashboard-header">
            <div>
                <h1 class="dashboard-title"><i class="fas fa-th-large me-2"></i> Admin Dashboard</h1>
                <p class="dashboard-subtitle">India</p>
            </div>
            <a href="#" class="change-country-btn"><i class="fas fa-globe me-1"></i> Change Country</a>
        </div>

        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs-custom">
            <li class="nav-item">
                <a class="nav-link tab-dashboard" href="{{ route('admin.home') }}">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link tab-apex" href="{{ route('admin.apex.index') }}">
                    <i class="fas fa-users"></i> Apex
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link tab-committee" href="{{ route('admin.committee.index') }}">
                    <i class="fas fa-user-tie"></i> Working Committee
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link tab-zone" href="{{ route('admin.zones.index') }}">
                    <i class="fas fa-globe"></i> Zone
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link tab-chapter" href="{{ route('admin.chapters.index') }}">
                    <i class="fas fa-map-marker-alt"></i> Chapter
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link tab-initiatives" href="{{ route('admin.initiatives.index') }}">
                    <i class="fas fa-lightbulb"></i> Initiatives
                </a>
            </li>
        </ul>

        <!-- Statistics Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.total.applications') }}"
                    style="text-decoration: none; color: inherit;display:block;">
                    <div class="stat-card">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <div class="stat-card-title">Total Applicants</div>
                                <div class="stat-card-value">{{ \App\Models\User::where('role', 'user')->count() }}</div>
                                <p class="stat-card-subtitle" style="color: #666;">+ 48 this month</p>
                            </div>
                            <div class="stat-card-icon" style="background: #e8eaf6;">
                                <i class="fas fa-file-alt" style="color: #393185;"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <div class="stat-card-title">Active Initiatives</div>
                            <div class="stat-card-value" style="color: #009846;">22</div>
                            <p class="stat-card-subtitle" style="color: #009846;">Out of 28 total</p>
                        </div>
                        <div class="stat-card-icon" style="background: #e8f5e9;">
                            <i class="fas fa-chart-line" style="color: #009846;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <div class="stat-card-title">Pending Reviews</div>
                            <div class="stat-card-value" style="color: #FBBA00;">
                                {{ \App\Models\User::where('role', 'user')->whereHas('workflowStatus', function ($q) {$q->where('final_status', 'in_progress');})->count() }}
                            </div>
                            <p class="stat-card-subtitle" style="color: #FBBA00;">Across all categories</p>
                        </div>
                        <div class="stat-card-icon" style="background: #fff8e1;">
                            <i class="fas fa-clock" style="color: #FBBA00;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.total.hold') }}" style="text-decoration: none; color: inherit;display:block;">
                    <div class="stat-card">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <div class="stat-card-title">On Hold</div>
                                <div class="stat-card-value" style="color: #E31E24;">
                                    {{ \App\Models\User::where('role', 'user')->whereHas('workflowStatus', function ($q) {$q->where('final_status', 'rejected');})->count() }}
                                </div>
                                <p class="stat-card-subtitle" style="color: #E31E24;">Need attention</p>
                            </div>
                            <div class="stat-card-icon" style="background: #ffebee;">
                                <i class="fas fa-exclamation-circle" style="color: #E31E24;"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>




        <!-- Approval Sections -->
        <!-- Row 1: Apex Step 1, Chapter -->
        <div class="row g-3">
            <div class="col-lg-6">
                @if (in_array($activeGuard, ['admin', 'apex']))
                    <!-- Apex stage 1 -->
                    <div class="approval-section">
                        <div class="approval-header">
                            <div class="approval-title apex-title">
                                <i class="fas fa-users"></i>
                                Apex Stage 1
                            </div>
                            <div class="approval-total">Total -
                                {{ \App\Models\User::where('role', 'user')->whereHas('workflowStatus')->count() }}</div>
                        </div>
                        <div class="approval-rate">
                            <span>Approval Rate</span>
                            <span>80%</span>
                        </div>
                        <div class="progress-custom">
                            <div class="progress-bar-custom"
                                style="width: 80%; background: linear-gradient(90deg, #495049, #6e796f);"></div>
                        </div>
                        <div class="status-badges" style="grid-template-columns: repeat(4, 1fr);">
                            <a href="{{ route('admin.apex.stage1.approved') }}" class="status-badge approved"
                                style="text-decoration: none; color: inherit;">
                                <div class="status-icon approved">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <div class="status-label">Appex Staff Approved</div>
                                    <div class="status-value">
                                        {{ \App\Models\User::where('role', 'user')->whereHas('workflowStatus', function ($q) {
                                                $q->where('apex_1_status', 'approved');
                                            })->count() }}
                                    </div>
                                </div>
                            </a>
                            <a href="{{ route('admin.apex.stage1.pending') }}" class="status-badge pending"
                                style="text-decoration: none; color: inherit;">
                                <div class="status-icon pending">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <div class="status-label">Draft</div>
                                    <div class="status-value">
                                        {{ \App\Models\User::where('role', 'user')->whereHas('workflowStatus', function ($q) {
                                                $q->where('apex_1_status', 'pending')->where('final_status', 'in_progress')->whereNull('apex_1_reject_remarks');
                                            })->count() }}
                                    </div>
                                </div>
                            </a>
                            <a href="{{ route('admin.apex.stage1.hold') }}" class="status-badge hold"
                                style="text-decoration: none; color: inherit;">
                                <div class="status-icon hold">
                                    <i class="fas fa-exclamation"></i>
                                </div>
                                <div>
                                    <div class="status-label">Send back for Correction</div>
                                    <div class="status-value">
                                        {{ \App\Models\User::where('role', 'user')->whereHas('workflowStatus', function ($q) {
                                                $q->where('apex_1_status', 'rejected');
                                            })->count() }}
                                    </div>
                                </div>
                            </a>


                            <a href="{{ route('admin.apex.stage1.resubmitted') }}" class="status-badge hold"
                                style="text-decoration: none; color: inherit;">
                                <div class="status-icon hold">
                                    <i class="fas fa-exclamation"></i>
                                </div>
                                <div>
                                    <div class="status-label">Resubmitted Applicants</div>
                                    <div class="status-value">
                                        {{ \App\Models\User::where('role', 'user')->whereHas('workflowStatus', function ($q) {
                                                $q->where('apex_1_status', 'pending')->where('apex_1_reject_remarks', '!=','null');
                                            })->count() }}
                                    </div>
                                </div>
                            </a>

                        </div>
                    </div>
                @endif
            </div>
            <div class="col-lg-6">
                <!-- chapter -->
                @php
                    $chapter_total = \App\Models\User::where('role', 'user')
                        ->whereHas('workflowStatus', function ($q) {
                            $q->whereIn('current_stage', ['chapter', 'working_committee', 'apex_2']);
                        })
                        ->count();
                    $chapter_approved = \App\Models\User::where('role', 'user')
                        ->whereHas('workflowStatus', function ($q) {
                            $q->whereIn('current_stage', ['chapter', 'working_committee', 'apex_2'])->where(
                                'final_status',
                                'approved',
                            );
                        })
                        ->count();
                    $chapter_progress = $chapter_total > 0 ? ($chapter_approved / $chapter_total) * 100 : 0;
                @endphp
               @if (in_array($activeGuard, ['admin', 'apex', 'chapter']))
                    <div class="approval-section">
                        <div class="approval-header">
                            <div class="approval-title working-committee-title">
                                <i class="fas fa-user-tie"></i>
                                Chapter
                            </div>
                            <div class="approval-total">Total - {{ $chapter_total }}</div>
                        </div>
                        <div class="approval-rate">
                            <span>Approval Rate</span>
                            <span>{{ $chapter_total > 0 ? round(($chapter_approved / $chapter_total) * 100) : 0 }}%</span>
                        </div>
                        <div class="progress-custom">
                            <div class="progress-bar-custom"
                                style="width: {{ $chapter_progress }}%; background: linear-gradient(90deg, #495049, #6e796f);">
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="{{ route('admin.chapters.stats') }}" class="btn btn-primary btn-lg"
                                style="padding: 0.75rem 2rem; font-size: 1rem;">
                                <i class="fas fa-chart-bar me-2"></i> View Chapter Statistics
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Row 2: Working Committee, Apex Step 2 -->
        <div class="row g-3">
            <div class="col-lg-6">
                @if (in_array($activeGuard, ['admin', 'apex', 'committee']))
                    @php
                        // $working_committee_total = \App\Models\User::where('role', 'user')
                        //     ->whereHas('workflowStatus', function ($q) {
                        //         $q->where('current_stage', 'working_committee');
                        //     })
                        //     ->count();
                        $working_committee_approved = \App\Models\User::where('role', 'user')
                            ->whereHas('workflowStatus', function ($q) {
                                $q->where('working_committee_status', 'approved');
                            })
                            ->count();
                        $working_committee_pending = \App\Models\User::where('role', 'user')
                            ->whereHas('workflowStatus', function ($q) {
                                $q->where('current_stage', 'working_committee')->where('final_status', 'in_progress');
                            })
                            ->count();
                        $working_committee_hold = \App\Models\User::where('role', 'user')
                            ->whereHas('workflowStatus', function ($q) {
                                $q->where('working_committee_status', 'hold');
                            })
                            ->count();

                        $working_committee_reject = \App\Models\User::where('role', 'user')
                            ->whereHas('workflowStatus', function ($q) {
                                $q->where('working_committee_status', 'rejected');
                            })
                            ->count();
                        $working_committee_total = $working_committee_approved + $working_committee_pending + $working_committee_hold + $working_committee_reject;

                        $working_committee_progress = $working_committee_total > 0 ? ($working_committee_approved / $working_committee_total) * 100 : 0;
                    @endphp
                    <!-- working committee -->
                    <div class="approval-section">
                        <div class="approval-header">
                            <div class="approval-title zone-title">
                                <i class="fas fa-globe"></i>
                                Working Committee
                            </div>
                            <div class="approval-total">Total - {{ $working_committee_total }}</div>
                        </div>
                        <div class="approval-rate">
                            <span>Approval Rate</span>
                            <span>{{ $working_committee_total > 0 ? round(($working_committee_approved / $working_committee_total) * 100) : 0 }}%</span>
                        </div>
                        <div class="progress-custom">
                            <div class="progress-bar-custom"
                                style="width: {{ $working_committee_progress }}%; background: linear-gradient(90deg, #495049, #6e796f);"></div>
                        </div>
                        <div class="status-badges" style="grid-template-columns: repeat(4, 1fr);">
                            <a href="{{ route('admin.working_committee.approved') }}" class="status-badge approved"
                                style="text-decoration: none; color: inherit;">
                                <div class="status-icon approved">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <div class="status-label">Approved</div>
                                    <div class="status-value">
                                        {{ $working_committee_approved }}
                                    </div>
                                </div>
                            </a>
                            <a href="{{ route('admin.working_committee.pending') }}" class="status-badge pending"
                                style="text-decoration: none; color: inherit;">
                                <div class="status-icon pending">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <div class="status-label">Pending</div>
                                    <div class="status-value">
                                        {{ $working_committee_pending }}
                                    </div>
                                </div>
                            </a>
                            <a href="{{ route('admin.working_committee.hold') }}" class="status-badge hold"
                                style="text-decoration: none; color: inherit;">
                                <div class="status-icon hold">
                                    <i class="fas fa-exclamation"></i>
                                </div>
                                <div>
                                    <div class="status-label">Hold</div>
                                    <div class="status-value">
                                        {{ $working_committee_hold }}
                                    </div>
                                </div>
                            </a>
                            <a href="{{ route('admin.working_committee.reject') }}" class="status-badge hold"
                                style="text-decoration: none; color: inherit;">
                                <div class="status-icon hold">
                                    <i class="fas fa-exclamation"></i>
                                </div>
                                <div>
                                    <div class="status-label">Reject</div>
                                    <div class="status-value">
                                        {{ $working_committee_reject }}
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-lg-6">
                @if (in_array($activeGuard, ['admin', 'apex']))
                    <!-- Apex stage 1 -->
                    <div class="approval-section">
                        <div class="approval-header">
                            <div class="approval-title apex-title">
                                <i class="fas fa-users"></i>
                                Apex Stage 2 (Post Dated Cheques Details)
                            </div>
                            <div class="approval-total">Total -
                                {{ \App\Models\User::where('role', 'user')->whereHas('workflowStatus')->count() }}</div>
                        </div>
                        <div class="approval-rate">
                            <span>Approval Rate</span>
                            <span>80%</span>
                        </div>
                        <div class="progress-custom">
                            <div class="progress-bar-custom"
                                style="width: 80%; background: linear-gradient(90deg, #495049, #6e796f);"></div>
                        </div>
                        <div class="status-badges" style="grid-template-columns: repeat(4, 1fr);">
                            <a href="{{ route('admin.apex.stage2.approved') }}" class="status-badge approved"
                                style="text-decoration: none; color: inherit;">
                                <div class="status-icon approved">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <div class="status-label">Appex Staff Approved</div>
                                    <div class="status-value">
                                        {{ \App\Models\User::where('role', 'user')->whereHas('workflowStatus', function ($q) {
                                                $q->where('apex_2_status', 'approved');
                                            })->count() }}
                                    </div>
                                </div>
                            </a>
                            <a href="{{ route('admin.apex.stage2.pending') }}" class="status-badge pending"
                                style="text-decoration: none; color: inherit;">
                                <div class="status-icon pending">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <div class="status-label">Pending</div>
                                    <div class="status-value">
                                        {{ \App\Models\User::where('role', 'user')->whereHas('workflowStatus', function ($q) {
                                                $q->where('apex_2_status', 'pending')->where('final_status', 'in_progress')->where('current_stage','apex_2')->whereNull('apex_2_reject_remarks');
                                            })->count() }}
                                    </div>
                                </div>
                            </a>
                            <a href="{{ route('admin.apex.stage2.hold') }}" class="status-badge hold"
                                style="text-decoration: none; color: inherit;">
                                <div class="status-icon hold">
                                    <i class="fas fa-exclamation"></i>
                                </div>
                                <div>
                                    <div class="status-label">Send back for Correction</div>
                                    <div class="status-value">
                                        {{ \App\Models\User::where('role', 'user')->whereHas('workflowStatus', function ($q) {
                                                $q->where('apex_2_status', 'rejected');
                                            })->count() }}
                                    </div>
                                </div>
                            </a>


                            <a href="{{ route('admin.apex.stage2.resubmitted') }}" class="status-badge hold"
                                style="text-decoration: none; color: inherit;">
                                <div class="status-icon hold">
                                    <i class="fas fa-exclamation"></i>
                                </div>
                                <div>
                                    <div class="status-label">Resubmitted Applicants</div>
                                    <div class="status-value">
                                        {{ \App\Models\User::where('role', 'user')->whereHas('workflowStatus', function ($q) {
                                                $q->where('apex_2_status', 'pending')->where('apex_2_reject_remarks', '!=','null');
                                            })->count() }}
                                    </div>
                                </div>
                            </a>

                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Row 3: Accounts Department, Disbursement -->
        <div class="row g-3">
            <div class="col-lg-6">
               @if (in_array($activeGuard, ['admin', 'apex']))
                    <!-- Accounts Department -->
                    <div class="approval-section">
                        <div class="approval-header">
                            <div class="approval-title initiatives-title">
                                <i class="fas fa-lightbulb"></i>
                                Accounts Department
                            </div>
                            <div class="approval-total">Total - {{ $disbursementTotal ?? 0 }}</div>
                        </div>
                        <div class="approval-rate">
                            <span>Disbursement Progress</span>
                            <span>{{ $disbursementTotal > 0 ? round(($disbursementCompleted / $disbursementTotal) * 100) : 0 }}%</span>
                        </div>
                        <div class="progress-custom">
                            <div class="progress-bar-custom"
                                style="width: {{ $disbursementTotal > 0 ? ($disbursementCompleted / $disbursementTotal) * 100 : 0 }}%; background: linear-gradient(90deg, #009846, #00b359);"></div>
                        </div>
                        <div class="status-badges">
                            <a href="{{ route('admin.disbursement.completed') }}" class="status-badge approved" style="text-decoration: none; color: inherit;">
                                <div class="status-icon approved">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <div class="status-label">Disbursement Completed</div>
                                    <div class="status-value">{{ $disbursementCompleted ?? 0 }}</div>
                                </div>
                            </a>
                            <a href="{{ route('admin.disbursement.in_progress') }}" class="status-badge pending" style="text-decoration: none; color: inherit;">
                                <div class="status-icon pending">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <div class="status-label">In Progress</div>
                                    <div class="status-value">{{ $disbursementInProgress ?? 0 }}</div>
                                </div>
                            </a>
                            <a href="{{ route('admin.disbursement.pending') }}" class="status-badge hold" style="text-decoration: none; color: inherit;">
                                <div class="status-icon hold">
                                    <i class="fas fa-exclamation"></i>
                                </div>
                                <div>
                                    <div class="status-label">Ready for Disbursement</div>
                                    <div class="status-value">{{ $disbursementPending ?? 0 }}</div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-lg-6">
                @if (in_array($activeGuard, ['admin', 'apex']))
                    <!-- Disbursement Summary -->
                    <div class="approval-section">
                        <div class="approval-header">
                            <div class="approval-title chapter-title">
                                <i class="fas fa-money-bill-wave" style="color: #4caf50;"></i>
                                <a href="{{ route('admin.disbursement.index') }}" style="color: #4caf50; text-decoration: none;">
                                    <span>Disbursement Summary</span>
                                </a>
                            </div>
                            <div class="approval-total">Total - {{ $disbursementTotal ?? 0 }}</div>
                        </div>
                        <div class="approval-rate">
                            <span>Completion Rate</span>
                            <span>{{ $disbursementTotal > 0 ? round(($disbursementCompleted / $disbursementTotal) * 100) : 0 }}%</span>
                        </div>
                        <div class="progress-custom">
                            <div class="progress-bar-custom"
                                style="width: {{ $disbursementTotal > 0 ? ($disbursementCompleted / $disbursementTotal) * 100 : 0 }}%; background: linear-gradient(90deg, #009846, #00b359);"></div>
                        </div>
                        <div class="status-badges">
                            <a href="{{ route('admin.disbursement.completed') }}" class="status-badge approved" style="text-decoration: none; color: inherit;">
                                <div class="status-icon approved">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <div class="status-label">Completed</div>
                                    <div class="status-value">{{ $disbursementCompleted ?? 0 }}</div>
                                </div>
                            </a>
                            <a href="{{ route('admin.disbursement.in_progress') }}" class="status-badge pending" style="text-decoration: none; color: inherit;">
                                <div class="status-icon pending">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <div class="status-label">In Progress</div>
                                    <div class="status-value">{{ $disbursementInProgress ?? 0 }}</div>
                                </div>
                            </a>
                            <a href="{{ route('admin.disbursement.pending') }}" class="status-badge ready" style="text-decoration: none; color: inherit;">
                                <div class="status-icon ready">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                                <div>
                                    <div class="status-label">Ready</div>
                                    <div class="status-value">{{ $disbursementPending ?? 0 }}</div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
