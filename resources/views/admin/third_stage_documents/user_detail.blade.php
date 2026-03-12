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

                    <h5 class="mt-4">Uploaded Documents</h5>
                    @if($user->thirdStageDocument && !empty($user->thirdStageDocument->documents))
                        <ul class="list-group">
                            @foreach($user->thirdStageDocument->documents as $doc)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ basename($doc) }}</span>
                                    <a href="{{ asset($doc) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                </li>
                            @endforeach
                        </ul>
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
