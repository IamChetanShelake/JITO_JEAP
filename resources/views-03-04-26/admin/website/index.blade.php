@extends('admin.website.layouts.master')

@section('title', 'Website Dashboard - JitoJeap Admin')

@section('website-content')
<style>
    /* Dashboard Header */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .dashboard-title {
        font-size: clamp(1.5rem, 4vw, 2rem);
        font-weight: 700;
        color: var(--primary-color);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .dashboard-title i {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6c5ce7 100%);
        color: white;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.2rem;
    }

    .dashboard-subtitle {
        color: #666;
        font-size: 0.95rem;
        margin-top: 0.25rem;
    }

    /* Statistics Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid #eee;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), #6c5ce7);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }

    .stat-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .stat-card-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        background: #f8f9ff;
        color: var(--primary-color);
    }

    .stat-card-value {
        font-size: 2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.25rem;
    }

    .stat-card-label {
        font-size: 0.9rem;
        color: #666;
        font-weight: 500;
    }

    /* Section Cards */
    .section-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid #eee;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .section-card-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6c5ce7 100%);
        color: white;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-card-header i {
        font-size: 1.2rem;
    }

    .section-card-header h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .section-card-body {
        padding: 1.5rem;
    }

    /* Quick Links Grid */
    .quick-links-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
    }

    .quick-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        background: #f8f9ff;
        border-radius: 12px;
        text-decoration: none;
        color: #333;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .quick-link:hover {
        background: #ebe8ff;
        border-color: var(--primary-color);
        transform: translateX(5px);
        color: var(--primary-color);
    }

    .quick-link-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        color: var(--primary-color);
        font-size: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .quick-link-content {
        flex: 1;
    }

    .quick-link-title {
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.15rem;
    }

    .quick-link-count {
        font-size: 0.8rem;
        color: #666;
    }

    /* Stats Row */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .stat-item {
        text-align: center;
        padding: 1rem;
        background: #f8f9ff;
        border-radius: 12px;
    }

    .stat-item-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.25rem;
    }

    .stat-item-label {
        font-size: 0.8rem;
        color: #666;
    }

    /* Welcome Card */
    .welcome-card {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6c5ce7 100%);
        color: white;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .welcome-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    }

    .welcome-card h2 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
    }

    .welcome-card p {
        opacity: 0.9;
        font-size: 1rem;
        position: relative;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .quick-links-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<!-- Welcome Card -->
<div class="welcome-card">
    <h2><i class="fas fa-globe me-2"></i> Website Management Dashboard</h2>
    <p>Manage all website content, pages, and settings from this central dashboard. Use the sidebar to navigate between different sections.</p>
</div>

<!-- Overall Statistics -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon">
                <i class="fas fa-home"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ array_sum($stats['home']) }}</div>
        <div class="stat-card-label">Home Page Items</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon">
                <i class="fas fa-info-circle"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ array_sum($stats['about']) }}</div>
        <div class="stat-card-label">About Us Items</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon">
                <i class="fas fa-file-alt"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ array_sum($stats['application']) }}</div>
        <div class="stat-card-label">Application Items</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-card-icon">
                <i class="fas fa-layer-group"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ array_sum($stats['other']) }}</div>
        <div class="stat-card-label">Other Pages</div>
    </div>
</div>

<!-- Home Section -->
<div class="section-card">
    <div class="section-card-header">
        <i class="fas fa-home"></i>
        <h3>Home Page Management</h3>
    </div>
    <div class="section-card-body">
        <div class="quick-links-grid">
            <a href="{{ route('admin.website.home.empowering-dreams') }}" class="quick-link">
                <div class="quick-link-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <div class="quick-link-content">
                    <div class="quick-link-title">Empowering Dreams</div>
                    <div class="quick-link-count">{{ $stats['home']['empowering_dreams'] }} items</div>
                </div>
            </a>

            <a href="{{ route('admin.website.home.key-instruction') }}" class="quick-link">
                <div class="quick-link-icon">
                    <i class="fas fa-key"></i>
                </div>
                <div class="quick-link-content">
                    <div class="quick-link-title">Key Instructions</div>
                    <div class="quick-link-count">{{ $stats['home']['key_instructions'] }} items</div>
                </div>
            </a>

            <a href="{{ route('admin.website.home.working-committee') }}" class="quick-link">
                <div class="quick-link-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="quick-link-content">
                    <div class="quick-link-title">Working Committee</div>
                    <div class="quick-link-count">{{ $stats['home']['working_committee'] }} items</div>
                </div>
            </a>

            <a href="{{ route('admin.website.home.empowering-future') }}" class="quick-link">
                <div class="quick-link-icon">
                    <i class="fas fa-rocket"></i>
                </div>
                <div class="quick-link-content">
                    <div class="quick-link-title">Empowering Future</div>
                    <div class="quick-link-count">{{ $stats['home']['empowering_future'] }} items</div>
                </div>
            </a>

            <a href="{{ route('admin.website.home.achievement-impact') }}" class="quick-link">
                <div class="quick-link-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="quick-link-content">
                    <div class="quick-link-title">Achievement & Impact</div>
                    <div class="quick-link-count">{{ $stats['home']['achievement_impact'] }} items</div>
                </div>
            </a>

            <a href="{{ route('admin.website.home.photo-gallery') }}" class="quick-link">
                <div class="quick-link-icon">
                    <i class="fas fa-images"></i>
                </div>
                <div class="quick-link-content">
                    <div class="quick-link-title">Photo Gallery</div>
                    <div class="quick-link-count">{{ $stats['home']['photo_gallery'] }} items</div>
                </div>
            </a>

            <a href="{{ route('admin.website.home.our-testimonial') }}" class="quick-link">
                <div class="quick-link-icon">
                    <i class="fas fa-quote-left"></i>
                </div>
                <div class="quick-link-content">
                    <div class="quick-link-title">Our Testimonials</div>
                    <div class="quick-link-count">{{ $stats['home']['our_testimonials'] }} items</div>
                </div>
            </a>

            <a href="{{ route('admin.website.home.success-stories') }}" class="quick-link">
                <div class="quick-link-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="quick-link-content">
                    <div class="quick-link-title">Success Stories</div>
                    <div class="quick-link-count">{{ $stats['home']['success_stories'] }} items</div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- About Section -->
<div class="section-card">
    <div class="section-card-header">
        <i class="fas fa-info-circle"></i>
        <h3>About Us Management</h3>
    </div>
    <div class="section-card-body">
        <div class="quick-links-grid">
            <a href="{{ route('admin.website.about.jito') }}" class="quick-link">
                <div class="quick-link-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="quick-link-content">
                    <div class="quick-link-title">JITO</div>
                    <div class="quick-link-count">{{ $stats['about']['jito'] }} items</div>
                </div>
            </a>

            <a href="{{ route('admin.website.about.jeap') }}" class="quick-link">
                <div class="quick-link-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="quick-link-content">
                    <div class="quick-link-title">JEAP</div>
                    <div class="quick-link-count">{{ $stats['about']['jeap'] }} items</div>
                </div>
            </a>

            <a href="{{ route('admin.website.about.board-of-directors') }}" class="quick-link">
                <div class="quick-link-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="quick-link-content">
                    <div class="quick-link-title">Board of Directors</div>
                    <div class="quick-link-count">{{ $stats['about']['board_of_directors'] }} items</div>
                </div>
            </a>

            <a href="{{ route('admin.website.about.zone-chairmen') }}" class="quick-link">
                <div class="quick-link-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="quick-link-content">
                    <div class="quick-link-title">Zone Chairmen</div>
                    <div class="quick-link-count">{{ $stats['about']['zone_chairmen'] }} items</div>
                </div>
            </a>

            <a href="{{ route('admin.website.about.testimonials-success') }}" class="quick-link">
                <div class="quick-link-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="quick-link-content">
                    <div class="quick-link-title">Testimonials & Success</div>
                    <div class="quick-link-count">{{ $stats['about']['testimonials_success'] }} items</div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Application & Other Sections -->
<div class="row g-3">
    <div class="col-lg-6">
        <div class="section-card">
            <div class="section-card-header">
                <i class="fas fa-file-alt"></i>
                <h3>Application Management</h3>
            </div>
            <div class="section-card-body">
                <div class="quick-links-grid">
                    <a href="{{ route('admin.website.application.faqs') }}" class="quick-link">
                        <div class="quick-link-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <div class="quick-link-content">
                            <div class="quick-link-title">FAQs</div>
                            <div class="quick-link-count">{{ $stats['application']['faqs'] }} items</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="section-card">
            <div class="section-card-header">
                <i class="fas fa-cog"></i>
                <h3>Other Pages</h3>
            </div>
            <div class="section-card-body">
                <div class="quick-links-grid">
                    <a href="{{ route('admin.website.contact') }}" class="quick-link">
                        <div class="quick-link-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="quick-link-content">
                            <div class="quick-link-title">Contact</div>
                            <div class="quick-link-count">{{ $stats['other']['contact'] }} items</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.website.university') }}" class="quick-link">
                        <div class="quick-link-icon">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="quick-link-content">
                            <div class="quick-link-title">Universities</div>
                            <div class="quick-link-count">{{ $stats['other']['universities'] }} items</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.website.course') }}" class="quick-link">
                        <div class="quick-link-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="quick-link-content">
                            <div class="quick-link-title">Courses</div>
                            <div class="quick-link-count">{{ $stats['other']['courses'] }} items</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.website.college') }}" class="quick-link">
                        <div class="quick-link-icon">
                            <i class="fas fa-school"></i>
                        </div>
                        <div class="quick-link-content">
                            <div class="quick-link-title">Colleges</div>
                            <div class="quick-link-count">{{ $stats['other']['colleges'] }} items</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.website.be-donor') }}" class="quick-link">
                        <div class="quick-link-icon">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <div class="quick-link-content">
                            <div class="quick-link-title">Be a Donor</div>
                            <div class="quick-link-count">{{ $stats['other']['be_donor_details'] }} items</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats Summary -->
<div class="section-card">
    <div class="section-card-header">
        <i class="fas fa-chart-pie"></i>
        <h3>Content Summary</h3>
    </div>
    <div class="section-card-body">
        <div class="stats-row">
            <div class="stat-item">
                <div class="stat-item-value">{{ array_sum($stats['home']) + array_sum($stats['about']) + array_sum($stats['application']) + array_sum($stats['other']) }}</div>
                <div class="stat-item-label">Total Items</div>
            </div>
            <div class="stat-item">
                <div class="stat-item-value">{{ $stats['home']['empowering_dreams'] + $stats['home']['key_instructions'] + $stats['home']['working_committee'] }}</div>
                <div class="stat-item-label">Home Sections</div>
            </div>
            <div class="stat-item">
                <div class="stat-item-value">{{ $stats['about']['jito'] + $stats['about']['jeap'] + $stats['about']['board_of_directors'] }}</div>
                <div class="stat-item-label">About Sections</div>
            </div>
            <div class="stat-item">
                <div class="stat-item-value">{{ $stats['other']['universities'] + $stats['other']['courses'] + $stats['other']['colleges'] }}</div>
                <div class="stat-item-label">Education Items</div>
            </div>
        </div>
    </div>
</div>
@endsection
