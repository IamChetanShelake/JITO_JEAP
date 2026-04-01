@extends('admin.layouts.master')

@section('title', 'Edit Apex Member - JitoJeap Admin')

@section('styles')
<style>
    /* Mobile-first base styles */
    .container {
        width: 100%;
        padding: 0 1rem;
    }

    .edit-header {
        background: linear-gradient(135deg, #393185, #5a4d9a);
        color: white;
        padding: 1.5rem;
        border-radius: 15px 15px 0 0;
        margin-bottom: 0;
    }

    .edit-header h1 {
        color: white;
        margin-bottom: 0.5rem;
        font-size: clamp(1.5rem, 4vw, 1.75rem);
    }

    .edit-header .subtitle {
        color: rgba(255,255,255,0.9);
        font-size: clamp(0.8rem, 2.5vw, 0.95rem);
    }

    .edit-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid #e0e0e0;
    }

    .edit-card-body {
        padding: 1.5rem;
    }

    .form-section {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1rem;
        border-left: 4px solid #393185;
    }

    .form-section-title {
        font-size: clamp(1rem, 3vw, 1.1rem);
        font-weight: 600;
        color: #393185;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 1rem;
    }

    .form-group {
        position: relative;
    }

    .form-label {
        font-size: clamp(0.75rem, 2vw, 0.85rem);
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
        font-size: clamp(0.9rem, 2.5vw, 1rem);
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        width: 100%;
    }

    .form-control:focus {
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
        flex-wrap: wrap;
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
        min-height: 44px;
        min-width: 44px;
        flex: 1;
        min-width: 150px;
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
        min-height: 44px;
        min-width: 44px;
        flex: 1;
        min-width: 150px;
    }

    /* Touch-friendly interactive elements */
    button, a, .tap-target {
        min-width: 44px;
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* Fluid typography */
    html {
        font-size: clamp(1rem, -0.875rem + 8.333vw, 1.125rem);
    }

    /* Responsive heading scale */
    h1 {
        font-size: clamp(1.75rem, 4vw, 2.5rem);
    }

    h2 {
        font-size: clamp(1.5rem, 3.5vw, 2rem);
    }

    h3 {
        font-size: clamp(1.25rem, 3vw, 1.75rem);
    }

    /* Responsive spacing */
    .sp-1 {
        margin: 8px;
    }

    .sp-2 {
        margin: 16px;
    }

    /* Responsive images with lazy loading */
    img {
        max-width: 100%;
        height: auto;
    }

    /* Prefers-reduced-motion support */
    @media (prefers-reduced-motion: reduce) {
        .animatable {
            animation: none !important;
            transition: none !important;
        }
    }

    /* Responsive form layouts */
    input, select, textarea {
        width: 100%;
        padding: 0.75rem;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .form-row > * {
        flex: 1;
        min-width: 0;
    }

    /* Accessible button styling */
    button {
        min-height: 44px;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        background: #007BFF;
        color: #fff;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    button:focus {
        outline: 2px solid #ffb400;
        box-shadow: 0 0 0 3px rgba(255, 180, 0, 0.3);
    }

    /* Content prioritization */
    .secondary {
        display: none;
    }

    /* Tablet-specific styles (600px - 1023px) */
    @media (min-width: 600px) and (max-width: 1023px) {
        .container {
            max-width: 720px;
            margin: auto;
        }

        .edit-header {
            padding: 2rem;
        }

        .edit-header h1 {
            font-size: 1.75rem;
        }

        .edit-header .subtitle {
            font-size: 0.95rem;
        }

        .edit-card-body {
            padding: 2rem;
        }

        .form-section {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-section-title {
            font-size: 1.1rem;
        }

        .form-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .form-label {
            font-size: 0.85rem;
        }

        .action-buttons {
            gap: 1rem;
        }

        .secondary {
            display: block;
        }

        /* Tablet landscape orientation */
        @media (orientation: landscape) and (max-width: 1023px) {
            .gallery {
                flex-direction: row;
            }
        }

        /* Form layouts for tablets */
        .form-row {
            display: flex;
            gap: 1rem;
        }

        .form-row > * {
            flex: 1;
        }
    }

    /* Tablet landscape specific (1024px - 1279px) */
    @media (min-width: 1024px) and (max-width: 1279px) {
        .form-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    /* Conditional stylesheet loading */
    @media (min-width: 600px) and (max-width: 1023px) {
        /* Tablet-specific CSS would be loaded here */
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="edit-card">
        <div class="edit-header">
            <h1><i class="fas fa-user-edit me-2"></i> Edit Apex Leadership Member</h1>
            <p class="subtitle">Update member information</p>
        </div>

        <div class="edit-card-body">
            <form action="{{ route('admin.apex.update', $apex) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-user-tie"></i> Member Information
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name" class="form-label">
                                <i class="fas fa-user"></i> Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $apex->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="position" class="form-label">
                                <i class="fas fa-briefcase"></i> Position <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('position') is-invalid @enderror"
                                   id="position" name="position" value="{{ old('position', $apex->position) }}" required>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="designation" class="form-label">
                                <i class="fas fa-id-badge"></i> Designation <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('designation') is-invalid @enderror"
                                   id="designation" name="designation" value="{{ old('designation', $apex->designation) }}" required>
                            @error('designation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope"></i> Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $apex->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="contact" class="form-label">
                                <i class="fas fa-phone"></i> Contact <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('contact') is-invalid @enderror"
                                   id="contact" name="contact" value="{{ old('contact', $apex->contact) }}" required>
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
                                       {{ old('status', $apex->status) ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">Active</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label d-block">
                                <i class="fas fa-eye"></i> Visibility
                            </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_hide" name="show_hide" value="1"
                                       {{ old('show_hide', $apex->show_hide) ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_hide">Show on website</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <button type="submit" class="btn-custom">
                        <i class="fas fa-save me-2"></i> Update Member
                    </button>
                    <a href="{{ route('admin.apex.index') }}" class="btn-secondary">
                        <i class="fas fa-times me-2"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
