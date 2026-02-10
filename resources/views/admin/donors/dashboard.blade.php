@extends('admin.layouts.master')

@section('title', 'Donor Dashboard - JitoJeap Admin')

@section('content')
<div class="container">
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title"><i class="fas fa-hand-holding-heart me-2"></i> Donor Dashboard</h1>
            <p class="dashboard-subtitle">Submitted and draft donor applications</p>
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
                                $status = $donor->submit_status === 'completed' ? 'submitted' : 'draft';
                            @endphp
                            <tr>
                                <td>{{ $donor->id }}</td>
                                <td>{{ $donor->name }}</td>
                                <td>{{ $donor->email }}</td>
                                <td>{{ $donor->phone ?? '-' }}</td>
                                <td>
                                    @if ($status === 'submitted')
                                        <span class="badge bg-success">Submitted</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.donors.dashboard.show', $donor) }}" class="btn btn-custom btn-sm">
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
