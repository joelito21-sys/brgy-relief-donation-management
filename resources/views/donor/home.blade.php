@extends('donor.layouts.app')

@section('title', 'Donor Dashboard - Barangay Cubacub Relief and Donation Management Program')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Welcome Section -->
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome, {{ Auth::guard('donor')->user()->name }}!</h1>
            <p class="text-lg text-gray-600">Thank you for supporting Barangay Cubacub Relief and Donation Management Program efforts. What would you like to do today?</p>
        </div>

        <!-- Navigation Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Donate Card -->
            <a href="{{ route('donor.donate.index') }}" class="group bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200 border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-100 p-3 rounded-lg group-hover:bg-indigo-600 transition-colors duration-200">
                            <i class="fas fa-hand-holding-heart text-indigo-600 text-2xl group-hover:text-white"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600">Make a Donation</h3>
                            <p class="mt-1 text-sm text-gray-500">Support our flood relief efforts with your contribution</p>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Donation History Card -->
            <a href="{{ route('donor.history') }}" class="group bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200 border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 p-3 rounded-lg group-hover:bg-green-600 transition-colors duration-200">
                            <i class="fas fa-history text-green-600 text-2xl group-hover:text-white"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-green-600">Donation History</h3>
                            <p class="mt-1 text-sm text-gray-500">View your past donations and receipts</p>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Activities Card -->
            <a href="{{ route('donor.activities') }}" class="group bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200 border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-100 p-3 rounded-lg group-hover:bg-yellow-500 transition-colors duration-200">
                            <i class="fas fa-tasks text-yellow-600 text-2xl group-hover:text-white"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-yellow-600">View Activities</h3>
                            <p class="mt-1 text-sm text-gray-500">See how your donations are making an impact</p>
                        </div>
                    </div>
                </div>
            </a>

            <!-- About Us Card -->
            <a href="{{ route('donor.about') }}" class="group bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200 border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 p-3 rounded-lg group-hover:bg-blue-600 transition-colors duration-200">
                            <i class="fas fa-info-circle text-blue-600 text-2xl group-hover:text-white"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600">About Us</h3>
                            <p class="mt-1 text-sm text-gray-500">Learn more about our mission and team</p>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Contact Us Card -->
            <a href="{{ route('donor.contact') }}" class="group bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200 border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-100 p-3 rounded-lg group-hover:bg-purple-600 transition-colors duration-200">
                            <i class="fas fa-envelope text-purple-600 text-2xl group-hover:text-white"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600">Contact Us</h3>
                            <p class="mt-1 text-sm text-gray-500">Get in touch with our team</p>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Profile Card -->
            <a href="{{ route('donor.profile') }}" class="group bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200 border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-pink-100 p-3 rounded-lg group-hover:bg-pink-600 transition-colors duration-200">
                            <i class="fas fa-user-circle text-pink-600 text-2xl group-hover:text-white"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-pink-600">My Profile</h3>
                            <p class="mt-1 text-sm text-gray-500">View and update your profile information</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
