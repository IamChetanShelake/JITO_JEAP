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

        .photo-upload-box {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            margin-bottom: 10px;
        }

        .photo-label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }

        .upload-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 3px;
            cursor: pointer;
            display: inline-block;
        }

        .upload-btn:hover {
            background: #0056b3;
        }

        .upload-icon {
            margin-right: 5px;
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

        .qualification-group {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #e9ecef;
        }

        .qualification-title {
            font-weight: 600;
            color: #393185;
            margin-bottom: 10px;
        }

        .year-select {
            width: 120px;
        }

        .section-divider {
            height: 1px;
            background: #e9ecef;
            margin: 30px 0;
        }

        .form-control-sm {
            border-radius: 15px;
        }

        label {
            color: #4C4C4C;
        }
    </style>



    <!-- Main Content -->
    <div class="col-lg-9 main-content">
        <!-- Hold Remark Alert -->
        @if ($educationDetail && $educationDetail->submit_status === 'resubmit' && $educationDetail->admin_remark)
            <div class="alert alert-warning alert-dismissible fade show" role="alert"
                style="background-color: #fff3cd; border-color: #ffeaa7; color: #856404; border-radius: 8px; margin-bottom: 20px;">
                <strong><i class="bi bi-exclamation-triangle-fill"></i> Hold Notice:</strong>
                <p style="margin: 8px 0 0 0; font-size: 14px;">{{ $educationDetail->admin_remark }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{ route('user.step2ug.store') }}" enctype="multipart/form-data"
                        novalidate>
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-5 offset-md-1">

                                <select class="form-control" name="financial_asset_type" id="financial_asset_type"
                                    style="border:2px solid #393185;border-radius:15px;" readonly required>
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
                                <small class="text-danger"
                                    id="financial_asset_type_error">{{ $errors->first('financial_asset_type') }}</small>
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
                                <small class="text-danger"
                                    id="financial_asset_for_error">{{ $errors->first('financial_asset_for') }}</small>
                            </div>
                        </div>
                        <div class="card form-card">
                            <div class="card-body">

                                <div class="step-card">
                                    <div class="card-icon">
                                        <i class="bi bi-mortarboard"></i>
                                    </div>
                                    <div>
                                        <h3 class="card-title">Education Details</h3>
                                        <p class="card-subtitle">Information about your educational background</p>
                                    </div>
                                </div>


                                <!-- Section 1: Your Financial Need Overview -->
                                <div class="education-section">
                                    <h4 class="title" style="color:#4C4C4C;font-size:18px;">Your Financial Need Overview
                                    </h4>

                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="course_name">Course Name <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" id="course_name" class="form-control"
                                                    name="course_name" placeholder="Enter Course Name "
                                                    value="{{ old('course_name') ?: $educationDetail->course_name ?? '' }}"
                                                    required>
                                                <small class="text-danger"
                                                    id="course_name_error">{{ $errors->first('course_name') }}</small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="university_name">University Name <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" id="university_name" class="form-control"
                                                    name="university_name" placeholder="Enter University Name "
                                                    value="{{ old('university_name') ?: $educationDetail->university_name ?? '' }}"
                                                    required>
                                                <small class="text-danger"
                                                    id="university_name_error">{{ $errors->first('university_name') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="college_name">College Name <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" id="college_name" class="form-control"
                                                    name="college_name" placeholder="Enter College Name "
                                                    value="{{ old('college_name') ?: $educationDetail->college_name ?? '' }}"
                                                    required>
                                                <small class="text-danger"
                                                    id="college_name_error">{{ $errors->first('college_name') }}</small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="country">Country Name <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" id="country" class="form-control" name="country"
                                                    placeholder="Enter Country Name "
                                                    value="{{ old('country') ?: $educationDetail->country ?? '' }}"
                                                    required>
                                                <small class="text-danger"
                                                    id="country_error">{{ $errors->first('country') }}</small>
                                            </div>

                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="city_name">City Name <span style="color: red;">*</span></label>
                                                <input type="text" id="city_name" class="form-control" name="city_name"
                                                    placeholder="Enter City Name "
                                                    value="{{ old('city_name') ?: $educationDetail->city_name ?? '' }}"
                                                    required>
                                                <small class="text-danger"
                                                    id="city_name_error">{{ $errors->first('city_name') }}</small>
                                            </div>

                                            {{-- <div class="form-group mb-3">
                                                <label for="start_year">Start Year <span
                                                        style="color: red;">*</span></label>
                                                <input type="number" id="start_year" class="form-control" name="start_year"
                                                    placeholder="Enter Start Year " value="{{ old('start_year') }}"
                                                    min="2000" max="2199" required>
                                                <small class="text-danger">{{ $errors->first('start_year') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="expected_year">Expected Year of Completion <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" id="expected_year" class="form-control"
                                                    name="expected_year" placeholder="Enter Expected Year of Completion  "
                                                    value="{{ old('expected_year') }}" pattern="^(20|21)\d{2}$"
                                                    title="Please enter a valid year (e.g. 2024)" required>
                                                <small class="text-danger">{{ $errors->first('expected_year') }}</small>
                                            </div> --}}
                                            {{-- <div class="form-group mb-3">
                                                <label for="start_year">Start Year <span
                                                        style="color:red">*</span></label>
                                                <input type="month" id="start_year" class="form-control"
                                                    name="start_year"
                                                    value="{{ old('start_year') ?: $educationDetail->start_year ?? '' }}"
                                                    required oninput="validateStartYear()">
                                                <small id="startYearError" class="text-danger d-none">
                                                    Start month must be within next 4 months from current month
                                                </small>
                                            </div> --}}
                                            <div class="form-group mb-3">
                                                <label for="start_year">Start Year <span
                                                        style="color:red">*</span></label>
                                                <input type="month" id="start_year" class="form-control"
                                                    name="start_year"
                                                    value="{{ old('start_year') ?: $educationDetail->start_year ?? '' }}"
                                                    required oninput="validateStartYear()">
                                                <small id="startYearError" class="text-danger d-none">
                                                    Start month must be within next 4 months from current month
                                                </small>
                                               

                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="expected_year">Expected Year of Completion <span
                                                        style="color:red">*</span></label>
                                                <input type="month" id="expected_year" class="form-control"
                                                    name="expected_year"
                                                    value="{{ old('expected_year') ?: $educationDetail->expected_year ?? '' }}"
                                                    required oninput="validateExpectedYear()">
                                                <small id="expectedYearError" class="text-danger d-none">
                                                    Expected month must be after start month and within next 5 years
                                                </small>
                                            </div>



                                            <div class="form-group mb-3">
                                                <label for="nirf_ranking">NIRF Ranking</label>
                                                <input type="text" id="nirf_ranking" class="form-control"
                                                    name="nirf_ranking" placeholder=" Enter NIRF Ranking"
                                                    value="{{ old('nirf_ranking') ?: $educationDetail->nirf_ranking ?? '' }}">
                                                <small class="text-danger" id="">{{ $errors->first('nirf_ranking') }}</small>
                                            </div>
                                            {{--
                                            <div class="form-group mb-3">
                                                <select class="form-control" name="duration">
                                                    <option value="" {{ !old('duration') ? 'selected' : '' }}
                                                        disabled hidden>Duration *</option>
                                                    <option value="1" {{ old('duration') == '1' ? 'selected' : '' }}>1
                                                        Year</option>
                                                    <option value="2" {{ old('duration') == '2' ? 'selected' : '' }}>2
                                                        Years</option>
                                                    <option value="3" {{ old('duration') == '3' ? 'selected' : '' }}>3
                                                        Years</option>
                                                    <option value="4" {{ old('duration') == '4' ? 'selected' : '' }}>4
                                                        Years</option>
                                                    <option value="5" {{ old('duration') == '5' ? 'selected' : '' }}>5
                                                        Years</option>
                                                    <option value="6" {{ old('duration') == '6' ? 'selected' : '' }}>6
                                                        Years</option>
                                                    <option value="7" {{ old('duration') == '7' ? 'selected' : '' }}>7
                                                        Years</option>
                                                    <option value="8" {{ old('duration') == '8' ? 'selected' : '' }}>8
                                                        Years</option>
                                                    <option value="9" {{ old('duration') == '9' ? 'selected' : '' }}>9
                                                        Years</option>
                                                    <option value="10" {{ old('duration') == '10' ? 'selected' : '' }}>
                                                        10 Years</option>
                                                </select>
                                                <small class="text-danger">{{ $errors->first('duration') }}</small>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>


                                <!-- Section 2: Financial Summary Table -->
                                <div class="education-section">
                                    {{-- <h4 class="title" style="color:#4C4C4C;font-size:18px;">Financial Summary</h4> --}}

                                    <div class="table-responsive mt-4">
                                        <table class="table" id="yearWiseTable"
                                            style="background: white; border: none; border-collapse: collapse;">
                                            <thead style="background-color: #f8f9fa;">
                                                <tr style="border-bottom: 1px solid lightgray;">
                                                    <th class="text-center"
                                                        style="width: 80px; font-weight: 600; color: #4C4C4C; border: none;">
                                                        Sr No</th>
                                                    <th class="text-center"
                                                        style="font-weight: 600; color: #4C4C4C; border: none;width: 25%;">
                                                        Group Name</th>
                                                    <th class="text-center"
                                                        style="width: 100px; font-weight: 600; color: #4C4C4C; border: none;">
                                                        1 Year</th>
                                                    <th class="text-center"
                                                        style="width: 100px; font-weight: 600; color: #4C4C4C; border: none;">
                                                        2 Year</th>
                                                    <th class="text-center"
                                                        style="width: 100px; font-weight: 600; color: #4C4C4C; border: none;">
                                                        3 Year</th>
                                                    <th class="text-center"
                                                        style="width: 100px; font-weight: 600; color: #4C4C4C; border: none;">
                                                        4 Year</th>
                                                    <th class="text-center"
                                                        style="width: 100px; font-weight: 600; color: #4C4C4C; border: none;">
                                                        5 Year</th>
                                                    <th class="text-center"
                                                        style="width: 120px; font-weight: 600; color: #393185; border: none;">
                                                        Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Row 1: Tuition Fees -->
                                                <tr style="border-bottom: 1px solid lightgray;">
                                                    <td class="text-center" style="font-weight: 500; border: none;">1</td>
                                                    <td
                                                        style="font-weight: 500; border: none;width: 25%;text-align:center;">
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="group_name_1" value="Tuition Fees" hidden>Tuition Fees
                                                    </td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_1_year1"
                                                            value="{{ old('group_1_year1') ?: $educationDetail->group_1_year1 ?? '' }}"
                                                            placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_1_year2"
                                                            value="{{ old('group_1_year2') ?: $educationDetail->group_1_year2 ?? '' }}"
                                                            placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_1_year3"
                                                            value="{{ old('group_1_year3') ?: $educationDetail->group_1_year3 ?? '' }}"
                                                            placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_1_year4"
                                                            value="{{ old('group_1_year4') ?: $educationDetail->group_1_year4 ?? '' }}"
                                                            placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_1_year5"
                                                            value="{{ old('group_1_year5') ?: $educationDetail->group_1_year5 ?? '' }}"
                                                            placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_1_total"
                                                            value="{{ old('group_1_total') ?: $educationDetail->group_1_total ?? '' }}"
                                                            placeholder="0" readonly></td>
                                                </tr>

                                                <!-- Row 2 -->
                                                <tr style="border-bottom: 1px solid lightgray;">
                                                    <td class="text-center" style="font-weight: 500; border: none;">2</td>
                                                    <td style="border: none;width: 25%;text-align:center;"><input
                                                            type="text" class="form-control form-control-sm"
                                                            name="group_name_2" value="Living Expenses" hidden>Living
                                                        Expenses
                                                    </td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_2_year1"
                                                            value="{{ old('group_2_year1') ?: $educationDetail->group_2_year1 ?? '' }}"
                                                            placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_2_year2"
                                                            value="{{ old('group_2_year2') ?: $educationDetail->group_2_year2 ?? '' }}"
                                                            placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_2_year3"
                                                            value="{{ old('group_2_year3') ?: $educationDetail->group_2_year3 ?? '' }}"
                                                            placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_2_year4"
                                                            value="{{ old('group_2_year4') ?: $educationDetail->group_2_year4 ?? '' }}"
                                                            placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_2_year5"
                                                            value="{{ old('group_2_year5') ?: $educationDetail->group_2_year5 ?? '' }}"
                                                            placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_2_total"
                                                            value="{{ old('group_2_total') ?: $educationDetail->group_2_total ?? '' }}"
                                                            placeholder="0" readonly>
                                                    </td>
                                                </tr>

                                                <!-- Row 3 -->
                                                <tr style="border-bottom: 1px solid lightgray;">
                                                    <td class="text-center" style="font-weight: 500; border: none;">3</td>
                                                    <td style="border: none;width: 25%;text-align:center;"><input
                                                            type="text" class="form-control form-control-sm"
                                                            name="group_name_3" value="Other Expenses"
                                                            placeholder="Enter Group Name" hidden>Other Expenses</td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_3_year1"
                                                            value="{{ old('group_3_year1') ?: $educationDetail->group_3_year1 ?? '' }}"
                                                            placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_3_year2"
                                                            value="{{ old('group_3_year2') ?: $educationDetail->group_3_year2 ?? '' }}"
                                                            placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_3_year3"
                                                            value="{{ old('group_3_year3') ?: $educationDetail->group_3_year3 ?? '' }}"
                                                            placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_3_year4"
                                                            value="{{ old('group_3_year4') ?: $educationDetail->group_3_year4 ?? '' }}"
                                                            placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_3_year5"
                                                            value="{{ old('group_3_year5') ?: $educationDetail->group_3_year5 ?? '' }}"
                                                            placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_3_total"
                                                            value="{{ old('group_3_total') ?: $educationDetail->group_3_total ?? '' }}"
                                                            placeholder="0" readonly>
                                                    </td>
                                                </tr>

                                                <!-- Row 4 -->
                                                <tr>
                                                    <td class="text-center" style="font-weight: 500; border: none;">4</td>
                                                    <td style="border: none;width: 25%;text-align:center;"><input
                                                            type="text" class="form-control form-control-sm"
                                                            name="group_name_4" value="Total Expenses"
                                                            placeholder="Enter Group Name" hidden>Total Expenses</td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_4_year1"
                                                            value="{{ old('group_4_year1') ?: $educationDetail->group_4_year1 ?? '' }}"
                                                            placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_4_year2"
                                                            value="{{ old('group_4_year2') ?: $educationDetail->group_4_year2 ?? '' }}"
                                                            placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_4_year3"
                                                            value="{{ old('group_4_year3') ?: $educationDetail->group_4_year3 ?? '' }}"
                                                            placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_4_year4"
                                                            value="{{ old('group_4_year4') ?: $educationDetail->group_4_year4 ?? '' }}"
                                                            placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_4_year5"
                                                            value="{{ old('group_4_year5') ?: $educationDetail->group_4_year5 ?? '' }}"
                                                            placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_4_total"
                                                            value="{{ old('group_4_total') ?: $educationDetail->group_4_total ?? '' }}"
                                                            placeholder="0" readonly>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Error messages for table fields -->
                                    <div class="mb-3">
                                        <small class="text-danger" id="table_error" style="display: none;">Please fill
                                            all financial summary fields with values greater than 0.</small>
                                    </div>
                                </div>

                                {{-- <!-- Section Divider -->
                                <div class="section-divider"></div>
                                <!-- Section 1: Current Education -->
                                <div class="education-section">
                                    <h4 class="title" style="color:#4C4C4C;font-size:18px;">Current Education</h4>

                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <select class="form-control" name="current_pursuing">
                                                    <option value=""
                                                        {{ !old('current_pursuing') ? 'selected' : '' }} disabled hidden>
                                                        Are you currently pursuing any course or degree? *
                                                    </option>
                                                    <option value="yes"
                                                        {{ old('current_pursuing') == 'yes' ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option value="no"
                                                        {{ old('current_pursuing') == 'no' ? 'selected' : '' }}>No</option>
                                                </select>
                                                <small
                                                    class="text-danger">{{ $errors->first('current_pursuing') }}</small>
                                            </div>

                                            <div id="current-education-fields" style="display: none;">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="current_course_name"
                                                        placeholder="Current Course Name *"
                                                        value="{{ old('current_course_name') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('current_course_name') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="current_institution"
                                                        placeholder="Institution / College Name *"
                                                        value="{{ old('current_institution') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('current_institution') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="current_university"
                                                        placeholder="University Name"
                                                        value="{{ old('current_university') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('current_university') }}</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div id="current-education-fields-right" style="display: none;">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="current_start_year"
                                                        placeholder="Start Year *"
                                                        value="{{ old('current_start_year') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('current_start_year') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control"
                                                        name="current_expected_year"
                                                        placeholder="Expected Completion Year *"
                                                        value="{{ old('current_expected_year') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('current_expected_year') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <select class="form-control" name="current_mode_of_study">
                                                        <option value="">Mode of Study *</option>
                                                        <option value="full-time"
                                                            {{ old('current_mode_of_study') == 'full-time' ? 'selected' : '' }}>
                                                            Full-time</option>
                                                        <option value="part-time"
                                                            {{ old('current_mode_of_study') == 'part-time' ? 'selected' : '' }}>
                                                            Part-time</option>
                                                        <option value="distance"
                                                            {{ old('current_mode_of_study') == 'distance' ? 'selected' : '' }}>
                                                            Distance</option>
                                                        <option value="online"
                                                            {{ old('current_mode_of_study') == 'online' ? 'selected' : '' }}>
                                                            Online</option>
                                                    </select>
                                                    <small
                                                        class="text-danger">{{ $errors->first('current_mode_of_study') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}




                                <!-- Section Divider -->
                                <div class="section-divider"></div>
                                {{-- 
                                <!-- Section 4: School / 10th Grade Information -->
                                <div class="education-section">
                                    <h4 class="title" style="color:#4C4C4C;font-size:18px;">School / 10th Grade
                                        Information</h4>

                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="school_name">School Name <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="school_name"
                                                    name="school_name" placeholder="School Name *"
                                                    value="{{ old('school_name') ?: ($educationDetail->school_name ?? '') }}">
                                                <small class="text-danger">{{ $errors->first('school_name') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="school_board">Board <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="school_board"
                                                    name="school_board" placeholder="Board *"
                                                    value="{{ old('school_board') ?: ($educationDetail->school_board ?? '') }}">
                                                <small class="text-danger">{{ $errors->first('school_board') }}</small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="school_completion_year">Year of Completion <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="school_completion_year"
                                                    name="school_completion_year" placeholder="Year of Completion *"
                                                    value="{{ old('school_completion_year') ?: ($educationDetail->school_completion_year ?? '') }}">
                                                <small
                                                    class="text-danger">{{ $errors->first('school_completion_year') }}</small>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-2 text-start">
                                                    <div class="form-group mb-3"><label for="10th_mark_obtained">Marks
                                                            obtained:</label></div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group mb-3"><input class="form-control"
                                                            id="10th_mark_obtained" type="number"
                                                            name="10th_mark_obtained" value="{{ old('10th_mark_obtained') ?: ($educationDetail->{'10th_mark_obtained'} ?? '') }}"></div>
                                                </div>
                                                <div class="col-2 text-start">
                                                    <div class="form-group mb-3 text-end">
                                                        <label for="10th_mark_out_of">Out Of:</label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group mb-3">
                                                        <input class="form-control" id="10th_mark_out_of" type="number"
                                                            name="10th_mark_out_of" value="{{ old('10th_mark_out_of') ?: ($educationDetail->{'10th_mark_out_of'} ?? '') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="school_percentage">Percentage (%)</label>
                                                <input type="text" class="form-control" id="school_percentage"
                                                    name="school_percentage" placeholder="Enter % "
                                                    value="{{ old('school_percentage') ?: ($educationDetail->school_percentage ?? '') }}">
                                                <small
                                                    class="text-danger">{{ $errors->first('school_percentage') }}</small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="school_CGPA">CGPA</label>
                                                <input type="text" class="form-control" id="school_CGPA"
                                                    name="school_CGPA" placeholder="Enter CGPA"
                                                    value="{{ old('school_CGPA') ?: ($educationDetail->school_CGPA ?? '') }}">
                                                <small class="text-danger">{{ $errors->first('school_CGPA') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section Divider -->
                                <div class="section-divider"></div>

                                <!-- Section 3: Junior College (12th Grade) -->
                                <div class="education-section">
                                    <h4 class="title" style="color:#4C4C4C;font-size:18px;">Junior College (12th Grade)
                                    </h4>

                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="jc_college_name">College / Junior College Name <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="jc_college_name"
                                                    name="jc_college_name" placeholder="College / Junior College Name *"
                                                    value="{{ old('jc_college_name') ?: ($educationDetail->jc_college_name ?? '') }}">
                                                <small class="text-danger">{{ $errors->first('jc_college_name') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="jc_stream">Stream <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="jc_stream"
                                                    name="jc_stream" placeholder="Select Stream *"
                                                    value="{{ old('jc_stream') ?: ($educationDetail->jc_stream ?? '') }}">
                                                <small class="text-danger">{{ $errors->first('jc_stream') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="jc_board">Board <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="jc_board"
                                                    name="jc_board" placeholder="Select Board *"
                                                    value="{{ old('jc_board') ?: ($educationDetail->jc_board ?? '') }}">
                                                <small class="text-danger">{{ $errors->first('jc_board') }}</small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="jc_completion_year">Year of Completion <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="jc_completion_year"
                                                    name="jc_completion_year" placeholder="Year of Completion *"
                                                    value="{{ old('jc_completion_year') ?: ($educationDetail->jc_completion_year ?? '') }}">
                                                <small
                                                    class="text-danger">{{ $errors->first('jc_completion_year') }}</small>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-2 text-start">
                                                    <div class="form-group mb-3"><label for="12th_mark_obtained">Marks
                                                            obtained:</label></div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group mb-3"><input class="form-control"
                                                            id="12th_mark_obtained" type="number"
                                                            name="12th_mark_obtained" value="{{ old('12th_mark_obtained') ?: ($educationDetail->{'12th_mark_obtained'} ?? '') }}"></div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group mb-3 text-start">
                                                        <label for="12th_mark_out_of">Out Of:</label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group mb-3">
                                                        <input class="form-control" id="12th_mark_out_of" type="number"
                                                            name="12th_mark_out_of" value="{{ old('12th_mark_out_of') ?: ($educationDetail->{'12th_mark_out_of'} ?? '') }}">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group mb-3">
                                                <label for="jc_percentage">Percentage (%)</label>
                                                <input type="text" class="form-control" id="jc_percentage"
                                                    name="jc_percentage" placeholder="Enter %"
                                                    value="{{ old('jc_percentage') ?: ($educationDetail->jc_percentage ?? '') }}">
                                                <small class="text-danger">{{ $errors->first('jc_percentage') }}</small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="jc_CGPA">CGPA</label>
                                                <input type="text" class="form-control" id="jc_CGPA" name="jc_CGPA"
                                                    placeholder="Enter CGPA" value="{{ old('jc_CGPA') ?: ($educationDetail->jc_CGPA ?? '') }}">
                                                <small class="text-danger">{{ $errors->first('jc_CGPA') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}


                                <!-- Section 4: School / 10th Grade Information -->
                                <div class="education-section">
                                    <h4 class="title" style="color:#4C4C4C;font-size:18px;">School / 10th Grade
                                        Information</h4>

                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="school_name">School Name <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="school_name"
                                                    name="school_name" placeholder="School Name "
                                                    value="{{ old('school_name') ?: $educationDetail->school_name ?? '' }}">
                                                <small class="text-danger" id="school_name">{{ $errors->first('school_name') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="school_board">Board <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="school_board"
                                                    name="school_board" placeholder="Board "
                                                    value="{{ old('school_board') ?: $educationDetail->school_board ?? '' }}">
                                                <small class="text-danger">{{ $errors->first('school_board') }}</small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="school_completion_year">Year of Completion <span
                                                        style="color: red;">*</span></label>
                                                <input type="month" class="form-control" id="school_completion_year"
                                                    name="school_completion_year" placeholder="Select Month and Year"
                                                    value="{{ old('school_completion_year') ?: ($educationDetail && $educationDetail->school_completion_year ? $educationDetail->school_completion_year . '-01' : '') }}">
                                                <small
                                                    class="text-danger">{{ $errors->first('school_completion_year') }}</small>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="school_grade_system">Grade System</label>
                                                <div>
                                                    <input type="radio" id="grade_percentage"
                                                        name="school_grade_system" value="percentage"
                                                        {{ old('school_grade_system', 'percentage') == 'percentage' ? 'checked' : '' }}>
                                                    <label
                                                        for="grade_percentage">Percentage</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" id="grade_cgpa" name="school_grade_system"
                                                        value="cgpa"
                                                        {{ old('school_grade_system') == 'cgpa' ? 'checked' : '' }}>
                                                    <label for="grade_cgpa">CGPA or SGPA</label>
                                                </div>
                                            </div>

                                            <div id="percentage_fields"
                                                style="display: {{ old('school_grade_system', 'percentage') == 'percentage' ? 'block' : 'none' }};">
                                                <div class="row">
                                                    <div class="col-2 text-start">
                                                        <div class="form-group mb-3"><label for="10th_mark_obtained">Marks
                                                                obtained:</label></div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group mb-3"><input class="form-control"
                                                                id="10th_mark_obtained" type="number"
                                                                name="10th_mark_obtained"
                                                                value="{{ old('10th_mark_obtained') ?: $educationDetail->{'10th_mark_obtained'} ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-2 text-start">
                                                        <div class="form-group mb-3 text-end"><label
                                                                for="10th_mark_out_of">Out Of:</label></div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group mb-3"><input class="form-control"
                                                                id="10th_mark_out_of" type="number"
                                                                name="10th_mark_out_of"
                                                                value="{{ old('10th_mark_out_of') ?: $educationDetail->{'10th_mark_out_of'} ?? '' }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="school_percentage">Percentage (%)</label>
                                                    <input type="text" class="form-control" id="school_percentage"
                                                        name="school_percentage" placeholder="Enter % "
                                                        value="{{ old('school_percentage') ?: $educationDetail->school_percentage ?? '' }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('school_percentage') }}</small>
                                                </div>
                                            </div>

                                            <div id="cgpa_fields"
                                                style="display: {{ old('school_grade_system') == 'cgpa' ? 'block' : 'none' }};">
                                                <div class="form-group mb-3">
                                                    <label for="school_CGPA">CGPA</label>
                                                    <input type="text" class="form-control" id="school_CGPA"
                                                        name="school_CGPA" placeholder="Enter CGPA"
                                                        value="{{ old('school_CGPA') ?: $educationDetail->school_CGPA ?? '' }}">
                                                    <small class="text-danger">{{ $errors->first('school_CGPA') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="school_SGPA">SGPA</label>
                                                    <input type="text" class="form-control" id="school_SGPA"
                                                        name="school_SGPA" placeholder="Enter SGPA"
                                                        value="{{ old('school_SGPA') ?: $educationDetail->school_SGPA ?? '' }}">
                                                    <small class="text-danger">{{ $errors->first('school_SGPA') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section Divider -->
                                <div class="section-divider"></div>

                                <!-- Section 3: Junior College (12th Grade) -->
                                <div class="education-section">
                                    <h4 class="title" style="color:#4C4C4C;font-size:18px;">Junior College (12th Grade)
                                    </h4>

                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="jc_college_name">College / Junior College Name <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="jc_college_name"
                                                    name="jc_college_name" placeholder="College / Junior College Name "
                                                    value="{{ old('jc_college_name') ?: $educationDetail->jc_college_name ?? '' }}">
                                                <small class="text-danger">{{ $errors->first('jc_college_name') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="jc_stream">Stream <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="jc_stream"
                                                    name="jc_stream" placeholder="Select Stream "
                                                    value="{{ old('jc_stream') ?: $educationDetail->jc_stream ?? '' }}">
                                                <small class="text-danger">{{ $errors->first('jc_stream') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="jc_board">Board <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="jc_board"
                                                    name="jc_board" placeholder="Select Board "
                                                    value="{{ old('jc_board') ?: $educationDetail->jc_board ?? '' }}">
                                                <small class="text-danger">{{ $errors->first('jc_board') }}</small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="jc_completion_year">Year of Completion <span
                                                        style="color: red;">*</span></label>
                                                <input type="month" class="form-control" id="jc_completion_year"
                                                    name="jc_completion_year" placeholder="Select Month and Year"
                                                    value="{{ old('jc_completion_year') ?: ($educationDetail && $educationDetail->jc_completion_year ? $educationDetail->jc_completion_year . '-01' : '') }}">
                                                <small
                                                    class="text-danger">{{ $errors->first('jc_completion_year') }}</small>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="jc_grade_system">Grade System</label>
                                                <div>
                                                    <input type="radio" id="jc_grade_percentage" name="jc_grade_system"
                                                        value="percentage"
                                                        {{ old('jc_grade_system', 'percentage') == 'percentage' ? 'checked' : '' }}>
                                                    <label
                                                        for="jc_grade_percentage">Percentage</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" id="jc_grade_cgpa" name="jc_grade_system"
                                                        value="cgpa"
                                                        {{ old('jc_grade_system') == 'cgpa' ? 'checked' : '' }}>
                                                    <label for="jc_grade_cgpa">CGPA or SGPA</label>
                                                </div>
                                            </div>

                                            <div id="jc_percentage_fields"
                                                style="display: {{ old('jc_grade_system', 'percentage') == 'percentage' ? 'block' : 'none' }};">
                                                <div class="row">
                                                    <div class="col-2 text-start">
                                                        <div class="form-group mb-3"><label for="12th_mark_obtained">Marks
                                                                obtained:</label></div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group mb-3"><input class="form-control"
                                                                id="12th_mark_obtained" type="number"
                                                                name="12th_mark_obtained"
                                                                value="{{ old('12th_mark_obtained') ?: $educationDetail->{'12th_mark_obtained'} ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="form-group mb-3 text-start">
                                                            <label for="12th_mark_out_of">Out Of:</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group mb-3">
                                                            <input class="form-control" id="12th_mark_out_of"
                                                                type="number" name="12th_mark_out_of"
                                                                value="{{ old('12th_mark_out_of') ?: $educationDetail->{'12th_mark_out_of'} ?? '' }}">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group mb-3">
                                                    <label for="jc_percentage">Percentage (%)</label>
                                                    <input type="text" class="form-control" id="jc_percentage"
                                                        name="jc_percentage" placeholder="Enter %"
                                                        value="{{ old('jc_percentage') ?: $educationDetail->jc_percentage ?? '' }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('jc_percentage') }}</small>
                                                </div>
                                            </div>

                                            <div id="jc_cgpa_fields"
                                                style="display: {{ old('jc_grade_system') == 'cgpa' ? 'block' : 'none' }};">
                                                <div class="form-group mb-3">
                                                    <label for="jc_CGPA">CGPA</label>
                                                    <input type="text" class="form-control" id="jc_CGPA"
                                                        name="jc_CGPA" placeholder="Enter CGPA"
                                                        value="{{ old('jc_CGPA') ?: $educationDetail->jc_CGPA ?? '' }}">
                                                    <small class="text-danger">{{ $errors->first('jc_CGPA') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="jc_SGPA">SGPA</label>
                                                    <input type="text" class="form-control" id="jc_SGPA"
                                                        name="jc_SGPA" placeholder="Enter SGPA"
                                                        value="{{ old('jc_SGPA') ?: $educationDetail->jc_SGPA ?? '' }}">
                                                    <small class="text-danger">{{ $errors->first('jc_SGPA') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Section Divider -->
                                {{-- <div class="section-divider"></div>

                                <!-- Section 2: Completed Qualifications -->
                                <div class="education-section">
                                    <h4 class="title" style="color:#4C4C4C;font-size:18px;">Completed Qualifications</h4>

                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <select class="form-control" name="qualifications"
                                                    id="qualifications_select">
                                                    <option value="" {{ !old('qualifications') ? 'selected' : '' }}
                                                        disabled hidden>Add your completed qualifications *</option>
                                                    <option value="diploma"
                                                        {{ old('qualifications') == 'diploma' ? 'selected' : '' }}>
                                                        Diploma</option>
                                                    <option value="graduation"
                                                        {{ old('qualifications') == 'graduation' ? 'selected' : '' }}>
                                                        Graduation</option>
                                                    <option value="masters"
                                                        {{ old('qualifications') == 'masters' ? 'selected' : '' }}>
                                                        Masters</option>
                                                    <option value="phd"
                                                        {{ old('qualifications') == 'phd' ? 'selected' : '' }}>
                                                        PhD</option>
                                                    <option value="none"
                                                        {{ old('qualifications') == 'none' ? 'selected' : '' }}>
                                                        Not Pursued Any of the Above</option>
                                                </select>

                                                <small class="text-danger">{{ $errors->first('qualifications') }}</small>


                                            </div>

                                            <!-- Additional Qualification Fields in Left Column -->
                                            <div id="qualification-fields" style="display: none;">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control"
                                                        name="qualification_course_name"
                                                        placeholder="Course / Degree Name *"
                                                        value="{{ old('qualification_course_name') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('qualification_course_name') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control"
                                                        name="qualification_institution"
                                                        placeholder="Institution / College Name *"
                                                        value="{{ old('qualification_institution') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('qualification_institution') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control"
                                                        name="qualification_university" placeholder="University Name"
                                                        value="{{ old('qualification_university') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('qualification_university') }}</small>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div id="qualification-fields-right" style="display: none;">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control"
                                                        name="qualification_specialization"
                                                        placeholder="Specialization / Major *"
                                                        value="{{ old('qualification_specialization') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('qualification_specialization') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="qualification_years"
                                                        placeholder="Start Year - End Year *"
                                                        value="{{ old('qualification_years') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('qualification_years') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control"
                                                        name="qualification_percentage" placeholder="Percentage / CGPA *"
                                                        value="{{ old('qualification_percentage') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('qualification_percentage') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <select class="form-control" name="qualification_mode_of_study">
                                                        <option value="">Mode of Study *</option>
                                                        <option value="full-time"
                                                            {{ old('qualification_mode_of_study') == 'full-time' ? 'selected' : '' }}>
                                                            Full-time</option>
                                                        <option value="part-time"
                                                            {{ old('qualification_mode_of_study') == 'part-time' ? 'selected' : '' }}>
                                                            Part-time</option>
                                                        <option value="distance"
                                                            {{ old('qualification_mode_of_study') == 'distance' ? 'selected' : '' }}>
                                                            Distance</option>
                                                        <option value="online"
                                                            {{ old('qualification_mode_of_study') == 'online' ? 'selected' : '' }}>
                                                            Online</option>
                                                    </select>
                                                    <small
                                                        class="text-danger">{{ $errors->first('qualification_mode_of_study') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- <!-- Section Divider -->
                                <div class="section-divider"></div>

                                <!-- Section 5: Additional Curriculum -->
                                <div class="education-section">
                                    <h4 class="title" style="color:#4C4C4C;font-size:18px;">Additional Curriculum</h4>

                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="ielts_overall_band_year"
                                                    placeholder="IELTS (Overall Band + Test Year)"
                                                    value="{{ old('ielts_overall_band_year') }}">
                                                <small
                                                    class="text-danger">{{ $errors->first('ielts_overall_band_year') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="toefl_score_year"
                                                    placeholder="TOEFL (Score + Test Year)"
                                                    value="{{ old('toefl_score_year') }}">
                                                <small
                                                    class="text-danger">{{ $errors->first('toefl_score_year') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="duolingo_det_score_year"
                                                    placeholder="Duolingo (DET) (Score + Test Year)"
                                                    value="{{ old('duolingo_det_score_year') }}">
                                                <small
                                                    class="text-danger">{{ $errors->first('duolingo_det_score_year') }}</small>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="gre_score_year"
                                                    placeholder="GRE (Score + Test Year)"
                                                    value="{{ old('gre_score_year') }}">
                                                <small class="text-danger">{{ $errors->first('gre_score_year') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="gmat_score_year"
                                                    placeholder="GMAT (Score + Test Year)"
                                                    value="{{ old('gmat_score_year') }}">
                                                <small class="text-danger">{{ $errors->first('gmat_score_year') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="sat_score_year"
                                                    placeholder="SAT (Score + Test Year)"
                                                    value="{{ old('sat_score_year') }}">
                                                <small class="text-danger">{{ $errors->first('sat_score_year') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- <!-- Section Divider -->
                                <div class="section-divider"></div>

                                <!-- Section 6: Work Experience (if any) -->
                                <div class="education-section">
                                    <h4 class="title" style="color:#4C4C4C;font-size:18px;">Work Experience (if any)</h4>

                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <select class="form-control" name="have_work_experience">
                                                    <option value=""
                                                        {{ !old('have_work_experience') ? 'selected' : '' }} hidden>Have
                                                        you worked professionally before? *</option>
                                                    <option value="yes"
                                                        {{ old('have_work_experience') == 'yes' ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option value="no"
                                                        {{ old('have_work_experience') == 'no' ? 'selected' : '' }}>No
                                                    </option>
                                                </select>
                                                <small
                                                    class="text-danger">{{ $errors->first('have_work_experience') }}</small>
                                            </div>

                                            <!-- Additional Work Experience Fields in Left Column -->
                                            <div id="work-experience-fields" style="display: none;">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="organization_name"
                                                        placeholder="Organization / Company Name"
                                                        value="{{ old('organization_name') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('organization_name') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="work_profile"
                                                        placeholder="Work Profile / Designation"
                                                        value="{{ old('work_profile') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('work_profile') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="work_duration"
                                                        placeholder="Duration" value="{{ old('work_duration') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('work_duration') }}</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div id="work-experience-fields-right" style="display: none;">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="work_location_city"
                                                        placeholder="Location – City"
                                                        value="{{ old('work_location_city') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('work_location_city') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="work_country"
                                                        placeholder="Country" value="{{ old('work_country') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('work_country') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <select class="form-control" name="work_type">
                                                        <option value="">Work Type</option>
                                                        <option value="full-time"
                                                            {{ old('work_type') == 'full-time' ? 'selected' : '' }}>
                                                            Full-time</option>
                                                        <option value="internship"
                                                            {{ old('work_type') == 'internship' ? 'selected' : '' }}>
                                                            Internship</option>
                                                        <option value="freelance"
                                                            {{ old('work_type') == 'freelance' ? 'selected' : '' }}>
                                                            Freelance</option>
                                                        <option value="volunteer"
                                                            {{ old('work_type') == 'volunteer' ? 'selected' : '' }}>
                                                            Volunteer</option>
                                                    </select>
                                                    <small class="text-danger">{{ $errors->first('work_type') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                <!-- Section Divider -->
                                {{-- <div class="section-divider"></div>

                                <!-- Section 7: Additional Achievements -->
                                <div class="education-section">
                                    <h4 class="title" style="color:#4C4C4C;font-size:18px;">Additional Achievements</h4>

                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="awards_recognition"
                                                    placeholder="Awards / Recognition"
                                                    value="{{ old('awards_recognition') }}">
                                                <small
                                                    class="text-danger">{{ $errors->first('awards_recognition') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="volunteer_work"
                                                    placeholder="Volunteer Work / NGO Involvement"
                                                    value="{{ old('volunteer_work') }}">
                                                <small class="text-danger">{{ $errors->first('volunteer_work') }}</small>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="leadership_roles"
                                                    placeholder="Leadership Roles (e.g., Class Representative, Club Head)"
                                                    value="{{ old('leadership_roles') }}">
                                                <small
                                                    class="text-danger">{{ $errors->first('leadership_roles') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="sports_cultural"
                                                    placeholder="Sports / Cultural Participation"
                                                    value="{{ old('sports_cultural') }}">
                                                <small
                                                    class="text-danger">{{ $errors->first('sports_cultural') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}


                            </div>
                        </div>
                </div>

                <div class="d-flex justify-content-between mt-4 mb-4">
                    <a href="{{ route('user.step2') }}" class="btn"
                        style="background:#988DFF1F;color:gray;border:1px solid lightgray;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            stroke="gray" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M15 18l-6-6 6-6" />
                        </svg>
                        Previous
                    </a>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Function to toggle qualification fields
            function toggleQualificationFields() {
                const qualificationsSelect = document.querySelector('select[name="qualifications"]');
                const qualificationFieldsLeft = document.getElementById('qualification-fields');
                const qualificationFieldsRight = document.getElementById('qualification-fields-right');

                if (qualificationsSelect && qualificationsSelect.value && qualificationsSelect.value !== 'none') {
                    // Show qualification fields if any qualification is selected (except 'none')
                    qualificationFieldsLeft.style.display = 'block';
                    qualificationFieldsRight.style.display = 'block';
                } else {
                    // Hide qualification fields if 'none' or nothing is selected
                    qualificationFieldsLeft.style.display = 'none';
                    qualificationFieldsRight.style.display = 'none';
                }
            }

            // Function to toggle work experience fields
            function toggleWorkExperienceFields() {
                const workExperienceSelect = document.querySelector('select[name="have_work_experience"]');
                const workFieldsLeft = document.getElementById('work-experience-fields');
                const workFieldsRight = document.getElementById('work-experience-fields-right');

                if (workExperienceSelect && workExperienceSelect.value === 'yes') {
                    // Show work experience fields if "Yes" is selected
                    workFieldsLeft.style.display = 'block';
                    workFieldsRight.style.display = 'block';
                } else {
                    // Hide work experience fields if "No" or nothing is selected
                    workFieldsLeft.style.display = 'none';
                    workFieldsRight.style.display = 'none';
                }
            }

            // Event listener for qualifications dropdown
            document.querySelector('select[name="qualifications"]').addEventListener('change',
                toggleQualificationFields);

            // Event listener for work experience dropdown
            document.querySelector('select[name="have_work_experience"]').addEventListener('change',
                toggleWorkExperienceFields);

            // Initialize on page load
            toggleQualificationFields();
            toggleWorkExperienceFields();
            toggleSchoolGradeFields();
            toggleJcGradeFields();
        });
    </script>
    <script>
        const now = new Date();

        // current month
        const currentMonth = new Date(now.getFullYear(), now.getMonth(), 1);

        // start month limit = current + 4 months
        const maxStartMonth = new Date(now.getFullYear(), now.getMonth() + 4, 1);

        function parseMonth(value) {
            const [year, month] = value.split('-');
            return new Date(year, month - 1, 1);
        }

        function validateStartYear() {
            const input = document.getElementById('start_year');
            const error = document.getElementById('startYearError');

            if (!input.value) return;

            const selected = parseMonth(input.value);

            if (selected < currentMonth || selected > maxStartMonth) {
                input.classList.add('is-invalid');
                error.classList.remove('d-none');
                input.value = ''; // Clear invalid value
            } else {
                input.classList.remove('is-invalid');
                error.classList.add('d-none');
            }
        }

        function validateExpectedYear() {
            const input = document.getElementById('expected_year');
            const error = document.getElementById('expectedYearError');
            const startInput = document.getElementById('start_year');

            if (!input.value || !startInput.value) return;

            const expected = parseMonth(input.value);
            const start = parseMonth(startInput.value);

            // ✅ correct max = start + 5 years
            const maxExpectedFromStart = new Date(
                start.getFullYear() + 5,
                start.getMonth(),
                1
            );

            if (expected < start || expected > maxExpectedFromStart) {
                input.classList.add('is-invalid');
                error.classList.remove('d-none');
            } else {
                input.classList.remove('is-invalid');
                error.classList.add('d-none');
            }
        }
    </script>

    <script>
        function parseMonth(value) {
            const [year, month] = value.split('-');
            return new Date(year, month - 1, 1);
        }

        function calculateYearDiff() {
            const startVal = document.getElementById('start_year').value;
            const endVal = document.getElementById('expected_year').value;

            if (!startVal || !endVal) return;

            const start = parseMonth(startVal);
            const end = parseMonth(endVal);

            let yearDiff = end.getFullYear() - start.getFullYear();

            // if end month < start month → reduce 1 year
            if (end.getMonth() < start.getMonth()) {
                yearDiff--;
            }

            if (yearDiff < 1) yearDiff = 1;
            if (yearDiff > 5) yearDiff = 5; // cap at 5 years

            generateTableColumns(yearDiff);
        }

        function generateTableColumns(years) {
            const table = document.getElementById('yearWiseTable');

            // ---- THEAD ----
            let thead = `
        <tr style="border-bottom:1px solid lightgray;">
            <th class="text-center">Sr No</th>
            <th class="text-center">Group Name</th>
    `;

            for (let i = 1; i <= years; i++) {
                thead += `<th class="text-center">${i} Year</th>`;
            }

            thead += `<th class="text-center">Total</th></tr>`;
            table.querySelector('thead').innerHTML = thead;

            // ---- TBODY ----
            const groups = [{
                    id: 1,
                    name: 'Tuition Fees'
                },
                {
                    id: 2,
                    name: 'Living Expenses'
                },
                {
                    id: 3,
                    name: 'Other Expenses'
                },
                {
                    id: 4,
                    name: 'Total Expenses'
                }
            ];

            let tbody = '';

            groups.forEach(group => {
                tbody += `
        <tr style="border-bottom:1px solid lightgray;">
            <td class="text-center">${group.id}</td>
            <td class="text-center">${group.name}</td>
        `;

                for (let y = 1; y <= years; y++) {
                    tbody += `
                <td>
                    <input type="number" class="form-control form-control-sm"
                        name="group_${group.id}_year${y}" placeholder="0" required>
                </td>
            `;
                }

                tbody += `
            <td>
                <input type="number" class="form-control form-control-sm"
                    name="group_${group.id}_total" placeholder="0" readonly>
            </td>
        </tr>`;
            });

            table.querySelector('tbody').innerHTML = tbody;
        }

        // trigger on change
        document.getElementById('start_year').addEventListener('change', calculateYearDiff);
        document.getElementById('expected_year').addEventListener('change', calculateYearDiff);

        // Function to calculate row totals
        function calculateRowTotal(rowId) {
            const totalInput = document.querySelector(`input[name="group_${rowId}_total"]`);
            if (!totalInput) return;

            const row = totalInput.closest('tr');
            if (!row) return;

            const inputs = row.querySelectorAll('input[type="number"]:not([readonly])');
            let total = 0;
            inputs.forEach(input => {
                const val = parseFloat(input.value) || 0;
                total += val;
            });

            if (totalInput) {
                totalInput.value = total;
            }
        }

        // Function to calculate Total Expenses column sums
        function calculateTotalExpenses() {
            const table = document.getElementById('yearWiseTable');
            if (!table) return;

            const rows = table.querySelectorAll('tbody tr');
            if (rows.length < 4) return;

            const totalRow = rows[3]; // 4th row (0-indexed)
            const yearInputs = totalRow.querySelectorAll('input[type="number"]:not([name$="_total"])');
            const totalInput = totalRow.querySelector('input[name="group_4_total"]');

            let grandTotal = 0;

            yearInputs.forEach((input, index) => {
                let columnSum = 0;
                // Sum from rows 0,1,2 for this column
                for (let r = 0; r < 3; r++) {
                    const rowInputs = rows[r].querySelectorAll('input[type="number"]:not([readonly])');
                    if (rowInputs[index]) {
                        columnSum += parseFloat(rowInputs[index].value) || 0;
                    }
                }
                input.value = columnSum;
                grandTotal += columnSum;
            });

            if (totalInput) {
                totalInput.value = grandTotal;
            }
        }

        // Add event listeners to table inputs for calculating totals
        function addTotalCalculationListeners() {
            const table = document.getElementById('yearWiseTable');
            if (!table) return;

            const inputs = table.querySelectorAll('input[type="number"]:not([readonly])');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    const name = this.name;
                    const match = name.match(/group_(\d+)_year\d+/);
                    if (match) {
                        const rowId = match[1];
                        calculateRowTotal(rowId);
                        // Also calculate total expenses if any input changes
                        calculateTotalExpenses();
                    }
                });
            });
        }

        // Call after generating table
        // Modify generateTableColumns to add listeners
        const originalGenerateTableColumns = generateTableColumns;
        generateTableColumns = function(years) {
            originalGenerateTableColumns(years);
            // Add listeners after a short delay to ensure DOM is updated
            setTimeout(addTotalCalculationListeners, 100);
        };

        // Function to toggle school grade fields
        function toggleSchoolGradeFields() {
            const percentageRadio = document.getElementById('grade_percentage');
            const cgpaRadio = document.getElementById('grade_cgpa');
            const percentageFields = document.getElementById('percentage_fields');
            const cgpaFields = document.getElementById('cgpa_fields');

            // Get field elements
            const markObtained = document.getElementById('10th_mark_obtained');
            const outOf = document.getElementById('10th_mark_out_of');
            const percentage = document.getElementById('school_percentage');
            const cgpa = document.getElementById('school_CGPA');
            const sgpa = document.getElementById('school_SGPA');

            if (percentageRadio.checked) {
                percentageFields.style.display = 'block';
                cgpaFields.style.display = 'none';
                // Set required
                markObtained.setAttribute('required', 'required');
                outOf.setAttribute('required', 'required');
                percentage.setAttribute('required', 'required');
                // Remove required
                cgpa.removeAttribute('required');
                sgpa.removeAttribute('required');
            } else if (cgpaRadio.checked) {
                percentageFields.style.display = 'none';
                cgpaFields.style.display = 'block';
                // Set required
                cgpa.setAttribute('required', 'required');
                sgpa.setAttribute('required', 'required');
                // Remove required
                markObtained.removeAttribute('required');
                outOf.removeAttribute('required');
                percentage.removeAttribute('required');
            }
        }

        // Event listeners for grade system radios
        document.getElementById('grade_percentage').addEventListener('change', toggleSchoolGradeFields);
        document.getElementById('grade_cgpa').addEventListener('change', toggleSchoolGradeFields);

        // Function to toggle jc grade fields
        function toggleJcGradeFields() {
            const percentageRadio = document.getElementById('jc_grade_percentage');
            const cgpaRadio = document.getElementById('jc_grade_cgpa');
            const percentageFields = document.getElementById('jc_percentage_fields');
            const cgpaFields = document.getElementById('jc_cgpa_fields');

            // Get field elements
            const markObtained = document.getElementById('12th_mark_obtained');
            const outOf = document.getElementById('12th_mark_out_of');
            const percentage = document.getElementById('jc_percentage');
            const cgpa = document.getElementById('jc_CGPA');
            const sgpa = document.getElementById('jc_SGPA');

            if (percentageRadio.checked) {
                percentageFields.style.display = 'block';
                cgpaFields.style.display = 'none';
                // Set required
                markObtained.setAttribute('required', 'required');
                outOf.setAttribute('required', 'required');
                percentage.setAttribute('required', 'required');
                // Remove required
                cgpa.removeAttribute('required');
                sgpa.removeAttribute('required');
            } else if (cgpaRadio.checked) {
                percentageFields.style.display = 'none';
                cgpaFields.style.display = 'block';
                // Set required
                cgpa.setAttribute('required', 'required');
                sgpa.setAttribute('required', 'required');
                // Remove required
                markObtained.removeAttribute('required');
                outOf.removeAttribute('required');
                percentage.removeAttribute('required');
            }
        }

        // Event listeners for jc grade system radios
        document.getElementById('jc_grade_percentage').addEventListener('change', toggleJcGradeFields);
        document.getElementById('jc_grade_cgpa').addEventListener('change', toggleJcGradeFields);

        // Function to calculate school percentage
        function calculateSchoolPercentage() {
            const obtained = parseFloat(document.getElementById('10th_mark_obtained').value) || 0;
            const outOf = parseFloat(document.getElementById('10th_mark_out_of').value) || 0;
            const percentageInput = document.getElementById('school_percentage');
            if (outOf > 0) {
                const percentage = (obtained / outOf) * 100;
                percentageInput.value = percentage.toFixed(2);
            } else {
                percentageInput.value = '';
            }
        }

        // Event listeners for school marks inputs
        document.getElementById('10th_mark_obtained').addEventListener('input', calculateSchoolPercentage);
        document.getElementById('10th_mark_out_of').addEventListener('input', calculateSchoolPercentage);

        // Function to calculate jc percentage
        function calculateJcPercentage() {
            const obtained = parseFloat(document.getElementById('12th_mark_obtained').value) || 0;
            const outOf = parseFloat(document.getElementById('12th_mark_out_of').value) || 0;
            const percentageInput = document.getElementById('jc_percentage');
            if (outOf > 0) {
                const percentage = (obtained / outOf) * 100;
                percentageInput.value = percentage.toFixed(2);
            } else {
                percentageInput.value = '';
            }
        }

        // Event listeners for jc marks inputs
        document.getElementById('12th_mark_obtained').addEventListener('input', calculateJcPercentage);
        document.getElementById('12th_mark_out_of').addEventListener('input', calculateJcPercentage);
    </script>

    <script>
        // Client-side validation for all fields
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');

            // Function to show error
            function showError(fieldId, message) {
                const errorElement = document.getElementById(fieldId + '_error');
                if (errorElement) {
                    errorElement.textContent = message;
                    errorElement.style.display = 'block';
                    const field = document.getElementById(fieldId);
                    if (field) {
                        field.classList.add('is-invalid');
                    }
                }
            }

            // Function to hide error
            function hideError(fieldId) {
                const errorElement = document.getElementById(fieldId + '_error');
                if (errorElement) {
                    errorElement.style.display = 'none';
                    const field = document.getElementById(fieldId);
                    if (field) {
                        field.classList.remove('is-invalid');
                    }
                }
            }

            // Validate required fields
            function validateRequired(fieldId, message = 'This field is required') {
                const field = document.getElementById(fieldId);
                if (!field || !field.value.trim()) {
                    showError(fieldId, message);
                    return false;
                } else {
                    hideError(fieldId);
                    return true;
                }
            }

            // Validate select fields
            function validateSelect(fieldId, message = 'Please select an option') {
                const field = document.getElementById(fieldId);
                if (!field || !field.value || field.value === '') {
                    showError(fieldId, message);
                    return false;
                } else {
                    hideError(fieldId);
                    return true;
                }
            }

            // Validate radio groups
            function validateRadioGroup(name, message = 'Please select an option') {
                const radios = document.querySelectorAll(`input[name="${name}"]:checked`);
                if (radios.length === 0) {
                    // Find the first radio and show error
                    const firstRadio = document.querySelector(`input[name="${name}"]`);
                    if (firstRadio) {
                        const fieldId = firstRadio.id;
                        showError(fieldId, message);
                    }
                    return false;
                } else {
                    const fieldId = radios[0].id;
                    hideError(fieldId);
                    return true;
                }
            }

            // Validate table fields
            function validateTableFields() {
                const table = document.getElementById('yearWiseTable');
                if (!table) return true;

                const inputs = table.querySelectorAll('input[type="number"]:not([readonly])');
                let isValid = true;

                inputs.forEach(input => {
                    if (!input.value || input.value === '0') {
                        input.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    // Show a general table error
                    const tableError = document.getElementById('table_error');
                    if (tableError) {
                        tableError.style.display = 'block';
                    }
                } else {
                    const tableError = document.getElementById('table_error');
                    if (tableError) {
                        tableError.style.display = 'none';
                    }
                }

                return isValid;
            }

            // Form submit validation
            form.addEventListener('submit', function(e) {
                let isValid = true;

                // Basic fields
                isValid &= validateSelect('financial_asset_type', 'Financial Asset Type is required');
                isValid &= validateSelect('financial_asset_for', 'Financial Asset For is required');
                isValid &= validateRequired('course_name', 'Course Name is required');
                isValid &= validateRequired('university_name', 'University Name is required');
                isValid &= validateRequired('college_name', 'College Name is required');
                isValid &= validateRequired('country', 'Country is required');
                isValid &= validateRequired('city_name', 'City Name is required');
                isValid &= validateRequired('start_year', 'Start Year is required');
                isValid &= validateRequired('expected_year', 'Expected Year of Completion is required');

                // School fields
                isValid &= validateRequired('school_name', 'School Name is required');
                isValid &= validateRequired('school_board', 'Board is required');
                isValid &= validateRequired('school_completion_year', 'Year of Completion is required');
                isValid &= validateRadioGroup('school_grade_system', 'Grade System is required');

                // Check grade system and validate accordingly
                const percentageRadio = document.getElementById('grade_percentage');
                const cgpaRadio = document.getElementById('grade_cgpa');
                if (percentageRadio && percentageRadio.checked) {
                    isValid &= validateRequired('10th_mark_obtained', 'Marks obtained is required');
                    isValid &= validateRequired('10th_mark_out_of', 'Marks out of is required');
                    isValid &= validateRequired('school_percentage', 'Percentage is required');
                } else if (cgpaRadio && cgpaRadio.checked) {
                    isValid &= validateRequired('school_CGPA', 'CGPA is required');
                    isValid &= validateRequired('school_SGPA', 'SGPA is required');
                }

                // JC fields
                isValid &= validateRequired('jc_college_name', 'College Name is required');
                isValid &= validateRequired('jc_stream', 'Stream is required');
                isValid &= validateRequired('jc_board', 'Board is required');
                isValid &= validateRequired('jc_completion_year', 'Year of Completion is required');
                isValid &= validateRadioGroup('jc_grade_system', 'Grade System is required');

                // Check JC grade system
                const jcPercentageRadio = document.getElementById('jc_grade_percentage');
                const jcCgpaRadio = document.getElementById('jc_grade_cgpa');
                if (jcPercentageRadio && jcPercentageRadio.checked) {
                    isValid &= validateRequired('12th_mark_obtained', 'Marks obtained is required');
                    isValid &= validateRequired('12th_mark_out_of', 'Marks out of is required');
                    isValid &= validateRequired('jc_percentage', 'Percentage is required');
                } else if (jcCgpaRadio && jcCgpaRadio.checked) {
                    isValid &= validateRequired('jc_CGPA', 'CGPA is required');
                    isValid &= validateRequired('jc_SGPA', 'SGPA is required');
                }

                // Validate table
                isValid &= validateTableFields();

                if (!isValid) {
                    e.preventDefault();
                    // Scroll to first error
                    const firstError = document.querySelector(
                        '.text-danger[style*="display: block"], .is-invalid');
                    if (firstError) {
                        firstError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                    return false;
                }
            });

            // Real-time validation on blur
            const requiredFields = [
                'financial_asset_type', 'financial_asset_for', 'course_name', 'university_name',
                'college_name', 'country', 'city_name', 'start_year', 'expected_year',
                'school_name', 'school_board', 'school_completion_year', 'school_percentage',
                'school_CGPA', 'school_SGPA', 'jc_college_name', 'jc_stream', 'jc_board',
                'jc_completion_year', 'jc_percentage', 'jc_CGPA', 'jc_SGPA', '10th_mark_obtained',
                '10th_mark_out_of', '12th_mark_obtained', '12th_mark_out_of'
            ];

            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.addEventListener('blur', function() {
                        if (field.type === 'select-one') {
                            validateSelect(fieldId);
                        } else {
                            validateRequired(fieldId);
                        }
                    });
                }
            });

            // Table validation on input
            const table = document.getElementById('yearWiseTable');
            if (table) {
                table.addEventListener('input', function(e) {
                    if (e.target.type === 'number') {
                        if (e.target.value && e.target.value !== '0') {
                            e.target.classList.remove('is-invalid');
                        } else {
                            e.target.classList.add('is-invalid');
                        }
                    }
                });
            }
        });
    </script>
@endsection
