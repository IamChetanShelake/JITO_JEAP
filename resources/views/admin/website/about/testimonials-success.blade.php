@extends('admin.website.layouts.master')

@section('title', 'Testimonials / Success Story - JitoJeap Admin')

@section('website-content')
{{-- Added p-0 class to remove padding so table touches edges --}}
<div class="welcome-card w-100 p-0">
    
    {{-- Added padding p-3 specifically to the header section --}}
    <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
        <h3 class="mb-0"><i class="fas fa-star"></i> Our Testimonials / Success Story</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTestimonialModal">
            <i class="fas fa-plus"></i> Add Testimonial
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
                    <th width="5%" class="text-center">Sr. No.</th>
                    <th width="10%" class="text-center">Image</th>
                    <th width="12%">Title</th>
                    <th width="12%">Name</th>
                    <th width="25%">Feedback</th>
                    <th width="10%">Date</th>
                    <th width="8%">Order</th>
                    
                    <th width="10%" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($testimonials ?? [] as $index => $testimonial)
                <tr>
                    <td class="text-center align-middle">{{ $index + 1 }}</td>
                    <td class="text-center align-middle">
                        @if(!empty($testimonial->image))
                            <img src="{{ asset($testimonial->image) }}" alt="{{ $testimonial->name ?? 'Image' }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                        @else
                            <div style="width: 50px; height: 50px; background: #f0f0f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-user text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td class="align-middle"><strong>{{ $testimonial->title ?? 'N/A' }}</strong></td>
                    <td class="align-middle">{{ $testimonial->name ?? 'N/A' }}</td>
                    <td class="align-middle">
                        <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ Str::limit($testimonial->feedback ?? 'No feedback', 80) }}
                        </div>
                    </td>
                    <td class="align-middle">{{ $testimonial->date ? \Carbon\Carbon::parse($testimonial->date)->format('d-m-Y') : 'N/A' }}</td>
                    <td class="text-center align-middle">{{ $testimonial->display_order ?? 0 }}</td>
                   
                    <td class="text-center align-middle">
                        <div class="d-flex justify-content-center gap-1">
                            <button class="btn btn-sm btn-info text-white" title="View" data-bs-toggle="modal" data-bs-target="#viewModal{{ $testimonial->id }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $testimonial->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $testimonial->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- View Modal -->
                <div class="modal fade" id="viewModal{{ $testimonial->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $testimonial->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewModalLabel{{ $testimonial->id }}">Testimonial Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center mb-4">
                                    @if(!empty($testimonial->image))
                                        <img src="{{ asset($testimonial->image) }}" alt="{{ $testimonial->name }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                                    @else
                                        <div style="width: 100px; height: 100px; background: #f0f0f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                            <i class="fas fa-user text-muted" style="font-size: 40px;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong>Name:</strong> {{ $testimonial->name ?? 'N/A' }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Date:</strong> {{ $testimonial->date ? \Carbon\Carbon::parse($testimonial->date)->format('d-m-Y') : 'N/A' }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <strong>Title:</strong> {{ $testimonial->title ?? 'N/A' }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <strong>About:</strong>
                                        <p>{{ $testimonial->about ?? 'No about information' }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <strong>Feedback:</strong>
                                        <p class="fst-italic">"{{ $testimonial->feedback ?? 'No feedback' }}"</p>
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
                <div class="modal fade" id="editModal{{ $testimonial->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $testimonial->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $testimonial->id }}">Edit - {{ $testimonial->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.website.about.testimonials-success.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="image{{ $testimonial->id }}" class="form-label">Image</label>
                                            <input type="file" class="form-control" id="image{{ $testimonial->id }}" name="image" accept="image/*">
                                            <small class="text-muted">Leave empty to keep current image.</small>
                                            @if(!empty($testimonial->image))
                                                <div class="mt-2">
                                                    <img src="{{ asset($testimonial->image) }}" alt="Current" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="title{{ $testimonial->id }}" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="title{{ $testimonial->id }}" name="title" value="{{ $testimonial->title ?? '' }}" placeholder="Enter title">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name{{ $testimonial->id }}" class="form-label">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name{{ $testimonial->id }}" name="name" value="{{ $testimonial->name ?? '' }}" required placeholder="Enter name">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="display_order{{ $testimonial->id }}" class="form-label">Display Order</label>
                                            <input type="number" class="form-control" id="display_order{{ $testimonial->id }}" name="display_order" value="{{ $testimonial->display_order ?? 0 }}" min="0">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="date{{ $testimonial->id }}" class="form-label">Date</label>
                                            <input type="date" class="form-control" id="date{{ $testimonial->id }}" name="date" value="{{ $testimonial->date ? $testimonial->date->format('Y-m-d') : '' }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="feedback{{ $testimonial->id }}" class="form-label">Feedback <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="feedback{{ $testimonial->id }}" name="feedback" rows="3" required placeholder="Enter feedback">{{ $testimonial->feedback ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update Testimonial</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal{{ $testimonial->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $testimonial->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $testimonial->id }}">Delete Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete the testimonial from <strong>{{ $testimonial->name ?? 'N/A' }}</strong>?</p>
                                <p class="text-danger">This action cannot be undone.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('admin.website.about.testimonials-success.delete', $testimonial->id) }}" method="POST" style="display: inline;">
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
                    <td colspan="9" class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                        <p class="mb-0">No testimonials found. Click "Add Testimonial" to add your first record.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Testimonial Modal -->
<div class="modal fade" id="addTestimonialModal" tabindex="-1" aria-labelledby="addTestimonialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTestimonialModalLabel">Add Testimonial</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.website.about.testimonials-success.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="testimonial">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
                        </div>
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required placeholder="Enter name">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="display_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control" id="display_order" name="display_order" value="0" min="0">
                        </div>
                        <div class="col-md-6">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="feedback" class="form-label">Feedback <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="feedback" name="feedback" rows="3" required placeholder="Enter feedback"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Testimonial</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Reference style from previous fixes */
    .welcome-card {
        background: #fff;
        padding: 0; /* Override default padding */
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
        overflow: hidden; /* Ensures proper rounded corners */
    }

    /* Table styling - Matching previous fixes */
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
</style>
@endsection
