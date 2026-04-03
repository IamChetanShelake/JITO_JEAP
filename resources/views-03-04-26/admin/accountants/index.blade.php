@extends('admin.layouts.master')

@section('title', 'Accountants - JitoJeap Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 mb-1">Accountants</h1>
        <p class="text-muted mb-0">Manage accountant login users for admin dashboard access</p>
    </div>
    <a href="{{ route('admin.accountants.create') }}" class="btn btn-custom">
        <i class="fas fa-plus me-2"></i>Add Accountant
    </a>
</div>

<div class="section-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Seq</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $index => $member)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->designation ?: '-' }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->contact }}</td>
                            <td>
                                @if($member->status)
                                    <span class="badge-status-active">Active</span>
                                @else
                                    <span class="badge-status-inactive">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.accountants.show', $member) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.accountants.edit', $member) }}" class="btn btn-sm btn-outline-warning me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.accountants.destroy', $member) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this accountant?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No accountants found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
