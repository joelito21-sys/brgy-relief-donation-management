<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Us - Barangay Cubacub Relief Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <!-- Navbar -->
    <nav class="bg-green-600 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-24">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-20 w-auto">
                    <a href="{{ route('home') }}" class="text-lg font-bold text-white hover:text-green-100 transition">Barangay Cubacub Relief</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-white hover:bg-green-700 px-3 py-2 rounded-md text-sm font-medium transition">Home</a>
                    <a href="{{ route('about') }}" class="text-white hover:bg-green-700 px-3 py-2 rounded-md text-sm font-medium transition">About Us</a>
                    <a href="{{ route('contact') }}" class="bg-white text-green-700 font-bold px-3 py-2 rounded-md text-sm transition shadow-sm">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-10">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Get in Touch</h1>
                <p class="text-xl text-gray-600">We'd love to hear from you. Please fill out the form below.</p>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-8 rounded shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700 font-medium">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden md:flex">
                <!-- Contact Info Side -->
                <div class="md:w-1/3 bg-gradient-to-br from-green-600 to-green-700 py-10 px-8 text-white flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-bold mb-6">Contact Information</h3>
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <i class="fas fa-map-marker-alt mt-1.5 w-6 text-green-200"></i>
                                <span class="ml-3 text-sm leading-6">Barangay Cubacub Hall,<br>Mandaue City, Cebu,<br>Philippines 6014</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-phone-alt w-6 text-green-200"></i>
                                <span class="ml-3 text-sm font-medium">+63 32 345 6789</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-envelope w-6 text-green-200"></i>
                                <span class="ml-3 text-sm font-medium">contact@barangaycubacub.gov.ph</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-10">
                         <div class="w-full h-48 rounded-lg overflow-hidden border border-white/10">
                            <a href="https://www.google.com/maps?q=Barangay+Cubacub+Hall,+Mandaue+City,+Cebu" target="_blank" rel="noopener noreferrer" class="block h-full w-full">
                                <img src="{{ asset('images/static_map.png') }}" alt="Map Location" class="w-full h-full object-cover transform hover:scale-105 transition duration-500">
                            </a>
                         </div>
                    </div>
                </div>

                <!-- Form Side -->
                <div class="md:w-2/3 py-10 px-8 md:px-12">
                    <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Full Name</label>
                                <input type="text" name="name" id="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition shadow-sm" placeholder="Your Name">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email Address</label>
                                <input type="email" name="email" id="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition shadow-sm" placeholder="you@example.com">
                            </div>

                            <div>
                                <label for="subject" class="block text-sm font-bold text-gray-700 mb-1">Subject / Recipient</label>
                                <div class="relative">
                                    <select name="subject" id="subject" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition shadow-sm appearance-none bg-white">
                                        <option value="" disabled selected>Select a recipient/topic</option>
                                        <option value="General Inquiry">General Inquiry</option>
                                        <option value="Donation Support">Donation Support</option>
                                        <option value="Relief Request Follow-up">Relief Request Follow-up</option>
                                        <option value="Direct Concern (serafinjoelito21@gmail.com)">Direct Concern for Joelito Serafin (serafinjoelito21@gmail.com)</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Select "Direct Concern" to email Joelito Serafin directly.</p>
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-bold text-gray-700 mb-1">Message</label>
                                <textarea name="message" id="message" rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition shadow-sm resize-none" placeholder="How can we help you?"></textarea>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all transform hover:-translate-y-0.5">
                                <i class="fas fa-paper-plane mr-2 mt-0.5"></i> Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 border-t border-gray-700 mt-auto">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-base text-gray-400">
                &copy; {{ date('Y') }} Barangay Cubacub Relief Management. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>
