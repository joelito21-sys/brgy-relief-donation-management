@extends('layouts.resident')

@section('title', 'Edit Profile')
@section('page-title', 'Edit Profile')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">Edit Profile</h2>
                <p class="text-gray-600 mt-1">Update your personal information</p>
            </div>

            <!-- Form -->
            <form class="p-6" method="POST" action="{{ route('resident.profile.update') }}">
                @csrf
                @method('PUT')

                <!-- Profile Photo -->
                <div class="mb-8">
                    <div class="flex items-center space-x-6">
                        <div class="shrink-0">
                            <img class="h-20 w-20 object-cover rounded-full" 
                                 src="{{ Auth::guard('resident')->user()->profile_photo_url }}" 
                                 alt="Profile photo">
                        </div>
                        <div class="flex-1">
                            <button type="button" class="bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Change Photo
                            </button>
                            <p class="text-xs text-gray-500 mt-1">JPG, GIF or PNG. Max size 2MB</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="col-span-2">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Personal Information</h3>
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Full Name
                        </label>
                        <input type="text" id="name" name="name" 
                               value="{{ Auth::guard('resident')->user()->name }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email Address
                        </label>
                        <input type="email" id="email" name="email" 
                               value="{{ Auth::guard('resident')->user()->email }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">
                            Phone Number
                        </label>
                        <input type="tel" id="phone" name="phone" 
                               value="{{ Auth::guard('resident')->user()->phone }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="id_number" class="block text-sm font-medium text-gray-700">
                            ID Number
                        </label>
                        <input type="text" id="id_number" name="id_number" 
                               value="{{ Auth::guard('resident')->user()->id_number }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- Address Information -->
                    <div class="col-span-2 mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Address Information</h3>
                    </div>

                    <div class="col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700">
                            Street Address
                        </label>
                        <input type="text" id="address" name="address" 
                               value="{{ Auth::guard('resident')->user()->address }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="barangay" class="block text-sm font-medium text-gray-700">
                            Barangay
                        </label>
                        <input type="text" id="barangay" name="barangay" 
                               value="{{ Auth::guard('resident')->user()->barangay }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">
                            City
                        </label>
                        <input type="text" id="city" name="city" 
                               value="{{ Auth::guard('resident')->user()->city }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700">
                            Province
                        </label>
                        <input type="text" id="province" name="province" 
                               value="{{ Auth::guard('resident')->user()->province }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700">
                            Postal Code
                        </label>
                        <input type="text" id="postal_code" name="postal_code" 
                               value="{{ Auth::guard('resident')->user()->postal_code }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- Emergency Contact -->
                    <div class="col-span-2 mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Emergency Contact</h3>
                    </div>

                    <div>
                        <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700">
                            Emergency Contact Name
                        </label>
                        <input type="text" id="emergency_contact_name" name="emergency_contact_name" 
                               value="{{ Auth::guard('resident')->user()->emergency_contact_name }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700">
                            Emergency Contact Phone
                        </label>
                        <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone" 
                               value="{{ Auth::guard('resident')->user()->emergency_contact_phone }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- Family Information -->
                    <div class="col-span-2 mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Family Information</h3>
                    </div>

                    <div>
                        <label for="family_size" class="block text-sm font-medium text-gray-700">
                            Family Size
                        </label>
                        <input type="number" id="family_size" name="family_size" min="1" max="50"
                               value="{{ Auth::guard('resident')->user()->family_size }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="special_needs" class="block text-sm font-medium text-gray-700">
                            Special Needs
                        </label>
                        <textarea id="special_needs" name="special_needs" rows="3"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ Auth::guard('resident')->user()->special_needs ? implode(', ', json_decode(Auth::guard('resident')->user()->special_needs, true) ?? []) : '' }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Any special medical needs, dietary restrictions, etc.</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('resident.dashboard') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
