@extends('admin.layouts.master')

@section('title', 'Zone Registration - JitoJeap Admin')

@section('content')
<div class="section-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="fas fa-map-marked-alt me-2"></i> Zone Registration</h4>
        <a href="{{ route('admin.zones.create') }}" class="btn btn-success-custom">
            <i class="fas fa-plus me-2"></i> Add New Zone
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Zone Name</th>
                        <th>Code</th>
                        <th>State</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($zones as $zone)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $zone->zone_name }}</td>
                        <td><strong>{{ $zone->code }}</strong></td>
                        <td>{{ $zone->state }}</td>
                        <td>
                            @if($zone->status)
                                <span class="badge-status-active">Active</span>
                            @else
                                <span class="badge-status-inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.zones.show', $zone) }}" class="btn btn-sm btn-custom" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.zones.edit', $zone) }}" class="btn btn-sm btn-success-custom" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.zones.destroy', $zone) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger-custom" onclick="return confirm('Are you sure you want to delete this zone?')" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No zones found. Create your first zone!</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
