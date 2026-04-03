@extends('admin.layouts.master')

@section('title', 'Add Zone - JitoJeap Admin')

@section('styles')
<style>
    .create-header {
        background: linear-gradient(135deg, #E31E24, #ff5252);
        color: white;
        padding: 2rem;
        border-radius: 15px 15px 0 0;
        margin-bottom: 0;
    }

    .create-header h1 {
        color: white;
        margin-bottom: 0.5rem;
        font-size: 1.75rem;
    }

    .create-header .subtitle {
        color: rgba(255,255,255,0.9);
        font-size: 0.95rem;
    }

    .create-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid #e0e0e0;
    }

    .create-card-body {
        padding: 2rem;
    }

    .form-section {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        border-left: 4px solid #E31E24;
    }

    .form-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #E31E24;
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
        color: #E31E24;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #E31E24;
        box-shadow: 0 0 0 3px rgba(227, 30, 36, 0.1);
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
        background-color: #E31E24;
        border-color: #E31E24;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e0e0e0;
    }

    .btn-custom {
        background: #E31E24;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        background: #c61a1f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(227, 30, 36, 0.3);
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
<div class="create-card">
    <div class="create-header">
        <h1><i class="fas fa-globe me-2"></i> Add Zone</h1>
        <p class="subtitle">Create a new regional zone</p>
    </div>

    <div class="create-card-body">
        <form action="{{ route('admin.zones.store') }}" method="POST">
            @csrf

            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-map-marker-alt"></i> Zone Information
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="zone_head" class="form-label">
                            <i class="fas fa-user-tie"></i> Zone Head <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('zone_head') is-invalid @enderror"
                               id="zone_head" name="zone_head" value="{{ old('zone_head') }}" required>
                        @error('zone_head')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="zone_name" class="form-label">
                            <i class="fas fa-map"></i> Zone Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('zone_name') is-invalid @enderror"
                               id="zone_name" name="zone_name" value="{{ old('zone_name') }}" required>
                        @error('zone_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="code" class="form-label">
                            <i class="fas fa-code"></i> Code <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror"
                               id="code" name="code" value="{{ old('code') }}" required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="state" class="form-label">
                            <i class="fas fa-flag"></i> State <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('state') is-invalid @enderror"
                               id="state" name="state" value="{{ old('state') }}" required>
                        @error('state')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> Email <span class="text-danger">*</span>
                        </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="contact" class="form-label">
                            <i class="fas fa-phone"></i> Contact <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('contact') is-invalid @enderror"
                               id="contact" name="contact" value="{{ old('contact') }}" required>
                        @error('contact')
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
                                   {{ old('status', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Active</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label d-block">
                            <i class="fas fa-eye"></i> Visibility
                        </label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="show_hide" name="show_hide" value="1"
                                   {{ old('show_hide', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_hide">Show on website</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn-custom">
                    <i class="fas fa-save me-2"></i> Save Zone
                </button>
                <a href="{{ route('admin.zones.index') }}" class="btn-secondary">
                    <i class="fas fa-times me-2"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
