@extends('admin.website.layouts.master')

@section('title', 'Key Instruction - JitoJeap Admin')

@section('website-content')
{{-- Removed m-3 and p-3 to match Empowering Dreams structure --}}
<div class="welcome-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fas fa-info-circle"></i> Key Instructions</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKeyInstructionModal">
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
        <!-- Added table-layout: fixed; and width: 100%; to force full width -->
        <table class="table table-hover table-bordered" style="width: 100%; table-layout: fixed;">
            <thead class="table-light">
                <tr>
                    <!-- Adjusted widths to sum 100% -->
                    <th width="5%" class="text-center">Sr. No.</th>
                    <th width="10%">Icon</th>
                    <th width="15%">Title</th>
                    <th width="35%">Description</th>
                    <th width="10%">Color</th>
                    <th width="10%">Order</th>
                    <th width="15%" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($keyInstructions ?? [] as $index => $instruction)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">
                        @if(!empty($instruction->icon_image))
                            <img src="{{ asset($instruction->icon_image) }}" alt="Icon" style="width: 40px; height: 40px; object-fit: contain; background: {{ $instruction->color ?? '#000' }}; border-radius: 50%;">
                        @elseif(!empty($instruction->icon_svg))
                            <div class="icon-preview" style="width: 40px; height: 40px; margin: 0 auto; display: flex; align-items: center; justify-content: center; background: {{ $instruction->color ?? '#000' }}; border-radius: 50%;">
                                {!! $instruction->icon_svg !!}
                            </div>
                        @else
                            <div class="icon-preview" style="width: 40px; height: 40px; margin: 0 auto; display: flex; align-items: center; justify-content: center; background: {{ $instruction->color ?? '#000' }}; border-radius: 50%;">
                                <i class="fas fa-{{ $instruction->icon ?? 'info' }}" style="color: white;"></i>
                            </div>
                        @endif
                    </td>
                    <td><strong>{{ $instruction->title ?? 'N/A' }}</strong></td>
                    <td>{{ Str::limit($instruction->description ?? 'No description', 100) }}</td>
                    <td>
                        <span class="badge" style="background-color: {{ $instruction->color ?? '#000' }}; color: white;">
                            {{ $instruction->color ?? 'Default' }}
                        </span>
                    </td>
                    <td>{{ $instruction->display_order ?? 0 }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-info text-white" title="View" data-bs-toggle="modal" data-bs-target="#viewModal{{ $instruction->id ?? $index }}">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $instruction->id ?? $index }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $instruction->id ?? $index }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                
                <!-- View Modal -->
                <div class="modal fade" id="viewModal{{ $instruction->id ?? $index }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $instruction->id ?? $index }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewModalLabel{{ $instruction->id ?? $index }}">{{ $instruction->title ?? 'N/A' }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center mb-3">
                                    @if(!empty($instruction->icon_image))
                                        <img src="{{ asset($instruction->icon_image) }}" alt="Icon" style="width: 80px; height: 80px; object-fit: contain; background: {{ $instruction->color ?? '#000' }}; border-radius: 50%;">
                                    @elseif(!empty($instruction->icon_svg))
                                        <div class="icon-preview" style="width: 80px; height: 80px; margin: 0 auto; display: flex; align-items: center; justify-content: center; background: {{ $instruction->color ?? '#000' }}; border-radius: 50%;">
                                            {!! $instruction->icon_svg !!}
                                        </div>
                                    @else
                                        <div class="icon-preview" style="width: 80px; height: 80px; margin: 0 auto; display: flex; align-items: center; justify-content: center; background: {{ $instruction->color ?? '#000' }}; border-radius: 50%;">
                                            <i class="fas fa-{{ $instruction->icon ?? 'info' }}" style="color: white; font-size: 30px;"></i>
                                        </div>
                                    @endif
                                </div>
                                <h6>Description:</h6>
                                <p>{{ $instruction->description ?? 'No description' }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Edit Modal -->
                <div class="modal fade" id="editModal{{ $instruction->id ?? $index }}" tabindex="-1" aria-labelledby="editModalLabel{{ $instruction->id ?? $index }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $instruction->id ?? $index }}">Edit - {{ $instruction->title ?? 'N/A' }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.website.home.key-instructions.update', $instruction->id ?? 0) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="icon{{ $instruction->id ?? $index }}" class="form-label">Icon (Image or SVG)</label>
                                            <input type="file" class="form-control" id="icon{{ $instruction->id ?? $index }}" name="icon" accept=".png,.jpg,.jpeg,.gif,.webp,.svg,.xml">
                                            <small class="text-muted">Upload image (PNG, JPG, JPEG, GIF, WebP) or SVG file. Leave empty to keep current icon.</small>
                                            @if(!empty($instruction->icon_image))
                                                <div class="mt-2">
                                                    <label class="form-label">Current Icon (Image):</label><br>
                                                    <img src="{{ asset($instruction->icon_image) }}" alt="Icon" style="width: 50px; height: 50px; object-fit: contain; background: {{ $instruction->color ?? '#000' }}; border-radius: 50%;">
                                                </div>
                                            @elseif(!empty($instruction->icon_svg))
                                                <div class="mt-2">
                                                    <label class="form-label">Current Icon (SVG):</label>
                                                    <div style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: {{ $instruction->color ?? '#000' }}; border-radius: 50%;">
                                                        {!! $instruction->icon_svg !!}
                                                    </div>
                                                </div>
                                                <input type="hidden" name="existing_icon_svg" value="{{ $instruction->icon_svg }}">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="title{{ $instruction->id ?? $index }}" class="form-label">Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="title{{ $instruction->id ?? $index }}" name="title" value="{{ $instruction->title ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="description{{ $instruction->id ?? $index }}" class="form-label">Description <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="description{{ $instruction->id ?? $index }}" name="description" rows="3" required>{{ $instruction->description ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="color{{ $instruction->id ?? $index }}" class="form-label">Color <span class="text-danger">*</span></label>
                                            <select class="form-select" id="color{{ $instruction->id ?? $index }}" name="color" required>
                                                <option value="#00008B" {{ ($instruction->color ?? '') == '#00008B' ? 'selected' : '' }}>Blue</option>
                                                <option value="#009846" {{ ($instruction->color ?? '') == '#009846' ? 'selected' : '' }}>Green</option>
                                                <option value="#FFD800" {{ ($instruction->color ?? '') == '#FFD800' ? 'selected' : '' }}>Yellow</option>
                                                <option value="#E31E25" {{ ($instruction->color ?? '') == '#E31E25' ? 'selected' : '' }}>Red</option>
                                                <option value="#393186" {{ ($instruction->color ?? '') == '#393186' ? 'selected' : '' }}>Purple</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="display_order{{ $instruction->id ?? $index }}" class="form-label">Display Order</label>
                                            <input type="number" class="form-control" id="display_order{{ $instruction->id ?? $index }}" name="display_order" value="{{ $instruction->display_order ?? 0 }}" min="0">
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
                <div class="modal fade" id="deleteModal{{ $instruction->id ?? $index }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $instruction->id ?? $index }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $instruction->id ?? $index }}">Delete Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete <strong>{{ $instruction->title ?? 'N/A' }}</strong>?</p>
                                <p class="text-danger">This action cannot be undone.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('admin.website.home.key-instructions.delete', $instruction->id ?? 0) }}" method="POST" style="display: inline;">
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
<div class="modal fade" id="addKeyInstructionModal" tabindex="-1" aria-labelledby="addKeyInstructionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKeyInstructionModalLabel">Add Key Instruction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.website.home.key-instructions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="file" class="form-label">Icon (Image or SVG)</label>
                            <input type="file" class="form-control" id="icon" name="icon" accept=".png,.jpg,.jpeg,.gif,.webp,.svg,.xml">
                            <small class="text-muted">Upload an image (PNG, JPG, JPEG, GIF, WebP) or SVG file. If not uploaded, a default icon will be used.</small>
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
                            <label for="color" class="form-label">Color <span class="text-danger">*</span></label>
                            <select class="form-select" id="color" name="color" required>
                                <option value="#00008B">Blue</option>
                                <option value="#009846">Green</option>
                                <option value="#FFD800">Yellow</option>
                                <option value="#E31E25">Red</option>
                                <option value="#393186">Purple</option>
                            </select>
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
    .icon-preview {
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
</style>
@endsection