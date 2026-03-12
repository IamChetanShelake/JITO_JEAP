@extends('user.layout.master')
@section('step')
    <button class="btn btn-purple me-2" style="background-color: #393185; color: white;">Step 8 of
        9</button>
@endsection
@section('content')
    <!-- Main Content -->
    <div class="col-lg-9 main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{ route('user.step8.store') }}" enctype="multipart/form-data">
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

                        <!-- Step Progress Indicator -->

                        <div class="card form-card">
                            <div class="card-body">
                                <div class="step-card">
                                    <div class="card-icon">
                                        <i class="bi bi-credit-card-2-front"></i>
                                    </div>
                                    <div>
                                        <h3 class="card-title"> PDC/Cheque Details</h3>
                                        <p class="card-subtitle">Upload your first cheque and add all cheque details for the
                                            financial assistance.</p>
                                    </div>
                                    <div class="ms-auto">
                                        @php
                                            $workflow = $user->workflowStatus;
                                            $isPdcApproved = $workflow && $workflow->apex_2_status === 'approved';
                                            $hasPendingRequest =
                                                isset($editBankDetailRequest) &&
                                                $editBankDetailRequest &&
                                                $editBankDetailRequest->status === 'pending';
                                            $hasApprovedRequest =
                                                isset($editBankDetailRequest) &&
                                                $editBankDetailRequest &&
                                                $editBankDetailRequest->status === 'approved';
                                            $isbankdetailsubmitted =
                                                isset($editBankDetailRequest) &&
                                                $editBankDetailRequest &&
                                                $editBankDetailRequest->bank_update_status === 'pending';
                                            $hasRejectedRequest =
                                                isset($editBankDetailRequest) &&
                                                $editBankDetailRequest &&
                                                $editBankDetailRequest->status === 'rejected';
                                        @endphp

                                        {{-- Edit Bank Detail Request Button - Only visible until Apex Stage 2 approves PDC --}}
                                        @if (!$isPdcApproved && !$hasApprovedRequest)
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editBankDetailRequestModal"
                                                {{ $hasPendingRequest ? 'disabled' : '' }}>
                                                <i class="bi bi-pencil-square me-1"></i>
                                                {{ $hasPendingRequest ? 'Request Pending' : 'Edit Bank Detail Request' }}
                                            </button>
                                        @endif

                                        {{-- Edit Bank Details Button - Only visible when request is approved --}}
                                        @if ($hasApprovedRequest && $isbankdetailsubmitted)
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#editBankDetailsModal">
                                                <i class="bi bi-pencil me-1"></i>
                                                Edit Bank Details
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <!-- Rejection Alert - Show if request was rejected -->
                                @if ($hasRejectedRequest && $editBankDetailRequest->admin_remark)
                                    <div class="alert alert-danger mt-3"
                                        style="border: 2px solid #dc3545; border-radius: 10px; background-color: #f8d7da;">
                                        <div class="d-flex align-items-start justify-content-between gap-2">
                                            <i class="fas fa-times-circle me-2"
                                                style="font-size: 1.2rem; color: #dc3545;"></i>
                                            <div style="min-width: 0;">
                                                <h5 class="mb-1" style="color: #721c24; font-weight: 600;">Request
                                                    Rejected</h5>
                                                <p style="margin: 0 0 4px 0; color: #721c24; font-size: 14px;">
                                                    <strong>Admin Remark:</strong>
                                                    {{ trim(preg_replace('/\s+/', ' ', strip_tags($editBankDetailRequest->admin_remark))) }}
                                                </p>
                                                <button type="button" class="btn btn-link p-0 text-danger"
                                                    data-bs-toggle="modal" data-bs-target="#rejectedRemarkModal">
                                                    View More
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="rejectedRemarkModal" tabindex="-1"
                                        aria-labelledby="rejectedRemarkModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="rejectedRemarkModalLabel">Rejection Remarks
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <strong>Admin Remark:</strong>
                                                    {!! $editBankDetailRequest->admin_remark !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Send Back for Correction Notice -->
                                @if (isset($user->workflowStatus) &&
                                        $user->workflowStatus->apex_2_status === 'rejected' &&
                                        $user->workflowStatus->apex_2_reject_remarks)
                                    <div class="alert alert-danger"
                                        style="border: 2px solid #dc3545; border-radius: 10px; background-color: #f8d7da; margin-top: 20px;">
                                        <div class="d-flex align-items-start justify-content-between gap-2">
                                            <i class="fas fa-exclamation-triangle me-2"
                                                style="font-size: 1.2rem; color: #dc3545;"></i>
                                            <div style="min-width: 0;">
                                                <h5 class="mb-1" style="color: #721c24; font-weight: 600;">Application
                                                    Send Back for Correction</h5>
                                                <p
                                                    style="margin: 0 0 4px 0; color: #721c24; font-size: 14px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                    <strong>Remarks:</strong>
                                                    {{ trim(preg_replace('/\s+/', ' ', strip_tags($user->workflowStatus->apex_2_reject_remarks))) }}
                                                </p>
                                                <button type="button" class="btn btn-link p-0 text-danger"
                                                    data-bs-toggle="modal" data-bs-target="#holdRemarkModalStep8">
                                                    View More
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="holdRemarkModalStep8" tabindex="-1"
                                        aria-labelledby="holdRemarkModalStep8Label" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="holdRemarkModalStep8Label">Application Send
                                                        Back
                                                        Remarks</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <strong>Remarks:</strong>
                                                    {!! $user->workflowStatus->apex_2_reject_remarks !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif


                                <!-- Rejection Alert - Show if request was rejected -->
                                @if (isset($workingCommitteeApproval) && $workingCommitteeApproval)
                                    <div class="card mb-4" style="border: 2px solid #009846; border-radius: 15px;">
                                        <div class="card-header bg-success text-white"
                                            style="border-radius: 13px 13px 0 0; background-color: #009846 !important;">
                                            <h5 class="mb-0">Approval Details</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <!-- Approved Financial Assistance Amount -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" style="font-weight: 600; color: #393185;">
                                                        Approved Financial Assistance Amount
                                                    </label>
                                                    <div class="form-control"
                                                        style="background-color: #f8f9fa; border: 2px solid #393185; border-radius: 10px;">
                                                        @if (isset($workingCommitteeApproval->approval_financial_assistance_amount) &&
                                                                $workingCommitteeApproval->approval_financial_assistance_amount)
                                                            <strong>₹{{ number_format($workingCommitteeApproval->approval_financial_assistance_amount, 2) }}</strong>
                                                        @else
                                                            <span class="text-muted">Not Available</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Repayment Type -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" style="font-weight: 600; color: #393185;">
                                                        Repayment Type
                                                    </label>
                                                    <div class="form-control"
                                                        style="background-color: #f8f9fa; border: 2px solid #393185; border-radius: 10px;">
                                                        @if (isset($workingCommitteeApproval->repayment_type) && $workingCommitteeApproval->repayment_type)
                                                            <strong>{{ ucfirst($workingCommitteeApproval->repayment_type) }}</strong>
                                                        @else
                                                            <span class="text-muted">Not Available</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- No. of Cheques to be Collected -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" style="font-weight: 600; color: #393185;">
                                                        No. of Cheques to be Collected
                                                    </label>
                                                    <div class="form-control"
                                                        style="background-color: #f8f9fa; border: 2px solid #393185; border-radius: 10px;">
                                                        @if (isset($workingCommitteeApproval->no_of_cheques_to_be_collected) &&
                                                                $workingCommitteeApproval->no_of_cheques_to_be_collected)
                                                            <strong>{{ $workingCommitteeApproval->no_of_cheques_to_be_collected }}</strong>
                                                        @else
                                                            <span class="text-muted">Not Available</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Repayment Starting From -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" style="font-weight: 600; color: #393185;">
                                                        Repayment Starting From
                                                    </label>
                                                    <div class="form-control"
                                                        style="background-color: #f8f9fa; border: 2px solid #393185; border-radius: 10px;">
                                                        @if (isset($workingCommitteeApproval->repayment_starting_from) && $workingCommitteeApproval->repayment_starting_from)
                                                            <strong>{{ \Carbon\Carbon::parse($workingCommitteeApproval->repayment_starting_from)->format('d-m-Y') }}</strong>
                                                        @else
                                                            <span class="text-muted">Not Available</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Installment Details Table -->
                                            {{--  @if (isset($workingCommitteeApproval->installment_amount) || isset($workingCommitteeApproval->no_of_months))
                                        <div class="mt-3">
                                            <label class="form-label" style="font-weight: 600; color: #393185;">
                                                Installment Details
                                            </label>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped" style="border: 2px solid #393185;">
                                                    <thead class="table-dark" style="background-color: #393185 !important;">
                                                        <tr>
                                                            <th style="background-color: #393185; color: white; font-weight: 700;">Installment No.</th>
                                                            <th style="background-color: #393185; color: white; font-weight: 700;">Amount (₹)</th>
                                                            <th style="background-color: #393185; color: white; font-weight: 700;">Due Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $installmentAmounts = is_array($workingCommitteeApproval->installment_amount)
                                                                ? $workingCommitteeApproval->installment_amount
                                                                : json_decode($workingCommitteeApproval->installment_amount, true) ?? [];

                                                            $noOfMonths = is_array($workingCommitteeApproval->no_of_months)
                                                                ? $workingCommitteeApproval->no_of_months
                                                                : json_decode($workingCommitteeApproval->no_of_months, true) ?? [];

                                                            $repaymentStart = isset($workingCommitteeApproval->repayment_starting_from)
                                                                ? \Carbon\Carbon::parse($workingCommitteeApproval->repayment_starting_from)
                                                                : null;
                                                        @endphp

                                                        @if (count($installmentAmounts) > 0)
                                                            @foreach ($installmentAmounts as $index => $amount)
                                                                <tr>
                                                                    <td>Installment {{ $index + 1 }}</td>
                                                                    <td>₹{{ number_format($amount, 2) }}</td>
                                                                    <td>
                                                                        @if ($repaymentStart)
                                                                            {{ $repaymentStart->copy()->addMonths($index)->format('d-m-Y') }}
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="3" class="text-center text-muted">No installment details available</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @endif  --}}

                                            <!-- Installment Details Table - Attractive UI -->
                                            @if (
                                                $user->workingCommitteeApproval->installment_amount &&
                                                    is_array($user->workingCommitteeApproval->installment_amount))
                                                <div class="mt-4">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="icon-circle"
                                                            style="width: 40px; height: 40px; background: linear-gradient(135deg, #393185 0%, #5a5aad 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px; box-shadow: 0 4px 10px rgba(57, 49, 133, 0.3);">
                                                            <i class="bi bi-calendar-check"
                                                                style="color: white; font-size: 18px;"></i>
                                                        </div>
                                                        <h5 class="mb-0" style="font-weight: 600; color: #393185;">
                                                            Installment Details</h5>
                                                    </div>

                                                    <div class="installment-card"
                                                        style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px; padding: 20px; border: 1px solid #dee2e6; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                                                        <div class="table-responsive">
                                                            <table class="table mb-0" style="background: transparent;">
                                                                <thead>
                                                                    <tr>
                                                                        {{--  <th
                                                                            style="background-color: #393185; color: white; font-weight: 600; padding: 12px 15px; border-radius: 8px 0 0 0;">
                                                                        #</th> --}}
                                                                        {{--  <th style="background-color: #393185; color: white; font-weight: 600; padding: 12px 15px;">
                                                                            <i class="bi bi-hash me-1"></i>Sr No.
                                                                        </th>  --}}
                                                                        <th
                                                                            style="background-color: #393185; color: white; font-weight: 600; padding: 12px 15px;">
                                                                            <i
                                                                                class="bi bi-currency-rupee me-1"></i>Installment
                                                                            Amount
                                                                        </th>
                                                                        <th
                                                                            style="background-color: #393185; color: white; font-weight: 600; padding: 12px 15px;">
                                                                            <i class="bi bi-calendar-range me-1"></i>No. of
                                                                            Cheques
                                                                        </th>
                                                                        <th
                                                                            style="background-color: #393185; color: white; font-weight: 600; padding: 12px 15px; border-radius: 0 8px 0 0;">
                                                                            <i class="bi bi-calculator me-1"></i>Total
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($user->workingCommitteeApproval->installment_amount as $index => $installmentAmount)
                                                                        <tr style="transition: all 0.3s ease;">
                                                                            {{--  <td
                                                                                style="padding: 12px 15px; border-bottom: 1px solid #dee2e6; font-weight: 600; color: #393185;">
                                                                                <span class="installment-badge"
                                                                                    style="background: linear-gradient(135deg, #393185 0%, #5a5aad 100%); color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px;">
                                                                                    {{ $index + 1 }}
                                                                                </span>
                                                                            </td>  --}}
                                                                            {{--  <td
                                                                                style="padding: 12px 15px; border-bottom: 1px solid #dee2e6; font-weight: 500; color: #495057;">
                                                                                Installment {{ $index + 1 }}
                                                                            </td>  --}}
                                                                            <td
                                                                                style="padding: 12px 15px; border-bottom: 1px solid #dee2e6; font-weight: 600; color: #009846;">
                                                                                <i class="bi bi-currency-rupee"
                                                                                    style="font-size: 12px;"></i>
                                                                                {{ number_format($installmentAmount ?? 0, 2) }}
                                                                            </td>
                                                                            <td
                                                                                style="padding: 12px 15px; border-bottom: 1px solid #dee2e6; font-weight: 500; color: #495057;">
                                                                                <span class="months-badge"
                                                                                    style="background: linear-gradient(135deg, #FBBA00 0%, #FFD700 100%); color: #333; padding: 4px 12px; border-radius: 20px; font-size: 15px; font-weight: 600;">
                                                                                    {{ $user->workingCommitteeApproval->no_of_months[$index] ?? 'N/A' }}

                                                                                </span>
                                                                            </td>
                                                                            <td
                                                                                style="padding: 12px 15px; border-bottom: 1px solid #dee2e6; font-weight: 600; color: #393185;">
                                                                                <i class="bi bi-currency-rupee"
                                                                                    style="font-size: 12px;"></i>
                                                                                {{ number_format($user->workingCommitteeApproval->total[$index] ?? 0, 2) }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    {{--
                                                    <div class="mt-3 d-flex justify-content-between align-items-center"
                                                        style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 15px 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                                                        <div class="text-center" style="flex: 1;">
                                                            <small class="text-muted d-block">Total Installments</small>
                                                            <p class="mb-0"
                                                                style="font-weight: 700; color: #393185; font-size: 16px;">
                                                                {{ count($user->workingCommitteeApproval->installment_amount) }}
                                                            </p>
                                                        </div>
                                                        <div class="vr"
                                                            style="height: 40px; width: 2px; background: #dee2e6;"></div>
                                                        <div class="text-center" style="flex: 1;">
                                                            <small class="text-muted d-block">Per Installment</small>
                                                            <p class="mb-0"
                                                                style="font-weight: 700; color: #009846; font-size: 16px;">
                                                                ₹{{ number_format(array_sum($user->workingCommitteeApproval->installment_amount) / count($user->workingCommitteeApproval->installment_amount), 2) }}
                                                            </p>
                                                        </div>
                                                        <div class="vr"
                                                            style="height: 40px; width: 2px; background: #dee2e6;"></div>
                                                        <div class="text-center" style="flex: 1;">
                                                            <small class="text-muted d-block">Total Amount</small>
                                                            <p class="mb-0"
                                                                style="font-weight: 700; color: #393185; font-size: 16px;">
                                                                ₹{{ number_format(array_sum($user->workingCommitteeApproval->installment_amount), 2) }}
                                                            </p>
                                                        </div>
                                                    </div>  --}}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Bank Details Check Modal - Show if bank_name is OTHER -->
                                @if (isset($fundingDetail) && $fundingDetail && strtoupper($fundingDetail->bank_name) === 'OTHER')
                                    <div class="modal fade" id="bankDetailsModal" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="bankDetailsModalLabel"
                                        aria-hidden="true" style="pointer-events: none;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content"
                                                style="border-radius: 15px; border: 3px solid #dc3545;">
                                                <div class="modal-header bg-danger text-white"
                                                    style="border-radius: 12px 12px 0 0;">
                                                    <h5 class="modal-title" id="bankDetailsModalLabel">
                                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                                        Action Required
                                                    </h5>
                                                    <!-- Close button removed - modal cannot be closed -->
                                                </div>
                                                <div class="modal-body text-center py-4">
                                                    <div class="mb-3">
                                                        <i class="bi bi-bank"
                                                            style="font-size: 4rem; color: #dc3545;"></i>
                                                    </div>
                                                    <h4 class="text-danger mb-3">Please Update Bank Details</h4>
                                                    <p class="text-dark fs-5">
                                                        Your bank name is marked as "OTHER". Please update the bank details
                                                        according to JITO JEAP registered bank.
                                                    </p>
                                                </div>
                                                <div class="modal-footer justify-content-center"
                                                    style="border-top: none;">
                                                    <a href="{{ route('user.step4') }}"
                                                        class="btn btn-danger btn-lg px-5"
                                                        style="border-radius: 10px; font-weight: 600;">
                                                        <i class="bi bi-arrow-right-circle me-2"></i>
                                                        Go to Step 4
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Important Note Section -->
                                <div class="alert alert-info"
                                    style="border: 2px solid #FBBA00; border-radius: 10px; background-color: #FEF6E0; margin-top: 20px;">
                                    <p class="mb-0" style="color: #E31E24; font-size: 15px;font-weight: 500;">
                                        <strong>NOTE:</strong> Please fill in the Post Dated Cheque (PDC) details below.
                                        Once completed, kindly submit the form. If the required details are not provided,
                                        there may be a delay of 10 to 15 days in the disbursement process.
                                </div>

                                <div style="margin-top: 30px; padding: 0 20px;">
                                    <!-- First Cheque Image Section -->
                                    <div class="card mb-4" style="border: 2px solid #393185; border-radius: 15px;">
                                        <div class="card-header bg-primary text-white"
                                            style="border-radius: 13px 13px 0 0; background-color: #393185 !important;">
                                            <h5 class="mb-0">First Cheque Image (Mandatory)</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class=" col-6  mb-3">
                                                    <label for="first_cheque_image" class="form-label"
                                                        style="font-weight: 600; color: #393185;">
                                                        @if (isset($pdcDetail->first_cheque_image) && $pdcDetail->first_cheque_image)
                                                            Replace First Cheque Image (Optional)
                                                        @else
                                                            Upload First Cheque Image *
                                                        @endif
                                                    </label>
                                                    <input type="file"
                                                        class="form-control @error('first_cheque_image') is-invalid @enderror"
                                                        id="first_cheque_image" name="first_cheque_image"
                                                        accept="image/*,.pdf"
                                                        @if (!isset($pdcDetail->first_cheque_image) || !$pdcDetail->first_cheque_image) required @endif
                                                        style="border: 2px solid #393185; border-radius: 10px;">
                                                    @error('first_cheque_image')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                    <small class="text-muted">
                                                        @if (isset($pdcDetail->first_cheque_image) && $pdcDetail->first_cheque_image)
                                                            Upload a new image to replace the existing one, or leave empty
                                                            to
                                                            keep current image.
                                                        @else
                                                            Upload a clear image of the first cheque (JPEG, PNG, JPG) or PDF
                                                            file.
                                                        @endif
                                                    </small>
                                                </div>

                                                @if (isset($pdcDetail->first_cheque_image) && $pdcDetail->first_cheque_image)
                                                    <div class=" col-6 mt-3">
                                                        <label class="form-label"
                                                            style="font-weight: 600; color: #393185;">Current Uploaded
                                                            File:</label>
                                                        <br>
                                                        @php
                                                            $fileExtension = strtolower(
                                                                pathinfo(
                                                                    $pdcDetail->first_cheque_image,
                                                                    PATHINFO_EXTENSION,
                                                                ),
                                                            );
                                                        @endphp
                                                        @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                            <img src="{{ asset($pdcDetail->first_cheque_image) }}"
                                                                alt="First Cheque"
                                                                style="max-width: 300px; max-height: 200px; border-radius: 10px; border: 2px solid #393185;">
                                                        @elseif($fileExtension == 'pdf')
                                                            <a href="{{ asset($pdcDetail->first_cheque_image) }}"
                                                                target="_blank" class="btn btn-primary"
                                                                style="background-color: #393185; border: 2px solid #393185; border-radius: 10px; font-weight: 600;">
                                                                <i class="bi bi-file-earmark-pdf"></i> View PDF
                                                            </a>
                                                        @else
                                                            <span class="text-muted">Unsupported file format</span>
                                                        @endif


                                                    </div>
                                                @endif
                                            </div>
                                        </div>


                                        <div class="alert alert-info "
                                            style="border: 2px solid #FBBA00; border-radius: 10px; background-color: #FEF6E0; margin-top: 20px; margin:0 20px 10px;">
                                            <p class="mb-0" style="color: #E31E24; font-size: 15px;font-weight: 500;">
                                                (Please upload the same PDC scanned 1st cheque copy here which
                                                you are submitting to JEAP)
                                        </div>

                                    </div>

                                    <!-- Cheque Details Table -->
                                    {{-- <div class="card mb-4" style="border: 2px solid #393185; border-radius: 15px;"> --}}
                                    <hr>

                                    <!-- Amount Mismatch Error Message -->
                                    @if (isset($user->workingCommitteeApproval) && $user->workingCommitteeApproval->approval_financial_assistance_amount)
                                        <div id="amountMismatchAlert" class="alert alert-danger d-none"
                                            style="border: 2px solid #dc3545; border-radius: 10px; background-color: #f8d7da; margin-top: 20px;">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-exclamation-circle me-2"
                                                    style="font-size: 1.2rem; color: #dc3545;"></i>
                                                <div>
                                                    <h5 class="mb-1" style="color: #721c24; font-weight: 600;">
                                                        Validation Error</h5>
                                                    <p class="mb-0" style="color: #721c24; font-size: 14px;">
                                                        Total cheque amount must match the approved financial assistance
                                                        amount exactly.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="   d-flex justify-content-between align-items-center"
                                        style="border-radius: 13px 13px 0 0; background-color: none !important; color:#393185">
                                        <h4 class="mb-0" style="font-weight: 600;">Cheque Details Table</h4>
                                        <button type="button" class="btn btn-sm" id="addRowBtn"
                                            style="border-radius: 8px;background:#393185; color:white; font-weight: 600;">
                                            + Add Row
                                        </button>
                                    </div>
                                    {{-- <div class="card-body"> --}}
                                    <div class="table-responsive mt-4"
                                        style="max-height: 500px; overflow-y: auto; overflow-x: auto;">
                                        <table class="table table-bordered table-striped" id="chequeTable"
                                            style="min-width: 1200px;">
                                            <thead class="table-dark"
                                                style="background-color: #393185 !important; position: sticky; top: 0; z-index: 10;">
                                                <tr>
                                                    <th scope="col"
                                                        style="width: 5%; background-color: #393185; color: white; font-weight: 700;">
                                                        Sr. No</th>
                                                    <th scope="col"
                                                        style="width: 5%; background-color: #393185; color: white; font-weight: 700;">
                                                        Student Name</th>
                                                    <th scope="col"
                                                        style="width: 20%; background-color: #393185; color: white; font-weight: 700;">
                                                        If Parents Jnt A/C Name</th>
                                                    <th scope="col"
                                                        style="width: 10%; background-color: #393185; color: white; font-weight: 700;">
                                                        Repayment Date</th>
                                                    <th scope="col"
                                                        style="width: 15%; background-color: #393185; color: white; font-weight: 700;">
                                                        Amount (₹)</th>
                                                    <th scope="col"
                                                        style="width: 20%; background-color: #393185; color: white; font-weight: 700;">
                                                        Bank Name</th>
                                                    <th scope="col"
                                                        style="width: 20%; background-color: #393185; color: white; font-weight: 700;">
                                                        Bank IFSC Code</th>
                                                    <th scope="col"
                                                        style="width: 25%; background-color: #393185; color: white; font-weight: 700;">
                                                        Account Number</th>
                                                    <th scope="col"
                                                        style="width: 12%; background-color: #393185; color: white; font-weight: 700;">
                                                        Cheque Number</th>
                                                    <th scope="col"
                                                        style="width: 30%; background-color: #393185; color: white; font-weight: 700;">
                                                        Application NO.</th>
                                                    <th scope="col"
                                                        style="width: 10%; background-color: #393185; color: white; font-weight: 700;">
                                                        Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="chequeRows">
                                                <!-- Cheque rows will be added here dynamically -->
                                            </tbody>
                                        </table>
                                    </div>

                                    @error('cheque_details')
                                        <div class="text-danger mb-3">{{ $message }}</div>
                                    @enderror
                                    @error('cheque_details.*')
                                        <div class="text-danger mb-3">{{ $message }}</div>
                                    @enderror
                                    {{-- </div> --}}
                                    {{-- </div> --}}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4 mb-4">
                            <a href="{{ route('user.step7') }}" class="btn"
                                style="background: #988DFF1F; color: #393185; border: 2px solid #393185; border-radius: 10px; font-weight: 600;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    stroke="#393185" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M15 18l-6-6 6-6" />
                                </svg>
                                Previous
                            </a>
                            <button type="submit" class="btn"
                                style="background: #F0FDF4; color: #009846; border: 2px solid #009846; border-radius: 10px; font-weight: 600;"
                                id="submitBtn">
                                <i class="bi bi-check-lg" style="color: green; font-size: 24px;"></i>
                                Save PDC Details
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if bank_name is "OTHER" and show modal
            const isBankOther =
                {{ isset($fundingDetail) && $fundingDetail && strtoupper($fundingDetail->bank_name) === 'OTHER' ? 'true' : 'false' }};

            if (isBankOther) {
                // Show the modal automatically
                const bankModal = new bootstrap.Modal(document.getElementById('bankDetailsModal'));
                bankModal.show();
            }

            // Get funding details for pre-populating bank fields
            const fundingBankName = "{{ $fundingDetail->bank_name ?? '' }}";
            const fundingIfsc = "{{ $fundingDetail->ifsc_code ?? '' }}";
            const fundingAccountNumber = "{{ $fundingDetail->account_number ?? '' }}";

            const chequeRowsContainer = document.getElementById('chequeRows');
            const addRowBtn = document.getElementById('addRowBtn');
            const totalCheques = {{ 1 }};

            // Get approval amount from PHP
            const approvalAmount =
                {{ $user->workingCommitteeApproval->approval_financial_assistance_amount ?? 0 }};
            const amountMismatchAlert = document.getElementById('amountMismatchAlert');
            const currentTotalSpan = document.getElementById('currentTotal');
            const differenceAmountSpan = document.getElementById('differenceAmount');

            // Get existing cheque details if available
            let existingCheques = [];
            @if (isset($pdcDetail->cheque_details) && $pdcDetail->cheque_details)
                existingCheques = {!! $pdcDetail->cheque_details !!};
            @endif

            // Function to format number as currency
            function formatCurrency(amount) {
                return '₹' + Number(amount).toLocaleString('en-IN', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            // Function to calculate total and update alert (only for submission)
            function updateAmountAlert() {
                // Don't show alert during real-time input
                // Only show when form is submitted
                return;
            }

            // Function to create a cheque row
            function createChequeRow(index, data = null) {
                const row = document.createElement('tr');
                row.className = 'cheque-row';
                row.dataset.rowIndex = index;

                const studentName = "{{ $user->name ?? '' }}";
                const applicationNo = "{{ $user->application_no ?? '' }}";
                const chequeDate = data ? data.cheque_date : '';
                const amount = data ? data.amount : '';
                // Pre-populate from funding details if no existing data and bank is not "OTHER"
                const bankName = data ? data.bank_name : (isBankOther ? '' : fundingBankName);
                const ifsc = data ? data.ifsc : (isBankOther ? '' : fundingIfsc);
                const accountNumber = data ? data.account_number : (isBankOther ? '' : fundingAccountNumber);
                const chequeNumber = data ? data.cheque_number : '';
                const parentsJntAcName = data ? data.parents_jnt_ac_name : '';

                row.innerHTML = `
                    <td class="align-middle">
                        <span class="sr-no">${index + 1}</span>
                    </td>
                    <td class="align-middle">
                        <span class="student-name">${studentName}</span>
                    </td>
                    <td>
                        <input type="text" class="form-control"
                               name="cheque_details[${index}][parents_jnt_ac_name]" value="${parentsJntAcName}"
                               placeholder="${parentsJntAcName ? '' : 'Enter parents joint account name (Optional)'}"
                               style="border: 2px solid #393185; border-radius: 10px;width:220px !important;">
                    </td>
                    <td>
                        <input type="date" class="form-control"
                               name="cheque_details[${index}][cheque_date]" value="${chequeDate}" required
                               min="{{ date('Y-m-d') }}"
                               style="border: 2px solid #393185; border-radius: 10px; background-color: white;width:160px !important;">
                    </td>
                    <td>
                        <input type="number" class="form-control"
                               name="cheque_details[${index}][amount]" value="${amount}" step="0.01" min="0" required
                               style="border: 2px solid #393185; border-radius: 10px;width:120px !important;">
                    </td>
                    <td>
                        <input type="text" class="form-control"
                               name="cheque_details[${index}][bank_name]" value="${bankName}" placeholder="Enter bank name" required
                               style="border: 2px solid #393185; border-radius: 10px;width:180px !important;">
                    </td>
                    <td>
                        <input type="text" class="form-control"
                               name="cheque_details[${index}][ifsc]" value="${ifsc}" placeholder="e.g., SBIN0001234" required
                               style="border: 2px solid #393185; border-radius: 10px;width:150px !important;">
                    </td>
                    <td>
                        <input type="text" class="form-control"
                               name="cheque_details[${index}][account_number]" value="${accountNumber}" placeholder="Enter account number" required
                               style="border: 2px solid #393185; border-radius: 10px;width:170px !important;">
                    </td>
                    <td>
                        <input type="text" class="form-control"
                               name="cheque_details[${index}][cheque_number]" value="${chequeNumber}" placeholder="Enter cheque number" required
                               style="border: 2px solid #393185; border-radius: 10px;width:100px !important;">
                    </td>
                    <td>
                        <input type="text" class="form-control"
                               name="cheque_details[${index}][application_no]" value="${applicationNo}" readonly
                               style="border: 2px solid #393185; border-radius: 10px;width:200px !important; background-color: #f8f9fa;">
                    </td>
                    <td class="text-center">
                        ${index > 0 ? `
                                                                                                                <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)"
                                                                                                                    style="border-radius: 8px; font-weight: 600;">
                                                                                                                    Remove
                                                                                                                </button>
                                                                                                            ` : `
                                                                                                                <span class="text-muted"></span>
                                                                                                            `}
                    </td>
                `;

                // Add event listener for amount input to update alert
                const amountInput = row.querySelector('input[name*="[amount]"]');
                if (amountInput) {
                    amountInput.addEventListener('input', updateAmountAlert);
                }

                return row;
            }

            // Initialize with existing rows or default 11 rows
            if (existingCheques.length > 0) {
                existingCheques.forEach((cheque, index) => {
                    chequeRowsContainer.appendChild(createChequeRow(index, cheque));
                });
            } else {
                // Create default 11 rows
                for (let i = 0; i < totalCheques; i++) {
                    chequeRowsContainer.appendChild(createChequeRow(i));
                }
            }

            // Add row button functionality
            addRowBtn.addEventListener('click', function() {
                const currentRows = chequeRowsContainer.querySelectorAll('.cheque-row');
                const newIndex = currentRows.length;
                chequeRowsContainer.appendChild(createChequeRow(newIndex));
            });

            // Make removeRow globally accessible
            window.removeRow = function(button) {
                const row = button.closest('.cheque-row');
                row.remove();
                // Re-index remaining rows
                reindexRows();
                // Update amount alert after removing row
                updateAmountAlert();
            };

            function reindexRows() {
                const rows = chequeRowsContainer.querySelectorAll('.cheque-row');
                rows.forEach((row, index) => {
                    row.dataset.rowIndex = index;
                    row.querySelectorAll('input').forEach(input => {
                        const name = input.name;
                        const newName = name.replace(/\[\d+\]/, `[${index}]`);
                        input.name = newName;
                    });
                    // Update Sr. No
                    const srNoSpan = row.querySelector('.sr-no');
                    if (srNoSpan) {
                        srNoSpan.textContent = index + 1;
                    }
                });
            }

            // Initial calculation
            updateAmountAlert();

            // Form validation before submission
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('submitBtn');

            // Function to validate amounts before submission
            function validateAmounts() {
                // Always validate if approval amount exists
                if (!approvalAmount || approvalAmount <= 0) {
                    return true; // No validation needed if no approval amount
                }

                const rows = chequeRowsContainer.querySelectorAll('.cheque-row');
                let total = 0;

                rows.forEach(row => {
                    const amountInput = row.querySelector('input[name*="[amount]"]');
                    if (amountInput && amountInput.value) {
                        total += parseFloat(amountInput.value) || 0;
                    }
                });

                const isMatch = Math.abs(total - approvalAmount) < 0.01;
                return isMatch;
            }

            // Form submission validation
            form.addEventListener('submit', function(e) {
                const isValid = validateAmounts();

                if (!isValid) {
                    e.preventDefault(); // CRITICAL: Prevent form submission

                    // Show error message with user-friendly text
                    const requiredAmount = formatCurrency(approvalAmount);
                    const currentTotal = formatCurrency(total);

                    // Update alert content with user-friendly message
                    amountMismatchAlert.classList.remove('d-none');
                    currentTotalSpan.textContent = currentTotal;
                    differenceAmountSpan.textContent = formatCurrency(Math.abs(total - approvalAmount));

                    // Change alert to show error message
                    amountMismatchAlert.innerHTML = `
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2" style="font-size: 1.2rem; color: #FBBA00;"></i>
                            <div>
                                <h5 class="mb-1" style="color: #E31E24; font-weight: 600;">Amount Mismatch - Cannot Submit</h5>
                                <p class="mb-0" style="color: #E31E24; font-size: 14px;">
                                    <strong>Approved Amount:</strong> ${requiredAmount}<br>
                                    <strong>Current Total:</strong> ${currentTotal}<br>
                                    <strong>Difference:</strong> ${formatCurrency(Math.abs(total - approvalAmount))}<br><br>
                                    <strong>Form submission is blocked until amounts match exactly.</strong>
                                </p>
                            </div>
                        </div>
                    `;

                    // Scroll to alert
                    amountMismatchAlert.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                    return false;
                }
            });

            // Also validate on button click
            submitBtn.addEventListener('click', function(e) {
                const isValid = validateAmounts();

                if (!isValid) {
                    e.preventDefault(); // Prevent submission

                    // Show error message
                    const rows = chequeRowsContainer.querySelectorAll('.cheque-row');
                    let total = 0;
                    rows.forEach(row => {
                        const amountInput = row.querySelector('input[name*="[amount]"]');
                        if (amountInput && amountInput.value) {
                            total += parseFloat(amountInput.value) || 0;
                        }
                    });

                    const requiredAmount = formatCurrency(approvalAmount);
                    const currentTotal = formatCurrency(total);

                    amountMismatchAlert.classList.remove('d-none');
                    currentTotalSpan.textContent = currentTotal;
                    differenceAmountSpan.textContent = formatCurrency(Math.abs(total - approvalAmount));

                    amountMismatchAlert.innerHTML = `
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2" style="font-size: 1.2rem; color: #FBBA00;"></i>
                            <div>
                                <h5 class="mb-1" style="color: #E31E24; font-weight: 600;">Amount Mismatch - Cannot Submit</h5>
                                <p class="mb-0" style="color: #E31E24; font-size: 14px;">
                                    <strong>Approved Amount:</strong> ${requiredAmount}<br>
                                    <strong>Current Total:</strong> ${currentTotal}<br>
                                    <strong>Difference:</strong> ${formatCurrency(Math.abs(total - approvalAmount))}<br><br>
                                    <strong>Form submission is blocked until amounts match exactly.</strong>
                                </p>
                            </div>
                        </div>
                    `;

                    amountMismatchAlert.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            });
        });
    </script>

    <!-- Edit Bank Detail Request Modal -->
    <div class="modal fade" id="editBankDetailRequestModal" tabindex="-1"
        aria-labelledby="editBankDetailRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header" style="background-color: #393185; color: white; border-radius: 13px 13px 0 0;">
                    <h5 class="modal-title" id="editBankDetailRequestModalLabel">
                        <i class="bi bi-pencil-square me-2"></i>
                        Edit Bank Detail Request
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editBankDetailRequestForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="reason" class="form-label" style="font-weight: 600; color: #393185;">
                                Reason <span style="color: red;">*</span>
                            </label>
                            <textarea class="form-control" id="reason" name="reason" rows="4"
                                placeholder="Please provide a reason for editing bank details..." required
                                style="border: 2px solid #393185; border-radius: 10px;"></textarea>
                            <small class="text-muted">Explain why you need to edit your bank details.</small>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: none;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            style="border-radius: 10px;">Cancel</button>
                        <button type="submit" class="btn"
                            style="background-color: #393185; color: white; border-radius: 10px;">
                            <i class="bi bi-send me-1"></i> Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Bank Details Modal (for approved request) -->
    <div class="modal fade" id="editBankDetailsModal" tabindex="-1" aria-labelledby="editBankDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header" style="background-color: #009846; color: white; border-radius: 13px 13px 0 0;">
                    <h5 class="modal-title" id="editBankDetailsModalLabel">
                        <i class="bi bi-bank me-2"></i>
                        Edit Bank Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editBankDetailsForm" novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div id="editBankValidationMessage" class="mt-2"></div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_bank_name" class="form-label" style="font-weight: 600; color: #393185;">
                                    Bank Name <span style="color: red;">*</span>
                                </label>
                                <select class="form-control" name="bank_name" id="edit_bank_name" required
                                    style="border: 2px solid #393185; border-radius: 10px;">
                                    <option value="" hidden>Select Bank</option>
                                    @foreach ($banks as $bank)
                                        @if (strtoupper($bank->name) !== 'OTHER')
                                            <option value="{{ $bank->name }}"
                                                data-ifsc="{{ strtoupper(substr($bank->ifsc_code, 0, 4)) }}">
                                                {{ $bank->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_account_holder_name" class="form-label"
                                    style="font-weight: 600; color: #393185;">
                                    Account Holder Name <span style="color: red;">*</span>
                                </label>
                                <input type="text" class="form-control" name="account_holder_name"
                                    id="edit_account_holder_name" value="" readonly required
                                    style="border: 2px solid #393185; border-radius: 10px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_ifsc_code" class="form-label" style="font-weight: 600; color: #393185;">
                                    IFSC Code <span style="color: red;">*</span>
                                </label>
                                <input type="text" class="form-control" name="ifsc_code" id="edit_ifsc_code"
                                    value="" required style="border: 2px solid #393185; border-radius: 10px;">
                                {{--  <div id="editBankValidationMessage" class="mt-2"></div>  --}}
                            </div>
                            {{--  <div class="col-md-6 mb-3">
                                <label for="edit_account_number" class="form-label"
                                    style="font-weight: 600; color: #393185;">
                                    Account Number <span style="color: red;">*</span>
                                </label>
                                <input type="text" class="form-control" name="account_number"
                                    id="edit_account_number" value="{{ $fundingDetail->account_number ?? '' }}" required
                                    style="border: 2px solid #393185; border-radius: 10px;">
                            </div>  --}}
                            <div class="col-md-6 mb-3">
                                <label for="edit_branch_name" class="form-label"
                                    style="font-weight: 600; color: #393185;">
                                    Branch Name <span style="color: red;">*</span>
                                </label>
                                <input type="text" class="form-control" name="branch_name" id="edit_branch_name"
                                    value="" readonly required
                                    style="border: 2px solid #393185; border-radius: 10px;">
                            </div>
                        </div>
                        <div class="row">
                            {{--  <div class="col-md-6 mb-3">
                                <label for="edit_ifsc_code" class="form-label" style="font-weight: 600; color: #393185;">
                                    IFSC Code <span style="color: red;">*</span>
                                </label>
                                <input type="text" class="form-control" name="ifsc_code" id="edit_ifsc_code"
                                    value="{{ $fundingDetail->ifsc_code ?? '' }}" required
                                    style="border: 2px solid #393185; border-radius: 10px;">
                                <div id="editBankValidationMessage" class="mt-2"></div>
                            </div>  --}}
                            <div class="col-md-6 mb-3">
                                <label for="edit_account_number" class="form-label"
                                    style="font-weight: 600; color: #393185;">
                                    Account Number <span style="color: red;">*</span>
                                </label>
                                <input type="text" class="form-control" name="account_number"
                                    id="edit_account_number" value="" readonly required
                                    style="border: 2px solid #393185; border-radius: 10px;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_bank_address" class="form-label"
                                    style="font-weight: 600; color: #393185;">
                                    Bank Address <span style="color: red;">*</span>
                                </label>
                                <textarea class="form-control" name="bank_address" id="edit_bank_address" rows="2" readonly required
                                    style="border: 2px solid #393185; border-radius: 10px;"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: none;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            style="border-radius: 10px;">Cancel</button>
                        <button type="submit" id="editBankDetailsSubmit" class="btn"
                            style="background-color: #009846; color: white; border-radius: 10px;">
                            <i class="bi bi-check-lg me-1"></i> Update Bank Details
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function hideModalById(modalId) {
            const modalElement = document.getElementById(modalId);
            if (!modalElement) return;

            // Bootstrap 5
            if (window.bootstrap && bootstrap.Modal) {
                let instance = null;
                if (typeof bootstrap.Modal.getInstance === 'function') {
                    instance = bootstrap.Modal.getInstance(modalElement);
                }
                if (!instance) {
                    instance = new bootstrap.Modal(modalElement);
                }
                if (instance && typeof instance.hide === 'function') {
                    instance.hide();
                }
                return;
            }

            // Bootstrap 4 / jQuery fallback
            if (typeof $ !== 'undefined') {
                $('#' + modalId).modal('hide');
            }
        }

        function forceCloseModalById(modalId) {
            hideModalById(modalId);

            const modalElement = document.getElementById(modalId);
            if (!modalElement) return;

            modalElement.classList.remove('show');
            modalElement.setAttribute('aria-hidden', 'true');
            modalElement.style.display = 'none';

            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => backdrop.remove());
            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('padding-right');
        }

        // Edit Bank Detail Request Form Submit
        document.getElementById('editBankDetailRequestForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML =
                '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Submitting...';

            fetch('{{ route('user.submit.edit.bank.detail.request') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    return response.json().catch(err => {
                        // If JSON parsing fails, check response status
                        if (response.ok) {
                            return {
                                success: true,
                                message: 'Request submitted successfully!'
                            };
                        }
                        throw err;
                    });
                })
                .then(data => {
                    // Close modal first
                    forceCloseModalById('editBankDetailRequestModal');

                    if (data.success) {
                        // Show success message
                        alert(data.message);
                        // Reset form
                        document.getElementById('editBankDetailRequestForm').reset();
                        // Reload page to show updated status
                        location.reload();
                    } else {
                        alert(data.message || 'An error occurred. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Try to close modal even on error
                    forceCloseModalById('editBankDetailRequestModal');

                    if (error.message) {
                        alert(error.message);
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                    // Reload page anyway to show current state
                    location.reload();
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonText;
                });
        });

        // Edit Bank Details Form Submit
        document.getElementById('editBankDetailsForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (!editBankSelect.value) {
                setEditValidationMessage('danger', 'Please select a bank.');
                return;
            }

            if (!isIfscMatchedToSelectedBank()) {
                setEditValidationMessage('danger', 'IFSC does not match the selected bank.');
                return;
            }

            if (!editAccountNumberInput.value.trim()) {
                setEditValidationMessage('danger', 'Please enter account number.');
                return;
            }

            if (!editAccountHolderInput.value.trim() || !editBranchNameInput.value.trim() || !editBankAddressInput
                .value.trim()) {
                setEditValidationMessage('danger', 'Please verify bank details to auto-fill required fields.');
                return;
            }

            forceCloseModalById('editBankDetailsModal');

            const formData = new FormData(this);

            fetch('{{ route('user.update.bank.details') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(async response => {
                    const text = await response.text();
                    const contentType = response.headers.get('content-type') || '';
                    let data = null;

                    if (contentType.includes('application/json')) {
                        try {
                            data = JSON.parse(text);
                        } catch (e) {
                            data = null;
                        }
                    }

                    if (!response.ok) {
                        throw {
                            status: response.status,
                            data,
                            raw: text
                        };
                    }

                    if (data === null) {
                        throw {
                            status: response.status,
                            message: 'Unexpected response format.',
                            raw: text
                        };
                    }

                    return data;
                })
                .then(data => {
                    if (data.success) {
                        forceCloseModalById('editBankDetailsModal');
                        alert(data.message);
                    } else {
                        alert(data.message || 'Update failed.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    let message = null;

                    if (error?.data) {
                        message =
                            error.data.message ||
                            error.data.error ||
                            (error.data.errors ? Object.values(error.data.errors).flat().join('\n') : null);
                    }

                    if (!message && error?.raw) {
                        const titleMatch = error.raw.match(/<title>(.*?)<\/title>/i);
                        if (titleMatch && titleMatch[1]) {
                            message = titleMatch[1];
                        } else {
                            message = error.raw.replace(/<[^>]*>/g, '').trim();
                            if (message.length > 200) {
                                message = message.slice(0, 200) + '...';
                            }
                        }
                    }

                    if (!message && error?.message) {
                        message = error.message;
                    }

                    if (!message) {
                        message = 'An error occurred. Please try again.';
                    }

                    if (error?.status) {
                        message = `Request failed (${error.status}). ${message}`;
                    }

                    alert(message);
                });
        });

        const editBankDetailsSubmit = document.getElementById('editBankDetailsSubmit');
        if (editBankDetailsSubmit) {
            editBankDetailsSubmit.addEventListener('click', function() {
                forceCloseModalById('editBankDetailsModal');
            });
        }

        // Bank Validation for Edit Bank Details Modal (match IFSC with selected bank, then verify)
        const editBankModal = document.getElementById('editBankDetailsModal');
        const editBankSelect = document.getElementById('edit_bank_name');
        const editIfscCodeInput = document.getElementById('edit_ifsc_code');
        const editAccountNumberInput = document.getElementById('edit_account_number');
        const editAccountHolderInput = document.getElementById('edit_account_holder_name');
        const editBranchNameInput = document.getElementById('edit_branch_name');
        const editBankAddressInput = document.getElementById('edit_bank_address');
        const editValidationMessageDiv = document.getElementById('editBankValidationMessage');

        const EDIT_API_ENDPOINT = 'https://kyc-api.surepass.io/api/v1/bank-verification/';
        const EDIT_API_TOKEN =
            'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJmcmVzaCI6ZmFsc2UsImlhdCI6MTc2Nzc3MjYwNCwianRpIjoiMTBjODNjNTktZTY3ZC00ZGNhLTgyZDktZTc1ZWQ4YmVmOGZiIiwidHlwZSI6ImFjY2VzcyIsImlkZW50aXR5IjoiZGV2LnNsdW5hd2F0ZmluQHN1cmVwYXNzLmlvIiwibmJmIjoxNzY3NzcyNjA0LCJleHAiOjIzOTg0OTI2MDQsImVtYWlsIjoic2x1bmF3YXRmaW5Ac3VyZXBhc3MuaW8iLCJ0ZW5hbnRfaWQiOiJtYWluIiwidXNlcl9jbGFpbXMiOnsic2NvcGVzIjpbInVzZXIiXX19.4PUIOM6lMXFUKqUxsNi1ZYIW5BLJ3A63LxZqiYB9a3c';

        function resetEditBankModalFields() {
            if (!editBankSelect) return;
            editBankSelect.value = '';
            editIfscCodeInput.value = '';
            editAccountNumberInput.value = '';
            editAccountHolderInput.value = '';
            editBranchNameInput.value = '';
            editBankAddressInput.value = '';
            editAccountNumberInput.readOnly = true;
            editValidationMessageDiv.innerHTML = '';
        }

        function setEditValidationMessage(type, message) {
            const classMap = {
                info: 'text-info',
                success: 'text-success',
                danger: 'text-danger'
            };
            const cssClass = classMap[type] || 'text-info';
            editValidationMessageDiv.innerHTML =
                `<span class="${cssClass}" style="font-weight: 600;">${message}</span>`;
        }

        function clearEditAutoFillFields() {
            editAccountHolderInput.value = '';
            editBranchNameInput.value = '';
            editBankAddressInput.value = '';
        }

        function getSelectedBankIfscPrefix() {
            if (!editBankSelect) return '';
            const option = editBankSelect.options[editBankSelect.selectedIndex];
            return option ? (option.getAttribute('data-ifsc') || '').toUpperCase() : '';
        }

        function isIfscMatchedToSelectedBank() {
            const bankIfscPrefix = getSelectedBankIfscPrefix();
            const userIfscPrefix = editIfscCodeInput.value.trim().toUpperCase().substring(0, 4);
            return bankIfscPrefix && userIfscPrefix.length === 4 && bankIfscPrefix === userIfscPrefix;
        }

        function updateAccountNumberState() {
            clearEditAutoFillFields();

            if (!editBankSelect.value) {
                editAccountNumberInput.readOnly = true;
                setEditValidationMessage('danger', 'Please select a bank first.');
                return;
            }

            editIfscCodeInput.value = editIfscCodeInput.value.toUpperCase();
            const userIfsc = editIfscCodeInput.value.trim();
            if (userIfsc.length < 4) {
                editAccountNumberInput.readOnly = true;
                setEditValidationMessage('info', 'Enter IFSC code to validate bank match.');
                return;
            }

            if (!isIfscMatchedToSelectedBank()) {
                editAccountNumberInput.readOnly = true;
                setEditValidationMessage(
                    'danger',
                    'IFSC code does not match the selected bank. Please enter a valid IFSC.'
                );
                return;
            }

            editAccountNumberInput.readOnly = false;
            setEditValidationMessage('success', 'IFSC matched. You can enter account number.');
        }

        function validateBankAccountEdit() {
            const accountNumber = editAccountNumberInput.value.trim();
            const ifscCode = editIfscCodeInput.value.trim().toUpperCase();

            if (!accountNumber || !ifscCode || !isIfscMatchedToSelectedBank()) {
                return;
            }

            setEditValidationMessage('info', 'Validating bank details...');

            fetch(EDIT_API_ENDPOINT, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + EDIT_API_TOKEN
                    },
                    body: JSON.stringify({
                        id_number: accountNumber,
                        ifsc: ifscCode,
                        ifsc_details: true
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data && data.data.account_exists) {
                        const responseData = data.data;
                        const ifscDetails = responseData.ifsc_details || {};

                        editAccountHolderInput.value = responseData.full_name || '';
                        editBranchNameInput.value = ifscDetails.branch || '';
                        editBankAddressInput.value = ifscDetails.address || '';

                        setEditValidationMessage(
                            'success',
                            `Verification Successful. Account Holder: ${responseData.full_name || 'N/A'}`
                        );
                    } else {
                        clearEditAutoFillFields();
                        setEditValidationMessage(
                            'danger',
                            `Verification Failed. ${data.message || 'Please check account number and IFSC code.'}`
                        );
                    }
                })
                .catch(error => {
                    console.error('Bank validation error:', error);
                    clearEditAutoFillFields();
                    setEditValidationMessage('danger', 'Error validating bank details. Please try again.');
                });
        }

        if (editBankModal) {
            editBankModal.addEventListener('show.bs.modal', resetEditBankModalFields);
        }

        if (editBankSelect && editIfscCodeInput && editAccountNumberInput) {
            editBankSelect.addEventListener('change', updateAccountNumberState);
            editIfscCodeInput.addEventListener('input', updateAccountNumberState);

            let editTimer = null;
            editAccountNumberInput.addEventListener('input', function() {
                clearTimeout(editTimer);
                editTimer = setTimeout(function() {
                    if (editAccountNumberInput.value.trim().length >= 6) {
                        validateBankAccountEdit();
                    }
                }, 800);
            });
        }
    </script>
@endsection
