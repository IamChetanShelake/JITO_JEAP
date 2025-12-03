@extends('admin.layouts.master')

@section('title', 'Add Initiative - JitoJeap Admin')

@section('content')
<div class="page-header mb-4">
    <h1 class="page-title" style="color: #009846;">Add Initiative</h1>
    <p class="page-subtitle">Create a new organizational initiative</p>
</div>

<div class="section-card">
    <div class="card-body p-4">
        <form action="{{ route('admin.initiatives.store') }}" method="POST">
            @csrf
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="initiative_leader" class="form-label">Initiative Leader <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('initiative_leader') is-invalid @enderror" 
                           id="initiative_leader" name="initiative_leader" value="{{ old('initiative_leader') }}" required>
                    @error('initiative_leader')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="initiative_name" class="form-label">Initiative Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('initiative_name') is-invalid @enderror" 
                           id="initiative_name" name="initiative_name" value="{{ old('initiative_name') }}" required>
                    @error('initiative_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="designation" class="form-label">Designation <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('designation') is-invalid @enderror" 
                           id="designation" name="designation" value="{{ old('designation') }}" required>
                    @error('designation')
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
                    <i class="fas fa-save me-2"></i> Save Initiative
                </button>
                <a href="{{ route('admin.initiatives.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-times me-2"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
