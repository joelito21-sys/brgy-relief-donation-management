<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - Barangay Cubacub Relief and Donation Management Program</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .team-member:hover img { transform: scale(1.05); }
        .partner-logo { transition: all 0.3s ease; }
        .partner-logo:hover { transform: scale(1.1); }
        .hero-pattern {
            background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgcGF0dGVyblRyYW5zZm9ybT0icm90YXRlKDQ1KSI+PHJlY3Qgd2lkdGg9IjIwIiBoZWlnaHQ9IjIwIiBmaWxsPSJ3aGl0ZSIgZmlsbC1vcGFjaXR5PSIwLjA1Ii8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI3BhdHRlcm4pIi8+PC9zdmc+');
        }
        .impact-section {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }
        .donation-highlight {
            background: linear-gradient(135deg, #16ca46ff 0%, #0ec35dff 100%);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(18, 213, 145, 0.3);
        }
        .gallery-item {
            transition: all 0.3s ease;
        }
        .gallery-item:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body class="bg-white min-h-screen">
    <!-- Navigation -->
    <nav class="bg-green-600 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-24">
                <div class="flex items-center space-x-3">
                    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Barangay Cubacub Logo" class="h-20 w-auto">
                    <a href="<?php echo e(route('home')); ?>" class="text-2xl font-bold text-white">Barangay Cubacub Relief and Donation Management Program</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="<?php echo e(route('home')); ?>" class="text-white hover:text-green-200 px-3 py-2 rounded-md text-sm font-medium">Home</a>
                    <a href="/about" class="bg-green-700 text-white px-3 py-2 rounded-md text-sm font-medium">About Us</a>
                    <?php if(auth()->guard('donor')->check()): ?>
                       
                    <?php else: ?>
                        <a href="<?php echo e(route('donor.login')); ?>" class="text-white hover:text-green-200 px-3 py-2 rounded-md text-sm font-medium">Donor Login</a>
                        <a href="<?php echo e(route('donor.register')); ?>" class="bg-white text-green-600 px-4 py-2 rounded-md text-sm font-medium hover:bg-green-50">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <!-- Hero Section - Portal Style -->
        <div class="py-16 bg-gradient-to-br from-green-50 to-green-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl lg:text-5xl">
                        About Flood Relief
                    </h1>
                </div>
                
                <!-- Portal Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    <!-- Mission Card -->
                    <div class="bg-white rounded-2xl shadow-xl border border-white/70 p-8 text-center space-y-4 transition-all hover:shadow-2xl hover:-translate-y-2">
                        <div class="w-20 h-20 mx-auto rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Our Mission</h3>
                        <p class="text-gray-600">
                            Providing immediate relief and sustainable support to flood-affected communities
                        </p>
                    </div>
                    
                    <!-- Impact Card -->
                    <div class="bg-white rounded-2xl shadow-xl border border-white/70 p-8 text-center space-y-4 transition-all hover:shadow-2xl hover:-translate-y-2">
                        <div class="w-20 h-20 mx-auto rounded-full bg-blue-100 flex items-center justify-center">
                            <svg class="h-10 w-10 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Our Impact</h3>
                        <p class="text-gray-600">
                            Helping thousands of families rebuild their lives with dignity and hope
                        </p>
                    </div>
                    
                    <!-- Vision Card -->
                    <div class="bg-white rounded-2xl shadow-xl border border-white/70 p-8 text-center space-y-4 transition-all hover:shadow-2xl hover:-translate-y-2">
                        <div class="w-20 h-20 mx-auto rounded-full bg-purple-100 flex items-center justify-center">
                            <svg class="h-10 w-10 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Our Vision</h3>
                        <p class="text-gray-600">
                            A world where no community is left behind in times of disaster
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Donation Highlight Section -->
        <div class="py-16 bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">Our Collective Impact</h2>
                    <p class="mt-4 text-xl text-gray-600">Thanks to generous donors like you, we've been able to make a significant difference</p>
                </div>
                
                <div class="donation-highlight p-8 text-center mb-16">
                    <div class="max-w-3xl mx-auto">
                        <h3 class="text-2xl font-semibold text-white mb-4">Total Donations Received</h3>
                        <div class="text-5xl font-bold text-white mb-6">
                            ₱<?php echo e(number_format($totalDonations, 2)); ?>

                        </div>
                        <p class="text-green-100 text-lg">This represents the collective generosity of our community in supporting flood relief efforts</p>
                    </div>
                </div>
                
                <!-- Stats Section -->
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-16">
                    <!-- Total Donations -->
                    <div class="bg-white overflow-hidden shadow rounded-lg stat-card hover:shadow-lg transition-shadow duration-300">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Total Donations
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">
                                                ₱<?php echo e(number_format($totalDonations, 2)); ?>

                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- People Helped -->
                    <div class="bg-white overflow-hidden shadow rounded-lg stat-card hover:shadow-lg transition-shadow duration-300">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            People Helped
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">
                                                <?php echo e(number_format($peopleHelped)); ?>+
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Donors -->
                    <div class="bg-white overflow-hidden shadow rounded-lg stat-card hover:shadow-lg transition-shadow duration-300">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Total Donors
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">
                                                <?php echo e(number_format($totalDonors)); ?>

                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Relief Operations -->
                    <div class="bg-white overflow-hidden shadow rounded-lg stat-card hover:shadow-lg transition-shadow duration-300">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Relief Operations
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">
                                                <?php echo e(number_format($completedReliefRequests)); ?>

                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery Section -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">Our Work in Action</h2>
                    <p class="mt-4 text-xl text-gray-600">See how your donations are making a difference in communities</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feeding Program -->
                    <div class="gallery-item bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="h-64 overflow-hidden">
                            <img src="<?php echo e(asset('images/flood.jpeg')); ?>" alt="Feeding Program - People receiving food assistance" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Feeding Programs</h3>
                            <p class="text-gray-600">Providing nutritious meals to families affected by floods, ensuring no one goes hungry during difficult times.</p>
                        </div>
                    </div>
                    
                    <!-- Relief Distribution -->
                    <div class="gallery-item bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="h-64 overflow-hidden">
                            <img src="<?php echo e(asset('images/rescue.jpeg')); ?>" alt="Relief Distribution - Volunteers distributing aid supplies" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Relief Distribution</h3>
                            <p class="text-gray-600">Distributing essential supplies like clothing, blankets, and hygiene kits to those in need.</p>
                        </div>
                    </div>
                    
                    <!-- Shelter Support -->
                    <div class="gallery-item bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="h-64 overflow-hidden">
                            <img src="<?php echo e(asset('images/landslide.jpeg')); ?>" alt="Shelter Support - Temporary housing for displaced families" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Shelter Support</h3>
                            <p class="text-gray-600">Helping families rebuild their homes and providing temporary shelter during recovery periods.</p>
                        </div>
                    </div>
                    
                    <!-- Medical Aid -->
                    <div class="gallery-item bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="h-64 overflow-hidden">
                            <img src="<?php echo e(asset('images/OIP (1).jpg')); ?>" alt="Medical Aid - Healthcare workers assisting flood victims" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Medical Assistance</h3>
                            <p class="text-gray-600">Providing medical care and health services to flood victims, including vaccinations and check-ups.</p>
                        </div>
                    </div>
                    
                    <!-- Education Support -->
                    <div class="gallery-item bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="h-64 overflow-hidden">
                            <img src="<?php echo e(asset('images/OIP (2).jpg')); ?>" alt="Education Support - Children continuing their studies" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Education Support</h3>
                            <p class="text-gray-600">Ensuring children can continue their education despite displacement caused by flooding.</p>
                        </div>
                    </div>
                    
                    <!-- Community Rebuilding -->
                    <div class="gallery-item bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="h-64 overflow-hidden">
                            <img src="<?php echo e(asset('images/OIP (3).jpg')); ?>" alt="Community Rebuilding - Volunteers rebuilding infrastructure" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Community Rebuilding</h3>
                            <p class="text-gray-600">Working with local communities to rebuild infrastructure and strengthen resilience against future floods.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mission Section -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">Our Purpose</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Mission & Vision
                    </p>
                </div>

                <div class="mt-10">
                    <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                        <div class="relative">
                            <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div class="ml-16">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Our Mission</h3>
                                <p class="mt-2 text-base text-gray-500">
                                    To provide immediate relief and sustainable support to communities affected by floods, ensuring they have access to essential resources, shelter, and the means to rebuild their lives with dignity.
                                </p>
                            </div>
                        </div>

                        <div class="relative">
                            <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                                </svg>
                            </div>
                            <div class="ml-16">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Our Vision</h3>
                                <p class="mt-2 text-base text-gray-500">
                                    A world where no community is left behind in times of disaster, where resilience is built through preparedness, and where every individual has the support they need to recover and thrive.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <!-- Team Section -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">The People Behind</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Our Team
                    </p>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                        Meet the dedicated individuals who make our mission possible
                    </p>
                </div>

                <div class="mt-16 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Team Member 1 -->
                    <div class="team-member p-6 bg-white rounded-lg shadow-md text-center">
                        <div class="w-32 h-32 mx-auto rounded-full bg-gray-200 mb-4 overflow-hidden">
                            <img src="<?php echo e(asset('images/592182972_712817481477107_1983668944099758967_n.jpg')); ?>" alt="Sarah Johnson" class="w-full h-full object-cover transition-transform duration-300">
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Angela Opawan</h3>
                        <p class="text-blue-600">Executive Director</p>
                        <p class="mt-2 text-gray-600">Angela With over 15 years of experience in disaster management, Sarah leads our organization with compassion and strategic vision.</p>
                    </div>

                    <!-- Team Member 2 -->
                    <div class="team-member p-6 bg-white rounded-lg shadow-md text-center">
                        <div class="w-32 h-32 mx-auto rounded-full bg-gray-200 mb-4 overflow-hidden">
                            <img src="<?php echo e(asset('images/594452902_1369848030647551_3647686060341469210_n.jpg')); ?>" alt="Michael Chen" class="w-full h-full object-cover transition-transform duration-300">
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Rica Mae Manghihilot</h3>
                        <p class="text-blue-600">Operations Manager</p>
                        <p class="mt-2 text-gray-600">Rica Mae ensures our operations run smoothly, from logistics to community coordination, with precision and dedication.</p>
                    </div>

                    <!-- Team Member 3 -->
                    <div class="team-member p-6 bg-white rounded-lg shadow-md text-center">
                        <div class="w-32 h-32 mx-auto rounded-full bg-gray-200 mb-4 overflow-hidden">
                            <img src="<?php echo e(asset('images/598182351_1779457496095731_6690650627272076342_n.jpg')); ?>" alt="David Rodriguez" class="w-full h-full object-cover transition-transform duration-300">
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Jenny Pretty Joy Amamalin</h3>
                        <p class="text-blue-600">Community Outreach</p>
                        <p class="mt-2 text-gray-600">Jenny builds and maintains relationships with communities, ensuring our programs meet their specific needs.</p>
                    </div>

                    <!-- Team Member 4 -->
                    <div class="team-member p-6 bg-green rounded-lg shadow-md text-center">
                        <div class="w-32 h-32 mx-auto rounded-full bg-gray-200 mb-4 overflow-hidden">
                            <img src="<?php echo e(asset('images/Screenshot 2025-12-13 213524.png')); ?>" alt="Team Member" class="w-full h-full object-cover transition-transform duration-300">
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Joelito Serafin</h3>
                        <p class="text-blue-600">Programs Coordinator</p>
                        <p class="mt-2 text-gray-600">Joelito manages our  programs and ensures effective community engagement in all relief operations.</p>
                    </div>
                </div>
            </div>
        </div>


        <!-- CTA Section -->
        <div class="bg-green-700">
            <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    <span class="block">Ready to make a difference?</span>
                    <span class="block">Join our community of supporters today.</span>
                </h2>
                <p class="mt-4 text-lg leading-6 text-blue-100">
                    Your support helps us provide critical aid to communities affected by floods.
                </p>
                <a href="<?php echo e(route('donor.register')); ?>" class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 sm:w-auto">
                    Donate Now
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                <div class="space-y-8 xl:col-span-1">
                    <h3 class="text-white text-xl font-bold">Barangay Cubacub Relief and Donation Management Program</h3>
                    <p class="text-gray-300 text-base">
                        Connecting generosity with need to provide relief to flood-affected communities.
                    </p>
                </div>
                <div class="mt-12 grid grid-cols-2 gap-8 xl:mt-0 xl:col-span-2">
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Quick Links</h3>
                            <ul class="mt-4 space-y-4">

                            <div class="animate-slide-up" style="animation-delay: 0.7s;">
                    <a href="https://www.facebook.com/share/14JPg93ZW1d/" class="btn-outline group">
                        <i class="fab fa-facebook-f mr-2 group-hover:animate-pulse"></i> 
                        Facebook
                    </a>
                </div>
            </div>
        </div>
                                <li>
                                    <a href="<?php echo e(route('home')); ?>" class="text-base text-gray-400 hover:text-white">
                                        Home
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('about')); ?>" class="text-base text-gray-400 hover:text-white">
                                        About Us
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="text-base text-gray-400 hover:text-white">
                                        How It Works
                                    </a>
                                </li>
                            <//ul>
                        </div>
                        <div class="mt-12 md:mt-0">
                            <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Support</h3>
                            <ul class="mt-4 space-y-4">
                                <li>
                                    <a href="<?php echo e(route('contact')); ?>" class="text-base text-gray-400 hover:text-white">
                                        Contact Us
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="text-base text-gray-400 hover:text-white">
                                        FAQ
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="text-base text-gray-400 hover:text-white">
                                        Privacy Policy
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Get Involved</h3>
                            <ul class="mt-4 space-y-4">
                                <li>
                                    <a href="<?php echo e(route('donor.register')); ?>" class="text-base text-gray-400 hover:text-white">
                                        Become a Donor
                                    </a>
                                </li>
                                
                                
                                <li>
                                    <a href="#" class="text-base text-gray-400 hover:text-white">
                                        Partner With Us
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-700 pt-8">
                <p class="text-base text-gray-400 text-center">
                    &copy; <?php echo e(date('Y')); ?> Barangay Cubacub Relief and Donation Management Program. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</body>
</html><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/about.blade.php ENDPATH**/ ?>