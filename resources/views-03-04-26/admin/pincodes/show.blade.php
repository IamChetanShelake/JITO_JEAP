@extends('admin.layouts.master')

@section('title', 'View Pincode - JitoJeap Admin')

@section('styles')
<style>
    .page-header {
        margin-bottom: 2rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    @media (min-width: 768px) {
        .page-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }

    .page-title-section {
        display: flex;
        flex-direction: column;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #393185;
        margin-bottom: 0.25rem;
        display: flex;
        align-items: center;
    }

    @media (min-width: 768px) {
        .page-title {
            font-size: 1.75rem;
        }
    }

    .page-subtitle {
        color: #7f8c8d;
        font-size: 0.9rem;
    }

    @media (min-width: 768px) {
        .page-subtitle {
            font-size: 0.95rem;
        }
    }

    .edit-btn {
        background-color: #393185;
        color: white;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: 0 2px 8px rgba(57, 49, 133, 0.3);
        width: 100%;
        font-size: 0.9rem;
    }

    @media (min-width: 768px) {
        .edit-btn {
            width: auto;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
        }
    }

    .edit-btn:hover {
        background-color: #4a40a8;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(57, 49, 133, 0.4);
    }

    .edit-btn i {
        font-size: 0.9rem;
    }

    .card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .card-header {
        background: #f8f9fa;
        padding: 1.5rem;
        border-bottom: 1px solid #e9ecef;
    }

    .card-body {
        padding: 2rem;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .detail-item {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        border-left: 4px solid #393185;
    }

    .detail-label {
        font-size: 0.8rem;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .detail-value {
        font-size: 1.1rem;
        color: #333;
        font-weight: 600;
    }

    .badge {
        font-size: 0.8rem;
        padding: 0.4rem 0.8rem;
        border-radius: 12px;
        font-weight: 500;
    }

    .badge-success {
        background: #e8f5e9;
        color: #4CAF50;
    }

    .badge-warning {
        background: #fff8e1;
        color: #FFC107;
    }

    .back-btn {
        background: #f0f0f0;
        color: #333;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .back-btn:hover {
        background: #e9ecef;
        transform: translateY(-1px);
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="page-title-section">
        <h1 class="page-title">
            <i class="fas fa-map-pin" style="color: #393185; margin-right: 0.5rem;"></i>
            Pincode Details
        </h1>
        <p class="page-subtitle">View pincode information and coordinates</p>
    </div>
    <a href="{{ route('admin.pincodes.edit', $pincode) }}" class="edit-btn">
        <i class="fas fa-edit"></i> Edit Pincode
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Pincode: {{ $pincode->pincode }}</h5>
    </div>

    <div class="card-body">
        <div class="detail-grid">
            <div class="detail-item">
                <div class="detail-label">
                    <i class="fas fa-hashtag me-1"></i> Pincode
                </div>
                <div class="detail-value">{{ $pincode->pincode }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-label">
                    <i class="fas fa-map-marker-alt me-1"></i> Latitude
                </div>
                <div class="detail-value">{{ $pincode->latitude ?? 'Not cached' }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-label">
                    <i class="fas fa-map-marker-alt me-1"></i> Longitude
                </div>
                <div class="detail-value">{{ $pincode->longitude ?? 'Not cached' }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-label">
                    <i class="fas fa-clock me-1"></i> Cached At
                </div>
                <div class="detail-value">
                    @if($pincode->cached_at)
                        <span class="badge badge-success">{{ $pincode->cached_at->format('d M Y H:i') }}</span>
                    @else
                        <span class="badge badge-warning">Not cached</span>
                    @endif
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">
                    <i class="fas fa-calendar me-1"></i> Created At
                </div>
                <div class="detail-value">{{ $pincode->created_at->format('d M Y H:i') }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-label">
                    <i class="fas fa-calendar-alt me-1"></i> Updated At
                </div>
                <div class="detail-value">{{ $pincode->updated_at->format('d M Y H:i') }}</div>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.pincodes.index') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Pincodes
            </a>
        </div>
    </div>
</div>
@endsection
