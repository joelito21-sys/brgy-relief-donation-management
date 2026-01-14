@extends('donor.layouts.dashboard')

@section('title', 'About Us - Donor Portal')

@section('header', 'About Our Barangay Cubacub Relief and Donation Management Program Mission')

@section('content')
    <!-- Hero Section -->
    <div class="py-20 hero-pattern">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                About Barangay Cubacub Relief and Donation Management Program
            </h1>
            <p class="mt-6 max-w-3xl mx-auto text-xl text-blue-100">
                Making a Difference Together
            </p>
            <p class="mt-3 max-w-3xl mx-auto text-lg text-blue-100 md:text-xl">
                We are a dedicated team working tirelessly to provide relief and support to communities affected by floods.
            </p>
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
                        ₱{{ number_format($totalDonations, 2) }}
                    </div>
                    <p class="text-blue-100 text-lg">This represents the collective generosity of our community in supporting flood relief efforts</p>
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
                                            ₱{{ number_format($totalDonations, 2) }}
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
                                            {{ number_format($peopleHelped) }}
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
                                            {{ number_format($totalDonors) }}
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
                                            {{ number_format($completedReliefRequests) }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Donor -->
                <div class="bg-white overflow-hidden shadow rounded-lg stat-card hover:shadow-lg transition-shadow duration-300 col-span-full">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Top Donor
                                    </dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-lg font-semibold text-gray-900">
                                            @if($topDonor && $topDonor->name)
                                                {{ $topDonor->name }}
                                                <span class="text-sm text-gray-500">
                                                    (₱{{ number_format($topDonor->total_donated ?? 0, 2) }} donated)
                                                </span>
                                            @else
                                                <span class="text-gray-500">No donations yet</span>
                                            @endif
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
                        <img src="https://images.unsplash.com/photo-1593118247619-e2d6f056869e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Feeding Program" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Feeding Programs</h3>
                        <p class="text-gray-600">Providing nutritious meals to families affected by floods, ensuring no one goes hungry during difficult times.</p>
                    </div>
                </div>
                
                <!-- Relief Distribution -->
                <div class="gallery-item bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1588277307392-75289b68c9eb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Relief Distribution" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Relief Distribution</h3>
                        <p class="text-gray-600">Distributing essential supplies like clothing, blankets, and hygiene kits to those in need.</p>
                    </div>
                </div>
                
                <!-- Shelter Support -->
                <div class="gallery-item bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1593305841991-05c297ba4575?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Shelter Support" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Shelter Support</h3>
                        <p class="text-gray-600">Helping families rebuild their homes and providing temporary shelter during recovery periods.</p>
                    </div>
                </div>
                
                <!-- Medical Aid -->
                <div class="gallery-item bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Medical Aid" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Medical Assistance</h3>
                        <p class="text-gray-600">Providing medical care and health services to flood victims, including vaccinations and check-ups.</p>
                    </div>
                </div>
                
                <!-- Education Support -->
                <div class="gallery-item bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Education Support" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Education Support</h3>
                        <p class="text-gray-600">Ensuring children can continue their education despite displacement caused by flooding.</p>
                    </div>
                </div>
                
                <!-- Community Rebuilding -->
                <div class="gallery-item bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1593118247619-e2d6f056869e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Community Rebuilding" class="w-full h-full object-cover">
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

    <!-- Our Journey Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">Our Journey</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Our Story
                </p>
            </div>
            <div class="mt-10 max-w-3xl mx-auto text-lg text-gray-500">
                <p class="mb-6">
                    Barangay Cubacub Relief and Donation Management Program was founded in 2018 in response to the devastating floods that affected thousands of families in our region. What started as a small group of volunteers delivering food and supplies has grown into a comprehensive disaster response organization.
                </p>
                <p>
                    Over the years, we've expanded our reach, improved our response systems, and developed sustainable programs that not only provide immediate relief but also help communities prepare for and recover from flood disasters. Our network now includes hundreds of volunteers, partner organizations, and generous donors like you.
                </p>
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
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Sarah Johnson" class="w-full h-full object-cover transition-transform duration-300">
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Sarah Johnson</h3>
                    <p class="text-blue-600">Executive Director</p>
                    <p class="mt-2 text-gray-600">With over 15 years of experience in disaster management, Sarah leads our organization with compassion and strategic vision.</p>
                </div>

                <!-- Team Member 2 -->
                <div class="team-member p-6 bg-white rounded-lg shadow-md text-center">
                    <div class="w-32 h-32 mx-auto rounded-full bg-gray-200 mb-4 overflow-hidden">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Michael Chen" class="w-full h-full object-cover transition-transform duration-300">
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Michael Chen</h3>
                    <p class="text-blue-600">Operations Manager</p>
                    <p class="mt-2 text-gray-600">Michael ensures our operations run smoothly, from logistics to volunteer coordination, with precision and dedication.</p>
                </div>

                <!-- Team Member 3 -->
                <div class="team-member p-6 bg-white rounded-lg shadow-md text-center">
                    <div class="w-32 h-32 mx-auto rounded-full bg-gray-200 mb-4 overflow-hidden">
                        <img src="https://randomuser.me/api/portraits/men/46.jpg" alt="David Rodriguez" class="w-full h-full object-cover transition-transform duration-300">
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">David Rodriguez</h3>
                    <p class="text-blue-600">Community Outreach</p>
                    <p class="mt-2 text-gray-600">David builds and maintains relationships with communities, ensuring our programs meet their specific needs.</p>
                </div>
            </div>

            <div class="mt-12 text-center">
                <p class="text-gray-500">And our incredible team of 50+ staff members and 200+ volunteers</p>
                <p class="mt-4 text-lg font-medium text-gray-900">Together, we're making a difference in the lives of those affected by floods.</p>
            </div>
        </div>
    </div>

    <!-- Partners Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-12">
                <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">Collaboration</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Our Partners
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    We work with amazing organizations to maximize our impact
                </p>
            </div>

            <div class="grid grid-cols-2 gap-8 md:grid-cols-3 lg:grid-cols-6">
                <!-- Partner logos would go here -->
                <div class="partner-logo flex items-center justify-center">
                    <img class="h-12" src="https://via.placeholder.com/150x60?text=Partner+1" alt="Partner 1">
                </div>
                <div class="partner-logo flex items-center justify-center">
                    <img class="h-12" src="https://via.placeholder.com/150x60?text=Partner+2" alt="Partner 2">
                </div>
                <div class="partner-logo flex items-center justify-center">
                    <img class="h-12" src="https://via.placeholder.com/150x60?text=Partner+3" alt="Partner 3">
                </div>
                <div class="partner-logo flex items-center justify-center">
                    <img class="h-12" src="https://via.placeholder.com/150x60?text=Partner+4" alt="Partner 4">
                </div>
                <div class="partner-logo flex items-center justify-center">
                    <img class="h-12" src="https://via.placeholder.com/150x60?text=Partner+5" alt="Partner 5">
                </div>
                <div class="partner-logo flex items-center justify-center">
                    <img class="h-12" src="https://via.placeholder.com/150x60?text=Partner+6" alt="Partner 6">
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-blue-700">
        <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                <span class="block">Ready to make a difference?</span>
                <span class="block">Join our community of supporters today.</span>
            </h2>
            <p class="mt-4 text-lg leading-6 text-blue-100">
                Your support helps us provide critical aid to communities affected by floods.
            </p>
            <a href="{{ route('donor.register') }}" class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 sm:w-auto">
                Donate Now
            </a>
        </div>
    </div>

@endsection