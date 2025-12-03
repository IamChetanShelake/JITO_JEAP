@extends('admin.layouts.master')

@section('title', 'View Zone - JitoJeap Admin')

@section('content')
<div class="page-header mb-4">
    <h1 class="page-title" style="color: #E31E24;">Zone Details</h1>
    <p class="page-subtitle">View zone information</p>
</div>

<div class="section-card">
    <div class="card-body p-4">
        <div class="row g-4">
            <div class="col-md-6">
                <label class="text-muted small">Zone Head</label>
                <p class="fw-bold">{{ $zone->zone_head }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Zone Name</label>
                <p class="fw-bold">{{ $zone->zone_name }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Code</label>
                <p class="fw-bold">{{ $zone->code }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">State</label>
                <p class="fw-bold">{{ $zone->state }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Email</label>
                <p class="fw-bold">{{ $zone->email }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Contact</label>
                <p class="fw-bold">{{ $zone->contact }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Status</label>
                <p>
                    <span class="status-badge {{ $zone->status ? 'active' : 'inactive' }}">
                        {{ $zone->status ? 'Active' : 'Inactive' }}
                    </span>
                </p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Visibility</label>
                <p>
                    <span class="badge {{ $zone->show_hide ? 'bg-success' : 'bg-secondary' }}">
                        {{ $zone->show_hide ? 'Visible' : 'Hidden' }}
                    </span>
                </p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Created At</label>
                <p>{{ $zone->created_at->format('d M Y, h:i A') }}</p>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.zones.edit', $zone) }}" class="btn btn-custom">
                <i class="fas fa-edit me-2"></i> Edit
            </a>
            <a href="{{ route('admin.zones.index') }}" class="btn btn-secondary ms-2">
                <i class="fas fa-arrow-left me-2"></i> Back to List
            </a>
        </div>
    </div>
</div>
@endsection
