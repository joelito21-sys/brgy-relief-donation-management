@extends('layouts.resident')

@section('title', 'Help & Support - Barangay Cubacub Relief and Donation Management Program')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
        <div class="container mx-auto px-4 py-12">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full backdrop-blur-sm mb-4">
                    <i class="fas fa-life-ring text-2xl"></i>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold mb-4">Help & Support</h1>
                <p class="text-lg text-light-blue-100 max-w-2xl mx-auto">
                    Find answers to common questions and get the support you need during difficult times.
                </p>
            </div>
        </div>
    </div>

    <!-- Quick Help Categories -->
    <div class="container mx-auto px-4 py-8">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="#emergency-help" class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6 text-center group">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-red-200 transition-colors">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Emergency Help</h3>
                <p class="text-sm text-gray-600">Immediate assistance for urgent situations</p>
            </a>

            <a href="#relief-requests" class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6 text-center group">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition-colors">
                    <i class="fas fa-hand-holding-heart text-blue-600"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Relief Requests</h3>
                <p class="text-sm text-gray-600">How to request and track relief assistance</p>
            </a>

            <a href="#donations" class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6 text-center group">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-200 transition-colors">
                    <i class="fas fa-box text-green-600"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Donations</h3>
                <p class="text-sm text-gray-600">Understanding distribution and receiving items</p>
            </a>

            <a href="#evacuation" class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6 text-center group">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-200 transition-colors">
                    <i class="fas fa-home text-purple-600"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Evacuation</h3>
                <p class="text-sm text-gray-600">Evacuation procedures and safety guidelines</p>
            </a>
        </div>
    </div>

    <!-- Emergency Help Section -->
    <section id="emergency-help" class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex items-center mb-8">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Emergency Help</h2>
                    <p class="text-gray-600">What to do in immediate danger</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                    <h3 class="font-semibold text-red-900 mb-4">
                        <i class="fas fa-phone-alt mr-2"></i>
                        Emergency Contacts
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-3 bg-white rounded">
                            <span class="font-medium">Emergency Hotline</span>
                            <span class="text-red-600 font-bold">911</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-white rounded">
                            <span class="font-medium">Flood Response Team</span>
                            <span class="text-blue-600 font-bold">(123) 456-7890</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-white rounded">
                            <span class="font-medium">Local Rescue</span>
                            <span class="text-green-600 font-bold">(123) 456-7891</span>
                        </div>
                    </div>
                </div>

                <div class="bg-orange-50 border border-orange-200 rounded-lg p-6">
                    <h3 class="font-semibold text-orange-900 mb-4">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        Immediate Actions
                    </h3>
                    <ol class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <span class="font-bold mr-2">1.</span>
                            Move to higher ground immediately if water is rising
                        </li>
                        <li class="flex items-start">
                            <span class="font-bold mr-2">2.</span>
                            Turn off utilities at the main switches if instructed
                        </li>
                        <li class="flex items-start">
                            <span class="font-bold mr-2">3.</span>
                            Avoid walking or driving through flood waters
                        </li>
                        <li class="flex items-start">
                            <span class="font-bold mr-2">4.</span>
                            Contact emergency services if trapped or in danger
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Relief Requests Section -->
    <section id="relief-requests" class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center mb-8">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-hand-holding-heart text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Relief Requests</h2>
                    <p class="text-gray-600">How to get assistance</p>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-blue-600 text-2xl font-bold mb-4">1</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Submit Request</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Fill out the relief request form with your current situation and needs.
                    </p>
                    <a href="{{ route('resident.relief-requests.create') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                        Create Request →
                    </a>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-blue-600 text-2xl font-bold mb-4">2</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Wait for Approval</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Our team reviews your request and verifies your situation.
                    </p>
                    <div class="text-gray-500 text-sm">
                        Status updates sent via email/SMS
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-blue-600 text-2xl font-bold mb-4">3</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Receive Assistance</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Once approved, you'll receive notifications about distribution schedules.
                    </p>
                    <a href="{{ route('resident.relief-requests.index') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                        Track Status →
                    </a>
                </div>
            </div>

            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="font-semibold text-blue-900 mb-4">
                    <i class="fas fa-info-circle mr-2"></i>
                    Request Tips
                </h3>
                <ul class="grid md:grid-cols-2 gap-4 text-gray-700">
                    <li class="flex items-start">
                        <i class="fas fa-check text-blue-600 mr-2 mt-1"></i>
                        <span>Provide accurate contact information</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-blue-600 mr-2 mt-1"></i>
                        <span>List specific needs and family size</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-blue-600 mr-2 mt-1"></i>
                        <span>Include current evacuation status</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-blue-600 mr-2 mt-1"></i>
                        <span>Upload verification documents if available</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Donations Section -->
    <section id="donations" class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex items-center mb-8">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-box text-green-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Donations & Distribution</h2>
                    <p class="text-gray-600">Understanding how donations work</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Types of Assistance Available</h3>
                    <div class="space-y-3">
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <i class="fas fa-utensils text-green-600 mr-3"></i>
                            <div>
                                <div class="font-medium">Food Supplies</div>
                                <div class="text-sm text-gray-600">Rice, canned goods, water, essentials</div>
                            </div>
                        </div>
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <i class="fas fa-tshirt text-green-600 mr-3"></i>
                            <div>
                                <div class="font-medium">Clothing</div>
                                <div class="text-sm text-gray-600">Weather-appropriate clothing, blankets</div>
                            </div>
                        </div>
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <i class="fas fa-pills text-green-600 mr-3"></i>
                            <div>
                                <div class="font-medium">Medical Supplies</div>
                                <div class="text-sm text-gray-600">First aid, medications, hygiene items</div>
                            </div>
                        </div>
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <i class="fas fa-home text-green-600 mr-3"></i>
                            <div>
                                <div class="font-medium">Shelter Materials</div>
                                <div class="text-sm text-gray-600">Tarps, tents, repair materials</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Distribution Process</h3>
                    <div class="space-y-4">
                        <div class="border-l-4 border-green-500 pl-4">
                            <div class="font-medium text-gray-900">Notification</div>
                            <div class="text-sm text-gray-600">You'll receive SMS/email about distribution</div>
                        </div>
                        <div class="border-l-4 border-green-500 pl-4">
                            <div class="font-medium text-gray-900">Schedule</div>
                            <div class="text-sm text-gray-600">Specific time and location provided</div>
                        </div>
                        <div class="border-l-4 border-green-500 pl-4">
                            <div class="font-medium text-gray-900">Collection</div>
                            <div class="text-sm text-gray-600">Bring ID and request confirmation</div>
                        </div>
                        <div class="border-l-4 border-green-500 pl-4">
                            <div class="font-medium text-gray-900">Documentation</div>
                            <div class="text-sm text-gray-600">Sign receipt to confirm receipt</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Evacuation Section -->
    <section id="evacuation" class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center mb-8">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-home text-purple-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Evacuation Guidelines</h2>
                    <p class="text-gray-600">Stay safe during evacuation</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
                    <h3 class="font-semibold text-purple-900 mb-4">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        When to Evacuate
                    </h3>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <i class="fas fa-arrow-right text-purple-600 mr-2 mt-1"></i>
                            <span>Official evacuation order issued</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-arrow-right text-purple-600 mr-2 mt-1"></i>
                            <span>Water levels rising rapidly</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-arrow-right text-purple-600 mr-2 mt-1"></i>
                            <span>Authorities recommend evacuation</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-arrow-right text-purple-600 mr-2 mt-1"></i>
                            <span>Your home is in immediate danger</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-6">
                    <h3 class="font-semibold text-indigo-900 mb-4">
                        <i class="fas fa-suitcase mr-2"></i>
                        Emergency Kit Checklist
                    </h3>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <i class="fas fa-check text-indigo-600 mr-2 mt-1"></i>
                            <span>Water (1 gallon per person per day)</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-indigo-600 mr-2 mt-1"></i>
                            <span>Non-perishable food (3-day supply)</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-indigo-600 mr-2 mt-1"></i>
                            <span>Medications and medical supplies</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-indigo-600 mr-2 mt-1"></i>
                            <span>Important documents (waterproof)</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-indigo-600 mr-2 mt-1"></i>
                            <span>Flashlight, batteries, radio</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-indigo-600 mr-2 mt-1"></i>
                            <span>Change of clothes and hygiene items</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Support -->
    <section class="py-12 bg-white border-t">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Still Need Help?</h2>
                <p class="text-gray-600">Our support team is here to assist you</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Call Us</h3>
                    <p class="text-gray-600 mb-2">Monday-Friday, 8AM-6PM</p>
                    <p class="text-blue-600 font-medium">(123) 456-7890</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-green-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Email Support</h3>
                    <p class="text-gray-600 mb-2">24-48 hour response time</p>
                    <p class="text-green-600 font-medium">support@floodrelief.org</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-comments text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Live Chat</h3>
                    <p class="text-gray-600 mb-2">Available 9AM-5PM</p>
                    <button class="text-purple-600 font-medium hover:text-purple-700">Start Chat →</button>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
