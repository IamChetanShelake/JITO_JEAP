@extends('admin.website.layouts.master')

@section('title', 'Course - JitoJeap Admin')

@section('website-content')
<div class="welcome-card w-100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fas fa-book"></i> Course Management</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal">
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
                    <th width="45%">Course Name</th>
                    <th width="40%">Duration</th>
                    <th width="10%" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses ?? [] as $index => $course)
                <tr>
                    <td class="text-center align-middle">{{ $index + 1 }}</td>
                    <td class="align-middle"><strong>{{ $course->course_name ?? 'N/A' }}</strong></td>
                    <td class="align-middle">{{ $course->duration ?? 'N/A' }}</td>
                    <td class="text-center align-middle">
                        <div class="d-flex justify-content-center gap-1">
                            <button class="btn btn-sm btn-info text-white" title="View" data-bs-toggle="modal" data-bs-target="#viewModal{{ $course->id }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $course->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $course->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- View Modal -->
                <div class="modal fade" id="viewModal{{ $course->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $course->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewModalLabel{{ $course->id }}">Course Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h6>Course Name:</h6>
                                        <p>{{ $course->course_name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Duration:</h6>
                                        <p>{{ $course->duration ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h6>Created At:</h6>
                                        <p>{{ $course->created_at->format('d-m-Y H:i:s') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Updated At:</h6>
                                        <p>{{ $course->updated_at->format('d-m-Y H:i:s') }}</p>
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
                <div class="modal fade" id="editModal{{ $course->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $course->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $course->id }}">Edit - {{ $course->course_name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.website.course.update', $course->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="course_name{{ $course->id }}" class="form-label">Course Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="course_name{{ $course->id }}" name="course_name" value="{{ $course->course_name }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="duration{{ $course->id }}" class="form-label">Duration</label>
                                            <input type="text" class="form-control" id="duration{{ $course->id }}" name="duration" value="{{ $course->duration ?? '' }}" placeholder="e.g., 4 years">
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
                <div class="modal fade" id="deleteModal{{ $course->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $course->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $course->id }}">Delete Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete <strong>{{ $course->course_name }}</strong>?</p>
                                <p class="text-danger">This action cannot be undone.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('admin.website.course.delete', $course->id) }}" method="POST" style="display: inline;">
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
                        <i class="fas fa-book fa-2x mb-2"></i>
                        <p>No courses found. Click "Add Data" to add your first record.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Course Modal -->
<div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCourseModalLabel">Add New Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.website.course.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="course_name" class="form-label">Course Name <span class="text-danger">*</span></label>
                            <select class="form-select" id="course_name" name="course_name" required onchange="toggleCourseOther()">
                                <option value="">Select Course</option>
                                <option value="BTECH">BTECH</option>
                                <option value="ENGINEERING">ENGINEERING</option>
                                <option value="MBA">MBA</option>
                                <option value="MD">MD</option>
                                <option value="MBBS">MBBS</option>
                                <option value="BAMS">BAMS</option>
                                <option value="MS">MS</option>
                                <option value="BDS">BDS</option>
                                <option value="LLB">LLB</option>
                                <option value="CA">CA</option>
                                <option value="CFA">CFA</option>
                                <option value="CS">CS</option>
                                <option value="Architect">Architect</option>
                                <option value="BBA">BBA</option>
                                <option value="B.COM">B.COM</option>
                                <option value="BMS">BMS</option>
                                <option value="BSC">BSC</option>
                                <option value="BDES">BDES</option>
                                <option value="BA">BA</option>
                                <option value="other">Other (Enter Manually)</option>
                            </select>
                            <input type="text" class="form-control mt-2" id="course_name_other" name="course_name_other" placeholder="Enter course name" style="display: none;">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="duration" class="form-label">Duration</label>
                            <input type="text" class="form-control" id="duration" name="duration" placeholder="e.g., 4 years">
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
@endsection

<script>
    function toggleCourseOther() {
        const courseSelect = document.getElementById('course_name');
        const courseOther = document.getElementById('course_name_other');
        
        if (courseSelect.value === 'other') {
            courseOther.style.display = 'block';
            courseOther.setAttribute('required', 'required');
        } else {
            courseOther.style.display = 'none';
            courseOther.removeAttribute('required');
            courseOther.value = '';
        }
    }
    
    // Reset form when modal opens
    document.getElementById('addCourseModal').addEventListener('shown.bs.modal', function () {
        document.getElementById('course_name').value = '';
        document.getElementById('course_name_other').style.display = 'none';
        document.getElementById('course_name_other').value = '';
    });
    
    // Handle form submission for 'other' course
    document.querySelector('#addCourseModal form').addEventListener('submit', function(e) {
        const courseSelect = document.getElementById('course_name');
        const courseOther = document.getElementById('course_name_other');
        
        if (courseSelect.value === 'other' && courseOther.value) {
            // Replace the 'other' value with the actual entered course name
            courseSelect.value = courseOther.value;
        }
    });
</script>
