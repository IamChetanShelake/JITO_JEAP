@extends('admin.layouts.master')

@section('title', 'View Chapter - JitoJeap Admin')

@section('content')
<div class="page-header mb-4">
    <h1 class="page-title" style="color: #393185;">Chapter Details</h1>
    <p class="page-subtitle">View chapter information</p>
</div>

<div class="section-card">
    <div class="card-body p-4">
        <div class="row g-4">
            <div class="col-md-6">
                <label class="text-muted small">Zone</label>
                <p class="fw-bold">{{ $chapter->zone->zone_name ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Chapter Head</label>
                <p class="fw-bold">{{ $chapter->chapter_head }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Chapter Name</label>
                <p class="fw-bold">{{ $chapter->chapter_name }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">City</label>
                <p class="fw-bold">{{ $chapter->city }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Pincode</label>
                <p class="fw-bold">{{ $chapter->pincode }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">State</label>
                <p class="fw-bold">{{ $chapter->state }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Email</label>
                <p class="fw-bold">{{ $chapter->email }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Contact</label>
                <p class="fw-bold">{{ $chapter->contact }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Status</label>
                <p>
                    <span class="status-badge {{ $chapter->status ? 'active' : 'inactive' }}">
                        {{ $chapter->status ? 'Active' : 'Inactive' }}
                    </span>
                </p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Visibility</label>
                <p>
                    <span class="badge {{ $chapter->show_hide ? 'bg-success' : 'bg-secondary' }}">
                        {{ $chapter->show_hide ? 'Visible' : 'Hidden' }}
                    </span>
                </p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Created At</label>
                <p>{{ $chapter->created_at->format('d M Y, h:i A') }}</p>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.chapters.edit', $chapter) }}" class="btn btn-custom">
                <i class="fas fa-edit me-2"></i> Edit
            </a>
            <a href="{{ route('admin.chapters.index') }}" class="btn btn-secondary ms-2">
                <i class="fas fa-arrow-left me-2"></i> Back to List
            </a>
        </div>
    </div>
</div>
@endsection
