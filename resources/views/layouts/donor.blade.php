<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Barangay Cubacub Relief and Donation Management Program') }} - Donor Dashboard</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Styles -->
    @livewireStyles
    @stack('styles')
    
    <style>
        .gradient-bg {
            background: #22c55e;
        }
        .sidebar-item {
            transition: all 0.3s ease;
        }
        .sidebar-item:hover {
            transform: translateX(4px);
            background: rgba(255, 255, 255, 0.1);
        }
        .sidebar-item.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-weight: 600;
        }
        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            animation: float 15s infinite linear;
        }
        .shape-1 {
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            top: 10%;
            left: 5%;
            animation-duration: 20s;
        }
        .shape-2 {
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            bottom: 15%;
            right: 10%;
            animation-duration: 25s;
            animation-delay: -5s;
        }
        @keyframes float {
            '0%, 100%': { transform: 'translateY(0)' },
            '50%': { transform: 'translateY(-10px)' },
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside style="background-color: #22c55e;" class="w-64 shadow-xl fixed left-0 top-0 h-full z-30 transform transition-all duration-300 ease-in-out" id="sidebar">
            <!-- Collapse/Expand Button - Centered on Right Edge -->
            <button onclick="toggleSidebarCollapse()" 
                    class="absolute top-1/2 -right-3 transform -translate-y-1/2 bg-white hover:bg-gray-100 rounded-full p-2 shadow-lg transition-all duration-300 z-40"
                    id="sidebarToggle">
                <i class="fas fa-chevron-left text-green-600 transition-transform duration-300" id="toggleIcon"></i>
            </button>

            <!-- Sidebar Header -->
            <div class="gradient-bg p-6 relative overflow-hidden">
                <div class="floating-shapes">
                    <div class="shape shape-1"></div>
                    <div class="shape shape-2"></div>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg p-2">
                            <i class="fas fa-hand-holding-heart text-white text-2xl"></i>
                        </div>
                        <div class="sidebar-text">
                            <h2 class="text-xl font-bold text-white">Donor Portal</h2>
                            <p class="text-white/80 text-sm">Barangay Cubacub Relief and Donation Management Program</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Profile -->
            <div class="p-4 border-b border-white/20">
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 backdrop-blur-sm rounded-full p-3">
                        <i class="fas fa-user text-white text-lg"></i>
                    </div>
                    <div class="flex-1 user-profile-text">
                        <p class="font-semibold text-white">{{ Auth::guard('donor')->user()->name }}</p>
                        <p class="text-sm text-white/80">{{ Auth::guard('donor')->user()->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="p-4 space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('donor.dashboard') }}" 
                   class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('donor.dashboard') ? 'active' : 'text-white' }}">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <!-- Donate -->
                <a href="{{ route('donor.donations.index') }}" 
                   class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('donor.donations.index') ? 'active' : 'text-white' }}">
                    <i class="fas fa-donate w-5"></i>
                    <span class="font-medium">Make Donation</span>
                </a>

                <!-- Donation History -->
                <a href="{{ route('donor.donations.history') }}" 
                   class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('donor.donations.history') ? 'active' : 'text-white' }}">
                    <i class="fas fa-history w-5"></i>
                    <span class="font-medium">Donation History</span>
                </a>

                <!-- Activities -->
                <a href="{{ route('donor.activities') }}" 
                   class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('donor.activities') ? 'active' : 'text-white' }}">
                    <i class="fas fa-calendar-alt w-5"></i>
                    <span class="font-medium">Activities</span>
                </a>

                <!-- Profile -->
                <a href="{{ route('donor.profile') }}" 
                   class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('donor.profile.*') ? 'active' : 'text-white' }}">
                    <i class="fas fa-user-circle w-5"></i>
                    <span class="font-medium">My Profile</span>
                </a>

                <!-- Settings -->
                <a href="{{ route('donor.settings') }}" 
                   class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('donor.settings') ? 'active' : 'text-white' }}">
                    <i class="fas fa-cog w-5"></i>
                    <span class="font-medium">Settings</span>
                </a>

                <!-- Help/Support -->
                <a href="{{ route('donor.contact') }}" 
                   class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('donor.contact') ? 'active' : 'text-white' }}">
                    <i class="fas fa-question-circle w-5"></i>
                    <span class="font-medium">Help & Support</span>
                </a>
            </nav>

            <!-- Logout Button -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-white/20">
                <form method="POST" action="{{ route('donor.logout') }}" class="w-full">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center justify-center space-x-3 p-3 rounded-lg text-white hover:bg-white/10 transition-colors">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Mobile Menu Toggle -->
        <div class="sm:hidden fixed top-4 left-4 z-40">
            <button onclick="toggleSidebar()" 
                    class="bg-white p-3 rounded-lg shadow-lg border border-gray-200">
                <i class="fas fa-bars text-gray-700"></i>
            </button>
        </div>

        <!-- Main Content -->
        <div id="mainContent" class="flex-1 sm:ml-64 transition-all duration-300 ease-in-out">
            <!-- Top Navigation -->
            <header style="background-color: #22c55e;" class="fixed top-0 left-0 right-0 sm:left-64 shadow-sm z-20">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <h1 class="text-2xl font-bold text-white">
                            @yield('title', 'Dashboard')
                        </h1>
                    </div>
                    
                    <!-- Desktop User Menu -->
                    <div class="hidden sm:flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="relative p-2 text-white hover:text-gray-100 transition-colors">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        
                        <!-- Messages -->
                        <button class="relative p-2 text-white hover:text-gray-100 transition-colors">
                            <i class="fas fa-envelope text-xl"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-yellow-400 rounded-full"></span>
                        </button>
                        
                        <!-- User Dropdown -->
                        <div class="relative">
                            <button onclick="toggleUserMenu()" 
                                    class="flex items-center space-x-2 p-2 rounded-lg hover:bg-white/10 transition-colors">
                                <div class="bg-white rounded-full p-2">
                                    <i class="fas fa-user text-green-500 text-sm"></i>
                                </div>
                                <span class="text-white font-medium hidden md:block">
                                    {{ Auth::guard('donor')->user()->name }}
                                </span>
                                <i class="fas fa-chevron-down text-white text-sm"></i>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                                <a href="{{ route('donor.profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-user-circle mr-2"></i>Profile
                                </a>
                                <a href="{{ route('donor.settings') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-cog mr-2"></i>Settings
                                </a>
                                <hr class="my-2 border-gray-200">
                                <form method="POST" action="{{ route('donor.logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6 pt-24">
                <!-- Success Messages -->
                @if (session('success'))
                    <div class="mb-6 rounded-lg bg-green-50 border border-green-200 p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">
                                    {{ session('success') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">
                                    Please correct the following errors:
                                </p>
                                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" 
         class="sm:hidden fixed inset-0 bg-black bg-opacity-50 z-20 hidden"
         onclick="toggleSidebar()"></div>

    <!-- Scripts -->
    @livewireScripts
    @stack('scripts')

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        }

        // Close user menu when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('userMenu');
            const userButton = event.target.closest('button[onclick="toggleUserMenu()"]');
            
            if (!userButton && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });

        // Initialize sidebar state for mobile
        document.addEventListener('DOMContentLoaded', function() {
            if (window.innerWidth < 640) {
                document.getElementById('sidebar').classList.add('-translate-x-full');
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (window.innerWidth >= 640) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        });

        // Sidebar Collapse/Expand Function
        let sidebarCollapsed = false;
        
        function toggleSidebarCollapse() {
            const sidebar = document.getElementById('sidebar');
            const toggleIcon = document.getElementById('toggleIcon');
            const mainContent = document.getElementById('mainContent');
            const header = document.querySelector('header');
            const sidebarTexts = document.querySelectorAll('.sidebar-text, .sidebar-item span, .user-profile-text');
            
            sidebarCollapsed = !sidebarCollapsed;
            
            if (sidebarCollapsed) {
                // Collapse
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');
                toggleIcon.classList.add('rotate-180');
                
                // Adjust header
                if (header) {
                    header.classList.remove('sm:left-64');
                    header.classList.add('sm:left-20');
                }

                // Adjust main content
                if (mainContent) {
                    mainContent.classList.remove('sm:ml-64');
                    mainContent.classList.add('sm:ml-20');
                }
                
                // Hide text
                sidebarTexts.forEach(el => {
                    el.style.display = 'none';
                });
            } else {
                // Expand
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-64');
                toggleIcon.classList.remove('rotate-180');
                
                // Adjust header
                if (header) {
                    header.classList.remove('sm:left-20');
                    header.classList.add('sm:left-64');
                }

                // Adjust main content
                if (mainContent) {
                    mainContent.classList.remove('sm:ml-20');
                    mainContent.classList.add('sm:ml-64');
                }
                
                // Show text
                sidebarTexts.forEach(el => {
                    el.style.display = '';
                });
            }
        }
    </script>
    <style>
        .rotate-180 {
            transform: rotate(180deg);
        }
    </style>
    </script>
</body>
</html>
