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
    </style>
    <!-- Main Content -->
    <div class="col-lg-9 main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{ route('user.step6.store') }}" enctype="multipart/form-data">
                        @csrf
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
                                        <strong>Note:</strong> Please ensure all documents are clear, legible, and in PDF or
                                        image format (JPG, PNG). Maximum file size: 5MB per document.
                                    </p>
                                </div>

                                <!--  Documents Fields -->
                                <div class="documents-section">
                                    <div class="row mb-3">
                                        <!-- Left Column -->
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                            <h4 class="title mb-3" style="color:#393185;font-size:18px;">Education Documents
                                            </h4>
                                            <hr>

                                            {{-- board 1  --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">CBSE/ICSE/SSC/IB/IGCSE *</span>
                                                            <input type="file" id="uploadInput1" name="board" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf">
                                                            <small class="text-danger">{{ $errors->first('board') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="uploadInput1" class="upload-btn">
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

                                            {{-- board 2  --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">HSC/CBSE/ICSE/IB/IGCSE *</span>
                                                            <input type="file" id="uploadInput2" name="board2" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('board2') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="uploadInput2" class="upload-btn">
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

                                            {{-- graduation  --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Graduation *</span>
                                                            <input type="file" id="graduation" name="graduation"
                                                                hidden accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('graduation') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="graduation" class="upload-btn">
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

                                            {{-- post graduation  --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Post Graduation *</span>
                                                            <input type="file" id="post_graduation"
                                                                name="post_graduation" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('post_graduation') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="post_graduation" class="upload-btn">
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
                                            {{-- fee structure  --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Fee Structure *</span>
                                                            <input type="file" id="fee_structure" name="fee_structure"
                                                                hidden accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('fee_structure') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="fee_structure" class="upload-btn">
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
                                            {{-- addmission letter  --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">1-20 or admission letter *</span>
                                                            <input type="file" id="admission_letter"
                                                                name="admission_letter" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('admission_letter') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="admission_letter" class="upload-btn">
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
                                            {{-- addmission letter  --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Student handwritten stating for
                                                                choosing
                                                                course & institutes</span>
                                                            <input type="file" id="statement" name="statement" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('statement') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="statement" class="upload-btn">
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
                                            <br>

                                            {{-- identity and address proof  --}}

                                            <h4 class="title mb-3" style="color:#393185;font-size:18px;">Identity &
                                                Address Proof
                                            </h4>

                                            {{-- visa --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Visa copy</span>
                                                            <input type="file" id="visa" name="visa" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('visa') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="visa" class="upload-btn">
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
                                            {{-- passport --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Passport copy *</span>
                                                            <input type="file" id="passport" name="passport" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('applicant_aadhar') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="passport" class="upload-btn">
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
                                            {{-- aadhar copy of applicant --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Aadhar card copy of applicant
                                                                *</span>
                                                            <input type="file" id="applicant_aadhar"
                                                                name="applicant_aadhar" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('applicant_aadhar') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="applicant_aadhar" class="upload-btn">
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
                                            {{-- pan  of applicant --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Pan card of applicant *</span>
                                                            <input type="file" id="applicant_pan" name="applicant_pan"
                                                                hidden accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('applicant_pan') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="applicant_pan" class="upload-btn">
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
                                            {{-- birth certificate --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Birth certificate</span>
                                                            <input type="file" id="birth_certificate"
                                                                name="birth_certificate" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('birth_certificate') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="birth_certificate" class="upload-btn">
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
                                            {{-- Electricity Bill - latest  --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Electricity Bill - latest *</span>
                                                            <input type="file" id="electricity_bill"
                                                                name="electricity_bill" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('electricity_bill') }}</small>
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

                                        <!-- Right Column -->
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                            <h4 class="title mb-3" style="color:#393185;font-size:18px;">Financial
                                                Documents
                                            </h4>
                                            <hr>

                                            {{-- ITR acknowledgement of father * --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">ITR acknowledgement of father
                                                                *</span>
                                                            <input type="file" id="father_itr" name="father_itr"
                                                                hidden accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('father_itr') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="father_itr" class="upload-btn">
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
                                            {{-- ITR acknowledgment with profit and loss statement and balance sheet of father --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">ITR acknowledgment with profit and
                                                                loss
                                                                statement and balance sheet of father *</span>
                                                            <input type="file" id="father_balanceSheet_pr_lss_stmnt"
                                                                name="father_balanceSheet_pr_lss_stmnt" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('father_balanceSheet_pr_lss_stmnt') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="father_balanceSheet_pr_lss_stmnt"
                                                                class="upload-btn">
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
                                            {{-- If father/mother is salaried, upload Form No. 16 or last 6 months’ salary slips --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">If father/mother is salaried, upload
                                                                Form No.
                                                                16 or last 6 months’ salary slips *</span>
                                                            <input type="file" id="form16_salary_sleep"
                                                                name="form16_salary_sleep" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('form16_salary_sleep') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="form16_salary_sleep" class="upload-btn">
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

                                            {{-- Father & mother income proof (at least 2 or 3 year) --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Father & mother income proof (at
                                                                least 2 or 3
                                                                year) *</span>
                                                            <input type="file" id="father_mother_income"
                                                                name="father_mother_income" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('father_mother_income') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="father_mother_income" class="upload-btn">
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

                                            {{-- Proof of funds arranged from(Loan taken from any other institution)  --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Proof of funds arranged from(Loan
                                                                taken from
                                                                any other institution) </span>
                                                            <input type="file" id="loan_arrangement"
                                                                name="loan_arrangement" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('loan_arrangement') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="loan_arrangement" class="upload-btn">
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
                                            <br>


                                            <h4 class="title mb-3" style="color:#393185;font-size:18px;">Bank Statement
                                            </h4>

                                            {{-- Bank statement of father (last 12 months) --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Bank statement of father (last 12
                                                                months)
                                                                *</span>
                                                            <input type="file" id="father_bank_stmnt"
                                                                name="father_bank_stmnt" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('father_bank_stmnt') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="father_bank_stmnt" class="upload-btn">
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
                                            {{-- Bank statement of mother (last 12 months) --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Bank statement of mother (last 12
                                                                months)
                                                                *</span>
                                                            <input type="file" id="mother_bank_stmnt"
                                                                name="mother_bank_stmnt" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('mother_bank_stmnt') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="mother_bank_stmnt" class="upload-btn">
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
                                            {{-- Student main bank details & statement for last 6 months/year  --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Student main bank details & statement
                                                                for
                                                                last 6 months/year *</span>
                                                            <input type="file" id="student_main_bank_details"
                                                                name="student_main_bank_details" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('student_main_bank_details') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="student_main_bank_details" class="upload-btn">
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
                                            <br>

                                            <h4 class="title mb-3" style="color:#393185;font-size:18px;">Additional
                                                Documents
                                            </h4>

                                            {{-- Jain sangh certificate --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Jain sangh certificate *</span>
                                                            <input type="file" id="jain_sangh_cert"
                                                                name="jain_sangh_cert" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('jain_sangh_cert') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="jain_sangh_cert" class="upload-btn">
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

                                            {{-- Recommendation of JATF  --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Recommendation of JATF *</span>
                                                            <input type="file" id="jatf_recommendation"
                                                                name="jatf_recommendation" hidden
                                                                accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('jatf_recommendation') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="jatf_recommendation" class="upload-btn">
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
                                            {{-- Other documents (if any achievement)   --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Other documents (if any achievement)
                                                            </span>
                                                            <input type="file" id="other_docs" name="other_docs"
                                                                hidden accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('other_docs') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="other_docs" class="upload-btn">
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
                                            {{-- Extra curriculum  --}}
                                            <div class="form-group mb-3">
                                                <div class="photo-upload-box">
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-9">
                                                            <span class="photo-label">Extra curriculum </span>
                                                            <input type="file" id="extra_curri" name="extra_curri"
                                                                hidden accept=".jpg,.jpeg,.png,.pdf">
                                                            <small
                                                                class="text-danger">{{ $errors->first('extra_curri') }}</small>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="extra_curri" class="upload-btn">
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
                                                                            style="display:none;border-radius:10px;">
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
        document.addEventListener('DOMContentLoaded', function() {

            // Function to handle file upload
            function handleFileUpload(fileInput) {
                console.log('File upload triggered for input:', fileInput.name);
                const photoUploadBox = fileInput.closest('.photo-upload-box');
                const uploadStatus = photoUploadBox.querySelector('.upload-status');
                const uploadButton = photoUploadBox.querySelector('.upload-btn');
                const uploadedButton = photoUploadBox.querySelector('.uploaded-btn');
                console.log('Upload status element:', uploadStatus);
                const uploadSummary = photoUploadBox.querySelector('.upload-summary');
                const removeBtn = photoUploadBox.querySelector('.remove-upload');

                if (fileInput.files.length > 0) {
                    const file = fileInput.files[0];
                    console.log('Selected file:', file);
                    const fileSizeKB = Math.round(file.size / 1024);
                    const fileSizeText = fileSizeKB > 1024 ? (fileSizeKB / 1024).toFixed(2) + ' MB' : fileSizeKB +
                        ' KB';

                    uploadSummary.innerHTML = `
                        <div class="text-success mb-1">✔ Document uploaded successfully</div>
                        <small class="text-muted">
                            <strong>Name:</strong> ${file.name}<br>
                            <strong>Size:</strong> ${fileSizeText}
                        </small>
                    `;

                    photoUploadBox.style.height = '143px';
                    uploadButton.style.display = 'none';
                    uploadedButton.style.display = 'block';
                    uploadedButton.style.color = '#009846';
                    uploadedButton.style.border = '1px solid #009846';
                    uploadedButton.style.display = 'flex';
                    uploadedButton.style.justifyContent = 'center';
                    uploadedButton.style.alignItems = 'center';
                    uploadedButton.style.fontSize = '91%';
                    uploadedButton.style.borderRadius = '10px';
                    uploadStatus.style.display = 'block';
                    removeBtn.style.display = 'inline-block';
                } else {
                    photoUploadBox.style.height = '50px';
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
                photoUploadBox.style.height = '50px';
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
                    // console.log(input);
                    handleFileUpload(this);
                });

                // Add remove button functionality
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
        });
    </script>
@endsection
