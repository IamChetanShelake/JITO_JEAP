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
                    <form method="POST" action="{{ route('user.step2_foreign_pg.store') }}" enctype="multipart/form-data"
                        novalidate>
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
                                                    value="{{ old('course_name', $educationDetail->course_name ?? '') }}"
                                                    required>
                                                <small class="text-danger"
                                                    id="course_name_error">{{ $errors->first('course_name') }}</small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="university_name">University Name <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" id="university_name" class="form-control"
                                                    name="university_name" placeholder="Enter University Name "
                                                    value="{{ old('university_name', $educationDetail->university_name ?? '') }}"
                                                    required>
                                                <small class="text-danger"
                                                    id="university_name_error">{{ $errors->first('university_name') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="college_name">College Name <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" id="college_name" class="form-control"
                                                    name="college_name" placeholder="Enter College Name "
                                                    value="{{ old('college_name', $educationDetail->college_name ?? '') }}"
                                                    required>
                                                <small class="text-danger"
                                                    id="college_name_error">{{ $errors->first('college_name') }}</small>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="country">Country Name <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" id="country" class="form-control" name="country"
                                                    placeholder="Enter Country Name "
                                                    value="{{ old('country', $educationDetail->country ?? '') }}" required>
                                                <small class="text-danger"
                                                    id="country_error">{{ $errors->first('country') }}</small>
                                            </div>

                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="city_name">City Name <span
                                                        style="color: red;">*</span></label>
                                                <input type="text" id="city_name" class="form-control"
                                                    name="city_name" placeholder="Enter City Name "
                                                    value="{{ old('city_name', $educationDetail->city_name ?? '') }}"
                                                    required>
                                                <small class="text-danger"
                                                    id="city_name_error">{{ $errors->first('city_name') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="start_year">
                                                    Start Date <span style="color:red">*</span>
                                                </label>

                                                <input type="date" id="start_year" class="form-control"
                                                    name="start_year"
                                                    value="{{ old('start_year') ?: ($educationDetail && $educationDetail->start_year ? \Carbon\Carbon::parse($educationDetail->start_year)->format('Y-m-d') : '') }}"
                                                    min="1900-01-01"
                                                    max="{{ \Carbon\Carbon::now()->addYear()->format('Y-m-d') }}"
                                                    required>

                                                <small class="text-danger">{{ $errors->first('start_year') }}</small>
                                            </div>


                                            {{-- <div class="form-group mb-3">
                                                <label for="expected_year">Expected Year of Completion <span
                                                        style="color:red">*</span></label>
                                                <input type="month" id="expected_year" class="form-control"
                                                    name="expected_year"
                                                    value="{{ old('expected_year') ?: ($educationDetail && $educationDetail->expected_year ? \Carbon\Carbon::parse($educationDetail->expected_year)->format('Y-m') : '') }}"
                                                    min="{{ date('Y-m') }}" required oninput="validateExpectedYear()">
                                                <small id="expectedYearError" class="text-danger d-none">
                                                    Expected month must be after start month and within next 5 years
                                                </small>
                                            </div> --}}

                                            <div class="form-group mb-3">
                                                <label for="expected_year">
                                                    Expected Date of Completion <span style="color:red">*</span>
                                                </label>

                                                <input type="date" id="expected_year" class="form-control"
                                                    name="expected_year"
                                                    value="{{ old('expected_year') ?: ($educationDetail && $educationDetail->expected_year ? \Carbon\Carbon::parse($educationDetail->expected_year)->format('Y-m-d') : '') }}"
                                                    required>

                                                <small class="text-danger">{{ $errors->first('expected_year') }}</small>
                                            </div>




                                            <div class="form-group mb-3">
                                                <label for="nirf_ranking">NIRF Ranking</label>
                                                <input type="number" id="nirf_ranking" class="form-control"
                                                    name="nirf_ranking" placeholder=" Enter NIRF Ranking"
                                                    value="{{ old('nirf_ranking', $educationDetail->nirf_ranking ?? '') }}">
                                                <small class="text-danger"
                                                    id="nirf_ranking_error">{{ $errors->first('nirf_ranking') }}</small>
                                            </div>

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



                                <!-- Section Divider -->
                                <div class="section-divider"></div>

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
                                                <small class="text-danger"
                                                    id="school_name_error">{{ $errors->first('school_name') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="school_board">Board <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="school_board"
                                                    name="school_board" placeholder="Board "
                                                    value="{{ old('school_board') ?: $educationDetail->school_board ?? '' }}">
                                                <small class="text-danger">{{ $errors->first('school_board') }}</small>
                                            </div>
                                            {{-- <div class="form-group mb-3">
                                                <label for="school_completion_year">Year of Completion <span
                                                        style="color: red;">*</span></label>
                                                <input type="month" class="form-control" id="school_completion_year"
                                                    name="school_completion_year" placeholder="Select Month and Year"
                                                    value="{{ old('school_completion_year') ?: ($educationDetail && $educationDetail->school_completion_year ? $educationDetail->\Carbon\Carbon::parse($educationDetail->school_completion_year)->format('Y-m') : '') }}">
                                                <small
                                                    class="text-danger">{{ $errors->first('school_completion_year') }}</small>
                                            </div> --}}
                                            <div class="form-group mb-3">
                                                <label for="school_completion_year">Year of Completion <span
                                                        style="color: red;">*</span></label>
                                                <input type="month" class="form-control" id="school_completion_year"
                                                    name="school_completion_year" placeholder="Select Month and Year"
                                                    value="{{ old('school_completion_year') ?: ($educationDetail && $educationDetail->school_completion_year ? \Carbon\Carbon::parse($educationDetail->school_completion_year)->format('Y-m') : '') }}"
                                                    max="{{ date('Y') - 1 }}-12" required>
                                                <small
                                                    class="text-danger">{{ $errors->first('school_completion_year') }}</small>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="school_grade_system">Grade System <span
                                                        style="color: red;">*</span></label>
                                                <div>
                                                    {{-- <input type="radio" id="grade_percentage"
                                                        name="school_grade_system" value="percentage"
                                                        {{ old('school_grade_system', 'percentage') == 'percentage' ? 'checked' : '' }}> --}}
                                                    <input type="radio" id="grade_percentage"
                                                        name="school_grade_system" value="percentage"
                                                        {{ old('school_grade_system', $educationDetail->school_grade_system ?? '') == 'percentage' ? 'checked' : '' }}>



                                                    <label
                                                        for="grade_percentage">Percentage</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    {{-- <input type="radio" id="grade_cgpa" name="school_grade_system"
                                                        value="cgpa"
                                                        {{ old('school_grade_system') == 'cgpa' ? 'checked' : '' }}> --}}
                                                    <input type="radio" id="grade_cgpa" name="school_grade_system"
                                                        value="cgpa"
                                                        {{ old('school_grade_system', $educationDetail->school_grade_system ?? '') == 'cgpa' ? 'checked' : '' }}>
                                                    <label for="grade_cgpa">CGPA </label>
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

                                            {{-- <div id="cgpa_fields"
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
                                            </div> --}}
                                            <div id="cgpa_fields"
                                                style="display: {{ old('school_grade_system') == 'cgpa' ? 'block' : 'none' }};">

                                                <!-- CGPA OUT OF -->
                                                <div class="form-group mb-3">
                                                    <label for="school_cgpa_out_of">CGPA Out Of</label>
                                                    <select class="form-control" id="school_cgpa_out_of"
                                                        name="school_cgpa_out_of">
                                                        <option value="">Select</option>
                                                        <option value="10"
                                                            {{ old('school_cgpa_out_of', $educationDetail->school_cgpa_out_of ?? '') == 10 ? 'selected' : '' }}>
                                                            10</option>
                                                        <option value="5"
                                                            {{ old('school_cgpa_out_of', $educationDetail->school_cgpa_out_of ?? '') == 5 ? 'selected' : '' }}>
                                                            5</option>
                                                    </select>
                                                    <small
                                                        class="text-danger">{{ $errors->first('school_cgpa_out_of') }}</small>
                                                </div>

                                                <!-- CGPA -->
                                                <div class="form-group mb-3">
                                                    <label for="school_CGPA">CGPA</label>
                                                    <input type="text" class="form-control" id="school_CGPA"
                                                        name="school_CGPA" placeholder="Enter CGPA"
                                                        value="{{ old('school_CGPA') ?: $educationDetail->school_CGPA ?? '' }}">
                                                    <small class="text-danger">{{ $errors->first('school_CGPA') }}</small>
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
                                            {{-- <div class="form-group mb-3">
                                                <label for="jc_completion_year">Year of Completion <span
                                                        style="color: red;">*</span></label>
                                                <input type="month" class="form-control" id="jc_completion_year"
                                                    name="jc_completion_year" placeholder="Select Month and Year"
                                                    value="{{ old('jc_completion_year') ?: ($educationDetail && $educationDetail->jc_completion_year ? $educationDetail->\Carbon\Carbon::parse($educationDetail->jc_completion_year)->format('Y-m') : '') }}">
                                                <small
                                                    class="text-danger">{{ $errors->first('jc_completion_year') }}</small>
                                            </div> --}}

                                            <div class="form-group mb-3">
                                                <label for="jc_completion_year">Year of Completion <span
                                                        style="color: red;">*</span></label>
                                                <input type="month" class="form-control" id="jc_completion_year"
                                                    name="jc_completion_year" placeholder="Select Month and Year"
                                                    value="{{ old('jc_completion_year') ?: ($educationDetail && $educationDetail->jc_completion_year ? \Carbon\Carbon::parse($educationDetail->jc_completion_year)->format('Y-m') : '') }}"
                                                    max="{{ date('Y') }}-12" required>
                                                <small
                                                    class="text-danger">{{ $errors->first('jc_completion_year') }}</small>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="jc_grade_system">Grade System<span
                                                        style="color: red;">*</span></label>
                                                <div>
                                                    {{-- <input type="radio" id="jc_grade_percentage" name="jc_grade_system"
                                                        value="percentage"
                                                        {{ old('jc_grade_system', 'percentage') == 'percentage' ? 'checked' : '' }}>
                                                    <label
                                                        for="jc_grade_percentage">Percentage</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" id="jc_grade_cgpa" name="jc_grade_system"
                                                        value="cgpa"
                                                        {{ old('jc_grade_system') == 'cgpa' ? 'checked' : '' }}>
                                                    <label for="jc_grade_cgpa">CGPA or SGPA</label> --}}
                                                    <input type="radio" id="jc_grade_percentage" name="jc_grade_system"
                                                        value="percentage"
                                                        {{ old('jc_grade_system', $educationDetail->jc_grade_system ?? 'percentage') == 'percentage' ? 'checked' : '' }}>

                                                    <label
                                                        for="jc_grade_percentage">Percentage</label>&nbsp;&nbsp;&nbsp;&nbsp;

                                                    <input type="radio" id="jc_grade_cgpa" name="jc_grade_system"
                                                        value="cgpa"
                                                        {{ old('jc_grade_system', $educationDetail->jc_grade_system ?? '') == 'cgpa' ? 'checked' : '' }}>

                                                    <label for="jc_grade_cgpa">CGPA</label>

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

                                            {{-- <div id="jc_cgpa_fields"
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
                                            </div> --}}


                                            <div id="jc_cgpa_fields"
                                                style="display: {{ old('jc_grade_system') == 'cgpa' ? 'block' : 'none' }};">

                                                <!-- CGPA OUT OF -->
                                                <div class="form-group mb-3">
                                                    <label for="jc_cgpa_out_of">CGPA Out Of</label>
                                                    <select class="form-control" id="jc_cgpa_out_of"
                                                        name="jc_cgpa_out_of">
                                                        <option value="">Select</option>
                                                        <option value="10"
                                                            {{ old('jc_cgpa_out_of', $educationDetail->jc_cgpa_out_of ?? '') == 10 ? 'selected' : '' }}>
                                                            10</option>
                                                        <option value="5"
                                                            {{ old('jc_cgpa_out_of', $educationDetail->jc_cgpa_out_of ?? '') == 5 ? 'selected' : '' }}>
                                                            5</option>
                                                    </select>
                                                    <small
                                                        class="text-danger">{{ $errors->first('jc_cgpa_out_of') }}</small>
                                                </div>

                                                <!-- CGPA -->
                                                <div class="form-group mb-3">
                                                    <label for="jc_CGPA">CGPA</label>
                                                    <input type="text" class="form-control" id="jc_CGPA"
                                                        name="jc_CGPA" placeholder="Enter CGPA"
                                                        value="{{ old('jc_CGPA') ?: $educationDetail->jc_CGPA ?? '' }}">
                                                    <small class="text-danger">{{ $errors->first('jc_CGPA') }}</small>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- Section Divider -->
                                <div class="section-divider"></div>

                                <!-- Section 2: Completed Qualifications -->
                                <div class="education-section">
                                    <h4 class="title" style="color:#4C4C4C;font-size:18px;">Completed Qualifications</h4>

                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="qualifications">Add your completed qualifications<span
                                                        style="color: red;">*</span></label>
                                                <select class="form-control" name="qualifications"
                                                    id="qualifications_select">
                                                    <option value=""
                                                        {{ !old('qualifications') && !($educationDetail->qualifications ?? '') ? 'selected' : '' }}
                                                        disabled hidden>Add your completed qualifications </option>
                                                    <option value="diploma"
                                                        {{ (old('qualifications') ?: $educationDetail->qualifications ?? '') == 'diploma' ? 'selected' : '' }}>
                                                        Diploma</option>
                                                    <option value="graduation"
                                                        {{ (old('qualifications') ?: $educationDetail->qualifications ?? '') == 'graduation' ? 'selected' : '' }}>
                                                        Graduation</option>
                                                    <option value="masters"
                                                        {{ (old('qualifications') ?: $educationDetail->qualifications ?? '') == 'masters' ? 'selected' : '' }}>
                                                        Masters</option>
                                                    <option value="phd"
                                                        {{ (old('qualifications') ?: $educationDetail->qualifications ?? '') == 'phd' ? 'selected' : '' }}>
                                                        PhD</option>
                                                    <option value="none"
                                                        {{ (old('qualifications') ?: $educationDetail->qualifications ?? '') == 'none' ? 'selected' : '' }}>
                                                        Not Pursued Any of the Above</option>
                                                </select>

                                                <small class="text-danger">{{ $errors->first('qualifications') }}</small>


                                            </div>

                                            <!-- Additional Qualification Fields in Left Column -->
                                            <div id="qualification-fields" style="display: none;">
                                                <div class="form-group mb-3">
                                                    <label for="qualification_institution">Institution / College Name <span
                                                            style="color: red;">*</span></label>
                                                    <input type="text" class="form-control"
                                                        id="qualification_institution" name="qualification_institution"
                                                        placeholder="Institution / College Name "
                                                        value="{{ old('qualification_institution') ?: $educationDetail->qualification_institution ?? '' }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('qualification_institution') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="qualification_university">University Name</label>
                                                    <input type="text" class="form-control"
                                                        id="qualification_university" name="qualification_university"
                                                        placeholder="University Name"
                                                        value="{{ old('qualification_university') ?: $educationDetail->qualification_university ?? '' }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('qualification_university') }}</small>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div id="qualification-fields-right" style="display: none;">
                                                <div class="form-group mb-3">
                                                    <label for="qualification_course_name">Current Course Name <span
                                                            style="color: red;">*</span></label>
                                                    <input type="text" id="qualification_course_name"
                                                        class="form-control" name="qualification_course_name"
                                                        placeholder="Enter Course Name "
                                                        value="{{ old('qualification_course_name', $educationDetail->qualification_course_name ?? '') }}"
                                                        required>
                                                    <small class="text-danger"
                                                        id="qualification_course_name_error">{{ $errors->first('qualification_course_name') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="qualification_start_year">Start Year <span
                                                            style="color:red">*</span></label>
                                                    <input type="month" class="form-control"
                                                        id="qualification_start_year" name="qualification_start_year"
                                                        placeholder="Start Year "
                                                        value="{{ old('qualification_start_year') ?: ($educationDetail && $educationDetail->qualification_start_year ? \Carbon\Carbon::parse($educationDetail->qualification_start_year)->format('Y-m') : '') }}"
                                                        max="{{ date('Y') - 1 }}-12">
                                                    <small
                                                        class="text-danger">{{ $errors->first('qualification_start_year') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="qualification_end_year">End Year <span
                                                            style="color:red">*</span></label>
                                                    <input type="month" class="form-control"
                                                        id="qualification_end_year" name="qualification_end_year"
                                                        placeholder="End Year "
                                                        value="{{ old('qualification_end_year') ?: ($educationDetail && $educationDetail->qualification_end_year ? \Carbon\Carbon::parse($educationDetail->qualification_end_year)->format('Y-m') : '') }}"
                                                        max="{{ date('Y') - 1 }}-12">
                                                    <small
                                                        class="text-danger">{{ $errors->first('qualification_end_year') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-4" id="marksheet-type-section" style="display: none;">
                                            <div class="form-group mb-3">
                                                <label>Enter your percentage / CGPA <span
                                                        class="text-danger">*</span></label>

                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="marksheet_type[]" id="yearBased" value="year"
                                                                {{ in_array('year', old('marksheet_type', json_decode($educationDetail->marksheet_type ?? '[]', true))) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="yearBased">
                                                                Year-based marksheet
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="marksheet_type[]" id="semesterBased"
                                                                value="semester"
                                                                {{ in_array('semester', old('marksheet_type', json_decode($educationDetail->marksheet_type ?? '[]', true))) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="semesterBased">
                                                                Semester-based marksheet
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <!-- TABLE -->
                                            <div class="mt-4 table-responsive" id="marksheetTableWrapper"
                                                style="display:none;">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Year / Sem</th>
                                                            <th>Marks Obtained</th>
                                                            <th>Out Of</th>
                                                            <th>Percentage</th>
                                                            <th>CGPA</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="marksheetTableBody"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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

                                <!-- Section Divider -->
                                <div class="section-divider"></div>

                                <!-- Section 6: Work Experience (if any) -->
                                <div class="education-section">
                                    <h4 class="title" style="color:#4C4C4C;font-size:18px;">Work Experience (if any)</h4>

                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="have_work_experience">Have you worked professionally before?
                                                    <span style="color: red;">*</span></label>
                                                <select class="form-control" name="have_work_experience"
                                                    id="have_work_experience">
                                                    <option value=""
                                                        {{ !old('have_work_experience') ? 'selected' : '' }} hidden>Have
                                                        you worked professionally before? </option>
                                                    {{-- <option value="yes"
                                                        {{ old('have_work_experience') == 'yes' ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option value="no"
                                                        {{ old('have_work_experience') == 'no' ? 'selected' : '' }}>No
                                                    </option> --}}
                                                    <option value="yes"
                                                        {{ old('have_work_experience', $educationDetail->have_work_experience ?? '') == 'yes' ? 'selected' : '' }}>
                                                        Yes
                                                    </option>

                                                    <option value="no"
                                                        {{ old('have_work_experience', $educationDetail->have_work_experience ?? '') == 'no' ? 'selected' : '' }}>
                                                        No
                                                    </option>
                                                </select>
                                                <small class="text-danger"
                                                    id="have_work_experience_error">{{ $errors->first('have_work_experience') }}</small>
                                            </div>

                                            <!-- Additional Work Experience Fields in Left Column -->
                                            <div id="work-experience-fields" style="display: none;">
                                                <div class="form-group mb-3">
                                                    <label for="organization_name">Organization / Company Name</label>
                                                    <input type="text" class="form-control" id="organization_name"
                                                        name="organization_name" placeholder="Organization / Company Name"
                                                        value="{{ old('organization_name') ?: $educationDetail->organization_name ?? '' }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('organization_name') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="work_profile">Work Profile / Designation</label>
                                                    <input type="text" class="form-control" id="work_profile"
                                                        name="work_profile" placeholder="Work Profile / Designation"
                                                        value="{{ old('work_profile') ?: $educationDetail->work_profile ?? '' }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('work_profile') }}</small>
                                                </div>

                                                {{-- <div class="form-group mb-3">
                                                    <label for="duration_start_year">Duration Start Year</label>
                                                    <input type="text" class="form-control" id="duration_start_year"
                                                        name="duration_start_year" placeholder="Start Year"
                                                        value="{{ old('duration_start_year') ?: $educationDetail->duration_start_year ?? '' }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('duration_start_year') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="duration_end_year">Duration End Year</label>
                                                    <input type="text" class="form-control" id="duration_end_year"
                                                        name="duration_end_year" placeholder="End Year"
                                                        value="{{ old('duration_end_year') ?: $educationDetail->duration_end_year ?? '' }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('duration_end_year') }}</small>
                                                </div> --}}
                                                <div class="form-group mb-3">
                                                    <label for="duration_start_year">Duration Start Year</label>
                                                    <input type="date" class="form-control" id="duration_start_year"
                                                        name="duration_start_year" placeholder="Start Year"
                                                        value="{{ old('duration_start_year', $educationDetail->duration_start_year ?? '') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('duration_start_year') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="duration_end_year">Duration End Year</label>
                                                    <input type="date" class="form-control" id="duration_end_year"
                                                        name="duration_end_year" placeholder="End Year"
                                                        value="{{ old('duration_end_year', $educationDetail->duration_end_year ?? '') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('duration_end_year') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="work_location_city">Location – City</label>
                                                    <input type="text" class="form-control" id="work_location_city"
                                                        name="work_location_city" placeholder="Location – City"
                                                        value="{{ old('work_location_city') ?: $educationDetail->work_location_city ?? '' }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('work_location_city') }}</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div id="work-experience-fields-right" style="display: none;">
                                                {{-- <div class="form-group mb-3">
                                                    <label for="work_location_city">Location – City</label>
                                                    <input type="text" class="form-control" id="work_location_city"
                                                        name="work_location_city" placeholder="Location – City"
                                                        value="{{ old('work_location_city') ?: $educationDetail->work_location_city ?? '' }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('work_location_city') }}</small>
                                                </div> --}}

                                                <div class="form-group mb-3">
                                                    <label for="work_country">Country</label>
                                                    <input type="text" class="form-control" id="work_country"
                                                        name="work_country" placeholder="Country"
                                                        value="{{ old('work_country') ?: $educationDetail->work_country ?? '' }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('work_country') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="work_type">Work Type</label>
                                                    <select class="form-control" name="work_type" id="work_type">
                                                        <option value="">Work Type</option>
                                                        <option value="full-time"
                                                            {{ (old('work_type') ?: $educationDetail->work_type ?? '') == 'full-time' ? 'selected' : '' }}>
                                                            Full-time</option>
                                                        <option value="internship"
                                                            {{ (old('work_type') ?: $educationDetail->work_type ?? '') == 'internship' ? 'selected' : '' }}>
                                                            Internship</option>
                                                        <option value="freelance"
                                                            {{ (old('work_type') ?: $educationDetail->work_type ?? '') == 'freelance' ? 'selected' : '' }}>
                                                            Freelance</option>
                                                        <option value="volunteer"
                                                            {{ (old('work_type') ?: $educationDetail->work_type ?? '') == 'volunteer' ? 'selected' : '' }}>
                                                            Volunteer</option>
                                                        <option value="stipend-based"
                                                            {{ (old('work_type') ?: $educationDetail->work_type ?? '') == 'stipend-based' ? 'selected' : '' }}>
                                                            Stipend-based</option>
                                                    </select>
                                                    <small class="text-danger">{{ $errors->first('work_type') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="mention_your_salary">Mention your salary</label>
                                                    <select class="form-control" name="mention_your_salary"
                                                        id="mention_your_salary">
                                                        <option value="">Mention your salary</option>
                                                        <option value="monthly"
                                                            {{ (old('mention_your_salary') ?: $educationDetail->mention_your_salary ?? '') == 'monthly' ? 'selected' : '' }}>
                                                            Monthly Salary</option>
                                                        <option value="yearly"
                                                            {{ (old('mention_your_salary') ?: $educationDetail->mention_your_salary ?? '') == 'yearly' ? 'selected' : '' }}>
                                                            Yearly Salary</option>
                                                        <option value="ctc"
                                                            {{ (old('mention_your_salary') ?: $educationDetail->mention_your_salary ?? '') == 'ctc' ? 'selected' : '' }}>
                                                            CTC</option>
                                                    </select>
                                                    <small
                                                        class="text-danger">{{ $errors->first('mention_your_salary') }}</small>
                                                </div>

                                                <div class="form-group mb-3" id="salary_amount_field"
                                                    style="display: none;">
                                                    <label for="salary_amount">Salary Amount</label>
                                                    <input type="text" class="form-control" id="salary_amount"
                                                        name="salary_amount" placeholder="Enter Salary Amount"
                                                        value="{{ old('salary_amount') ?: $educationDetail->salary_amount ?? '' }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('salary_amount') }}</small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="yearly_gross_income">Yearly Gross Income</label>
                                                    <input type="number" class="form-control" id="yearly_gross_income"
                                                        name="yearly_gross_income" placeholder="Enter Yearly Gross Income"
                                                        value="{{ old('yearly_gross_income') ?: $educationDetail->yearly_gross_income ?? '' }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('yearly_gross_income') }}</small>
                                                </div>



                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-divider"></div>

                                <!-- Section 5: Additional Curriculum -->
                                <div class="education-section">
                                    <h4 class="title" style="color:#4C4C4C;font-size:18px;">Additional Curriculum</h4>

                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="ielts_overall_band_year" class="form-label">IELTS (Overall
                                                    Band + Test Year)</label>
                                                <input type="text" class="form-control" id="ielts_overall_band_year"
                                                    name="ielts_overall_band_year"
                                                    placeholder="IELTS (Overall Band + Test Year)"
                                                    value="{{ old('ielts_overall_band_year') ?: $educationDetail->ielts_overall_band_year ?? '' }}">
                                                <small
                                                    class="text-danger">{{ $errors->first('ielts_overall_band_year') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="toefl_score_year" class="form-label">TOEFL (Score + Test
                                                    Year)</label>
                                                <input type="text" class="form-control" id="toefl_score_year"
                                                    name="toefl_score_year" placeholder="TOEFL (Score + Test Year)"
                                                    value="{{ old('toefl_score_year') ?: $educationDetail->toefl_score_year ?? '' }}">
                                                <small
                                                    class="text-danger">{{ $errors->first('toefl_score_year') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="duolingo_det_score_year" class="form-label">Duolingo (DET)
                                                    (Score + Test Year)</label>
                                                <input type="text" class="form-control" id="duolingo_det_score_year"
                                                    name="duolingo_det_score_year"
                                                    placeholder="Duolingo (DET) (Score + Test Year)"
                                                    value="{{ old('duolingo_det_score_year') ?: $educationDetail->duolingo_det_score_year ?? '' }}">
                                                <small
                                                    class="text-danger">{{ $errors->first('duolingo_det_score_year') }}</small>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="gre_score_year" class="form-label">GRE (Score + Test
                                                    Year)</label>
                                                <input type="text" class="form-control" id="gre_score_year"
                                                    name="gre_score_year" placeholder="GRE (Score + Test Year)"
                                                    value="{{ old('gre_score_year') ?: $educationDetail->gre_score_year ?? '' }}">
                                                <small class="text-danger">{{ $errors->first('gre_score_year') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="gmat_score_year" class="form-label">GMAT (Score + Test
                                                    Year)</label>
                                                <input type="text" class="form-control" id="gmat_score_year"
                                                    name="gmat_score_year" placeholder="GMAT (Score + Test Year)"
                                                    value="{{ old('gmat_score_year') ?: $educationDetail->gmat_score_year ?? '' }}">
                                                <small
                                                    class="text-danger">{{ $errors->first('gmat_score_year') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="sat_score_year" class="form-label">SAT (Score + Test
                                                    Year)</label>
                                                <input type="text" class="form-control" id="sat_score_year"
                                                    name="sat_score_year" placeholder="SAT (Score + Test Year)"
                                                    value="{{ old('sat_score_year') ?: $educationDetail->sat_score_year ?? '' }}">
                                                <small class="text-danger">{{ $errors->first('sat_score_year') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

            // Function to toggle salary amount field
            function toggleSalaryAmount() {
                const mentionSalary = document.getElementById('mention_your_salary');
                const field = document.getElementById('salary_amount_field');
                if (mentionSalary && mentionSalary.value) {
                    field.style.display = 'block';
                } else {
                    field.style.display = 'none';
                }
            }

            // Event listener for salary dropdown
            document.getElementById('mention_your_salary').addEventListener('change', toggleSalaryAmount);

            // Function to toggle school grade fields
            function toggleSchoolGradeFields() {
                const percentageRadio = document.getElementById('grade_percentage');
                const cgpaRadio = document.getElementById('grade_cgpa');

                const percentageFields = document.getElementById('percentage_fields');
                const cgpaFields = document.getElementById('cgpa_fields');

                const markObtained = document.getElementById('10th_mark_obtained');
                const outOf = document.getElementById('10th_mark_out_of');
                const percentage = document.getElementById('school_percentage');

                const cgpa = document.getElementById('school_CGPA');
                const cgpaOutOf = document.getElementById('school_cgpa_out_of');

                if (percentageRadio.checked) {
                    percentageFields.style.display = 'block';
                    cgpaFields.style.display = 'none';

                    markObtained.required = true;
                    outOf.required = true;
                    percentage.required = true;

                    cgpa.required = false;
                    cgpaOutOf.required = false;
                }

                if (cgpaRadio.checked) {
                    percentageFields.style.display = 'none';
                    cgpaFields.style.display = 'block';

                    cgpa.required = true;
                    cgpaOutOf.required = true;

                    markObtained.required = false;
                    outOf.required = false;
                    percentage.required = false;
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

                const markObtained = document.getElementById('12th_mark_obtained');
                const outOf = document.getElementById('12th_mark_out_of');
                const percentage = document.getElementById('jc_percentage');
                const cgpa = document.getElementById('jc_CGPA');
                const cgpaOutOf = document.getElementById('jc_cgpa_out_of');

                if (percentageRadio && percentageRadio.checked) {
                    percentageFields.style.display = 'block';
                    cgpaFields.style.display = 'none';

                    markObtained.required = true;
                    outOf.required = true;
                    percentage.required = true;

                    cgpa.required = false;
                    cgpaOutOf.required = false;
                }

                if (cgpaRadio && cgpaRadio.checked) {
                    percentageFields.style.display = 'none';
                    cgpaFields.style.display = 'block';

                    cgpa.required = true;
                    cgpaOutOf.required = true;

                    markObtained.required = false;
                    outOf.required = false;
                    percentage.required = false;
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

            // Function to check if work experience data exists and show fields accordingly
            function initializeWorkExperienceFields() {
                const workExperienceSelect = document.querySelector('select[name="have_work_experience"]');
                const workFieldsLeft = document.getElementById('work-experience-fields');
                const workFieldsRight = document.getElementById('work-experience-fields-right');

                // Check if there's saved data for work experience
                const savedData = @json($educationDetail ?? null);
                const hasWorkExperienceData = savedData &&
                    (savedData.organization_name || savedData.work_profile || savedData.work_location_city);

                if (hasWorkExperienceData || (workExperienceSelect && workExperienceSelect.value === 'yes')) {
                    workFieldsLeft.style.display = 'block';
                    workFieldsRight.style.display = 'block';
                    if (workExperienceSelect) workExperienceSelect.value = 'yes';
                } else if (workExperienceSelect && workExperienceSelect.value === 'no') {
                    workFieldsLeft.style.display = 'none';
                    workFieldsRight.style.display = 'none';
                }
            }

            // Initialize on page load
            toggleQualificationFields();
            initializeWorkExperienceFields();
            toggleSalaryAmount();
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

        // Prevent form submission if start year is invalid
        document.querySelector('form').addEventListener('submit', function(e) {
            const input = document.getElementById('start_year');
            const error = document.getElementById('startYearError');

            if (!input.value) {
                // Required field, but let HTML required handle it
                return;
            }

            const selected = parseMonth(input.value);

            if (selected > maxStartMonth) {
                e.preventDefault();
                input.classList.add('is-invalid');
                error.classList.remove('d-none');
                input.focus();
            }
        });

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

        // Function to populate table with saved data
        function populateTableWithSavedData() {
            const table = document.getElementById('yearWiseTable');
            if (!table) return;

            // Get saved data from PHP variables (passed from controller)
            const savedData = @json($educationDetail ?? null);

            if (!savedData) return;

            // Populate each row with saved data
            const groups = [{
                    id: 1,
                    name: 'group_1'
                },
                {
                    id: 2,
                    name: 'group_2'
                },
                {
                    id: 3,
                    name: 'group_3'
                },
                {
                    id: 4,
                    name: 'group_4'
                }
            ];

            groups.forEach(group => {
                // Populate year columns
                for (let year = 1; year <= 5; year++) {
                    const input = document.querySelector(`input[name="${group.name}_year${year}"]`);
                    if (input && savedData[`${group.name}_year${year}`]) {
                        input.value = savedData[`${group.name}_year${year}`];
                    }
                }

                // Populate total column
                const totalInput = document.querySelector(`input[name="${group.name}_total"]`);
                if (totalInput && savedData[`${group.name}_total`]) {
                    totalInput.value = savedData[`${group.name}_total`];
                }
            });
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
                        name="group_${group.id}_year${y}" placeholder="0">
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

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // If we have saved start and expected years, generate table accordingly
            const startYearInput = document.getElementById('start_year');
            const expectedYearInput = document.getElementById('expected_year');

            if (startYearInput.value && expectedYearInput.value) {
                calculateYearDiff();
            }

            // Populate table with saved data
            populateTableWithSavedData();
        });

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
    </script>
    <script>
        const startInput = document.getElementById('qualification_start_year');
        const endInput = document.getElementById('qualification_end_year');
        const yearBased = document.getElementById('yearBased');
        const semesterBased = document.getElementById('semesterBased');
        const tableWrapper = document.getElementById('marksheetTableWrapper');
        const tableBody = document.getElementById('marksheetTableBody');

        function calculateYears() {
            if (!startInput.value || !endInput.value) return 0;

            const start = new Date(startInput.value);
            const end = new Date(endInput.value);

            const months =
                (end.getFullYear() - start.getFullYear()) * 12 +
                (end.getMonth() - start.getMonth()) + 1;

            return Math.floor(months / 12);
        }

        function generateTable(type) {
            tableBody.innerHTML = '';

            const years = calculateYears();
            if (years <= 0) {
                tableWrapper.style.display = 'none';
                return;
            }

            let rows = type === 'year' ? years : years * 2;
            let label = type === 'year' ? 'Year' : 'Sem';

            for (let i = 1; i <= rows; i++) {
                tableBody.innerHTML += `
                <tr>
                    <td style="color: red;">${i}${label}</td>
                    <td><input type="number" class="form-control marks-obtained" name="marks_obtained[]" required></td>
                    <td><input type="number" class="form-control out-of" name="out_of[]" required></td>
                    <td><input type="number" step="0.01" class="form-control percentage" name="percentage[]" required readonly></td>
                    <td><input type="number" step="0.01" class="form-control cgpa" name="cgpa[]" required readonly></td>
                </tr>
            `;
            }

            // Add calculation listeners for auto-calculating percentage and CGPA
            addCalculationListeners();

            tableWrapper.style.display = 'block';
        }

        function addCalculationListeners() {
            const rows = tableBody.querySelectorAll('tr');
            rows.forEach(row => {
                const marksObtained = row.querySelector('.marks-obtained');
                const outOf = row.querySelector('.out-of');
                const percentage = row.querySelector('.percentage');
                const cgpa = row.querySelector('.cgpa');

                function calculate() {
                    const obtained = parseFloat(marksObtained.value) || 0;
                    const total = parseFloat(outOf.value) || 0;

                    if (total > 0) {
                        const perc = (obtained / total) * 100;
                        percentage.value = perc.toFixed(2);

                        // CGPA calculation: assuming CGPA = percentage / 10 (common conversion)
                        const cgpaValue = perc / 10;
                        cgpa.value = cgpaValue.toFixed(2);
                    } else {
                        percentage.value = '';
                        cgpa.value = '';
                    }
                }

                marksObtained.addEventListener('input', calculate);
                outOf.addEventListener('input', calculate);
            });
        }

        function toggleMarksheetTypeSection() {
            const section = document.getElementById('marksheet-type-section');
            if (endInput.value) {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        }

        // Ensure only one checkbox is checked at a time
        yearBased.addEventListener('change', function() {
            if (this.checked) {
                semesterBased.checked = false;
                generateTable('year');
            }
        });

        semesterBased.addEventListener('change', function() {
            if (this.checked) {
                yearBased.checked = false;
                generateTable('semester');
            }
        });

        startInput.addEventListener('change', () => {
            toggleMarksheetTypeSection();
            if (yearBased.checked) generateTable('year');
            if (semesterBased.checked) generateTable('semester');
        });

        endInput.addEventListener('change', () => {
            toggleMarksheetTypeSection();
            if (yearBased.checked) generateTable('year');
            if (semesterBased.checked) generateTable('semester');
        });

        // Function to populate marksheet table with saved data
        function populateMarksheetWithSavedData() {
            // Get saved data from PHP variables (passed from controller)
            const savedData = @json($educationDetail ?? null);

            if (!savedData) return;

            // Check if marksheet data exists (decode JSON arrays)
            const marksObtained = @json(json_decode($educationDetail->marks_obtained ?? '[]', true));
            const outOf = @json(json_decode($educationDetail->out_of ?? '[]', true));
            const percentage = @json(json_decode($educationDetail->percentage ?? '[]', true));
            const cgpa = @json(json_decode($educationDetail->cgpa ?? '[]', true));
            const marksheetType = @json(json_decode($educationDetail->marksheet_type ?? '[]', true));

            if (marksObtained.length === 0) return;

            // Show the marksheet type section
            const section = document.getElementById('marksheet-type-section');
            section.style.display = 'block';

            // Ensure start and end dates are set for calculateYears
            if (!startInput.value && savedData.qualification_start_year) {
                startInput.value = new Date(savedData.qualification_start_year).toISOString().slice(0, 7);
            }
            if (!endInput.value && savedData.qualification_end_year) {
                endInput.value = new Date(savedData.qualification_end_year).toISOString().slice(0, 7);
            }

            // Set the appropriate checkbox
            if (marksheetType.includes('year')) {
                yearBased.checked = true;
                semesterBased.checked = false;
                generateTable('year');
            } else if (marksheetType.includes('semester')) {
                semesterBased.checked = true;
                yearBased.checked = false;
                generateTable('semester');
            }

            // Populate table data after a delay to ensure DOM is updated
            setTimeout(() => {
                const rows = tableBody.querySelectorAll('tr');
                rows.forEach((row, index) => {
                    if (index < marksObtained.length) {
                        const inputs = row.querySelectorAll('input');
                        if (inputs.length >= 4) {
                            inputs[0].value = marksObtained[index] || ''; // marks_obtained
                            inputs[1].value = outOf[index] || ''; // out_of
                            inputs[2].value = percentage[index] || ''; // percentage
                            inputs[3].value = cgpa[index] || ''; // cgpa
                        }
                    }
                });
            }, 500);
        }

        // Initialize
        toggleMarksheetTypeSection();
        populateMarksheetWithSavedData();
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

            form.addEventListener('submit', function(e) {
                let isValid = true;

                // Basic fields
                isValid = isValid && validateSelect('financial_asset_type',
                    'Financial Asset Type is required');
                isValid = isValid && validateSelect('financial_asset_for',
                    'Financial Asset For is required');
                isValid = isValid && validateRequired('course_name', 'Course Name is required');
                isValid = isValid && validateRequired('university_name', 'University Name is required');
                isValid = isValid && validateRequired('college_name', 'College Name is required');
                isValid = isValid && validateRequired('country', 'Country is required');
                isValid = isValid && validateRequired('city_name', 'City Name is required');
                isValid = isValid && validateRequired('start_year', 'Start Year is required');
                isValid = isValid && validateRequired('expected_year',
                    'Expected Year of Completion is required');

                // School fields
                isValid = isValid && validateRequired('school_name', 'School Name is required');
                isValid = isValid && validateRequired('school_board', 'Board is required');
                isValid = isValid && validateRequired('school_completion_year',
                    'Year of Completion is required');
                isValid = isValid && validateRadioGroup('school_grade_system', 'Grade System is required');

                // School grade system
                const percentageRadio = document.getElementById('grade_percentage');
                const cgpaRadio = document.getElementById('grade_cgpa');

                if (percentageRadio && percentageRadio.checked) {
                    isValid = isValid && validateRequired('10th_mark_obtained',
                        'Marks obtained is required');
                    isValid = isValid && validateRequired('10th_mark_out_of', 'Marks out of is required');
                    isValid = isValid && validateRequired('school_percentage', 'Percentage is required');
                } else if (cgpaRadio && cgpaRadio.checked) {
                    isValid = isValid && validateRequired('school_CGPA', 'CGPA is required');
                    isValid = isValid && validateRequired('school_cgpa_out_of', 'CGPA out of is required');
                }

                // JC fields
                isValid = isValid && validateRequired('jc_college_name', 'College Name is required');
                isValid = isValid && validateRequired('jc_stream', 'Stream is required');
                isValid = isValid && validateRequired('jc_board', 'Board is required');
                isValid = isValid && validateRequired('jc_completion_year',
                    'Year of Completion is required');
                isValid = isValid && validateRadioGroup('jc_grade_system', 'Grade System is required');


                // JC grade system
                const jcPercentageRadio = document.getElementById('jc_grade_percentage');
                const jcCgpaRadio = document.getElementById('jc_grade_cgpa');

                if (jcPercentageRadio && jcPercentageRadio.checked) {
                    isValid = isValid && validateRequired('12th_mark_obtained',
                        'Marks obtained is required');
                    isValid = isValid && validateRequired('12th_mark_out_of', 'Marks out of is required');
                    isValid = isValid && validateRequired('jc_percentage', 'Percentage is required');
                } else if (jcCgpaRadio && jcCgpaRadio.checked) {
                    isValid = isValid && validateRequired('jc_CGPA', 'CGPA is required');
                    isValid = isValid && validateRequired('jc_cgpa_out_of', 'CGPA out of is required');
                }

                // Final check
                if (!isValid) {
                    e.preventDefault();
                    return false;
                }
            });


            // Real-time validation on blur
            const requiredFields = [
                'financial_asset_type', 'financial_asset_for', 'course_name', 'university_name',
                'college_name', 'country', 'city_name', 'start_year', 'expected_year',
                'school_name', 'school_board', 'school_completion_year', 'school_grade_system',
                'school_percentage',
                'school_CGPA', 'school_cgpa_out_of', 'jc_college_name', 'jc_stream', 'jc_board',
                'jc_completion_year', 'jc_grade_system', 'jc_percentage', 'jc_CGPA', 'jc_cgpa_out_of',
                'qualifications',
                'qualification_institution', 'qualification_start_year', 'qualification_end_year',
                'have_work_experience', 'organization_name', 'work_profile', 'duration_start_year',
                'duration_end_year', 'work_location_city', 'work_country', 'work_type',
                'mention_your_salary', 'salary_amount','yearly_gross_income', '10th_mark_obtained', '10th_mark_out_of',
                '12th_mark_obtained', '12th_mark_out_of', 'ielts_overall_band_year', 'toefl_score_year', '
                pte_score_year ','
                duolingo_score_year ','
                other_exam_name ','
                other_exam_score ','
                other_exam_year '
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            toggleSchoolGradeFields();
            toggleJcGradeFields();
        });
    </script>
@endsection
