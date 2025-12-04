@extends('admin.layouts.master')

@section('title', 'Edit Initiative - JitoJeap Admin')

@section('styles')
<style>
    .edit-header {
        background: linear-gradient(135deg, #009846, #4caf50);
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
        border-left: 4px solid #009846;
    }

    .form-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #009846;
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
        color: #009846;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #009846;
        box-shadow: 0 0 0 3px rgba(0, 152, 70, 0.1);
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
        background-color: #009846;
        border-color: #009846;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e0e0e0;
    }

    .btn-custom {
        background: #009846;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        background: #007938;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 152, 70, 0.3);
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
        <h1><i class="fas fa-edit me-2"></i> Edit Initiative</h1>
        <p class="subtitle">Update initiative information</p>
    </div>

    <div class="edit-card-body">
        <form action="{{ route('admin.initiatives.update', $initiative) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-project-diagram"></i> Initiative Information
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="initiative_leader" class="form-label">
                            <i class="fas fa-user-tie"></i> Initiative Leader <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('initiative_leader') is-invalid @enderror"
                               id="initiative_leader" name="initiative_leader" value="{{ old('initiative_leader', $initiative->initiative_leader) }}" required>
                        @error('initiative_leader')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="initiative_name" class="form-label">
                            <i class="fas fa-lightbulb"></i> Initiative Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('initiative_name') is-invalid @enderror"
                               id="initiative_name" name="initiative_name" value="{{ old('initiative_name', $initiative->initiative_name) }}" required>
                        @error('initiative_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="designation" class="form-label">
                            <i class="fas fa-id-badge"></i> Designation <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('designation') is-invalid @enderror"
                               id="designation" name="designation" value="{{ old('designation', $initiative->designation) }}" required>
                        @error('designation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> Email <span class="text-danger">*</span>
                        </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email', $initiative->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="contact" class="form-label">
                            <i class="fas fa-phone"></i> Contact <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('contact') is-invalid @enderror"
                               id="contact" name="contact" value="{{ old('contact', $initiative->contact) }}" required>
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
                                   {{ old('status', $initiative->status) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Active</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label d-block">
                            <i class="fas fa-eye"></i> Visibility
                        </label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="show_hide" name="show_hide" value="1"
                                   {{ old('show_hide', $initiative->show_hide) ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_hide">Show on website</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn-custom">
                    <i class="fas fa-save me-2"></i> Update Initiative
                </button>
                <a href="{{ route('admin.initiatives.index') }}" class="btn-secondary">
                    <i class="fas fa-times me-2"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
