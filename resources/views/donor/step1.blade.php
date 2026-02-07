@extends('donor.layout.master')
@section('step')
    <button class="btn me-2" style="background:#393185;color:white;">
        Step 1 of 8
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
                    <form method="POST" action="{{ route('donor.step1.store') }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="card form-card">
    <div class="card-body">

        <!-- TITLE ABOVE FIRST NAME -->
        <h4 class="mb-4 text-center">Personal Details (Mandatory)</h4>

        <!-- NAME -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label>Title *</label>
                <select class="form-control">
                    <option selected disabled>Select</option>
                    <option>Mr</option>
                    <option>Mrs</option>
                    <option>Miss</option>
                    <option>Ms</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label>First Name *</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-4">
                <label>Middle Name *</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-4">
                <label>Surname *</label>
                <input type="text" class="form-control">
            </div>
        </div>

        <!-- ADDRESS -->
        <div class="mb-3">
            <label>Complete Address (Residence) *</label>
            <textarea class="form-control" rows="2"></textarea>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>City *</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-4">
                <label>State *</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-4">
                <label>Pin Code *</label>
                <input type="text" class="form-control">
            </div>
        </div>

        <!-- RESI LANDLINE (AFTER PINCODE) -->
        <div class="mb-3">
            <label>Resi. Landline</label>
            <input type="text" class="form-control">
        </div>

        <!-- CONTACT -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Mobile No *</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-6">
                <label>WhatsApp No *</label>
                <input type="text" class="form-control">
            </div>
        </div>

        <!-- EMAIL -->
        <div class="mb-3">
            <label>Email ID 1 *</label>
            <input type="email" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email ID 2</label>
            <input type="email" class="form-control">
        </div>

        <!-- PREFERRED ADDRESS HEADING (AFTER EMAIL 2) -->
        <h6 class="mt-4 mb-3">Preferred Address for Communication</h6>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>Residence Address *</label>
                <textarea class="form-control" rows="2"></textarea>
            </div>
            <div class="col-md-4">
                <label>Office Address *</label>
                <textarea class="form-control" rows="2"></textarea>
            </div>
            <div class="col-md-4">
                <label>PAN No *</label>
                <input type="text" class="form-control">
            </div>
        </div>
       <h6 class="mt-4 mb-3">Chapter Details</h6>
        <!-- CHAPTER NAME (BEFORE DOB) -->
        <div class="mb-3">
            <label>Chapter Name *</label>
            <input type="text" class="form-control">
        </div>

        <!-- DOB & ANNIVERSARY -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Date of Birth *</label>
                <input type="date" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Anniversary Date *</label>
                <input type="date" class="form-control">
            </div>
        </div>

        <!-- BLOOD GROUP -->
        <div class="mb-3">
            <label>Blood Group *</label><br>
            <div class="d-flex flex-wrap gap-3">
                <label><input type="radio" name="blood"> A+</label>
                <label><input type="radio" name="blood"> A-</label>
                <label><input type="radio" name="blood"> B+</label>
                <label><input type="radio" name="blood"> B-</label>
                <label><input type="radio" name="blood"> AB+</label>
                <label><input type="radio" name="blood"> AB-</label>
                <label><input type="radio" name="blood"> O+</label>
                <label><input type="radio" name="blood"> O-</label>
                <label><input type="radio" name="blood"> Other</label>
            </div>
        </div>

        <!-- FAMILY DETAILS -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Mother Tongue *</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-6">
                <label>District of Native Place *</label>
                <input type="text" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label>Father's Name *</label>
            <input type="text" class="form-control">
        </div>

        <!-- HOBBIES -->
        <div class="mb-3">
            <label>Hobby 1</label>
            <input type="text" class="form-control">
        </div>

        <div class="mb-4">
            <label>Hobby 2</label>
            <input type="text" class="form-control">
        </div>

    </div>
</div>
<div class="d-flex justify-content-between mt-4 mb-4">
                            <button type="button" class="btn " style="background:#988DFF1F;color:gray;"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    stroke="gray" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M15 18l-6-6 6-6" />
                                </svg>

                                Previous</button>
                            <button type="submit" class="btn" style="background:#393185;color:white;">Next Step <svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    stroke="white" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M9 6l6 6-6 6" />
                                </svg>

                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endsection

    
 
