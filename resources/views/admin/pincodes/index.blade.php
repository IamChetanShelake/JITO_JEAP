@extends('admin.layouts.master')

@section('title', 'Pincode Management - JitoJeap Admin')

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

    .add-btn {
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
        .add-btn {
            width: auto;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
        }
    }

    .add-btn:hover {
        background-color: #4a40a8;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(57, 49, 133, 0.4);
    }

    .add-btn i {
        font-size: 0.9rem;
    }

    .card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .table-container {
        position: relative;
        width: 100%;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: #393185 transparent;
    }

    .table-responsive::-webkit-scrollbar {
        height: 6px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background-color: #393185;
        border-radius: 3px;
    }

    .table {
        width: 100%;
        min-width: 800px;
        margin-bottom: 0;
        color: #2c3e50;
    }

    .table thead th {
        background-color: #f8f9fa;
        color: #7f8c8d;
        font-weight: 500;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e9ecef;
        padding: 1rem;
        vertical-align: middle;
        white-space: nowrap;
        position: sticky;
        top: 0;
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
        color: #555;
        font-size: 0.9rem;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s ease;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 0.1rem;
        transition: all 0.2s ease;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .action-btn.view-btn {
        background-color: #e3f2fd;
        color: #2196F3;
    }

    .action-btn.view-btn:hover {
        background-color: #2196F3;
        color: white;
    }

    .action-btn.edit-btn {
        background-color: #fff8e1;
        color: #FFC107;
    }

    .action-btn.edit-btn:hover {
        background-color: #FFC107;
        color: white;
    }

    .action-btn.delete-btn {
        background-color: #ffebee;
        color: #f44336;
    }

    .action-btn.delete-btn:hover {
        background-color: #f44336;
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #999;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #e0e0e0;
    }

    .actions-cell {
        display: flex;
        justify-content: center;
        gap: 0.2rem;
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
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="page-title-section">
        <h1 class="page-title">
            <i class="fas fa-map-pin" style="color: #393185; margin-right: 0.5rem;"></i>
            Pincode Management
        </h1>
        <p class="page-subtitle">Manage pincodes for geographical chapter assignment</p>
    </div>
    <a href="{{ route('admin.pincodes.create') }}" class="add-btn">
        <i class="fas fa-plus"></i> Add Pincode
    </a>
</div>

<div class="card">
    <div class="table-container">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 5%;">Seq</th>
                        <th style="width: 20%;">Pincode</th>
                        <th style="width: 20%;">Latitude</th>
                        <th style="width: 20%;">Longitude</th>
                        <th style="width: 20%;">Cached At</th>
                        <th style="width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pincodes as $index => $pincode)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $pincode->pincode }}</strong></td>
                        <td>{{ $pincode->latitude ?? 'Not cached' }}</td>
                        <td>{{ $pincode->longitude ?? 'Not cached' }}</td>
                        <td>
                            @if($pincode->cached_at)
                                <span class="badge badge-success">{{ $pincode->cached_at->format('d M Y H:i') }}</span>
                            @else
                                <span class="badge badge-warning">Not cached</span>
                            @endif
                        </td>
                        <td class="actions-cell">
                            <a href="{{ route('admin.pincodes.show', $pincode) }}" class="action-btn view-btn">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.pincodes.edit', $pincode) }}" class="action-btn edit-btn">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.pincodes.destroy', $pincode) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete-btn"
                                        onclick="return confirm('Are you sure you want to delete this pincode?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>No pincodes found. Click "Add Pincode" to get started.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($pincodes->hasPages())
<div class="d-flex justify-content-center mt-3">
    {{ $pincodes->links() }}
</div>
@endif
@endsection
