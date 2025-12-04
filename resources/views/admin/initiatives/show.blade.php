@extends('admin.layouts.master')

@section('title', 'View Initiative - JitoJeap Admin')

@section('styles')
<style>
    .detail-header {
        background: linear-gradient(135deg, #009846, #4caf50);
        color: white;
        padding: 2rem;
        border-radius: 15px 15px 0 0;
        margin-bottom: 0;
    }

    .detail-header h1 {
        color: white;
        margin-bottom: 0.5rem;
        font-size: 1.75rem;
    }

    .detail-header .subtitle {
        color: rgba(255,255,255,0.9);
        font-size: 0.95rem;
    }

    .detail-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid #e0e0e0;
    }

    .detail-card-body {
        padding: 2rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        padding: 1rem;
        border-radius: 12px;
        background: #f8f9fa;
        border-left: 4px solid #009846;
    }

    .info-item i {
        color: #009846;
        margin-right: 0.5rem;
    }

    .info-label {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 0.25rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 1.1rem;
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
        font-size: 1rem;
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
<div class="detail-card">
    <div class="detail-header">
        <h1><i class="fas fa-lightbulb me-2"></i> Initiative Details</h1>
        <p class="subtitle">Comprehensive initiative information and status</p>
    </div>

    <div class="detail-card-body">
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label"><i class="fas fa-user-tie"></i> Initiative Leader</div>
                <div class="info-value">{{ $initiative->initiative_leader }}</div>
            </div>

            <div class="info-item">
                <div class="info-label"><i class="fas fa-project-diagram"></i> Initiative Name</div>
                <div class="info-value">{{ $initiative->initiative_name }}</div>
            </div>

            <div class="info-item">
                <div class="info-label"><i class="fas fa-id-badge"></i> Designation</div>
                <div class="info-value">{{ $initiative->designation }}</div>
            </div>

            <div class="info-item">
                <div class="info-label"><i class="fas fa-envelope"></i> Email</div>
                <div class="info-value">{{ $initiative->email }}</div>
            </div>

            <div class="info-item">
                <div class="info-label"><i class="fas fa-phone"></i> Contact</div>
                <div class="info-value">{{ $initiative->contact }}</div>
            </div>

            <div class="info-item">
                <div class="info-label"><i class="fas fa-calendar-alt"></i> Created</div>
                <div class="info-value">{{ $initiative->created_at->format('d M Y') }}</div>
            </div>

            <div class="info-item">
                <div class="info-label"><i class="fas fa-clock"></i> Time</div>
                <div class="info-value">{{ $initiative->created_at->format('h:i A') }}</div>
            </div>

            <div class="info-item">
                <div class="info-label"><i class="fas fa-power-off"></i> Status</div>
                <div class="status-indicator {{ $initiative->status ? 'active' : 'inactive' }}">
                    <i class="fas fa-circle {{ $initiative->status ? 'text-success' : 'text-danger' }}"></i>
                    {{ $initiative->status ? 'Active' : 'Inactive' }}
                </div>
            </div>

            <div class="info-item">
                <div class="info-label"><i class="fas fa-eye"></i> Visibility</div>
                <div class="status-indicator {{ $initiative->show_hide ? 'active' : 'inactive' }}">
                    <i class="fas fa-circle {{ $initiative->show_hide ? 'text-success' : 'text-warning' }}"></i>
                    {{ $initiative->show_hide ? 'Visible' : 'Hidden' }}
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="{{ route('admin.initiatives.edit', $initiative) }}" class="btn-custom">
                <i class="fas fa-edit me-2"></i> Edit Initiative
            </a>
            <a href="{{ route('admin.initiatives.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to List
            </a>
        </div>
    </div>
</div>
@endsection
