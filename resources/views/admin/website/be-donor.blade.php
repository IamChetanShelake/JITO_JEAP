@extends('admin.website.layouts.master')

@section('title', 'Be a Donor - JitoJeap Admin')

@section('website-content')
<style>
    /* Full width page layout */
    .be-donor-full-width .welcome-card {
        max-width: 100% !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 20px !important;
        border-radius: 0 !important;
    }
    .be-donor-full-width .website-pages-content {
        max-width: 100% !important;
        width: 100% !important;
        padding: 0 !important;
    }
    .be-donor-full-width .website-pages-layout {
        max-width: 100% !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        gap: 0 !important;
    }
    .full-width-table {
        width: 100% !important;
    }
    .table-responsive {
        width: 100% !important;
        overflow-x: visible !important;
    }
</style>

<div class="be-donor-full-width">
<div class="welcome-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fas fa-hand-holding-heart"></i> Be a Donor</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBeDonorModal">
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
        <table class="table table-hover table-bordered full-width-table">
            <thead class="table-light">
                <tr>
                    <th width="5%" class="text-center">Sr. No.</th>
                    <th width="15%">Icon</th>
                    <th width="20%">Benefit</th>
                    <th width="20%">Description</th>
                    <th width="15%">Become Member Step</th>
                    <th width="15%">What to Do</th>
                    <th width="10%" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($beDonorDetails as $index => $detail)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        @if($detail->icon)
                            <i class="{{ $detail->icon }} fa-2x"></i>
                        @else
                            <span class="text-muted">No Icon</span>
                        @endif
                    </td>
                    <td>{{ $detail->benefit }}</td>
                    <td>{{ Str::limit($detail->description, 100) }}</td>
                    <td>{{ $detail->become_member_step }}</td>
                    <td>{{ Str::limit($detail->what_to_do, 50) }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary" title="View" data-bs-toggle="modal" data-bs-target="#viewModal{{ $detail->id }}">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-info text-white" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $detail->id }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $detail->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                
                <!-- View Modal -->
                <div class="modal fade" id="viewModal{{ $detail->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $detail->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewModalLabel{{ $detail->id }}">View Be Donor Detail</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12 text-center mb-4">
                                        @if($detail->icon)
                                            <i class="{{ $detail->icon }} fa-4x text-primary"></i>
                                        @else
                                            <span class="text-muted">No Icon</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong>Benefit:</strong>
                                        <p>{{ $detail->benefit }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Become Member Step:</strong>
                                        <p>{{ $detail->become_member_step }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Display Order:</strong>
                                        <p>{{ $detail->display_order }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <strong>Description:</strong>
                                        <p>{{ $detail->description }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <strong>What to Do:</strong>
                                        <p>{{ $detail->what_to_do }}</p>
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
                <div class="modal fade" id="editModal{{ $detail->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $detail->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $detail->id }}">Edit Be Donor Detail</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.website.be-donor.update', $detail->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="icon{{ $detail->id }}" class="form-label">Icon</label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="icon_file{{ $detail->id }}" name="icon_file" accept="image/*">
                                                <span class="input-group-text">OR</span>
                                                <input type="text" class="form-control" id="icon{{ $detail->id }}" name="icon" value="{{ $detail->icon }}" placeholder="fas fa-heart">
                                            </div>
                                            <small class="text-muted">Upload an icon image or enter Font Awesome class</small>
                                            @if($detail->icon)
                                                <div class="mt-2">
                                                    <i class="{{ $detail->icon }} fa-2x"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="benefit{{ $detail->id }}" class="form-label">Benefit <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="benefit{{ $detail->id }}" name="benefit" value="{{ $detail->benefit }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="description{{ $detail->id }}" class="form-label">Description <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="description{{ $detail->id }}" name="description" rows="3" required>{{ $detail->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="become_member_step{{ $detail->id }}" class="form-label">Become Member Step</label>
                                            <input type="text" class="form-control" id="become_member_step{{ $detail->id }}" name="become_member_step" value="{{ $detail->become_member_step }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="what_to_do{{ $detail->id }}" class="form-label">What to Do</label>
                                            <textarea class="form-control" id="what_to_do{{ $detail->id }}" name="what_to_do" rows="3">{{ $detail->what_to_do }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="display_order{{ $detail->id }}" class="form-label">Display Order</label>
                                            <input type="number" class="form-control" id="display_order{{ $detail->id }}" name="display_order" value="{{ $detail->display_order }}">
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
                <div class="modal fade" id="deleteModal{{ $detail->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $detail->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $detail->id }}">Delete Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this record?</p>
                                <p class="text-danger"><strong>{{ $detail->benefit }}</strong></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('admin.website.be-donor.delete', $detail->id) }}" method="POST" style="display: inline;">
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
<div class="modal fade" id="addBeDonorModal" tabindex="-1" aria-labelledby="addBeDonorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBeDonorModalLabel">Add Be Donor Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.website.be-donor.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="icon" class="form-label">Icon</label>
                            <div class="input-group">
                                <input type="file" class="form-control" id="icon_file" name="icon_file" accept="image/*">
                                <span class="input-group-text">OR</span>
                                <input type="text" class="form-control" id="icon" name="icon" placeholder="fas fa-heart">
                            </div>
                            <small class="text-muted">Upload an icon image or enter Font Awesome class</small>
                            <div id="icon_preview" class="mt-2"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="benefit" class="form-label">Benefit <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="benefit" name="benefit" required placeholder="Enter benefit">
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
                            <label for="become_member_step" class="form-label">Become Member Step</label>
                            <input type="text" class="form-control" id="become_member_step" name="become_member_step" placeholder="e.g., Step 1, Step 2">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="what_to_do" class="form-label">What to Do</label>
                            <textarea class="form-control" id="what_to_do" name="what_to_do" rows="3" placeholder="Enter what to do"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="display_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control" id="display_order" name="display_order" value="0">
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
</style>
<script>
// Icon file preview for Add Modal
document.getElementById('icon_file').addEventListener('change', function(e) {
    const preview = document.getElementById('icon_preview');
    const file = e.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" style="max-width: 50px; max-height: 50px;">';
        };
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '';
    }
});
</script>
@endsection
