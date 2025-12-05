@extends('admin.layouts.master')

@section('title', 'Working Committee - JitoJeap Admin')

@section('styles')
<style>
    :root {
        --primary-green: #4CAF50;
        --primary-yellow: #FBBA00;
        --primary-blue: #2196F3;
        --primary-red: #f44336;
        --text-dark: #2c3e50;
        --text-light: #7f8c8d;
        --bg-light: #f8f9fa;
        --border-color: #e9ecef;
    }

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
        color: var(--primary-yellow);
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
        color: var(--text-light);
        font-size: 0.9rem;
    }

    @media (min-width: 768px) {
        .page-subtitle {
            font-size: 0.95rem;
        }
    }

    .add-btn {
        background-color: var(--primary-yellow);
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
        box-shadow: 0 2px 8px rgba(251, 186, 0, 0.3);
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
        background-color: #e6a600;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(251, 186, 0, 0.4);
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
        scrollbar-color: var(--primary-green) transparent;
    }

    .table-responsive::-webkit-scrollbar {
        height: 6px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background-color: var(--primary-yellow);
        border-radius: 3px;
    }

    .table {
        width: 100%;
        min-width: 1000px;
        margin-bottom: 0;
        color: var(--text-dark);
    }

    .table thead th {
        background-color: var(--bg-light);
        color: var(--text-light);
        font-weight: 500;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--border-color);
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

    .initiative-name {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .initiative-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    .status-badge {
        padding: 0.35rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .status-active {
        background: #e8f5e9;
        color: var(--primary-green);
    }

    .status-inactive {
        background: #ffebee;
        color: var(--primary-red);
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
        color: var(--primary-blue);
    }

    .action-btn.view-btn:hover {
        background-color: var(--primary-blue);
        color: white;
    }

    .action-btn.edit-btn {
        background-color: #fff8e1;
        color: var(--primary-yellow);
    }

    .action-btn.edit-btn:hover {
        background-color: var(--primary-yellow);
        color: white;
    }

    .action-btn.delete-btn {
        background-color: #ffebee;
        color: var(--primary-red);
    }

    .action-btn.delete-btn:hover {
        background-color: var(--primary-red);
        color: white;
    }

    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
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
        border-radius: 20px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 14px;
        width: 14px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: var(--primary-yellow);
    }

    input:checked + .slider:before {
        transform: translateX(20px);
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

    /* Mobile specific styles */
    @media (max-width: 767.98px) {
        .table-container {
            border-radius: 10px;
            overflow: hidden;
        }

        .table-responsive {
            border-radius: 10px;
        }

        .table {
            min-width: 100%;
        }

        /* Add shadow to indicate scrollability */
        .table-responsive {
            -webkit-mask-image: linear-gradient(to right, transparent 0%, black 5%, black 95%, transparent 100%);
            mask-image: linear-gradient(to right, transparent 0%, black 5%, black 95%, transparent 100%);
        }

        /* Scroll hint for mobile users */
        .scroll-hint {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.9);
            padding: 0.5rem;
            border-radius: 50% 0 0 50%;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
            z-index: 10;
            display: none;
        }

        .table-responsive:hover .scroll-hint {
            display: block;
        }
    }

    @media (min-width: 768px) {
        .scroll-hint {
            display: none !important;
        }
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="page-title-section">
        <h1 class="page-title">
            <i class="fas fa-user-tie" style="color: var(--primary-yellow); margin-right: 0.5rem;"></i>
            Working Committee
        </h1>
        <p class="page-subtitle">Department heads and committee leaders</p>
    </div>
    <a href="{{ route('admin.committee.create') }}" class="add-btn">
        <i class="fas fa-plus"></i> Add Committee Member
    </a>
</div>

<div class="card">
    <div class="table-container">
        <div class="table-responsive">
            <div class="scroll-hint">
                <i class="fas fa-chevron-right" style="color: var(--primary-yellow);"></i>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 5%;">Seq</th>
                        <th style="width: 15%;">Name</th>
                        <th style="width: 20%;">Department</th>
                        <th style="width: 15%;">Designation</th>
                        <th style="width: 15%;">Email</th>
                        <th style="width: 12%;">Contact</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 8%;">Show/Hide</th>
                        <th style="width: 10%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $index => $member)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $member->name }}</strong></td>
                        <td>{{ $member->department }}</td>
                        <td>{{ $member->designation }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ $member->contact }}</td>
                        <td>
                            <span class="status-badge {{ $member->status ? 'active' : 'inactive' }}">
                                <i class="fas fa-circle" style="font-size: 0.6rem;"></i>
                                {{ $member->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" {{ $member->show_hide ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </td>
                        <td class="actions-cell">
                            <a href="{{ route('admin.committee.show', $member) }}" class="action-btn view-btn">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.committee.edit', $member) }}" class="action-btn edit-btn">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.committee.destroy', $member) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete-btn"
                                        onclick="return confirm('Are you sure you want to delete this member?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>No members found. Click "Add Committee Member" to get started.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
