<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        /* ===== SIDEBAR COLLAPSIBLE ===== */
        #sidebar {
            width: 240px;
            transition: width 0.25s ease;
            overflow: hidden;
            flex-shrink: 0;
        }
        #sidebar.collapsed { width: 68px; }

        #sidebar.collapsed .sb-label,
        #sidebar.collapsed .sb-chevron,
        #sidebar.collapsed .sb-brand { display: none; }

        #sidebar.collapsed .nav-item {
            justify-content: center;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        #sidebar.collapsed .sb-header-inner { justify-content: center; }
        #sidebar.collapsed #toggleBtn { margin-left: 0; }
        #toggleIcon { transition: transform 0.25s ease; }
        #sidebar.collapsed #toggleIcon { transform: rotate(180deg); }

        /* Tooltip */
        .sb-tooltip {
            position: absolute;
            left: calc(100% + 10px);
            top: 50%;
            transform: translateY(-50%);
            background: #1D0C36;
            color: #fff;
            font-size: 12px;
            font-weight: 500;
            padding: 5px 12px;
            border-radius: 8px;
            white-space: nowrap;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.15s;
            z-index: 999;
            border: 0.5px solid rgba(139, 92, 246, 0.3);
        }
        #sidebar.collapsed .nav-item:hover .sb-tooltip { opacity: 1; }

        #main-content {
            margin-left: 240px;
            transition: margin-left 0.25s ease;
            min-width: 0;
            flex: 1;
        }

        /* Scrollbar */
        .scrollbar-thin { scrollbar-width: thin; scrollbar-color: #4b5563 #27124A; }
        .scrollbar-thin::-webkit-scrollbar { width: 4px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: #1D0C36; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background-color: #6D28D9; border-radius: 3px; }

        html { scroll-behavior: smooth; }

        .nav-item { transition: all 0.15s ease; }
        .nav-item.active { background: linear-gradient(to right, #3A1B6E, #6D28D9); }

        .modal-enter { animation: modalFadeIn 0.2s ease-out; }
        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        .user-avatar-btn { transition: all 0.2s ease; }
        .user-avatar-btn:hover { transform: scale(1.05); box-shadow: 0 0 0 3px #8B5CF6; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <div id="sidebar" class="bg-primary text-white flex flex-col fixed h-full z-20 shadow-lg">

            <!-- Header: Logo + Toggle -->
            <div class="border-b border-primary-dark px-3 py-3.5" style="min-height: 60px;">
                <div class="sb-header-inner flex items-center gap-3">
                    <img src="{{ asset('images/logo/trax.png') }}" alt="TraxFit Logo" class="w-9 h-9 object-contain flex-shrink-0">
                    <div class="sb-brand overflow-hidden">
                        <h1 class="text-sm font-bold tracking-tight whitespace-nowrap">TraxFit</h1>
                        <p class="text-gray-400 text-xs whitespace-nowrap">Gym Management</p>
                    </div>
                    <button id="toggleBtn" onclick="toggleSidebar()"
                        class="ml-auto flex-shrink-0 w-7 h-7 rounded-lg flex items-center justify-center transition-colors"
                        style="background: rgba(255,255,255,0.08);"
                        onmouseover="this.style.background='rgba(255,255,255,0.15)'"
                        onmouseout="this.style.background='rgba(255,255,255,0.08)'">
                        <i id="toggleIcon" class="fas fa-chevron-left text-gray-400" style="font-size: 11px;"></i>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto overflow-x-hidden scrollbar-thin py-3 px-2">
                @yield('sidebar')
            </nav>
        </div>

        <!-- Main Content -->
        <div id="main-content" class="flex flex-col h-screen">

            <!-- Top Bar -->
            <div class="bg-white shadow-sm border-b border-gray-200 flex-shrink-0">
                <div class="px-6 py-3 flex justify-between items-center">
                    <div>
                        <h1 class="text-lg font-semibold text-gray-800">@yield('page-title')</h1>
                        <p class="text-xs text-gray-500 mt-0.5">Dashboard / @yield('page-title')</p>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div class="text-sm text-gray-600 bg-gray-100 px-3 py-1.5 rounded-lg">
                            <i class="far fa-calendar mr-2 text-accent"></i>{{ now()->format('d M Y') }}
                        </div>

                        <div class="flex items-center space-x-2">
                            <div class="text-right">
                                <div class="text-sm font-medium text-gray-700">{{ Auth::user()->nama }}</div>
                                <div class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</div>
                            </div>
                            @if(Auth::user()->role === 'owner')
                                <a href="{{ route('owner.profile') }}" title="Edit Profil"
                                   class="user-avatar-btn w-8 h-8 bg-gradient-to-r from-accent to-secondary rounded-full flex items-center justify-center text-white">
                                    <i class="fas fa-user text-sm"></i>
                                </a>
                            @else
                                <div class="w-8 h-8 bg-gradient-to-r from-accent to-secondary rounded-full flex items-center justify-center text-white">
                                    <i class="fas fa-user text-sm"></i>
                                </div>
                            @endif
                        </div>

                        <form method="POST" action="{{ route('logout') }}" id="logoutForm" class="inline">
                            @csrf
                            <button type="button" id="logoutBtn" class="p-2 rounded-xl hover:bg-red-50 text-gray-600 hover:text-red-600 transition-colors">
                                <i class="fas fa-sign-out-alt text-lg"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Logout Modal -->
    <div id="logoutModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 modal-enter">
            <div class="p-6">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-sign-out-alt text-red-600 text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-center text-gray-800 mb-2">Konfirmasi Logout</h3>
                <p class="text-center text-gray-600 mb-6">Apakah Anda yakin ingin keluar dari sistem?</p>
                <div class="flex gap-3">
                    <button type="button" id="cancelLogoutBtn" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">Batal</button>
                    <button type="button" id="confirmLogoutBtn" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">Keluar</button>
                </div>
            </div>
        </div>
    </div>

    @yield('scripts')

    <script>
        const sidebar     = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');

        function toggleSidebar() {
            const collapsed = sidebar.classList.toggle('collapsed');
            mainContent.style.marginLeft = collapsed ? '68px' : '240px';
            localStorage.setItem('sidebarCollapsed', collapsed ? '1' : '0');
        }

        // Restore state
        (function () {
            if (localStorage.getItem('sidebarCollapsed') === '1') {
                sidebar.classList.add('collapsed');
                mainContent.style.marginLeft = '68px';
            }
        })();

        // Logout Modal
        const logoutModal = document.getElementById('logoutModal');
        document.getElementById('logoutBtn')?.addEventListener('click', () => {
            logoutModal.classList.replace('hidden', 'flex');
        });
        document.getElementById('cancelLogoutBtn')?.addEventListener('click', () => {
            logoutModal.classList.replace('flex', 'hidden');
        });
        logoutModal?.addEventListener('click', (e) => {
            if (e.target === logoutModal) logoutModal.classList.replace('flex', 'hidden');
        });
        document.getElementById('confirmLogoutBtn')?.addEventListener('click', () => {
            document.getElementById('logoutForm').submit();
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && logoutModal.classList.contains('flex'))
                logoutModal.classList.replace('flex', 'hidden');
        });
    </script>
</body>
</html>