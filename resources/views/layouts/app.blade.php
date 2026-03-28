<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>@yield('title') - TraxFit Gym</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#27124A',
                        'primary-light': '#3A1B6E',
                        'primary-dark': '#1D0C36',
                        'secondary': '#6D28D9',
                        'accent': '#8B5CF6',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ===== SCROLLBAR ===== */
        .scrollbar-thin {
            scrollbar-width: thin;
            scrollbar-color: #4b5563 #27124A;
        }
        .scrollbar-thin::-webkit-scrollbar { width: 6px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: #1D0C36; }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: #6D28D9;
            border-radius: 3px;
        }

        html { scroll-behavior: smooth; }

        /* ===== NAV ITEM ===== */
        .nav-item {
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .nav-item.active {
            background: linear-gradient(to right, #3A1B6E, #6D28D9);
            color: white;
        }
        .nav-item.active i { color: #8B5CF6; }

        /* ===== SIDEBAR TRANSITION ===== */
        #sidebar {
            transition: width 0.3s ease-in-out, transform 0.3s ease-in-out;
            width: 256px; /* w-64 */
        }
        #sidebar.collapsed {
            width: 80px; /* w-20 */
        }

        /* ===== MAIN CONTENT TRANSITION ===== */
        #mainContent {
            transition: margin-left 0.3s ease-in-out;
            margin-left: 256px;
        }
        #mainContent.collapsed {
            margin-left: 80px;
        }

        /* ===== TOOLTIP saat collapsed ===== */
        .nav-tooltip {
            position: relative;
        }
        .nav-tooltip[data-tooltip]:not([data-tooltip=""]):hover::after {
            content: attr(data-tooltip);
            position: absolute;
            left: calc(100% + 8px);
            top: 50%;
            transform: translateY(-50%);
            background-color: #1D0C36;
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 999;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            pointer-events: none;
            border: 1px solid #3A1B6E;
        }

        /* ===== MOBILE ===== */
        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-100%);
                width: 256px !important;
                position: fixed;
                z-index: 40;
            }
            #sidebar.mobile-open {
                transform: translateX(0);
            }
            #mainContent {
                margin-left: 0 !important;
            }
            .nav-tooltip[data-tooltip]:not([data-tooltip=""]):hover::after {
                display: none;
            }
        }

        /* ===== OVERLAY MOBILE ===== */
        #mobileOverlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 30;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        #mobileOverlay.active {
            display: block;
            opacity: 1;
        }

        /* ===== COLLAPSED ICON CENTERING ===== */
        #sidebar.collapsed .nav-item {
            justify-content: center;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        #sidebar.collapsed .sidebar-logo-text,
        #sidebar.collapsed .nav-label,
        #sidebar.collapsed .nav-chevron,
        #sidebar.collapsed .toggle-label {
            display: none !important;
        }
        #sidebar.collapsed .sidebar-logo {
            justify-content: center;
        }
        #sidebar.collapsed #toggleIcon {
            transform: rotate(180deg);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">

        <!-- ===== SIDEBAR ===== -->
        <div id="sidebar"
             class="bg-primary text-white flex flex-col fixed h-full z-20 shadow-lg overflow-hidden">

            <!-- Logo -->
            <div class="p-5 border-b border-primary-dark flex-shrink-0">
                <div class="sidebar-logo flex items-center space-x-3">
                    <img src="{{ asset('images/logo/trax.png') }}" alt="TraxFit Logo"
                         class="w-10 h-10 object-contain flex-shrink-0">
                    <div class="sidebar-logo-text overflow-hidden">
                        <h1 class="text-xl font-bold tracking-tight">TraxFit</h1>
                        <p class="text-gray-400 text-xs mt-0.5">Gym Management</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto scrollbar-thin py-4">
                @yield('sidebar')
            </nav>

            <!-- Toggle Button Desktop -->
            <div class="p-4 border-t border-primary-dark flex-shrink-0">
                <button onclick="toggleSidebar()"
                        class="w-full py-2 px-3 rounded-lg bg-primary-light hover:bg-primary-dark transition-colors flex items-center justify-center gap-2 text-sm">
                    <i id="toggleIcon" class="fas fa-chevron-left transition-transform duration-300"></i>
                    <span class="toggle-label">Perkecil</span>
                </button>
            </div>
        </div>

        <!-- Mobile Overlay -->
        <div id="mobileOverlay" onclick="closeMobileMenu()"></div>

        <!-- ===== MAIN CONTENT ===== -->
        <div id="mainContent" class="flex-1 flex flex-col h-screen overflow-hidden">

            <!-- Top Bar -->
            <div class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-10">
                <div class="px-4 sm:px-8 py-3 flex justify-between items-center">

                    <!-- Left: Mobile Menu Button & Title -->
                    <div class="flex items-center space-x-3">
                        <!-- Tombol hamburger hanya muncul di mobile -->
                        <button onclick="openMobileMenu()"
                                class="md:hidden p-2 rounded-lg hover:bg-gray-100 text-gray-600 focus:outline-none">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <div>
                            <h1 class="text-lg sm:text-xl font-semibold text-gray-800">@yield('page-title')</h1>
                            <p class="text-xs text-gray-500 mt-0.5 hidden sm:block">
                                Dashboard / @yield('page-title')
                            </p>
                        </div>
                    </div>

                    <!-- Right: User Info & Logout -->
                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <!-- Date -->
                        <div class="hidden sm:flex text-sm text-gray-600 bg-gray-100 px-3 py-1.5 rounded-lg">
                            <i class="far fa-calendar mr-2 text-accent"></i>{{ now()->format('d M Y') }}
                        </div>

                        <!-- User Profile -->
                        <div class="flex items-center space-x-2 sm:space-x-3">
                            <div class="text-right hidden sm:block">
                                <div class="text-sm font-medium text-gray-700">{{ Auth::user()->nama }}</div>
                                <div class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</div>
                            </div>
                            <div class="w-8 h-8 bg-gradient-to-r from-accent to-secondary rounded-full flex items-center justify-center text-white flex-shrink-0">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                        </div>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}" class="inline" id="logoutForm">
                            @csrf
                            <button type="button" id="logoutBtn"
                                    class="p-2 rounded-xl hover:bg-red-50 text-gray-600 hover:text-red-600 transition-colors">
                                <i class="fas fa-sign-out-alt text-xl"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-3 sm:p-6 bg-gray-50">
                <div class="bg-white rounded-xl shadow-sm p-3 sm:p-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @yield('scripts')

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        // ===== SIDEBAR STATE =====
        let isCollapsed = false;
        let isMobile = window.innerWidth < 768;

        // Load saved state
        const saved = localStorage.getItem('sidebarCollapsed');
        if (saved !== null && !isMobile) {
            isCollapsed = JSON.parse(saved);
            applySidebarState();
        }

        function applySidebarState() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const navItems = document.querySelectorAll('.nav-item');

            if (isCollapsed && !isMobile) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('collapsed');
            } else {
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('collapsed');
            }

            // Update tooltip visibility on nav items
            updateTooltips();
        }

        function updateTooltips() {
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                const tooltip = item.getAttribute('data-tooltip-text');
                if (tooltip) {
                    item.setAttribute('data-tooltip', isCollapsed && !isMobile ? tooltip : '');
                }
            });
        }

        function toggleSidebar() {
            if (!isMobile) {
                isCollapsed = !isCollapsed;
                localStorage.setItem('sidebarCollapsed', JSON.stringify(isCollapsed));
                applySidebarState();
            }
        }

        function openMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.add('mobile-open');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Responsive check
        window.addEventListener('resize', () => {
            const wasMobile = isMobile;
            isMobile = window.innerWidth < 768;
            if (wasMobile !== isMobile) {
                if (isMobile) {
                    closeMobileMenu();
                }
                applySidebarState();
            }
        });

        // Logout confirmation
        document.getElementById('logoutBtn')?.addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                document.getElementById('logoutForm').submit();
            }
        });
    </script>
</body>
</html>