@extends('admin.layouts.master')

@section('title', 'Donor Details - JitoJeap Admin')

@section('content')
<div class="container">
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title"><i class="fas fa-hand-holding-heart me-2"></i> Donor Details</h1>
            <p class="dashboard-subtitle">{{ $donor->name }}</p>
        </div>
        <a href="{{ route('admin.donors.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="section-card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="info-label">Name</div>
                    <div class="fw-bold">{{ $donor->name }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Email</div>
                    <div class="fw-bold">{{ $donor->email }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Phone</div>
                    <div class="fw-bold">{{ $donor->phone ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Created At</div>
                    <div class="fw-bold">{{ $donor->created_at ? $donor->created_at->format('d/m/Y') : '-' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
