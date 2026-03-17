@extends('user.layout.master')
@section('step')
    <button class="btn btn-purple me-2" style="background-color: #393185; color: white;">Step 9 of
        9</button>
@endsection

@section('content')
    <div class="col-lg-9 main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{ route('user.step9.store') }}" enctype="multipart/form-data">
                        @csrf

                        @if (session('success'))
                            <div class="alert alert-warning alert-dismissible fade show position-relative" role="alert"
                                id="successAlert">
                                {{ session('success') }}
                                <button type="button" class="close custom-close" data-dismiss="alert"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show position-relative" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close custom-close" data-dismiss="alert"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="card form-card">
                            <div class="card-body">
                                <div class="step-card">
                                    <div class="card-icon">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </div>
                                    <div>
                                        <h3 class="card-title">3rd Stage Documents</h3>
                                        <p class="card-subtitle">Upload the required documents for the 3rd stage review.</p>
                                    </div>
                                </div>

                                @if ($eligibility['second_date'])
                                    <div class="alert alert-info" style="border-radius: 10px;">
                                        <strong>Second Disbursement Date:</strong>
                                        {{ $eligibility['second_date']->format('d-m-Y') }}
                                    </div>
                                @endif

                                @if ($thirdStageDocument && $thirdStageDocument->status === 'rejected' && $thirdStageDocument->admin_remark)
                                    <div class="alert alert-danger" style="border-radius: 10px;">
                                        <strong>Correction Required:</strong>
                                        {!! $thirdStageDocument->admin_remark !!}
                                    </div>
                                @endif

                                @php
                                    $isLocked = $thirdStageDocument && in_array($thirdStageDocument->status, ['submitted', 'approved']);
                                @endphp

                                @if ($thirdStageDocument && $thirdStageDocument->status === 'submitted')
                                    <div class="alert alert-warning" style="border-radius: 10px;">
                                        Your documents are submitted and pending admin review.
                                    </div>
                                @elseif ($thirdStageDocument && $thirdStageDocument->status === 'approved')
                                    <div class="alert alert-success" style="border-radius: 10px;">
                                        Your 3rd Stage Documents are approved. You can no longer update them.
                                    </div>
                                @elseif ($thirdStageDocument && $thirdStageDocument->status === 'rejected')
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <div class="card border-danger h-100">
                                                <div class="card-body">
                                                    <h5 class="card-title text-danger">Send Back for Correction</h5>
                                                    <p class="card-text mb-2">Your submission needs correction. Please review the remarks below.</p>
                                                    @if ($thirdStageDocument->admin_remark)
                                                        <div class="alert alert-danger mb-0" style="border-radius: 10px;">
                                                            {!! $thirdStageDocument->admin_remark !!}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card border-warning h-100">
                                                <div class="card-body">
                                                    <h5 class="card-title text-warning">Resubmit Documents</h5>
                                                    <p class="card-text">
                                                        Update the required fields/documents and resubmit for review.
                                                    </p>
                                                    <span class="text-muted">Once resubmitted, you will not be able to edit until admin review.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @php
                                    $currentUser = Auth::user();
                                    $financialAssetType = $currentUser?->financial_asset_type;
                                @endphp

                                @if ($financialAssetType === 'domestic')
                                    <div class="mb-3">
                                        <label class="form-label" style="font-weight: 600; color: #393185;">
                                            All Mark Sheets
                                        </label>
                                        <input type="file" class="form-control" name="domestic_marksheets[]" multiple
                                            accept=".pdf,image/*"
                                            {{ $isLocked ? 'disabled' : '' }}>
                                        <small class="text-muted">Allowed formats: PDF, JPG, JPEG, PNG. Max 5MB per file.</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" style="font-weight: 600; color: #393185;">
                                            Paid Fees Receipt
                                        </label>
                                        <input type="file" class="form-control" name="domestic_paid_fees_receipt"
                                            accept=".pdf,image/*"
                                            {{ $isLocked ? 'disabled' : '' }}>
                                        <small class="text-muted">Allowed formats: PDF, JPG, JPEG, PNG. Max 5MB per file.</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" style="font-weight: 600; color: #393185;">
                                            Cancelled Cheque Copy
                                        </label>
                                        <input type="file" class="form-control" name="domestic_cancelled_cheque"
                                            accept=".pdf,image/*"
                                            {{ $isLocked ? 'disabled' : '' }}>
                                        <small class="text-muted">Allowed formats: PDF, JPG, JPEG, PNG. Max 5MB per file.</small>
                                    </div>
                                @elseif ($financialAssetType === 'foreign_finance_assistant')
                                    <div class="mb-3">
                                        <label class="form-label" style="font-weight: 600; color: #393185;">
                                            Applicant New Address (Overseas)
                                        </label>
                                        <textarea class="form-control" name="foreign_address" rows="3"
                                            {{ $isLocked ? 'disabled' : '' }}>{{ old('foreign_address', $thirdStageDocument->foreign_address ?? '') }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" style="font-weight: 600; color: #393185;">
                                            Foreign Contact Number (e.g. USA +1 / UK +44)
                                        </label>
                                        <input type="text" class="form-control" name="foreign_contact_number"
                                            value="{{ old('foreign_contact_number', $thirdStageDocument->foreign_contact_number ?? '') }}"
                                            {{ $isLocked ? 'disabled' : '' }}>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" style="font-weight: 600; color: #393185;">
                                            SSN Number / Country ID Details
                                        </label>
                                        <input type="text" class="form-control" name="foreign_ssn_or_country_id"
                                            value="{{ old('foreign_ssn_or_country_id', $thirdStageDocument->foreign_ssn_or_country_id ?? '') }}"
                                            {{ $isLocked ? 'disabled' : '' }}>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" style="font-weight: 600; color: #393185;">
                                            Immigration Copy (e.g. USA I-94 or Visa copy with your entry stamp on the same page)
                                        </label>
                                        <input type="file" class="form-control" name="foreign_immigration_copy"
                                            accept=".pdf,image/*"
                                            {{ $isLocked ? 'disabled' : '' }}>
                                        <small class="text-muted">Allowed formats: PDF, JPG, JPEG, PNG. Max 5MB per file.</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" style="font-weight: 600; color: #393185;">
                                            Paid Fees Receipt of the University Admitted
                                        </label>
                                        <input type="file" class="form-control" name="foreign_paid_fees_receipt"
                                            accept=".pdf,image/*"
                                            {{ $isLocked ? 'disabled' : '' }}>
                                        <small class="text-muted">Allowed formats: PDF, JPG, JPEG, PNG. Max 5MB per file.</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" style="font-weight: 600; color: #393185;">
                                            Name of Foreign Bank Account
                                        </label>
                                        <input type="text" class="form-control" name="foreign_bank_name"
                                            value="{{ old('foreign_bank_name', $thirdStageDocument->foreign_bank_name ?? '') }}"
                                            {{ $isLocked ? 'disabled' : '' }}>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" style="font-weight: 600; color: #393185;">
                                            Foreign Bank Account Number
                                        </label>
                                        <input type="text" class="form-control" name="foreign_bank_account_number"
                                            value="{{ old('foreign_bank_account_number', $thirdStageDocument->foreign_bank_account_number ?? '') }}"
                                            {{ $isLocked ? 'disabled' : '' }}>
                                    </div>
                                @endif

                                @if ($thirdStageDocument)
                                    <div class="mt-4">
                                        <h5 style="font-weight: 600;">Uploaded Documents</h5>
                                        <ul class="list-group">
                                            @if (!empty($thirdStageDocument->domestic_marksheets))
                                                @foreach ($thirdStageDocument->domestic_marksheets as $doc)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span>{{ basename($doc) }}</span>
                                                        <a href="{{ asset($doc) }}" target="_blank"
                                                            class="btn btn-sm btn-outline-primary">View</a>
                                                    </li>
                                                @endforeach
                                            @endif

                                            @if (!empty($thirdStageDocument->domestic_paid_fees_receipt))
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>{{ basename($thirdStageDocument->domestic_paid_fees_receipt) }}</span>
                                                    <a href="{{ asset($thirdStageDocument->domestic_paid_fees_receipt) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary">View</a>
                                                </li>
                                            @endif

                                            @if (!empty($thirdStageDocument->domestic_cancelled_cheque))
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>{{ basename($thirdStageDocument->domestic_cancelled_cheque) }}</span>
                                                    <a href="{{ asset($thirdStageDocument->domestic_cancelled_cheque) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary">View</a>
                                                </li>
                                            @endif

                                            @if (!empty($thirdStageDocument->foreign_immigration_copy))
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>{{ basename($thirdStageDocument->foreign_immigration_copy) }}</span>
                                                    <a href="{{ asset($thirdStageDocument->foreign_immigration_copy) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary">View</a>
                                                </li>
                                            @endif

                                            @if (!empty($thirdStageDocument->foreign_paid_fees_receipt))
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>{{ basename($thirdStageDocument->foreign_paid_fees_receipt) }}</span>
                                                    <a href="{{ asset($thirdStageDocument->foreign_paid_fees_receipt) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary">View</a>
                                                </li>
                                            @endif

                                            @if (!empty($thirdStageDocument->documents))
                                                @foreach ($thirdStageDocument->documents as $doc)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span>{{ basename($doc) }}</span>
                                                        <a href="{{ asset($doc) }}" target="_blank"
                                                            class="btn btn-sm btn-outline-primary">View</a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                @endif

                                <div class="mt-4">
                                    <button type="submit" class="btn"
                                        style="background-color: #009846; color: white; border-radius: 10px;"
                                        {{ $isLocked ? 'disabled' : '' }}>
                                        <i class="bi bi-check-lg me-1"></i> Submit Documents
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
