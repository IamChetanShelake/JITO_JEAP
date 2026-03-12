@extends('admin.website.layouts.master')

@section('title', 'Empowering Dreams - JitoJeap Admin')

@section('website-content')
<div class="welcome-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fas fa-star"></i> Empowering Dreams</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmpoweringDreamModal">
            <i class="fas fa-plus"></i> Add Data
        </button>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th width="5%" class="text-center">Sr. No.</th>
                    <th width="20%">Title</th>
                    <th width="25%">Description</th>
                    <th width="20%">Features</th>
                    <th width="15%">Image</th>
                    <th width="15%" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($empoweringDreams as $index => $dream)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $dream->title }}</strong></td>
                    <td>{{ Str::limit($dream->description, 100) }}</td>
                    <td>
                        @php
                        $features = explode(',', $dream->features);
                        @endphp
                        @foreach($features as $feature)
                            <span class="badge bg-primary me-1 mb-1">{{ trim($feature) }}</span>
                        @endforeach
                    </td>
                    <td>
                        @if($dream->image && file_exists(public_path($dream->image)))
                            <img src="{{ asset($dream->image) }}" alt="{{ $dream->title }}" class="img-thumbnail" style="max-width: 80px;">
                        @else
                            <img src="https://via.placeholder.com/80x60?text=No+Image" alt="No Image" class="img-thumbnail" style="max-width: 80px;">
                        @endif
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-info text-white" title="View" data-bs-toggle="modal" data-bs-target="#viewModal{{ $dream->id }}">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $dream->id }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $dream->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                
                <!-- View Modal -->
                <div class="modal fade" id="viewModal{{ $dream->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $dream->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewModalLabel{{ $dream->id }}">{{ $dream->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        @if($dream->image && file_exists(public_path($dream->image)))
                                            <img src="{{ asset($dream->image) }}" alt="{{ $dream->title }}" class="img-fluid rounded">
                                        @else
                                            <img src="https://via.placeholder.com/300x200?text=No+Image" alt="No Image" class="img-fluid rounded">
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <h6>Description:</h6>
                                        <p>{{ $dream->description }}</p>
                                        <h6 class="mt-3">Features:</h6>
                                        <div>
                                            @foreach($features as $feature)
                                                <span class="badge bg-primary me-1">{{ trim($feature) }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Edit Modal -->
                <div class="modal fade" id="editModal{{ $dream->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $dream->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $dream->id }}">Edit - {{ $dream->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.website.home.empowering-dreams.update', $dream->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="title{{ $dream->id }}" class="form-label">Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="title{{ $dream->id }}" name="title" value="{{ $dream->title }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="description{{ $dream->id }}" class="form-label">Description <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="description{{ $dream->id }}" name="description" rows="4" required>{{ $dream->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="features{{ $dream->id }}" class="form-label">Features <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="features{{ $dream->id }}" name="features" value="{{ $dream->features }}" required>
                                            <small class="text-muted">Separate features with commas (e.g., Tuition, Books, Uniform)</small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="image{{ $dream->id }}" class="form-label">Image</label>
                                            <input type="file" class="form-control" id="image{{ $dream->id }}" name="image" accept="image/*">
                                            <small class="text-muted">Leave empty to keep current image</small>
                                            @if($dream->image && file_exists(public_path($dream->image)))
                                                <div class="mt-2">
                                                    <img src="{{ asset($dream->image) }}" alt="Current Image" class="img-thumbnail" style="max-width: 150px;">
                                                </div>
                                            @endif
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
                <div class="modal fade" id="deleteModal{{ $dream->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $dream->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $dream->id }}">Delete Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete <strong>{{ $dream->title }}</strong>?</p>
                                <p class="text-danger">This action cannot be undone.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('admin.website.home.empowering-dreams.delete', $dream->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
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
<div class="modal fade" id="addEmpoweringDreamModal" tabindex="-1" aria-labelledby="addEmpoweringDreamModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmpoweringDreamModalLabel">Add Empowering Dreams Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.website.home.empowering-dreams.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required placeholder="Enter title">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="4" required placeholder="Enter description"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="features" class="form-label">Features <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="features" name="features" required placeholder="Enter features (comma separated)">
                            <small class="text-muted">Separate features with commas (e.g., Tuition, Books, Uniform)</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="image" class="form-label">Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                            <small class="text-muted">Supported formats: JPG, PNG, GIF (Max size: 2MB)</small>
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
    .table thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
    }
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
    .img-thumbnail {
        object-fit: cover;
    }
</style>
@endsection
