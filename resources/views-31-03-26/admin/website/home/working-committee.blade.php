@extends('admin.website.layouts.master')

@section('title', 'Working Committee - JitoJeap Admin')

@section('website-content')
<div class="welcome-card w-100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fas fa-users"></i> Working Committee</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWorkingCommitteeModal">
            <i class="fas fa-plus"></i> Add Data
        </button>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <div class="table-responsive">
        <!-- Added table-layout: fixed; and width: 100%; to force full width -->
        <table class="table table-hover table-bordered" style="width: 100%; table-layout: fixed;">
            <thead class="table-light">
                <tr>
                    <!-- Adjusted widths to sum 100% -->
                    <th width="10%" class="text-center">Photo</th>
                    <th width="15%">Name</th>
                    <th width="15%">Designation</th>
                    <th width="35%">Description</th>
                    <th width="5%">Order</th>
                    <th width="5%">Status</th>
                    <th width="15%" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($workingCommittee ?? [] as $index => $member)
                <tr>
                    <td class="text-center align-middle">
                        @if($member->photo)
                            <img src="{{ asset($member->photo) }}" alt="{{ $member->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;">
                        @else
                            <div style="width: 60px; height: 60px; background: #f0f0f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-user text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td class="align-middle"><strong>{{ $member->name ?? 'N/A' }}</strong></td>
                    <td class="align-middle">{{ $member->designation ?? 'N/A' }}</td>
                    <td class="align-middle">
                        <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ Str::limit($member->description ?? 'No description', 100) }}
                        </div>
                    </td>
                    <td class="text-center align-middle">{{ $member->display_order ?? 0 }}</td>
                    <td class="text-center align-middle">
                        @if($member->status)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td class="text-center align-middle">
                        <button class="btn btn-sm btn-info text-white" title="View" data-bs-toggle="modal" data-bs-target="#viewModal{{ $member->id }}">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $member->id }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $member->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                
                <!-- View Modal -->
                <div class="modal fade" id="viewModal{{ $member->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $member->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewModalLabel{{ $member->id }}">{{ $member->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center mb-4">
                                    @if($member->photo)
                                        <img src="{{ asset($member->photo) }}" alt="{{ $member->name }}" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
                                    @else
                                        <div style="width: 150px; height: 150px; background: #f0f0f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                            <i class="fas fa-user text-muted" style="font-size: 60px;"></i>
                                        </div>
                                    @endif
                                </div>
                                <h6>Designation:</h6>
                                <p>{{ $member->designation ?? 'N/A' }}</p>
                                <h6>Description:</h6>
                                <p>{{ $member->description ?? 'No description' }}</p>
                                <h6>Status:</h6>
                                <p>
                                    @if($member->status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </p>
                                <h6>Display Order:</h6>
                                <p>{{ $member->display_order ?? 0 }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Edit Modal -->
                <div class="modal fade" id="editModal{{ $member->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $member->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $member->id }}">Edit - {{ $member->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.website.home.working-committee.update', $member->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="photo{{ $member->id }}" class="form-label">Photo</label>
                                            <input type="file" class="form-control" id="photo{{ $member->id }}" name="photo" accept="image/*">
                                            <small class="text-muted">Leave empty to keep current photo.</small>
                                            @if($member->photo)
                                                <div class="mt-2">
                                                    <label class="form-label">Current Photo:</label>
                                                    <img src="{{ asset($member->photo) }}" alt="{{ $member->name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="name{{ $member->id }}" class="form-label">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name{{ $member->id }}" name="name" value="{{ $member->name }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="designation{{ $member->id }}" class="form-label">Designation <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="designation{{ $member->id }}" name="designation" value="{{ $member->designation }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="description{{ $member->id }}" class="form-label">Description</label>
                                            <textarea class="form-control" id="description{{ $member->id }}" name="description" rows="3">{{ $member->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="display_order{{ $member->id }}" class="form-label">Display Order</label>
                                            <input type="number" class="form-control" id="display_order{{ $member->id }}" name="display_order" value="{{ $member->display_order ?? 0 }}" min="0">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="status{{ $member->id }}" class="form-label">Status</label>
                                            <select class="form-select" id="status{{ $member->id }}" name="status">
                                                <option value="1" {{ $member->status ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ !$member->status ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal{{ $member->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $member->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $member->id }}">Delete Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete <strong>{{ $member->name }}</strong>?</p>
                                <p class="text-danger">This action cannot be undone.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('admin.website.home.working-committee.delete', $member->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-2"></i>
                        <p>No data found. Click "Add Data" to add your first record.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Data Modal -->
<div class="modal fade" id="addWorkingCommitteeModal" tabindex="-1" aria-labelledby="addWorkingCommitteeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addWorkingCommitteeModalLabel">Add Working Committee Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.website.home.working-committee.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                            <small class="text-muted">Upload photo (recommended size: 200x200px)</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required placeholder="Enter name">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="designation" class="form-label">Designation <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="designation" name="designation" required placeholder="Enter designation">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="display_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control" id="display_order" name="display_order" value="0" min="0">
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Ensure table header stands out */
    .table thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
    }
    
    /* Hover effect for rows */
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        margin: 0 2px;
    }
    
    /* Ensure the welcome card takes full width available */
    .welcome-card {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }
</style>
@endsection