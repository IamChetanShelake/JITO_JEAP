@extends('user.layout.master')
@section('step')
    <button class="btn btn-purple me-2" style="background-color: #393185; color: white;">Step 1 of
        7</button>
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
    @if(auth()->check() && auth()->user()->submit_status === 'resubmit' && auth()->user()->admin_remark)
        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="background-color: #fff3cd; border-color: #ffeaa7; color: #856404; border-radius: 8px; margin-bottom: 20px;">
            <strong><i class="bi bi-exclamation-triangle-fill"></i> Hold Notice:</strong>
            <p style="margin: 8px 0 0 0; font-size: 14px;">{{ auth()->user()->admin_remark }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{ route('user.step1.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-5 offset-md-1">
                                <label for="financial_asset_type" class="form-label">Financial Asset Type <span
                                        style="color: red;">*</span></label>
                                <select class="form-control" name="financial_asset_type" id="financial_asset_type"
                                    style="border:2px solid #393185;border-radius:15px;" @if($user->submit_status == 'submited') readonly @endif required>
                                    <option disabled
                                        {{ $user->financial_asset_type ? '' : 'selected' }}
                                        hidden>Select Financial Asset Type</option>
                                    <option value="domestic"
                                        {{ $user->financial_asset_type == 'domestic' ? 'selected' : '' }}>
                                        Domestic</option>
                                    <option value="foreign_finance_assistant"
                                        {{ $user->financial_asset_type == 'foreign_finance_assistant' ? 'selected' : '' }}>
                                        Foreign Financial Assistance</option>
                                </select>
                                <small class="text-danger">{{ $errors->first('financial_asset_type') }}</small>
                            </div>
                            <div class="col-md-5">
                                <label for="financial_asset_for" class="form-label">Financial Asset For <span
                                        style="color: red;">*</span></label>
                                <select class="form-control" name="financial_asset_for" id="financial_asset_for"
                                    style="border:2px solid #393185;border-radius:15px;" @if($user->submit_status == 'submited') readonly @endif required>
                                    <option disabled
                                        {{ $user->financial_asset_for ? '' : 'selected' }}
                                        hidden>Select Financial Asset For</option>
                                    <option value="graduation"
                                        {{ $user->financial_asset_for == 'graduation' ? 'selected' : '' }}>
                                        Graduation</option>
                                    <option value="post_graduation"
                                        {{ $user->financial_asset_for == 'post_graduation' ? 'selected' : '' }}>
                                        Post Graduation</option>
                                </select>
                                <small class="text-danger">{{ $errors->first('financial_asset_for') }}</small>
                            </div>
                        </div>
                        {{-- <div class="row mb-3">
                            <div class="col-md-5 offset-md-1">

                                <select class="form-control" name="financial_asset_type" id="financial_asset_type"
                                    style="border:2px solid #393185;border-radius:15px;" @if ($user->submit_status == 'submited') readonly @endif required>
                                    <option disabled
                                        {{ (old('financial_asset_type') ?: $user->financial_asset_type ?? '') ? '' : 'selected' }}
                                        hidden>Financial Asst Type <span style="color: red;">*</span></option>
                                    <option value="domestic"
                                        {{ (old('financial_asset_type') ?: $user->financial_asset_type ?? '') == 'domestic' ? 'selected' : '' }}
                                        hidden>
                                        Domestic</option>
                                    <option value="foreign_finance_assistant"
                                        {{ (old('financial_asset_type') ?: $user->financial_asset_type ?? '') == 'foreign_finance_assistant' ? 'selected' : '' }}
                                        hidden>
                                        Foreign Financial Assistance</option>
                                </select>
                                <small class="text-danger">{{ $errors->first('financial_asset_type') }}</small>
                            </div>
                            <div class="col-md-5">
                                <select class="form-control" name="financial_asset_for" id="financial_asset_for"
                                    style="border:2px solid #393185;border-radius:15px;" @if ($user->submit_status == 'submited') readonly @endif required>
                                    <option disabled
                                        {{ (old('financial_asset_for') ?: $user->financial_asset_for ?? '') ? '' : 'selected' }}
                                        hidden>Financial Asst For *</option>
                                    <option value="graduation"
                                        {{ (old('financial_asset_for') ?: $user->financial_asset_for ?? '') == 'graduation' ? 'selected' : '' }}
                                        hidden>
                                        Graduation</option>
                                    <option value="post_graduation"
                                        {{ (old('financial_asset_for') ?: $user->financial_asset_for ?? '') == 'post_graduation' ? 'selected' : '' }}
                                        hidden>
                                        Post Graduation</option>
                                </select>
                                <small class="text-danger">{{ $errors->first('financial_asset_for') }}</small>
                            </div>
                        </div> --}}
                        <div class="card form-card">
                            <div class="card-body">

                                <div class="step-card">
                                    <div class="card-icon">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div>
                                        <h3 class="card-title">Personal Details</h3>
                                        <p class="card-subtitle">Provide your correct details</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6">

                                        <div class="form-group mb-3">
                                            <label for="name" class="form-label">Applicant's Name <span
                                                    style="color: red;">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Enter Applicant's Name"
                                                value="{{ old('name', $user->name ?? '') }}" required>
                                            <small class="text-danger">{{ $errors->first('name') }}</small>
                                        </div>



                                        <div class="form-group mb-3">
                                            <label for="uploadInput" class="form-label">Photo <span
                                                    style="color: red;">*</span></label>
                                            @if ($user->image)
                                                <div class="current-image mt-2">
                                                    <img src="{{ asset($user->image) }}" alt="Current Photo"
                                                        style="max-width: 100px; max-height: 100px; border: 1px solid #ddd; border-radius: 5px;">
                                                    <p class="mb-0 mt-1" style="font-size: 12px; color: #666;">Current Photo
                                                    </p>
                                                </div>
                                            @endif
                                            <div class="photo-upload-box">
                                                <div class="row mb-2 align-items-center">
                                                    <div class="col-9">
                                                        <span class="photo-label">Upload Photo</span>
                                                        <input type="file" id="uploadInput" name="image" hidden
                                                            accept=".jpg,.jpeg,.png">
                                                        <small class="text-danger">{{ $errors->first('image') }}</small>
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="uploadInput" class="upload-btn">
                                                            <span class="upload-icon">⭱</span> Upload
                                                        </label>
                                                        <label class="uploaded-btn" style="display: none;">
                                                            <span class="upload-icon">✔</span> Upload
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="row mb-2 align-items-center">

                                                    <div class="col-12 align-items-center">
                                                        <div class="upload-status" style="display:none;">
                                                            <div class="row">
                                                                <div class="col-9">
                                                                    {{-- <img id="imagePreview" class="img-thumbnail"
                                                                        style="max-width: 100px; max-height: 100px; display: none;" /><br> --}}
                                                                    <div class="upload-summary"></div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <button type="button" class="remove-upload btn bt-sm"
                                                                        style="display:none;">
                                                                        <i class="bi bi-trash"></i>
                                                                        Remove</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="form-group mb-3">
                                            <label for="aadhar_card_number" class="form-label">Applicant's Aadhar Card
                                                Number <span style="color: red;">*</span></label>
                                            <input type="number" id="aadhar_card_number" name="aadhar_card_number"
                                                class="form-control" placeholder="Enter Applicant's Aadhar Card Number"
                                                value="{{ old('aadhar_card_number', $user->aadhar_card_number ?? '') }}"
                                                required>
                                            <small class="text-danger">{{ $errors->first('aadhar_card_number') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="pan_card" class="form-label">Applicant's Pan Card</label>
                                            <input type="text" id="pan_card" class="form-control" name="pan_card"
                                                placeholder="Enter Applicant's Pan Card"
                                                value="{{ old('pan_card', $user->pan_card ?? '') }}">
                                            <small class="text-danger">{{ $errors->first('pan_card') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="phone" class="form-label">Applicant's Phone Number <span
                                                    style="color: red;">*</span></label>
                                            <input type="tel" id="phone" name="phone" class="form-control"
                                                placeholder="Enter Applicant's Phone Number"
                                                value="{{ old('phone', $user->phone ?? '') }}" required>
                                            <small class="text-danger">{{ $errors->first('phone') }}</small>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="alternate_phone" class="form-label">Alternate Phone Number</label>
                                            <input type="tel" id="alternate_phone" name="alternate_phone"
                                                class="form-control" placeholder="Enter Alternate Phone Number"
                                                value="{{ old('alternate_phone', $user->alternate_phone ?? '') }}">
                                            <small class="text-danger">{{ $errors->first('alternate_phone') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="email" class="form-label">Applicant's Email Address <span
                                                    style="color: red;">*</span></label>
                                            <input type="email" id="email" name="email" class="form-control"
                                                placeholder="Enter Applicant's Email Address"
                                                value="{{ old('email', $user->email ?? '') }}" required>
                                            <small class="text-danger">{{ $errors->first('email') }}</small>
                                        </div>





                                        <div class="form-group mb-3">
                                            <label for="alternate_email" class="form-label">Alternate Email
                                                Address</label>
                                            <input type="email" id="alternate_email" name="alternate_email"
                                                class="form-control" placeholder="Enter Alternate Email Address"
                                                value="{{ old('alternate_email') }}">
                                            <small class="text-danger">{{ $errors->first('alternate_email') }}</small>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="marital_status" class="form-label">Marital Status <span
                                                    style="color: red;">*</span></label>
                                            <select class="form-control" id="marital_status" name="marital_status"
                                                required>
                                                <option disabled
                                                    {{ (old('marital_status') ?: $user->marital_status ?? '') ? '' : 'selected' }}
                                                    hidden>
                                                    Select Marital Status</option>
                                                <option value="married"
                                                    {{ (old('marital_status') ?: $user->marital_status ?? '') == 'married' ? 'selected' : '' }}>
                                                    Married
                                                </option>
                                                <option value="unmarried"
                                                    {{ (old('marital_status') ?: $user->marital_status ?? '') == 'unmarried' ? 'selected' : '' }}>
                                                    Unmarried
                                                </option>
                                            </select>
                                            <small class="text-danger">{{ $errors->first('marital_status') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="religion" class="form-label">Religion <span
                                                    style="color: red;">*</span></label>
                                            <input type="text" id="religion" name="religion" class="form-control"
                                                placeholder="Enter Religion"
                                                value="{{ old('religion', $user->religion ?? '') }}" required>
                                            <small class="text-danger">{{ $errors->first('religion') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="sub_cast" class="form-label">Sub Caste <span
                                                    style="color: red;">*</span></label>
                                            <input type="text" id="sub_cast" name="sub_cast" class="form-control"
                                                placeholder="Enter Sub Caste"
                                                value="{{ old('sub_cast', $user->sub_cast ?? '') }}" required>
                                            <small class="text-danger">{{ $errors->first('sub_cast') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="blood_group" class="form-label">Blood Group <span
                                                    style="color: red;">*</span></label>
                                            <select class="form-control" id="blood_group" name="blood_group" required>
                                                <option disabled
                                                    {{ (old('blood_group') ?: $user->blood_group ?? '') ? '' : 'selected' }}
                                                    hidden>Select Blood Group</option>
                                                <option value="A+"
                                                    {{ (old('blood_group') ?: $user->blood_group ?? '') == 'A+' ? 'selected' : '' }}>
                                                    A+</option>
                                                <option value="A-"
                                                    {{ (old('blood_group') ?: $user->blood_group ?? '') == 'A-' ? 'selected' : '' }}>
                                                    A-</option>
                                                <option value="B+"
                                                    {{ (old('blood_group') ?: $user->blood_group ?? '') == 'B+' ? 'selected' : '' }}>
                                                    B+</option>
                                                <option value="B-"
                                                    {{ (old('blood_group') ?: $user->blood_group ?? '') == 'B-' ? 'selected' : '' }}>
                                                    B-</option>
                                                <option value="AB+"
                                                    {{ (old('blood_group') ?: $user->blood_group ?? '') == 'AB+' ? 'selected' : '' }}>
                                                    AB+</option>
                                                <option value="AB-"
                                                    {{ (old('blood_group') ?: $user->blood_group ?? '') == 'AB-' ? 'selected' : '' }}>
                                                    AB-</option>
                                                <option value="O+"
                                                    {{ (old('blood_group') ?: $user->blood_group ?? '') == 'O+' ? 'selected' : '' }}>
                                                    O+</option>
                                                <option value="O-"
                                                    {{ (old('blood_group') ?: $user->blood_group ?? '') == 'O-' ? 'selected' : '' }}>
                                                    O-</option>
                                            </select>
                                            <small class="text-danger">{{ $errors->first('blood_group') }}</small>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="d_o_b" class="form-label">Date of Birth <span
                                                    style="color: red;">*</span></label>
                                            <input type="text" id="d_o_b" name="d_o_b" class="form-control"
                                                placeholder="yyyy-mm-dd" value="{{ old('d_o_b', $user->d_o_b ?? '') }}"
                                                pattern="\d{4}-\d{2}-\d{2}" title="Format: yyyy-mm-dd" readonly required>

                                            <small class="text-danger">{{ $errors->first('d_o_b') }}</small>
                                        </div>



                                        <div class="form-group mb-3">
                                            <label for="birth_place" class="form-label">Birth Place <span
                                                    style="color: red;">*</span></label>
                                            <input type="text" id="birth_place" name="birth_place"
                                                class="form-control" placeholder="Enter Birth Place"
                                                value="{{ old('birth_place', $user->birth_place ?? '') }}" required>
                                            <small class="text-danger">{{ $errors->first('birth_place') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="gender" class="form-label">Gender <span
                                                    style="color: red;">*</span></label>
                                            <select class="form-control" id="gender" name="gender" required>
                                                <option disabled
                                                    {{ (old('gender') ?: $user->gender ?? '') ? '' : 'selected' }} hidden>
                                                    Select Gender
                                                </option>
                                                <option value="male"
                                                    {{ (old('gender') ?: $user->gender ?? '') == 'male' ? 'selected' : '' }}>
                                                    Male</option>
                                                <option value="female"
                                                    {{ (old('gender') ?: $user->gender ?? '') == 'female' ? 'selected' : '' }}>
                                                    Female</option>
                                            </select>
                                            <small class="text-danger">{{ $errors->first('gender') }}</small>
                                        </div>



                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-md-6">

                                        <div class="form-group mb-3">
                                            <label for="age" class="form-label">Age <span
                                                    style="color: red;">*</span></label>
                                            <input type="number" id="age" name="age" class="form-control"
                                                placeholder="Age" value="{{ old('age', $user->age ?? '') }}" readonly
                                                required>
                                            <small class="text-danger">{{ $errors->first('age') }}</small>
                                        </div>
                                        {{-- <div class="form-group mb-3">
                                            <textarea class="form-control" name="address" rows="3" placeholder="Flat No, Building No/Street Name*"
                                                required>{{ old('address', $user->address ?? '') }}</textarea>
                                            <small class="text-danger">{{ $errors->first('address') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <textarea class="form-control" name="address1" rows="3" placeholder="Address 1*" required>{{ old('address1', $user->address1 ?? '') }}</textarea>
                                            <small class="text-danger">{{ $errors->first('address1') }}</small>
                                        </div> --}}
                                        <div class="form-group mb-3">
                                            <label for="flat_no" class="form-label">Flat No</label>
                                            <input type="text" id="flat_no" class="form-control" name="flat_no"
                                                placeholder="Enter Flat No"
                                                value="{{ old('flat_no', $user->flat_no ?? '') }}">
                                            <small class="text-danger">{{ $errors->first('flat_no') }}</small>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="building_no" class="form-label">Building No </label>
                                            <input type="text" id="building_no" class="form-control"
                                                name="building_no" placeholder="Enter Building No"
                                                value="{{ old('building_no', $user->building_no ?? '') }}">
                                            <small class="text-danger">{{ $errors->first('building_no') }}</small>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="street_name" class="form-label">Street Name</label>
                                            <input type="text" id="street_name" class="form-control"
                                                name="street_name" placeholder="Enter Street Name"
                                                value="{{ old('street_name', $user->street_name ?? '') }}">
                                            <small class="text-danger">{{ $errors->first('street_name') }}</small>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="area" class="form-label">Area</label>
                                            <input type="text" id="area" class="form-control" name="area"
                                                placeholder="Enter Area" value="{{ old('area', $user->area ?? '') }}">
                                            <small class="text-danger">{{ $errors->first('area') }}</small>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="landmark" class="form-label">Landmark</label>
                                            <input type="text" id="landmark" class="form-control" name="landmark"
                                                placeholder="Enter Landmark"
                                                value="{{ old('landmark', $user->landmark ?? '') }}">
                                            <small class="text-danger">{{ $errors->first('landmark') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="city" class="form-label">City <span
                                                    style="color: red;">*</span></label>
                                            <input type="text" id="city" class="form-control" name="city"
                                                placeholder="Enter City" value="{{ old('city', $user->city ?? '') }}"
                                                required>
                                            <small class="text-danger">{{ $errors->first('city') }}</small>
                                        </div>



                                        <div class="form-group mb-3">
                                            <label for="district" class="form-label">District <span
                                                    style="color: red;">*</span></label>
                                            <input type="text" id="district" class="form-control" name="district"
                                                placeholder="Enter District"
                                                value="{{ old('district', $user->district ?? '') }}" required>
                                            <small class="text-danger">{{ $errors->first('district') }}</small>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="state" class="form-label">State <span
                                                    style="color: red;">*</span></label>
                                            <input type="text" id="state" class="form-control" name="state"
                                                placeholder="Enter State" value="{{ old('state', $user->state ?? '') }}"
                                                required>
                                            <small class="text-danger">{{ $errors->first('state') }}</small>
                                        </div>



                                        <div class="form-group mb-3">
                                            <label for="nationality" class="form-label">Nationality <span
                                                    style="color: red;">*</span></label>
                                            <select class="form-control" id="nationality" name="nationality" required>
                                                <option disabled
                                                    {{ (old('nationality') ?: $user->nationality ?? '') ? '' : 'selected' }}
                                                    hidden>
                                                    Select Nationality</option>
                                                <option value="indian"
                                                    {{ (old('nationality') ?: $user->nationality ?? '') == 'indian' ? 'selected' : '' }}>
                                                    Indian</option>
                                                <option value="foreigner"
                                                    {{ (old('nationality') ?: $user->nationality ?? '') == 'foreigner' ? 'selected' : '' }}>
                                                    Foreigner
                                                </option>
                                            </select>
                                            <small class="text-danger">{{ $errors->first('nationality') }}</small>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="pin_code" class="form-label">Pin Code <span
                                                    style="color: red;">*</span></label>
                                            <input type="number" id="pin_code" name="pin_code" class="form-control"
                                                placeholder="Enter Pin Code"
                                                value="{{ old('pin_code', $user->pin_code ?? '') }}" required>
                                            <small class="text-danger">{{ $errors->first('pin_code') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="chapter" class="form-label">Chapter <span
                                                    style="color: red;">*</span></label>
                                            <input type="text" id="chapter" name="chapter" class="form-control"
                                                placeholder="Enter Chapter"
                                                value="{{ old('chapter', $user->chapter ?? '') }}" required>
                                            <small class="text-danger">{{ $errors->first('chapter') }}</small>
                                        </div>




                                        <div class="form-group mb-3">
                                            <label for="aadhar_address" class="form-label">Aadhar/Pan Address <span
                                                    style="color: red;">*</span></label>
                                            <textarea class="form-control" id="aadhar_address" name="aadhar_address" rows="3"
                                                placeholder="Enter Aadhar/Pan Address" required>{{ old('aadhar_address', $user->aadhar_address ?? '') }}</textarea>
                                            <small class="text-danger">{{ $errors->first('aadhar_address') }}</small>
                                        </div>


                                        <div class="form-group mb-3">
                                            <label for="specially_abled" class="form-label">Specially Abled <span
                                                    style="color: red;">*</span></label>
                                            <select class="form-control" id="specially_abled" name="specially_abled"
                                                required>
                                                <option disabled
                                                    {{ (old('specially_abled') ?: $user->specially_abled ?? '') ? '' : 'selected' }}
                                                    hidden>
                                                    Select Specially Abled</option>
                                                <option value="yes"
                                                    {{ (old('specially_abled') ?: $user->specially_abled ?? '') == 'yes' ? 'selected' : '' }}>
                                                    Yes</option>
                                                <option value="no"
                                                    {{ (old('specially_abled') ?: $user->specially_abled ?? '') == 'no' ? 'selected' : '' }}>
                                                    No</option>
                                            </select>
                                            <small class="text-danger">{{ $errors->first('specially_abled') }}</small>
                                        </div>
                                    </div>
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

    <script>
        function calculateAge(dob) {
            const today = new Date();
            const birthDate = new Date(dob);
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            return age;
        }

        document.addEventListener('DOMContentLoaded', function() {
            var typeSelect = document.getElementById('financial_asset_type');
            var forSelect = document.getElementById('financial_asset_for');
            var dobInput = document.querySelector('input[name="d_o_b"]');
            var ageInput = document.querySelector('input[name="age"]');

            function updateForOptions() {
                var type = typeSelect.value;
                forSelect.innerHTML = '<option disabled selected hidden>Financial Asst For *</option>';
                if (type === 'domestic') {
                    forSelect.innerHTML +=
                        '<option value="graduation">Graduation</option><option value="post_graduation">Post Graduation</option>';
                } else if (type === 'foreign_finance_assistant') {
                    forSelect.innerHTML += '<option value="post_graduation">Post Graduation</option>';
                }
                // Reset selection if current value is not available
                var currentValue = forSelect.value;
                if (currentValue && !Array.from(forSelect.options).some(option => option.value === currentValue)) {
                    forSelect.selectedIndex = 0;
                }
            }

            function updateAge() {
                const dob = dobInput.value;
                if (dob && dob.match(/^\d{4}-\d{2}-\d{2}$/)) {
                    const age = calculateAge(dob);
                    ageInput.value = age;
                }
            }

            typeSelect.addEventListener('change', updateForOptions);
            dobInput.addEventListener('input', updateAge);
            dobInput.addEventListener('change', updateAge);

            // Initialize on load
            if (typeSelect.value) {
                updateForOptions();
            }
            if (dobInput.value) {
                updateAge();
            }

            // File upload preview
            document.getElementById('uploadInput').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const preview = document.getElementById('imagePreview');
                    preview.src = URL.createObjectURL(file);
                    preview.style.display = 'block';
                    document.querySelector('.upload-summary').textContent = file.name;
                    document.querySelector('.upload-status').style.display = 'block';
                    document.querySelector('.remove-upload').style.display = 'block';
                }
            });

            document.querySelector('.remove-upload').addEventListener('click', function() {
                document.getElementById('uploadInput').value = '';
                document.getElementById('imagePreview').style.display = 'none';
                document.querySelector('.upload-summary').textContent = '';
                document.querySelector('.upload-status').style.display = 'none';
                document.querySelector('.remove-upload').style.display = 'none';
                URL.revokeObjectURL(document.getElementById('imagePreview').src);
            });
        });
    </script>
