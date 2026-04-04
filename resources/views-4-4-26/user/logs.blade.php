@extends('user.layout.master')

@section('content')
    <style>
        .activity-timeline {
            position: relative;
            padding-left: 30px;
        }

        .activity-timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, #393185, #988DFF);
            border-radius: 2px;
        }

        .activity-date-group {
            margin-bottom: 30px;
        }

        .activity-date-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
        }

        .activity-date-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #393185;
            margin-left: 15px;
        }

        .activity-card {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            /* left: -35px; */
        }

        .activity-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
            border-color: #dee2e6;
        }

        .activity-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #393185, #988DFF);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.1rem;
            margin-right: 15px;
            box-shadow: 0 2px 8px rgba(57, 49, 133, 0.3);
        }

        .activity-meta {
            flex-grow: 1;
        }

        .user-name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 1rem;
        }

        .user-role {
            font-size: 0.8rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .activity-time {
            font-size: 0.85rem;
            color: #6c757d;
            margin-left: auto;
            background: #f8f9fa;
            padding: 4px 10px;
            border-radius: 20px;
            border: 1px solid #dee2e6;
        }

        .activity-content {
            margin-left: 55px;
        }

        .activity-title {
            font-weight: 600;
            color: #393185;
            margin-bottom: 8px;
            font-size: 1.1rem;
        }

        .activity-description {
            color: #495057;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .activity-details {
            background: #f8f9fa;
            border-left: 4px solid #393185;
            padding: 15px;
            border-radius: 0 8px 8px 0;
        }

        .activity-details ul {
            margin: 0;
            padding-left: 20px;
        }

        .activity-details li {
            margin-bottom: 5px;
            color: #495057;
        }

        .activity-type-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .activity-type-step {
            background: #e3dfff;
            color: #393185;
            border: 1px solid #d1c6ff;
        }

        .activity-type-document {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .activity-type-system {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .no-logs-container {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .no-logs-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .no-logs-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .activity-timeline::before {
                left: 10px;
            }

            .activity-card {
                left: -30px;
                padding: 15px;
            }

            .activity-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .user-avatar {
                margin-right: 0;
                margin-bottom: 10px;
            }

            .activity-time {
                margin-left: 0;
                margin-top: 5px;
            }

            .activity-content {
                margin-left: 0;
                margin-top: 10px;
            }
        }
    </style>

    <div class="col-lg-9 main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-card">
                        <div class="step-card">
                            <div class="card-icon">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <div>
                                <h5 class="card-title">Application Activity Log</h5>
                                <p class="card-subtitle">Track all activities related to your application</p>
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($logs->isEmpty())
                            <div class="no-logs-container">
                                <div class="no-logs-icon">
                                    <i class="bi bi-info-circle"></i>
                                </div>
                                <div class="no-logs-title">No Activity Found</div>
                                <p>Your application activity will appear here as you progress through the application
                                    process.</p>
                            </div>
                        @else
                            <div class="activity-timeline">
                                @php
                                    $groupedLogs = $logs->groupBy(function ($log) {
                                        return $log->process_date->format('Y-m-d');
                                    });
                                @endphp

                                @foreach ($groupedLogs as $date => $dateLogs)
                                    <div class="activity-date-group">
                                        <div class="activity-date-header">
                                            <div class="activity-date-title">
                                                {{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }}
                                            </div>
                                        </div>

                                        @foreach ($dateLogs as $log)
                                            <div class="activity-card">
                                                <div class="activity-header">
                                                    <div class="user-avatar">
                                                        @if ($log->process_by_name)
                                                            {{ strtoupper(substr($log->process_by_name, 0, 1)) }}
                                                        @else
                                                            S
                                                        @endif
                                                    </div>
                                                    <div class="activity-meta">
                                                        <div class="user-name">
                                                            @if ($log->process_by_name)
                                                                {{ $log->process_by_name }}
                                                            @else
                                                                System
                                                            @endif
                                                        </div>
                                                        {{-- @if ($log->process_by_role)
                                                            <div class="user-role">{{ ucfirst(str_replace('_', ' ', $log->process_by_role)) }}</div>
                                                        @endif --}}
                                                        @if ($log->process_by_role)
                                                            <div class="user-role">
                                                                {{ $log->process_by_role === 'user' ? 'Student' : ucfirst(str_replace('_', ' ', $log->process_by_role)) }}
                                                            </div>
                                                        @endif

                                                    </div>
                                                    <div class="activity-time">
                                                        {{ $log->process_date->format('h:i A') }}
                                                        <span style="color: #6c757d; font-weight: normal;">•</span>
                                                        {{ $log->process_date->diffForHumans() }}
                                                    </div>
                                                </div>

                                                <div class="activity-content">
                                                    <span
                                                        class="activity-type-badge
                                                        @if (str_contains(strtolower($log->process_type), 'step')) activity-type-step
                                                        @elseif(str_contains(strtolower($log->process_type), 'document')) activity-type-document
                                                        @else activity-type-system @endif">
                                                        {{ ucfirst(str_replace('_', ' ', $log->process_type)) }}
                                                    </span>

                                                    <div class="activity-title">
                                                        {{ ucfirst(str_replace('_', ' ', $log->process_action)) }}
                                                    </div>

                                                    <div class="activity-description">
                                                        {!! $log->process_description !!}
                                                    </div>

                                                    <div class="activity-details">
                                                        <strong>Details:</strong>
                                                        <ul>
                                                            <li><strong>Process:</strong>
                                                                {{ ucfirst(str_replace('_', ' ', $log->process_type)) }}
                                                            </li>
                                                            <li><strong>Action:</strong>
                                                                {{ ucfirst(str_replace('_', ' ', $log->process_action)) }}
                                                            </li>
                                                            <li><strong>Timestamp:</strong>
                                                                {{ $log->process_date->format('F j, Y \a\t h:i A') }}</li>
                                                            @if ($log->process_by_name)
                                                                <li><strong>Performed by:</strong>
                                                                    {{ $log->process_by_name }}
                                                                    ({{ ucfirst(str_replace('_', ' ', $log->process_by_role)) }})
                                                                </li>
                                                            @else
                                                                <li><strong>Performed by:</strong> System</li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
