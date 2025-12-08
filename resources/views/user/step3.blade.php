@extends('user.layout.master')
@section('step')
    <button class="btn btn-purple me-2" style="background-color: #393185; color: white;">Step 3 of
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
    </style>

    <!-- Main Content -->
    <div class="col-lg-9 main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{ route('user.step3.store') }}" enctype="multipart/form-data">
                        @csrf
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
                                <!-- Section 1: Current Education -->
                                <div class="education-section">
                                    <h4 class="title" style="color:#4C4C4C;font-size:18px;">Current Education</h4>

                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <select class="form-control" name="current_pursuing">
                                                    <option value="" {{ !old('current_pursuing') ? 'selected' : '' }}
                                                        disabled hidden>Are you currently pursuing any course or degree? *
                                                    </option>
                                                    <option value="yes"
                                                        {{ old('current_pursuing') == 'yes' ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option value="no"
                                                        {{ old('current_pursuing') == 'no' ? 'selected' : '' }}>No</option>
                                                </select>
                                                <small class="text-danger">{{ $errors->first('current_pursuing') }}</small>
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
                                                        placeholder="Start Year *" value="{{ old('current_start_year') }}">
                                                    <small
                                                        class="text-danger">{{ $errors->first('current_start_year') }}</small>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" name="current_expected_year"
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
                                                <select class="form-control" name="qualifications">
                                                    <option value="" {{ !old('qualifications') ? 'selected' : '' }} disabled hidden>Add your completed qualifications *</option>
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
                                                {{-- <select class="form-control" name="qualifications">
                                                    <option value="" hidden>Add your completed qualifications *
                                                    </option>

                                                    <option value="diploma"
                                                        {{ old('qualifications') == 'diploma' ? 'selected' : '' }}>
                                                        Diploma
                                                    </option>

                                                    <option value="graduation"
                                                        {{ old('qualifications') == 'graduation' ? 'selected' : '' }}>
                                                        Graduation
                                                    </option>

                                                    <option value="masters"
                                                        {{ old('qualifications') == 'masters' ? 'selected' : '' }}>
                                                        Masters
                                                    </option>

                                                    <option value="phd"
                                                        {{ old('qualifications') == 'phd' ? 'selected' : '' }}>
                                                        PhD
                                                    </option>

                                                    <option value="none"
                                                        {{ old('qualifications') == 'none' ? 'selected' : '' }}>
                                                        Not Pursued Any of the Above
                                                    </option>
                                                </select> --}}
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
                                                <input type="text" class="form-control" name="jc_college_name"
                                                    placeholder="College / Junior College Name *"
                                                    value="{{ old('jc_college_name') }}">
                                                <small class="text-danger">{{ $errors->first('jc_college_name') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="jc_stream"
                                                    placeholder="Select Stream *" value="{{ old('jc_stream') }}">
                                                <small class="text-danger">{{ $errors->first('jc_stream') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="jc_board"
                                                    placeholder="Select Board *" value="{{ old('jc_board') }}">
                                                <small class="text-danger">{{ $errors->first('jc_board') }}</small>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="jc_completion_year"
                                                    placeholder="Year of Completion *"
                                                    value="{{ old('jc_completion_year') }}">
                                                <small
                                                    class="text-danger">{{ $errors->first('jc_completion_year') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="jc_percentage"
                                                    placeholder="Percentage / CGPA *" value="{{ old('jc_percentage') }}">
                                                <small class="text-danger">{{ $errors->first('jc_percentage') }}</small>
                                            </div>
                                        </div>
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
                                                <input type="text" class="form-control" name="school_name"
                                                    placeholder="School Name *" value="{{ old('school_name') }}">
                                                <small class="text-danger">{{ $errors->first('school_name') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="school_board"
                                                    placeholder="Board *" value="{{ old('school_board') }}">
                                                <small class="text-danger">{{ $errors->first('school_board') }}</small>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="school_completion_year"
                                                    placeholder="Year of Completion *"
                                                    value="{{ old('school_completion_year') }}">
                                                <small
                                                    class="text-danger">{{ $errors->first('school_completion_year') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="school_percentage"
                                                    placeholder="Percentage / CGPA *"
                                                    value="{{ old('school_percentage') }}">
                                                <small
                                                    class="text-danger">{{ $errors->first('school_percentage') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section Divider -->
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
                                </div>

                                <!-- Section Divider -->
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
                                </div>

                                <!-- Section Divider -->
                                <div class="section-divider"></div>

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
                                                <small class="text-danger">{{ $errors->first('sports_cultural') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section Divider -->
                                <div class="section-divider"></div>

                                <!-- Section 8: Your Financial Need Overview -->
                                <div class="education-section">
                                    <h4 class="title" style="color:#4C4C4C;font-size:18px;">Your Financial Need Overview
                                    </h4>

                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="institute_name"
                                                    placeholder="Institute Name *" value="{{ old('institute_name') }}">
                                                <small class="text-danger">{{ $errors->first('institute_name') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="course_name"
                                                    placeholder="Course Name *" value="{{ old('course_name') }}">
                                                <small class="text-danger">{{ $errors->first('course_name') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="city_name"
                                                    placeholder="City Name *" value="{{ old('city_name') }}">
                                                <small class="text-danger">{{ $errors->first('city_name') }}</small>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <input type="text" class="form-control" name="country"
                                                    placeholder="Country *" value="{{ old('country') }}">
                                                <small class="text-danger">{{ $errors->first('country') }}</small>
                                            </div>

                                            <div class="form-group mb-3">
                                                <select class="form-control" name="duration">
                                                    <option value="" {{ !old('duration') ? 'selected' : '' }}
                                                        disabled hidden>Duration *</option>
                                                    <option value="1"
                                                        {{ old('duration') == '1' ? 'selected' : '' }}>1 Year</option>
                                                    <option value="2"
                                                        {{ old('duration') == '2' ? 'selected' : '' }}>2 Years</option>
                                                    <option value="3"
                                                        {{ old('duration') == '3' ? 'selected' : '' }}>3 Years</option>
                                                    <option value="4"
                                                        {{ old('duration') == '4' ? 'selected' : '' }}>4 Years</option>
                                                    <option value="5"
                                                        {{ old('duration') == '5' ? 'selected' : '' }}>5 Years</option>
                                                    <option value="6"
                                                        {{ old('duration') == '6' ? 'selected' : '' }}>6 Years</option>
                                                    <option value="7"
                                                        {{ old('duration') == '7' ? 'selected' : '' }}>7 Years</option>
                                                    <option value="8"
                                                        {{ old('duration') == '8' ? 'selected' : '' }}>8 Years</option>
                                                    <option value="9"
                                                        {{ old('duration') == '9' ? 'selected' : '' }}>9 Years</option>
                                                    <option value="10"
                                                        {{ old('duration') == '10' ? 'selected' : '' }}>10 Years</option>
                                                </select>
                                                <small class="text-danger">{{ $errors->first('duration') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section Divider -->
                                <div class="section-divider"></div>

                                <!-- Section 9: Financial Summary Table -->
                                <div class="education-section">
                                    <h4 class="title" style="color:#4C4C4C;font-size:18px;">Financial Summary</h4>

                                    <div class="table-responsive">
                                        <table class="table"
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
                                                            class="form-control form-control-sm" name="tuition_fee_year1"
                                                            value="{{ old('tuition_fee_year1') }}" placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="tuition_fee_year2"
                                                            value="{{ old('tuition_fee_year2') }}" placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="tuition_fee_year3"
                                                            value="{{ old('tuition_fee_year3') }}" placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="tuition_fee_year4"
                                                            value="{{ old('tuition_fee_year4') }}" placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="tuition_fee_total"
                                                            value="{{ old('tuition_fee_total') }}" placeholder="0"
                                                            readonly></td>
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
                                                            value="{{ old('group_2_year1') }}" placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_2_year2"
                                                            value="{{ old('group_2_year2') }}" placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_2_year3"
                                                            value="{{ old('group_2_year3') }}" placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_2_year4"
                                                            value="{{ old('group_2_year4') }}" placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_2_total"
                                                            value="{{ old('group_2_total') }}" placeholder="0" readonly>
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
                                                            value="{{ old('group_3_year1') }}" placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_3_year2"
                                                            value="{{ old('group_3_year2') }}" placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_3_year3"
                                                            value="{{ old('group_3_year3') }}" placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_3_year4"
                                                            value="{{ old('group_3_year4') }}" placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_3_total"
                                                            value="{{ old('group_3_total') }}" placeholder="0" readonly>
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
                                                            value="{{ old('group_4_year1') }}" placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_4_year2"
                                                            value="{{ old('group_4_year2') }}" placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_4_year3"
                                                            value="{{ old('group_4_year3') }}" placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_4_year4"
                                                            value="{{ old('group_4_year4') }}" placeholder="0"></td>
                                                    <td style="border: none;"><input type="number"
                                                            class="form-control form-control-sm" name="group_4_total"
                                                            value="{{ old('group_4_total') }}" placeholder="0" readonly>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Error messages for table fields -->
                                    <div class="mb-3">
                                        <small class="text-danger">{{ $errors->first('tuition_fee_year1') }}</small>
                                        <small class="text-danger">{{ $errors->first('tuition_fee_year2') }}</small>
                                        <small class="text-danger">{{ $errors->first('tuition_fee_year3') }}</small>
                                        <small class="text-danger">{{ $errors->first('tuition_fee_year4') }}</small>
                                        <small class="text-danger">{{ $errors->first('group_name_2') }}</small>
                                        <small class="text-danger">{{ $errors->first('group_name_3') }}</small>
                                        <small class="text-danger">{{ $errors->first('group_name_4') }}</small>
                                    </div>
                                </div>
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
            // Function to toggle current education fields
            function toggleCurrentEducation() {
                const currentPursuingSelect = document.querySelector('select[name="current_pursuing"]');
                const currentFieldsLeft = document.getElementById('current-education-fields');
                const currentFieldsRight = document.getElementById('current-education-fields-right');

                if (currentPursuingSelect && currentPursuingSelect.value === 'yes') {
                    currentFieldsLeft.style.display = 'block';
                    currentFieldsRight.style.display = 'block';
                } else {
                    currentFieldsLeft.style.display = 'none';
                    currentFieldsRight.style.display = 'none';
                }
            }

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

            // Event listener for current pursuing dropdown
            document.querySelector('select[name="current_pursuing"]').addEventListener('change',
                toggleCurrentEducation);

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
            toggleCurrentEducation();
            toggleQualificationFields();
            toggleWorkExperienceFields();
        });
    </script>
@endsection
