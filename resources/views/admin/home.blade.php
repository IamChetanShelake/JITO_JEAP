@extends('admin.layouts.master')

@section('title', 'Admin Dashboard - JitoJeap')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-3">Welcome to JitoJeap Admin Panel</h2>
        <p class="text-muted">Manage zones and chapters for the organization</p>
    </div>
</div>

<div class="row g-4">
    <!-- Zone Statistics Card -->
    <div class="col-md-6 col-lg-3">
        <div class="section-card">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-map-marked-alt" style="font-size: 3rem; color: #393185;"></i>
                </div>
                <h3 class="mb-2" style="color: #393185;">{{ \App\Models\Zone::count() }}</h3>
                <p class="text-muted mb-0">Total Zones</p>
            </div>
        </div>
    </div>

    <!-- Chapter Statistics Card -->
    <div class="col-md-6 col-lg-3">
        <div class="section-card">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-building" style="font-size: 3rem; color: #E31E24;"></i>
                </div>
                <h3 class="mb-2" style="color: #E31E24;">{{ \App\Models\Chapter::count() }}</h3>
                <p class="text-muted mb-0">Total Chapters</p>
            </div>
        </div>
    </div>

    <!-- Active Zones Card -->
    <div class="col-md-6 col-lg-3">
        <div class="section-card">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-check-circle" style="font-size: 3rem; color: #009846;"></i>
                </div>
                <h3 class="mb-2" style="color: #009846;">{{ \App\Models\Zone::where('status', true)->count() }}</h3>
                <p class="text-muted mb-0">Active Zones</p>
            </div>
        </div>
    </div>

    <!-- Active Chapters Card -->
    <div class="col-md-6 col-lg-3">
        <div class="section-card">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-star" style="font-size: 3rem; color: #FBBA00;"></i>
                </div>
                <h3 class="mb-2" style="color: #FBBA00;">{{ \App\Models\Chapter::where('status', true)->count() }}</h3>
                <p class="text-muted mb-0">Active Chapters</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4 g-4">
    <!-- Quick Actions Card -->
    <div class="col-lg-6">
        <div class="section-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i> Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <a href="{{ route('admin.zones.create') }}" class="btn btn-custom d-flex align-items-center">
                        <i class="fas fa-plus-circle me-3"></i>
                        <span>Create New Zone</span>
                    </a>
                    <a href="{{ route('admin.chapters.create') }}" class="btn btn-success-custom d-flex align-items-center">
                        <i class="fas fa-plus-circle me-3"></i>
                        <span>Create New Chapter</span>
                    </a>
                    <a href="{{ route('admin.zones.index') }}" class="btn btn-custom d-flex align-items-center">
                        <i class="fas fa-list me-3"></i>
                        <span>View All Zones</span>
                    </a>
                    <a href="{{ route('admin.chapters.index') }}" class="btn btn-success-custom d-flex align-items-center">
                        <i class="fas fa-list me-3"></i>
                        <span>View All Chapters</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Card -->
    <div class="col-lg-6">
        <div class="section-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-clock me-2"></i> Recent Zones</h5>
            </div>
            <div class="card-body">
                @php
                    $recentZones = \App\Models\Zone::latest()->take(5)->get();
                @endphp
                @if($recentZones->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentZones as $zone)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <strong>{{ $zone->zone_name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $zone->zone_code }}</small>
                                </div>
                                <a href="{{ route('admin.zones.show', $zone) }}" class="btn btn-sm btn-custom">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No zones created yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
