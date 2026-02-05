<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="{{ asset('logosmk.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 70px;
            --primary-color: #10b981;
            --sidebar-bg: linear-gradient(170deg, #059669 0%, #047857 100%);
            --topbar-bg: #059669;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .pagination .page-link:hover {
            background-color: #047857;
            border-color: #047857;
            color: white;
        }

        .pagination .page-link {
            color: var(--primary-color);
        }

        body {
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: white;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 3px 0 10px rgba(0,0,0,0.1);
            overflow-y: auto;
            /* Hide scrollbar */
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }

        /* Hide scrollbar for Webkit browsers (Chrome, Safari, Opera) */
        .sidebar::-webkit-scrollbar {
            display: none;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar .sidebar-header {
            padding: 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar.collapsed .sidebar-header-content {
            display: none;
        }

        .sidebar-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .sidebar-logo img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            margin-bottom: 10px;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.3);
            padding: 5px;
        }

        .sidebar.collapsed .sidebar-logo {
            align-items: center;
            padding: 10px 5px;
            justify-content: center;
        }

        .sidebar.collapsed .sidebar-logo img {
            width: 40px;
            height: 40px;
            margin: 5px auto 10px;
            padding: 3px;
        }

        .sidebar-title h3 {
            margin: 5px 0;
            font-size: 1.4rem;
            font-weight: 700;
        }

        .sidebar-title p {
            margin: 0;
            font-size: 0.85rem;
            opacity: 0.8;
        }

        .sidebar.collapsed .sidebar-title {
            display: none;
        }

        .sidebar ul {
            list-style: none;
            padding: 15px 0;
            margin: 0;
        }

        .sidebar ul li {
            margin-bottom: 5px;
        }

        .sidebar ul li a {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            font-weight: 500;
        }

        .sidebar ul li a:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
            border-left-color: white;
        }

        .sidebar ul li a i {
            width: 24px;
            text-align: center;
            margin-right: 12px;
            font-size: 1.1rem;
        }

        .sidebar.collapsed ul li a span {
            display: none;
        }

        .sidebar.collapsed ul li a {
            justify-content: center;
            padding: 15px 5px;
        }

        .sidebar.collapsed ul li a i {
            margin-right: 0;
        }

        /* Topbar Styles */
        .topbar {
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            height: 60px;
            background-color: var(--topbar-bg);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 999;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .topbar.sidebar-collapsed {
            left: var(--sidebar-collapsed-width);
        }

        .topbar button {
            background-color: rgba(255,255,255,0.15);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .topbar button:hover {
            background-color: rgba(255,255,255,0.25);
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* Main Content Styles */
        .main-content {
            margin-top: 60px;
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: all 0.3s ease;
        }

        .main-content.expanded {
            margin-left: var(--sidebar-collapsed-width);
        }

        .container-fluid {
            padding-top: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #f5c6cb;
        }

        /* Responsive design */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .topbar {
                left: 0;
                width: 100%;
            }

            .main-content {
                margin-left: 0;
                padding: 20px 15px;
            }

            .main-content.expanded {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: block !important;
            }

            /* Mobile-specific layout adjustments */
            .container-fluid {
                padding: 10px 5px;
            }

            /* Adjust stat cards for mobile */
            .stat-card {
                margin-bottom: 10px;
            }

            /* Adjust book cards for mobile */
            .col-md-3 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            /* Adjust activity columns for mobile */
            .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .activity-item {
                flex-direction: column;
                text-align: center;
            }

            .activity-icon {
                margin-bottom: 10px;
            }

            /* Adjust buttons for mobile */
            .btn-sm {
                padding: 8px 12px;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 100%;
            }

            .topbar {
                height: 50px;
                padding: 0 15px;
            }

            .topbar-user .user-info {
                display: none;
            }

            .main-content {
                margin-top: 50px;
                padding: 15px 10px;
            }

            .display-5 {
                font-size: 1.5rem !important;
            }

            .h3 {
                font-size: 1.3rem !important;
            }

            .card, .books-card, .activity-card {
                margin-bottom: 15px;
            }
        }

        .mobile-menu-btn {
            display: none;
        }

        /* Animation for sidebar items */
        .sidebar ul li {
            opacity: 0;
            transform: translateX(-20px);
            animation: slideIn 0.3s forwards;
        }

        .sidebar ul li:nth-child(1) { animation-delay: 0.1s; }
        .sidebar ul li:nth-child(2) { animation-delay: 0.2s; }
        .sidebar ul li:nth-child(3) { animation-delay: 0.3s; }
        .sidebar ul li:nth-child(4) { animation-delay: 0.4s; }
        .sidebar ul li:nth-child(5) { animation-delay: 0.5s; }
        .sidebar ul li:nth-child(6) { animation-delay: 0.6s; }
        .sidebar ul li:nth-child(7) { animation-delay: 0.7s; }
        .sidebar ul li:nth-child(8) { animation-delay: 0.8s; }
        .sidebar ul li:nth-child(9) { animation-delay: 0.9s; }

        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Active link styling */
        .sidebar ul li a.active {
            background-color: rgba(255,255,255,0.15);
            color: white;
            border-left-color: white;
            font-weight: 600;
        }

        /* Dropdown menu styling - Profil Saya and Logout */
        .dropdown-menu .dropdown-item {
            color: var(--primary-color);
            background-color: white !important;
            transition: all 0.2s ease;
        }

        .dropdown-menu .dropdown-item:hover {
            color: white;
            background-color: var(--primary-color) !important;
        }

        .dropdown-menu .dropdown-item i {
            color: var(--primary-color);
            transition: all 0.2s ease;
        }

        .dropdown-menu .dropdown-item:hover i {
            color: white;
        }
    </style>
</head>
<body>

    {{-- Sidebar --}}
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <img src="{{ asset('logosmk.png') }}" alt="LITAZ Library Logo">
                <div class="sidebar-title">
                    <h3>LITAZ</h3>
                    <p>Library Tazakka</p>
                </div>
            </div>
        </div>
        <ul>
            <li>
                <a href="{{ route('beranda') }}" class="{{ request()->routeIs('beranda') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> <span>Beranda</span>
                </a>
            </li>
            <li>
                <a href="{{ route('indexbuku') }}" class="{{ request()->routeIs('indexbuku') ? 'active' : '' }}">
                    <i class="fas fa-book-open"></i> <span>Koleksi Buku</span>
                </a>
            </li>
            @if(Auth::user()->role == 1)
            <li>
                <a href="{{ route('user.peminjaman') }}" class="{{ request()->routeIs('user.peminjaman') ? 'active' : '' }}">
                    <i class="fas fa-book-reader"></i> <span>Peminjaman Saya</span>
                </a>
            </li>
            @endif
            @if(Auth::user()->role == 0)
            <li>
                <a href="{{ route('peminjaman.index') }}" class="{{ request()->routeIs('peminjaman*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i> <span>Daftar Peminjaman</span>
                </a>
            </li>
            @endif
            @if(Auth::user()->role == 0)
            <li>
                <a href="{{ route('anggotaindex') }}" class="{{ request()->routeIs('anggotaindex*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> <span>Daftar Anggota</span>
                </a>
            </li>
            @endif
            @if(Auth::user()->role == 0)
            <li>
                <a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> <span>Kelola Kategori</span>
                </a>
            </li>
            @endif
            @if(Auth::user()->role == 0)
            <li>
                <a href="{{ route('bidangkajian.index') }}" class="{{ request()->routeIs('bidangkajian*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group"></i> <span>Kelola Bidang Kajian</span>
                </a>
            </li>
            @endif
            @if(Auth::user()->role == 0)
            <li>
                <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i> <span>Laporan</span>
                </a>
            </li>
            @endif
        </ul>
    </div>

    {{-- Topbar --}}
    <div class="topbar">
        <button class="mobile-menu-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <div class="topbar-user d-flex align-items-center gap-3">
            <div class="dropdown">
                <a class="dropdown-toggle d-flex align-items-center text-white text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar me-2">
                        {{ strtoupper(substr(Auth::user()->nama ?? 'U', 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <span>Halo, {{ Auth::user()->nama ?? 'User' }}</span>
                    </div>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profil.index') }}"><i class="fas fa-user me-2"></i>Profil Saya</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="main-content">
        <div class="container-fluid">

            {{-- Alerts --}}
            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert-error">{{ session('error') }}</div>
            @endif

            {{-- Content Section --}}
            @yield('content')

            {{-- Table Section --}}
            @yield('table')
        </div>
    </div>

    {{-- Modal --}}
    @yield('modal')

    {{-- Scripts --}}
    @yield('scripts')

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const topbar = document.querySelector('.topbar');
            const mainContent = document.querySelector('.main-content');
            const menuBtn = document.querySelector('.mobile-menu-btn');

            // Check if we're on mobile view
            if (window.innerWidth <= 992) {
                // Toggle the active class
                sidebar.classList.toggle('active');

                // Update icon based on the new state after toggling
                setTimeout(() => {
                    if (sidebar.classList.contains('active')) {
                        menuBtn.innerHTML = '<i class="fas fa-times"></i>';
                    } else {
                        menuBtn.innerHTML = '<i class="fas fa-bars"></i>';
                    }
                }, 0);
            } else {
                sidebar.classList.toggle('collapsed');
                topbar.classList.toggle('sidebar-collapsed');
                mainContent.classList.toggle('expanded');

                // Reset mobile menu icon for desktop view
                menuBtn.innerHTML = '<i class="fas fa-bars"></i>';
            }
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const menuBtn = document.querySelector('.mobile-menu-btn');
            const isMobileView = window.innerWidth <= 992;

            if (isMobileView &&
                sidebar.classList.contains('active') &&
                !sidebar.contains(event.target) &&
                !menuBtn.contains(event.target)) {
                sidebar.classList.remove('active');
                // Use setTimeout to ensure DOM update happens after class removal
                setTimeout(() => {
                    menuBtn.innerHTML = '<i class="fas fa-bars"></i>';
                }, 0);
            }
        });

        // Close sidebar when clicking on sidebar links on mobile
        document.querySelectorAll('.sidebar ul li a').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 992) {
                    const sidebar = document.querySelector('.sidebar');
                    sidebar.classList.remove('active');
                    const menuBtn = document.querySelector('.mobile-menu-btn');
                    // Use setTimeout to ensure DOM update happens after class removal
                    setTimeout(() => {
                        menuBtn.innerHTML = '<i class="fas fa-bars"></i>';
                    }, 0);
                }
            });
        });

        // Update layout on window resize
        window.addEventListener('resize', function() {
            const sidebar = document.querySelector('.sidebar');
            const topbar = document.querySelector('.topbar');
            const mainContent = document.querySelector('.main-content');
            const menuBtn = document.querySelector('.mobile-menu-btn');

            if (window.innerWidth > 992) {
                // Desktop view - reset mobile classes
                sidebar.classList.remove('active');
                sidebar.classList.remove('collapsed'); // Keep sidebar expanded in desktop
                topbar.classList.remove('sidebar-collapsed');
                mainContent.classList.remove('expanded');

                // Reset mobile menu icon for desktop view
                setTimeout(() => {
                    menuBtn.innerHTML = '<i class="fas fa-bars"></i>';
                }, 0);
            } else {
                // Mobile view - collapse sidebar
                sidebar.classList.remove('collapsed');
                sidebar.classList.remove('active'); // Start with closed sidebar
                topbar.classList.remove('sidebar-collapsed');
                mainContent.classList.remove('expanded');

                // Show hamburger icon for new mobile view
                setTimeout(() => {
                    menuBtn.innerHTML = '<i class="fas fa-bars"></i>';
                }, 0);
            }
        });

        // Add active class to current page
        document.addEventListener('DOMContentLoaded', function() {
            const currentUrl = window.location.href;
            const sidebarLinks = document.querySelectorAll('.sidebar ul li a');

            sidebarLinks.forEach(link => {
                if (link.href === currentUrl) {
                    link.classList.add('active');
                }
            });

            // Initialize layout based on screen size
            if (window.innerWidth <= 992) {
                const sidebar = document.querySelector('.sidebar');
                sidebar.classList.remove('active'); // Start with closed sidebar
                const menuBtn = document.querySelector('.mobile-menu-btn');
                setTimeout(() => {
                    menuBtn.innerHTML = '<i class="fas fa-bars"></i>';
                }, 0);
            }
        });
    </script>
</body>
</html>
