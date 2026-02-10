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
                                <td>
                                    <a href="{{ route('admin.donors.show', $donor) }}" class="btn btn-custom btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.donors.edit', $donor) }}" class="btn btn-success-custom btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.donors.destroy', $donor) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger-custom btn-sm" onclick="return confirm('Delete this donor?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No donors found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
