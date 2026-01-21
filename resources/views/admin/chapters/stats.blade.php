@extends('admin.layouts.master')

@section('title', 'Chapter Statistics - JitoJeap')

@section('styles')
<style>
    .chapter-item {
        background: white;
        border-radius: 15px;
        padding: 1rem;
        border: 1px solid #e0e0e0;
        margin-bottom: 1rem;
    }

    .chapter-title {
        color: #E31E24;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .status-badges {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 0.75rem;
    }

    .status-badge {
        border-radius: 12px;
        padding: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border: 1px solid;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
    }

    .status-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .status-badge.approved {
        background: #e8f5e9;
        border-color: #c8e6c9;
    }

    .status-badge.pending {
        background: #fff8e1;
        border-color: #ffe082;
    }

    .status-badge.hold {
        background: #ffebee;
        border-color: #ffcdd2;
    }

    .status-icon {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        border: 2px solid;
        background: transparent;
    }

    .status-icon.approved {
        border-color: #4caf50;
        color: #4caf50;
    }

    .status-icon.pending {
        border-color: #ffc107;
        color: #ffc107;
    }

    .status-icon.hold {
        border-color: #f44336;
        color: #f44336;
    }

    .status-label {
        font-size: 0.7rem;
        color: #666;
        margin-bottom: 0.25rem;
    }

    .status-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: #333;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="dashboard-header" style="margin-bottom: 1.5rem;">
        <h1 class="dashboard-title"><i class="fas fa-chart-bar me-2"></i> Chapter Statistics</h1>
    </div>

    @foreach($chapters as $chapter)
    <div class="chapter-item">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="chapter-title">{{ $chapter->chapter_name }}</h5>
            <a href="{{ route('admin.chapter.details', $chapter->id) }}" class="btn btn-primary">View Details</a>
        </div>
    </div>
    @endforeach
</div>
@endsection
