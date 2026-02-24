@extends('admin.layouts.master')

@section('title', $pageTitle . ' - JITO JEAP')

@section('content')
<div class="container">
    <div class="dashboard-header mb-3">
        <div>
            <h1 class="dashboard-title">
                <i class="fas fa-calendar-alt me-2"></i>
                {{ $pageTitle }}
            </h1>
            <p class="dashboard-subtitle">Accounts Department</p>
        </div>
        <a href="{{ route('admin.home') }}" class="change-country-btn">
            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
        </a>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="mb-3">
                <a href="{{ route('admin.disbursement.export', array_merge(['period' => $period], request()->query())) }}"
                   class="btn btn-success">
                    <i class="fas fa-file-excel me-1"></i> Export to Excel
                </a>
            </div>

            @if($period === 'upcoming')
                <div class="mb-3">
                    <a href="{{ route('admin.disbursement.upcoming', array_merge(request()->except(['today_only', 'date_from', 'date_to']), ['today_only' => 1])) }}"
                       class="btn {{ !empty($todayOnly) ? 'btn-success' : 'btn-outline-success' }} me-2">
                        <i class="fas fa-calendar-day me-1"></i>
                        Today Pending ({{ $todayPendingCount ?? 0 }})
                    </a>
                    @if(!empty($todayOnly))
                        <a href="{{ route('admin.disbursement.upcoming', request()->except(['today_only', 'date_from', 'date_to'])) }}" class="btn btn-outline-secondary">
                            Show All Upcoming
                        </a>
                    @endif
                </div>
            @endif

            <form method="GET" action="{{ $period === 'upcoming' ? route('admin.disbursement.upcoming') : route('admin.disbursement.past') }}">
                @if(!empty($todayOnly))
                    <input type="hidden" name="today_only" value="1">
                @endif
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Student Type</label>
                        <select name="student_type" class="form-select">
                            <option value="">All</option>
                            <option value="domestic_ug" {{ $studentType === 'domestic_ug' ? 'selected' : '' }}>Domestic - UG</option>
                            <option value="domestic_pg" {{ $studentType === 'domestic_pg' ? 'selected' : '' }}>Domestic - PG</option>
                            <option value="foreign_pg" {{ $studentType === 'foreign_pg' ? 'selected' : '' }}>Foreign - PG</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Date From</label>
                        <input type="date" name="date_from" class="form-control" value="{{ $dateFrom }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Date To</label>
                        <input type="date" name="date_to" class="form-control" value="{{ $dateTo }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-1"></i> Apply Filters
                        </button>
                        <a href="{{ $period === 'upcoming' ? route('admin.disbursement.upcoming') : route('admin.disbursement.past') }}" class="btn btn-outline-secondary">
                            Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="mb-3">
                <i class="fas fa-list me-2"></i>
                {{ $pageTitle }} List ({{ $schedules->count() }})
            </h5>

            @if($schedules->isEmpty())
                <div class="alert alert-info mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    No records found for selected filters.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Student Type</th>
                                <th>Installment</th>
                                <th>Paid Installments</th>
                                <th>Pending Installments</th>
                                <th>Planned Date</th>
                                <th>Planned Amount</th>
                                <th>Disbursement Date</th>
                                <th>Disbursed Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->user_id }}</td>
                                    <td>{{ $schedule->student_name }}</td>
                                    <td>{{ $schedule->student_type }}</td>
                                    <td>{{ $schedule->installment_no }}</td>
                                    <td>{{ $schedule->paid_installments ?? 0 }}</td>
                                    <td>{{ $schedule->pending_installments ?? 0 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->planned_date)->format('d M Y') }}</td>
                                    <td>Rs {{ number_format($schedule->planned_amount, 2) }}</td>
                                    <td>
                                        @if($schedule->disbursement_date)
                                            {{ \Carbon\Carbon::parse($schedule->disbursement_date)->format('d M Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($schedule->disbursed_amount)
                                            Rs {{ number_format($schedule->disbursed_amount, 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($schedule->status === 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($schedule->status === 'in_progress')
                                            <span class="badge bg-primary">In Progress</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.disbursement.show', $schedule->user_id) }}" class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
