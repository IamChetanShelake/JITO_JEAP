@extends('donor.layout.master')
@section('step')
    <button class="btn me-2" style="background:#393185;color:white;">
        Step 2 of 8
    </button>
@endsection
@section('content')
    <style>
        select option {
            border: none !important;
            border-radius: 15px !important;
            background-color: #F2F2F2 !important;
        }
    </style>


    <!-- Main Content -->
    <div class="col-lg-9 main-content">
        <!-- Hold Remark Alert -->
        @if (auth()->check() && auth()->user()->submit_status === 'resubmit' && auth()->user()->admin_remark)
            <div class="alert alert-warning alert-dismissible fade show" role="alert"
                style="background-color: #fff3cd; border-color: #ffeaa7; color: #856404; border-radius: 8px; margin-bottom: 20px;">
                <strong><i class="bi bi-exclamation-triangle-fill"></i> Hold Notice:</strong>
                <p style="margin: 8px 0 0 0; font-size: 14px;">{{ auth()->user()->admin_remark }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{ route('donor.step2.store') }}" enctype="multipart/form-data" novalidate>
    @csrf

    <div class="card form-card">
        <div class="card-body">

            <h4 class="mb-4 text-center">Family Details</h4>

            <!-- TITLE + SPOUSE NAME -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <label>Title *</label>
                    <select class="form-control" name="spouse_title" required>
                        <option value="" disabled selected>Select</option>
                        <option>Mr</option>
                        <option>Mrs</option>
                        <option>Miss</option>
                        <option>Ms</option>
                    </select>
                </div>

                <div class="col-md-9">
                    <label>Spouse Name *</label>
                    <input type="text" name="spouse_name" class="form-control" required>
                </div>
            </div>

            <!-- DOB + JITO MEMBER -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Birth Date *</label>
                    <input type="date" name="birth_date" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label>Is he / she JITO Member? *</label>
                    <div class="d-flex gap-4 mt-2">
                        <label>
                            <input type="radio" name="jito_member" value="yes" onclick="toggleJitoUID(true)"> Yes
                        </label>
                        <label>
                            <input type="radio" name="jito_member" value="no" onclick="toggleJitoUID(false)"> No
                        </label>
                    </div>
                </div>

                <div class="col-md-4" id="jito_uid_box" style="display:none;">
                    <label>JITO UID *</label>
                    <input type="text" name="jito_uid" class="form-control">
                </div>
            </div>

            <!-- BLOOD GROUP + KIDS -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Blood Group *</label>
                    <select name="blood_group" class="form-control" required>
                        <option value="">Select Blood Group</option>
                        <option>A+</option>
                        <option>A-</option>
                        <option>B+</option>
                        <option>B-</option>
                        <option>AB+</option>
                        <option>AB-</option>
                        <option>O+</option>
                        <option>O-</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Number of Kids *</label>
                    <input type="number" name="number_of_kids" id="number_of_kids"
                           class="form-control" min="0" placeholder="Enter number of kids">
                </div>
            </div>

            <!-- CHILD DETAILS -->
            
            <div id="child_details_container"></div>

        </div>
    </div>

    <!-- BUTTONS -->
    <div class="d-flex justify-content-between mt-4 mb-4">
        <a href="{{ route('donor.step1') }}" class="btn"
           style="background:#988DFF1F;color:gray;">
            ← Previous
        </a>

        <button type="submit" class="btn" style="background:#393185;color:white;">
            Next Step →
        </button>
    </div>
</form>

                </div>
            </div>
        </div>
    @endsection

   <script>
document.addEventListener('DOMContentLoaded', function () {

    function toggleJitoUID(show) {
        document.getElementById('jito_uid_box').style.display = show ? 'block' : 'none';
    }
    window.toggleJitoUID = toggleJitoUID; // make it accessible

    const container = document.getElementById('child_details_container');
    const numberInput = document.getElementById('number_of_kids');

    if (!numberInput || !container) return;

    numberInput.addEventListener('input', function () {
        const count = parseInt(this.value) || 0;
        container.innerHTML = '';

        for (let i = 1; i <= count; i++) {
            container.innerHTML += `
               <h5 class="mt-4 mb-3">Child Details</h5>
                <div class="card mb-3">
                
                    <div class="card-body">
                    
                        <h6>Child ${i}</h6>

                        <div class="row">
                            <div class="col-md-4">
                                <label>Name *</label>
                                <input type="text" name="child_name[]" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label>Gender *</label>
                                <select name="child_gender[]" class="form-control" required>
                                    <option value="">Select</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Other</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>DOB *</label>
                                <input type="date" name="child_dob[]" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label>Blood Group *</label>
                                <select name="child_blood_group[]" class="form-control" required>
                                    <option value="">Select</option>
                                    <option>A+</option>
                                    <option>A-</option>
                                    <option>B+</option>
                                    <option>B-</option>
                                    <option>AB+</option>
                                    <option>AB-</option>
                                    <option>O+</option>
                                    <option>O-</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Marital Status *</label>
                                <select name="child_marital_status[]" class="form-control" required>
                                    <option value="">Select</option>
                                    <option>Single</option>
                                    <option>Married</option>
                                    <option>Divorced</option>
                                    <option>Widowed</option>
                                    <option>Separated</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
    });

});
</script>

