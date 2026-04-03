@extends('admin.layouts.master')

@section('title', 'View Committee Member - JitoJeap Admin')

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

    .detail-header {
        background: var(--primary-gradient);
        color: white;
        padding: 1.5rem 1rem;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
        margin-bottom: 0;
    }

    .detail-header h1 {
        color: white;
        margin-bottom: 0.5rem;
        font-size: clamp(1.25rem, 5vw, 1.75rem);
        font-weight: 600;
    }

    .detail-header .subtitle {
        color: rgba(255,255,255,0.9);
        font-size: clamp(0.85rem, 3vw, 0.95rem);
    }

    .detail-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid #e0e0e0;
        width: 100%;
    }

    .detail-card-body {
        padding: 1.5rem 1rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .info-item {
        padding: 1rem;
        border-radius: 12px;
        background: #f8f9fa;
        border-left: 4px solid var(--primary-color);
    }

    .info-item i {
        color: var(--primary-color);
        margin-right: 0.5rem;
        font-size: 0.9rem;
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
        font-size: clamp(1rem, 3vw, 1.1rem);
        font-weight: 600;
        color: #333;
        margin-bottom: 0;
        word-break: break-word;
    }

    .status-indicator {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: clamp(0.75rem, 2vw, 0.85rem);
    }

    .status-indicator.active {
        background: #e8f5e9;
        color: var(--success-color);
    }

    .status-indicator.inactive {
        background: #ffebee;
        color: var(--danger-color);
    }

    .status-indicator i {
        font-size: 0.9rem;
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

        .detail-header {
            padding: 2rem;
        }

        .detail-card-body {
            padding: 2rem;
        }

        .info-grid {
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

        .detail-header h1 {
            font-size: 1.75rem;
        }

        .detail-header .subtitle {
            font-size: 0.95rem;
        }

        .info-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }

        .info-value {
            font-size: 1.1rem;
        }

        .status-indicator {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
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
        .detail-card {
            box-shadow: none;
            border: none;
        }

        .action-buttons {
            display: none;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="detail-card">
        <div class="detail-header">
            <h1><i class="fas fa-user-tie me-2"></i> Working Committee Member</h1>
            <p class="subtitle">Detailed member information and status</p>
        </div>

        <div class="detail-card-body">
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label"><i class="fas fa-user"></i> Name</div>
                <div class="info-value">{{ $committee->name }}</div>
            </div>

            <div class="info-item">
                <div class="info-label"><i class="fas fa-building"></i> Department</div>
                <div class="info-value">{{ $committee->department }}</div>
            </div>

            <div class="info-item">
                <div class="info-label"><i class="fas fa-id-badge"></i> Designation</div>
                <div class="info-value">{{ $committee->designation }}</div>
            </div>

            <div class="info-item">
                <div class="info-label"><i class="fas fa-envelope"></i> Email</div>
                <div class="info-value">{{ $committee->email }}</div>
            </div>

            <div class="info-item">
                <div class="info-label"><i class="fas fa-phone"></i> Contact</div>
                <div class="info-value">{{ $committee->contact }}</div>
            </div>

            <div class="info-item">
                <div class="info-label"><i class="fas fa-calendar-alt"></i> Created</div>
                <div class="info-value">{{ $committee->created_at->format('d M Y') }}</div>
            </div>

            <div class="info-item">
                <div class="info-label"><i class="fas fa-clock"></i> Time</div>
                <div class="info-value">{{ $committee->created_at->format('h:i A') }}</div>
            </div>

            <div class="info-item">
                <div class="info-label"><i class="fas fa-power-off"></i> Status</div>
                <div class="status-indicator {{ $committee->status ? 'active' : 'inactive' }}">
                    <i class="fas fa-circle {{ $committee->status ? 'text-success' : 'text-danger' }}"></i>
                    {{ $committee->status ? 'Active' : 'Inactive' }}
                </div>
            </div>

            <div class="info-item">
                <div class="info-label"><i class="fas fa-eye"></i> Visibility</div>
                <div class="status-indicator {{ $committee->show_hide ? 'active' : 'inactive' }}">
                    <i class="fas fa-circle {{ $committee->show_hide ? 'text-success' : 'text-warning' }}"></i>
                    {{ $committee->show_hide ? 'Visible' : 'Hidden' }}
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="{{ route('admin.committee.edit', $committee) }}" class="btn-custom">
                <i class="fas fa-edit me-2"></i> Edit Member
            </a>
            <a href="{{ route('admin.committee.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to List
            </a>
        </div>
    </div>
</div>
@endsection
