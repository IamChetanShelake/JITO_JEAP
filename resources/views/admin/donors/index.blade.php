@extends('admin.layouts.master')

@section('title', 'Donors - JitoJeap Admin')

@section('content')
    <div class="container">
        <div class="dashboard-header">
            <div>
                <h1 class="dashboard-title"><i class="fas fa-hand-holding-heart me-2"></i> Donors</h1>
                <p class="dashboard-subtitle">Manage donor accounts</p>
            </div>
            <a href="{{ route('admin.donors.create') }}" class="btn btn-success-custom">
                <i class="fas fa-plus me-1"></i> Add Donor
            </a>
        </div>

        <div class="section-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Membership Number</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Login</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($donors as $donor)
                                <tr>
                                    <td>{{ $donor->id }}</td>
                                    <td>{{ $donor->name }}</td>
                                    <td>{{ $donor->email }}</td>
                                    <td>{{ $donor->phone ?? '-' }}</td>
                                    <td>{{ $donor->membership_number ?? 'N/A' }}</td>
                                    <td>
                                        @if ($donor->donor_type === 'general')
                                            <span class="badge bg-secondary">General</span>
                                        @else
                                            <span class="badge bg-primary">Member</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($donor->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($donor->status === 'converted')
                                            <span class="badge bg-warning">Converted</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($donor->can_login)
                                            <span class="text-success"><i class="fas fa-check"></i> Yes</span>
                                        @else
                                            <span class="text-muted"><i class="fas fa-times"></i> No</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.donors.show', $donor) }}" class="btn btn-custom btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.donors.edit', $donor) }}"
                                            class="btn btn-success-custom btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.donors.destroy', $donor) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger-custom btn-sm"
                                                onclick="return confirm('Delete this donor?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                        @if ($donor->donor_type === 'member' && $donor->status === 'active')
                                            <form action="{{ route('admin.donors.convertToGeneral', $donor) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm"
                                                    onclick="return confirm('Are you sure you want to convert this member donor to a general donor?')">
                                                    <i class="fas fa-user"></i> Convert
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No donors found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
