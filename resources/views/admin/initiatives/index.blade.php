@extends('admin.layouts.master')

@section('title', 'Initiatives - JitoJeap Admin')

@section('styles')
<style>
    .page-header {
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: #009846;
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        color: #666;
        font-size: 0.95rem;
    }

    .add-btn {
        background: linear-gradient(135deg, #009846, #4caf50);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 2px 8px rgba(0, 152, 70, 0.2);
    }

    .add-btn:hover {
        background: linear-gradient(135deg, #00b855, #66bb6a);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 152, 70, 0.3);
        color: white;
    }

    .data-table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background: linear-gradient(135deg, #009846, #4caf50);
        color: white;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        padding: 1rem;
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table tbody tr:hover {
        background: #f8f9fa;
        transition: background 0.2s ease;
    }

    .table tbody tr:hover td {
        background: #f8f9fa;
    }

    .status-badge {
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .status-badge.active {
        background: #e8f5e9;
        color: #009846;
    }

    .status-badge.inactive {
        background: #ffebee;
        color: #E31E24;
    }

    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #393185;
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    .action-btn {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 0.25rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .action-btn.view-btn {
        background: #e8eaf6;
        color: #393185;
    }

    .action-btn.view-btn:hover {
        background: #393185;
        color: white;
        transform: scale(1.1);
    }

    .action-btn.edit-btn {
        background: #fff8e1;
        color: #FBBA00;
    }

    .action-btn.edit-btn:hover {
        background: #FBBA00;
        color: white;
        transform: scale(1.1);
    }

    .action-btn.delete-btn {
        background: #ffebee;
        color: #E31E24;
    }

    .action-btn.delete-btn:hover {
        background: #E31E24;
        color: white;
        transform: scale(1.1);
    }

    .table-header-icon {
        margin-right: 0.5rem;
        font-size: 1rem;
    }

    .table-row-icon {
        margin-right: 0.5rem;
        color: #666;
    }

    .badge {
        font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
        border-radius: 12px;
        font-weight: 500;
    }

    .badge-light {
        background: #f8f9fa;
        color: #333;
        border: 1px solid #e0e0e0;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
    }

    .empty-state i {
        font-size: 3rem;
        color: #e0e0e0;
        margin-bottom: 1rem;
    }

    .empty-state p {
        color: #999;
        font-size: 0.95rem;
    }
</style>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title"><i class="fas fa-lightbulb me-2"></i> Initiative Management</h1>
        <p class="page-subtitle">Track and manage organizational initiatives</p>
    </div>
    <a href="{{ route('admin.initiatives.create') }}" class="add-btn">
        <i class="fas fa-plus"></i> Add Initiatives
    </a>
</div>

<div class="data-table">
    <table class="table">
        <thead>
            <tr>
                <th><i class="fas fa-hashtag table-header-icon"></i> Seq</th>
                <th><i class="fas fa-user-tie table-header-icon"></i> Initiative Leader</th>
                <th><i class="fas fa-lightbulb table-header-icon"></i> Initiative Name</th>
                <th><i class="fas fa-id-badge table-header-icon"></i> Designation</th>
                <th><i class="fas fa-envelope table-header-icon"></i> Email</th>
                <th><i class="fas fa-phone table-header-icon"></i> Contact</th>
                <th><i class="fas fa-power-off table-header-icon"></i> Status</th>
                <th><i class="fas fa-eye table-header-icon"></i> Show/Hide</th>
                <th><i class="fas fa-cog table-header-icon"></i> Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($initiatives as $index => $initiative)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong><i class="fas fa-user-circle table-row-icon"></i> {{ $initiative->initiative_leader }}</strong></td>
                <td><span class="badge badge-light">{{ $initiative->initiative_name }}</span></td>
                <td><i class="fas fa-id-badge table-row-icon"></i> {{ $initiative->designation }}</td>
                <td><i class="fas fa-envelope table-row-icon"></i> {{ $initiative->email }}</td>
                <td><i class="fas fa-phone table-row-icon"></i> {{ $initiative->contact }}</td>
                <td>
                    <span class="status-badge {{ $initiative->status ? 'active' : 'inactive' }}">
                        <i class="fas fa-circle {{ $initiative->status ? 'text-success' : 'text-danger' }} me-1"></i>
                        {{ $initiative->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <label class="toggle-switch">
                        <input type="checkbox" {{ $initiative->show_hide ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </td>
                <td>
                    <a href="{{ route('admin.initiatives.show', $initiative) }}" class="action-btn view-btn" title="View">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.initiatives.edit', $initiative) }}" class="action-btn edit-btn" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.initiatives.destroy', $initiative) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn delete-btn" title="Delete"
                                onclick="return confirm('Are you sure you want to delete this initiative?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="empty-state">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No initiatives found. Click "Add Initiatives" to get started.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
