@extends('admin.layouts.master')

@section('title', 'View Bank Details - JitoJeap Admin')

@section('styles')
<style>
    .show-header {
        background: linear-gradient(135deg, #393185, #5a4d9a);
        color: white;
        padding: 2rem;
        border-radius: 15px 15px 0 0;
        margin-bottom: 0;
    }

    .show-header h1 {
        color: white;
        margin-bottom: 0.5rem;
        font-size: 1.75rem;
    }

    .show-header .subtitle {
        color: rgba(255,255,255,0.9);
        font-size: 0.95rem;
    }

    .show-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid #e0e0e0;
    }

    .show-card-body {
        padding: 2rem;
    }

    .detail-section {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        border-left: 4px solid #393185;
    }

    .detail-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #393185;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .detail-item {
        background: white;
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
    }

    .detail-label {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 0.25rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 1rem;
        color: #2c3e50;
        font-weight: 500;
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
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-custom:hover {
        background: #2a226a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(57, 49, 133, 0.3);
        color: white;
    }

    .btn-secondary {
        background: #f0f0f0;
        color: #333;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        border: 1px solid #e0e0e0;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-secondary:hover {
        background: #e0e0e0;
        color: #333;
    }

    .btn-warning {
        background: #ffc107;
        color: #333;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-warning:hover {
        background: #e0a800;
        color: #333;
    }
</style>
@endsection

@section('content')
<div class="show-card">
    <div class="show-header">
        <h1><i class="fas fa-university me-2"></i> Bank Details</h1>
        <p class="subtitle">View bank account information</p>
    </div>

    <div class="show-card-body">
        <div class="detail-section">
            <div class="detail-section-title">
                <i class="fas fa-info-circle"></i> Bank Account Information
            </div>

            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Account Name</div>
                    <div class="detail-value">{{ $jitoJeapBank->account_name }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Bank Name</div>
                    <div class="detail-value">{{ $jitoJeapBank->bank_name }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Account Type</div>
                    <div class="detail-value">{{ $jitoJeapBank->account_type }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Account Number</div>
                    <div class="detail-value">{{ $jitoJeapBank->account_number }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">IFSC Code</div>
                    <div class="detail-value">{{ $jitoJeapBank->ifsc_code }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Created At</div>
                    <div class="detail-value">{{ $jitoJeapBank->created_at->format('d M, Y h:i A') }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Updated At</div>
                    <div class="detail-value">{{ $jitoJeapBank->updated_at->format('d M, Y h:i A') }}</div>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="{{ route('admin.jito-jeap-banks.edit', $jitoJeapBank) }}" class="btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.jito-jeap-banks.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
</div>
@endsection
