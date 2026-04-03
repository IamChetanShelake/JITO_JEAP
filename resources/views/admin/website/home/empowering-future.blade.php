@extends('admin.website.layouts.master')

@section('title', 'Empowering Future - JitoJeap Admin')

@section('website-content')
<div class="welcome-card w-100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fas fa-rocket"></i> Empowering Future</h3>
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

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <div class="table-responsive">
        <table class="table table-hover table-bordered" style="width: 100%; table-layout: fixed;">
            <thead class="table-light">
                <tr>
                    <th width="10%" class="text-center">Image</th>
                    <th width="12%">Title</th>
                    <th width="18%">Description</th>
                    <th width="18%">Vision of JEAP</th>
                    <th width="18%">Mission of JEAP</th>
                    <th width="5%">Order</th>
                   
                    <th width="14%" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($empoweringDreams ?? [] as $index => $dream)
                <tr>
                    <td class="text-center align-middle">
                        @if($dream->image)
                            <img src="{{ asset($dream->image) }}" alt="{{ $dream->title }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                        @else
                            <div style="width: 60px; height: 60px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td class="align-middle"><strong>{{ $dream->title ?? 'N/A' }}</strong></td>
                    <td class="align-middle">
                        <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ Str::limit($dream->description ?? 'No description', 50) }}
                        </div>
                    </td>
                    <td class="align-middle">
                        <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ Str::limit($dream->vision_description ?? 'No vision', 50) }}
                        </div>
                    </td>
                    <td class="align-middle">
                        <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ Str::limit($dream->mission_description ?? 'No mission', 50) }}
                        </div>
                    </td>
                    <td class="text-center align-middle">{{ $dream->order ?? 0 }}</td>
                   
                    <td class="text-center align-middle">
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
                                <div class="text-center mb-4">
                                    @if($dream->image)
                                        <img src="{{ asset($dream->image) }}" alt="{{ $dream->title }}" style="width: 200px; height: 200px; object-fit: cover; border-radius: 8px;">
                                    @else
                                        <div style="width: 200px; height: 200px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                            <i class="fas fa-image text-muted" style="font-size: 60px;"></i>
                                        </div>
                                    @endif
                                </div>
                                <h6>Title:</h6>
                                <p>{{ $dream->title ?? 'N/A' }}</p>
                                <h6>Description:</h6>
                                <p>{{ $dream->description ?? 'No description' }}</p>
                                
                                <h6>Vision Description of JEAP:</h6>
                                <p>{{ $dream->vision_description ?? 'No vision description' }}</p>
                               
                                <h6>Mission Description of JEAP:</h6>
                                <p>{{ $dream->mission_description ?? 'No mission description' }}</p>
                                
                                
                                
                                <h6>Display Order:</h6>
                                <p>{{ $dream->order ?? 0 }}</p>
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
                            <form action="{{ route('admin.website.home.empowering-future.update', $dream->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="image{{ $dream->id }}" class="form-label">Image</label>
                                            <input type="file" class="form-control" id="image{{ $dream->id }}" name="image" accept="image/*">
                                            <small class="text-muted">Leave empty to keep current image.</small>
                                            @if($dream->image)
                                                <div class="mt-2">
                                                    <label class="form-label">Current Image:</label>
                                                    <img src="{{ asset($dream->image) }}" alt="{{ $dream->title }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="title{{ $dream->id }}" class="form-label">Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="title{{ $dream->id }}" name="title" value="{{ $dream->title }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="description{{ $dream->id }}" class="form-label">Description <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="description{{ $dream->id }}" name="description" rows="3" required>{{ $dream->description }}</textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="vision_description{{ $dream->id }}" class="form-label">Vision Description of JEAP</label>
                                            <textarea class="form-control" id="vision_description{{ $dream->id }}" name="vision_description" rows="3">{{ $dream->vision_description }}</textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="mission_description{{ $dream->id }}" class="form-label">Mission Description of JEAP</label>
                                            <textarea class="form-control" id="mission_description{{ $dream->id }}" name="mission_description" rows="3">{{ $dream->mission_description }}</textarea>
                                        </div>
                                    </div>
                                    

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="order{{ $dream->id }}" class="form-label">Display Order</label>
                                            <input type="number" class="form-control" id="order{{ $dream->id }}" name="order" value="{{ $dream->order ?? 0 }}" min="0">
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
                                <form action="{{ route('admin.website.home.empowering-future.delete', $dream->id) }}" method="POST" style="display: inline;">
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
                    <td colspan="8" class="text-center text-muted py-4">
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
                <h5 class="modal-title" id="addEmpoweringDreamModalLabel">Add Empowering Dream</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.website.home.empowering-future.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="text-muted">Upload image (recommended size: 800x600px)</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required placeholder="Enter title">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="3" required placeholder="Enter description"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="vision" class="form-label">Vision of JEAP</label>
                            <textarea class="form-control" id="vision" name="vision" rows="3" placeholder="Enter vision of JEAP"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="vision_description" class="form-label">Vision Description of JEAP</label>
                            <textarea class="form-control" id="vision_description" name="vision_description" rows="3" placeholder="Enter vision of JEAP"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="mission" class="form-label">Mission of JEAP</label>
                            <textarea class="form-control" id="mission" name="mission" rows="3" placeholder="Enter mission of JEAP"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="mission_description" class="form-label">Mission Description of JEAP</label>
                            <textarea class="form-control" id="mission_description" name="mission_description" rows="3" placeholder="Enter mission of JEAP"></textarea>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="order" class="form-label">Display Order</label>
                            <input type="number" class="form-control" id="order" name="order" value="0" min="0">
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
    
    .welcome-card {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }
</style>
@endsection
