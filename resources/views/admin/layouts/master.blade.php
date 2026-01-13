<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JitoJeap Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #393185;
            --secondary-color: #E31E24;
            --success-color: #009846;
            --warning-color: #FBBA00;
            --dark-color: #000000;
            --light-color: #FFFFFF;
            --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
            --border-radius: 15px;
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 70px;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-collapsed-width);
            background: #29235f;
            color: white;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
            overflow: hidden;
        }

        .sidebar.expanded {
            width: var(--sidebar-width);
        }

        .sidebar.collapsed:hover {
            width: var(--sidebar-width);
        }

        .sidebar.collapsed:hover .nav-link {
            justify-content: flex-start;
            padding: 1rem 1.5rem;
            margin: 0 0.5rem;
        }

        .sidebar.collapsed:hover .nav-link i {
            margin-right: 12px;
            font-size: 1.3rem;
        }

        .sidebar.collapsed:hover .nav-text {
            opacity: 1;
            transform: translateX(0);
            position: static;
        }

        .sidebar.collapsed:hover .logo-text {
            opacity: 1;
            transform: translateY(0);
        }

        .sidebar.collapsed:hover .logo-container img {
            height: 50px;
            margin-bottom: 0.5rem;
        }

        .sidebar.collapsed:hover .toggle-text {
            opacity: 1;
        }

        .sidebar-header {
            padding: 2rem 1rem 1rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .logo-text {
            opacity: 0;
            transform: translateY(-10px);
        }

        .logo-container img {
            height: 50px;
            transition: all 0.3s ease;
            background: white;
            padding: 8px;
            border-radius: 12px;
            margin-bottom: 0.5rem;
        }

        .sidebar.collapsed .logo-container img {
            height: 35px;
            margin-bottom: 0;
        }

        .logo-text {
            font-size: 0.9rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }

        .sidebar-nav {
            padding: 2rem 0 1rem 0;
            height: calc(100vh - 140px);
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-toggle-btn {
            width: 100%;
            background: rgba(251, 186, 0, 0.1);
            border: 2px solid rgba(251, 186, 0, 0.3);
            color: white;
            padding: 0.75rem;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .sidebar-toggle-btn:hover {
            background: rgba(251, 186, 0, 0.2);
            border-color: var(--warning-color);
            transform: translateY(-2px);
        }

        .sidebar-toggle-btn i {
            margin-right: 8px;
            transition: transform 0.3s ease;
        }

        .sidebar.expanded .sidebar-toggle-btn i {
            transform: rotate(180deg);
        }

        .toggle-text {
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .toggle-text {
            opacity: 0;
        }

        .nav-item {
            margin-bottom: 0.25rem;
        }

        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            font-weight: 500;
            padding: 1rem 1.5rem;
            margin: 0 0.5rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 1rem 0.5rem;
            margin: 0 0.25rem;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(251, 186, 0, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .nav-link:hover::before {
            left: 100%;
        }

        .nav-link:hover {
            background-color: rgba(251, 186, 0, 0.15);
            color: white !important;
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(251, 186, 0, 0.2);
        }

        .sidebar.collapsed .nav-link:hover {
            transform: none;
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--warning-color) 0%, #e6a800 100%);
            color: var(--dark-color) !important;
            font-weight: 600;
            box-shadow: 0 4px 20px rgba(251, 186, 0, 0.4);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .nav-link.active::before {
            display: none;
        }

        .nav-link i {
            font-size: 1.3rem;
            margin-right: 12px;
            width: 24px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .nav-link i {
            margin-right: 0;
            font-size: 1.4rem;
        }

        .nav-text {
            transition: all 0.3s ease;
            white-space: nowrap;
            opacity: 1;
        }

        .sidebar.collapsed .nav-text {
            opacity: 0;
            transform: translateX(-10px);
            position: absolute;
            left: -9999px;
        }

        .main-content {
            margin-left: 70px;
            padding: 2rem;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }

        .dashboard-container {
            padding: 0;
        }

        .section-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            border: none;
            margin-bottom: 2rem;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .section-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #4a3fa5 100%);
            color: white;
            border: none;
            padding: 1.5rem;
            font-weight: 600;
            font-size: 1.25rem;
        }

        .card-body {
            padding: 2rem;
        }

        .btn-custom {
            background: linear-gradient(135deg, var(--primary-color) 0%, #4a3fa5 100%);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(57, 49, 133, 0.3);
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(57, 49, 133, 0.4);
            color: white;
        }

        .btn-success-custom {
            background: linear-gradient(135deg, var(--success-color) 0%, #00b855 100%);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 152, 70, 0.3);
        }

        .btn-success-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 152, 70, 0.4);
            color: white;
        }

        .btn-danger-custom {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #f9282e 100%);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(227, 30, 36, 0.3);
        }

        .btn-danger-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(227, 30, 36, 0.4);
            color: white;
        }

        .table {
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .table thead th {
            background: var(--primary-color);
            color: white;
            border: none;
            font-weight: 600;
            padding: 1rem;
        }

        .table tbody tr {
            transition: background-color 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(57, 49, 133, 0.05);
        }

        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.75rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(57, 49, 133, 0.25);
        }

        .badge-status-active {
            background: var(--success-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
        }

        .badge-status-inactive {
            background: var(--secondary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(0, 152, 70, 0.1) 0%, rgba(0, 184, 85, 0.1) 100%);
            border-left: 5px solid var(--success-color);
            color: var(--success-color);
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(227, 30, 36, 0.1) 0%, rgba(249, 40, 46, 0.1) 100%);
            border-left: 5px solid var(--secondary-color);
            color: var(--secondary-color);
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 70px;
                padding: 1rem;
            }

            .card-body {
                padding: 1.5rem;
            }
        }

        /* Mobile responsive styles for sidebar - Improved */
        @media (max-width: 992px) {
            /* Hide sidebar by default on mobile */
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 1050;
                width: 280px !important;
                height: 100vh;
                position: fixed;
                top: 0;
                left: 0;
                background: #29235f;
            }

            /* Show sidebar when active */
            .sidebar.active {
                transform: translateX(0);
            }

            /* Adjust main content when sidebar is active */
            .main-content {
                margin-left: 0 !important;
                transition: margin-left 0.3s ease;
            }

            /* Overlay when sidebar is open */
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1040;
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.3s ease, visibility 0.3s ease;
            }

            .sidebar-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            /* Mobile toggle button */
            .mobile-sidebar-toggle {
                position: fixed;
                top: 1rem;
                right: 1rem;
                z-index: 1060;
                background: #29235f;
                color: white;
                border: none;
                width: 40px;
                height: 40px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .mobile-sidebar-toggle:hover {
                background: #1a1542;
                transform: translateY(-2px);
            }

            /* Ensure proper sidebar styling on mobile */
            .sidebar-header {
                padding: 1.5rem;
                text-align: left;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .logo-container {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            }

            .logo-container img {
                height: 50px !important;
                margin-bottom: 0.5rem !important;
                background: white;
                padding: 8px;
                border-radius: 12px;
            }

            .logo-text {
                font-size: 1rem;
                font-weight: 600;
                color: white;
                opacity: 1 !important;
                transform: none !important;
            }

            .sidebar-nav {
                padding: 1rem 0;
                height: calc(100vh - 120px);
                overflow-y: auto;
            }

            .nav-item {
                margin-bottom: 0.25rem;
                padding: 0 0.5rem;
            }

            .nav-link {
                color: rgba(255, 255, 255, 0.8) !important;
                font-weight: 500;
                padding: 1rem 1.5rem;
                margin: 0 0.5rem;
                border-radius: 12px;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                text-decoration: none;
                justify-content: flex-start !important;
                width: 100% !important;
            }

            .nav-link:hover {
                background-color: rgba(251, 186, 0, 0.15);
                color: white !important;
                transform: none !important;
                box-shadow: none !important;
            }

            .nav-link.active {
                background: linear-gradient(135deg, var(--warning-color) 0%, #e6a800 100%);
                color: var(--dark-color) !important;
                font-weight: 600;
                box-shadow: 0 4px 20px rgba(251, 186, 0, 0.4);
            }

            .nav-link i {
                font-size: 1.3rem;
                margin-right: 12px !important;
                width: 24px;
                text-align: center;
            }

            .nav-text {
                opacity: 1 !important;
                transform: none !important;
                position: static !important;
                left: auto !important;
                white-space: nowrap;
            }

            /* Dashboard button styling for mobile - only when active */
            .nav-item:first-child .nav-link.active {
                background: var(--warning-color);
                color: var(--dark-color) !important;
                margin: 0 0.5rem 0.5rem;
                font-weight: 600;
            }

            .nav-item:first-child .nav-link.active i {
                margin-right: 12px;
            }

            /* Hide the expand/collapse button on mobile */
            .sidebar-footer {
                display: none;
            }

            /* Scrollbar styling for mobile sidebar */
            .sidebar-nav::-webkit-scrollbar {
                width: 5px;
            }

            .sidebar-nav::-webkit-scrollbar-thumb {
                background-color: rgba(255, 255, 255, 0.2);
                border-radius: 5px;
            }

            .sidebar-nav::-webkit-scrollbar-track {
                background-color: rgba(255, 255, 255, 0.1);
            }
        }

        /* Desktop styles (unchanged) */
        @media (min-width: 993px) {
            .mobile-sidebar-toggle {
                display: none;
            }

            .sidebar-overlay {
                display: none;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <header>
        <!-- Sidebar -->
        <div class="sidebar collapsed" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <img src="{{ asset('jitojeaplogo.png') }}" alt="JitoJeap Logo">
                <span class="logo-text">JitoJeap Admin</span>
            </div>
        </div>
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'admin.home' ? 'active' : '' }}" href="{{ route('admin.home') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ str_contains(Route::currentRouteName() ?? '', 'admin.apex') ? 'active' : '' }}" href="{{ route('admin.apex.index') }}">
                        <i class="fas fa-users"></i>
                        <span class="nav-text">Apex Leadership</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ str_contains(Route::currentRouteName() ?? '', 'admin.committee') ? 'active' : '' }}" href="{{ route('admin.committee.index') }}">
                        <i class="fas fa-user-tie"></i>
                        <span class="nav-text">Working Committee</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ str_contains(Route::currentRouteName() ?? '', 'admin.zones') ? 'active' : '' }}" href="{{ route('admin.zones.index') }}">
                        <i class="fas fa-globe"></i>
                        <span class="nav-text">Zone</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ str_contains(Route::currentRouteName() ?? '', 'admin.chapters') ? 'active' : '' }}" href="{{ route('admin.chapters.index') }}">
                        <i class="fas fa-map-marker-alt"></i>
                        <span class="nav-text">Chapter</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ str_contains(Route::currentRouteName() ?? '', 'admin.pincodes') ? 'active' : '' }}" href="{{ route('admin.pincodes.index') }}">
                        <i class="fas fa-thumbtack"></i>
                        <span class="nav-text">Pincodes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ str_contains(Route::currentRouteName() ?? '', 'admin.initiatives') ? 'active' : '' }}" href="{{ route('admin.initiatives.index') }}">
                        <i class="fas fa-lightbulb"></i>
                        <span class="nav-text">Initiatives</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="nav-text">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <button class="sidebar-toggle-btn" id="sidebarToggle">
                <i class="fas fa-chevron-right"></i>
                <span class="toggle-text">Expand</span>
            </button>
        </div>
    </div>
    </header>

    <div class="main-content">
        <div class="dashboard-container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle functionality
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.querySelector('.main-content');
            const toggleBtn = document.getElementById('sidebarToggle');
            const toggleIcon = toggleBtn.querySelector('i');
            const toggleText = toggleBtn.querySelector('.toggle-text');

            // Toggle between collapsed and expanded states
            if (sidebar.classList.contains('collapsed')) {
                // Expand sidebar
                sidebar.classList.remove('collapsed');
                sidebar.classList.add('expanded');
                toggleIcon.classList.remove('fa-chevron-right');
                toggleIcon.classList.add('fa-chevron-left');
                if (toggleText) toggleText.textContent = 'Collapse';
                if (mainContent) {
                    mainContent.style.marginLeft = '280px';
                }
            } else {
                // Collapse sidebar
                sidebar.classList.remove('expanded');
                sidebar.classList.add('collapsed');
                toggleIcon.classList.remove('fa-chevron-left');
                toggleIcon.classList.add('fa-chevron-right');
                if (toggleText) toggleText.textContent = 'Expand';
                if (mainContent) {
                    mainContent.style.marginLeft = '70px';
                }
            }
        }

        // Initialize sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.querySelector('.main-content');
            const toggleBtn = document.getElementById('sidebarToggle');
            const toggleIcon = toggleBtn.querySelector('i');
            const toggleText = toggleBtn.querySelector('.toggle-text');

            // Set initial collapsed state
            if (sidebar.classList.contains('collapsed')) {
                toggleIcon.classList.remove('fa-chevron-left');
                toggleIcon.classList.add('fa-chevron-right');
                if (toggleText) toggleText.textContent = 'Expand';
                if (mainContent) {
                    mainContent.style.marginLeft = '70px';
                }
            }

            // Add event listener to sidebar toggle button
            toggleBtn.addEventListener('click', toggleSidebar);

            // Add hover event listeners for content adjustment
            sidebar.addEventListener('mouseenter', function() {
                if (sidebar.classList.contains('collapsed') && mainContent) {
                    mainContent.style.marginLeft = '280px';
                }
            });

            sidebar.addEventListener('mouseleave', function() {
                if (sidebar.classList.contains('collapsed') && mainContent) {
                    mainContent.style.marginLeft = '70px';
                }
            });

            // Mobile sidebar functionality
            const mobileToggle = document.createElement('button');
            mobileToggle.className = 'mobile-sidebar-toggle';
            mobileToggle.innerHTML = '<i class="fas fa-bars"></i>';
            document.body.prepend(mobileToggle);

            const overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            document.body.prepend(overlay);

            mobileToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            });

            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });

            // Close sidebar when clicking on a nav link (mobile)
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 992) {
                        sidebar.classList.remove('active');
                        overlay.classList.remove('active');
                    }
                });
            });
        });
    </script>
    @yield('scripts')
    </footer>

</body>
</html>
