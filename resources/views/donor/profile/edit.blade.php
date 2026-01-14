@extends('layouts.donor')

@section('title', 'My Profile')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-green-50 to-emerald-50 py-12 px-4">
    <div class="max-w-5xl mx-auto">
       

        <!-- Success Message -->
        @if (session('status'))
            <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-xl p-4 shadow-sm animate-fade-in">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            {{ session('status') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Summary Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 sticky top-6">
                    <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-8 relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-8 -mr-8 h-32 w-32 rounded-full bg-white opacity-10"></div>
                        <div class="absolute bottom-0 left-0 -mb-8 -ml-8 h-24 w-24 rounded-full bg-white opacity-10"></div>
                        <div class="relative z-10 text-center">
                            <div class="inline-block bg-white/20 backdrop-blur-sm rounded-full p-6 mb-4">
                                <i class="fas fa-user text-white text-5xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-white mb-1">{{ $user->name }}</h3>
                            <p class="text-green-100 text-sm">Donor Account</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center space-x-3 text-gray-700">
                            <i class="fas fa-envelope text-green-500 w-5"></i>
                            <span class="text-sm truncate">{{ $user->email }}</span>
                        </div>
                        <div class="flex items-center space-x-3 text-gray-700">
                            <i class="fas fa-phone text-green-500 w-5"></i>
                            <span class="text-sm">{{ $user->phone }}</span>
                        </div>
                        <div class="flex items-center space-x-3 text-gray-700">
                            <i class="fas fa-map-marker-alt text-green-500 w-5"></i>
                            <span class="text-sm">{{ $user->address ?? 'Not set' }}</span>
                        </div>
                        <div class="pt-4 border-t border-gray-200">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Member since</span>
                                <span class="font-semibold text-gray-900">{{ $user->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Profile Information Card -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-6">
                        <h2 class="text-2xl font-bold text-white flex items-center">
                            <i class="fas fa-id-card mr-3"></i>Profile Information
                        </h2>
                        <p class="text-green-100 mt-1">Update your account's profile information and email address</p>
                    </div>

                    <form method="POST" action="{{ route('donor.profile.update') }}" class="p-8">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-user text-green-500 mr-2"></i>Full Name
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                                       placeholder="Enter your full name">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-envelope text-green-500 mr-2"></i>Email Address
                                </label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                                       placeholder="your.email@example.com">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-phone text-green-500 mr-2"></i>Phone Number
                                </label>
                                <input type="text" 
                                       name="phone" 
                                       id="phone" 
                                       value="{{ old('phone', $user->phone) }}" 
                                       required
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                                       placeholder="09XX XXX XXXX">
                                @error('phone')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>Address
                                </label>
                                <textarea name="address" 
                                          id="address" 
                                          rows="3" 
                                          required
                                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all resize-none"
                                          placeholder="Enter your complete address">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div class="mt-8 flex justify-end">
                            <button type="submit" 
                                    class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-8 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex items-center">
                                <i class="fas fa-save mr-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Update Password Card -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-teal-600 to-cyan-600 px-8 py-6">
                        <h2 class="text-2xl font-bold text-white flex items-center">
                            <i class="fas fa-lock mr-3"></i>Update Password
                        </h2>
                        <p class="text-teal-100 mt-1">Leave these fields empty if you don't want to change your password</p>
                    </div>

                    <form method="POST" action="{{ route('donor.profile.update') }}" class="p-8">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Current Password -->
                            <div>
                                <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-key text-teal-500 mr-2"></i>Current Password
                                </label>
                                <input type="password" 
                                       name="current_password" 
                                       id="current_password" 
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all"
                                       placeholder="Enter your current password">
                                @error('current_password')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-lock text-teal-500 mr-2"></i>New Password
                                </label>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all"
                                       placeholder="Enter new password (min. 8 characters)">
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                                <p class="mt-2 text-xs text-gray-500">
                                    <i class="fas fa-info-circle mr-1"></i>Password must be at least 8 characters long
                                </p>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-check-circle text-teal-500 mr-2"></i>Confirm New Password
                                </label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all"
                                       placeholder="Confirm your new password">
                            </div>
                        </div>

                        <!-- Update Password Button -->
                        <div class="mt-8 flex justify-end">
                            <button type="submit" 
                                    class="bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white px-8 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex items-center">
                                <i class="fas fa-shield-alt mr-2"></i>Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.5s ease-out;
}
</style>
@endsection