@extends('admin.layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">3rd Stage Document Details</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Name:</strong> {{ $user->name }}</div>
                        <div class="col-md-4"><strong>Email:</strong> {{ $user->email }}</div>
                        <div class="col-md-4"><strong>Phone:</strong> {{ $user->phone }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Chapter:</strong> {{ $user->chapter }}</div>
                        <div class="col-md-4"><strong>Status:</strong> {{ ucfirst(optional($user->thirdStageDocument)->status ?? 'pending') }}</div>
                        <div class="col-md-4"><strong>Submitted:</strong> {{ optional($user->thirdStageDocument?->submitted_at)->format('d-m-Y H:i') ?? 'N/A' }}</div>
                    </div>

                    @if($user->thirdStageDocument && $user->thirdStageDocument->admin_remark)
                        <div class="alert alert-warning">
                            <strong>Admin Remark:</strong>
                            {!! $user->thirdStageDocument->admin_remark !!}
                        </div>
                    @endif

                    @if($user->thirdStageDocument && $user->thirdStageDocument->status === 'rejected')
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="card border-danger h-100">
                                    <div class="card-body">
                                        <h5 class="card-title text-danger">Send Back for Correction</h5>
                                        <p class="card-text mb-2">This submission was sent back for correction.</p>
                                        @if ($user->thirdStageDocument->admin_remark)
                                            <div class="alert alert-danger mb-0" style="border-radius: 10px;">
                                                {!! $user->thirdStageDocument->admin_remark !!}
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
                                            The applicant must update the required fields/documents and resubmit.
                                        </p>
                                        <span class="text-muted">Once resubmitted, it will return to admin review.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($user->thirdStageDocument)
                        @if($user->financial_asset_type === 'domestic')
                            <h5 class="mt-4">Domestic Details</h5>
                            <div class="text-muted mb-3">Document fields for domestic applicants.</div>
                        @elseif($user->financial_asset_type === 'foreign_finance_assistant')
                            <h5 class="mt-4">Foreign Finance Assistant Details</h5>
                            <div class="row mb-3">
                                <div class="col-md-6"><strong>Overseas Address:</strong> {{ $user->thirdStageDocument->foreign_address ?? 'N/A' }}</div>
                                <div class="col-md-6"><strong>Foreign Contact Number:</strong> {{ $user->thirdStageDocument->foreign_contact_number ?? 'N/A' }}</div>
                                <div class="col-md-6"><strong>SSN / Country ID:</strong> {{ $user->thirdStageDocument->foreign_ssn_or_country_id ?? 'N/A' }}</div>
                                <div class="col-md-6"><strong>Foreign Bank Name:</strong> {{ $user->thirdStageDocument->foreign_bank_name ?? 'N/A' }}</div>
                                <div class="col-md-6"><strong>Foreign Bank Account Number:</strong> {{ $user->thirdStageDocument->foreign_bank_account_number ?? 'N/A' }}</div>
                            </div>
                        @endif
                    @endif

                    <h5 class="mt-4">Uploaded Documents</h5>
                    @if($user->thirdStageDocument)
                        @php
                            $hasUploads =
                                !empty($user->thirdStageDocument->documents) ||
                                !empty($user->thirdStageDocument->domestic_marksheets) ||
                                !empty($user->thirdStageDocument->domestic_paid_fees_receipt) ||
                                !empty($user->thirdStageDocument->domestic_cancelled_cheque) ||
                                !empty($user->thirdStageDocument->foreign_immigration_copy) ||
                                !empty($user->thirdStageDocument->foreign_paid_fees_receipt);
                        @endphp

                        @if($hasUploads)
                            <ul class="list-group">
                                @if(!empty($user->thirdStageDocument->domestic_marksheets))
                                    @foreach($user->thirdStageDocument->domestic_marksheets as $doc)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>{{ basename($doc) }}</span>
                                            <a href="{{ asset($doc) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                        </li>
                                    @endforeach
                                @endif

                                @if(!empty($user->thirdStageDocument->domestic_paid_fees_receipt))
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ basename($user->thirdStageDocument->domestic_paid_fees_receipt) }}</span>
                                        <a href="{{ asset($user->thirdStageDocument->domestic_paid_fees_receipt) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                    </li>
                                @endif

                                @if(!empty($user->thirdStageDocument->domestic_cancelled_cheque))
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ basename($user->thirdStageDocument->domestic_cancelled_cheque) }}</span>
                                        <a href="{{ asset($user->thirdStageDocument->domestic_cancelled_cheque) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                    </li>
                                @endif

                                @if(!empty($user->thirdStageDocument->foreign_immigration_copy))
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ basename($user->thirdStageDocument->foreign_immigration_copy) }}</span>
                                        <a href="{{ asset($user->thirdStageDocument->foreign_immigration_copy) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                    </li>
                                @endif

                                @if(!empty($user->thirdStageDocument->foreign_paid_fees_receipt))
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ basename($user->thirdStageDocument->foreign_paid_fees_receipt) }}</span>
                                        <a href="{{ asset($user->thirdStageDocument->foreign_paid_fees_receipt) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                    </li>
                                @endif

                                @if(!empty($user->thirdStageDocument->documents))
                                    @foreach($user->thirdStageDocument->documents as $doc)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>{{ basename($doc) }}</span>
                                            <a href="{{ asset($doc) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        @else
                            <p class="text-muted">No documents uploaded yet.</p>
                        @endif
                    @else
                        <p class="text-muted">No documents uploaded yet.</p>
                    @endif

                    <div class="mt-4">
                        @if($user->thirdStageDocument && $user->thirdStageDocument->status === 'submitted')
                            <form action="{{ route('admin.third_stage_documents.approve', $user->id) }}" method="POST" class="mb-3">
                                @csrf
                                <div class="mb-2">
                                    <label class="form-label">Approval Remark (optional)</label>
                                    <textarea name="admin_remark" class="form-control" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                            </form>

                            <form action="{{ route('admin.third_stage_documents.send_back', $user->id) }}" method="POST">
                                @csrf
                                <div class="mb-2">
                                    <label class="form-label">Send Back Remark (required)</label>
                                    <textarea name="admin_remark" class="form-control" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-undo"></i> Send Back for Correction
                                </button>
                            </form>
                        @elseif($user->thirdStageDocument && $user->thirdStageDocument->status === 'approved')
                            <div class="alert alert-success">Documents approved. Second disbursement can proceed.</div>
                        @else
                            <div class="alert alert-info">Awaiting student submission.</div>
                        @endif
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.third_stage_documents.pending') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
