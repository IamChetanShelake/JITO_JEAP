@extends('admin.website.layouts.master')

@section('title', 'College - JitoJeap Admin')

@section('website-content')
<div class="welcome-card w-100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fas fa-graduation-cap"></i> College Management</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCollegeModal">
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
                    <th width="10%">College Type</th>
                    <th width="18%">College Name</th>
                    
                    <th width="12%">University</th>
                   
                    <th width="8%">State</th>
                   
                    <th width="20%">Courses</th>
                   
                    <th width="8%" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($colleges ?? [] as $index => $college)
                <tr>
                    <td class="text-center align-middle">{{ $index + 1 }}</td>
                    
                    <td class="align-middle">
                        @if($college->college_type == 'domestic')
                            <span class="badge bg-primary">Domestic</span>
                        @else
                            <span class="badge bg-info text-dark">Foreign</span>
                        @endif
                    </td>
                    <td class="align-middle"><strong>{{ $college->college_name ?? 'N/A' }}</strong></td>
                    <td class="align-middle">{{ $college->university_name ?? 'N/A' }}</td>
                    
                   
                    <td class="align-middle">{{ $college->state ?? 'N/A' }}</td>
                    
                    <td class="align-middle">
                        @php
                            $collegeCourses = is_array($college->courses) ? $college->courses : json_decode($college->courses, true);
                        @endphp
                        @if($collegeCourses && is_array($collegeCourses) && count($collegeCourses) > 0)
                            @foreach($collegeCourses as $course)
                                <span class="badge bg-secondary me-1 mb-1">{{ $course }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    
                    <td class="text-center align-middle">
                        <div class="d-flex justify-content-center gap-1">
                            <button class="btn btn-sm btn-info text-white" title="View" data-bs-toggle="modal" data-bs-target="#viewModal{{ $college->id }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $college->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $college->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- View Modal -->
                <div class="modal fade" id="viewModal{{ $college->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $college->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewModalLabel{{ $college->id }}">College Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h6>College Name:</h6>
                                        <p>{{ $college->college_name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>University:</h6>
                                        <p>{{ $college->university_name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h6>College Type:</h6>
                                        <p>
                                            @if($college->college_type == 'domestic')
                                                <span class="badge bg-primary">Domestic</span>
                                            @else
                                                <span class="badge bg-info text-dark">Foreign</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Country:</h6>
                                        <p>{{ $college->country ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h6>State:</h6>
                                        <p>{{ $college->state ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>City:</h6>
                                        <p>{{ $college->city ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                
                                
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <h6>Courses:</h6>
                                        @php
                                            $collegeCourses = is_array($college->courses) ? $college->courses : json_decode($college->courses, true);
                                        @endphp
                                        @if($collegeCourses && is_array($collegeCourses) && count($collegeCourses) > 0)
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($collegeCourses as $course)
                                                    <span class="badge bg-secondary">{{ $course }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">No courses selected</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h6>Created At:</h6>
                                        <p>{{ $college->created_at->format('d-m-Y H:i:s') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Updated At:</h6>
                                        <p>{{ $college->updated_at->format('d-m-Y H:i:s') }}</p>
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
                <div class="modal fade" id="editModal{{ $college->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $college->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $college->id }}">Edit - {{ $college->college_name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.website.college.update', $college->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="college_type{{ $college->id }}" class="form-label">College Type <span class="text-danger">*</span></label>
                                            <select class="form-select" id="college_type{{ $college->id }}" name="college_type" required>
                                                <option value="domestic" {{ $college->college_type == 'domestic' ? 'selected' : '' }}>Domestic</option>
                                                <option value="foreign" {{ $college->college_type == 'foreign' ? 'selected' : '' }}>Foreign</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="college_name{{ $college->id }}" class="form-label">College Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="college_name{{ $college->id }}" name="college_name" value="{{ $college->college_name }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="university_name{{ $college->id }}" class="form-label">University <span class="text-danger">*</span></label>
                                            <select class="form-select" id="university_name{{ $college->id }}" name="university_name" required>
                                                <option value="">Select University</option>
                                                @foreach($universities as $university)
                                                <option value="{{ $university->university_name }}" data-type="{{ $university->university_type }}" {{ $college->university_name == $university->university_name ? 'selected' : '' }}>{{ $university->university_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="country{{ $college->id }}" class="form-label">Country <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="country{{ $college->id }}" name="country" value="{{ $college->country ?? '' }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="state{{ $college->id }}" class="form-label">State <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="state{{ $college->id }}" name="state" value="{{ $college->state ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="city{{ $college->id }}" class="form-label">City <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="city{{ $college->id }}" name="city" value="{{ $college->city ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Courses</label>
                                            <div class="row">
                                                @php
                                                    $collegeCourses = is_array($college->courses) ? $college->courses : json_decode($college->courses, true) ?? [];
                                                @endphp
                                                @forelse($courses ?? [] as $course)
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="course_{{ $college->id }}_{{ $course->id }}" name="courses[]" value="{{ $course->course_name }}" {{ in_array($course->course_name, $collegeCourses) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="course_{{ $college->id }}_{{ $course->id }}">
                                                            {{ $course->course_name }}
                                                        </label>
                                                    </div>
                                                </div>
                                                @empty
                                                <div class="col-12">
                                                    <p class="text-muted">No courses available. Please add courses first.</p>
                                                </div>
                                                @endforelse
                                            </div>
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
                <div class="modal fade" id="deleteModal{{ $college->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $college->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $college->id }}">Delete Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete <strong>{{ $college->college_name }}</strong>?</p>
                                <p class="text-danger">This action cannot be undone.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('admin.website.college.delete', $college->id) }}" method="POST" style="display: inline;">
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
                    <td colspan="10" class="text-center text-muted py-4">
                        <i class="fas fa-graduation-cap fa-2x mb-2"></i>
                        <p>No colleges found. Click "Add Data" to add your first record.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add College Modal -->
<div class="modal fade" id="addCollegeModal" tabindex="-1" aria-labelledby="addCollegeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCollegeModalLabel">Add New College</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.website.college.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="college_type" class="form-label">College Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="college_type" name="college_type" required>
                                <option value="">Select College Type</option>
                                <option value="domestic">Domestic</option>
                                <option value="foreign">Foreign</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="college_name" class="form-label">College Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="college_name" name="college_name" required placeholder="Enter college name">
                        </div>
                    </div>
                      
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="university_name" class="form-label">University <span class="text-danger">*</span></label>
                            <select class="form-select" id="university_name" name="university_name" required>
                                <option value="">Select University</option>
                                @foreach($universities as $university)
                                <option value="{{ $university->university_name }}" data-type="{{ $university->university_type }}">{{ $university->university_name }}</option>
                                @endforeach
                            </select>
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
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Courses</label>
                            <div class="row">
                                @forelse($courses ?? [] as $course)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="course_{{ $course->id }}" name="courses[]" value="{{ $course->course_name }}">
                                        <label class="form-check-label" for="course_{{ $course->id }}">
                                            {{ $course->course_name }}
                                        </label>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12">
                                    <p class="text-muted">No courses available. Please add courses first.</p>
                                </div>
                                @endforelse
                            </div>
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
document.addEventListener('DOMContentLoaded', function() {
    // For Add Modal
    const addCollegeType = document.getElementById('college_type');
    const addUniversitySelect = document.getElementById('university_name');
    
    if (addCollegeType && addUniversitySelect) {
        addCollegeType.addEventListener('change', function() {
            const selectedType = this.value;
            const options = addUniversitySelect.querySelectorAll('option');
            
            // Filter options based on college type
            options.forEach(function(option) {
                if (option.value === '') {
                    option.style.display = '';
                } else {
                    option.style.display = (option.dataset.type === selectedType || !selectedType) ? '' : 'none';
                }
            });
            
            // Reset selection
            addUniversitySelect.value = '';
        });
    }
    
    // For Edit Modals - Add event listeners to all edit modals
    const editModals = document.querySelectorAll('[id^="editModal"]');
    editModals.forEach(function(modal) {
        const modalId = modal.id;
        const collegeId = modalId.replace('editModal', '');
        const collegeTypeSelect = document.getElementById('college_type' + collegeId);
        const universitySelect = document.getElementById('university_name' + collegeId);
        
        if (collegeTypeSelect && universitySelect) {
            collegeTypeSelect.addEventListener('change', function() {
                const selectedType = this.value;
                const options = universitySelect.querySelectorAll('option');
                
                options.forEach(function(option) {
                    if (option.value === '') {
                        option.style.display = '';
                    } else {
                        option.style.display = (option.dataset.type === selectedType || !selectedType) ? '' : 'none';
                    }
                });
                
                universitySelect.value = '';
            });
            
            // Initial filter based on current selection
            const currentType = collegeTypeSelect.value;
            if (currentType) {
                const options = universitySelect.querySelectorAll('option');
                options.forEach(function(option) {
                    if (option.value !== '' && option.dataset.type !== currentType) {
                        option.style.display = 'none';
                    }
                });
            }
        }
    });
});
</script>
@endsection
