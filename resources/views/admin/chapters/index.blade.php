@extends('admin.layouts.master')

@section('title', 'Chapter Registration - JitoJeap Admin')

@section('content')
<div class="section-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="fas fa-building me-2"></i> Chapter Registration</h4>
        <a href="{{ route('admin.chapters.create') }}" class="btn btn-success-custom">
            <i class="fas fa-plus me-2"></i> Add New Chapter
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Zone</th>
                        <th>Chapter Name</th>
                        <th>Code</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Chairman</th>
                        <th>Contact No</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($chapters as $chapter)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $chapter->zone->zone_name ?? 'N/A' }}</td>
                        <td>{{ $chapter->chapter_name }}</td>
                        <td><strong>{{ $chapter->code }}</strong></td>
                        <td>{{ $chapter->city }}</td>
                        <td>{{ $chapter->state }}</td>
                        <td>{{ $chapter->chairman }}</td>
                        <td>{{ $chapter->contact_no }}</td>
                        <td>
                            @if($chapter->status)
                                <span class="badge-status-active">Active</span>
                            @else
                                <span class="badge-status-inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.chapters.show', $chapter) }}" class="btn btn-sm btn-custom" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.chapters.edit', $chapter) }}" class="btn btn-sm btn-success-custom" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.chapters.destroy', $chapter) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger-custom" onclick="return confirm('Are you sure you want to delete this chapter?')" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No chapters found. Create your first chapter!</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
