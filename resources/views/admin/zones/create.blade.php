@extends('admin.layouts.master')

@section('title', 'Add Zone - JitoJeap Admin')

@section('content')
<div class="page-header mb-4">
    <h1 class="page-title" style="color: #E31E24;">Add Zone</h1>
    <p class="page-subtitle">Add a new regional zone</p>
</div>

<div class="section-card">
    <div class="card-body p-4">
        <form action="{{ route('admin.zones.store') }}" method="POST">
            @csrf
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="zone_head" class="form-label">Zone Head <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('zone_head') is-invalid @enderror"
                           id="zone_head" name="zone_head" value="{{ old('zone_head') }}" required>
                    @error('zone_head')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="zone_name" class="form-label">Zone Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('zone_name') is-invalid @enderror"
                           id="zone_name" name="zone_name" value="{{ old('zone_name') }}" required>
                    @error('zone_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="code" class="form-label">Code <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror"
                           id="code" name="code" value="{{ old('code') }}" required>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('state') is-invalid @enderror"
                           id="state" name="state" value="{{ old('state') }}" required>
                    @error('state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="contact" class="form-label">Contact <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('contact') is-invalid @enderror" 
                           id="contact" name="contact" value="{{ old('contact') }}" required>
                    @error('contact')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label d-block">Status</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1" 
                               {{ old('status', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Active</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label d-block">Show/Hide</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="show_hide" name="show_hide" value="1" 
                               {{ old('show_hide', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="show_hide">Show on website</label>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-custom">
                    <i class="fas fa-save me-2"></i> Save Zone
                </button>
                <a href="{{ route('admin.zones.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-times me-2"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
