@extends('admin.website.layouts.master')

@section('title', 'Jito - JitoJeap Admin')

@section('website-content')
<div class="welcome-card w-100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fas fa-info-circle"></i> Jito</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addJitoModal">
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
                    <th width="15%">Title</th>
                    <th width="40%">Paragraphs</th>
                    <th width="20%">Order</th>
                    
                    <th width="15%" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items ?? [] as $item)
                <tr>
                    <td class="align-middle">{{ $item->title ?? 'Untitled' }}</td>
                    <td class="align-middle">
                        <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 300px;">
                            @foreach(($item->paragraphs ?? []) as $paragraph)
                                <p style="margin: 0;">{{ Str::limit($paragraph, 120) }}</p>
                            @endforeach
                        </div>
                    </td>
                    <td class="text-center align-middle">{{ $item->display_order ?? 0 }}</td>
                   
                    <td class="text-center align-middle">
                        <button class="btn btn-sm btn-info text-white" title="View" data-bs-toggle="modal" data-bs-target="#viewModal{{ $item->id }}">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>

                <!-- View Modal -->
                <div class="modal fade" id="viewModal{{ $item->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewModalLabel{{ $item->id }}">{{ $item->title ?? 'Untitled' }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if($item->image)
                                <div class="text-center mb-4">
                                    <img src="{{ asset($item->image) }}" alt="{{ $item->title ?? 'Jito' }}" style="max-width: 100%; height: auto; border-radius: 10px;">
                                </div>
                                @endif

                                @foreach(($item->paragraphs ?? []) as $paragraph)
                                    <p>{{ $paragraph }}</p>
                                @endforeach

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <strong>Display Order:</strong> {{ $item->display_order ?? 0 }}
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
                <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit - {{ $item->title ?? 'Untitled' }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.website.about.jito.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="title{{ $item->id }}" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="title{{ $item->id }}" name="title" value="{{ $item->title }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Paragraphs</label>
                                            <div class="paragraphs-container" id="paragraphsContainer{{ $item->id }}">
                                                @foreach(($item->paragraphs ?? []) as $index => $paragraph)
                                                <div class="input-group mb-2 paragraph-row">
                                                    <textarea class="form-control" name="paragraphs[]" rows="3" required>{{ $paragraph }}</textarea>
                                                    <button type="button" class="btn btn-outline-danger btn-sm ms-2 remove-paragraph-btn" title="Delete paragraph">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="btn btn-sm btn-secondary" onclick="addParagraphField('paragraphsContainer{{ $item->id }}')">
                                                <i class="fas fa-plus"></i> Add paragraph
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="image{{ $item->id }}" class="form-label">Image</label>
                                            <input type="file" class="form-control" id="image{{ $item->id }}" name="image" accept="image/*">
                                            <small class="text-muted">Leave empty to keep current image.</small>
                                            @if($item->image)
                                                <div class="mt-2">
                                                    <img src="{{ asset($item->image) }}" alt="Current" class="img-thumbnail" style="max-width: 150px;">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="number{{ $item->id }}" class="form-label">Number</label>
                                            <input type="text" class="form-control" id="number{{ $item->id }}" name="number" value="{{ $item->number ?? '' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="stat_text{{ $item->id }}" class="form-label">Stat Text</label>
                                            <input type="text" class="form-control" id="stat_text{{ $item->id }}" name="stat_text" value="{{ $item->stat_text ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="display_order{{ $item->id }}" class="form-label">Display Order</label>
                                            <input type="number" class="form-control" id="display_order{{ $item->id }}" name="display_order" value="{{ $item->display_order ?? 0 }}" min="0">
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
                <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Delete Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete <strong>{{ $item->title ?? 'this item' }}</strong>?</p>
                                <p class="text-danger">This action cannot be undone.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('admin.website.about.jito.delete', $item->id) }}" method="POST" style="display: inline;">
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
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-2"></i>
                        <p>No data found. Click "Add Data" to add your first record.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Jito Modal -->
<div class="modal fade" id="addJitoModal" tabindex="-1" aria-labelledby="addJitoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addJitoModalLabel">Add Jito About Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.website.about.jito.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Paragraphs</label>
                            <div class="paragraphs-container" id="paragraphsContainerAdd">
                                <div class="input-group mb-2 paragraph-row">
                                    <textarea class="form-control" name="paragraphs[]" rows="3" placeholder="Enter paragraph text"></textarea>
                                    <button type="button" class="btn btn-outline-danger btn-sm ms-2 remove-paragraph-btn" title="Delete paragraph">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-secondary" onclick="addParagraphField('paragraphsContainerAdd')">
                                <i class="fas fa-plus"></i> Add paragraph
                            </button>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="number" class="form-label">Number</label>
                            <input type="text" class="form-control" id="number" name="number">
                        </div>
                        <div class="col-md-6">
                            <label for="stat_text" class="form-label">Stat Text</label>
                            <input type="text" class="form-control" id="stat_text" name="stat_text">
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

<script>
    // Add Paragraph Field
    function addParagraphField(containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;

        const wrapper = document.createElement('div');
        wrapper.className = 'input-group mb-2 paragraph-row';

        const textarea = document.createElement('textarea');
        textarea.className = 'form-control';
        textarea.name = 'paragraphs[]';
        textarea.rows = 3;
        textarea.placeholder = 'Enter paragraph text';

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'btn btn-outline-danger btn-sm ms-2 remove-paragraph-btn';
        btn.title = 'Delete paragraph';
        btn.innerHTML = '<i class="fas fa-trash"></i>';
        btn.addEventListener('click', function() {
            wrapper.remove();
        });

        wrapper.appendChild(textarea);
        wrapper.appendChild(btn);
        container.appendChild(wrapper);
    }

    // Global listener for removing paragraphs
    document.addEventListener('click', function(event) {
        if (event.target.closest('.remove-paragraph-btn')) {
            const wrapper = event.target.closest('.paragraph-row');
            if (wrapper) wrapper.remove();
        }
    });
</script>

    <!-- Stats Management Section -->
    <div class="welcome-card w-100 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3><i class="fas fa-chart-bar"></i> Jito Statistics</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStatModal">
                <i class="fas fa-plus"></i> Add Stat
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="width: 100%;">
                <thead class="table-light">
                    <tr>
                        <th width="15%">Order</th>
                        <th width="25%">Number</th>
                        <th width="25%">Text</th>
                        
                        <th width="20%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stats ?? [] as $stat)
                    <tr>
                        <td class="align-middle text-center">{{ $stat->display_order ?? 0 }}</td>
                        <td class="align-middle"><strong>{{ $stat->number }}</strong></td>
                        <td class="align-middle">{{ $stat->text }}</td>
                        
                        <td class="text-center align-middle">
                            <button class="btn btn-sm btn-info text-white" title="View" data-bs-toggle="modal" data-bs-target="#viewStatModal{{ $stat->id }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#editStatModal{{ $stat->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteStatModal{{ $stat->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- View Stat Modal -->
                    <div class="modal fade" id="viewStatModal{{ $stat->id }}" tabindex="-1" aria-labelledby="viewStatModalLabel{{ $stat->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewStatModalLabel{{ $stat->id }}">Stat Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <strong>Number:</strong> {{ $stat->number }}
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <strong>Text:</strong> {{ $stat->text }}
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <strong>Display Order:</strong> {{ $stat->display_order }}
                                        </div>
                                      
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Stat Modal -->
                    <div class="modal fade" id="editStatModal{{ $stat->id }}" tabindex="-1" aria-labelledby="editStatModalLabel{{ $stat->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editStatModalLabel{{ $stat->id }}">Edit Stat</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.website.about.jito.stats.update', $stat->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="number{{ $stat->id }}" class="form-label">Number</label>
                                                <input type="text" class="form-control" id="number{{ $stat->id }}" name="number" value="{{ $stat->number }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="text{{ $stat->id }}" class="form-label">Text</label>
                                                <input type="text" class="form-control" id="text{{ $stat->id }}" name="text" value="{{ $stat->text }}" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="display_order{{ $stat->id }}" class="form-label">Display Order</label>
                                                <input type="number" class="form-control" id="display_order{{ $stat->id }}" name="display_order" value="{{ $stat->display_order }}" min="0">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Update Stat</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Stat Modal -->
                    <div class="modal fade" id="deleteStatModal{{ $stat->id }}" tabindex="-1" aria-labelledby="deleteStatModalLabel{{ $stat->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteStatModalLabel{{ $stat->id }}">Delete Confirmation</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this stat?</p>
                                    <p><strong>{{ $stat->number }} - {{ $stat->text }}</strong></p>
                                    <p class="text-danger">This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('admin.website.about.jito.stats.delete', $stat->id) }}" method="POST" style="display: inline;">
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
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="fas fa-chart-bar fa-2x mb-2"></i>
                            <p>No stats found. Click "Add Stat" to add your first stat.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Stat Modal -->
    <div class="modal fade" id="addStatModal" tabindex="-1" aria-labelledby="addStatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStatModalLabel">Add New Stat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.website.about.jito.stats.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="number" class="form-label">Number</label>
                                <input type="text" class="form-control" id="number" name="number" placeholder="e.g. 78" required>
                            </div>
                            <div class="col-md-6">
                                <label for="text" class="form-label">Text</label>
                                <input type="text" class="form-control" id="text" name="text" placeholder="e.g. Chapters" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="display_order" class="form-label">Display Order</label>
                                <input type="number" class="form-control" id="display_order" name="display_order" placeholder="0" min="0">
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Stat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection