@extends('admin.layouts.app')

@section('title', 'Create New Resident')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl border border-violet-200">
        

        <!-- Form -->
        <form method="POST" action="{{ route('admin.residents.store') }}" class="p-6">
            @csrf
            
            <!-- Personal Information -->
            <div class="mb-8">
                <h2 class="text-lg font-bold text-black mb-4 pb-2 border-b border-gray-200">Personal Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-bold text-black mb-2">First Name *</label>
                        <input type="text" 
                               name="first_name" 
                               id="first_name" 
                               value="{{ old('first_name') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="Juan"
                               required>
                        @error('first_name')
                            <p class="mt-2 text-red-600 text-sm font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-bold text-black mb-2">Last Name *</label>
                        <input type="text" 
                               name="last_name" 
                               id="last_name" 
                               value="{{ old('last_name') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="Dela Cruz"
                               required>
                        @error('last_name')
                            <p class="mt-2 text-red-600 text-sm font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-black mb-2">Email Address *</label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="resident@example.com"
                               required>
                        @error('email')
                            <p class="mt-2 text-red-600 text-sm font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-black mb-2">Password *</label>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="••••••••"
                               required>
                        @error('password')
                            <p class="mt-2 text-red-600 text-sm font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-black mb-2">Confirm Password *</label>
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="••••••••"
                               required>
                        @error('password_confirmation')
                            <p class="mt-2 text-red-600 text-sm font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-bold text-black mb-2">Phone Number *</label>
                        <input type="text" 
                               name="phone" 
                               id="phone" 
                               value="{{ old('phone') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="09XX-XXX-XXXX"
                               required>
                        @error('phone')
                            <p class="mt-2 text-red-600 text-sm font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ID Number -->
                    <div>
                        <label for="id_number" class="block text-sm font-bold text-black mb-2">ID Number *</label>
                        <input type="text" 
                               name="id_number" 
                               id="id_number" 
                               value="{{ old('id_number') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="Government ID Number"
                               required>
                        @error('id_number')
                            <p class="mt-2 text-red-600 text-sm font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ID Type -->
                    <div>
                        <label for="id_type" class="block text-sm font-bold text-black mb-2">ID Type *</label>
                        <select name="id_type" 
                                id="id_type"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                                required>
                            <option value="">Select ID type</option>
                            <option value="passport" {{ old('id_type') == 'passport' ? 'selected' : '' }}>Passport</option>
                            <option value="driver_license" {{ old('id_type') == 'driver_license' ? 'selected' : '' }}>Driver's License</option>
                            <option value="sss" {{ old('id_type') == 'sss' ? 'selected' : '' }}>SSS ID</option>
                            <option value="voters_id" {{ old('id_type') == 'voters_id' ? 'selected' : '' }}>Voter's ID</option>
                            <option value="philhealth" {{ old('id_type') == 'philhealth' ? 'selected' : '' }}>PhilHealth ID</option>
                            <option value="others" {{ old('id_type') == 'others' ? 'selected' : '' }}>Others</option>
                        </select>
                        @error('id_type')
                            <p class="mt-2 text-red-600 text-sm font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="mb-8">
                <h2 class="text-lg font-bold text-black mb-4 pb-2 border-b border-gray-200">Address Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Street Address -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-bold text-black mb-2">Street Address *</label>
                        <input type="text" 
                               name="address" 
                               id="address" 
                               value="{{ old('address') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="123 Main Street"
                               required>
                        @error('address')
                            <p class="mt-2 text-red-600 text-sm font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Barangay -->
                    <div>
                        <label for="barangay" class="block text-sm font-bold text-black mb-2">Barangay *</label>
                        <input type="text" 
                               name="barangay" 
                               id="barangay" 
                               value="{{ old('barangay') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="Barangay Name"
                               required>
                        @error('barangay')
                            <p class="mt-2 text-red-600 text-sm font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-bold text-black mb-2">City *</label>
                        <input type="text" 
                               name="city" 
                               id="city" 
                               value="{{ old('city') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="City Name"
                               required>
                        @error('city')
                            <p class="mt-2 text-red-600 text-sm font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Province -->
                    <div>
                        <label for="province" class="block text-sm font-bold text-black mb-2">Province *</label>
                        <input type="text" 
                               name="province" 
                               id="province" 
                               value="{{ old('province') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="Province Name"
                               required>
                        @error('province')
                            <p class="mt-2 text-red-600 text-sm font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Postal Code -->
                    <div>
                        <label for="postal_code" class="block text-sm font-bold text-black mb-2">Postal Code</label>
                        <input type="text" 
                               name="postal_code" 
                               id="postal_code" 
                               value="{{ old('postal_code') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="XXXX">
                        @error('postal_code')
                            <p class="mt-2 text-red-600 text-sm font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Emergency Contact -->
            <div class="mb-8">
                <h2 class="text-lg font-bold text-black mb-4 pb-2 border-b border-gray-200">Emergency Contact</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Emergency Contact Name -->
                    <div>
                        <label for="emergency_contact_name" class="block text-sm font-bold text-black mb-2">Emergency Contact Name *</label>
                        <input type="text" 
                               name="emergency_contact_name" 
                               id="emergency_contact_name" 
                               value="{{ old('emergency_contact_name') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="Contact Person Name"
                               required>
                        @error('emergency_contact_name')
                            <p class="mt-2 text-red-600 text-sm font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Emergency Contact Phone -->
                    <div>
                        <label for="emergency_contact_phone" class="block text-sm font-bold text-black mb-2">Emergency Contact Phone *</label>
                        <input type="text" 
                               name="emergency_contact_phone" 
                               id="emergency_contact_phone" 
                               value="{{ old('emergency_contact_phone') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="09XX-XXX-XXXX"
                               required>
                        @error('emergency_contact_phone')
                            <p class="mt-2 text-red-600 text-sm font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-violet-600 to-violet-700 text-white rounded-lg hover:from-violet-700 hover:to-violet-800 transition-all transform hover:scale-105 shadow-lg font-bold">
                    <i class="fas fa-save mr-2"></i>Create Resident
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Make all text black */
    .text-gray-700, .text-gray-600, .text-gray-500 {
        color: black !important;
        font-weight: bold !important;
    }
    
    .text-sm, .text-xs {
        font-weight: bold !important;
    }
    
    input::placeholder, textarea::placeholder, select::placeholder {
        color: #9CA3AF !important;
        font-weight: normal !important;
    }
</style>
@endsection