<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barangay Cubacub Relief and Donation Management Program</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .transition-all { transition: all 0.3s ease; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-violet-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-24">
                <div class="flex items-center space-x-3">
                    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Barangay Cubacub Logo" class="h-20 w-auto">
                    <span class="text-3xl font-bold text-white">Barangay Cubacub Relief and Donation Management Program</span>
                </div>
                <div class="flex items-center space-x-4">
                   
                    <a href="<?php echo e(url('/about')); ?>" class="text-white hover:text-green-200 px-3 py-2 rounded-md text-sm font-medium">About Us</a>
                    <a href="<?php echo e(route('contact')); ?>" class="text-white hover:text-green-200 px-3 py-2 rounded-md text-sm font-medium">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-[calc(100vh-4rem)] flex flex-col items-center justify-center">
        <div class="text-center mb-10">
            <h1 class="text-2xl font-bold text-gray-900">Welcome to Our Community Portal</h1>
            <p class="text-gray-500 mt-2 text-lg">Please select your portal to continue</p>
        </div>

        <div class="w-full max-w-5xl px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl shadow-xl border border-white/70 p-6 text-center space-y-4">
                    <div class="w-16 h-16 mx-auto rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-user text--600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Admin Portal</h3>
                    <p class="text-gray-500 text-sm">Manage users, content, and system settings</p>
                    <a href="<?php echo e(route('admin.login')); ?>" class="mt-4 inline-flex items-center justify-center bg-purple-600 hover:bg-purple-700 text-white font-semibold text-sm px-6 py-2 rounded-full transition">Login as Admin</a>
                </div>

                <div class="bg-white rounded-2xl shadow-xl border border-white/70 p-6 text-center space-y-4">
                    <div class="w-16 h-16 mx-auto rounded-full bg-emerald-100 flex items-center justify-center">
                        <i class="fas fa-hand-holding-heart text-emerald-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Donor Portal</h3>
                    <p class="text-gray-500 text-sm">Make donations and track your contributions</p>
                    <div class="space-y-2">
                        <a href="<?php echo e(route('donor.login')); ?>" class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm px-6 py-2 rounded-full transition">Login as Donor</a>
                        <a href="<?php echo e(route('donor.register')); ?>" class="inline-flex items-center justify-center border border-emerald-600 text-emerald-600 font-semibold text-sm px-6 py-2 rounded-full hover:bg-emerald-50 transition">Register as Donor</a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xl border border-white/70 p-6 text-center space-y-4">
                    <div class="w-16 h-16 mx-auto rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-building text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Resident Portal</h3>
                    <p class="text-gray-500 text-sm">Access community resources and services</p>
                    <div class="space-y-2">
                        <a href="<?php echo e(route('resident.login')); ?>" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-6 py-2 rounded-full transition">Login as Resident</a>
                        <a href="<?php echo e(route('resident.register')); ?>" class="inline-flex items-center justify-center border border-blue-600 text-blue-600 font-semibold text-sm px-6 py-2 rounded-full hover:bg-blue-50 transition">Register as Resident</a>
                    </div>
                </div>
            </div>
        </div>

        <p class="text-gray-400 text-sm mt-10">© <?php echo e(date('Y')); ?> Barangay Cubacub Relief and Donation Management Program. All rights reserved.</p>
    </div>
</body>
</html><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/welcome.blade.php ENDPATH**/ ?>