@extends('admin.layouts.master')

@section('title', 'Edit Committee Member - JitoJeap Admin')

@section('content')
<div class="page-header mb-4">
    <h1 class="page-title" style="color: #FBBA00;">Edit Working Committee Member</h1>
    <p class="page-subtitle">Update member information</p>
</div>

<div class="section-card">
    <div class="card-body p-4">
        <form action="{{ route('admin.committee.update', $committee) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $committee->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="department" class="form-label">Department <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('department') is-invalid @enderror" 
                           id="department" name="department" value="{{ old('department', $committee->department) }}" required>
                    @error('department')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="designation" class="form-label">Designation <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('designation') is-invalid @enderror" 
                           id="designation" name="designation" value="{{ old('designation', $committee->designation) }}" required>
                    @error('designation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email', $committee->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="contact" class="form-label">Contact <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('contact') is-invalid @enderror" 
                           id="contact" name="contact" value="{{ old('contact', $committee->contact) }}" required>
                    @error('contact')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label d-block">Status</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1" 
                               {{ old('status', $committee->status) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Active</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label d-block">Show/Hide</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="show_hide" name="show_hide" value="1" 
                               {{ old('show_hide', $committee->show_hide) ? 'checked' : '' }}>
                        <label class="form-check-label" for="show_hide">Show on website</label>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-custom">
                    <i class="fas fa-save me-2"></i> Update Member
                </button>
                <a href="{{ route('admin.committee.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-times me-2"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
