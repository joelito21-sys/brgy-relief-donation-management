<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard - ' . config('app.name'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .sidebar {
            width: 260px;
            transition: all 0.3s;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 1000;
        }
        .main-content {
            margin-left: 260px;
            transition: all 0.3s;
            min-height: 100vh;
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            padding-left: 0;
            box-sizing: border-box;
        }
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
        }
        .sidebar-item {
            transition: all 0.2s;
        }
        .sidebar-item:hover {
            background: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }
        .sidebar-item.active {
            background: rgba(255,255,255,0.2);
            border-left: 4px solid #fff;
        }
        .stat-card {
            transition: all 0.3s;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
        }
        .action-btn {
            transition: all 0.2s;
        }
        .action-btn:hover {
            transform: scale(1.05);
        }
        /* Fix text contrast issues */
        .text-gray-600 {
            color: #4b5563 !important;
        }
        .text-gray-800 {
            color: #1f2937 !important;
        }
        .text-gray-900 {
            color: #111827 !important;
        }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-blue-600">
    <!-- Sidebar -->
    <div class="sidebar text-white shadow-2xl" id="sidebar">
        <div class="p-6">
            <!-- Logo -->
            <div class="flex items-center justify-between mb-8">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <i class="fas fa-shield-alt text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">Barangay Cubacub Relief and Donation Management Program</h1>
                        <p class="text-xs text-purple-200">Admin Panel</p>
                    </div>
                </a>
                <button class="lg:hidden text-white" id="closeSidebar">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                
                <div class="pt-2 pb-1">
                    <p class="text-xs text-purple-200 uppercase tracking-wider px-4">Management</p>
                </div>
                
                <a href="{{ route('admin.residents.index') }}" class="sidebar-item flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.residents.*') ? 'active' : '' }}">
                    <i class="fas fa-users w-5 mr-3"></i>
                    <span>Resident Management</span>
                </a>
                
                <a href="{{ route('admin.donors.index') }}" class="sidebar-item flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.donors.*') ? 'active' : '' }}">
                    <i class="fas fa-hand-holding-heart w-5 mr-3"></i>
                    <span>Donor Management</span>
                </a>
                
                <a href="{{ route('admin.donations.index') }}" class="sidebar-item flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.donations.*') ? 'active' : '' }}">
                    <i class="fas fa-hand-holding-usd w-5 mr-3"></i>
                    <span>Donations</span>
                </a>
                
                <a href="{{ route('admin.donations.walkins') }}" class="sidebar-item flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.donations.walkins') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check w-5 mr-3"></i>
                    <span>Walk-in Appointments</span>
                </a>

                <a href="{{ route('admin.inventory.index') }}" class="sidebar-item flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}">
                    <i class="fas fa-box-open w-5 mr-3"></i>
                    <span>Inventory</span>
                </a>
                
                <a href="{{ route('admin.relief-requests.index') }}" class="sidebar-item flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.relief-requests.*') ? 'active' : '' }}">
                    <i class="fas fa-hand-holding-medical w-5 mr-3"></i>
                    <span>Relief Requests</span>
                </a>

                <a href="{{ route('admin.contact-messages.index') }}" class="sidebar-item flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope w-5 mr-3"></i>
                    <span>Contact Messages</span>
                </a>
                
                <div class="pt-2 pb-1">
                    <p class="text-xs text-purple-200 uppercase tracking-wider px-4">System</p>
                </div>
                
                <a href="{{ route('admin.reports.index') }}" class="sidebar-item flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar w-5 mr-3"></i>
                    <span>Reports</span>
                </a>
                
                <a href="{{ route('admin.settings') }}" class="sidebar-item flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <i class="fas fa-cog w-5 mr-3"></i>
                    <span>Settings</span>
                </a>
            </nav>
        </div>

        <!-- User Profile -->
        <div class="absolute bottom-0 left-0 right-0 p-6 border-t border-purple-700">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-purple-800 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-white"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium">{{ Auth::guard('admin')->user()->name }}</p>
                    <p class="text-xs text-purple-200">Administrator</p>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}" class="ml-auto">
                    @csrf
                    <button type="submit" class="text-purple-200 hover:text-white">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="bg-white/90 backdrop-blur-sm shadow-lg border-b border-blue-200 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <button class="lg:hidden text-gray-600 mr-4" id="openSidebar">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-600">
                        <i class="far fa-clock mr-1"></i>
                        {{ now()->format('M d, Y h:i A') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="p-6">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        // Mobile sidebar toggle
        document.getElementById('openSidebar')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.add('active');
        });
        
        document.getElementById('closeSidebar')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('active');
        });
    </script>
    @stack('scripts')
</body>
</html>
            
