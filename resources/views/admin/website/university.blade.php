@extends('admin.website.layouts.master')

@section('title', 'University - JitoJeap Admin')

@section('website-content')
<div class="welcome-card w-100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fas fa-university"></i> University Management</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUniversityModal">
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
                    <th width="5%" class="text-center">S.N.</th>
                    <th width="12%">University Type</th>
                    <th width="20%">University Name</th>
                    <th width="12%">Country</th>
                    <th width="10%">State</th>
                    <th width="10%">City</th>
                    <th width="5%">Status</th>
                    <th width="8%" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($universities ?? [] as $index => $university)
                <tr>
                    <td class="text-center align-middle">{{ $index + 1 }}</td>
                    <td class="align-middle">
                        @if($university->university_type == 'domestic')
                            <span class="badge bg-primary">Domestic</span>
                        @else
                            <span class="badge bg-info text-dark">Foreign</span>
                        @endif
                    </td>
                    <td class="align-middle"><strong>{{ $university->university_name ?? 'N/A' }}</strong></td>
                    <td class="align-middle">{{ $university->country ?? 'N/A' }}</td>
                    <td class="align-middle">{{ $university->state ?? 'N/A' }}</td>
                    <td class="align-middle">{{ $university->city ?? 'N/A' }}</td>
                    <td class="text-center align-middle">
                        @if($university->status)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td class="text-center align-middle">
                        <div class="d-flex justify-content-center gap-1">
                            <button class="btn btn-sm btn-info text-white" title="View" data-bs-toggle="modal" data-bs-target="#viewModal{{ $university->id }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $university->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $university->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- View Modal -->
                <div class="modal fade" id="viewModal{{ $university->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $university->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewModalLabel{{ $university->id }}">University Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h6>University Type:</h6>
                                        <p>
                                            @if($university->university_type == 'domestic')
                                                <span class="badge bg-primary">Domestic</span>
                                            @else
                                                <span class="badge bg-info text-dark">Foreign</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>University Name:</h6>
                                        <p>{{ $university->university_name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h6>Country:</h6>
                                        <p>{{ $university->country ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>State:</h6>
                                        <p>{{ $university->state ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h6>City:</h6>
                                        <p>{{ $university->city ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Status:</h6>
                                        <p>
                                            @if($university->status)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h6>Created At:</h6>
                                        <p>{{ $university->created_at->format('d-m-Y H:i:s') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Updated At:</h6>
                                        <p>{{ $university->updated_at->format('d-m-Y H:i:s') }}</p>
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
                <div class="modal fade" id="editModal{{ $university->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $university->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $university->id }}">Edit - {{ $university->university_name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.website.university.update', $university->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="location{{ $university->id }}" class="form-label">Location</label>
                                            <input type="text" class="form-control" id="location{{ $university->id }}" name="location" value="{{ $university->location ?? '' }}" placeholder="Enter location">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="university_name{{ $university->id }}" class="form-label">University Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="university_name{{ $university->id }}" name="university_name" value="{{ $university->university_name }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="university_type{{ $university->id }}" class="form-label">University Type <span class="text-danger">*</span></label>
                                            <select class="form-select" id="university_type{{ $university->id }}" name="university_type" required>
                                                <option value="domestic" {{ $university->university_type == 'domestic' ? 'selected' : '' }}>Domestic</option>
                                                <option value="foreign" {{ $university->university_type == 'foreign' ? 'selected' : '' }}>Foreign</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="country{{ $university->id }}" class="form-label">Country <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="country{{ $university->id }}" name="country" value="{{ $university->country ?? '' }}" required placeholder="Enter country name">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="state{{ $university->id }}" class="form-label">State <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="state{{ $university->id }}" name="state" value="{{ $university->state ?? '' }}" required placeholder="Enter state name">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="city{{ $university->id }}" class="form-label">City <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="city{{ $university->id }}" name="city" value="{{ $university->city ?? '' }}" required placeholder="Enter city name">
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
                <div class="modal fade" id="deleteModal{{ $university->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $university->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $university->id }}">Delete Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete <strong>{{ $university->university_name }}</strong>?</p>
                                <p class="text-danger">This action cannot be undone.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('admin.website.university.delete', $university->id) }}" method="POST" style="display: inline;">
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
                        <i class="fas fa-university fa-2x mb-2"></i>
                        <p>No universities found. Click "Add Data" to add your first record.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Data Modal -->
<div class="modal fade" id="addUniversityModal" tabindex="-1" aria-labelledby="addUniversityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUniversityModalLabel">Add University</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.website.university.store') }}" method="POST" id="addUniversityForm" onsubmit="return prepareFormForSubmit()">
                @csrf
                <div class="modal-body">
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="university_type" class="form-label">University Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="university_type" name="university_type" onchange="toggleUniversityOptions()" required>
                                <option value="">Select University Type</option>
                                <option value="domestic">Domestic</option>
                                <option value="foreign">Foreign</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="university_name_select" class="form-label">University Name <span class="text-danger">*</span></label>
                            <!-- Dropdown dynamically populated -->
                            <select class="form-select" id="university_name_select" name="university_name_select" required>
                                <option value="">Select University Type First</option>
                            </select>
                            <!-- Text input for 'Other' option -->
                            <input type="text" class="form-control mt-2" id="university_name_other" name="university_name_other" placeholder="Enter university name" style="display: none;">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="country" name="country" required placeholder="Enter country name">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="state" name="state" required placeholder="Enter state name">
                        </div>
                        <div class="col-md-6">
                            <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="city" name="city" required placeholder="Enter city name">
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
    // 1. Define University Data Lists
    const domesticUniversities = [
        "IIM", "IIT", "ISB-HYBD", "NMIMS", "VIT", "Bitspilani", "Symbiosis"
    ];

    const foreignUniversities = [
        "MIT", "Imperial College London", "Stanford", "Oxford", "Cambridge"
    ];

    // 2. Function to toggle dropdown options based on Type
    function toggleUniversityOptions() {
        const type = document.getElementById('university_type').value;
        const universitySelect = document.getElementById('university_name_select');
        const universityNameOther = document.getElementById('university_name_other');
        const countryInput = document.getElementById('country');
        
        // Clear current options
        universitySelect.innerHTML = '<option value="">Select University</option>';
        universityNameOther.style.display = 'none';
        universityNameOther.value = '';

        let universities = [];

        if (type === 'domestic') {
            universities = domesticUniversities;
            // Auto-fill country for domestic
            countryInput.value = 'India';
        } else if (type === 'foreign') {
            universities = foreignUniversities;
            // Clear country for foreign
            countryInput.value = '';
        } else {
            universitySelect.innerHTML = '<option value="">Select University Type First</option>';
            return;
        }

        // Populate the dropdown dynamically
        universities.forEach(function(uni) {
            const option = document.createElement('option');
            option.value = uni;
            option.textContent = uni;
            universitySelect.appendChild(option);
        });

        // Add "Other" option for Foreign type
        if (type === 'foreign') {
            const otherOption = document.createElement('option');
            otherOption.value = 'other';
            otherOption.textContent = 'Other (Enter Manually)';
            universitySelect.appendChild(otherOption);
        }
    }

    // 3. Handle selection of "Other" to show text input
    document.getElementById('university_name_select').addEventListener('change', function() {
        const universityNameOther = document.getElementById('university_name_other');
        if (this.value === 'other') {
            universityNameOther.style.display = 'block';
            universityNameOther.setAttribute('required', 'required');
        } else {
            universityNameOther.style.display = 'none';
            universityNameOther.removeAttribute('required');
            universityNameOther.value = '';
        }
    });

    // 4. Handle Form Submission to ensure correct name is sent to Controller
    function prepareFormForSubmit() {
        const universitySelect = document.getElementById('university_name_select');
        const universityNameOther = document.getElementById('university_name_other');
        const form = document.getElementById('addUniversityForm');

        // If "Other" is selected, use the text input value
        if (universitySelect.value === 'other') {
            if (!universityNameOther.value.trim()) {
                alert('Please enter the university name');
                return false;
            }
            
            // Remove name from select so it doesn't send "other"
            universitySelect.removeAttribute('name');
            
            // Create a hidden input with the correct name 'university_name'
            let hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'university_name';
            hiddenInput.value = universityNameOther.value;
            form.appendChild(hiddenInput);
        } else {
            // If a standard option is selected, ensure the select has the correct name
            universitySelect.setAttribute('name', 'university_name');
        }

        return true;
    }

    // 5. Reset form when modal closes to ensure clean state
    document.getElementById('addUniversityModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('addUniversityForm').reset();
        document.getElementById('university_name_select').innerHTML = '<option value="">Select University Type First</option>';
        document.getElementById('university_name_other').style.display = 'none';
    });
</script>

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