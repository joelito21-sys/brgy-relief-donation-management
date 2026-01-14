@extends('layouts.donor')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Card -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="flex items-center mb-4 md:mb-0">
                        <div class="bg-white p-3 rounded-xl mr-4">
                            <i class="fas fa-person-walking text-3xl text-orange-500"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-white">Walk-in Donation Appointment</h1>
                            <p class="text-orange-100 mt-1">Schedule your visit to make a donation in person</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6 md:p-8">
                <!-- Progress Steps -->
                <div class="mb-8">
                    <div class="flex justify-between relative">
                        <div class="absolute top-4 left-0 right-0 h-1 bg-gray-200 z-0"></div>
                        <div class="absolute top-4 left-0 w-2/3 h-1 bg-orange-500 z-10"></div>
                        <div class="relative z-20 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-orange-500 flex items-center justify-center text-white font-bold">1</div>
                            <span class="mt-2 text-sm font-medium text-gray-700">Schedule</span>
                        </div>
                        <div class="relative z-20 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-orange-500 flex items-center justify-center text-white font-bold">2</div>
                            <span class="mt-2 text-sm font-medium text-gray-700">Visit Office</span>
                        </div>
                        <div class="relative z-20 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-500 font-bold">3</div>
                            <span class="mt-2 text-sm font-medium text-gray-500">Complete</span>
                        </div>
                    </div>
                </div>

                <!-- Complete Location Information -->
                <div class="mb-8">
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Our Office Location</h3>
                        <p class="text-gray-600 mb-6">Visit us at our central office for in-person donations</p>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Map Section -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-map-location-dot text-orange-500 mr-2"></i>Location Map
                            </h4>
                            <div class="aspect-video bg-gray-200 rounded-lg flex items-center justify-center">
                                <div class="text-center">
                                    <i class="fas fa-map-pin text-4xl text-orange-500 mb-3"></i>
                                    <p class="text-gray-600">Interactive Map Placeholder</p>
                                    <p class="text-sm text-gray-500 mt-2">Map will show exact location and directions</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="https://maps.google.com/?q=123+Relief+Street,+Manila,+Philippines" target="_blank" 
                                   class="inline-flex items-center text-orange-600 hover:text-orange-700 font-medium">
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    Open in Google Maps
                                </a>
                            </div>
                        </div>
                        
                        <!-- Detailed Address Information -->
                        <div class="space-y-6">
                            <!-- Physical Address -->
                            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                                <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-building text-orange-500 mr-2"></i>Physical Address
                                </h4>
                                <div class="space-y-3">
                                    <div class="flex items-start">
                                        <i class="fas fa-location-dot text-gray-500 mt-1 mr-3"></i>
                                        <div>
                                            <p class="font-medium text-gray-800">Barangay Cubacub Relief and Donation Management Program Foundation</p>
                                            <p class="text-gray-700">123 Relief Street</p>
                                            <p class="text-gray-700">Barangay Hall, Manila</p>
                                            <p class="text-gray-700">Metro Manila, Philippines 1000</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Office Hours -->
                            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                                <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-clock text-orange-500 mr-2"></i>Office Hours
                                </h4>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-days text-gray-500 mr-3"></i>
                                        <div>
                                            <p class="font-medium text-gray-800">Monday - Friday</p>
                                            <p class="text-gray-700">9:00 AM - 6:00 PM</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-days text-gray-500 mr-3"></i>
                                        <div>
                                            <p class="font-medium text-gray-800">Saturday</p>
                                            <p class="text-gray-700">9:00 AM - 12:00 PM</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-xmark text-gray-500 mr-3"></i>
                                        <div>
                                            <p class="font-medium text-gray-800">Sunday</p>
                                            <p class="text-gray-700">Closed</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Look For Information -->
                            <div class="bg-orange-50 border-l-4 border-orange-500 rounded-xl p-6 shadow-sm">
                                <h4 class="font-semibold text-orange-800 mb-4 flex items-center">
                                    <i class="fas fa-user text-orange-500 mr-2"></i>Look For
                                </h4>
                                <div class="flex items-start">
                                    <i class="fas fa-info-circle text-orange-500 mt-1 mr-3"></i>
                                    <div>
                                        <p class="text-orange-800 font-medium">Ask for Jane at the front desk</p>
                                        <p class="text-orange-700 mt-1">Our donation coordinator will assist you with your contribution.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                        <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-phone text-orange-500 mr-2"></i>Phone
                        </h4>
                        <p class="text-2xl font-bold text-gray-800">+63 2 1234 5678</p>
                        <p class="text-gray-600 mt-2">Mon-Fri: 9:00 AM - 6:00 PM</p>
                    </div>
                    
                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                        <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-envelope text-orange-500 mr-2"></i>Email
                        </h4>
                        <p class="text-xl font-bold text-gray-800 break-all">info@floodrelief.org</p>
                        <p class="text-gray-600 mt-2">We typically respond within 24 hours</p>
                    </div>
                    
                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                        <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-comment text-orange-500 mr-2"></i>Emergency
                        </h4>
                        <p class="text-2xl font-bold text-gray-800">+63 912 345 6789</p>
                        <p class="text-gray-600 mt-2">For urgent matters only</p>
                    </div>
                </div>

                <!-- Appointment Scheduling -->
                <div class="bg-orange-50 border-l-4 border-orange-500 p-5 rounded-lg mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-plus text-orange-500 text-xl mt-0.5"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-orange-800 mb-2">Schedule Your Appointment</h4>
                            <p class="text-orange-700 mb-4">Appointments are required for all walk-in donations. Please select your preferred date and time below.</p>
                            
                            <form action="{{ route('donor.donations.cash.process', ['method' => 'walkin']) }}" method="POST">
                                @csrf
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-2">Preferred Date</label>
                                        <input type="date" 
                                               id="appointment_date" 
                                               name="appointment_date" 
                                               required
                                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-base">
                                    </div>
                                    
                                    <div>
                                        <label for="appointment_time" class="block text-sm font-medium text-gray-700 mb-2">Preferred Time</label>
                                        <select id="appointment_time" 
                                                name="appointment_time" 
                                                required
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-base">
                                            <option value="">Select time slot</option>
                                            <option value="9:00 AM - 10:00 AM">9:00 AM - 10:00 AM</option>
                                            <option value="10:00 AM - 11:00 AM">10:00 AM - 11:00 AM</option>
                                            <option value="11:00 AM - 12:00 PM">11:00 AM - 12:00 PM</option>
                                            <option value="1:00 PM - 2:00 PM">1:00 PM - 2:00 PM</option>
                                            <option value="2:00 PM - 3:00 PM">2:00 PM - 3:00 PM</option>
                                            <option value="3:00 PM - 4:00 PM">3:00 PM - 4:00 PM</option>
                                            <option value="4:00 PM - 5:00 PM">4:00 PM - 5:00 PM</option>
                                            <option value="5:00 PM - 6:00 PM">5:00 PM - 6:00 PM</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-6">
                                    <label for="appointment_type" class="block text-sm font-medium text-gray-700 mb-2">Purpose of Visit</label>
                                    <select id="appointment_type" 
                                            name="appointment_type" 
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-base">
                                        <option value="">Select purpose</option>
                                        <option value="consultation">Consultation - Discuss donation options</option>
                                        <option value="direct_donation">Direct Donation - Ready to donate</option>
                                        <option value="item_dropoff">Item Drop-off - Dropping off donated items</option>
                                        <option value="followup">Follow-up - Follow-up on previous donation</option>
                                    </select>
                                </div>
                                
                                <div class="mb-6">
                                    <label for="appointment_notes" class="block text-sm font-medium text-gray-700 mb-2">Additional Information (Optional)</label>
                                    <textarea id="appointment_notes" 
                                              name="appointment_notes" 
                                              rows="4" 
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-base"
                                              placeholder="Any special requirements, questions, or items you plan to donate..."></textarea>
                                </div>
                                
                                <div class="flex items-center mb-6 p-4 bg-white rounded-xl border border-gray-200">
                                    <input id="terms" name="terms" type="checkbox" required
                                           class="h-5 w-5 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                                    <label for="terms" class="ml-3 block text-base text-gray-700">
                                        I agree to the <a href="#" class="text-orange-600 hover:underline">Terms and Conditions</a> and confirm that I will visit the office on the scheduled date and time.
                                    </label>
                                </div>
                                
                                <div class="flex flex-col sm:flex-row justify-between gap-4 pt-4 border-t border-gray-200">
                                    <a href="{{ route('donor.donations.cash.index') }}" 
                                       class="px-6 py-3 border-2 border-gray-300 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all flex items-center justify-center">
                                        <i class="fas fa-arrow-left mr-2"></i>Back to Payment Methods
                                    </a>
                                    <button type="submit" 
                                            class="px-6 py-3 border border-transparent text-base font-medium rounded-xl shadow-sm text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all flex items-center justify-center">
                                        <i class="fas fa-calendar-check mr-2"></i>Confirm Appointment
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection