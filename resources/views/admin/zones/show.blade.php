@extends('admin.layouts.master')

@section('title', 'Zone Details - JitoJeap Admin')

@section('content')
<div class="section-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i> Zone Details</h4>
        <div>
            <a href="{{ route('admin.zones.edit', $zone) }}" class="btn btn-success-custom">
                <i class="fas fa-edit me-2"></i> Edit
            </a>
            <a href="{{ route('admin.zones.index') }}" class="btn btn-custom">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted">Zone Name</h6>
                <p class="fs-5">{{ $zone->zone_name }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted">Code</h6>
                <p class="fs-5"><strong>{{ $zone->code }}</strong></p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted">State</h6>
                <p>{{ $zone->state }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted">Status</h6>
                <p>
                    @if($zone->status)
                        <span class="badge-status-active">Active</span>
                    @else
                        <span class="badge-status-inactive">Inactive</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted">Created At</h6>
                <p>{{ $zone->created_at->format('d M Y, h:i A') }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted">Last Updated</h6>
                <p>{{ $zone->updated_at->format('d M Y, h:i A') }}</p>
            </div>
        </div>

        <hr>

        <h5 class="mb-3"><i class="fas fa-building me-2"></i> Associated Chapters ({{ $zone->chapters->count() }})</h5>
        @if($zone->chapters->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Chapter Name</th>
                            <th>Code</th>
                            <th>City</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($zone->chapters as $chapter)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $chapter->chapter_name }}</td>
                            <td><strong>{{ $chapter->code }}</strong></td>
                            <td>{{ $chapter->city }}</td>
                            <td>
                                @if($chapter->status)
                                    <span class="badge-status-active">Active</span>
                                @else
                                    <span class="badge-status-inactive">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">No chapters associated with this zone yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection
