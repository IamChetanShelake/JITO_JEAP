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
                <label>Title</label>
                <select class="form-control" name="title">
                    <option value="" disabled {{ old('title', $personalDetail->title ?? '') === '' ? 'selected' : '' }}>Select</option>
                    <option value="Mr" {{ old('title', $personalDetail->title ?? '') === 'Mr' ? 'selected' : '' }}>Mr</option>
                    <option value="Mrs" {{ old('title', $personalDetail->title ?? '') === 'Mrs' ? 'selected' : '' }}>Mrs</option>
                    <option value="Miss" {{ old('title', $personalDetail->title ?? '') === 'Miss' ? 'selected' : '' }}>Miss</option>
                    <option value="Ms" {{ old('title', $personalDetail->title ?? '') === 'Ms' ? 'selected' : '' }}>Ms</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label>First Name *</label>
                <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $personalDetail->first_name ?? '') }}">
            </div>
            <div class="col-md-4">
                <label>Middle Name</label>
                <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name', $personalDetail->middle_name ?? '') }}">
            </div>
            <div class="col-md-4">
                <label>Surname *</label>
                <input type="text" name="surname" class="form-control" value="{{ old('surname', $personalDetail->surname ?? '') }}">
            </div>
        </div>

        <!-- ADDRESS -->
        <div class="mb-3">
            <label>Complete Address (Residence) *</label>
            <textarea name="complete_address" class="form-control" rows="2">{{ old('complete_address', $personalDetail->complete_address ?? '') }}</textarea>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>City *</label>
                <input type="text" name="city" class="form-control" value="{{ old('city', $personalDetail->city ?? '') }}">
            </div>
            <div class="col-md-4">
                <label>State *</label>
                <input type="text" name="state" class="form-control" value="{{ old('state', $personalDetail->state ?? '') }}">
            </div>
            <div class="col-md-4">
                <label>Pin Code *</label>
                <input type="number" name="pin_code" class="form-control" value="{{ old('pin_code', $personalDetail->pin_code ?? '') }}">
            </div>
        </div>

        <!-- RESI LANDLINE (AFTER PINCODE) -->
        <div class="mb-3">
            <label>Resi. Landline</label>
            <input type="text" name="resi_landline" class="form-control" value="{{ old('resi_landline', $personalDetail->resi_landline ?? '') }}">
        </div>

        <!-- CONTACT -->
       <div class="row mb-3">
            <div class="col-md-6">
                <label>Mobile No *</label>
                <input 
                    type="tel"
                    name="mobile_no"
                    class="form-control"
                    maxlength="10"
                    pattern="[0-9]{10}"
                    value="{{ old('mobile_no', $personalDetail->mobile_no ?? '') }}"
                >
            </div>

            <div class="col-md-6">
                <label>WhatsApp No *</label>
                <input 
                    type="tel"
                    name="whatsapp_no"
                    class="form-control"
                    maxlength="10"
                    pattern="[0-9]{10}"
                    value="{{ old('whatsapp_no', $personalDetail->whatsapp_no ?? '') }}"
                >
            </div>
        </div>


        <!-- EMAIL -->
        <div class="mb-3">
            <label>Email ID 1 *</label>
            <input type="email" name="email_id_1" class="form-control" value="{{ old('email_id_1', $personalDetail->email_id_1 ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Email ID 2</label>
            <input type="email" name="email_id_2" class="form-control" value="{{ old('email_id_2', $personalDetail->email_id_2 ?? '') }}">
        </div>

        <!-- PREFERRED ADDRESS HEADING (AFTER EMAIL 2) -->
        <h6 class="mt-4 mb-3">Preferred Address for Communication</h6>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>Residence Address</label>
                <textarea name="preferred_residence_address" class="form-control" rows="2">{{ old('preferred_residence_address', $personalDetail->preferred_residence_address ?? '') }}</textarea>
            </div>
            <div class="col-md-4">
                <label>Office Address</label>
                <textarea name="preferred_office_address" class="form-control" rows="2">{{ old('preferred_office_address', $personalDetail->preferred_office_address ?? '') }}</textarea>
            </div>
            <div class="col-md-4">
                <label>PAN No *</label>
                <input type="text" name="pan_no" class="form-control" value="{{ old('pan_no', $personalDetail->pan_no ?? '') }}">
            </div>
        </div>
       <h6 class="mt-4 mb-3">Chapter Details</h6>
        <!-- CHAPTER NAME (BEFORE DOB) -->
        <div class="mb-3">
            <label>Chapter Name *</label>
            <input type="text" name="chapter_name" class="form-control" value="{{ old('chapter_name', $personalDetail->chapter_name ?? '') }}">
        </div>

        <!-- DOB & ANNIVERSARY -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Date of Birth *</label>
                <input
                    type="date"
                    name="date_of_birth"
                    class="form-control"
                    max="{{ now()->subYears(18)->format('Y-m-d') }}"
                    value="{{ old('date_of_birth', $personalDetail->date_of_birth ?? '') }}"
                >
            </div>

            <div class="col-md-6">
                <label>Anniversary Date</label>
                <input type="date" name="anniversary_date" class="form-control" value="{{ old('anniversary_date', $personalDetail->anniversary_date ?? '') }}">
            </div>
        </div>

        <!-- BLOOD GROUP -->
        <div class="mb-3">
            <label>Blood Group *</label><br>
            <div class="d-flex flex-wrap gap-3">
                <label><input type="radio" name="blood_group" value="A+" {{ old('blood_group', $personalDetail->blood_group ?? '') === 'A+' ? 'checked' : '' }}> A+</label>
                <label><input type="radio" name="blood_group" value="A-" {{ old('blood_group', $personalDetail->blood_group ?? '') === 'A-' ? 'checked' : '' }}> A-</label>
                <label><input type="radio" name="blood_group" value="B+" {{ old('blood_group', $personalDetail->blood_group ?? '') === 'B+' ? 'checked' : '' }}> B+</label>
                <label><input type="radio" name="blood_group" value="B-" {{ old('blood_group', $personalDetail->blood_group ?? '') === 'B-' ? 'checked' : '' }}> B-</label>
                <label><input type="radio" name="blood_group" value="AB+" {{ old('blood_group', $personalDetail->blood_group ?? '') === 'AB+' ? 'checked' : '' }}> AB+</label>
                <label><input type="radio" name="blood_group" value="AB-" {{ old('blood_group', $personalDetail->blood_group ?? '') === 'AB-' ? 'checked' : '' }}> AB-</label>
                <label><input type="radio" name="blood_group" value="O+" {{ old('blood_group', $personalDetail->blood_group ?? '') === 'O+' ? 'checked' : '' }}> O+</label>
                <label><input type="radio" name="blood_group" value="O-" {{ old('blood_group', $personalDetail->blood_group ?? '') === 'O-' ? 'checked' : '' }}> O-</label>
            </div>
        </div>

        <!-- FAMILY DETAILS -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Mother Tongue *</label>
                <input type="text" name="mother_tongue" class="form-control" value="{{ old('mother_tongue', $personalDetail->mother_tongue ?? '') }}">
            </div>
            <div class="col-md-6">
                <label>District of Native Place *</label>
                <input type="text" name="district_of_native_place" class="form-control" value="{{ old('district_of_native_place', $personalDetail->district_of_native_place ?? '') }}">
            </div>
        </div>

        <div class="mb-3">
            <label>Father's Name *</label>
            <input type="text" name="fathers_name" class="form-control" value="{{ old('fathers_name', $personalDetail->fathers_name ?? '') }}">
        </div>

        <!-- HOBBIES -->
        <div class="mb-3">
            <label>Hobby 1</label>
            <input type="text" name="hobby_1" class="form-control" value="{{ old('hobby_1', $personalDetail->hobby_1 ?? '') }}">
        </div>

        <div class="mb-4">
            <label>Hobby 2</label>
            <input type="text" name="hobby_2" class="form-control" value="{{ old('hobby_2', $personalDetail->hobby_2 ?? '') }}">
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

    
 
