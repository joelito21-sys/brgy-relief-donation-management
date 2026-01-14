<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" x-data="{ sidebarOpen: window.innerWidth >= 1024, collapsed: false }" @resize.window="sidebarOpen = window.innerWidth >= 1024">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Flood Control')); ?> - Admin Panel</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('favicon.ico')); ?>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <style>
        [x-cloak] { display: none !important; }
        
        :root {
            --primary-color: #8B5CF6; /* Violet */
            --primary-dark: #7C3AED; /* Darker violet */
            --primary-light: #A78BFA; /* Lighter violet */
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;
            --dark-bg: #0f172a;
            --sidebar-bg: #8B5CF6; /* Violet sidebar */
            --card-bg: #ffffff;
            --text-primary: #111827; /* Bold black text */
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --hover-bg: #f1f5f9;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: white; /* White background */
            min-height: 100vh;
        }

        .sidebar {
            background: var(--sidebar-bg); /* Violet sidebar */
            box-shadow: 4px 0 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            width: 280px;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 40;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.collapsed .nav-text {
            opacity: 0;
            visibility: hidden;
            width: 0;
            height: 0;
            display: none;
        }

        .sidebar.collapsed .logo-text {
            opacity: 0;
            visibility: hidden;
            width: 0;
            height: 0;
            display: none;
        }

        .sidebar.collapsed .nav-item .nav-link i {
            margin-right: 0;
            text-align: center;
            width: 100%;
        }

        .sidebar.collapsed .nav-item .nav-link {
            justify-content: center;
            padding-left: 16px;
            padding-right: 16px;
        }

        .content-area {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-left: 280px;
            min-height: 100vh;
            width: calc(100% - 280px);
            background: white; /* White content area */
        }

        .content-area.expanded {
            margin-left: 80px;
            width: calc(100% - 80px);
        }

        .nav-item {
            position: relative;
            margin: 4px 12px;
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.2); /* Light violet on hover */
            transform: translateX(2px);
        }

        .nav-item.active {
            background: rgba(255, 255, 255, 0.3); /* Light violet for active */
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
        }

        .nav-item.active .nav-link {
            color: white;
            font-weight: 700; /* Bold text */
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: white; /* White text */
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.2s ease;
            font-weight: 600; /* Semi-bold text */
        }

        .nav-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.2);
        }

        .nav-link i {
            width: 20px;
            margin-right: 12px;
            font-size: 18px;
        }

        .header {
            background: #8B5CF6; /* Violet header */
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 30;
            color: white; /* White text */
        }

        .header h1 {
            color: white; /* White text for title */
            font-weight: 700; /* Bold text */
        }

        .card {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .btn-primary {
            background: var(--primary-color); /* Violet button */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 700; /* Bold text */
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(139, 92, 246, 0.2);
        }

        .btn-primary:hover {
            background: var(--primary-dark); /* Darker violet on hover */
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(139, 92, 246, 0.3);
        }

        .stat-card {
            background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%); /* Violet gradient */
            color: white;
            border-radius: 16px;
            padding: 24px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.mobile-show {
                transform: translateX(0);
            }
            .content-area {
                margin-left: 0;
                width: 100%;
            }
        }

        .mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 35;
            backdrop-filter: blur(2px);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700; /* Bold text */
            font-size: 16px;
            box-shadow: 0 2px 8px rgba(139, 92, 246, 0.3);
        }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 18px;
            height: 18px;
            background: var(--danger-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700; /* Bold text */
        }

        .page-header {
            background: rgba(139, 92, 246, 0.1); /* Light violet background */
            border-bottom: 1px solid var(--border-color);
            padding: 24px 32px;
            margin: -24px -32px 24px -32px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            color: white; /* White breadcrumb text */
            font-size: 14px;
            font-weight: 600; /* Semi-bold text */
        }

        .breadcrumb a {
            color: white; /* White links */
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .breadcrumb a:hover {
            color: #EDE9FE; /* Light violet on hover */
        }

        /* Make all text bold black as requested */
        .text-bold-black {
            color: #111827 !important;
            font-weight: 700 !important;
        }

        /* Toggle button styles */
        .toggle-sidebar-btn {
            transition: transform 0.3s ease;
        }

        .sidebar.collapsed .toggle-sidebar-btn {
            transform: rotate(180deg);
        }

        /* Search dropdown styles */
        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            z-index: 100;
            max-height: 400px;
            overflow-y: auto;
            margin-top: 5px;
        }

        .search-result-item {
            padding: 12px 16px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .search-result-item:hover {
            background-color: #f5f5f5;
        }

        .search-result-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .search-result-subtitle {
            font-size: 12px;
            color: #666;
        }

        .search-category {
            padding: 8px 16px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: #8B5CF6;
            background: #f8f5ff;
        }
    </style>
</head>
<body class="antialiased" x-data="{
    sidebarOpen: window.innerWidth >= 1024, 
    isMobile: window.innerWidth < 1024, 
    collapsed: false,
    searchQuery: '',
    searchResults: {},
    searchLoading: false,
    searchFocused: false,
    searchTimeout: null,
    
    async performSearch() {
        if (this.searchQuery.length < 2) {
            this.searchResults = {};
            return;
        }
        
        this.searchLoading = true;
        
        try {
            const response = await fetch(&quot;/admin/search?q=&quot; + encodeURIComponent(this.searchQuery), {
                headers: {
                    &quot;X-Requested-With&quot;: &quot;XMLHttpRequest&quot;,
                    &quot;X-CSRF-TOKEN&quot;: document.querySelector(&quot;meta[name='csrf-token']&quot;).getAttribute(&quot;content&quot;)
                }
            });
            
            if (response.ok) {
                this.searchResults = await response.json();
            } else {
                this.searchResults = {};
            }
        } catch (error) {
            console.error(&quot;Search error:&quot;, error);
            this.searchResults = {};
        } finally {
            this.searchLoading = false;
        }
    },
    
    debouncedSearch() {
        clearTimeout(this.searchTimeout);
        this.searchTimeout = setTimeout(() => {
            this.performSearch();
        }, 300);
    },
    
    goToResult(url) {
        window.location.href = url;
    }
}">
    <div class="flex">
        <!-- Sidebar -->
        <?php if(auth()->guard('admin')->check()): ?>
        <aside class="sidebar" :class="{ 'mobile-show': sidebarOpen, 'collapsed': collapsed }" x-cloak>
            <!-- Logo -->
            <div class="p-6 border-b border-violet-400">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" class="w-12 h-auto">
                    </div>
                    <span class="logo-text ml-3 text-sm font-bold text-white leading-tight">Barangay Cubacub Relief and Donation Management Program</span>
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden ml-auto text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- User Profile -->
            <div class="p-4 border-b border-violet-400">
                <div class="flex items-center">
                    <div class="user-avatar">
                        <?php echo e(strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1))); ?>

                    </div>
                    <div class="ml-3 overflow-hidden">
                        <p class="text-sm font-bold text-white truncate"><?php echo e(Auth::guard('admin')->user()->name); ?></p>
                        <p class="text-xs text-violet-200 truncate"><?php echo e(Auth::guard('admin')->user()->email); ?></p>
                    </div>
                </div>
            </div>

            <!-- Navigation Container -->
            <div class="flex flex-col h-full">
                <!-- Navigation -->
                <nav class="p-4 space-y-2 flex-grow">
                    <?php
                        $navigation = [
                            [
                                'title' => 'Dashboard',
                                'route' => 'admin.dashboard',
                                'icon' => 'fas fa-tachometer-alt',
                                'active' => request()->routeIs('admin.dashboard'),
                            ],
                            [
                                'title' => 'Manage Residents',
                                'route' => 'admin.residents.index',
                                'icon' => 'fas fa-users',
                                'active' => request()->Is('admin/residents*'),
                            ],
                            [
                                'title' => 'Create Resident',
                                'route' => 'admin.residents.create',
                                'icon' => 'fas fa-user-plus',
                                'active' => request()->routeIs('admin.residents.create'),
                            ],
                            [
                                'title' => 'Donors',
                                'route' => 'admin.donors.index',
                                'icon' => 'fas fa-hand-holding-heart',
                                'active' => request()->Is('admin/donors*'),
                            ],
                            [
                                'title' => 'Donations',
                                'route' => 'admin.donations.index',
                                'icon' => 'fas fa-donate',
                                'active' => request()->Is('admin/donations*'),
                                'submenu' => [
                                    [
                                        'title' => 'Overview',
                                        'route' => 'admin.donations.index',
                                        'icon' => 'fas fa-list',
                                        'active' => request()->routeIs('admin.donations.index'),
                                    ],
                                    [
                                        'title' => 'GCash Account',
                                        'route' => 'admin.payment-accounts.gcash',
                                        'icon' => 'fas fa-mobile-alt',
                                        'active' => request()->routeIs('admin.payment-accounts.gcash'),
                                    ],
                                    [
                                        'title' => 'PayMaya Account',
                                        'route' => 'admin.payment-accounts.paymaya',
                                        'icon' => 'fas fa-wallet',
                                        'active' => request()->routeIs('admin.payment-accounts.paymaya'),
                                    ],
                                    [
                                        'title' => 'Bank Account',
                                        'route' => 'admin.payment-accounts.bank',
                                        'icon' => 'fas fa-university',
                                        'active' => request()->routeIs('admin.payment-accounts.bank'),
                                    ],
                                ],
                            ],
                            [
                                'title' => 'Relief Requests',
                                'route' => 'admin.relief-requests.index',
                                'icon' => 'fas fa-hands-helping',
                                'active' => request()->Is('admin/relief-requests*'),
                            ],
                            [
                                'title' => 'Inventory',
                                'route' => 'admin.inventory.index',
                                'icon' => 'fas fa-boxes',
                                'active' => request()->routeIs('admin.inventory.*'),
                            ],
                            [
                                'title' => 'Distributions',
                                'route' => 'admin.distributions.index',
                                'icon' => 'fas fa-truck',
                                'active' => request()->routeIs('admin.distributions.*'),
                            ],
                            [
                                'title' => 'Messages',
                                'route' => 'admin.contact-messages.index',
                                'icon' => 'fas fa-envelope',
                                'active' => request()->routeIs('admin.contact-messages.*'),
                            ],
                            [
                                'title' => 'Reports',
                                'route' => 'admin.reports.index',
                                'icon' => 'fas fa-chart-bar',
                                'active' => request()->routeIs('admin.reports.*'),
                            ],
                            [
                                'title' => 'Analytics',
                                'route' => 'admin.analytics',
                                'icon' => 'fas fa-chart-line',
                                'active' => request()->routeIs('admin.analytics'),
                            ],
                            [
                                'title' => 'System Settings',
                                'route' => 'admin.settings',
                                'icon' => 'fas fa-cog',
                                'active' => request()->routeIs('admin.settings'),
                            ],
                        ];
                    ?>

                    <?php $__currentLoopData = $navigation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="nav-item <?php echo e($item['active'] ? 'active' : ''); ?>">
                            <?php if(isset($item['submenu'])): ?>
                                <!-- Submenu Item -->
                                <div x-data="{ submenuOpen: <?php echo e($item['active'] ? 'true' : 'false'); ?> }">
                                    <button @click="submenuOpen = !submenuOpen" 
                                           class="w-full nav-link text-left">
                                        <i class="<?php echo e($item['icon']); ?>"></i>
                                        <span class="nav-text"><?php echo e($item['title']); ?></span>
                                        <i class="fas fa-chevron-down ml-auto text-xs transition-transform" 
                                           :class="{ 'rotate-180': submenuOpen }"></i>
                                    </button>
                                    
                                    <!-- Submenu -->
                                    <div x-show="submenuOpen" class="mt-2 ml-4 space-y-1" style="display: <?php echo e($item['active'] ? 'block' : 'none'); ?>;">
                                        <?php $__currentLoopData = $item['submenu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subitem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="<?php echo e(route($subitem['route'])); ?>" 
                                               class="nav-link text-sm <?php echo e($subitem['active'] ? 'active' : ''); ?> bg-violet-500 bg-opacity-20">
                                                <i class="<?php echo e($subitem['icon']); ?> text-xs"></i>
                                                <span class="nav-text"><?php echo e($subitem['title']); ?></span>
                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <!-- Regular Menu Item -->
                                <a href="<?php echo e(route($item['route'])); ?>" class="nav-link">
                                    <i class="<?php echo e($item['icon']); ?>"></i>
                                    <span class="nav-text"><?php echo e($item['title']); ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </nav>

                <!-- Spacer to separate navigation from logout -->
                <div class="pb-4 flex-shrink-0"></div>

                <!-- Bottom Section -->
                <div class="p-4 border-t border-violet-400 flex-shrink-0">
                    <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full nav-link text-left">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="nav-text">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        <?php endif; ?>

        <!-- Main Content -->
        <div class="content-area flex-1" :class="{ 'expanded': collapsed }">
            <?php if(auth()->guard('admin')->check()): ?>
                <!-- Header -->
                <header class="header">
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-white rounded-lg hover:bg-violet-500 lg:hidden">
                                    <i class="fas fa-bars text-xl"></i>
                                </button>
                                <button @click="collapsed = !collapsed" class="toggle-sidebar-btn hidden lg:block p-2 text-white rounded-lg hover:bg-violet-500 mr-4">
                                    <i class="fas fa-bars text-xl"></i>
                                </button>
                                
                                <!-- Search Bar -->
                                <div class="relative ml-4 w-64 md:w-96" @click.away="searchFocused = false; searchResults = {}">
                                    <div class="relative">
                                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                        <input type="text" 
                                               x-model="searchQuery" 
                                               @input="debouncedSearch()" 
                                               @focus="searchFocused = true"
                                               class="w-full pl-10 pr-4 py-2 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-violet-300" 
                                               placeholder="Search resources...">
                                        
                                        <!-- Loading Spinner -->
                                        <div x-show="searchLoading" class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                            <i class="fas fa-spinner fa-spin text-violet-500"></i>
                                        </div>
                                    </div>
                                    
                                    <!-- Search Results Dropdown -->
                                    <div x-show="Object.keys(searchResults).length > 0 && searchQuery.length >= 2" 
                                         class="search-results text-black" 
                                         x-transition.opacity
                                         style="display: none;">
                                        
                                        <!-- Donors -->
                                        <template x-if="searchResults.donors && searchResults.donors.length > 0">
                                            <div>
                                                <div class="search-category">Donors</div>
                                                <template x-for="donor in searchResults.donors" :key="'donor-' + donor.id">
                                                    <div @click="goToResult('/admin/donors/' + donor.id)" class="search-result-item">
                                                        <div class="search-result-title" x-text="donor.name"></div>
                                                        <div class="search-result-subtitle">
                                                            <i class="fas fa-envelope mr-1"></i> <span x-text="donor.email"></span>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                        
                                        <!-- Residents -->
                                        <template x-if="searchResults.residents && searchResults.residents.length > 0">
                                            <div>
                                                <div class="search-category">Residents</div>
                                                <template x-for="resident in searchResults.residents" :key="'resident-' + resident.id">
                                                    <div @click="goToResult('/admin/residents/' + resident.id)" class="search-result-item">
                                                        <div class="search-result-title" x-text="resident.first_name + ' ' + resident.last_name"></div>
                                                        <div class="search-result-subtitle">
                                                            <span x-text="resident.barangay"></span> • <span x-text="resident.contact_number"></span>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                        
                                        <!-- Donations -->
                                        <template x-if="searchResults.donations && searchResults.donations.length > 0">
                                            <div>
                                                <div class="search-category">Donations</div>
                                                <template x-for="donation in searchResults.donations" :key="'donation-' + donation.id">
                                                    <div @click="goToResult('/admin/donations/' + donation.id)" class="search-result-item">
                                                        <div class="search-result-title">
                                                            <span x-text="donation.reference_number || 'ID: ' + donation.id"></span>
                                                        </div>
                                                        <div class="search-result-subtitle">
                                                            <span x-text="donation.type"></span> • <span x-text="donation.formatted_amount"></span>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                        
                                        <!-- No Results -->
                                        <div x-show="Object.keys(searchResults).length === 0 && !searchLoading" class="p-4 text-center text-gray-500">
                                            No results found
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-4">
                                <!-- Notifications -->
                                <button class="p-2 text-white hover:bg-violet-500 rounded-lg relative">
                                    <i class="fas fa-bell text-xl"></i>
                                    <div class="notification-badge">3</div>
                                </button>
                                
                                <!-- Profile Dropdown -->
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                        <div class="user-avatar text-sm">
                                            <?php echo e(strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1))); ?>

                                        </div>
                                        <span class="hidden md:block font-bold">Admin</span>
                                        <i class="fas fa-chevron-down text-xs ml-1"></i>
                                    </button>
                                    
                                    <div x-show="open" @click.away="open = false" 
                                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 z-50 text-gray-800"
                                         style="display: none;">
                                        <a href="<?php echo e(route('admin.profile')); ?>" class="block px-4 py-2 hover:bg-violet-50 hover:text-violet-600 transition-colors">
                                            <i class="fas fa-user mr-2"></i> Profile
                                        </a>
                                        <a href="<?php echo e(route('admin.settings')); ?>" class="block px-4 py-2 hover:bg-violet-50 hover:text-violet-600 transition-colors">
                                            <i class="fas fa-cog mr-2"></i> Settings
                                        </a>
                                        <div class="border-t border-gray-100 my-1"></div>
                                        <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
            <?php endif; ?>

            <main class="p-6">
                <?php if(session('success')): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline"><?php echo e(session('success')); ?></span>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline"><?php echo e(session('error')); ?></span>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>