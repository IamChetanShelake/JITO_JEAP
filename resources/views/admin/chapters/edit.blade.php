@extends('admin.layouts.master')

@section('title', 'Edit Chapter - JitoJeap Admin')

@section('content')
<div class="page-header mb-4">
    <h1 class="page-title" style="color: #393185;">Edit Chapter</h1>
    <p class="page-subtitle">Update chapter information</p>
</div>

<div class="section-card">
    <div class="card-body p-4">
        <form action="{{ route('admin.chapters.update', $chapter) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="zone_id" class="form-label">Select Zone <span class="text-danger">*</span></label>
                    <select class="form-select @error('zone_id') is-invalid @enderror" id="zone_id" name="zone_id" required>
                        <option value="">Select Zone</option>
                        @foreach($zones as $zone)
                            <option value="{{ $zone->id }}" {{ old('zone_id', $chapter->zone_id) == $zone->id ? 'selected' : '' }}>
                                {{ $zone->zone_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('zone_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="chapter_head" class="form-label">Chapter Head <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('chapter_head') is-invalid @enderror" 
                           id="chapter_head" name="chapter_head" value="{{ old('chapter_head', $chapter->chapter_head) }}" required>
                    @error('chapter_head')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="chapter_name" class="form-label">Chapter Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('chapter_name') is-invalid @enderror" 
                           id="chapter_name" name="chapter_name" value="{{ old('chapter_name', $chapter->chapter_name) }}" required>
                    @error('chapter_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                           id="city" name="city" value="{{ old('city', $chapter->city) }}" required>
                    @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="pincode" class="form-label">Pincode <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('pincode') is-invalid @enderror" 
                           id="pincode" name="pincode" value="{{ old('pincode', $chapter->pincode) }}" required>
                    @error('pincode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('state') is-invalid @enderror" 
                           id="state" name="state" value="{{ old('state', $chapter->state) }}" required>
                    @error('state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email', $chapter->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="contact" class="form-label">Contact <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('contact') is-invalid @enderror" 
                           id="contact" name="contact" value="{{ old('contact', $chapter->contact) }}" required>
                    @error('contact')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label d-block">Status</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1" 
                               {{ old('status', $chapter->status) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Active</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label d-block">Show/Hide</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="show_hide" name="show_hide" value="1" 
                               {{ old('show_hide', $chapter->show_hide) ? 'checked' : '' }}>
                        <label class="form-check-label" for="show_hide">Show on website</label>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-custom">
                    <i class="fas fa-save me-2"></i> Update Chapter
                </button>
                <a href="{{ route('admin.chapters.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-times me-2"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
