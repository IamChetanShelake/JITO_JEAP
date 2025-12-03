@extends('admin.layouts.master')

@section('title', 'View Initiative - JitoJeap Admin')

@section('content')
<div class="page-header mb-4">
    <h1 class="page-title" style="color: #009846;">Initiative Details</h1>
    <p class="page-subtitle">View initiative information</p>
</div>

<div class="section-card">
    <div class="card-body p-4">
        <div class="row g-4">
            <div class="col-md-6">
                <label class="text-muted small">Initiative Leader</label>
                <p class="fw-bold">{{ $initiative->initiative_leader }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Initiative Name</label>
                <p class="fw-bold">{{ $initiative->initiative_name }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Designation</label>
                <p class="fw-bold">{{ $initiative->designation }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Email</label>
                <p class="fw-bold">{{ $initiative->email }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Contact</label>
                <p class="fw-bold">{{ $initiative->contact }}</p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Status</label>
                <p>
                    <span class="status-badge {{ $initiative->status ? 'active' : 'inactive' }}">
                        {{ $initiative->status ? 'Active' : 'Inactive' }}
                    </span>
                </p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Visibility</label>
                <p>
                    <span class="badge {{ $initiative->show_hide ? 'bg-success' : 'bg-secondary' }}">
                        {{ $initiative->show_hide ? 'Visible' : 'Hidden' }}
                    </span>
                </p>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Created At</label>
                <p>{{ $initiative->created_at->format('d M Y, h:i A') }}</p>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.initiatives.edit', $initiative) }}" class="btn btn-custom">
                <i class="fas fa-edit me-2"></i> Edit
            </a>
            <a href="{{ route('admin.initiatives.index') }}" class="btn btn-secondary ms-2">
                <i class="fas fa-arrow-left me-2"></i> Back to List
            </a>
        </div>
    </div>
</div>
@endsection
