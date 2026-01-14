<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Resident Dashboard'); ?> - <?php echo e(config('app.name')); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }
        .sidebar-item {
            transition: all 0.2s ease;
        }
        .sidebar-item:hover {
            transform: translateX(4px);
        }
        .sidebar-active {
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.1) 0%, rgba(99, 102, 241, 0.05) 100%);
            border-left: 4px solid #6366f1;
        }
        .sidebar-closed {
            margin-left: -16rem;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar-transition w-64 bg-blue-900 shadow-lg flex-shrink-0">
            <div class="flex flex-col h-full">

                <div class="flex flex-col items-center justify-center min-h-[5rem] pt-8 pb-8 px-4 bg-blue-900 border-b border-blue-800">
                    <a href="<?php echo e(route('resident.dashboard')); ?>" class="flex flex-col items-center text-center">
                        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Flood Control Logo" class="h-24 w-auto mb-4">
                        <span class="text-white font-bold text-lg leading-tight">Barangay Cubacub Relief and Donation Management Program</span>
                    </a>
                </div>

                <!-- User Info -->
                <div class="p-4 border-b border-blue-800 mt-16">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-700 rounded-full flex items-center justify-center text-white">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white mb-1"><?php echo e(Auth::guard('resident')->user()->name); ?></p>
                            <p class="text-xs text-blue-200"><?php echo e(Auth::guard('resident')->user()->email); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">
                    <!-- Dashboard -->
                    <a href="<?php echo e(route('resident.dashboard')); ?>" 
                       class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-lg <?php echo e(request()->routeIs('resident.dashboard') ? 'bg-blue-800 text-white border-l-4 border-blue-400' : 'text-blue-100 hover:bg-blue-800 hover:text-white'); ?>">
                        <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                        Dashboard
                    </a>

                    <!-- Relief Requests -->
                    <div class="space-y-1">
                        <button onclick="toggleSubmenu('relief-requests')" 
                                class="sidebar-item w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg text-blue-100 hover:bg-blue-800 hover:text-white">
                            <div class="flex items-center">
                                <i class="fas fa-hands-helping w-5 h-5 mr-3"></i>
                                Relief Requests
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform" id="relief-requests-chevron"></i>
                        </button>
                        
                        <div id="relief-requests-submenu" class="ml-8 space-y-1 hidden">
                            <a href="<?php echo e(route('resident.relief-requests.create')); ?>" class="sidebar-item flex items-center px-4 py-2 text-sm text-blue-200 hover:text-white hover:bg-blue-800 rounded">
                                <i class="fas fa-plus w-4 h-4 mr-2"></i>
                                New Request
                            </a>
                            <a href="<?php echo e(route('resident.relief-requests.index')); ?>" class="sidebar-item flex items-center px-4 py-2 text-sm text-blue-200 hover:text-white hover:bg-blue-800 rounded">
                                <i class="fas fa-list w-4 h-4 mr-2"></i>
                                My Requests
                            </a>
                        </div>
                    </div>

                    <!-- Donations Received -->
                    <a href="<?php echo e(route('resident.donations.index')); ?>" 
                       class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-lg <?php echo e(request()->routeIs('resident.donations.*') ? 'bg-blue-800 text-white border-l-4 border-blue-400' : 'text-blue-100 hover:bg-blue-800 hover:text-white'); ?>">
                        <i class="fas fa-box-open w-5 h-5 mr-3"></i>
                        Donations Received
                    </a>

                    <!-- Profile -->
                    <div class="space-y-1">
                        <button onclick="toggleSubmenu('profile')" 
                                class="sidebar-item w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg text-blue-100 hover:bg-blue-800 hover:text-white">
                            <div class="flex items-center">
                                <i class="fas fa-user-circle w-5 h-5 mr-3"></i>
                                My Profile
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform" id="profile-chevron"></i>
                        </button>
                        
                        <div id="profile-submenu" class="ml-8 space-y-1 hidden">
                            <a href="<?php echo e(route('resident.profile.edit')); ?>" class="sidebar-item flex items-center px-4 py-2 text-sm text-blue-200 hover:text-white hover:bg-blue-800 rounded">
                                <i class="fas fa-edit w-4 h-4 mr-2"></i>
                                Edit Profile
                            </a>
                            <a href="<?php echo e(route('resident.profile.password')); ?>" class="sidebar-item flex items-center px-4 py-2 text-sm text-blue-200 hover:text-white hover:bg-blue-800 rounded">
                                <i class="fas fa-lock w-4 h-4 mr-2"></i>
                                Change Password
                            </a>
                            <a href="#" class="sidebar-item flex items-center px-4 py-2 text-sm text-blue-200 hover:text-white hover:bg-blue-800 rounded">
                                <i class="fas fa-users w-4 h-4 mr-2"></i>
                                Family Members
                            </a>
                        </div>
                    </div>

                    <!-- Emergency -->
                    <div class="pt-4 border-t border-blue-800">
                        <a href="<?php echo e(route('resident.emergency')); ?>" 
                           class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-lg <?php echo e(request()->routeIs('resident.emergency') ? 'bg-red-700 text-white' : 'text-red-300 hover:bg-red-900 hover:text-white'); ?>">
                            <i class="fas fa-exclamation-triangle w-5 h-5 mr-3"></i>
                            Emergency Contact
                        </a>
                    </div>

                    <!-- Help & Support -->
                    <a href="<?php echo e(route('resident.help')); ?>" 
                       class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-lg <?php echo e(request()->routeIs('resident.help') ? 'bg-blue-800 text-white border-l-4 border-blue-400' : 'text-blue-100 hover:bg-blue-800 hover:text-white'); ?>">
                        <i class="fas fa-question-circle w-5 h-5 mr-3"></i>
                        Help & Support
                    </a>
                </nav>

                <!-- Logout -->
                <div class="p-4 border-t border-blue-800">
                    <form method="POST" action="<?php echo e(route('resident.logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" 
                                class="sidebar-item w-full flex items-center px-4 py-3 text-sm font-medium rounded-lg text-blue-100 hover:bg-blue-800 hover:text-white">
                            <i class="fas fa-sign-out-alt w-5 h-5 mr-3"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-blue-100 shadow-sm border-b border-blue-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <button onclick="toggleSidebar()" class="text-blue-900 hover:text-blue-700 focus:outline-none">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="ml-4 text-xl font-bold text-black"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h1>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="relative text-blue-900 hover:text-blue-700 focus:outline-none">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        
                        <!-- User Menu -->
                        <div class="relative">
                            <button onclick="toggleUserMenu()" class="flex items-center text-blue-900 hover:text-blue-700 focus:outline-none">
                                <div class="w-8 h-8 bg-blue-200 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-800 text-sm"></i>
                                </div>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                                <div class="px-4 py-3 border-b border-gray-200">
                                    <p class="text-sm font-medium text-gray-900"><?php echo e(Auth::guard('resident')->user()->name); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e(Auth::guard('resident')->user()->email); ?></p>
                                </div>
                                <div class="py-2">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user-circle mr-2"></i>Profile
                                    </a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-cog mr-2"></i>Settings
                                    </a>
                                    <form method="POST" action="<?php echo e(route('resident.logout')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 text-black">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    <script>
        // Toggle Sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('sidebar-closed');
        }

        // Toggle Submenu
        function toggleSubmenu(menuId) {
            const submenu = document.getElementById(menuId + '-submenu');
            const chevron = document.getElementById(menuId + '-chevron');
            
            submenu.classList.toggle('hidden');
            chevron.classList.toggle('rotate-180');
        }

        // Toggle User Menu
        function toggleUserMenu() {
            const menu = document.getElementById('user-menu');
            menu.classList.toggle('hidden');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('user-menu');
            const userMenuButton = event.target.closest('button[onclick="toggleUserMenu()"]');
            
            if (!userMenuButton && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });

        // Set active menu item based on current route
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.sidebar-item');
            
            menuItems.forEach(item => {
                if (item.getAttribute('href') === currentPath) {
                    item.classList.add('bg-blue-800', 'text-white', 'border-l-4', 'border-blue-400');
                    item.classList.remove('text-blue-100');
                }
            });
        });
    </script>
</body>
</html>

<?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/layouts/resident.blade.php ENDPATH**/ ?>