@extends('layouts.donor')

@section('title', 'Activities & Impact')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-green-50 to-emerald-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-green-600 via-green-700 to-emerald-700 text-white py-16 px-4 relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.05\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        <div class="max-w-7xl mx-auto text-center relative z-10">
            <div class="inline-block bg-white/20 backdrop-blur-sm rounded-full px-6 py-2 mb-4">
                <i class="fas fa-heart text-red-300 mr-2"></i>
                <span class="text-sm font-semibold">Making a Difference Together</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4 text-center">Activities & Impact</h1>
            <p class="text-xl text-green-100 max-w-3xl mx-auto">See how your donations are making a difference in flood-affected communities</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-12">
        <!-- Impact Stats Cards -->
        <div class="mb-12">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-chart-line text-green-600 mr-3"></i>Your Impact at a Glance
                </h2>
                <p class="text-gray-600">Real-time statistics of our collective efforts</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Stat Card 1 -->
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-green-300 transform hover:-translate-y-2">
                    <div class="bg-gradient-to-br from-green-500 to-green-600 p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white opacity-10"></div>
                        <div class="absolute bottom-0 left-0 -mb-6 -ml-6 h-20 w-20 rounded-full bg-white opacity-10"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                                    <i class="fas fa-users text-white text-2xl"></i>
                                </div>
                                <div class="bg-white/20 backdrop-blur-sm rounded-full px-3 py-1">
                                    <span class="text-xs text-white font-semibold">+12%</span>
                                </div>
                            </div>
                            <div class="text-5xl font-bold text-white mb-2">15+</div>
                            <div class="text-green-100 font-medium">Families Helped</div>
                        </div>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-green-50 to-white">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                            <span class="font-semibold text-green-600">3 families</span> this week
                        </p>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-emerald-300 transform hover:-translate-y-2">
                    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white opacity-10"></div>
                        <div class="absolute bottom-0 left-0 -mb-6 -ml-6 h-20 w-20 rounded-full bg-white opacity-10"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                                    <i class="fas fa-box text-white text-2xl"></i>
                                </div>
                                <div class="bg-white/20 backdrop-blur-sm rounded-full px-3 py-1">
                                    <span class="text-xs text-white font-semibold">+25%</span>
                                </div>
                            </div>
                            <div class="text-5xl font-bold text-white mb-2">50+</div>
                            <div class="text-emerald-100 font-medium">Emergency Kits</div>
                        </div>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-emerald-50 to-white">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-arrow-up text-emerald-500 mr-1"></i>
                            <span class="font-semibold text-emerald-600">10 kits</span> distributed
                        </p>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-teal-300 transform hover:-translate-y-2">
                    <div class="bg-gradient-to-br from-teal-500 to-teal-600 p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white opacity-10"></div>
                        <div class="absolute bottom-0 left-0 -mb-6 -ml-6 h-20 w-20 rounded-full bg-white opacity-10"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                                    <i class="fas fa-utensils text-white text-2xl"></i>
                                </div>
                                <div class="bg-white/20 backdrop-blur-sm rounded-full px-3 py-1">
                                    <span class="text-xs text-white font-semibold">+18%</span>
                                </div>
                            </div>
                            <div class="text-5xl font-bold text-white mb-2">100+</div>
                            <div class="text-teal-100 font-medium">Meals Provided</div>
                        </div>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-teal-50 to-white">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-arrow-up text-teal-500 mr-1"></i>
                            <span class="font-semibold text-teal-600">15 meals</span> today
                        </p>
                    </div>
                </div>

                <!-- Stat Card 4 -->
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-lime-300 transform hover:-translate-y-2">
                    <div class="bg-gradient-to-br from-lime-500 to-lime-600 p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white opacity-10"></div>
                        <div class="absolute bottom-0 left-0 -mb-6 -ml-6 h-20 w-20 rounded-full bg-white opacity-10"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                                    <i class="fas fa-map-marked-alt text-white text-2xl"></i>
                                </div>
                                <div class="bg-white/20 backdrop-blur-sm rounded-full px-3 py-1">
                                    <span class="text-xs text-white font-semibold">+20%</span>
                                </div>
                            </div>
                            <div class="text-5xl font-bold text-white mb-2">5+</div>
                            <div class="text-lime-100 font-medium">Communities Reached</div>
                        </div>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-lime-50 to-white">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-arrow-up text-lime-500 mr-1"></i>
                            <span class="font-semibold text-lime-600">1 new</span> community
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="mb-12">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-tasks mr-3"></i>Recent Activities
                    </h2>
                    <p class="text-green-100 mt-1">Latest updates on flood relief efforts</p>
                </div>
                <div class="p-8">
                    <div class="flow-root">
                        <ul class="-mb-8">
                            <!-- Activity 1 -->
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gradient-to-b from-green-400 to-gray-200" aria-hidden="true"></span>
                                    <div class="relative flex items-start space-x-4">
                                        <div>
                                            <span class="h-10 w-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center ring-8 ring-white shadow-lg">
                                                <i class="fas fa-check text-white"></i>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 bg-gradient-to-br from-green-50 to-white rounded-xl p-6 shadow-sm border border-green-100">
                                            <div class="flex justify-between items-start">
                                                <div class="flex-1">
                                                    <p class="text-base font-semibold text-gray-900 mb-2">
                                                        Emergency relief kits distributed
                                                    </p>
                                                    <p class="text-sm text-gray-600">
                                                        15 families in <span class="font-medium text-green-700">Barangay San Jose</span> received essential supplies including food, water, and hygiene kits
                                                    </p>
                                                </div>
                                                <div class="ml-4 flex-shrink-0">
                                                    <div class="bg-white rounded-lg px-3 py-2 shadow-sm border border-gray-200">
                                                        <time datetime="2023-11-05" class="text-sm font-medium text-gray-700">Nov 5, 2023</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <!-- Activity 2 -->
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gradient-to-b from-blue-400 to-gray-200" aria-hidden="true"></span>
                                    <div class="relative flex items-start space-x-4">
                                        <div>
                                            <span class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center ring-8 ring-white shadow-lg">
                                                <i class="fas fa-truck text-white"></i>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 bg-gradient-to-br from-blue-50 to-white rounded-xl p-6 shadow-sm border border-blue-100">
                                            <div class="flex justify-between items-start">
                                                <div class="flex-1">
                                                    <p class="text-base font-semibold text-gray-900 mb-2">
                                                        Food packs delivered
                                                    </p>
                                                    <p class="text-sm text-gray-600">
                                                        30 affected families in <span class="font-medium text-blue-700">Barangay Magsaysay</span> received nutritious food packages
                                                    </p>
                                                </div>
                                                <div class="ml-4 flex-shrink-0">
                                                    <div class="bg-white rounded-lg px-3 py-2 shadow-sm border border-gray-200">
                                                        <time datetime="2023-10-28" class="text-sm font-medium text-gray-700">Oct 28, 2023</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <!-- Activity 3 -->
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gradient-to-b from-purple-400 to-gray-200" aria-hidden="true"></span>
                                    <div class="relative flex items-start space-x-4">
                                        <div>
                                            <span class="h-10 w-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center ring-8 ring-white shadow-lg">
                                                <i class="fas fa-home text-white"></i>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 bg-gradient-to-br from-purple-50 to-white rounded-xl p-6 shadow-sm border border-purple-100">
                                            <div class="flex justify-between items-start">
                                                <div class="flex-1">
                                                    <p class="text-base font-semibold text-gray-900 mb-2">
                                                        Temporary shelters established
                                                    </p>
                                                    <p class="text-sm text-gray-600">
                                                        Safe temporary housing set up in <span class="font-medium text-purple-700">Barangay Poblacion</span> for displaced families
                                                    </p>
                                                </div>
                                                <div class="ml-4 flex-shrink-0">
                                                    <div class="bg-white rounded-lg px-3 py-2 shadow-sm border border-gray-200">
                                                        <time datetime="2023-10-20" class="text-sm font-medium text-gray-700">Oct 20, 2023</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <!-- Activity 4 -->
                            <li>
                                <div class="relative">
                                    <div class="relative flex items-start space-x-4">
                                        <div>
                                            <span class="h-10 w-10 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center ring-8 ring-white shadow-lg">
                                                <i class="fas fa-users text-white"></i>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 bg-gradient-to-br from-yellow-50 to-white rounded-xl p-6 shadow-sm border border-yellow-100">
                                            <div class="flex justify-between items-start">
                                                <div class="flex-1">
                                                    <p class="text-base font-semibold text-gray-900 mb-2">
                                                        Community clean-up drive
                                                    </p>
                                                    <p class="text-sm text-gray-600">
                                                        Volunteers organized cleanup activities in <span class="font-medium text-yellow-700">Barangay San Isidro</span>
                                                    </p>
                                                </div>
                                                <div class="ml-4 flex-shrink-0">
                                                    <div class="bg-white rounded-lg px-3 py-2 shadow-sm border border-gray-200">
                                                        <time datetime="2023-10-15" class="text-sm font-medium text-gray-700">Oct 15, 2023</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="mb-12">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-green-600 to-teal-600 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <i class="far fa-calendar-alt mr-3"></i>Upcoming Events
                    </h2>
                    <p class="text-green-100 mt-1">Join us in our upcoming relief efforts</p>
                </div>
                <div class="p-8">
                    <div class="space-y-6">
                        <!-- Event 1 -->
                        <div class="group bg-gradient-to-br from-green-50 to-white rounded-xl p-6 shadow-sm border border-green-100 hover:shadow-lg transition-all duration-300 hover:border-green-300">
                            <div class="flex items-center space-x-6">
                                <div class="flex-shrink-0">
                                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-4 text-center shadow-lg min-w-[80px]">
                                        <div class="text-3xl font-bold text-white">20</div>
                                        <div class="text-xs text-green-200 font-semibold mt-1">NOV</div>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">Community Rebuilding Workshop</h3>
                                    <div class="flex flex-wrap gap-3 text-sm text-gray-600">
                                        <span class="flex items-center">
                                            <i class="far fa-clock text-green-500 mr-2"></i>
                                            9:00 AM - 3:00 PM
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                                            Barangay Hall, San Jose
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <button class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                        <i class="fas fa-calendar-check mr-2"></i>Join Event
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Event 2 -->
                        <div class="group bg-gradient-to-br from-emerald-50 to-white rounded-xl p-6 shadow-sm border border-emerald-100 hover:shadow-lg transition-all duration-300 hover:border-emerald-300">
                            <div class="flex items-center space-x-6">
                                <div class="flex-shrink-0">
                                    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-4 text-center shadow-lg min-w-[80px]">
                                        <div class="text-3xl font-bold text-white">25</div>
                                        <div class="text-xs text-emerald-200 font-semibold mt-1">NOV</div>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">Barangay Cubacub Relief and Donation Management Program Preparedness Seminar</h3>
                                    <div class="flex flex-wrap gap-3 text-sm text-gray-600">
                                        <span class="flex items-center">
                                            <i class="far fa-clock text-emerald-500 mr-2"></i>
                                            1:00 PM - 4:00 PM
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-map-marker-alt text-emerald-500 mr-2"></i>
                                            Municipal Hall, Poblacion
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <button class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                        <i class="fas fa-calendar-check mr-2"></i>Join Event
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Event 3 -->
                        <div class="group bg-gradient-to-br from-teal-50 to-white rounded-xl p-6 shadow-sm border border-teal-100 hover:shadow-lg transition-all duration-300 hover:border-teal-300">
                            <div class="flex items-center space-x-6">
                                <div class="flex-shrink-0">
                                    <div class="bg-gradient-to-br from-teal-500 to-teal-600 rounded-2xl p-4 text-center shadow-lg min-w-[80px]">
                                        <div class="text-3xl font-bold text-white">30</div>
                                        <div class="text-xs text-teal-200 font-semibold mt-1">NOV</div>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">Medical Mission</h3>
                                    <div class="flex flex-wrap gap-3 text-sm text-gray-600">
                                        <span class="flex items-center">
                                            <i class="far fa-clock text-teal-500 mr-2"></i>
                                            8:00 AM - 5:00 PM
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-map-marker-alt text-teal-500 mr-2"></i>
                                            Barangay Health Center, Magsaysay
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <button class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                        <i class="fas fa-calendar-check mr-2"></i>Join Event
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 text-center">
                        <a href="#" class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold text-lg group">
                            View all upcoming events
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stories of Hope -->
        <div class="mb-12">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-quote-left text-green-600 mr-3"></i>Stories of Hope
                </h2>
                <p class="text-gray-600">Hear from those whose lives have been touched by your generosity</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Testimonial 1 -->
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-green-200 transform hover:-translate-y-2">
                    <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-8 -mr-8 h-32 w-32 rounded-full bg-white opacity-10"></div>
                        <i class="fas fa-quote-right text-white text-4xl opacity-20 absolute bottom-4 right-4"></i>
                        <div class="relative z-10">
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="h-16 w-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center ring-4 ring-white/30">
                                    <i class="fas fa-user text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-white">Maria Santos</h3>
                                    <p class="text-green-100 text-sm">
                                        <i class="fas fa-map-marker-alt mr-1"></i>Barangay San Jose
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 italic leading-relaxed">
                            "The emergency kit we received was a lifeline for my family after our home was flooded. Thank you for your support during our most difficult time."
                        </p>
                        <div class="mt-4 flex items-center">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="ml-2 text-sm text-gray-500">5.0 Impact Rating</span>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-teal-200 transform hover:-translate-y-2">
                    <div class="bg-gradient-to-br from-teal-500 to-cyan-600 p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-8 -mr-8 h-32 w-32 rounded-full bg-white opacity-10"></div>
                        <i class="fas fa-quote-right text-white text-4xl opacity-20 absolute bottom-4 right-4"></i>
                        <div class="relative z-10">
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="h-16 w-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center ring-4 ring-white/30">
                                    <i class="fas fa-user text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-white">Juan Dela Cruz</h3>
                                    <p class="text-teal-100 text-sm">
                                        <i class="fas fa-map-marker-alt mr-1"></i>Barangay Poblacion
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 italic leading-relaxed">
                            "The temporary shelter provided a safe place for my children while we rebuild our home. We are forever grateful for your kindness."
                        </p>
                        <div class="mt-4 flex items-center">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="ml-2 text-sm text-gray-500">5.0 Impact Rating</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection