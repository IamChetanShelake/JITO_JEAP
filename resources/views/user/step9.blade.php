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
                                @endif

                                <div class="mb-3">
                                    <label class="form-label" style="font-weight: 600; color: #393185;">
                                        Upload Documents
                                    </label>
                                    <input type="file" class="form-control" name="documents[]" multiple
                                        {{ $isLocked ? 'disabled' : '' }}>
                                    <small class="text-muted">Allowed formats: PDF, JPG, JPEG, PNG. Max 5MB per file.</small>
                                </div>

                                @if ($thirdStageDocument && !empty($thirdStageDocument->documents))
                                    <div class="mt-4">
                                        <h5 style="font-weight: 600;">Uploaded Documents</h5>
                                        <ul class="list-group">
                                            @foreach ($thirdStageDocument->documents as $doc)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>{{ basename($doc) }}</span>
                                                    <a href="{{ asset($doc) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary">View</a>
                                                </li>
                                            @endforeach
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
