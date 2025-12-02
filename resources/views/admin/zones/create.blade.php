@extends('admin.layouts.master')

@section('title', 'Create Zone - JitoJeap Admin')

@section('content')
<div class="section-card">
    <div class="card-header">
        <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Create New Zone</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.zones.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="zone_name" class="form-label">Zone Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('zone_name') is-invalid @enderror" 
                           id="zone_name" name="zone_name" value="{{ old('zone_name') }}" required>
                    @error('zone_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="code" class="form-label">Code <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                           id="code" name="code" value="{{ old('code') }}" required>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('state') is-invalid @enderror" 
                           id="state" name="state" value="{{ old('state') }}" required>
                    @error('state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1" 
                               {{ old('status', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">
                            Active Status
                        </label>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-custom">
                    <i class="fas fa-save me-2"></i> Create Zone
                </button>
                <a href="{{ route('admin.zones.index') }}" class="btn btn-danger-custom">
                    <i class="fas fa-times me-2"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
