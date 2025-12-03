@extends('admin.layouts.master')

@section('title', 'Admin Dashboard - JitoJeap')

@section('styles')
<style>
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .dashboard-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
        margin: 0;
    }

    .dashboard-subtitle {
        color: #666;
        font-size: 0.95rem;
    }

    .change-country-btn {
        color: #E31E24;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .nav-tabs-custom {
        border: none;
        gap: 0.5rem;
        margin-bottom: 2rem;
        display: flex;
        flex-wrap: wrap;
    }

    .nav-tabs-custom .nav-item {
        flex: 1;
        min-width: 150px;
    }

    .nav-tabs-custom .nav-link {
        border: none;
        border-radius: 25px;
        padding: 0.75rem 1.5rem;
        color: white;
        font-weight: 500;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        height: 50px;
        text-align: center;
    }

    .nav-tabs-custom .nav-link:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    /* Dashboard - Purple */
    .nav-tabs-custom .nav-link.tab-dashboard {
        background: #393185;
    }

    /* Apex - Green */
    .nav-tabs-custom .nav-link.tab-apex {
        background: #009846;
    }

    /* Working Committee - Yellow */
    .nav-tabs-custom .nav-link.tab-committee {
        background: #FBBA00;
    }

    /* Zone - Red */
    .nav-tabs-custom .nav-link.tab-zone {
        background: #E31E24;
    }

    /* Chapter - Purple */
    .nav-tabs-custom .nav-link.tab-chapter {
        background: #393185;
    }

    /* Initiatives - Green */
    .nav-tabs-custom .nav-link.tab-initiatives {
        background: #009846;
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .stat-card-title {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 1rem;
    }

    .stat-card-value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .stat-card-subtitle {
        font-size: 0.85rem;
        margin: 0;
    }

    .stat-card-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-left: auto;
    }

    .approval-section {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        border: 1px solid #e0e0e0;
        margin-bottom: 1.5rem;
    }

    .approval-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.75rem;
    }

    .approval-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .approval-title i {
        font-size: 1.2rem;
    }

    .approval-total {
        color: #999;
        font-size: 0.9rem;
        font-weight: 400;
    }

    /* Section Title Colors */
    .approval-title.apex-title,
    .approval-title.apex-title i {
        color: #393185;
    }

    .approval-title.working-committee-title,
    .approval-title.working-committee-title i {
        color: #009846;
    }

    .approval-title.zone-title,
    .approval-title.zone-title i {
        color: #FBBA00;
    }

    .approval-title.chapter-title,
    .approval-title.chapter-title i {
        color: #E31E24;
    }

    .approval-title.initiatives-title,
    .approval-title.initiatives-title i {
        color: #393185;
    }

    .approval-rate {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 0.75rem;
        display: flex;
        justify-content: space-between;
    }

    .progress-custom {
        height: 8px;
        border-radius: 10px;
        background: #f0f0f0;
        margin-bottom: 1.5rem;
    }

    .progress-bar-custom {
        height: 100%;
        border-radius: 10px;
        transition: width 0.6s ease;
    }

    .status-badges {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
    }

    .status-badge {
        border-radius: 12px;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border: 1px solid;
    }

    .status-badge.approved {
        background: #e8f5e9;
        border-color: #c8e6c9;
    }

    .status-badge.pending {
        background: #fff8e1;
        border-color: #ffe082;
    }

    .status-badge.hold {
        background: #ffebee;
        border-color: #ffcdd2;
    }

    .status-icon {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        border: 2px solid;
        background: transparent;
    }

    .status-icon.approved {
        border-color: #4caf50;
        color: #4caf50;
    }

    .status-icon.pending {
        border-color: #ffc107;
        color: #ffc107;
    }

    .status-icon.hold {
        border-color: #f44336;
        color: #f44336;
    }

    .status-label {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 0.25rem;
    }

    .status-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
    }

    .recent-applications {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid #e0e0e0;
    }

    .recent-app-header {
        font-size: 1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .recent-app-subtitle {
        font-size: 0.85rem;
        color: #999;
        margin-bottom: 1.5rem;
    }

    .application-item {
        padding: 1rem 0;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .application-item:last-child {
        border-bottom: none;
    }

    .app-name {
        font-weight: 600;
        color: #333;
        font-size: 0.95rem;
        margin-bottom: 0.25rem;
    }

    .app-category {
        color: #999;
        font-size: 0.85rem;
    }

    .app-time {
        color: #999;
        font-size: 0.85rem;
    }
</style>
@endsection

@section('content')
<!-- Dashboard Header -->
<div class="dashboard-header">
    <div>
        <h1 class="dashboard-title">Admin Dashboard</h1>
        <p class="dashboard-subtitle">India</p>
    </div>
    <a href="#" class="change-country-btn">Change Country</a>
</div>

<!-- Navigation Tabs -->
<ul class="nav nav-tabs-custom">
    <li class="nav-item">
        <a class="nav-link tab-dashboard" href="{{ route('admin.home') }}">
            <i class="fas fa-th-large"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link tab-apex" href="{{ route('admin.apex.index') }}">
            <i class="fas fa-users"></i> Apex
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link tab-committee" href="{{ route('admin.committee.index') }}">
            <i class="fas fa-user-tie"></i> Working Committee
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link tab-zone" href="{{ route('admin.zones.index') }}">
            <i class="fas fa-globe"></i> Zone
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link tab-chapter" href="{{ route('admin.chapters.index') }}">
            <i class="fas fa-map-marker-alt"></i> Chapter
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link tab-initiatives" href="{{ route('admin.initiatives.index') }}">
            <i class="fas fa-lightbulb"></i> Initiatives
        </a>
    </li>
</ul>

<!-- Statistics Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-start">
                <div class="flex-grow-1">
                    <div class="stat-card-title">Total Applicants</div>
                    <div class="stat-card-value">245</div>
                    <p class="stat-card-subtitle" style="color: #666;">+ 48 this month</p>
                </div>
                <div class="stat-card-icon" style="background: #e8eaf6;">
                    <i class="fas fa-file-alt" style="color: #393185;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-start">
                <div class="flex-grow-1">
                    <div class="stat-card-title">Active Initiatives</div>
                    <div class="stat-card-value" style="color: #009846;">22</div>
                    <p class="stat-card-subtitle" style="color: #009846;">Out of 28 total</p>
                </div>
                <div class="stat-card-icon" style="background: #e8f5e9;">
                    <i class="fas fa-chart-line" style="color: #009846;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-start">
                <div class="flex-grow-1">
                    <div class="stat-card-title">Pending Reviews</div>
                    <div class="stat-card-value" style="color: #FBBA00;">17</div>
                    <p class="stat-card-subtitle" style="color: #FBBA00;">Across all categories</p>
                </div>
                <div class="stat-card-icon" style="background: #fff8e1;">
                    <i class="fas fa-clock" style="color: #FBBA00;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-start">
                <div class="flex-grow-1">
                    <div class="stat-card-title">On Hold</div>
                    <div class="stat-card-value" style="color: #E31E24;">6</div>
                    <p class="stat-card-subtitle" style="color: #E31E24;">Need attention</p>
                </div>
                <div class="stat-card-icon" style="background: #ffebee;">
                    <i class="fas fa-exclamation-circle" style="color: #E31E24;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approval Sections -->
<div class="row">
    <div class="col-lg-6">
        <!-- Apex Leadership -->
        <div class="approval-section">
            <div class="approval-header">
                <div class="approval-title apex-title">
                    <i class="fas fa-users"></i>
                    Apex Leadership
                </div>
                <div class="approval-total">Total - 15</div>
            </div>
            <div class="approval-rate">
                <span>Approval Rate</span>
                <span>80%</span>
            </div>
            <div class="progress-custom">
                <div class="progress-bar-custom" style="width: 80%; background: linear-gradient(90deg, #4caf50, #66bb6a);"></div>
            </div>
            <div class="status-badges">
                <div class="status-badge approved">
                    <div class="status-icon approved">
                        <i class="far fa-check-circle"></i>
                    </div>
                    <div>
                        <div class="status-label">Approved</div>
                        <div class="status-value">12</div>
                    </div>
                </div>
                <div class="status-badge pending">
                    <div class="status-icon pending">
                        <i class="far fa-clock"></i>
                    </div>
                    <div>
                        <div class="status-label">Pending</div>
                        <div class="status-value">2</div>
                    </div>
                </div>
                <div class="status-badge hold">
                    <div class="status-icon hold">
                        <i class="far fa-exclamation-circle"></i>
                    </div>
                    <div>
                        <div class="status-label">Hold</div>
                        <div class="status-value">1</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Zone -->
        <div class="approval-section">
            <div class="approval-header">
                <div class="approval-title zone-title">
                    <i class="fas fa-globe"></i>
                    Zone
                </div>
                <div class="approval-total">Total - 12</div>
            </div>
            <div class="approval-rate">
                <span>Approval Rate</span>
                <span>70%</span>
            </div>
            <div class="progress-custom">
                <div class="progress-bar-custom" style="width: 70%; background: linear-gradient(90deg, #4caf50, #66bb6a);"></div>
            </div>
            <div class="status-badges">
                <div class="status-badge approved">
                    <div class="status-icon approved">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <div class="status-label">Approved</div>
                        <div class="status-value">{{ \App\Models\Zone::where('status', true)->count() }}</div>
                    </div>
                </div>
                <div class="status-badge pending">
                    <div class="status-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div class="status-label">Pending</div>
                        <div class="status-value">1</div>
                    </div>
                </div>
                <div class="status-badge hold">
                    <div class="status-icon hold">
                        <i class="fas fa-exclamation"></i>
                    </div>
                    <div>
                        <div class="status-label">Hold</div>
                        <div class="status-value">1</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Initiatives -->
        <div class="approval-section">
            <div class="approval-header">
                <div class="approval-title initiatives-title">
                    <i class="fas fa-lightbulb"></i>
                    Initiatives
                </div>
                <div class="approval-total">Total - 14</div>
            </div>
            <div class="approval-rate">
                <span>Approval Rate</span>
                <span>80%</span>
            </div>
            <div class="progress-custom">
                <div class="progress-bar-custom" style="width: 80%; background: linear-gradient(90deg, #4caf50, #66bb6a);"></div>
            </div>
            <div class="status-badges">
                <div class="status-badge approved">
                    <div class="status-icon approved">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <div class="status-label">Approved</div>
                        <div class="status-value">10</div>
                    </div>
                </div>
                <div class="status-badge pending">
                    <div class="status-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div class="status-label">Pending</div>
                        <div class="status-value">3</div>
                    </div>
                </div>
                <div class="status-badge hold">
                    <div class="status-icon hold">
                        <i class="fas fa-exclamation"></i>
                    </div>
                    <div>
                        <div class="status-label">Hold</div>
                        <div class="status-value">1</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <!-- Working Committee -->
        <div class="approval-section">
            <div class="approval-header">
                <div class="approval-title working-committee-title">
                    <i class="fas fa-user-tie"></i>
                    Working Committee
                </div>
                <div class="approval-total">Total - 42</div>
            </div>
            <div class="approval-rate">
                <span>Approval Rate</span>
                <span>83%</span>
            </div>
            <div class="progress-custom">
                <div class="progress-bar-custom" style="width: 83%; background: linear-gradient(90deg, #4caf50, #66bb6a);"></div>
            </div>
            <div class="status-badges">
                <div class="status-badge approved">
                    <div class="status-icon approved">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <div class="status-label">Approved</div>
                        <div class="status-value">35</div>
                    </div>
                </div>
                <div class="status-badge pending">
                    <div class="status-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div class="status-label">Pending</div>
                        <div class="status-value">5</div>
                    </div>
                </div>
                <div class="status-badge hold">
                    <div class="status-icon hold">
                        <i class="fas fa-exclamation"></i>
                    </div>
                    <div>
                        <div class="status-label">Hold</div>
                        <div class="status-value">2</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chapter -->
        <div class="approval-section">
            <div class="approval-header">
                <div class="approval-title chapter-title">
                    <i class="fas fa-map-marker-alt"></i>
                    Chapter
                </div>
                <div class="approval-total">Total - 10</div>
            </div>
            <div class="approval-rate">
                <span>Approval Rate</span>
                <span>75%</span>
            </div>
            <div class="progress-custom">
                <div class="progress-bar-custom" style="width: 75%; background: linear-gradient(90deg, #4caf50, #66bb6a);"></div>
            </div>
            <div class="status-badges">
                <div class="status-badge approved">
                    <div class="status-icon approved">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <div class="status-label">Approved</div>
                        <div class="status-value">{{ \App\Models\Chapter::where('status', true)->count() }}</div>
                    </div>
                </div>
                <div class="status-badge pending">
                    <div class="status-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div class="status-label">Pending</div>
                        <div class="status-value">2</div>
                    </div>
                </div>
                <div class="status-badge hold">
                    <div class="status-icon hold">
                        <i class="fas fa-exclamation"></i>
                    </div>
                    <div>
                        <div class="status-label">Hold</div>
                        <div class="status-value">2</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Applications -->
        <div class="recent-applications">
            <div class="recent-app-header">Recent Application</div>
            <div class="recent-app-subtitle">Latest membership applications</div>
            
            <div class="application-item">
                <div>
                    <div class="app-name">Rajesh Jain</div>
                    <div class="app-category">Apex Leadership</div>
                </div>
                <div class="app-time">2 hours ago</div>
            </div>
            
            <div class="application-item">
                <div>
                    <div class="app-name">Manoj Mehta</div>
                    <div class="app-category">Working Committee</div>
                </div>
                <div class="app-time">3 hours ago</div>
            </div>
            
            <div class="application-item">
                <div>
                    <div class="app-name">Kashish Patel</div>
                    <div class="app-category">Zone Chapter</div>
                </div>
                <div class="app-time">5 hours ago</div>
            </div>
        </div>
    </div>
</div>
@endsection
