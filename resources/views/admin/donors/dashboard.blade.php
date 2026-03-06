@extends('admin.layouts.master')

@section('title', 'Donor Dashboard - JitoJeap Admin')

@section('content')
    <div class="container">
        <div class="dashboard-header">
            <div>
                <h1 class="dashboard-title"><i class="fas fa-hand-holding-heart me-2"></i> Member Donors Dashboard</h1>
                <p class="dashboard-subtitle">Submitted and draft member donor applications</p>
            </div>
        </div>

        <div class="section-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Donor</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($donors as $donor)
                                @php
                                    $targetAmount = 5400000; // 54 lakhs
                                    $paymentEntries = $donor->paymentDetail->payment_entries ?? [];
                                    if (!is_array($paymentEntries)) {
                                        $paymentEntries = json_decode($paymentEntries, true);
                                    }
                                    $paymentEntries = is_array($paymentEntries) ? $paymentEntries : [];
                                    $totalPaid = collect($paymentEntries)->sum(function ($entry) {
                                        return (float) ($entry['amount'] ?? 0);
                                    });
                                    $isFullyPaid = $totalPaid >= $targetAmount;
                                    $status = $isFullyPaid ? 'paid' : ($donor->submit_status === 'completed' ? 'submitted' : 'draft');
                                @endphp
                                <tr>
                                    <td>{{ $donor->id }}</td>
                                    <td>{{ $donor->name }}</td>
                                    <td>{{ $donor->email }}</td>
                                    <td>{{ $donor->phone ?? '-' }}</td>
                                    <td>
                                        @if ($status === 'paid')
                                            <span class="badge bg-primary">Paid</span>
                                            <div class="small text-muted mt-1">
                                                ₹{{ number_format($totalPaid, 2) }} / ₹{{ number_format($targetAmount, 2) }}
                                            </div>
                                        @elseif ($status === 'submitted')
                                            <span class="badge bg-success">Submitted</span>
                                            <div class="small text-muted mt-1">
                                                ₹{{ number_format($totalPaid, 2) }} / ₹{{ number_format($targetAmount, 2) }}
                                            </div>
                                        @else
                                            <span class="badge bg-warning text-dark">Draft</span>
                                            <div class="small text-muted mt-1">
                                                ₹{{ number_format($totalPaid, 2) }} / ₹{{ number_format($targetAmount, 2) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.donors.dashboard.show', $donor) }}"
                                            class="btn btn-custom btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No donor applications found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
