@extends('user.layout.master')
@section('step')
    <button class="btn btn-purple me-2" style="background-color: #393185; color: white;">Step 5 of
        7</button>
@endsection
@section('content')
    <style>
        .section-divider {
            height: 1px;
            background: #e9ecef;
            margin: 30px 0;
        }
    </style>
    <!-- Main Content -->
    <div class="col-lg-9 main-content">
        <!-- Hold Remark Alert -->
        @if ($guarantorDetail && $guarantorDetail->submit_status === 'resubmit' && $guarantorDetail->admin_remark)
            <div class="alert alert-warning alert-dismissible fade show" role="alert"
                style="background-color: #fff3cd; border-color: #ffeaa7; color: #856404; border-radius: 8px; margin-bottom: 20px;">
                <strong><i class="bi bi-exclamation-triangle-fill"></i> Hold Notice:</strong>
                <p style="margin: 8px 0 0 0; font-size: 14px;">{{ $guarantorDetail->admin_remark }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{ route('user.step5.store') }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        @if (session('success'))
                            <div class="alert alert-warning alert-dismissible fade show position-relative" role="alert"
                                id="successAlert">

                                {{ session('success') }}

                                <button type="button" class="close custom-close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="row mb-3">
                            <div class="col-md-5 offset-md-1">

                                <select class="form-control" name="financial_asset_type" id="financial_asset_type"
                                    style="border:2px solid #393185;border-radius:15px;" readonly required>
                                    <option disabled
                                        {{ (old('financial_asset_type') ?: $user->financial_asset_type ?? '') ? '' : 'selected' }}
                                        hidden>Financial Asst Type *</option>
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
                                    style="border:2px solid #393185;border-radius:15px;" readonly required>
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
                        </div>
                        <div class="card form-card">
                            <div class="card-body">

                                <div class="step-card">
                                    <div class="card-icon">
                                        <i class="bi bi-check2-square"></i>
                                    </div>
                                    <div>
                                        <h3 class="card-title">Guarantor Details</h3>
                                        <p class="card-subtitle">Information about your Guarantors</p>
                                    </div>
                                </div>

                                <!-- PAN Validation Message Container -->
                                <div id="panValidationMessage" class="alert alert-dismissible fade show" role="alert"
                                    style="display: none; margin-bottom: 20px;">
                                    <span id="panValidationText"></span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>

                                <!-- Important Note Box -->
                                <div
                                    style="background-color: #FEF6E0; border: 1px solid #FBBA00; border-radius: 8px; padding: 12px; margin-bottom: 20px;">
                                    <p class="mb-0" style="color: #E31E24; font-size: 15px;font-weight: 500;">
                                        <strong>Note:</strong> The guarantor must strictly belong to the Jain community and
                                        should be between 25 to 65 years of age. Students, housewives, father, mother,
                                        brother, or sister are not eligible to act as guarantors. Additionally, the
                                        guarantor and the applicant must not share the same address, and both guarantors
                                        should also have different residential addresses.
                                    </p>
                                </div>

                                <!--  Guarantor Fields -->
                                <div class="guarantor-section">
                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                            <h4 class="title mb-3" style="color:#4C4C4C;font-size:18px;">First Guarantor
                                            </h4>
                                            <div class="form-group mb-3">
                                                <label for="g_one_pan" class="form-label">PAN Card Number <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" id="g_one_pan" name="g_one_pan" class="form-control"
                                                    placeholder="Enter 10-character PAN number"
                                                    value="{{ old('g_one_pan') ?: $guarantorDetail->g_one_pan ?? '' }}"
                                                    required>
                                                <small class="text-danger">{{ $errors->first('g_one_pan') }}</small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="g_one_name" class="form-label">Name <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" id="g_one_name" class="form-control" name="g_one_name"
                                                    placeholder="Enter guarantor's name"
                                                    value="{{ old('g_one_name') ?: $guarantorDetail->g_one_name ?? '' }}"
                                                    required>
                                                <small class="text-danger">{{ $errors->first('g_one_name') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="g_one_gender" class="form-label">Gender <span
                                                        style="color: red;">*</span></label>
                                                <select id="g_one_gender" class="form-control" name="g_one_gender" required>
                                                    <option disabled
                                                        {{ (old('g_one_gender') ?: $guarantorDetail->g_one_gender ?? '') ? '' : 'selected' }}
                                                        hidden>
                                                        Select Gender
                                                    </option>
                                                    <option value="male"
                                                        {{ (old('g_one_gender') ?: $guarantorDetail->g_one_gender ?? '') == 'male' ? 'selected' : '' }}>
                                                        Male</option>
                                                    <option value="female"
                                                        {{ (old('g_one_gender') ?: $guarantorDetail->g_one_gender ?? '') == 'female' ? 'selected' : '' }}>
                                                        Female
                                                    </option>
                                                </select>
                                                <small class="text-danger">{{ $errors->first('g_one_gender') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="g_one_permanent_flat_no" class="form-label">Flat No, Building
                                                    No/Street Name <span style="color: red;">*</span></label>
                                                <textarea id="g_one_permanent_flat_no" class="form-control" name="g_one_permanent_flat_no" rows="3"
                                                    placeholder="Enter flat no, building no, street name" required>{{ old('g_one_permanent_flat_no') ?: $guarantorDetail->g_one_permanent_flat_no ?? '' }}</textarea>
                                                <small
                                                    class="text-danger">{{ $errors->first('g_one_permanent_flat_no') }}</small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="g_one_permanent_address" class="form-label">Address <span
                                                        style="color: red;">*</span></label>
                                                <textarea id="g_one_permanent_address" class="form-control" name="g_one_permanent_address" rows="3"
                                                    placeholder="Enter full address" required>{{ old('g_one_permanent_address') ?: $guarantorDetail->g_one_permanent_address ?? '' }}</textarea>
                                                <small
                                                    class="text-danger">{{ $errors->first('g_one_permanent_address') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="g_one_city" class="form-label">City <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" id="g_one_city" class="form-control"
                                                    name="g_one_city" placeholder="Enter city"
                                                    value="{{ old('g_one_city') ?: $guarantorDetail->g_one_permanent_city ?? '' }}"
                                                    required>
                                                <small class="text-danger">{{ $errors->first('g_one_city') }}</small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="g_one_district" class="form-label">District <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" id="g_one_district" class="form-control"
                                                    name="g_one_district" placeholder="Enter district"
                                                    value="{{ old('g_one_district') ?: $guarantorDetail->g_one_permanent_district ?? '' }}"
                                                    required>
                                                <small class="text-danger">{{ $errors->first('g_one_district') }}</small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="g_one_state" class="form-label">State <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" id="g_one_state" class="form-control"
                                                    name="g_one_state" placeholder="Enter state"
                                                    value="{{ old('g_one_state') ?: $guarantorDetail->g_one_permanent_state ?? '' }}"
                                                    required>
                                                <small class="text-danger">{{ $errors->first('g_one_state') }}</small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="g_one_pincode" class="form-label">Pin Code <span
                                                        style="color: red;">*</span></label>
                                                <input type="number" id="g_one_pincode" class="form-control"
                                                    name="g_one_pincode" placeholder="Enter pin code"
                                                    value="{{ old('g_one_pincode') ?: $guarantorDetail->g_one_permanent_pincode ?? '' }}"
                                                    required>
                                                <small class="text-danger">{{ $errors->first('g_one_pincode') }}</small>
                                            </div>
                                            {{-- <div class="form-group mb-3">
                                                <input type="tel" name="g_one_phone" class="form-control"
                                                    placeholder="Mobile number *"
                                                    value="{{ old('g_one_phone') ?: $guarantorDetail->g_one_phone ?? '' }}"
                                                    maxlength="10" required>
                                                <small class="text-danger">{{ $errors->first('g_one_phone') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="email" name="g_one_email" class="form-control"
                                                    placeholder="Email ID *"
                                                    value="{{ old('g_one_email') ?: $guarantorDetail->g_one_email ?? '' }}"
                                                    required>
                                                <small class="text-danger">{{ $errors->first('g_one_email') }}</small>
                                            </div> --}}

                                            <div class="form-group mb-3">
                                                <label for="g_one_phone" class="form-label">Mobile Number <span
                                                        style="color: red;">*</span></label>
                                                <input type="tel" id="g_one_phone" name="g_one_phone"
                                                    class="form-control" placeholder="Enter mobile number"
                                                    value="{{ old('g_one_phone') ?: $guarantorDetail->g_one_phone ?? '' }}"
                                                    maxlength="10" required>
                                                <small class="text-danger">{{ $errors->first('g_one_phone') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="g_one_email" class="form-label">Email ID <span
                                                        style="color: red;">*</span></label>
                                                <input type="email" id="g_one_email" name="g_one_email"
                                                    class="form-control" placeholder="Enter email address"
                                                    value="{{ old('g_one_email') ?: $guarantorDetail->g_one_email ?? '' }}"
                                                    required>
                                                <small class="text-danger">{{ $errors->first('g_one_email') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="g_one_relation_with_student" class="form-label">Relation with
                                                    Student <span style="color: red;">*</span></label>
                                                <input type="text" id="g_one_relation_with_student"
                                                    class="form-control" name="g_one_relation_with_student"
                                                    placeholder="Enter relation with student"
                                                    value="{{ old('g_one_relation_with_student') ?: $guarantorDetail->g_one_relation_with_student ?? '' }}"
                                                    required>
                                                <small
                                                    class="text-danger">{{ $errors->first('g_one_relation_with_student') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="g_one_aadhar_card_number" class="form-label">Aadhar Card
                                                    Number <span style="color: red;">*</span></label>
                                                <input type="number" id="g_one_aadhar_card_number"
                                                    name="g_one_aadhar_card_number" class="form-control"
                                                    placeholder="Enter 12-digit Aadhar number" minlength="12"
                                                    maxlength="12"
                                                    value="{{ old('g_one_aadhar_card_number') ?: $guarantorDetail->g_one_aadhar_card_number ?? '' }}"
                                                    required>
                                                <small
                                                    class="text-danger">{{ $errors->first('g_one_aadhar_card_number') }}</small>
                                            </div>

                                            {{-- <div class="form-group mb-3">
                                                <label for="g_one_pan" class="form-label">PAN Card Number <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" id="g_one_pan" name="g_one_pan"
                                                    class="form-control" placeholder="Enter 10-character PAN number"
                                                    value="{{ old('g_one_pan') ?: $guarantorDetail->g_one_pan ?? '' }}"
                                                    required>
                                                <small class="text-danger">{{ $errors->first('g_one_pan') }}</small>
                                            </div> --}}

                                            <div class="form-group mb-3">
                                                <label for="g_one_d_o_b" class="form-label">Date of Birth
                                                    <span style="color: red;">*</span></label>
                                                <input type="date" name="g_one_d_o_b" class="form-control"
                                                    value="{{ old('g_one_d_o_b') ?: $guarantorDetail->g_one_d_o_b ?? '' }}"
                                                    min="{{ date('Y-m-d', strtotime('-65 years')) }}"
                                                    max="{{ date('Y-m-d', strtotime('-25 years')) }}" required>
                                                <small class="text-danger">{{ $errors->first('g_one_d_o_b') }}</small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="g_one_srvice" class="form-label">Name of Business/ Services
                                                    <span style="color: red;">*</span></label>
                                                <input type="text" name="g_one_srvice" class="form-control"
                                                    placeholder="Name of Business/ Services  "
                                                    value="{{ old('g_one_srvice') ?: $guarantorDetail->g_one_srvice ?? '' }}"
                                                    required>
                                                <small class="text-danger">{{ $errors->first('g_one_srvice') }}</small>

                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="g_one_income" class="form-label">Income as Per ITR<span
                                                        style="color: red;">*</span></label>
                                                <input type="number" name="g_one_income" class="form-control"
                                                    placeholder="Income as Per ITR"
                                                    value="{{ old('g_one_income') ?: $guarantorDetail->g_one_income ?? '' }}"
                                                    required>
                                                <small class="text-danger">{{ $errors->first('g_one_income') }}</small>

                                            </div>

                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                            <h4 class="title mb-3" style="color:#4C4C4C;font-size:18px;">Second Guarantor
                                            </h4>
                                            <div class="form-group mb-3">
                                                <label for="g_two_pan" class="form-label">PAN Card Number <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" id="g_two_pan" name="g_two_pan"
                                                    class="form-control" placeholder="Enter 10-character PAN number"
                                                    value="{{ old('g_two_pan') ?: $guarantorDetail->g_two_pan ?? '' }}"
                                                    required>
                                                <small class="text-danger">{{ $errors->first('g_two_pan') }}</small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="g_two_name" class="form-label">Name <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" class="form-control" name="g_two_name"
                                                    placeholder="Name "
                                                    value="{{ old('g_two_name') ?: $guarantorDetail->g_two_name ?? '' }}"
                                                    required>
                                                <small class="text-danger">{{ $errors->first('g_two_name') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="g_two_gender" class="form-label">Gender <span
                                                        style="color: red;">*</span></label>
                                                <select class="form-control" name="g_two_gender" required>
                                                    <option disabled
                                                        {{ (old('g_two_gender') ?: $guarantorDetail->g_two_gender ?? '') ? '' : 'selected' }}
                                                        hidden>
                                                        Gender
                                                    </option>
                                                    <option value="male"
                                                        {{ (old('g_two_gender') ?: $guarantorDetail->g_two_gender ?? '') == 'male' ? 'selected' : '' }}>
                                                        Male</option>
                                                    <option value="female"
                                                        {{ (old('g_two_gender') ?: $guarantorDetail->g_two_gender ?? '') == 'female' ? 'selected' : '' }}>
                                                        Female
                                                    </option>
                                                </select>
                                                <small class="text-danger">{{ $errors->first('g_two_gender') }}</small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="g_two_permanent_flat_no" class="form-label">Flat No, Building
                                                    No/Street Name <span style="color: red;">*</span></label>
                                                <textarea class="form-control" name="g_two_permanent_flat_no" rows="3"
                                                    placeholder="Flat No, Building No/Street Name" required>{{ old('g_two_permanent_flat_no') ?: $guarantorDetail->g_two_permanent_flat_no ?? '' }}</textarea>
                                                <small
                                                    class="text-danger">{{ $errors->first('g_two_permanent_flat_no') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="g_two_permanent_address" class="form-label">Address <span
                                                        style="color: red;">*</span></label>
                                                <textarea class="form-control" name="g_two_permanent_address" rows="3" placeholder="Permanent Address "
                                                    required>{{ old('g_two_permanent_address') ?: $guarantorDetail->g_two_permanent_address ?? '' }}</textarea>
                                                <small
                                                    class="text-danger">{{ $errors->first('g_two_permanent_address') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="g_two_city" class="form-label">City <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" class="form-control" name="g_two_city"
                                                    placeholder="City "
                                                    value="{{ old('g_two_city') ?: $guarantorDetail->g_two_permanent_city ?? '' }}"
                                                    required>
                                                <small class="text-danger">{{ $errors->first('g_two_city') }}</small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="g_two_district" class="form-label">District <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" class="form-control" name="g_two_district"
                                                    placeholder="District "
                                                    value="{{ old('g_two_district') ?: $guarantorDetail->g_two_permanent_district ?? '' }}"
                                                    required>
                                                <small class="text-danger">{{ $errors->first('g_two_district') }}</small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="g_two_state" class="form-label">State <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" class="form-control" name="g_two_state"
                                                    placeholder="State "
                                                    value="{{ old('g_two_state') ?: $guarantorDetail->g_two_permanent_state ?? '' }}"
                                                    required>
                                                <small class="text-danger">{{ $errors->first('g_two_state') }}</small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="g_two_pincode" class="form-label">Pin Code <span
                                                        style="color: red;">*</span></label>
                                                <input type="number" class="form-control" name="g_two_pincode"
                                                    placeholder="Pin Code "
                                                    value="{{ old('g_two_pincode') ?: $guarantorDetail->g_two_permanent_pincode ?? '' }}"
                                                    required>
                                                <small class="text-danger">{{ $errors->first('g_two_pincode') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="g_two_phone" class="form-label">Mobile Number <span
                                                        style="color: red;">*</span></label>
                                                <input type="tel" name="g_two_phone" class="form-control"
                                                    placeholder="Mobile Number "
                                                    value="{{ old('g_two_phone') ?: $guarantorDetail->g_two_phone ?? '' }}"
                                                    maxlength="10" required>
                                                <small class="text-danger">{{ $errors->first('g_two_phone') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="g_two_email" class="form-label">Email ID <span
                                                        style="color: red;">*</span></label>
                                                <input type="email" name="g_two_email" class="form-control"
                                                    placeholder="Email ID "
                                                    value="{{ old('g_two_email') ?: $guarantorDetail->g_two_email ?? '' }}"
                                                    required>
                                                <small class="text-danger">{{ $errors->first('g_two_email') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="g_two_relation_with_student" class="form-label">Relation with
                                                    Student <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control"
                                                    name="g_two_relation_with_student"
                                                    placeholder="Relation with student "
                                                    value="{{ old('g_two_relation_with_student') ?: $guarantorDetail->g_two_relation_with_student ?? '' }}"
                                                    required>
                                                <small
                                                    class="text-danger">{{ $errors->first('g_two_relation_with_student') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="g_two_aadhar_card_number" class="form-label">Aadhar Card
                                                    Number <span style="color: red;">*</span></label>
                                                <input type="number" name="g_two_aadhar_card_number"
                                                    class="form-control" placeholder="Aadhar Card Number " minlength="12"
                                                    maxlength="12"
                                                    value="{{ old('g_two_aadhar_card_number') ?: $guarantorDetail->g_two_aadhar_card_number ?? '' }}"
                                                    required>
                                                <small
                                                    class="text-danger">{{ $errors->first('g_two_aadhar_card_number') }}</small>
                                            </div>



                                            {{-- <div class="form-group mb-3">
                                                <label for="g_two_d_o_b" class="form-label">Date of Birth(yyyy-mm-dd)
                                                    <span style="color: red;">*</span></label>
                                                <input type="text" name="g_two_d_o_b" class="form-control"
                                                    placeholder="Date of Birth(yyyy-mm-dd) "
                                                    value="{{ old('g_two_d_o_b') ?: $guarantorDetail->g_two_d_o_b ?? '' }}"
                                                    pattern="\d{4}-\d{2}-\d{2}" title="Format: yyyy-mm-dd"
                                                    inputmode="numeric" required>
                                                <small class="text-danger">{{ $errors->first('g_two_d_o_b') }}</small>
                                            </div> --}}

                                            <div class="form-group mb-3">
                                                <label for="g_two_d_o_b" class="form-label">Date of Birth
                                                    <span style="color: red;">*</span></label>
                                                <input type="date" name="g_two_d_o_b" class="form-control"
                                                    value="{{ old('g_two_d_o_b') ?: $guarantorDetail->g_two_d_o_b ?? '' }}"
                                                    min="{{ date('Y-m-d', strtotime('-65 years')) }}"
                                                    max="{{ date('Y-m-d', strtotime('-25 years')) }}" required>
                                                <small class="text-danger">{{ $errors->first('g_two_d_o_b') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="g_two_srvice" class="form-label">Name of Business/ Services
                                                    <span style="color: red;">*</span></label>
                                                <input type="text" name="g_two_srvice" class="form-control"
                                                    placeholder="Name of Business/ Services  "
                                                    value="{{ old('g_two_srvice') ?: $guarantorDetail->g_two_srvice ?? '' }}"
                                                    required>
                                                <small class="text-danger">{{ $errors->first('g_two_srvice') }}</small>

                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="g_two_income" class="form-label">Income as Per ITR <span
                                                        style="color: red;">*</span></label>
                                                <input type="number" name="g_two_income" class="form-control"
                                                    placeholder="Income as Per ITR"
                                                    value="{{ old('g_two_income') ?: $guarantorDetail->g_two_income ?? '' }}"
                                                    required>
                                                <small class="text-danger">{{ $errors->first('g_two_income') }}</small>

                                            </div>
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
    </div>

    <script>
        function showMessage(type, text) {
            const box = document.getElementById('panValidationMessage');
            const msg = document.getElementById('panValidationText');

            box.classList.remove('alert-success', 'alert-danger');
            box.classList.add(type === 'success' ? 'alert-success' : 'alert-danger');

            msg.innerText = text;
            box.style.display = 'block';

            setTimeout(() => {
                box.style.display = 'none';
            }, 5000);
        }

        document.addEventListener('DOMContentLoaded', function() {

            /* ===== First Guarantor PAN Verification ===== */
            function verifyFirstGuarantorPan() {
                const panInput = document.getElementById('g_one_pan');
                let pan = panInput.value.trim().toUpperCase();

                if (pan.length !== 10) {
                    console.log('First Guarantor PAN length invalid');
                    return;
                }

                console.log('Verifying First Guarantor PAN:', pan);

                fetch("{{ route('user.verify.pan') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            pan: pan,
                            type: 'first'
                        })
                    })
                    .then(res => res.json())
                    .then(resp => {
                        console.log('First Guarantor PAN Response:', resp);

                        if (resp.status === true) {
                            let data = resp.data;

                            // Populate First Guarantor fields
                            document.getElementById('g_one_name').value = data.full_name ?? '';
                            document.querySelector('[name="g_one_d_o_b"]').value = data.dob ?? '';

                            if (data.gender === 'M') {
                                document.getElementById('g_one_gender').value = 'male';
                            } else if (data.gender === 'F') {
                                document.getElementById('g_one_gender').value = 'female';
                            }

                            alert('First Guarantor PAN verified successfully!');
                        } else {
                            alert('Invalid First Guarantor PAN: ' + (resp.message ||
                                'Please check and try again'));
                        }
                    })
                    .catch((err) => {
                        console.error('First Guarantor PAN verification error:', err);
                        alert('First Guarantor PAN verification error. Please try again.');
                    });
            }

            /* ===== Second Guarantor PAN Verification ===== */
            function verifySecondGuarantorPan() {
                const panInput = document.getElementById('g_two_pan');
                let pan = panInput.value.trim().toUpperCase();

                if (pan.length !== 10) {
                    console.log('Second Guarantor PAN length invalid');
                    return;
                }

                console.log('Verifying Second Guarantor PAN:', pan);

                fetch("{{ route('user.verify.pan') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            pan: pan,
                            type: 'second'
                        })
                    })
                    .then(res => res.json())
                    .then(resp => {
                        console.log('Second Guarantor PAN Response:', resp);

                        if (resp.status === true) {
                            let data = resp.data;

                            // Populate Second Guarantor fields
                            document.querySelector('[name="g_two_name"]').value = data.full_name ?? '';
                            document.querySelector('[name="g_two_d_o_b"]').value = data.dob ?? '';

                            if (data.gender === 'M') {
                                document.querySelector('[name="g_two_gender"]').value = 'male';
                            } else if (data.gender === 'F') {
                                document.querySelector('[name="g_two_gender"]').value = 'female';
                            }

                            alert('Second Guarantor PAN verified successfully!');
                        } else {
                            alert('Invalid Second Guarantor PAN: ' + (resp.message ||
                                'Please check and try again'));
                        }
                    })
                    .catch((err) => {
                        console.error('Second Guarantor PAN verification error:', err);
                        alert('Second Guarantor PAN verification error. Please try again.');
                    });
            }

            /* ===== Event Listeners ===== */
            const gOnePan = document.getElementById('g_one_pan');
            if (gOnePan) {
                gOnePan.addEventListener('blur', verifyFirstGuarantorPan);
            }

            const gTwoPan = document.getElementById('g_two_pan');
            if (gTwoPan) {
                gTwoPan.addEventListener('blur', verifySecondGuarantorPan);
            }

        });

        let gOneAadhaarVerifying = false;

        document.getElementById('g_one_aadhar_card_number')
            .addEventListener('blur', function() {

                if (gOneAadhaarVerifying) return;

                let aadhaar = this.value.trim();

                if (aadhaar.length !== 12) {
                    alert('Aadhaar number must be 12 digits');
                    return;
                }

                gOneAadhaarVerifying = true;

                fetch("{{ route('user.verify.aadhaar.last4') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            aadhaar: aadhaar,
                            type: 'first'
                        })
                    })
                    .then(res => res.json())
                    .then(resp => {
                        if (resp.status) {
                            alert(resp.message + ' ✅');
                        } else {
                            alert(resp.message + ' ❌');
                            this.value = '';
                        }
                    })
                    .catch(() => {
                        alert('Aadhaar verification failed');
                    })
                    .finally(() => {
                        gOneAadhaarVerifying = false;
                    });
            });

        let gTwoAadhaarVerifying = false;

        document.querySelector('[name="g_two_aadhar_card_number"]')
            .addEventListener('blur', function() {

                if (gTwoAadhaarVerifying) return;

                let aadhaar = this.value.trim();

                if (aadhaar.length !== 12) {
                    alert('Aadhaar number must be 12 digits');
                    return;
                }

                gTwoAadhaarVerifying = true;

                fetch("{{ route('user.verify.aadhaar.last4') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            aadhaar: aadhaar,
                            type: 'second'
                        })
                    })
                    .then(res => res.json())
                    .then(resp => {
                        if (resp.status) {
                            alert(resp.message + ' ✅');
                        } else {
                            alert(resp.message + ' ❌');
                            this.value = '';
                        }
                    })
                    .catch(() => {
                        alert('Aadhaar verification failed');
                    })
                    .finally(() => {
                        gTwoAadhaarVerifying = false;
                    });
            });
    </script>

    <script>
        function checkDuplicate(field, value, errorElementId) {
            if (!value) return;

            fetch("{{ route('user.check.guarantor.duplicate') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        field: field,
                        value: value
                    })
                })
                .then(res => res.json())
                .then(data => {
                    const errorEl = document.getElementById(errorElementId);
                    if (data.exists) {
                        errorEl.innerText = "This value cannot be same as applicant or family member.";
                    } else {
                        errorEl.innerText = "";
                    }
                });
        }
    </script>
@endsection
