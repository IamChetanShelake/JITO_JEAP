@extends('admin.layouts.master')

@section('title', 'Working Committee - JitoJeap Admin')

@section('styles')
<style>
    .page-header {
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: #FBBA00;
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        color: #666;
        font-size: 0.95rem;
    }

    .add-btn {
        background: #FBBA00;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .add-btn:hover {
        background: #e6a800;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(251, 186, 0, 0.3);
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
        background: #f8f9fa;
        color: #666;
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
    }

    .action-btn.view-btn {
        background: #e8eaf6;
        color: #393185;
    }

    .action-btn.view-btn:hover {
        background: #393185;
        color: white;
    }

    .action-btn.edit-btn {
        background: #fff8e1;
        color: #FBBA00;
    }

    .action-btn.edit-btn:hover {
        background: #FBBA00;
        color: white;
    }

    .action-btn.delete-btn {
        background: #ffebee;
        color: #E31E24;
    }

    .action-btn.delete-btn:hover {
        background: #E31E24;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Working Committee</h1>
        <p class="page-subtitle">Department heads and committee leaders</p>
    </div>
    <a href="{{ route('admin.committee.create') }}" class="add-btn">
        <i class="fas fa-plus"></i> Add Committee Member
    </a>
</div>

<div class="data-table">
    <table class="table">
        <thead>
            <tr>
                <th>Seq</th>
                <th>Name</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Status</th>
                <th>Show/Hide</th>
                <th>Actions</th>
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
                        {{ $member->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <label class="toggle-switch">
                        <input type="checkbox" {{ $member->show_hide ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </td>
                <td>
                    <a href="{{ route('admin.committee.show', $member) }}" class="action-btn view-btn" title="View">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.committee.edit', $member) }}" class="action-btn edit-btn" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.committee.destroy', $member) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn delete-btn" title="Delete" 
                                onclick="return confirm('Are you sure you want to delete this member?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No members found. Click "Add Committee Member" to get started.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
