@extends('user.layout.master')
@section('step')
    <button class="btn btn-purple me-2" style="background-color: #393185; color: white;">Step 2 of
        7</button>
@endsection

@section('content')
    <style>
        .modern-form-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            border: none;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #393185;
            margin-bottom: 8px;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 60px;
            height: 2px;
            background: #393185;
        }

        .form-control-modern {
            height: 45px;
            border-radius: 8px;
            border: 1px solid #e1e5e9;
            padding: 0 15px;
            font-size: 14px;
            color: #495057;
        }

        .form-control-modern:focus {
            border-color: #393185;
            box-shadow: 0 0 0 0.2rem rgba(57, 49, 133, 0.25);
        }

        .tab-modern .nav-link {
            border: none;
            background: #f8f9fa;
            color: #6c757d;
            border-radius: 8px 8px 0 0;
            margin-right: 5px;
            padding: 12px 20px;
        }

        .tab-modern .nav-link.active {
            background: #393185;
            color: white;
        }

        .tab-content-modern {
            border: 1px solid #e1e5e9;
            border-radius: 0 8px 8px 8px;
            background: white;
            padding: 20px;
        }

        .sub-card {
            background: #f8f9fc;
            border-radius: 8px;
            padding: 15px;
            border: 1px solid #e1e5e9;
        }

        .upload-box {
            border: 2px dashed #d1d5db;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .upload-box:hover {
            border-color: #393185;
            background: #f8f9fe;
        }

        .btn-modern {
            border-radius: 8px;
            padding: 12px 30px;
            font-weight: 500;
        }

        .btn-previous {
            background: #f8f9fa;
            color: #6c757d;
            border: 2px solid #e9ecef;
        }

        .btn-next {
            background: #393185;
            color: white;
            border: 2px solid #393185;
        }

        .modal-modern .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .modern-form-card {
                margin: 10px;
                padding: 15px;
            }

            .tab-modern .nav-link {
                margin-right: 2px;
                padding: 10px 15px;
                font-size: 14px;
            }
        }

        .nav.nav-tabs .nav-link {
            color: #4C4C4C;
            font-size: 16px;
            font-weight: 600;
            background: none;
            border: none;
            padding-bottom: 8px;
            position: relative;

        }

        .nav.nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50%;
            height: 3.5px;
            margin-left: 15px;
            background: #4C4C4C;
        }
    </style>
    <!-- Main Content -->
    <div class="col-lg-9 main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{ route('user.step2.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card form-card">
                            <div class="card-body">

                                <div class="step-card">
                                    <div class="card-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div>
                                        <h3 class="card-title">Family Details</h3>
                                        <p class="card-subtitle">Information about your family members</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6">

                                        <div class="form-group mb-3">
                                            <input type="number" class="form-control" name="number_family_members"
                                                placeholder="Number of Family Members *"
                                                value="{{ old('number_family_members') }}" required>
                                            <small class="text-danger">{{ $errors->first('number_family_members') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="number" class="form-control" name="total_family_income"
                                                placeholder="Total Family Income (₹) *"
                                                value="{{ old('total_family_income') }}" required>
                                            <small class="text-danger">{{ $errors->first('total_family_income') }}</small>
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="number" class="form-control" name="total_students"
                                                placeholder="Total Number of Students *" value="{{ old('total_students') }}"
                                                required>
                                            <small class="text-danger">{{ $errors->first('total_students') }}</small>
                                        </div>

                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" name="family_member_diksha"
                                                placeholder="Family Member Taken Diksha "
                                                value="{{ old('family_member_diksha') }}">
                                            <small class="text-danger">{{ $errors->first('family_member_diksha') }}</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <input type="number" class="form-control" name="total_insurance_coverage"
                                                placeholder="Total Insurance Coverage of Family (₹) *"
                                                value="{{ old('total_insurance_coverage') }}" required>
                                            <small
                                                class="text-danger">{{ $errors->first('total_insurance_coverage') }}</small>
                                        </div>



                                        <div class="form-group mb-3">
                                            <input type="number" class="form-control" name="total_premium_paid"
                                                placeholder="Total Premium Paid in Rupees/Year *"
                                                value="{{ old('total_premium_paid') }}" required>
                                            <small class="text-danger">{{ $errors->first('total_premium_paid') }}</small>
                                        </div>

                                    </div>
                                </div>


                                <hr>


                                <!-- Bootstrap Tabs for Parents Details -->
                                <ul class="nav nav-tabs" id="parentTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="father-tab" data-bs-toggle="tab"
                                            data-bs-target="#father" type="button" role="tab" aria-controls="father"
                                            aria-selected="true">Father's Details*</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="mother-tab" data-bs-toggle="tab"
                                            data-bs-target="#mother" type="button" role="tab" aria-controls="mother"
                                            aria-selected="false">Mother's Details*</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="additional-tab" data-bs-toggle="tab"
                                            data-bs-target="#additional" type="button" role="tab"
                                            aria-controls="additional" aria-selected="false">Additional
                                            Information*</button>
                                    </li>
                                </ul>
                                <div class="tab-content mt-4" id="parentTabsContent">
                                    <!-- Father's Details Tab -->
                                    <div class="tab-pane fade show active" id="father" role="tabpanel"
                                        aria-labelledby="father-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="father_name"
                                                        placeholder="Father's Name *" value="{{ old('father_name') }}"
                                                        required>
                                                    <small class="text-danger">{{ $errors->first('father_name') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="number" class="form-control" name="father_age"
                                                        placeholder="Age *" value="{{ old('father_age') }}" required
                                                        min="18" max="120">
                                                    <small class="text-danger">{{ $errors->first('father_age') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <select class="form-control" name="father_marital_status" required>
                                                        <option disabled
                                                            {{ old('father_marital_status') ? '' : 'selected' }} hidden>
                                                            Marital Status *</option>
                                                        <option value="married"
                                                            {{ old('father_marital_status') == 'married' ? 'selected' : '' }}>
                                                            Married</option>
                                                        <option value="unmarried"
                                                            {{ old('father_marital_status') == 'unmarried' ? 'selected' : '' }}>
                                                            Unmarried</option>
                                                    </select>
                                                    <small
                                                        class="text-danger">{{ $errors->first('father_marital_status') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control"
                                                        name="father_qualification" placeholder="Qualification *"
                                                        value="{{ old('father_qualification') }}" required>
                                                    <small
                                                        class="text-danger">{{ $errors->first('father_qualification') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="father_occupation"
                                                        placeholder="Occupation *" value="{{ old('father_occupation') }}"
                                                        required>
                                                    <small
                                                        class="text-danger">{{ $errors->first('father_occupation') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="tel" class="form-control" name="father_mobile"
                                                        placeholder="Mobile Number *" value="{{ old('father_mobile') }}"
                                                        required>
                                                    <small
                                                        class="text-danger">{{ $errors->first('father_mobile') }}</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">

                                                <div class="form-group mb-3">
                                                    <input type="email" class="form-control" name="father_email"
                                                        placeholder="Father's Email address"
                                                        value="{{ old('father_email') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('father_email') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="number" class="form-control"
                                                        name="father_yearly_gross_income"
                                                        placeholder="Father's Yearly Gross Income (₹) *"
                                                        value="{{ old('father_yearly_gross_income') }}" required>
                                                    <small
                                                        class="text-danger">{{ $errors->first('father_yearly_gross_income') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="number" class="form-control"
                                                        name="father_individual_insurance_coverage"
                                                        placeholder="Father's Individual Insurance Coverage Value (₹) "
                                                        value="{{ old('father_individual_insurance_coverage') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('father_individual_insurance_coverage') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="number" class="form-control"
                                                        name="father_individual_premium_paid"
                                                        placeholder="Father's Individual Premium Paid Year (₹) "
                                                        value="{{ old('father_individual_premium_paid') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('father_individual_premium_paid') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <div class="photo-upload-box">
                                                        <div class="row mb-2 align-items-center">
                                                            <div class="col-9">
                                                                <span class="photo-label">Father's Aadhaar Card*</span>
                                                                <input type="file" id="father_aadhaar"
                                                                    name="father_aadhaar" hidden
                                                                    accept=".jpg,.jpeg,.png,.pdf" required>
                                                                <small
                                                                    class="text-danger">{{ $errors->first('father_aadhaar') }}</small>
                                                            </div>
                                                            <div class="col-3">
                                                                <label for="father_aadhaar" class="upload-btn">
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
                                                                            <button type="button"
                                                                                class="remove-upload btn bt-sm"
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
                                                    <div class="photo-upload-box">
                                                        <div class="row mb-2 align-items-center">
                                                            <div class="col-9">
                                                                <span class="photo-label">Father's Passport Size
                                                                    Photo</span>
                                                                <input type="file" id="father_photo"
                                                                    name="father_photo" hidden accept=".jpg,.jpeg,.png">
                                                                <small
                                                                    class="text-danger">{{ $errors->first('father_photo') }}</small>
                                                            </div>
                                                            <div class="col-3">
                                                                <label for="father_photo" class="upload-btn">
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
                                                                            <button type="button"
                                                                                class="remove-upload btn bt-sm"
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
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Mother's Details Tab -->
                                    <div class="tab-pane fade" id="mother" role="tabpanel"
                                        aria-labelledby="mother-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="mother_name"
                                                        placeholder="Mother's Name *" value="{{ old('mother_name') }}"
                                                        required>
                                                    <small class="text-danger">{{ $errors->first('mother_name') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="number" class="form-control" name="mother_age"
                                                        placeholder="Age *" value="{{ old('mother_age') }}" required
                                                        min="18" max="120">
                                                    <small class="text-danger">{{ $errors->first('mother_age') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <select class="form-control" name="mother_marital_status" required>
                                                        <option disabled
                                                            {{ old('mother_marital_status') ? '' : 'selected' }} hidden>
                                                            Marital Status *</option>
                                                        <option value="married"
                                                            {{ old('mother_marital_status') == 'married' ? 'selected' : '' }}>
                                                            Married</option>
                                                        <option value="unmarried"
                                                            {{ old('mother_marital_status') == 'unmarried' ? 'selected' : '' }}>
                                                            Unmarried</option>
                                                    </select>
                                                    <small
                                                        class="text-danger">{{ $errors->first('mother_marital_status') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control"
                                                        name="mother_qualification" placeholder="Qualification *"
                                                        value="{{ old('mother_qualification') }}" required>
                                                    <small
                                                        class="text-danger">{{ $errors->first('mother_qualification') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="mother_occupation"
                                                        placeholder="Occupation *" value="{{ old('mother_occupation') }}"
                                                        required>
                                                    <small
                                                        class="text-danger">{{ $errors->first('mother_occupation') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="tel" class="form-control" name="mother_mobile"
                                                        placeholder="Mobile Number *" value="{{ old('mother_mobile') }}"
                                                        required>
                                                    <small
                                                        class="text-danger">{{ $errors->first('mother_mobile') }}</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">

                                                <div class="form-group mb-3">
                                                    <input type="email" class="form-control" name="mother_email"
                                                        placeholder="Mother's Email address"
                                                        value="{{ old('mother_email') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('mother_email') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="number" class="form-control"
                                                        name="mother_yearly_gross_income"
                                                        placeholder="Mother's Yearly Gross Income (₹) *"
                                                        value="{{ old('mother_yearly_gross_income') }}" required>
                                                    <small
                                                        class="text-danger">{{ $errors->first('mother_yearly_gross_income') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="number" class="form-control"
                                                        name="mother_individual_insurance_coverage"
                                                        placeholder="Mother's Individual Insurance Coverage Value (₹) "
                                                        value="{{ old('mother_individual_insurance_coverage') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('mother_individual_insurance_coverage') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="number" class="form-control"
                                                        name="mother_individual_premium_paid"
                                                        placeholder="Mother's Individual Premium Paid Year (₹) "
                                                        value="{{ old('mother_individual_premium_paid') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('mother_individual_premium_paid') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <div class="photo-upload-box">
                                                        <div class="row mb-2 align-items-center">
                                                            <div class="col-9">
                                                                <span class="photo-label">Mother's Aadhaar Card*</span>
                                                                <input type="file" id="mother_aadhaar"
                                                                    name="mother_aadhaar" hidden
                                                                    accept=".jpg,.jpeg,.png,.pdf" required>
                                                                <small
                                                                    class="text-danger">{{ $errors->first('mother_aadhaar') }}</small>
                                                            </div>
                                                            <div class="col-3">
                                                                <label for="mother_aadhaar" class="upload-btn">
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
                                                                            <button type="button"
                                                                                class="remove-upload btn bt-sm"
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
                                                    <div class="photo-upload-box">
                                                        <div class="row mb-2 align-items-center">
                                                            <div class="col-9">
                                                                <span class="photo-label">Mother's Passport Size
                                                                    Photo</span>
                                                                <input type="file" id="mother_photo"
                                                                    name="mother_photo" hidden accept=".jpg,.jpeg,.png">
                                                                <small
                                                                    class="text-danger">{{ $errors->first('mother_photo') }}</small>
                                                            </div>
                                                            <div class="col-3">
                                                                <label for="mother_photo" class="upload-btn">
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
                                                                            <button type="button"
                                                                                class="remove-upload btn bt-sm"
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
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Additional Information Tab -->
                                    <div class="tab-pane fade" id="additional" role="tabpanel"
                                        aria-labelledby="additional-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                {{-- <div class="form-group mb-3">
                                                    <label>Scholar Details</label>
                                                    <div class="form-group mb-3">
                                                        <input type="email" class="form-control"
                                                            name="additional_email" placeholder="Additional Email"
                                                            value="{{ old('additional_email') }}">
                                                        <small
                                                            class="text-danger">{{ $errors->first('additional_email') }}</small>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="number" class="form-control"
                                                            name="yearly_gross_income"
                                                            placeholder="Yearly Gross Income (₹)"
                                                            value="{{ old('yearly_gross_income') }}">
                                                        <small
                                                            class="text-danger">{{ $errors->first('yearly_gross_income') }}</small>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="number" class="form-control"
                                                            name="individual_insurance_coverage"
                                                            placeholder="Individual Insurance Coverage (₹) *"
                                                            value="{{ old('individual_insurance_coverage') }}" required>
                                                        <small
                                                            class="text-danger">{{ $errors->first('individual_insurance_coverage') }}</small>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="number" class="form-control"
                                                            name="individual_premium_paid"
                                                            placeholder="Individual Premium Paid (₹) *"
                                                            value="{{ old('individual_premium_paid') }}" required>
                                                        <small
                                                            class="text-danger">{{ $errors->first('individual_premium_paid') }}</small>
                                                    </div>
                                                </div> --}}
                                                <div class="form-group mb-3">
                                                    <label>Do You Have Sibling?</label>
                                                    <div>
                                                        <input type="radio" name="has_sibling" value="yes"
                                                            id="has_sibling_yes"
                                                            {{ old('has_sibling') == 'yes' ? 'checked' : '' }}> <label
                                                            for="has_sibling_yes">Yes</label>
                                                        <input type="radio" name="has_sibling" value="no"
                                                            id="has_sibling_no"
                                                            {{ old('has_sibling') == 'no' || !old('has_sibling') ? 'checked' : '' }}>
                                                        <label for="has_sibling_no">No</label>
                                                    </div>
                                                    <small class="text-danger">{{ $errors->first('has_sibling') }}</small>
                                                </div>
                                                <div id="sibling-fields" style="display: none;">
                                                    <div class="form-group mb-3">
                                                        <input type="number" class="form-control"
                                                            name="number_of_siblings" placeholder="Number Of Siblings *"
                                                            value="{{ old('number_of_siblings') }}">
                                                        <small
                                                            class="text-danger">{{ $errors->first('number_of_siblings') }}</small>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control" name="sibling_name_1"
                                                            placeholder="Name *" value="{{ old('sibling_name_1') }}">
                                                        <small
                                                            class="text-danger">{{ $errors->first('sibling_name_1') }}</small>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control"
                                                            name="sibling_qualification" placeholder="Qualification"
                                                            value="{{ old('sibling_qualification') }}">
                                                        <small
                                                            class="text-danger">{{ $errors->first('sibling_qualification') }}</small>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control"
                                                            name="sibling_occupation" placeholder="Occupation"
                                                            value="{{ old('sibling_occupation') }}">
                                                        <small
                                                            class="text-danger">{{ $errors->first('sibling_occupation') }}</small>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="sibling-fields-2" style="display: none;">
                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control" name="sibling_mobile"
                                                            placeholder="Mobile Number"
                                                            value="{{ old('sibling_mobile') }}">
                                                        <small
                                                            class="text-danger">{{ $errors->first('sibling_mobile') }}</small>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="email" class="form-control" name="sibling_email"
                                                            placeholder="Email Address"
                                                            value="{{ old('sibling_email') }}">
                                                        <small
                                                            class="text-danger">{{ $errors->first('sibling_email') }}</small>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="number" class="form-control"
                                                            name="sibling_yearly_income"
                                                            placeholder="Yearly Gross Income (₹)"
                                                            value="{{ old('sibling_yearly_income') }}">
                                                        <small
                                                            class="text-danger">{{ $errors->first('sibling_yearly_income') }}</small>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="number" class="form-control"
                                                            name="sibling_insurance_coverage"
                                                            placeholder="Individual Insurance Coverage Value (₹)"
                                                            value="{{ old('sibling_insurance_coverage') }}">
                                                        <small
                                                            class="text-danger">{{ $errors->first('sibling_insurance_coverage') }}</small>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="number" class="form-control"
                                                            name="sibling_premium_paid"
                                                            placeholder="Individual Premium Paid Year (₹)"
                                                            value="{{ old('sibling_premium_paid') }}">
                                                        <small
                                                            class="text-danger">{{ $errors->first('sibling_premium_paid') }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bootstrap Tabs for Relatives Details -->
                                <ul class="nav nav-tabs" id="relativesTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="paternal-tab" data-bs-toggle="tab"
                                            data-bs-target="#paternal" type="button" role="tab"
                                            aria-controls="paternal" aria-selected="true">Paternal Side</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="maternal-tab" data-bs-toggle="tab"
                                            data-bs-target="#maternal" type="button" role="tab"
                                            aria-controls="maternal" aria-selected="false">Maternal Side</button>
                                    </li>
                                </ul>
                                <div class="tab-content mt-4" id="relativesTabsContent">
                                    <!-- Paternal Side Tab -->
                                    <div class="tab-pane fade show active" id="paternal" role="tabpanel"
                                        aria-labelledby="paternal-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="paternal_uncle_name"
                                                        placeholder="Paternal Uncle's Name">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="tel" class="form-control"
                                                        name="paternal_uncle_mobile" placeholder="His Mobile Number">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="email" class="form-control"
                                                        name="paternal_uncle_email" placeholder="His Email Address">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="paternal_aunt_name"
                                                        placeholder="Paternal Aunt's Name">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="tel" class="form-control"
                                                        name="paternal_aunt_mobile" placeholder="Her Mobile Number">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="email" class="form-control" name="paternal_aunt_email"
                                                        placeholder="Her Email Address">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Maternal Side Tab -->
                                    <div class="tab-pane fade" id="maternal" role="tabpanel"
                                        aria-labelledby="maternal-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="maternal_uncle_name"
                                                        placeholder="Maternal Uncle's Name">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="tel" class="form-control"
                                                        name="maternal_uncle_mobile" placeholder="His Mobile Number">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="email" class="form-control"
                                                        name="maternal_uncle_email" placeholder="His Email Address">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="maternal_aunt_name"
                                                        placeholder="Maternal Aunt's Name">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="tel" class="form-control"
                                                        name="maternal_aunt_mobile" placeholder="Her Mobile Number">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="email" class="form-control" name="maternal_aunt_email"
                                                        placeholder="Her Email Address">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4 mb-4">
                            {{-- <button  type="button" class="btn" style="background:#988DFF1F;color:gray;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    stroke="gray" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M15 18l-6-6 6-6" />
                                </svg>
                                Previous
                            </button> --}}
                            <a href="{{ route('user.step1') }}" class="btn"
                                style="background:#988DFF1F;color:gray;border:1px solid #393185;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    stroke="gray" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M15 18l-6-6 6-6" />
                                </svg>
                                Previous
                            </a>

                            <button type="submit" class="btn" style="background:#393185;color:white;">
                                Next Step
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    stroke="white" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M9 6l6 6-6 6" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to show/hide sibling fields
            function toggleSiblingFields() {
                const hasSibling = document.querySelector('input[name="has_sibling"]:checked').value;
                const siblingFields1 = document.getElementById('sibling-fields');
                const siblingFields2 = document.getElementById('sibling-fields-2');
                const siblingInputs = document.querySelectorAll('#sibling-fields input, #sibling-fields-2 input');

                if (hasSibling === 'yes') {
                    siblingFields1.style.display = 'block';
                    siblingFields2.style.display = 'block';
                } else {
                    siblingFields1.style.display = 'none';
                    siblingFields2.style.display = 'none';
                    // Reset all sibling fields
                    siblingInputs.forEach(input => {
                        input.value = '';
                    });
                }
            }

            // Initialize sibling fields based on old value
            toggleSiblingFields();

            // Add event listeners to radio buttons
            const radioButtons = document.querySelectorAll('input[name="has_sibling"]');
            radioButtons.forEach(radio => {
                radio.addEventListener('change', toggleSiblingFields);
            });

            // Initialize Bootstrap tabs
            var triggerTabList = [].slice.call(document.querySelectorAll('#parentTabs button'))
            triggerTabList.forEach(function(triggerEl) {
                var tabTrigger = new bootstrap.Tab(triggerEl)
                triggerEl.addEventListener('click', function(event) {
                    event.preventDefault()
                    tabTrigger.show()
                })
            })

            // Initialize relatives tabs
            var relativesTabList = [].slice.call(document.querySelectorAll('#relativesTabs button'))
            relativesTabList.forEach(function(triggerEl) {
                var tabTrigger = new bootstrap.Tab(triggerEl)
                triggerEl.addEventListener('click', function(event) {
                    event.preventDefault()
                    tabTrigger.show()
                })
            })
        })
    </script>
@endsection
