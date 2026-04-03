@extends('admin.website.layouts.master')

@section('title', 'Photo Gallery - JitoJeap Admin')

@section('website-content')
<div class="welcome-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fas fa-images"></i> Photo Gallery</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus"></i> Add Photos
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
                    <th width="60%">Images</th>
                    <th width="35%" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($photoGalleries as $index => $gallery)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        @php
                            $images = $gallery->images ?? [];
                            if (is_string($images)) {
                                $images = json_decode($images, true) ?? [];
                            }
                        @endphp
                        @if(count($images) > 0)
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($images as $img)
                                    @if(file_exists(public_path($img)))
                                        <img src="{{ asset($img) }}" alt="Gallery" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                    @endif
                                @endforeach
                            </div>
                            <small class="text-muted">{{ count($images) }} photo(s)</small>
                        @else
                            No Images
                        @endif
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal{{ $gallery->id }}">
                            <i class="fas fa-eye"></i> View
                        </button>
                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $gallery->id }}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $gallery->id }}">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </td>
                </tr>
                
                <!-- View Modal -->
                <div class="modal fade" id="viewModal{{ $gallery->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $gallery->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewModalLabel{{ $gallery->id }}">Photo Gallery</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    @php
                                        $images = $gallery->images ?? [];
                                        if (is_string($images)) {
                                            $images = json_decode($images, true) ?? [];
                                        }
                                    @endphp
                                    @foreach($images as $img)
                                        @if(file_exists(public_path($img)))
                                            <div class="col-md-4 mb-3">
                                                <img src="{{ asset($img) }}" alt="Gallery" class="img-fluid rounded" style="max-height: 200px; width: 100%; object-fit: cover;">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal{{ $gallery->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $gallery->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $gallery->id }}">Edit Photos</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.website.home.photo-gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Add New Images</label>
                                        <input type="file" class="form-control" name="images[]" accept="image/*" multiple>
                                        <small class="text-muted">Select multiple images to add new photos</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Current Photos <span class="text-muted">(Click X to remove)</span></label>
                                        <div class="d-flex flex-wrap gap-2">
                                            @php
                                                $images = json_decode($gallery->images, true) ?? [];
                                            @endphp
                                            @foreach($images as $imgKey => $img)
                                                @if(file_exists(public_path($img)))
                                                    <div class="position-relative" style="width: 80px; height: 80px;">
                                                        <img src="{{ asset($img) }}" alt="Gallery" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                                        <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: -5px; right: -5px; padding: 2px 6px; font-size: 10px;" onclick="removeImage{{ $gallery->id }}('{{ $img }}', event)">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="removed_images" id="removed_images{{ $gallery->id }}" value="">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update Photos</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                function removeImage{{ $gallery->id }}(imagePath, event) {
                    var removedInput = document.getElementById('removed_images{{ $gallery->id }}');
                    var currentRemoved = removedInput.value ? JSON.parse(removedInput.value) : [];
                    currentRemoved.push(imagePath);
                    removedInput.value = JSON.stringify(currentRemoved);
                    
                    event.target.closest('.position-relative').style.display = 'none';
                }
                </script>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal{{ $gallery->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $gallery->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $gallery->id }}">Delete Photos</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Delete these photos?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('admin.website.home.photo-gallery.delete', $gallery->id) }}" method="POST">
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
                    <td colspan="3" class="text-center">No photos found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add Photos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.website.home.photo-gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Images</label>
                        <input type="file" class="form-control" name="images[]" accept="image/*" multiple required>
                        <small class="text-muted">You can select multiple images at once</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload Photos</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
