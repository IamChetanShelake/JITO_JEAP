@extends('admin.website.layouts.master')

@section('title', 'Success Stories - JitoJeap Admin')

@section('website-content')
<div class="welcome-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fas fa-trophy"></i> Success Stories</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSuccessStoryModal">
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
        <table class="table table-hover table-bordered" style="width: 100%; table-layout: fixed;">
            <thead class="table-light">
                <tr>
                    <th width="5%" class="text-center">Sr. No.</th>
                    <th width="30%">Image</th>
                    <th width="40%">Video Link</th>
                    <th width="10%">Order</th>
                    <th width="5%">Status</th>
                    <th width="10%" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($successStories ?? [] as $index => $story)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">
                        @if(!empty($story->image))
                            <img src="{{ asset($story->image) }}" alt="Success Story Image" style="width: 120px; height: 80px; object-fit: cover;">
                        @else
                            <div style="width: 120px; height: 80px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        @if(!empty($story->video_link))
                            <a href="{{ $story->video_link }}" target="_blank" class="text-primary">
                                {{ Str::limit($story->video_link, 50) }}
                            </a>
                        @else
                            <span class="text-muted">No link</span>
                        @endif
                    </td>
                    <td>{{ $story->display_order ?? 0 }}</td>
                    <td class="text-center">
                        @if($story->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <button class="btn btn-sm btn-info text-white" title="View" data-bs-toggle="modal" data-bs-target="#viewModal{{ $story->id ?? $index }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $story->id ?? $index }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $story->id ?? $index }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- View Modal -->
                <div class="modal fade" id="viewModal{{ $story->id ?? $index }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $story->id ?? $index }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewModalLabel{{ $story->id ?? $index }}">Success Story Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center mb-3">
                                    @if(!empty($story->image))
                                        <img src="{{ asset($story->image) }}" alt="Success Story Image" style="max-width: 100%; max-height: 300px; object-fit: contain;">
                                    @else
                                        <div style="width: 200px; height: 150px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                            <i class="fas fa-image text-muted fa-3x"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <strong>Video Link:</strong>
                                        @if(!empty($story->video_link))
                                            <a href="{{ $story->video_link }}" target="_blank" class="text-primary ms-2">{{ $story->video_link }}</a>
                                        @else
                                            <span class="text-muted ms-2">No link</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong>Display Order:</strong> {{ $story->display_order ?? 0 }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Status:</strong>
                                        @if($story->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
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
                <div class="modal fade" id="editModal{{ $story->id ?? $index }}" tabindex="-1" aria-labelledby="editModalLabel{{ $story->id ?? $index }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $story->id ?? $index }}">Edit Success Story</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.website.home.success-stories.update', $story->id ?? 0) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="image{{ $story->id ?? $index }}" class="form-label">Image</label>
                                            <input type="file" class="form-control" id="image{{ $story->id ?? $index }}" name="image" accept="image/*">
                                            <small class="text-muted">Upload image. Leave empty to keep current image.</small>
                                            @if(!empty($story->image))
                                                <div class="mt-2">
                                                    <label class="form-label">Current Image:</label>
                                                    <img src="{{ asset($story->image) }}" alt="Current" style="width: 120px; height: 80px; object-fit: cover;">
                                                    <input type="hidden" name="existing_image" value="{{ $story->image }}">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="video_link{{ $story->id ?? $index }}" class="form-label">Video Link</label>
                                            <input type="url" class="form-control" id="video_link{{ $story->id ?? $index }}" name="video_link" value="{{ $story->video_link ?? '' }}" placeholder="https://youtube.com/watch?v=...">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="display_order{{ $story->id ?? $index }}" class="form-label">Display Order</label>
                                            <input type="number" class="form-control" id="display_order{{ $story->id ?? $index }}" name="display_order" value="{{ $story->display_order ?? 0 }}" min="0">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="is_active{{ $story->id ?? $index }}" class="form-label">Status</label>
                                            <select class="form-select" id="is_active{{ $story->id ?? $index }}" name="is_active">
                                                <option value="1" {{ ($story->is_active ?? true) ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ ($story->is_active ?? true) ? '' : 'selected' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal{{ $story->id ?? $index }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $story->id ?? $index }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $story->id ?? $index }}">Delete Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this success story?</p>
                                <p class="text-danger">This action cannot be undone.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('admin.website.home.success-stories.delete', $story->id ?? 0) }}" method="POST" style="display: inline;">
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
                        <p>No success stories found. Click "Add Data" to add your first record.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Data Modal -->
<div class="modal fade" id="addSuccessStoryModal" tabindex="-1" aria-labelledby="addSuccessStoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSuccessStoryModalLabel">Add Success Story</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.website.home.success-stories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="text-muted">Upload image (recommended size: 400x300px).</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="video_link" class="form-label">Video Link</label>
                            <input type="url" class="form-control" id="video_link" name="video_link" placeholder="https://youtube.com/watch?v=...">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="display_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control" id="display_order" name="display_order" value="0" min="0">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection