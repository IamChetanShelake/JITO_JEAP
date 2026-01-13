@extends('admin.layouts.master')

@section('title', 'Add Pincode - JitoJeap Admin')

@section('styles')
<style>
    .create-header {
        background: linear-gradient(135deg, #393185, #5a4d9a);
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
<div class="create-card">
    <div class="create-header">
        <h1><i class="fas fa-map-pin me-2"></i> Add Pincode</h1>
        <p class="subtitle">Create a new pincode entry</p>
    </div>

    <div class="create-card-body">
        <form action="{{ route('admin.pincodes.store') }}" method="POST">
            @csrf

            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-info-circle"></i> Pincode Information
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="pincode" class="form-label">
                            <i class="fas fa-hashtag"></i> Pincode <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('pincode') is-invalid @enderror"
                               id="pincode" name="pincode" value="{{ old('pincode') }}" required
                               maxlength="10" placeholder="Enter pincode">
                        @error('pincode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn-custom">
                    <i class="fas fa-save me-2"></i> Save Pincode
                </button>
                <a href="{{ route('admin.pincodes.index') }}" class="btn-secondary">
                    <i class="fas fa-times me-2"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
