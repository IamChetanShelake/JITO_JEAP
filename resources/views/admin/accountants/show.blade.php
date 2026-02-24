@extends('admin.layouts.master')

@section('title', 'View Accountant - JitoJeap Admin')

@section('content')
<div class="section-card">
    <div class="card-header">Accountant Details</div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="text-muted small">Name</label>
                <div class="fw-bold">{{ $accountant->name }}</div>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Designation</label>
                <div class="fw-bold">{{ $accountant->designation ?: '-' }}</div>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Email</label>
                <div class="fw-bold">{{ $accountant->email }}</div>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Contact</label>
                <div class="fw-bold">{{ $accountant->contact }}</div>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Status</label>
                <div class="fw-bold">{{ $accountant->status ? 'Active' : 'Inactive' }}</div>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Visibility</label>
                <div class="fw-bold">{{ $accountant->show_hide ? 'Shown' : 'Hidden' }}</div>
            </div>
            <div class="col-md-6">
                <label class="text-muted small">Created At</label>
                <div class="fw-bold">{{ $accountant->created_at ? $accountant->created_at->format('d M Y h:i A') : '-' }}</div>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.accountants.edit', $accountant) }}" class="btn btn-custom">Edit</a>
            <a href="{{ route('admin.accountants.index') }}" class="btn btn-secondary ms-2">Back</a>
        </div>
    </div>
</div>
@endsection
