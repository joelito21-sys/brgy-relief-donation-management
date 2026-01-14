{{-- resources/views/donor/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'Barangay Cubacub Relief and Donation Management Program'))</title>
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <style>
        /* Custom styles */
        .main-content {
            padding-top: 4rem; /* Account for fixed header */
        }
        
        .dropdown:hover .dropdown-menu {
            display: block;
        }
        
        /* Animation for mobile menu */
        #mobile-menu {
            transition: all 0.3s ease-in-out;
        }
        
        /* Active link styling */
        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.375rem;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <nav class="bg-blue-900 text-white shadow-md fixed w-full z-10" id="mainHeader">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('donor.dashboard') }}" class="flex items-center">
                        <img class="h-8 w-auto" src="{{ asset('images/logo.png') }}" alt="Barangay Cubacub Relief and Donation Management Program">
                        <span class="ml-2 text-xl font-bold">Barangay Cubacub Relief and Donation Management Program</span>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-center space-x-4">
                        <a href="{{ route('donor.dashboard') }}" class="nav-link {{ request()->routeIs('donor.dashboard') ? 'active' : '' }} px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-home mr-1"></i> Dashboard
                        </a>
                        <a href="{{ route('donor.donations.index') }}" class="nav-link {{ request()->routeIs('donor.donations.*') ? 'active' : '' }} px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-donate mr-1"></i> Donate
                        </a>
                        <a href="{{ route('donor.donations.history') }}" class="nav-link {{ request()->routeIs('donor.donations.history') ? 'active' : '' }} px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-history mr-1"></i> History
                        </a>
                        <a href="{{ route('donor.activities') }}" class="nav-link {{ request()->routeIs('donor.activities') ? 'active' : '' }} px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-tasks mr-1"></i> Activities
                        </a>
                        <a href="{{ route('donor.about') }}" class="nav-link {{ request()->routeIs('donor.about') ? 'active' : '' }} px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-info-circle mr-1"></i> About
                        </a>
                        <a href="{{ route('donor.messages.index') }}" class="nav-link {{ request()->routeIs('donor.messages.*') ? 'active' : '' }} px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-inbox mr-1"></i> Messages
                        </a>
                        <a href="{{ route('donor.contact') }}" class="nav-link {{ request()->routeIs('donor.contact') ? 'active' : '' }} px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-envelope mr-1"></i> Contact
                        </a>
                    </div>
                </div>
                
                <!-- User Dropdown & Mobile menu button -->
                <div class="flex items-center">
                    <!-- User Dropdown -->
                    <div class="hidden md:block relative dropdown">
                        <button class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-900">
                            <div class="h-8 w-8 rounded-full bg-blue-700 flex items-center justify-center">
                                <span class="text-white text-sm font-medium">{{ substr(Auth::guard('donor')->user()->name, 0, 1) }}</span>
                            </div>
                            <span class="ml-2 hidden lg:inline-block text-sm font-medium">{{ Auth::guard('donor')->user()->name }}</span>
                            <i class="ml-1 fas fa-chevron-down hidden lg:inline-block"></i>
                        </button>
                        
                        <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden dropdown-menu">
                            <div class="py-1">
                                <a href="{{ route('donor.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i> Your Profile
                                </a>
                                <a href="{{ route('donor.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i> Settings
                                </a>
                                <form method="POST" action="{{ route('donor.logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center ml-4">
                        <button id="mobileMenuButton" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                            <span class="sr-only">Open main menu</span>
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-blue-800">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('donor.dashboard') }}" class="text-white hover:bg-indigo-500 block px-3 py-2 rounded-md text-base font-medium">
                    <i class="fas fa-home mr-2"></i> Dashboard
                </a>
                <a href="{{ route('donor.donations.index') }}" class="text-white hover:bg-indigo-500 block px-3 py-2 rounded-md text-base font-medium">
                    <i class="fas fa-donate mr-2"></i> Make a Donation
                </a>
                <a href="{{ route('donor.donations.history') }}" class="text-white hover:bg-indigo-500 block px-3 py-2 rounded-md text-base font-medium">
                    <i class="fas fa-history mr-2"></i> Donation History
                </a>
                <a href="{{ route('donor.activities') }}" class="text-white hover:bg-indigo-500 block px-3 py-2 rounded-md text-base font-medium">
                    <i class="fas fa-tasks mr-2"></i> View Activities
                </a>
                <a href="{{ route('donor.about') }}" class="text-white hover:bg-indigo-500 block px-3 py-2 rounded-md text-base font-medium">
                    <i class="fas fa-info-circle mr-2"></i> About Us
                </a>
                <a href="{{ route('donor.contact') }}" class="text-white hover:bg-indigo-500 block px-3 py-2 rounded-md text-base font-medium">
                    <i class="fas fa-envelope mr-2"></i> Contact Us
                </a>
                
                <!-- Mobile User Menu -->
                <div class="mt-4 pt-4 border-t border-blue-700">
                    <a href="{{ route('donor.profile') }}" class="text-white hover:bg-indigo-500 block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fas fa-user mr-2"></i> Your Profile
                    </a>
                    <a href="{{ route('donor.settings') }}" class="text-white hover:bg-indigo-500 block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fas fa-cog mr-2"></i> Settings
                    </a>
                    <form method="POST" action="{{ route('donor.logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left text-white hover:bg-indigo-500 block px-3 py-2 rounded-md text-base font-medium">
                            <i class="fas fa-sign-out-alt mr-2"></i> Sign out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="main-content pt-2 pb-6">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-white mt-12">
        <div class="max-w-7xl mx-auto py-6 px-4 overflow-hidden sm:px-6 lg:px-8">
            <p class="text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Barangay Cubacub Relief and Donation Management Program. All rights reserved.
            </p>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }
    </script>
    @stack('scripts')
    
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobileMenuButton');
            const mobileMenu = document.getElementById('mobileMenu');
            const mainHeader = document.getElementById('mainHeader');
            const topBar = document.querySelector('.bg-blue-900');

            // Toggle mobile menu
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    mobileMenu.classList.toggle('hidden');
                    const icon = mobileMenuButton.querySelector('i');
                    if (icon) {
                        if (icon.classList.contains('fa-bars')) {
                            icon.classList.remove('fa-bars');
                            icon.classList.add('fa-times');
                        } else {
                            icon.classList.remove('fa-times');
                            icon.classList.add('fa-bars');
                        }
                    }
                });
            }

            // Keep header always visible
            if (mainHeader) {
                window.addEventListener('scroll', function() {
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    
                    // Add/remove shadow when scrolled
                    if (scrollTop > 10) {
                        mainHeader.classList.add('shadow-lg');
                        mainHeader.classList.remove('shadow-md');
                    } else {
                        mainHeader.classList.remove('shadow-lg');
                        mainHeader.classList.add('shadow-md');
                    }
                });
            }

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                    if (!event.target.closest('#mobileMenu') && !event.target.closest('#mobileMenuButton')) {
                        mobileMenu.classList.add('hidden');
                        const icon = mobileMenuButton.querySelector('i');
                        if (icon) {
                            icon.classList.remove('fa-times');
                            icon.classList.add('fa-bars');
                        }
                    }
                }
            });

            // Close mobile menu when clicking on a link
            const mobileLinks = document.querySelectorAll('#mobileMenu a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                    const icon = mobileMenuButton.querySelector('i');
                    if (icon) {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                });
            });
        });
    </script>
</body>
</html>