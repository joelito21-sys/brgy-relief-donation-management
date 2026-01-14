
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Donor Dashboard'); ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-bg: #28a745; /* Green background */
            --sidebar-text: #ffffff;
            --sidebar-active: #218838;
            --topbar-height: 60px;
            --collapsed-width: 80px;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--sidebar-bg); /* Green background */
            color: var(--sidebar-text);
            transition: all 0.3s ease-in-out;
            z-index: 1000;
            box-shadow: 3px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar.collapsed {
            width: var(--collapsed-width);
        }
        
        .sidebar-header {
            padding: 20px 15px;
            background: rgba(0,0,0,0.1);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: white;
        }
        
        .sidebar-logo img {
            height: 32px;
            margin-right: 10px;
        }
        
        .sidebar-logo h3 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
            transition: opacity 0.3s ease;
        }
        
        .sidebar.collapsed .sidebar-logo h3 {
            opacity: 0;
            width: 0;
            height: 0;
            overflow: hidden;
        }
        
        .sidebar-menu {
            padding: 15px 0;
            overflow-y: auto;
            height: calc(100vh - 120px);
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            margin: 5px 15px;
            color: var(--sidebar-text);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        
        .nav-link.active {
            background: var(--sidebar-active);
            color: white;
        }
        
        .nav-link i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            transition: margin-right 0.3s ease;
        }
        
        .nav-link span {
            transition: opacity 0.3s ease;
        }
        
        .sidebar.collapsed .nav-link span {
            opacity: 0;
            width: 0;
            height: 0;
            overflow: hidden;
        }
        
        .sidebar.collapsed .nav-link i {
            margin-right: 0;
            width: 100%;
            text-align: center;
        }
        
        /* Collapse Toggle Button */
        .collapse-toggle {
            position: absolute;
            right: -12px;
            top: 50%;
            transform: translateY(-50%);
            width: 24px;
            height: 24px;
            background: var(--sidebar-bg);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            z-index: 1001;
        }
        
        .sidebar.collapsed .collapse-toggle {
            right: -12px;
        }
        
        .collapse-toggle i {
            transition: transform 0.3s ease;
        }
        
        .sidebar.collapsed .collapse-toggle i {
            transform: rotate(180deg);
        }
        
        /* Main Content Styles */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-height);
            transition: margin-left 0.3s ease;
            min-height: calc(100vh - var(--topbar-height));
            background-color: white; /* White content area */
        }
        
        .main-content.collapsed {
            margin-left: var(--collapsed-width);
        }
        
        /* Top Bar Styles */
        .navbar {
            padding: 0.8rem 1.5rem;
            background: #28a745 !important; /* Green header */
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            color: white;
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            z-index: 999;
            transition: all 0.3s ease;
        }
        
        .navbar.collapsed {
            left: var(--collapsed-width);
        }
        
        .navbar .navbar-brand,
        .navbar .nav-link,
        .navbar .btn-link {
            color: white !important;
        }
        
        .navbar .btn-link:hover {
            color: rgba(255,255,255,0.8) !important;
        }
        
        /* Mobile Toggle */
        #sidebarToggle {
            font-size: 1.5rem;
        }
        
        /* Footer */
        footer {
            background: white;
            border-top: 1px solid #e9ecef;
        }
        
        /* Responsive Styles */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .main-content.collapsed {
                margin-left: 0;
            }
        }
        
        /* Chart Container */
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        
        /* Stats Card */
        .stats-card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
        }
        
        /* Table Styles */
        .table th {
            font-weight: 600;
        }
        
        /* Badge Styles */
        .badge-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.05);
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.2);
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(0,0,0,0.3);
        }
    </style>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="<?php echo e(route('donor.dashboard')); ?>" class="sidebar-logo">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo">
                <h3>Barangay Cubacub Relief and Donation Management Program</h3>
            </a>
        </div>
        
        <!-- Collapse Toggle Button -->
        <div class="collapse-toggle" id="collapseToggle">
            <i class="fas fa-chevron-left"></i>
        </div>
        
        <div class="sidebar-menu">
            <a href="<?php echo e(route('donor.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('donor.dashboard') ? 'active' : ''); ?>">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="<?php echo e(route('donor.donations.index')); ?>" class="nav-link <?php echo e(request()->routeIs('donor.donations.*') ? 'active' : ''); ?>">
                <i class="fas fa-hand-holding-heart"></i>
                <span>My Donations</span>
            </a>
            
            <a href="<?php echo e(route('donor.donations.history')); ?>" class="nav-link <?php echo e(request()->routeIs('donor.donations.history') ? 'active' : ''); ?>">
                <i class="fas fa-history"></i>
                <span>Donation History</span>
            </a>
            
            <a href="<?php echo e(route('donor.activities')); ?>" class="nav-link <?php echo e(request()->routeIs('donor.activities') ? 'active' : ''); ?>">
                <i class="fas fa-calendar-alt"></i>
                <span>Activities</span>
            </a>

            <a href="<?php echo e(route('donor.messages.index')); ?>" class="nav-link <?php echo e(request()->routeIs('donor.messages.*') ? 'active' : ''); ?>">
                <i class="fas fa-comment-alt"></i>
                <span>Messages</span>
            </a>
            
            <a href="<?php echo e(route('donor.settings')); ?>" class="nav-link <?php echo e(request()->routeIs('donor.settings') ? 'active' : ''); ?>">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
            
            <hr class="my-2">
            
            <a href="<?php echo e(route('donor.about')); ?>" class="nav-link <?php echo e(request()->routeIs('donor.about') ? 'active' : ''); ?>">
                <i class="fas fa-info-circle"></i>
                <span>About Us</span>
            </a>
            
            <a href="<?php echo e(route('donor.contact')); ?>" class="nav-link <?php echo e(request()->routeIs('donor.contact') ? 'active' : ''); ?>">
                <i class="fas fa-envelope"></i>
                <span>Contact Us</span>
            </a>
        </div>
        
        <div class="mt-auto">
            <div class="px-3 py-2 text-muted small">
                <div class="d-flex align-items-center mb-2">
                    <div class="me-2">
                        <div class="rounded-circle bg-white text-dark d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <?php echo e(strtoupper(substr(Auth::guard('donor')->user()->name, 0, 1))); ?>

                        </div>
                    </div>
                    <div>
                        <div class="fw-bold text-white"><?php echo e(Auth::guard('donor')->user()->name); ?></div>
                        <div>Donor</div>
                    </div>
                </div>
                <form method="POST" action="<?php echo e(route('donor.logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-sm btn-outline-light w-100">
                        <i class="fas fa-sign-out-alt me-1"></i> Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Top Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <button class="btn btn-link text-dark d-lg-none" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="mx-auto text-center">
                <h1 class="h4 mb-0 text-white"><?php echo $__env->yieldContent('header', 'Dashboard'); ?></h1>
                <div class="text-white-50 small">
                    Welcome back, <?php echo e(Auth::guard('donor')->user()->name); ?>! 👋
                    Your generous support is making a difference in flood-affected communities.
                </div>
            </div>
            
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <button class="btn btn-link text-decoration-none dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="me-2 d-none d-md-block text-end">
                            <div class="fw-medium text-white"><?php echo e(Auth::guard('donor')->user()->name); ?></div>
                            <div class="small text-white-50">Donor</div>
                        </div>
                        <div class="rounded-circle bg-white text-dark d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <?php echo e(strtoupper(substr(Auth::guard('donor')->user()->name, 0, 1))); ?>

                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="<?php echo e(route('donor.profile')); ?>"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="<?php echo e(route('donor.logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Page Content -->
        <div class="container-fluid">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

        <!-- Footer -->
        <footer class="mt-5 py-4 border-top">
            <div class="container-fluid">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div class="mb-3 mb-md-0">
                        <span class="text-muted">&copy; <?php echo e(date('Y')); ?> Barangay Cubacub Relief and Donation Management Program. All rights reserved.</span>
                    </div>
                    <div class="d-flex">
                        <a href="#" class="text-muted me-3"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-muted me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-muted"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle sidebar collapse
        document.getElementById('collapseToggle').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('mainContent').classList.toggle('collapsed');
            document.querySelector('.navbar').classList.toggle('collapsed');
        });

        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('sidebar').classList.toggle('show');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            
            if (window.innerWidth < 992 && 
                !sidebar.contains(event.target) && 
                !sidebarToggle.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        });

        // Update active nav link based on current URL
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
            
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/donor/layouts/dashboard.blade.php ENDPATH**/ ?>