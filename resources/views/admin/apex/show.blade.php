@extends('admin.layouts.master')

@section('title', 'View Apex Member - JitoJeap Admin')

@section('styles')
<style>
    /* Mobile-first base styles */
    .container {
        width: 100%;
        padding: 0 1rem;
    }

    .detail-header {
        background: linear-gradient(135deg, #393185, #5a4d9a);
        color: white;
        padding: 1.5rem;
        border-radius: 15px 15px 0 0;
        margin-bottom: 0;
    }

    .detail-header h1 {
        color: white;
        margin-bottom: 0.5rem;
        font-size: clamp(1.5rem, 4vw, 1.75rem);
    }

    .detail-header .subtitle {
        color: rgba(255,255,255,0.9);
        font-size: clamp(0.8rem, 2.5vw, 0.95rem);
    }

    .detail-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid #e0e0e0;
    }

    .detail-card-body {
        padding: 1.5rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 1rem;
    }

    .info-item {
        padding: 1rem;
        border-radius: 12px;
        background: #f8f9fa;
        border-left: 4px solid #393185;
    }

    .info-item i {
        color: #393185;
        margin-right: 0.5rem;
        font-size: clamp(0.9rem, 2.5vw, 1rem);
    }

    .info-label {
        font-size: clamp(0.75rem, 2vw, 0.85rem);
        color: #666;
        margin-bottom: 0.25rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: clamp(0.9rem, 3vw, 1.1rem);
        font-weight: 600;
        color: #333;
        margin-bottom: 0;
    }

    .status-indicator {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 500;
    }

    .status-indicator.active {
        background: #e8f5e9;
        color: #009846;
    }

    .status-indicator.inactive {
        background: #ffebee;
        color: #E31E24;
    }

    .status-indicator i {
        font-size: clamp(0.8rem, 2.5vw, 1rem);
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

        .detail-header {
            padding: 2rem;
        }

        .detail-header h1 {
            font-size: 1.75rem;
        }

        .detail-header .subtitle {
            font-size: 0.95rem;
        }

        .detail-card-body {
            padding: 2rem;
        }

        .info-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .info-item {
            padding: 1rem;
        }

        .info-label {
            font-size: 0.85rem;
        }

        .info-value {
            font-size: 1.1rem;
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
        .info-grid {
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
    <div class="detail-card">
        <div class="detail-header">
            <h1><i class="fas fa-user-tie me-2"></i> Apex Leadership Member</h1>
            <p class="subtitle">Detailed member information and status</p>
        </div>

        <div class="detail-card-body">
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-user"></i> Name</div>
                    <div class="info-value">{{ $apex->name }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label"><i class="fas fa-briefcase"></i> Position</div>
                    <div class="info-value">{{ $apex->position }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label"><i class="fas fa-id-badge"></i> Designation</div>
                    <div class="info-value">{{ $apex->designation }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label"><i class="fas fa-envelope"></i> Email</div>
                    <div class="info-value">{{ $apex->email }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label"><i class="fas fa-phone"></i> Contact</div>
                    <div class="info-value">{{ $apex->contact }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label"><i class="fas fa-calendar-alt"></i> Created</div>
                    <div class="info-value">{{ $apex->created_at->format('d M Y') }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label"><i class="fas fa-clock"></i> Time</div>
                    <div class="info-value">{{ $apex->created_at->format('h:i A') }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label"><i class="fas fa-eye"></i> Status</div>
                    <div class="status-indicator {{ $apex->status ? 'active' : 'inactive' }}">
                        <i class="fas fa-circle {{ $apex->status ? 'text-success' : 'text-danger' }}"></i>
                        {{ $apex->status ? 'Active' : 'Inactive' }}
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label"><i class="fas fa-globe"></i> Visibility</div>
                    <div class="status-indicator {{ $apex->show_hide ? 'active' : 'inactive' }}">
                        <i class="fas fa-circle {{ $apex->show_hide ? 'text-success' : 'text-warning' }}"></i>
                        {{ $apex->show_hide ? 'Visible' : 'Hidden' }}
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <a href="{{ route('admin.apex.edit', $apex) }}" class="btn-custom">
                    <i class="fas fa-edit me-2"></i> Edit Member
                </a>
                <a href="{{ route('admin.apex.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back to List
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
