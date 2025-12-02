@extends('admin.layouts.master')

@section('title', 'Chapter Details - JitoJeap Admin')

@section('content')
<div class="section-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i> Chapter Details</h4>
        <div>
            <a href="{{ route('admin.chapters.edit', $chapter) }}" class="btn btn-success-custom">
                <i class="fas fa-edit me-2"></i> Edit
            </a>
            <a href="{{ route('admin.chapters.index') }}" class="btn btn-custom">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted">Zone</h6>
                <p class="fs-5">{{ $chapter->zone->zone_name ?? 'Not specified' }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted">Chapter Name</h6>
                <p class="fs-5">{{ $chapter->chapter_name }}</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted">Code</h6>
                <p><strong>{{ $chapter->code }}</strong></p>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted">City</h6>
                <p>{{ $chapter->city }}</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted">Pincode</h6>
                <p>{{ $chapter->pincode }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted">State</h6>
                <p>{{ $chapter->state }}</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted">Chairman</h6>
                <p>{{ $chapter->chairman }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted">Contact No</h6>
                <p>{{ $chapter->contact_no }}</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted">Status</h6>
                <p>
                    @if($chapter->status)
                        <span class="badge-status-active">Active</span>
                    @else
                        <span class="badge-status-inactive">Inactive</span>
                    @endif
                </p>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted">Created At</h6>
                <p>{{ $chapter->created_at->format('d M Y, h:i A') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
