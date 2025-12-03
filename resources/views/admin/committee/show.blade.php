@extends('admin.layouts.master')

@section('title', 'View Committee Member - JitoJeap Admin')

@section('content')
<div class="page-header mb-4">
    <h1 class="page-title" style="color: #FBBA00;">Working Committee Member Details</h1>
    <p class="page-subtitle">View member information</p>
</div>

<div class="section-card">
    <div class="card-body p-4">
        <div class="row g-4">
            <div class="col-md-6">
                <label class="text-muted small">Name</label>
                <p class="fw-bold">{{ $committee->name }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Department</label>
                <p class="fw-bold">{{ $committee->department }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Designation</label>
                <p class="fw-bold">{{ $committee->designation }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Email</label>
                <p class="fw-bold">{{ $committee->email }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Contact</label>
                <p class="fw-bold">{{ $committee->contact }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Status</label>
                <p>
                    <span class="status-badge {{ $committee->status ? 'active' : 'inactive' }}">
                        {{ $committee->status ? 'Active' : 'Inactive' }}
                    </span>
                </p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Visibility</label>
                <p>
                    <span class="badge {{ $committee->show_hide ? 'bg-success' : 'bg-secondary' }}">
                        {{ $committee->show_hide ? 'Visible' : 'Hidden' }}
                    </span>
                </p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Created At</label>
                <p>{{ $committee->created_at->format('d M Y, h:i A') }}</p>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.committee.edit', $committee) }}" class="btn btn-custom">
                <i class="fas fa-edit me-2"></i> Edit
            </a>
            <a href="{{ route('admin.committee.index') }}" class="btn btn-secondary ms-2">
                <i class="fas fa-arrow-left me-2"></i> Back to List
            </a>
        </div>
    </div>
</div>
@endsection
