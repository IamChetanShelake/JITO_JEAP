@extends('admin.layouts.master')

@section('title', 'Apex Leadership - JitoJeap Admin')

@section('styles')
<style>
    /* Mobile-first base styles */
    .container {
        width: 100%;
        padding: 0 1rem;
    }

    .page-header {
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title {
        font-size: clamp(1.5rem, 4vw, 1.75rem);
        font-weight: 600;
        color: #393185;
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        color: #666;
        font-size: clamp(0.8rem, 2.5vw, 0.95rem);
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
        min-height: 44px;
        min-width: 44px;
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
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        margin-bottom: 0;
        min-width: 600px;
        width: 100%;
    }

    .table thead th {
        background: linear-gradient(135deg, #393185, #5a4d9a);
        color: white;
        font-weight: 600;
        font-size: clamp(0.75rem, 2vw, 0.85rem);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        padding: 0.75rem;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .table tbody td {
        padding: 0.75rem;
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
        font-size: clamp(0.75rem, 2vw, 0.85rem);
        font-weight: 500;
        white-space: nowrap;
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
        min-width: 44px;
        min-height: 44px;
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
        font-size: clamp(0.8rem, 2.5vw, 1rem);
    }

    .table-row-icon {
        margin-right: 0.5rem;
        color: #666;
        font-size: clamp(0.8rem, 2.5vw, 1rem);
    }

    .badge {
        font-size: clamp(0.7rem, 2vw, 0.85rem);
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
        padding: 2rem;
    }

    .empty-state i {
        font-size: clamp(2rem, 8vw, 3rem);
        color: #e0e0e0;
        margin-bottom: 1rem;
    }

    .empty-state p {
        color: #999;
        font-size: clamp(0.8rem, 2.5vw, 0.95rem);
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

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.75rem;
        }

        .page-subtitle {
            font-size: 0.95rem;
        }

        .add-btn {
            padding: 0.75rem 1.5rem;
            height: 50px;
        }

        .table thead th {
            font-size: 0.85rem;
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
        }

        .status-badge {
            font-size: 0.85rem;
        }

        .status-badges {
            grid-template-columns: repeat(2, 1fr);
        }

        .stat-card {
            padding: 1.25rem;
        }

        .approval-section {
            padding: 1.75rem;
        }

        .recent-applications {
            padding: 1.5rem;
        }

        .sp-4 {
            margin: 32px;
        }

        .sp-5 {
            margin: 40px;
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
        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .status-badges {
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
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fas fa-users me-2"></i> Apex Leadership</h1>
            <p class="page-subtitle">Top-level management and decision makers</p>
        </div>
        <a href="{{ route('admin.apex.create') }}" class="add-btn">
            <i class="fas fa-plus"></i> Add Member
        </a>
    </div>

    <div class="data-table">
        <table class="table">
            <thead>
                <tr>
                    <th><i class="fas fa-hashtag table-header-icon"></i> Seq</th>
                    <th><i class="fas fa-user table-header-icon"></i> Name</th>
                    <th><i class="fas fa-briefcase table-header-icon"></i> Position</th>
                    <th><i class="fas fa-id-badge table-header-icon"></i> Designation</th>
                    <th><i class="fas fa-envelope table-header-icon"></i> Email</th>
                    <th><i class="fas fa-phone table-header-icon"></i> Contact</th>
                    <th><i class="fas fa-power-off table-header-icon"></i> Status</th>
                    <th><i class="fas fa-eye table-header-icon"></i> Show/Hide</th>
                    <th><i class="fas fa-cog table-header-icon"></i> Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $index => $member)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong><i class="fas fa-user-circle table-row-icon"></i> {{ $member->name }}</strong></td>
                    <td><i class="fas fa-briefcase table-row-icon"></i> {{ $member->position }}</td>
                    <td><i class="fas fa-id-badge table-row-icon"></i> {{ $member->designation }}</td>
                    <td><i class="fas fa-envelope table-row-icon"></i> {{ $member->email }}</td>
                    <td><i class="fas fa-phone table-row-icon"></i> {{ $member->contact }}</td>
                    <td>
                        <span class="status-badge {{ $member->status ? 'active' : 'inactive' }}">
                            <i class="fas fa-circle {{ $member->status ? 'text-success' : 'text-danger' }} me-1"></i>
                            {{ $member->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <label class="toggle-switch">
                            <input type="checkbox" {{ $member->show_hide ? 'checked' : '' }}
                                   onchange="toggleShowHide({{ $member->id }}, this)">
                            <span class="slider"></span>
                        </label>
                    </td>
                    <td>
                        <a href="{{ route('admin.apex.show', $member) }}" class="action-btn view-btn" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.apex.edit', $member) }}" class="action-btn edit-btn" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.apex.destroy', $member) }}" method="POST" style="display: inline;">
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
                    <td colspan="9" class="empty-state">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No members found. Click "Add Member" to get started.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
function toggleShowHide(id, checkbox) {
    fetch(`/admin/apex/${id}/toggle-show-hide`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            checkbox.checked = !checkbox.checked;
            alert('Failed to update status');
        }
    })
    .catch(error => {
        checkbox.checked = !checkbox.checked;
        alert('An error occurred');
    });
}
</script>
@endsection
