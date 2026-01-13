@extends('admin.layouts.master')

@section('title', 'Edit Chapter - JitoJeap Admin')

@section('styles')
<style>
    .edit-header {
        background: linear-gradient(135deg, #393185, #5a4d9a);
        color: white;
        padding: 2rem;
        border-radius: 15px 15px 0 0;
        margin-bottom: 0;
    }

    .edit-header h1 {
        color: white;
        margin-bottom: 0.5rem;
        font-size: 1.75rem;
    }

    .edit-header .subtitle {
        color: rgba(255,255,255,0.9);
        font-size: 0.95rem;
    }

    .edit-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid #e0e0e0;
    }

    .edit-card-body {
        padding: 2rem;
    }

    .form-section {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        border-left: 4px solid #393185;
    }

    .form-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #393185;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .form-group {
        position: relative;
    }

    .form-label {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 0.5rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label i {
        color: #393185;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #393185;
        box-shadow: 0 0 0 3px rgba(57, 49, 133, 0.1);
    }

    .form-switch {
        padding-left: 2.5rem;
    }

    .form-switch .form-check-input {
        width: 2rem;
        height: 1rem;
        border-radius: 1rem;
    }

    .form-switch .form-check-input:checked {
        background-color: #393185;
        border-color: #393185;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e0e0e0;
    }

    .btn-custom {
        background: #393185;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        background: #2a226a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(57, 49, 133, 0.3);
    }

    .btn-secondary {
        background: #f0f0f0;
        color: #333;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        border: 1px solid #e0e0e0;
    }
</style>
@endsection

@section('content')
<div class="edit-card">
    <div class="edit-header">
        <h1><i class="fas fa-edit me-2"></i> Edit Chapter</h1>
        <p class="subtitle">Update chapter information</p>
    </div>

    <div class="edit-card-body">
        <form action="{{ route('admin.chapters.update', $chapter) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-map-marker-alt"></i> Chapter Information
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="zone_id" class="form-label">
                            <i class="fas fa-globe"></i> Select Zone <span class="text-danger">*</span>
                        </label>
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

                    <div class="form-group">
                        <label for="chapter_head" class="form-label">
                            <i class="fas fa-user-tie"></i> Chapter Head <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('chapter_head') is-invalid @enderror"
                               id="chapter_head" name="chapter_head" value="{{ old('chapter_head', $chapter->chapter_head) }}" required>
                        @error('chapter_head')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="chapter_name" class="form-label">
                            <i class="fas fa-book"></i> Chapter Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('chapter_name') is-invalid @enderror"
                               id="chapter_name" name="chapter_name" value="{{ old('chapter_name', $chapter->chapter_name) }}" required>
                        @error('chapter_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="city" class="form-label">
                            <i class="fas fa-city"></i> City <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror"
                               id="city" name="city" value="{{ old('city', $chapter->city) }}" required>
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="pincodes" class="form-label">
                            <i class="fas fa-map-pin"></i> Pincodes <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('pincodes') is-invalid @enderror" id="pincodes" name="pincodes[]" multiple required>
                            @foreach($pincodes as $pincode)
                                <option value="{{ $pincode->pincode }}"
                                        {{ in_array($pincode->pincode, old('pincodes', explode(',', $chapter->pincode))) ? 'selected' : '' }}>
                                    {{ $pincode->pincode }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Hold Ctrl (or Cmd on Mac) to select multiple pincodes</small>
                        @error('pincodes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="state" class="form-label">
                            <i class="fas fa-flag"></i> State <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('state') is-invalid @enderror"
                               id="state" name="state" value="{{ old('state', $chapter->state) }}" required>
                        @error('state')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> Email <span class="text-danger">*</span>
                        </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email', $chapter->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="contact" class="form-label">
                            <i class="fas fa-phone"></i> Contact <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('contact') is-invalid @enderror"
                               id="contact" name="contact" value="{{ old('contact', $chapter->contact) }}" required>
                        @error('contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i> Password (leave blank to keep current)
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-cog"></i> Settings
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label d-block">
                            <i class="fas fa-power-off"></i> Status
                        </label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status" name="status" value="1"
                                   {{ old('status', $chapter->status) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Active</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label d-block">
                            <i class="fas fa-eye"></i> Visibility
                        </label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="show_hide" name="show_hide" value="1"
                                   {{ old('show_hide', $chapter->show_hide) ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_hide">Show on website</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn-custom">
                    <i class="fas fa-save me-2"></i> Update Chapter
                </button>
                <a href="{{ route('admin.chapters.index') }}" class="btn-secondary">
                    <i class="fas fa-times me-2"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
