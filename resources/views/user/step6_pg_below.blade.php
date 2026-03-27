@extends('user.layout.master')
@section('step')
    <button class="btn btn-purple me-2" style="background-color: #393185; color: white;">Step 6 of
        7</button>
@endsection
@section('content')
    <style>
        .section-divider {
            height: 1px;
            background: #e9ecef;
            margin: 30px 0;
        }

        .photo-upload-box {
            width: 100%;
            height: 100% !important;
            border: 1px solid #d9d9d9;
            border-radius: 7px;
            padding: 20px 18px 0px 12px;
            font-family: 'Poppins', sans-serif;
            color: #4C4C4C;
            background: white;
            overflow: hidden;
            min-height: 110px;
        }
    </style>
    <!-- Main Content -->
    <div class="col-lg-9 main-content">
        <!-- Hold Remark Alert -->
        @if ($documents && $documents->submit_status === 'resubmit' && $documents->admin_remark)
            <div class="alert alert-warning alert-dismissible fade show" role="alert"
                style="background-color: #fff3cd; border-color: #ffeaa7; color: #856404; border-radius: 8px; margin-bottom: 20px;">
                <div class="d-flex justify-content-between align-items-start gap-2">
                    <div style="min-width: 0;">
                        <strong><i class="bi bi-exclamation-triangle-fill"></i> Hold Notice:</strong>
                        <p
                            style="margin: 8px 0 4px 0; font-size: 14px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ trim(preg_replace('/\s+/', ' ', strip_tags($documents->admin_remark))) }}
                        </p>
                        <button type="button" class="btn btn-link p-0" data-bs-toggle="modal"
                            data-bs-target="#holdRemarkModal">
                            View More
                        </button>
                    </div>
                    <button type="button" class="btn-close ms-2 flex-shrink-0" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            </div>

            <div class="modal fade" id="holdRemarkModal" tabindex="-1" aria-labelledby="holdRemarkModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="holdRemarkModalLabel">Hold Notice</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {!! $documents->admin_remark !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{ route('user.step6.storepgbelow') }}" enctype="multipart/form-data" novalidate>
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
                                        <i class="bi bi-journal-text"></i>

                                    </div>
                                    <div>
                                        <h3 class="card-title">Document Upload </h3>
                                        <p class="card-subtitle">Please upload the required documents</p>
                                    </div>
                                </div>

                                <!-- Important Note Box -->
                                <div
                                    style="background-color: #FEF6E0; border: 1px solid #FBBA00; border-radius: 8px; padding: 12px; margin-bottom: 20px;">
                                    <p class="mb-0" style="color: #E31E24; font-size:16px;font-weight: 500;">
                                        <strong>Note:</strong> Please ensure all documents are clear and in PDF or
                                        image format (JPG, PNG). Maximum file size: 5MB per document.
                                    </p>
                                </div>

                                <!--  Documents Fields -->
                                <div class="documents-section">
                                    <div class="row mb-3">
                                        <!-- Left Column -->
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                            
                                            <!-- 1. SSC Marksheet -->
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">SSC Marksheet *</span>
                                                            <input type="file" id="ssc_marksheet"
                                                                name="ssc_cbse_icse_ib_igcse" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf" required
                                                                @if ($documents && $documents->ssc_cbse_icse_ib_igcse) data-filename="{{ basename($documents->ssc_cbse_icse_ib_igcse) }}" @endif>
                                                            <small class="text-danger">{{ $errors->first('ssc_cbse_icse_ib_igcse') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="ssc_marksheet" class="upload-btn">
                                                                <span class="upload-icon">⭱</span> Upload
                                                            </label>
                                                            <label class="uploaded-btn" style="display: none;">
                                                                <span class="upload-icon">✔</span> Upload
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-12">
                                                            <div class="upload-status" style="display:none;">
                                                                <div class="row">
                                                                    <div class="col-9"><div class="upload-summary"></div></div>
                                                                    <div class="col-3">
                                                                        <button type="button" class="remove-upload btn bt-sm" style="display:none;">
                                                                            <i class="bi bi-trash"></i> Remove</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($documents && $documents->ssc_cbse_icse_ib_igcse)
                                                    <div class="existing-document mt-2">
                                                        <a href="{{ asset($documents->ssc_cbse_icse_ib_igcse) }}" target="_blank" class="btn btn-sm btn-success">View Existing Document</a>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- 2. HSC / Diploma Marksheet -->
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">HSC / Diploma Marksheet *</span>
                                                            <input type="file" id="hsc_diploma_marksheet" name="hsc_diploma_marksheet" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf" required
                                                                @if ($documents && $documents->hsc_diploma_marksheet) data-filename="{{ basename($documents->hsc_diploma_marksheet) }}" @endif>
                                                            <small class="text-danger">{{ $errors->first('hsc_diploma_marksheet') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="hsc_diploma_marksheet" class="upload-btn">
                                                                <span class="upload-icon">⭱</span> Upload
                                                            </label>
                                                            <label class="uploaded-btn" style="display: none;">
                                                                <span class="upload-icon">✔</span> Upload
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-12">
                                                            <div class="upload-status" style="display:none;">
                                                                <div class="row">
                                                                    <div class="col-9"><div class="upload-summary"></div></div>
                                                                    <div class="col-3">
                                                                        <button type="button" class="remove-upload btn bt-sm" style="display:none;">
                                                                            <i class="bi bi-trash"></i> Remove</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($documents && $documents->hsc_diploma_marksheet)
                                                    <div class="existing-document mt-2">
                                                        <a href="{{ asset($documents->hsc_diploma_marksheet) }}" target="_blank" class="btn btn-sm btn-success">View Existing Document</a>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- 3. Graduation Marksheet (Only for Post Graduation) -->
                                            @if ($user->financial_asset_for == 'post_graduation')
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Graduation Marksheet *</span>
                                                            <input type="file" id="graduation_marksheet" name="graduate_post_graduate_marksheet" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf" required
                                                                @if ($documents && $documents->graduate_post_graduate_marksheet) data-filename="{{ basename($documents->graduate_post_graduate_marksheet) }}" @endif>
                                                            <small class="text-danger">{{ $errors->first('graduate_post_graduate_marksheet') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="graduation_marksheet" class="upload-btn">
                                                                <span class="upload-icon">⭱</span> Upload
                                                            </label>
                                                            <label class="uploaded-btn" style="display: none;">
                                                                <span class="upload-icon">✔</span> Upload
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-12">
                                                            <div class="upload-status" style="display:none;">
                                                                <div class="row">
                                                                    <div class="col-9"><div class="upload-summary"></div></div>
                                                                    <div class="col-3">
                                                                        <button type="button" class="remove-upload btn bt-sm" style="display:none;">
                                                                            <i class="bi bi-trash"></i> Remove</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($documents && $documents->graduate_post_graduate_marksheet)
                                                    <div class="existing-document mt-2">
                                                        <a href="{{ asset($documents->graduate_post_graduate_marksheet) }}" target="_blank" class="btn btn-sm btn-success">View Existing Document</a>
                                                    </div>
                                                @endif
                                            </div>
                                            @endif

                                            <!-- 4. College – Fees Structure -->
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">College – Fees Structure *</span>
                                                            <input type="file" id="college_fees_structure" name="admission_letter_fees_structure" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf" required
                                                                @if ($documents && $documents->admission_letter_fees_structure) data-filename="{{ basename($documents->admission_letter_fees_structure) }}" @endif>
                                                            <small class="text-danger">{{ $errors->first('admission_letter_fees_structure') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="college_fees_structure" class="upload-btn">
                                                                <span class="upload-icon">⭱</span> Upload
                                                            </label>
                                                            <label class="uploaded-btn" style="display: none;">
                                                                <span class="upload-icon">✔</span> Upload
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-12">
                                                            <div class="upload-status" style="display:none;">
                                                                <div class="row">
                                                                    <div class="col-9"><div class="upload-summary"></div></div>
                                                                    <div class="col-3">
                                                                        <button type="button" class="remove-upload btn bt-sm" style="display:none;">
                                                                            <i class="bi bi-trash"></i> Remove</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($documents && $documents->admission_letter_fees_structure)
                                                    <div class="existing-document mt-2">
                                                        <a href="{{ asset($documents->admission_letter_fees_structure) }}" target="_blank" class="btn btn-sm btn-success">View Existing Document</a>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- 5. PAN Card – Applicant -->
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">PAN Card – Applicant *</span>
                                                            <input type="file" id="pan_applicant" name="pan_applicant" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf" required
                                                                @if ($documents && $documents->pan_applicant) data-filename="{{ basename($documents->pan_applicant) }}" @endif>
                                                            <small class="text-danger">{{ $errors->first('pan_applicant') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="pan_applicant" class="upload-btn">
                                                                <span class="upload-icon">⭱</span> Upload
                                                            </label>
                                                            <label class="uploaded-btn" style="display: none;">
                                                                <span class="upload-icon">✔</span> Upload
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-12">
                                                            <div class="upload-status" style="display:none;">
                                                                <div class="row">
                                                                    <div class="col-9"><div class="upload-summary"></div></div>
                                                                    <div class="col-3">
                                                                        <button type="button" class="remove-upload btn bt-sm" style="display:none;">
                                                                            <i class="bi bi-trash"></i> Remove</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($documents && $documents->pan_applicant)
                                                    <div class="existing-document mt-2">
                                                        <a href="{{ asset($documents->pan_applicant) }}" target="_blank" class="btn btn-sm btn-success">View Existing Document</a>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- 6. Aadhaar Card – Applicant -->
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Aadhaar Card – Applicant *</span>
                                                            <input type="file" id="aadhaar_applicant" name="aadhaar_applicant" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf" required
                                                                @if ($documents && $documents->aadhaar_applicant) data-filename="{{ basename($documents->aadhaar_applicant) }}" @endif>
                                                            <small class="text-danger">{{ $errors->first('aadhaar_applicant') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="aadhaar_applicant" class="upload-btn">
                                                                <span class="upload-icon">⭱</span> Upload
                                                            </label>
                                                            <label class="uploaded-btn" style="display: none;">
                                                                <span class="upload-icon">✔</span> Upload
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-12">
                                                            <div class="upload-status" style="display:none;">
                                                                <div class="row">
                                                                    <div class="col-9"><div class="upload-summary"></div></div>
                                                                    <div class="col-3">
                                                                        <button type="button" class="remove-upload btn bt-sm" style="display:none;">
                                                                            <i class="bi bi-trash"></i> Remove</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($documents && $documents->aadhaar_applicant)
                                                    <div class="existing-document mt-2">
                                                        <a href="{{ asset($documents->aadhaar_applicant) }}" target="_blank" class="btn btn-sm btn-success">View Existing Document</a>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">

                                            <!-- 7. Jain Sangh Certificate -->
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Jain Sangh Certificate *&nbsp;&nbsp;
                                                                <a href="{{ asset('SANGH-CERTIFICATE-FORM.pdf') }}" download>
                                                                    <svg width="25" height="25" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg" style="cursor: pointer;">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.5 19C12.0196 19 14.4359 17.9991 16.2175 16.2175C17.9991 14.4359 19 12.0196 19 9.5C19 6.98044 17.9991 4.56408 16.2175 2.78249C14.4359 1.00089 12.0196 0 9.5 0C6.98044 0 4.56408 1.00089 2.78249 2.78249C1.00089 4.56408 0 6.98044 0 9.5C0 12.0196 1.00089 14.4359 2.78249 16.2175C4.56408 17.9991 6.98044 19 9.5 19ZM13.7696 11.2779L9.97907 15.0684C9.85182 15.1956 9.67925 15.267 9.49932 15.267C9.31939 15.267 9.14682 15.1956 9.01957 15.0684L5.23043 11.2779C5.13583 11.183 5.07144 11.0622 5.04538 10.9308C5.01933 10.7993 5.03276 10.6631 5.084 10.5393C5.13523 10.4155 5.22198 10.3096 5.33329 10.2351C5.44461 10.1605 5.57551 10.1205 5.7095 10.1202H8.14286V5.08929C8.14286 4.72935 8.28584 4.38415 8.54035 4.12964C8.79487 3.87513 9.14006 3.73214 9.5 3.73214C9.85994 3.73214 10.2051 3.87513 10.4596 4.12964C10.7142 4.38415 10.8571 4.72935 10.8571 5.08929V10.1202H13.2905C13.4245 10.1205 13.5554 10.1605 13.6667 10.2351C13.778 10.3096 13.8648 10.4155 13.916 10.5393C13.9672 10.6631 13.9807 10.7993 13.9546 10.9308C13.9286 11.0622 13.8642 11.183 13.7696 11.2779Z" fill="#009846" />
                                                                    </svg>
                                                                </a>
                                                            </span>
                                                            <input type="file" id="jain_sangh_certificate" name="jain_sangh_certificate" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf" required
                                                                @if ($documents && $documents->jain_sangh_certificate) data-filename="{{ basename($documents->jain_sangh_certificate) }}" @endif>
                                                            <small class="text-danger">{{ $errors->first('jain_sangh_certificate') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="jain_sangh_certificate" class="upload-btn">
                                                                <span class="upload-icon">⭱</span> Upload
                                                            </label>
                                                            <label class="uploaded-btn" style="display: none;">
                                                                <span class="upload-icon">✔</span> Upload
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-12">
                                                            <div class="upload-status" style="display:none;">
                                                                <div class="row">
                                                                    <div class="col-9"><div class="upload-summary"></div></div>
                                                                    <div class="col-3">
                                                                        <button type="button" class="remove-upload btn bt-sm" style="display:none;">
                                                                            <i class="bi bi-trash"></i> Remove</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($documents && $documents->jain_sangh_certificate)
                                                    <div class="existing-document mt-2">
                                                        <a href="{{ asset($documents->jain_sangh_certificate) }}" target="_blank" class="btn btn-sm btn-success">View Existing Document</a>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- 8. Recommendation of JITO Member -->
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Recommendation of JITO Member *&nbsp;&nbsp;
                                                                <a href="{{ asset('NEW_JITO RECOMMENDATION FORM FORMAT_20122025.pdf') }}" download>
                                                                    <svg width="25" height="25" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg" style="cursor:pointer;">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.5 19C12.0196 19 14.4359 17.9991 16.2175 16.2175C17.9991 14.4359 19 12.0196 19 9.5C19 6.98044 17.9991 4.56408 16.2175 2.78249C14.4359 1.00089 12.0196 0 9.5 0C6.98044 0 4.56408 1.00089 2.78249 2.78249C1.00089 4.56408 0 6.98044 0 9.5C0 12.0196 1.00089 14.4359 2.78249 16.2175C4.56408 17.9991 6.98044 19 9.5 19ZM13.7696 11.2779L9.97907 15.0684C9.85182 15.1956 9.67925 15.267 9.49932 15.267C9.31939 15.267 9.14682 15.1956 9.01957 15.0684L5.23043 11.2779C5.13583 11.183 5.07144 11.0622 5.04538 10.9308C5.01933 10.7993 5.03276 10.6631 5.084 10.5393C5.13523 10.4155 5.22198 10.3096 5.33329 10.2351C5.44461 10.1605 5.57551 10.1205 5.7095 10.1202H8.14286V5.08929C8.14286 4.72935 8.28584 4.38415 8.54035 4.12964C8.79487 3.87513 9.14006 3.73214 9.5 3.73214C9.85994 3.73214 10.2051 3.87513 10.4596 4.12964C10.7142 4.38415 10.8571 4.72935 10.8571 5.08929V10.1202H13.2905C13.4245 10.1205 13.5554 10.1605 13.6667 10.2351C13.778 10.3096 13.8648 10.4155 13.916 10.5393C13.9672 10.6631 13.9807 10.7993 13.9546 10.9308C13.9286 11.0622 13.8642 11.183 13.7696 11.2779Z" fill="#009846" />
                                                                    </svg>
                                                                </a>
                                                            </span>
                                                            <input type="file" id="jito_recommendation" name="jito_group_recommendation" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf" required
                                                                @if ($documents && $documents->jito_group_recommendation) data-filename="{{ basename($documents->jito_group_recommendation) }}" @endif>
                                                            <small class="text-danger">{{ $errors->first('jito_group_recommendation') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="jito_recommendation" class="upload-btn">
                                                                <span class="upload-icon">⭱</span> Upload
                                                            </label>
                                                            <label class="uploaded-btn" style="display: none;">
                                                                <span class="upload-icon">✔</span> Upload
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-12">
                                                            <div class="upload-status" style="display:none;">
                                                                <div class="row">
                                                                    <div class="col-9"><div class="upload-summary"></div></div>
                                                                    <div class="col-3">
                                                                        <button type="button" class="remove-upload btn bt-sm" style="display:none;">
                                                                            <i class="bi bi-trash"></i> Remove</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($documents && $documents->jito_group_recommendation)
                                                    <div class="existing-document mt-2">
                                                        <a href="{{ asset($documents->jito_group_recommendation) }}" target="_blank" class="btn btn-sm btn-success">View Existing Document</a>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- 9. Latest Electricity Bill -->
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Latest Electricity Bill *</span>
                                                            <input type="file" id="electricity_bill" name="electricity_bill" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf" required
                                                                @if ($documents && $documents->electricity_bill) data-filename="{{ basename($documents->electricity_bill) }}" @endif>
                                                            <small class="text-danger">{{ $errors->first('electricity_bill') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="electricity_bill" class="upload-btn">
                                                                <span class="upload-icon">⭱</span> Upload
                                                            </label>
                                                            <label class="uploaded-btn" style="display: none;">
                                                                <span class="upload-icon">✔</span> Upload
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-12">
                                                            <div class="upload-status" style="display:none;">
                                                                <div class="row">
                                                                    <div class="col-9"><div class="upload-summary"></div></div>
                                                                    <div class="col-3">
                                                                        <button type="button" class="remove-upload btn bt-sm" style="display:none;">
                                                                            <i class="bi bi-trash"></i> Remove</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($documents && $documents->electricity_bill)
                                                    <div class="existing-document mt-2">
                                                        <a href="{{ asset($documents->electricity_bill) }}" target="_blank" class="btn btn-sm btn-success">View Existing Document</a>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- 10. Aadhaar Card – Father / Mother / Guardian -->
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Aadhaar Card – Father / Mother / Guardian *</span>
                                                            <input type="file" id="aadhaar_parent" name="aadhaar_father_mother" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf" required
                                                                @if ($documents && $documents->aadhaar_father_mother) data-filename="{{ basename($documents->aadhaar_father_mother) }}" @endif>
                                                            <small class="text-danger">{{ $errors->first('aadhaar_father_mother') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="aadhaar_parent" class="upload-btn">
                                                                <span class="upload-icon">⭱</span> Upload
                                                            </label>
                                                            <label class="uploaded-btn" style="display: none;">
                                                                <span class="upload-icon">✔</span> Upload
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-12">
                                                            <div class="upload-status" style="display:none;">
                                                                <div class="row">
                                                                    <div class="col-9"><div class="upload-summary"></div></div>
                                                                    <div class="col-3">
                                                                        <button type="button" class="remove-upload btn bt-sm" style="display:none;">
                                                                            <i class="bi bi-trash"></i> Remove</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($documents && $documents->aadhaar_father_mother)
                                                    <div class="existing-document mt-2">
                                                        <a href="{{ asset($documents->aadhaar_father_mother) }}" target="_blank" class="btn btn-sm btn-success">View Existing Document</a>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- 11. PAN Card – Father / Mother / Guardian -->
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">PAN Card – Father / Mother / Guardian *</span>
                                                            <input type="file" id="pan_parent" name="pan_father_mother" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf" required
                                                                @if ($documents && $documents->pan_father_mother) data-filename="{{ basename($documents->pan_father_mother) }}" @endif>
                                                            <small class="text-danger">{{ $errors->first('pan_father_mother') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="pan_parent" class="upload-btn">
                                                                <span class="upload-icon">⭱</span> Upload
                                                            </label>
                                                            <label class="uploaded-btn" style="display: none;">
                                                                <span class="upload-icon">✔</span> Upload
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-12">
                                                            <div class="upload-status" style="display:none;">
                                                                <div class="row">
                                                                    <div class="col-9"><div class="upload-summary"></div></div>
                                                                    <div class="col-3">
                                                                        <button type="button" class="remove-upload btn bt-sm" style="display:none;">
                                                                            <i class="bi bi-trash"></i> Remove</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($documents && $documents->pan_father_mother)
                                                    <div class="existing-document mt-2">
                                                        <a href="{{ asset($documents->pan_father_mother) }}" target="_blank" class="btn btn-sm btn-success">View Existing Document</a>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- 12. Form No. 16 OR Salary Slips -->
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Form No. 16 (Last 6 months salary) OR Salary Slips *</span>
                                                            <input type="file" id="form_16_salary" name="form16_salary_income_father" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf" required
                                                                @if ($documents && $documents->form16_salary_income_father) data-filename="{{ basename($documents->form16_salary_income_father) }}" @endif>
                                                            <small class="text-danger">{{ $errors->first('form16_salary_income_father') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="form_16_salary" class="upload-btn">
                                                                <span class="upload-icon">⭱</span> Upload
                                                            </label>
                                                            <label class="uploaded-btn" style="display: none;">
                                                                <span class="upload-icon">✔</span> Upload
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-12">
                                                            <div class="upload-status" style="display:none;">
                                                                <div class="row">
                                                                    <div class="col-9"><div class="upload-summary"></div></div>
                                                                    <div class="col-3">
                                                                        <button type="button" class="remove-upload btn bt-sm" style="display:none;">
                                                                            <i class="bi bi-trash"></i> Remove</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($documents && $documents->form16_salary_income_father)
                                                    <div class="existing-document mt-2">
                                                        <a href="{{ asset($documents->form16_salary_income_father) }}" target="_blank" class="btn btn-sm btn-success">View Existing Document</a>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- 13. Bank Statement of Father -->
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Bank Statement of Father (Last 1 Year) OR Passbook Copy *</span>
                                                            <input type="file" id="bank_statement_father" name="bank_statement_father_12months" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf" required
                                                                @if ($documents && $documents->bank_statement_father_12months) data-filename="{{ basename($documents->bank_statement_father_12months) }}" @endif>
                                                            <small class="text-danger">{{ $errors->first('bank_statement_father_12months') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="bank_statement_father" class="upload-btn">
                                                                <span class="upload-icon">⭱</span> Upload
                                                            </label>
                                                            <label class="uploaded-btn" style="display: none;">
                                                                <span class="upload-icon">✔</span> Upload
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-12">
                                                            <div class="upload-status" style="display:none;">
                                                                <div class="row">
                                                                    <div class="col-9"><div class="upload-summary"></div></div>
                                                                    <div class="col-3">
                                                                        <button type="button" class="remove-upload btn bt-sm" style="display:none;">
                                                                            <i class="bi bi-trash"></i> Remove</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($documents && $documents->bank_statement_father_12months)
                                                    <div class="existing-document mt-2">
                                                        <a href="{{ asset($documents->bank_statement_father_12months) }}" target="_blank" class="btn btn-sm btn-success">View Existing Document</a>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-4 mb-4">
                            <a href="{{ route('user.step6') }}" class="btn"
                                style="background:#988DFF1F;color:gray;border:1px solid lightgray;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    stroke="gray" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M15 18l-6-6 6-6" />
                                </svg>
                                Previous
                            </a>
                            @if ($documents && in_array($documents->submit_status, ['submited', 'approved']))
                                 <button type="submit" class="btn" style="background:#393185;color:white;">Next Step
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        stroke="white" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M9 6l6 6-6 6" />
                                    </svg>
                                </button>
                            @elseif ($documents && $documents->submit_status == 'resubmit')
                                <button type="submit" class="btn"
                                    style="background:#F0FDF4;color:red;border:1px solid red">
                                    <i class="bi bi-arrow-clockwise" style="color: red; font-size: 24px;"></i>
                                    Resubmit Step 6
                                </button>
                            @else
                                <button type="submit" class="btn" style="background:#393185;color:white;">Next Step
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        stroke="white" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M9 6l6 6-6 6" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Function to handle file upload
            function handleFileUpload(fileInput) {
                const photoUploadBox = fileInput.closest('.photo-upload-box');
                const uploadStatus = photoUploadBox.querySelector('.upload-status');
                const uploadButton = photoUploadBox.querySelector('.upload-btn');
                const uploadedButton = photoUploadBox.querySelector('.uploaded-btn');
                const uploadSummary = photoUploadBox.querySelector('.upload-summary');
                const removeBtn = photoUploadBox.querySelector('.remove-upload');

                if (fileInput.files.length > 0) {
                    const file = fileInput.files[0];
                    const fileSizeKB = Math.round(file.size / 1024);
                    const fileSizeText = fileSizeKB > 1024 ? (fileSizeKB / 1024).toFixed(2) + ' MB' : fileSizeKB + ' KB';

                    uploadSummary.innerHTML = `
                        <div class="text-success mb-1" style="word-break: break-all;">✔ Document uploaded successfully</div>
                        <small class="text-muted" style="word-break: break-all;">
                            <strong>Name:</strong> ${file.name}<br>
                            <strong>Size:</strong> ${fileSizeText}
                        </small>
                    `;
                    uploadButton.style.display = 'none';
                    uploadedButton.style.display = 'flex';
                    uploadedButton.style.color = '#009846';
                    uploadedButton.style.border = '1px solid #009846';
                    uploadedButton.style.justifyContent = 'center';
                    uploadedButton.style.alignItems = 'center';
                    uploadedButton.style.fontSize = '91%';
                    uploadedButton.style.borderRadius = '10px';
                    uploadStatus.style.display = 'block';
                    removeBtn.style.display = 'inline-block';
                } else {
                    uploadStatus.style.display = 'none';
                    removeBtn.style.display = 'none';
                    uploadSummary.innerHTML = '';
                }
            }

            // Function to remove upload
            function removeUpload(fileInput) {
                const photoUploadBox = fileInput.closest('.photo-upload-box');
                const uploadStatus = photoUploadBox.querySelector('.upload-status');
                const uploadSummary = photoUploadBox.querySelector('.upload-summary');
                const uploadButton = photoUploadBox.querySelector('.upload-btn');
                const uploadedButton = photoUploadBox.querySelector('.uploaded-btn');
                const removeBtn = photoUploadBox.querySelector('.remove-upload');

                fileInput.value = '';
                uploadStatus.style.display = 'none';
                removeBtn.style.display = 'none';
                uploadSummary.innerHTML = '';
                uploadButton.style.display = 'block';
                uploadedButton.style.display = 'none';
            }

            // Add event listeners to all file inputs
            const fileInputs = document.querySelectorAll('input[type="file"]');
            fileInputs.forEach(function(input) {
                input.addEventListener('change', function() {
                    handleFileUpload(this);
                });

                const photoUploadBox = input.closest('.photo-upload-box');
                if (photoUploadBox) {
                    const removeBtn = photoUploadBox.querySelector('.remove-upload');
                    if (removeBtn) {
                        removeBtn.addEventListener('click', function() {
                            removeUpload(input);
                        });
                    }
                }
            });

            // Initialize upload status for existing documents
            fileInputs.forEach(function(input) {
                const dataFilename = input.getAttribute('data-filename');
                if (dataFilename) {
                    const photoUploadBox = input.closest('.photo-upload-box');
                    const uploadStatus = photoUploadBox.querySelector('.upload-status');
                    const uploadButton = photoUploadBox.querySelector('.upload-btn');
                    const uploadedButton = photoUploadBox.querySelector('.uploaded-btn');
                    const uploadSummary = photoUploadBox.querySelector('.upload-summary');
                    const removeBtn = photoUploadBox.querySelector('.remove-upload');

                    uploadSummary.innerHTML = `
                        <div class="text-success mb-1" style="word-break: break-all;">✔ Document uploaded successfully</div>
                        <small class="text-muted" style="word-break: break-all;">
                            <strong>Name:</strong> ${dataFilename}<br>
                            <strong>Status:</strong> Existing Document
                        </small>
                    `;
                    uploadButton.style.display = 'none';
                    uploadedButton.style.display = 'flex';
                    uploadedButton.style.color = '#009846';
                    uploadedButton.style.border = '1px solid #009846';
                    uploadedButton.style.justifyContent = 'center';
                    uploadedButton.style.alignItems = 'center';
                    uploadedButton.style.fontSize = '91%';
                    uploadedButton.style.borderRadius = '10px';
                    uploadStatus.style.display = 'block';
                    removeBtn.style.display = 'inline-block';
                }
            });
        });
    </script>
@endsection