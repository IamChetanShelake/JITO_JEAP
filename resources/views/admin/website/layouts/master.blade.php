@extends('admin.layouts.master')

@section('title', 'Website Manage - JitoJeap Admin')

@section('styles')
<style>
    :root {
        --primary-color: #4a3fa5;
        --sidebar-bg: #ffffff;
        --sidebar-hover-bg: #f8f9ff;
        --sidebar-text: #5a5872;
        --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .website-pages-layout {
        display: flex;
        gap: 2rem;
        align-items: flex-start;
        min-height: 100vh; 
    }
    
    /* --- SIDEBAR STYLING --- */
    .website-pages-sidebar {
        flex: 0 0 280px;
        background: var(--sidebar-bg);
        border-radius: 0; 
        box-shadow: var(--card-shadow);
        
        position: sticky;
        top: 0;
        height: 100vh; /* Full screen height */
        display: flex;
        flex-direction: column;
        border-right: 1px solid #eee;
        
        /* FIX: Allow vertical scroll when dropdowns expand */
        overflow-y: auto;
    }
    
    .website-pages-sidebar .sidebar-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6c5ce7 100%);
        color: white;
        padding: 1.5rem;
        font-weight: 600;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        letter-spacing: 0.3px;
        flex-shrink: 0; /* Header stays fixed at top */
    }

    .website-pages-sidebar .sidebar-header i {
        background: rgba(255, 255, 255, 0.2);
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin-right: 12px;
    }
    
    .website-pages-list {
        list-style: none;
        padding: 1rem;
        margin: 0;
        
        /* FIX: This area takes all available space and handles scrolling */
        flex-grow: 1;
        overflow-y: auto; 
        min-height: 0; /* Crucial for flex scrolling */
        
        /* Optional: Nice scrollbar styling */
        scrollbar-width: thin;
        scrollbar-color: #ddd transparent;
    }
    
    .website-pages-list::-webkit-scrollbar {
        width: 6px;
    }
    .website-pages-list::-webkit-scrollbar-thumb {
        background-color: #ddd;
        border-radius: 3px;
    }
    
    .website-pages-list li {
        margin-bottom: 4px;
    }
    
    .website-pages-list a {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        color: var(--sidebar-text);
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.25s ease;
        font-weight: 500;
        border: 1px solid transparent;
    }
    
    .website-pages-list a:hover {
        background: var(--sidebar-hover-bg);
        color: var(--primary-color);
        transform: translateX(5px);
        border-color: #eee;
    }
    
    .website-pages-list a .icon-box {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0f2f5;
        border-radius: 8px;
        margin-right: 14px;
        transition: all 0.25s ease;
        color: var(--primary-color);
        font-size: 0.9rem;
    }

    .website-pages-list a:hover .icon-box {
        background: var(--primary-color);
        color: white;
        transform: scale(1.05);
    }

    .website-pages-list a.active {
        background: #ebe8ff;
        color: var(--primary-color);
        border-color: #d4cfff;
        font-weight: 600;
    }

    .website-pages-list a.active .icon-box {
        background: var(--primary-color);
        color: white;
        box-shadow: 0 4px 10px rgba(74, 63, 165, 0.3);
    }
    
    /* --- Content Area Styling --- */
    .website-pages-content {
        flex: 1;
        min-width: 0;
        padding-bottom: 2rem; 
    }
    
    .welcome-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        padding: 0;
        border: 1px solid #eee;
    }
    
    .welcome-card h3 {
        color: var(--primary-color);
        margin-bottom: 0;
        font-weight: 700;
        display: flex;
        align-items: center;
    }

    .welcome-card h3 i {
        background: #ebe8ff;
        color: var(--primary-color);
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        margin-right: 15px;
    }
    
    .welcome-card p {
        color: #666;
        line-height: 1.8;
        font-size: 1rem;
    }

    .quick-tips {
        margin-top: 2rem;
        padding: 1.5rem;
        background: #f8f9ff;
        border-radius: 10px;
        border-left: 4px solid var(--primary-color);
    }
    .quick-tips h4 {
        font-size: 0.95rem;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    .quick-tips ul {
        margin: 0;
        padding-left: 1.2rem;
        color: #555;
        font-size: 0.9rem;
    }
    .quick-tips li {
        margin-bottom: 5px;
    }
    
    /* --- DROPDOWN STYLING (ACCORDION) --- */
    .dropdown-menu-item {
        position: relative;
    }
    
    .dropdown-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 12px 15px;
        color: var(--sidebar-text);
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.25s ease;
        font-weight: 500;
        border: 1px solid transparent;
        background: transparent;
        cursor: pointer;
        font-size: inherit;
        font-family: inherit;
    }
    
    .dropdown-toggle:hover {
        background: var(--sidebar-hover-bg);
        color: var(--primary-color);
        transform: translateX(5px);
        border-color: #eee;
    }
    
    .dropdown-toggle .icon-box {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0f2f5;
        border-radius: 8px;
        margin-right: 14px;
        transition: all 0.25s ease;
        color: var(--primary-color);
        font-size: 0.9rem;
    }
    
    .dropdown-toggle:hover .icon-box {
        background: var(--primary-color);
        color: white;
        transform: scale(1.05);
    }
    
    .dropdown-toggle .arrow-icon {
        transition: transform 0.3s ease;
        font-size: 0.8rem;
        margin-left: auto;
    }
    
    .dropdown-toggle.active .arrow-icon {
        transform: rotate(180deg);
    }
    
    .dropdown-toggle.active {
        background: #ebe8ff;
        color: var(--primary-color);
        border-color: #d4cfff;
        font-weight: 600;
    }
    
    .dropdown-toggle.active .icon-box {
        background: var(--primary-color);
        color: white;
        box-shadow: 0 4px 10px rgba(74, 63, 165, 0.3);
    }
    
    .dropdown-menu {
        list-style: none;
        padding: 0;
        margin: 0;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease-out;
        background: #fcfcff; /* Slight background for distinction */
        border-radius: 0 0 10px 10px;
        position: relative;
        z-index: 1000;
    }
    
    .dropdown-menu.show {
        max-height: 1000px; /* Large enough to show all items */
    }
    
    .dropdown-menu li {
        margin: 0;
    }
    
    .dropdown-menu a {
        display: flex;
        align-items: center;
        padding: 10px 15px 10px 65px; /* Indented */
        color: var(--sidebar-text);
        text-decoration: none;
        transition: all 0.25s ease;
        font-size: 0.9rem;
        border-left: 3px solid transparent;
    }
    
    .dropdown-menu a:hover {
        background: var(--sidebar-hover-bg);
        color: var(--primary-color);
        border-left-color: var(--primary-color);
    }
    
    .dropdown-menu a.active {
        background: #ebe8ff;
        color: var(--primary-color);
        font-weight: 600;
        border-left-color: var(--primary-color);
    }

    @media (max-width: 768px) {
        .website-pages-layout {
            flex-direction: column;
        }
        .website-pages-sidebar {
            position: static;
            height: auto;
            overflow-y: visible;
        }
        .website-pages-list {
            overflow-y: visible;
        }
    }
</style>
@endsection

@section('content')
<div class="website-pages-layout">
    
    <!-- FULL HEIGHT SIDEBAR -->
    <div class="website-pages-sidebar">
        <div class="sidebar-header">
            <i class="fas fa-layer-group"></i> Website Pages
        </div>
        <ul class="website-pages-list">
            
            <!-- HOME DROPDOWN ITEM -->
            <li class="dropdown-menu-item">
                <button class="dropdown-toggle {{ request()->routeIs('admin.website.home.*') ? 'active' : '' }}" type="button">
                    <div style="display: flex; align-items: center;">
                        <div class="icon-box"><i class="fas fa-home"></i></div>
                        <span>Home</span>
                    </div>
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </button>
                
                <!-- Dropdown Menu -->
                <ul class="dropdown-menu {{ request()->routeIs('admin.website.home.*') ? 'show' : '' }}">
                    <li><a href="{{ route('admin.website.home.empowering-dreams') }}" class="{{ request()->routeIs('admin.website.home.empowering-dreams') ? 'active' : '' }}">Empowering Dreams</a></li>
                    <li><a href="{{ route('admin.website.home.key-instruction') }}" class="{{ request()->routeIs('admin.website.home.key-instruction') ? 'active' : '' }}">Key Instruction</a></li>
                    <li><a href="{{ route('admin.website.home.working-committee') }}" class="{{ request()->routeIs('admin.website.home.working-committee') ? 'active' : '' }}">Working Committee</a></li>
                    <li><a href="{{ route('admin.website.home.empowering-future') }}" class="{{ request()->routeIs('admin.website.home.empowering-future') ? 'active' : '' }}">Empowering Future</a></li>
                    <li><a href="{{ route('admin.website.home.achievement-impact') }}" class="{{ request()->routeIs('admin.website.home.achievement-impact') ? 'active' : '' }}">Achievement and Impact</a></li>
                    <li><a href="{{ route('admin.website.home.photo-gallery') }}" class="{{ request()->routeIs('admin.website.home.photo-gallery') ? 'active' : '' }}">Photo Gallery</a></li>
                    <li><a href="{{ route('admin.website.home.our-testimonial') }}" class="{{ request()->routeIs('admin.website.home.our-testimonial') ? 'active' : '' }}">Our Testimonial</a></li>
                    <li><a href="{{ route('admin.website.home.success-stories') }}" class="{{ request()->routeIs('admin.website.home.success-stories') ? 'active' : '' }}">Success Stories</a></li>
                </ul>
            </li>

            <!-- ABOUT US DROPDOWN ITEM (UPDATED) -->
            <li class="dropdown-menu-item">
                <button class="dropdown-toggle {{ request()->routeIs('admin.website.about.*') ? 'active' : '' }}" type="button">
                    <div style="display: flex; align-items: center;">
                        <div class="icon-box"><i class="fas fa-info-circle"></i></div>
                        <span>About Us</span>
                    </div>
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </button>
                
                <!-- Dropdown Menu -->
                <ul class="dropdown-menu {{ request()->routeIs('admin.website.about.*') ? 'show' : '' }}">
                    <li><a href="{{ route('admin.website.about.jito') }}" class="{{ request()->routeIs('admin.website.about.jito') ? 'active' : '' }}">Jito</a></li>
                    <li><a href="{{ route('admin.website.about.jeap') }}" class="{{ request()->routeIs('admin.website.about.jeap') ? 'active' : '' }}">Jeap</a></li>
                    <li><a href="{{ route('admin.website.about.board-of-directors') }}" class="{{ request()->routeIs('admin.website.about.board-of-directors') ? 'active' : '' }}">Board of Directors</a></li>
                    <li><a href="{{ route('admin.website.about.zone-chairmen') }}" class="{{ request()->routeIs('admin.website.about.zone-chairmen') ? 'active' : '' }}">Zone Chairmen</a></li>
                    <li><a href="{{ route('admin.website.about.testimonials-success') }}" class="{{ request()->routeIs('admin.website.about.testimonials-success') ? 'active' : '' }}">Our Testimonials / Success Story</a></li>
                </ul>
            </li>

            <!-- APPLICATION DROPDOWN ITEM -->
            <li class="dropdown-menu-item">
                <button class="dropdown-toggle {{ request()->routeIs('admin.website.application.*') ? 'active' : '' }}" type="button">
                    <div style="display: flex; align-items: center;">
                        <div class="icon-box"><i class="fas fa-file-alt"></i></div>
                        <span>Application</span>
                    </div>
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </button>
                
                <!-- Dropdown Menu -->
                <ul class="dropdown-menu {{ request()->routeIs('admin.website.application.*') ? 'show' : '' }}">
                    <li><a href="{{ route('admin.website.application.faqs') }}" class="{{ request()->routeIs('admin.website.application.faqs') ? 'active' : '' }}">FAQ's</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.website.contact') }}" class="{{ request()->routeIs('admin.website.contact') ? 'active' : '' }}">
                    <div class="icon-box"><i class="fas fa-phone-alt"></i></div>
                    <span>Contact</span>
                </a>
            </li>
            
           
            <li>
                <a href="{{ route('admin.website.university') }}" class="{{ request()->routeIs('admin.website.university') ? 'active' : '' }}">
                    <div class="icon-box"><i class="fas fa-university"></i></div>
                    <span>University</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.website.course') }}" class="{{ request()->routeIs('admin.website.course') ? 'active' : '' }}">
                    <div class="icon-box"><i class="fas fa-book"></i></div>
                    <span>Course</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.website.college') }}" class="{{ request()->routeIs('admin.website.college') ? 'active' : '' }}">
                    <div class="icon-box"><i class="fas fa-graduation-cap"></i></div>
                    <span>College</span>
                </a>
            </li>
        </ul>
    </div>
    
    <!-- Content Area -->
    <div class="website-pages-content">
        @yield('website-content')
    </div>
    
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    const sidebarList = document.querySelector('.website-pages-list');
    
    dropdownToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            
            const parentLi = this.closest('.dropdown-menu-item');
            const dropdownMenu = parentLi.querySelector('.dropdown-menu');
            const arrowIcon = this.querySelector('.arrow-icon');
            
            // Toggle the dropdown
            if (dropdownMenu) {
                dropdownMenu.classList.toggle('show');
                
                // FIX: Auto-scroll the sidebar if the dropdown opens
                if (dropdownMenu.classList.contains('show')) {
                    // Calculate the position of the dropdown relative to the scrollable area
                    // We use setTimeout to allow the CSS animation to start
                    setTimeout(() => {
                        // Scroll the specific item into view smoothly
                        parentLi.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 100);
                }
            }
            
            // Rotate arrow
            if (arrowIcon) {
                if (dropdownMenu.classList.contains('show')) {
                    arrowIcon.style.transform = 'rotate(180deg)';
                } else {
                    arrowIcon.style.transform = 'rotate(0deg)';
                }
            }
        });
    });

    // Auto-open and scroll if a child is active
    const dropdownMenus = document.querySelectorAll('.dropdown-menu');
    dropdownMenus.forEach(function(menu) {
        const activeLinks = menu.querySelectorAll('a.active');
        if (activeLinks.length > 0) {
            menu.classList.add('show');
            const toggleBtn = menu.previousElementSibling;
            if (toggleBtn && toggleBtn.classList.contains('dropdown-toggle')) {
                const arrow = toggleBtn.querySelector('.arrow-icon');
                if (arrow) arrow.style.transform = 'rotate(180deg)';
            }
        }
    });
});
</script>
@endsection