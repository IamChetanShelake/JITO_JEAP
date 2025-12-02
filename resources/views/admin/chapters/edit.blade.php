@extends('admin.layouts.master')

@section('title', 'Edit Chapter - JitoJeap Admin')

@section('content')
<div class="section-card">
    <div class="card-header">
        <h4 class="mb-0"><i class="fas fa-edit me-2"></i> Edit Chapter</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.chapters.update', $chapter) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="zone_id" class="form-label">Select Zone <span class="text-danger">*</span></label>
                    <select class="form-select @error('zone_id') is-invalid @enderror" id="zone_id" name="zone_id" required>
                        <option value="">Select Zone</option>
                        @foreach($zones as $zone)
                            <option value="{{ $zone->id }}" {{ old('zone_id', $chapter->zone_id) == $zone->id ? 'selected' : '' }}>
                                {{ $zone->zone_name }} ({{ $zone->code }})
                            </option>
                        @endforeach
                    </select>
                    @error('zone_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="chapter_name" class="form-label">Chapter Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('chapter_name') is-invalid @enderror" 
                           id="chapter_name" name="chapter_name" value="{{ old('chapter_name', $chapter->chapter_name) }}" required>
                    @error('chapter_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="code" class="form-label">Code <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                           id="code" name="code" value="{{ old('code', $chapter->code) }}" required>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                           id="city" name="city" value="{{ old('city', $chapter->city) }}" required>
                    @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="pincode" class="form-label">Pincode <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('pincode') is-invalid @enderror" 
                           id="pincode" name="pincode" value="{{ old('pincode', $chapter->pincode) }}" required>
                    @error('pincode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('state') is-invalid @enderror" 
                           id="state" name="state" value="{{ old('state', $chapter->state) }}" required>
                    @error('state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="chairman" class="form-label">Chairman <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('chairman') is-invalid @enderror" 
                           id="chairman" name="chairman" value="{{ old('chairman', $chapter->chairman) }}" required>
                    @error('chairman')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="contact_no" class="form-label">Contact No <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('contact_no') is-invalid @enderror" 
                           id="contact_no" name="contact_no" value="{{ old('contact_no', $chapter->contact_no) }}" required>
                    @error('contact_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1" 
                               {{ old('status', $chapter->status) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">
                            Active Status
                        </label>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-custom">
                    <i class="fas fa-save me-2"></i> Update Chapter
                </button>
                <a href="{{ route('admin.chapters.index') }}" class="btn btn-danger-custom">
                    <i class="fas fa-times me-2"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
