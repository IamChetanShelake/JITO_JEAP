@extends('admin.website.layouts.master')

@section('title', 'Empowering Dreams - JitoJeap Admin')

@section('website-content')
{{-- Added p-0 to remove default padding so table touches edges --}}
<div class="welcome-card w-100 p-0">
    
    {{-- Added padding p-3 specifically to the header section --}}
    <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
        <h3 class="mb-0"><i class="fas fa-star"></i> Empowering Dreams</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmpoweringDreamModal">
            <i class="fas fa-plus"></i> Add Data
        </button>
    </div>
    
    @if(session('success'))
    {{-- Added mx-3 margin to alert so it doesn't touch edges --}}
    <div class="alert alert-success alert-dismissible fade show mx-3 mt-3 mb-0" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <div class="table-responsive">
        {{-- ADDED: width: 100%; table-layout: fixed; to force full width behavior --}}
        <table class="table table-hover table-bordered mb-0" style="width: 100%; table-layout: fixed;">
            <thead class="table-light">
                <tr>
                    {{-- DEFINED EXPLICIT WIDTHS to ensure full expansion --}}
                    <th class="text-center" width="5%">Sr. No.</th>
                    <th width="20%">Title</th>
                    <th width="25%">Description</th>
                    <th width="20%">Features</th>
                    <th class="text-center" width="15%">Image</th>
                    <th class="text-center" width="15%">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($empoweringDreams as $index => $dream)
                <tr>
                    <td class="text-center align-middle">{{ $index + 1 }}</td>
                    <td class="align-middle">
                        {{ Str::limit($dream->title, 50) }}
                    </td>
                    <td class="align-middle">
                        {{-- Added text-truncate or limit logic if needed, keeping limit for now --}}
                        {{ Str::limit($dream->description, 100) }}
                    </td>
                    <td class="align-middle">
                        @php
                        $features = explode(',', $dream->features);
                        @endphp
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($features as $feature)
                                <span class="badge bg-primary">{{ trim($feature) }}</span>
                            @endforeach
                        </div>
                    </td>
                    <td class="text-center align-middle">
                        @if($dream->image && file_exists(public_path($dream->image)))
                            <img src="{{ asset($dream->image) }}" alt="Empowering Dream" class="img-thumbnail p-0" style="width: 80px; height: 60px; object-fit: cover; border-radius: 4px;">
                        @else
                            <img src="https://via.placeholder.com/80x60?text=No+Image" alt="No Image" class="img-thumbnail p-0" style="width: 80px; height: 60px; object-fit: cover; border-radius: 4px;">
                        @endif
                    </td>
                    <td class="text-center align-middle">
                        <div class="d-flex justify-content-center gap-1">
                            <button class="btn btn-sm btn-info text-white" title="View" data-bs-toggle="modal" data-bs-target="#viewModal{{ $dream->id }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $dream->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $dream->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- View Modal -->
                <div class="modal fade" id="viewModal{{ $dream->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $dream->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewModalLabel{{ $dream->id }}">Empowering Dream Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        @if($dream->image && file_exists(public_path($dream->image)))
                                            <img src="{{ asset($dream->image) }}" alt="Empowering Dream" class="img-fluid rounded w-100">
                                        @else
                                            <img src="https://via.placeholder.com/300x200?text=No+Image" alt="No Image" class="img-fluid rounded w-100">
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <h6>Description:</h6>
                                        <p>{{ $dream->description }}</p>
                                        <h6 class="mt-3">Features:</h6>
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($features as $feature)
                                                <span class="badge bg-primary">{{ trim($feature) }}</span>
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
                                <h5 class="modal-title" id="editModalLabel{{ $dream->id }}">Edit Empowering Dream</h5>
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
                                        <div class="col-md-6">
                                            <label for="vision_description{{ $dream->id }}" class="form-label">Vision Description</label>
                                            <textarea class="form-control" id="vision_description{{ $dream->id }}" name="vision_description" rows="3" placeholder="Enter vision description">{{ $dream->vision_description }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="mission_description{{ $dream->id }}" class="form-label">Mission Description</label>
                                            <textarea class="form-control" id="mission_description{{ $dream->id }}" name="mission_description" rows="3" placeholder="Enter mission description">{{ $dream->mission_description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="features{{ $dream->id }}" class="form-label">Features <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="features{{ $dream->id }}" name="features" value="{{ $dream->features }}" required onkeyup="updateFeatureImageFieldsEdit('{{ $dream->id }}')">
                                            <small class="text-muted">Separate features with commas (e.g., Tuition, Books, Uniform)</small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Feature Images</label>
                                            <div id="featureImageFields{{ $dream->id }}">
                                                @php
                                                    $features = explode(',', $dream->features);
                                                    $featureImages = json_decode($dream->feature_images, true) ?? [];
                                                @endphp
                                                @foreach($features as $index => $feature)
                                                    @if(trim($feature))
                                                    <div class="mb-2">
                                                        <label class="form-label small">Image for: <strong>{{ trim($feature) }}</strong></label>
                                                        <input type="file" class="form-control" name="feature_images[{{ $index }}]" accept="image/*">
                                                        @if(isset($featureImages[$index]) && file_exists(public_path($featureImages[$index])))
                                                            <div class="mt-1">
                                                                <img src="{{ asset($featureImages[$index]) }}" alt="Feature Image" class="img-thumbnail" style="max-width: 80px; max-height: 60px;">
                                                                <small class="text-muted d-block">Current image</small>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
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
                                <p>Are you sure you want to delete this record?</p>
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
                    <td colspan="5" class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                        <p class="mb-0">No data found. Click "Add Data" to add your first record.</p>
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
                            <input type="text" class="form-control" id="features" name="features" required placeholder="Enter features (comma separated)" onkeyup="updateFeatureImageFields()">
                            <small class="text-muted">Separate features with commas (e.g., Tuition, Books, Uniform)</small>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Feature Images</label>
                            <div id="featureImageFields">
                                <p class="text-muted small">Enter features above to see image upload fields</p>
                            </div>
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

<script>
function updateFeatureImageFields() {
    const featuresInput = document.getElementById('features').value;
    const container = document.getElementById('featureImageFields');
    
    if (!featuresInput.trim()) {
        container.innerHTML = '<p class="text-muted small">Enter features above to see image upload fields</p>';
        return;
    }
    
    const features = featuresInput.split(',').map(f => f.trim()).filter(f => f);
    let html = '';
    
    features.forEach((feature, index) => {
        html += `
            <div class="mb-2">
                <label class="form-label small">Image for: <strong>${feature}</strong></label>
                <input type="file" class="form-control" name="feature_images[${index}]" accept="image/*">
            </div>
        `;
    });
    
    container.innerHTML = html;
}

function updateFeatureImageFieldsEdit(dreamId) {
    const featuresInput = document.getElementById('features' + dreamId).value;
    const container = document.getElementById('featureImageFields' + dreamId);
    
    if (!featuresInput.trim()) {
        container.innerHTML = '<p class="text-muted small">Enter features above to see image upload fields</p>';
        return;
    }
    
    const features = featuresInput.split(',').map(f => f.trim()).filter(f => f);
    let html = '';
    
    features.forEach((feature, index) => {
        html += `
            <div class="mb-2">
                <label class="form-label small">Image for: <strong>${feature}</strong></label>
                <input type="file" class="form-control" name="feature_images[${index}]" accept="image/*">
            </div>
        `;
    });
    
    container.innerHTML = html;
}
</script>

<style>
    /* Reference style from Working Committee */
    .welcome-card {
        background: #fff;
        padding: 0; /* Override to allow table to touch edges */
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
        overflow: hidden; /* Ensures proper rounded corners */
    }

    /* Table styling - Matching Working Committee */
    .table {
        width: 100% !important;
        margin-bottom: 0 !important;
    }
    
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
        border: 1px solid #dee2e6;
        padding: 0;
        background: #f8f9fa;
    }
</style>
@endsection