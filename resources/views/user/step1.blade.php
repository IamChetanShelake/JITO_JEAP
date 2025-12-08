@extends('user.layout.master')
@section('step')
    <button class="btn btn-purple me-2" style="background-color: #393185; color: white;">Step 1 of
        7</button>
@endsection
@section('content')
    <!-- Main Content -->
    <div class="col-lg-9 main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{ route('user.step1.store') }}" enctype="multipart/form-data">
                        @csrf
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
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Applicant's Name *"
                                                value="{{ old('name', $user->name ?? '') }}" required>
                                            <small class="text-danger">{{ $errors->first('name') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <div class="photo-upload-box">
                                                <div class="row mb-2 align-items-center">
                                                    <div class="col-9">
                                                        <span class="photo-label">Add Photo *</span>
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
                                            @if ($user->image)
                                                <div class="uploadedimg"
                                                    style="cursor: pointer;width: 48px;height: 48px;display: flex;">
                                                    <img src="{{ asset($user->image) }}" alt="" style="width:100%;">
                                                    <i class="bi bi-x remove-upload"
                                                        style="color: #F43333;border: none;display:block;width:100%;font-size: 100%;">
                                                    </i>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- <div class="form-group mb-3">
                                                    <select class="form-control" style="color:#4C4C4C" required>
                                                        <option>Financial Asset Type *</option>
                                                        <option value="domestic">Domestic</option>
                                                        <option value="foreign_finance_assistant">Foreign Financial
                                                            Assistance</option>
                                                    </select>
                                                </div> --}}
                                        <div class="form-group mb-3">
                                            <select class="form-control " name="financial_asset_type" required>
                                                <option disabled
                                                    {{ (old('financial_asset_type') ?: $user->financial_asset_type ?? '') ? '' : 'selected' }}
                                                    hidden>
                                                    Financial Asst Type *</option>
                                                <option value="domestic"
                                                    {{ (old('financial_asset_type') ?: $user->financial_asset_type ?? '') == 'domestic' ? 'selected' : '' }}>
                                                    Domestic</option>
                                                <option value="foreign_finance_assistant"
                                                    {{ (old('financial_asset_type') ?: $user->financial_asset_type ?? '') == 'foreign_finance_assistant' ? 'selected' : '' }}>
                                                    Foreign Financial
                                                    Assistance</option>
                                            </select>
                                            <small class="text-danger">{{ $errors->first('financial_asset_type') }}</small>
                                        </div>


                                        <div class="form-group mb-3">
                                            <select class="form-control" name="financial_asset_for" required>
                                                <option disabled
                                                    {{ (old('financial_asset_for') ?: $user->financial_asset_for ?? '') ? '' : 'selected' }}
                                                    hidden>
                                                    Financial Asset For *</option>
                                                <option value="graduation"
                                                    {{ (old('financial_asset_for') ?: $user->financial_asset_for ?? '') == 'graduation' ? 'selected' : '' }}>
                                                    Graduation</option>
                                                <option value="post_graduation"
                                                    {{ (old('financial_asset_for') ?: $user->financial_asset_for ?? '') == 'post_graduation' ? 'selected' : '' }}>
                                                    Post Graduation</option>
                                            </select>
                                            <small class="text-danger">{{ $errors->first('financial_asset_for') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="number" name="aadhar_card_number" class="form-control"
                                                placeholder="Aadhar Card Number *"
                                                value="{{ old('aadhar_card_number', $user->aadhar_card_number ?? '') }}"
                                                required>
                                            <small class="text-danger">{{ $errors->first('aadhar_card_number') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" name="pan_card"
                                                placeholder="Pan card"
                                                value="{{ old('pan_card', $user->pan_card ?? '') }}">
                                            <small class="text-danger">{{ $errors->first('pan_card') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="tel" name="phone" class="form-control"
                                                placeholder="Phone Number *" value="{{ old('phone', $user->phone ?? '') }}"
                                                required>
                                            <small class="text-danger">{{ $errors->first('phone') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="email" name="email" class="form-control"
                                                placeholder="Email Address *"
                                                value="{{ old('email', $user->email ?? '') }}" required>
                                            <small class="text-danger">{{ $errors->first('email') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="tel" name="alternate_phone" class="form-control"
                                                placeholder="Alternate Phone Number"
                                                value="{{ old('alternate_phone', $user->alternate_phone ?? '') }}">
                                            <small class="text-danger">{{ $errors->first('alternate_phone') }}</small>
                                        </div>

                                        {{-- <div class="form-group mb-3">
                                            <input type="email" name="alternate_email" class="form-control"
                                                placeholder="Alternate Email Address" value="{{ old('alternate_email') }}">
                                            <small class="text-danger">{{ $errors->first('alternate_email') }}</small>
                                        </div>
                                         --}}
                                        <div class="form-group mb-3">
                                            <textarea class="form-control" name="address" rows="3" placeholder="Flat No, Building No/Street Name*"
                                                required>{{ old('address', $user->address ?? '') }}</textarea>
                                            <small class="text-danger">{{ $errors->first('address') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <textarea class="form-control" name="address1" rows="3" placeholder="Address 1*" required>{{ old('address1', $user->address1 ?? '') }}</textarea>
                                            <small class="text-danger">{{ $errors->first('address1') }}</small>
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" name="city"
                                                placeholder="City *" value="{{ old('city', $user->city ?? '') }}"
                                                required>
                                            <small class="text-danger">{{ $errors->first('city') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" name="district"
                                                placeholder="District *"
                                                value="{{ old('district', $user->district ?? '') }}" required>
                                            <small class="text-danger">{{ $errors->first('district') }}</small>
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" name="state"
                                                placeholder="State *" value="{{ old('state', $user->state ?? '') }}"
                                                required>
                                            <small class="text-danger">{{ $errors->first('state') }}</small>
                                        </div>

                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-md-6">




                                        <div class="form-group mb-3">
                                            <input type="number" name="pin_code" class="form-control"
                                                placeholder="Pin Code *"
                                                value="{{ old('pin_code', $user->pin_code ?? '') }}" required>
                                            <small class="text-danger">{{ $errors->first('pin_code') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="text" name="chapter" class="form-control"
                                                placeholder="Chapter *"
                                                value="{{ old('chapter', $user->chapter ?? '') }}" required>
                                            <small class="text-danger">{{ $errors->first('chapter') }}</small>
                                        </div>



                                        <div class="form-group mb-3">
                                            <select class="form-control" name="nationality" required>
                                                <option disabled
                                                    {{ (old('nationality') ?: $user->nationality ?? '') ? '' : 'selected' }}
                                                    hidden>
                                                    Nationality *</option>
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
                                            <textarea class="form-control" name="aadhar_address" rows="3" placeholder="Aadhar/Pan Address *" required>{{ old('aadhar_address', $user->aadhar_address ?? '') }}</textarea>
                                            <small class="text-danger">{{ $errors->first('aadhar_address') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="email" name="alternate_email" class="form-control"
                                                placeholder="Alternate Email Address"
                                                value="{{ old('alternate_email', $user->alternate_email ?? '') }}">
                                            <small class="text-danger">{{ $errors->first('alternate_email') }}</small>
                                        </div>


                                        {{-- <div class="form-group mb-3">
                                                    <input type="text" name="d_o_b" class="form-control"
                                                        placeholder="Date of Birth *" required>
                                                </div> --}}
                                        {{-- <div class="form-group mb-3">
                                                    <input type="text" id="dob" name="d_o_b"
                                                        class="form-control"
                                                        placeholder="Date of Birth (dd-mm-yyyy) *" required>
                                                </div>

                                                <script>
                                                    document.getElementById('dob').addEventListener('input', function(e) {
                                                        let value = e.target.value.replace(/\D/g, '').slice(0, 8);
                                                        if (value.length >= 5) {
                                                            value = value.replace(/(\d{2})(\d{2})(\d{0,4})/, '$1-$2-$3');
                                                        } else if (value.length >= 3) {
                                                            value = value.replace(/(\d{2})(\d{0,2})/, '$1-$2');
                                                        }
                                                        e.target.value = value;
                                                    });
                                                </script> --}}

                                        <div class="form-group mb-3">
                                            {{-- <input type="text" name="d_o_b" class="form-control"
                                                placeholder="Date of Birth (dd-mm-yyyy) *"
                                                value="{{ old('d_o_b', $user->d_o_b ? $user->d_o_b->format('d-m-Y') : '') }}"
                                                pattern="\d{2}-\d{2}-\d{4}" title="Format: dd-mm-yyyy"
                                                inputmode="numeric" required> --}}
                                            <input type="text" name="d_o_b" class="form-control"
                                                placeholder="Date of Birth (yyyy-mm-dd) *"
                                                value="{{ old('d_o_b', $user->d_o_b ?? '') }}"
                                                pattern="\d{4}-\d{2}-\d{2}" title="Format: yyyy-mm-dd" required>
                                            <small class="text-danger">{{ $errors->first('d_o_b') }}</small>
                                        </div>



                                        <div class="form-group mb-3">
                                            <input type="text" name="birth_place" class="form-control"
                                                placeholder="Birth Place *"
                                                value="{{ old('birth_place', $user->birth_place ?? '') }}" required>
                                            <small class="text-danger">{{ $errors->first('birth_place') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <select class="form-control" name="gender" required>
                                                <option disabled
                                                    {{ (old('gender') ?: $user->gender ?? '') ? '' : 'selected' }} hidden>
                                                    Gender *
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

                                        <div class="form-group mb-3">
                                            <input type="number" name="age" class="form-control"
                                                placeholder="Age *" value="{{ old('age', $user->age ?? '') }}" required>
                                            <small class="text-danger">{{ $errors->first('age') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <select class="form-control" name="marital_status" required>
                                                <option disabled
                                                    {{ (old('marital_status') ?: $user->marital_status ?? '') ? '' : 'selected' }}
                                                    hidden>
                                                    Marital Status *</option>
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
                                            <input type="text" name="religion" class="form-control"
                                                placeholder="Religion *"
                                                value="{{ old('religion', $user->religion ?? '') }}" required>
                                            <small class="text-danger">{{ $errors->first('religion') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="text" name="sub_cast" class="form-control"
                                                placeholder="Sub caste *"
                                                value="{{ old('sub_cast', $user->sub_cast ?? '') }}" required>
                                            <small class="text-danger">{{ $errors->first('sub_cast') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <select class="form-control" name="blood_group" required>
                                                <option disabled
                                                    {{ (old('blood_group') ?: $user->blood_group ?? '') ? '' : 'selected' }}
                                                    hidden>Blood
                                                    Group *</option>
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
                                            <select class="form-control" name="specially_abled" required>
                                                <option disabled
                                                    {{ (old('specially_abled') ?: $user->specially_abled ?? '') ? '' : 'selected' }}
                                                    hidden>
                                                    Specially Abled *</option>
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
