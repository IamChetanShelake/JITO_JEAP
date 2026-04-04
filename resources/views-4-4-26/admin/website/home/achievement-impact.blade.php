@extends('admin.website.layouts.master')

@section('title', 'Achievement & Impact - JitoJeap Admin')

@section('website-content')
{{-- Added p-0 class to remove padding so table touches edges --}}
<div class="welcome-card w-100 p-0">
    
    {{-- Added padding p-3 specifically to the header section --}}
    <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
        <h3 class="mb-0"><i class="fas fa-trophy"></i> Achievement & Impact</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
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
                    <th width="5%" class="text-center">Sr. No.</th>
                    <th width="35%">Description</th>
                    <th width="15%" class="text-center">Image</th>
                    <th width="30%">Numbers</th>
                    <th width="15%" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($achievementImpacts as $index => $impact)
                <tr>
                    <td class="text-center align-middle">{{ $index + 1 }}</td>
                    <td class="align-middle">{{ Str::limit($impact->description, 80) }}</td>
                    <td class="text-center align-middle">
                        @if($impact->image && file_exists(public_path($impact->image)))
                            <img src="{{ asset($impact->image) }}" alt="Image" class="img-thumbnail p-0" style="max-width: 60px; height: 60px; object-fit: cover;">
                        @else
                            <span class="text-muted small">No Image</span>
                        @endif
                    </td>
                    <td class="align-middle">
                        @php
                            $numbers = json_decode($impact->numbers, true) ?? [];
                            $numberTexts = json_decode($impact->number_texts, true) ?? [];
                        @endphp
                        <div class="d-flex flex-wrap gap-1">
                            @if(count($numbers) > 0)
                                @foreach($numbers as $idx => $number)
                                    <span class="badge bg-primary">{{ $number }}
                                        @if(isset($numberTexts[$idx]))
                                            <small>{{ $numberTexts[$idx] }}</small>
                                        @endif
                                    </span>
                                @endforeach
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </td>
                    <td class="text-center align-middle">
                        <div class="d-flex justify-content-center gap-1">
                            <button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#viewModal{{ $impact->id }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $impact->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $impact->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- View Modal -->
                <div class="modal fade" id="viewModal{{ $impact->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $impact->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewModalLabel{{ $impact->id }}">Achievement & Impact Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        @if($impact->image && file_exists(public_path($impact->image)))
                                            <img src="{{ asset($impact->image) }}" alt="Achievement" class="img-fluid rounded w-100">
                                        @else
                                            <img src="https://via.placeholder.com/300x200?text=No+Image" alt="No Image" class="img-fluid rounded w-100">
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <h6>Description:</h6>
                                        <p>{{ $impact->description }}</p>
                                        <h6 class="mt-3">Numbers:</h6>
                                        <div>
                                            @php
                                                $numbers = json_decode($impact->numbers, true) ?? [];
                                                $numberTexts = json_decode($impact->number_texts, true) ?? [];
                                            @endphp
                                            @if(count($numbers) > 0)
                                                @foreach($numbers as $idx => $number)
                                                    <div class="badge bg-primary me-1 mb-2 p-2">
                                                        <strong>{{ $number }}</strong>
                                                        @if(isset($numberTexts[$idx]))
                                                            <br><small>{{ $numberTexts[$idx] }}</small>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @else
                                                No Numbers
                                            @endif
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
                <div class="modal fade" id="editModal{{ $impact->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $impact->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg" style="max-height: 90vh;">
                        <div class="modal-content" style="max-height: 90vh; display: flex; flex-direction: column;">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $impact->id }}">Edit Achievement & Impact</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.website.home.achievement-impact.update', $impact->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body" style="overflow-y: auto;">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name="description" rows="3">{{ $impact->description }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Image</label>
                                        <input type="file" class="form-control" name="image" accept="image/*">
                                        @if($impact->image && file_exists(public_path($impact->image)))
                                            <img src="{{ asset($impact->image) }}" class="img-thumbnail mt-2" style="max-width: 100px;">
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Numbers & Texts</label>
                                        <div id="editNumbersContainer{{ $impact->id }}">
                                            @php
                                                $editNumbers = json_decode($impact->numbers, true) ?? [];
                                                $editNumberTexts = json_decode($impact->number_texts, true) ?? [];
                                            @endphp
                                            @if(count($editNumbers) > 0)
                                                @foreach($editNumbers as $idx => $number)
                                                    <div class="row mb-2">
                                                        <div class="col-5">
                                                            <input type="text" class="form-control" name="numbers[]" value="{{ $number }}" placeholder="Number">
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="text" class="form-control" name="number_texts[]" value="{{ $editNumberTexts[$idx] ?? '' }}" placeholder="Text">
                                                        </div>
                                                        <div class="col-1">
                                                            <button type="button" class="btn btn-danger remove-edit-number">X</button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-secondary btn-sm mt-2" id="addEditNumberBtn{{ $impact->id }}" data-id="{{ $impact->id }}">+ Add Number</button>
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
                <div class="modal fade" id="deleteModal{{ $impact->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $impact->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $impact->id }}">Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this record?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('admin.website.home.achievement-impact.delete', $impact->id) }}" method="POST">
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

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add Achievement & Impact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.website.home.achievement-impact.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Enter description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Numbers & Texts</label>
                        <div id="addNumbersContainer">
                            <div class="row mb-2">
                                <div class="col-5">
                                    <input type="text" class="form-control" name="numbers[]" placeholder="Number (e.g., 250+)">
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" name="number_texts[]" placeholder="Text (e.g., Donors)">
                                </div>
                                <div class="col-1">
                                    <button type="button" class="btn btn-danger remove-number">X</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm mt-2" id="addNumberBtn">+ Add Number</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('addNumberBtn').addEventListener('click', function() {
        const container = document.getElementById('addNumbersContainer');
        const newRow = document.createElement('div');
        newRow.className = 'row mb-2';
        newRow.innerHTML = `
            <div class="col-5">
                <input type="text" class="form-control" name="numbers[]" placeholder="Number">
            </div>
            <div class="col-6">
                <input type="text" class="form-control" name="number_texts[]" placeholder="Text">
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-danger remove-number">X</button>
            </div>
        `;
        container.appendChild(newRow);
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-number')) {
            e.target.closest('.row').remove();
        }
    });

    // Handle edit modal add number button
    document.addEventListener('click', function(e) {
        if (e.target && e.target.id && e.target.id.startsWith('addEditNumberBtn')) {
            const id = e.target.getAttribute('data-id');
            addEditNumberField(id);
        }
    });

    function addEditNumberField(id) {
        const container = document.getElementById('editNumbersContainer' + id);
        if (!container) {
            console.error('Container not found: editNumbersContainer' + id);
            return;
        }
        const newRow = document.createElement('div');
        newRow.className = 'row mb-2';
        newRow.innerHTML = `
            <div class="col-5">
                <input type="text" class="form-control" name="numbers[]" placeholder="Number">
            </div>
            <div class="col-6">
                <input type="text" class="form-control" name="number_texts[]" placeholder="Text">
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-danger remove-edit-number">X</button>
            </div>
        `;
        container.appendChild(newRow);
    }

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-edit-number')) {
            e.target.closest('.row').remove();
        }
    });
</script>

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