@extends('admin.layouts.master')

@section('title', 'Add Committee Member - JitoJeap Admin')

@section('styles')
<style>
    /* Mobile-first responsive design */
    :root {
        --primary-color: #FBBA00;
        --primary-gradient: linear-gradient(135deg, #FBBA00, #ffd740);
        --success-color: #009846;
        --danger-color: #E31E24;
        --warning-color: #ff9800;
        --border-radius: 15px;
        --transition-speed: 0.3s;
    }

    /* Base mobile styles */
    .container-fluid {
        width: 100%;
        padding: 0 1rem;
        margin: 0 auto;
    }

    .create-header {
        background: var(--primary-gradient);
        color: white;
        padding: 1.5rem 1rem;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
        margin-bottom: 0;
    }

    .create-header h1 {
        color: white;
        margin-bottom: 0.5rem;
        font-size: clamp(1.25rem, 5vw, 1.75rem);
        font-weight: 600;
    }

    .create-header .subtitle {
        color: rgba(255,255,255,0.9);
        font-size: clamp(0.85rem, 3vw, 0.95rem);
    }

    .create-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid #e0e0e0;
        width: 100%;
    }

    .create-card-body {
        padding: 1.5rem 1rem;
    }

    .form-section {
        background: #f8f9fa;
        padding: 1.25rem 1rem;
        border-radius: 12px;
        margin-bottom: 1.25rem;
        border-left: 4px solid var(--primary-color);
    }

    .form-section-title {
        font-size: clamp(1rem, 3vw, 1.1rem);
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr;
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
        color: var(--primary-color);
        font-size: 0.9rem;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 0.75rem 1rem;
        transition: all var(--transition-speed) ease;
        font-size: clamp(0.85rem, 2vw, 1rem);
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(251, 186, 0, 0.1);
    }

    .form-switch {
        padding-left: 2.25rem;
    }

    .form-switch .form-check-input {
        width: 1.8rem;
        height: 0.9rem;
        border-radius: 1rem;
    }

    .form-switch .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid #e0e0e0;
    }

    .btn-custom {
        background: var(--primary-color);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all var(--transition-speed) ease;
        width: 100%;
        text-align: center;
    }

    .btn-custom:hover {
        background: #e6a600;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(251, 186, 0, 0.3);
    }

    .btn-secondary {
        background: #f0f0f0;
        color: #333;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        border: 1px solid #e0e0e0;
        width: 100%;
        text-align: center;
    }

    /* Tablet styles */
    @media (min-width: 768px) {
        .container-fluid {
            padding: 0 2rem;
        }

        .create-header {
            padding: 2rem;
        }

        .create-card-body {
            padding: 2rem;
        }

        .form-section {
            padding: 1.5rem;
        }

        .form-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .action-buttons {
            flex-direction: row;
            gap: 1rem;
        }

        .btn-custom, .btn-secondary {
            width: auto;
        }
    }

    /* Desktop styles */
    @media (min-width: 992px) {
        .container-fluid {
            max-width: 1200px;
            padding: 0;
        }

        .create-header h1 {
            font-size: 1.75rem;
        }

        .create-header .subtitle {
            font-size: 0.95rem;
        }

        .form-section-title {
            font-size: 1.1rem;
        }

        .form-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }

        .form-control {
            font-size: 1rem;
        }
    }

    /* Reduced motion preference */
    @media (prefers-reduced-motion: reduce) {
        * {
            transition: none !important;
            animation: none !important;
        }
    }

    /* Print styles */
    @media print {
        .action-buttons {
            display: none;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="create-card">
        <div class="create-header">
            <h1><i class="fas fa-user-plus me-2"></i> Add Working Committee Member</h1>
            <p class="subtitle">Create a new member for the working committee</p>
        </div>

        <div class="create-card-body">
        <form action="{{ route('admin.committee.store') }}" method="POST">
            @csrf

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
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="department" class="form-label">
                            <i class="fas fa-building"></i> Department <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('department') is-invalid @enderror"
                               id="department" name="department" value="{{ old('department') }}" required>
                        @error('department')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="designation" class="form-label">
                            <i class="fas fa-id-badge"></i> Designation <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('designation') is-invalid @enderror"
                               id="designation" name="designation" value="{{ old('designation') }}" required>
                        @error('designation')
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

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i> Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" required>
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
                    <i class="fas fa-save me-2"></i> Save Member
                </button>
                <a href="{{ route('admin.committee.index') }}" class="btn-secondary">
                    <i class="fas fa-times me-2"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
