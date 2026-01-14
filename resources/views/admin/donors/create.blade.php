@extends('admin.layouts.app')

@section('title', 'Create New Donor')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl border border-violet-200">
        <!-- Header -->
        <div class="border-b border-gray-200 p-6" style="background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-white">Create New Donor</h1>
                <a href="{{ route('admin.donors.index') }}" 
                   class="px-4 py-2 bg-white/20 text-white rounded-lg hover:bg-white/30 transition-colors font-bold">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Donors
                </a>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('admin.donors.store') }}" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-bold text-black mb-2">Full Name *</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                           placeholder="Enter full name"
                           required>
                    @error('name')
                        <p class="mt-2 text-red-600 text-sm font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="md:col-span-2">
                    <label for="email" class="block text-sm font-bold text-black mb-2">Email Address *</label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                           placeholder="Enter email address"
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
                           placeholder="Enter password"
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
                           placeholder="Confirm password"
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
                           placeholder="Enter phone number"
                           required>
                    @error('phone')
                        <p class="mt-2 text-red-600 text-sm font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Organization -->
                <div>
                    <label for="organization" class="block text-sm font-bold text-black mb-2">Organization</label>
                    <input type="text" 
                           name="organization" 
                           id="organization" 
                           value="{{ old('organization') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                           placeholder="Enter organization (optional)">
                    @error('organization')
                        <p class="mt-2 text-red-600 text-sm font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-bold text-black mb-2">Status *</label>
                    <select name="status" 
                            id="status"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                            required>
                        <option value="">Select Status</option>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-red-600 text-sm font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-8 flex justify-end">
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-violet-600 to-violet-700 text-black rounded-lg hover:from-violet-700 hover:to-violet-800 transition-all transform hover:scale-105 shadow-lg font-bold">
                    <i class="fas fa-save mr-2"></i>Create Donor
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
    
    input::placeholder, textarea::placeholder {
        color: #9CA3AF !important;
        font-weight: normal !important;
    }
</style>
@endsection