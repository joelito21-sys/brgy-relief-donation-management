<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Registration - {{ config('app.name') }}</title>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: linear-gradient(135deg, #74027aff 0%, #d010b9ff 100%); /* Blue gradient */
        }
        .sticky-header {
            position: sticky;
            top: 5px;
            z-index: 50;
            background: rgba(240, 242, 245, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 1rem 0;
            margin: -3rem -1rem 1rem -1rem;
            padding-left: 1rem;
            padding-right: 1rem;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl w-full space-y-8">
        <!-- Sticky Header -->
        <div class="sticky-header">
            <div class="mx-auto flex justify-center">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="h-16 w-auto">
            </div>
            <h2 class="mt-3 text-center text-2xl font-extrabold text-black">
                Resident Registration
            </h2>
            <p class="mt-1 text-center text-sm text-black">
                Create your flood relief assistance account
            </p>
        </div>
        
        
        <form class="mt-8 space-y-6" action="{{ route('resident.register.process') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="bg-blue-50 rounded-lg shadow-xl p-8"> <!-- Light blue background -->
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline">Please fix the errors below.</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="col-span-2">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                    </div>

                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">
                            First Name <span class="text-red-500">*</span>
                        </label>
                        <input id="first_name" name="first_name" type="text" required
                            class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Juan"
                            value="{{ old('first_name') }}">
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="middle_name" class="block text-sm font-medium text-gray-700">
                            Middle Name <span class="text-gray-400 text-xs">(Optional)</span>
                        </label>
                        <input id="middle_name" name="middle_name" type="text"
                            class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Santos"
                            value="{{ old('middle_name') }}">
                        @error('middle_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">
                            Last Name <span class="text-red-500">*</span>
                        </label>
                        <input id="last_name" name="last_name" type="text" required
                            class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Dela Cruz"
                            value="{{ old('last_name') }}">
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="suffix" class="block text-sm font-medium text-gray-700">
                            Suffix <span class="text-gray-400 text-xs">(Optional)</span>
                        </label>
                        <select id="suffix" name="suffix"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" {{ old('suffix') == '' ? 'selected' : '' }}>None</option>
                            <option value="Jr." {{ old('suffix') == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                            <option value="Sr." {{ old('suffix') == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                            <option value="II" {{ old('suffix') == 'II' ? 'selected' : '' }}>II</option>
                            <option value="III" {{ old('suffix') == 'III' ? 'selected' : '' }}>III</option>
                            <option value="IV" {{ old('suffix') == 'IV' ? 'selected' : '' }}>IV</option>
                            <option value="V" {{ old('suffix') == 'V' ? 'selected' : '' }}>V</option>
                        </select>
                        @error('suffix')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="birthdate" class="block text-sm font-medium text-gray-700">
                            Birthdate <span class="text-red-500">*</span>
                        </label>
                        <input id="birthdate" name="birthdate" type="date" required
                            class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('birthdate') }}"
                            max="{{ now()->subYears(18)->format('Y-m-d') }}">
                        <p class="mt-1 text-xs text-gray-500">You must be at least 18 years old to register.</p>
                        <p id="age-display" class="mt-1 text-sm text-green-600 hidden"></p>
                        <p id="age-error" class="mt-1 text-sm text-red-600 hidden">You must be at least 18 years old to register.</p>
                        @error('birthdate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input id="email" name="email" type="email" required
                            class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="resident@example.com"
                            value="{{ old('email') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input id="password" name="password" type="password" required
                            class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="••••••••">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    
                     <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="••••••••">
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">
                            Phone Number <span class="text-red-500">*</span>
                        </label>
                        <input id="phone" name="phone" type="tel" required maxlength="11"
                            class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="09123456789"
                            value="{{ old('phone', '09') }}">
                        <p class="mt-1 text-xs text-gray-500">Ex: 09123456789 (11 digits)</p>
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                   
                    <div class="row mb-3">
                        <label for="id_number" class="block text-sm font-medium text-gray-700">
                            ID Number <span class="text-red-500">*</span>
                        </label>
                        <input id="id_number" name="id_number" type="text" required
                            class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Government ID Number"
                            value="{{ old('id_number') }}">
                        @error('id_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <label for="id_type" class="block text-sm font-medium text-gray-700">
                            ID Type <span class="text-red-500">*</span>
                        </label>
                        <select id="id_type" name="id_type" required
                            class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="" disabled {{ old('id_type') ? '' : 'selected' }}>Select ID type</option>
                            <option value="National ID" {{ old('id_type') == 'National ID' ? 'selected' : '' }}>National ID</option>
                            <option value="Passport" {{ old('id_type') == 'Passport' ? 'selected' : '' }}>Passport</option>
                            <option value="Driver's License" {{ old('id_type') == "Driver's License" ? 'selected' : '' }}>Driver's License</option>
                            <option value="Postal ID" {{ old('id_type') == 'Postal ID' ? 'selected' : '' }}>Postal ID</option>
                        </select>
                        @error('id_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <label for="valid_id_front" class="block text-sm font-medium text-gray-700">
                            Valid ID (Front) <span class="text-red-500">*</span>
                        </label>
                        <input id="valid_id_front" name="valid_id_front" type="file" required accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @error('valid_id_front')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <label for="valid_id_back" class="block text-sm font-medium text-gray-700">
                            Valid ID (Back) <span class="text-red-500">*</span>
                        </label>
                        <input id="valid_id_back" name="valid_id_back" type="file" required accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @error('valid_id_back')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Face Verification Section -->
                    <div class="col-span-2 mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-user-check mr-2"></i>Face Verification
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">
                            To verify your identity, please take a selfie. We will compare it with your uploaded ID photo.
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- ID Photo Preview -->
                            <div class="bg-gray-100 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">ID Photo</h4>
                                <div id="id-photo-preview" class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                                    <p class="text-gray-500 text-sm" id="id-placeholder">Upload your ID to see preview</p>
                                    <img id="id-preview-img" class="hidden w-full h-full object-cover rounded-lg" alt="ID Preview">
                                </div>
                                <div id="id-face-status" class="mt-2 text-sm hidden">
                                    <span class="inline-flex items-center">
                                        <i class="fas fa-spinner fa-spin mr-2"></i>Detecting face...
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Selfie Capture -->
                            <div class="bg-gray-100 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Take Selfie</h4>
                                <div id="selfie-container" class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden relative">
                                    <video id="webcam-video" class="hidden w-full h-full object-cover rounded-lg" autoplay playsinline></video>
                                    <canvas id="selfie-canvas" class="hidden w-full h-full object-cover rounded-lg"></canvas>
                                    <img id="selfie-preview" class="hidden w-full h-full object-cover rounded-lg" alt="Selfie Preview">
                                    <p id="selfie-placeholder" class="text-gray-500 text-sm">Click button below to start camera</p>
                                </div>
                                <div class="mt-3 flex space-x-2">
                                    <button type="button" id="start-camera-btn" 
                                        class="flex-1 py-2 px-4 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                                        <i class="fas fa-camera mr-2"></i>Start Camera
                                    </button>
                                    <button type="button" id="capture-selfie-btn" 
                                        class="hidden flex-1 py-2 px-4 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
                                        <i class="fas fa-camera mr-2"></i>Capture
                                    </button>
                                    <button type="button" id="retake-selfie-btn" 
                                        class="hidden flex-1 py-2 px-4 bg-yellow-600 text-white text-sm rounded-md hover:bg-yellow-700 transition">
                                        <i class="fas fa-redo mr-2"></i>Retake
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Face Match Result -->
                        <div id="face-match-result" class="mt-4 p-4 rounded-lg hidden">
                            <div id="face-match-success" class="hidden bg-green-100 border border-green-400 text-green-700 p-4 rounded-lg">
                                <i class="fas fa-check-circle mr-2"></i>
                                <strong>Face Verified!</strong> 
                                <span id="match-score"></span>
                            </div>
                            <div id="face-match-error" class="hidden bg-red-100 border border-red-400 text-red-700 p-4 rounded-lg">
                                <i class="fas fa-times-circle mr-2"></i>
                                <strong>Face Mismatch!</strong> 
                                <span>The selfie does not match your ID photo. Please try again.</span>
                            </div>
                            <div id="face-match-loading" class="hidden bg-blue-100 border border-blue-400 text-blue-700 p-4 rounded-lg">
                                <i class="fas fa-spinner fa-spin mr-2"></i>
                                <strong>Comparing faces...</strong> 
                                <span>Please wait while we verify your identity.</span>
                            </div>
                        </div>
                        
                        <input type="hidden" id="face_verified" name="face_verified" value="0">
                        
                        @error('face_verified')
                            <div class="mt-3 bg-red-100 border border-red-400 text-red-700 p-4 rounded-lg">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <strong>Face Verification Required!</strong>
                                <p class="mt-1 text-sm">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>

                    <!-- Address Information -->
                    <div class="col-span-2 mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Address Information</h3>
                        
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">
                            City <span class="text-red-500">*</span>
                        </label>
                        <select id="city" name="city" required disabled
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Select City / Municipality</option>
                        </select>
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Barangay -->
                    <div>
                        <label for="barangay" class="block text-sm font-medium text-gray-700">
                            Barangay <span class="text-red-500">*</span>
                        </label>
                        <select id="barangay" name="barangay" required disabled
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Select Barangay</option>
                        </select>
                        @error('barangay')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- House / Unit / Block No -->
                    <div class="col-span-2 md:col-span-1">
                        <label for="house_number" class="block text-sm font-medium text-gray-700">
                            House / Unit / Block No. <span class="text-red-500">*</span>
                        </label>
                        <input id="house_number" name="house_number" type="text" required
                            class="mt-1 appearance-none block w-full px-3 py-2 border border-blue-200 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="e.g. 123"
                            value="{{ old('house_number') }}">
                        @error('house_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subdivision / Village -->
                    <div class="col-span-2 md:col-span-1">
                        <label for="subdivision" class="block text-sm font-medium text-gray-700">
                            Subdivision / Village <span class="text-gray-400 text-xs">(Optional)</span>
                        </label>
                        <input id="subdivision" name="subdivision" type="text"
                            class="mt-1 appearance-none block w-full px-3 py-2 border border-blue-200 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="e.g. Happy Village"
                            value="{{ old('subdivision') }}">
                        @error('subdivision')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Purok / Street (mapped to address) -->
                    <div class="col-span-2">
                        <label for="purok_select" class="block text-sm font-medium text-gray-700">
                            Purok / Street <span class="text-red-500">*</span>
                        </label>
                        <!-- Actual field sent to backend -->
                        <input type="hidden" id="final_address" name="address" value="{{ old('address') }}">

                        <div class="space-y-2">
                            <select id="purok_select" 
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Select Purok / Street</option>
                                @for ($i = 1; $i <= 15; $i++)
                                    <option value="Purok {{ $i }}">Purok {{ $i }}</option>
                                @endfor
                                <option value="Sitio">Sitio</option>
                                <option value="Other">Other (Specific Street)</option>
                            </select>

                            <input id="purok_input" type="text" 
                                class="hidden mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Enter specific Purok or Street Name">
                        </div>
                        
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Province -->
                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700">
                            Province <span class="text-red-500">*</span>
                        </label>
                        <input id="province" name="province" type="text" required readonly
                            class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600 cursor-not-allowed focus:outline-none"
                            value="Cebu">
                        @error('province')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Postal Code -->
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700">
                            Postal Code <span class="text-red-500">*</span>
                        </label>
                        <input id="postal_code" name="postal_code" type="text" required
                            class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="1000"
                            value="{{ old('postal_code') }}">
                        @error('postal_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Country -->
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700">
                            Country <span class="text-red-500">*</span>
                        </label>
                        <input id="country" name="country" type="text" required readonly
                            class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600 cursor-not-allowed focus:outline-none"
                            value="Philippines">
                    </div>

                    <!-- Emergency Contact -->
                    <div class="col-span-2 mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Emergency Contact</h3>
                    </div>

                    <div>
                        <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700">
                            Contact Name <span class="text-red-500">*</span>
                        </label>
                        <input id="emergency_contact_name" name="emergency_contact_name" type="text" required
                            class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Full Name"
                            value="{{ old('emergency_contact_name') }}">
                        @error('emergency_contact_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700">
                            Contact Phone <span class="text-red-500">*</span>
                        </label>
                        <input id="emergency_contact_phone" name="emergency_contact_phone" type="tel" required
                            class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="09XX-XXX-XXXX"
                            value="{{ old('emergency_contact_phone') }}">
                        @error('emergency_contact_phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Family Members Section -->
                    <div class="col-span-2 mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Household Information</h3>
                        <p class="text-sm text-gray-600 mb-4">Add all family members living in your household (excluding yourself).</p>
                    </div>

                    <div class="col-span-2">
                        <div id="family-members-container">
                            <!-- Family member entries will be added here dynamically -->
                        </div>
                        
                        <button type="button" id="add-family-member-btn"
                            class="mt-3 inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Family Member
                        </button>
                        
                        <p class="mt-2 text-xs text-gray-500">
                            <span id="family-count">0</span> family member(s) added. 
                            Total household size: <span id="household-size">1</span> (including yourself)
                        </p>
                        
                        @error('family_member_names')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @error('family_member_names.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-user-plus group-hover:text-indigo-400"></i>
                        </span>
                        Register Account
                    </button>
                </div>
            </div>
        </form>

        <div class="text-center">
            <p class="text-indigo-100">
                Already have an account?
                <a href="{{ route('resident.login') }}" class="font-medium text-white hover:text-indigo-200">
                    Sign in here
                </a>
            </p>
        </div>

        <div class="text-center">
            <a href="{{ route('home') }}" class="text-indigo-100 hover:text-white text-sm">
                <i class="fas fa-arrow-left mr-2"></i>Back to Home
            </a>
        </div>
    </div>

    <!-- PSGC Address Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const citySelect = document.getElementById('city');
            const barangaySelect = document.getElementById('barangay');
            
            // Old One values for repopulation after validation error
            const oldCity = "{{ old('city') }}";
            const oldBarangay = "{{ old('barangay') }}";

            // Function to fetch and populate cities for Cebu
            async function loadCebuCities() {
                try {
                    // First fetch all provinces to find Cebu's code (usually 072200000 but best to be dynamic)
                    // Optimisation: We know Cebu is usually Region VII.
                    // Let's search for "Cebu" in provinces.
                    const response = await fetch('https://psgc.gitlab.io/api/provinces/');
                    const provinces = await response.json();
                    const cebu = provinces.find(p => p.name === 'Cebu');
                    
                    if (cebu) {
                        const citiesResponse = await fetch(`https://psgc.gitlab.io/api/provinces/${cebu.code}/cities-municipalities/`);
                        const cities = await citiesResponse.json();
                        
                        // Sort cities alphabetically
                        cities.sort((a, b) => a.name.localeCompare(b.name));

                        citySelect.innerHTML = '<option value="">Select City / Municipality</option>';
                        cities.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.name;
                            option.dataset.code = city.code;
                            option.textContent = city.name;
                            if (city.name === oldCity) {
                                option.selected = true;
                            }
                            citySelect.appendChild(option);
                        });
                        
                        citySelect.disabled = false;

                        // If there was an old city selected, trigger change to load barangays
                        if (oldCity) {
                            loadBarangays(citySelect.options[citySelect.selectedIndex].dataset.code);
                        }
                    } else {
                        console.error('Cebu province not found in PSGC API');
                        // Fallback or alert?
                    }
                } catch (error) {
                    console.error('Error loading cities:', error);
                }
            }

            // Function to load barangays based on city code
            async function loadBarangays(cityCode) {
                if (!cityCode) return;
                
                barangaySelect.disabled = true;
                barangaySelect.innerHTML = '<option value="">Loading...</option>';

                try {
                    const response = await fetch(`https://psgc.gitlab.io/api/cities-municipalities/${cityCode}/barangays/`);
                    const barangays = await response.json();
                    
                    // Sort barangays alphabetically
                    barangays.sort((a, b) => a.name.localeCompare(b.name));

                    barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
                    barangays.forEach(barangay => {
                        const option = document.createElement('option');
                        option.value = barangay.name;
                        option.textContent = barangay.name;
                        if (barangay.name === oldBarangay) {
                            option.selected = true;
                        }
                        barangaySelect.appendChild(option);
                    });
                    
                    barangaySelect.disabled = false;
                } catch (error) {
                    console.error('Error loading barangays:', error);
                    barangaySelect.innerHTML = '<option value="">Error loading</option>';
                }
            }

            // Event listener for city change
            citySelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const cityCode = selectedOption.dataset.code;
                
                // Reset barangay dropdown
                barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
                barangaySelect.disabled = true;

                if (cityCode) {
                    loadBarangays(cityCode);
                }
            });

            // Start loading process
            loadCebuCities();

            // Purok/Street Hybrid Logic
            const purokSelect = document.getElementById('purok_select');
            const purokInput = document.getElementById('purok_input');
            const finalAddress = document.getElementById('final_address');
            
            // Note: We no longer concatenate on frontend because we are submitting separate fields.
            // But we DO need to handle the hybrid purok selection into the 'address' field.
            
            const oldAddress = "{{ old('address') }}";

            // Initialize state based on old input
            if (oldAddress) {
                // Check if old address matches one of the known options
                let matchFound = false;
                for (let i = 0; i < purokSelect.options.length; i++) {
                    if (purokSelect.options[i].value === oldAddress) {
                        purokSelect.selectedIndex = i;
                        matchFound = true;
                        break;
                    }
                }
                
                if (!matchFound) {
                    purokSelect.value = 'Other';
                    purokInput.value = oldAddress;
                    purokInput.classList.remove('hidden');
                    purokInput.required = true;
                }
            }

            purokSelect.addEventListener('change', function() {
                if (this.value === 'Other') {
                    purokInput.classList.remove('hidden');
                    purokInput.required = true;
                    purokInput.focus();
                    finalAddress.value = purokInput.value;
                } else {
                    purokInput.classList.add('hidden');
                    purokInput.required = false;
                    finalAddress.value = this.value;
                }
            });

            purokInput.addEventListener('input', function() {
                finalAddress.value = this.value;
            });

            // Phone Number Restriction Logic
            const phoneInput = document.getElementById('phone');
            if (phoneInput) {
                // Ensure starts with 09 on load/focus
                phoneInput.addEventListener('focus', function() {
                    if (this.value === '') {
                        this.value = '09';
                    }
                });

                // Enforce "09" prefix and numeric only
                phoneInput.addEventListener('input', function(e) {
                    // Remove non-numeric characters
                    let value = this.value.replace(/[^0-9]/g, '');
                    
                    // Ensure it starts with 09
                    if (value.length < 2) {
                        value = '09';
                    } else if (value.substring(0, 2) !== '09') {
                        value = '09' + value.substring(2);
                    }
                    
                    // Limit to 11 digits
                    if (value.length > 11) {
                        value = value.substring(0, 11);
                    }
                    
                    this.value = value;
                });

                // Prevent deleting the prefix
                phoneInput.addEventListener('keydown', function(e) {
                    if ((e.key === 'Backspace' || e.key === 'Delete') && this.value.length <= 2) {
                        e.preventDefault();
                    }
                });
            }

            // Age Validation Logic
            const birthdateInput = document.getElementById('birthdate');
            const ageDisplay = document.getElementById('age-display');
            const ageError = document.getElementById('age-error');
            
            if (birthdateInput) {
                birthdateInput.addEventListener('change', function() {
                    const birthdate = new Date(this.value);
                    const today = new Date();
                    let age = today.getFullYear() - birthdate.getFullYear();
                    const monthDiff = today.getMonth() - birthdate.getMonth();
                    
                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
                        age--;
                    }
                    
                    if (age >= 18) {
                        ageDisplay.textContent = `Age: ${age} years old ✓`;
                        ageDisplay.classList.remove('hidden');
                        ageError.classList.add('hidden');
                    } else {
                        ageDisplay.classList.add('hidden');
                        ageError.classList.remove('hidden');
                    }
                });
            }

            // Family Members Dynamic Form Logic
            const familyMembersContainer = document.getElementById('family-members-container');
            const addFamilyMemberBtn = document.getElementById('add-family-member-btn');
            const familyCountSpan = document.getElementById('family-count');
            const householdSizeSpan = document.getElementById('household-size');
            let familyMemberIndex = 0;

            function updateFamilyCount() {
                const count = familyMembersContainer.querySelectorAll('.family-member-entry').length;
                familyCountSpan.textContent = count;
                householdSizeSpan.textContent = count + 1; // +1 for the resident themselves
            }

            function createFamilyMemberEntry(index) {
                const div = document.createElement('div');
                div.className = 'family-member-entry bg-gray-50 border border-gray-200 rounded-lg p-4 mb-3';
                div.innerHTML = `
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm font-medium text-gray-700">Family Member #${index + 1}</span>
                        <button type="button" class="remove-family-member text-red-500 hover:text-red-700 text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div class="md:col-span-1">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="family_member_names[]" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="e.g., Maria Dela Cruz">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Relationship <span class="text-red-500">*</span></label>
                            <select name="family_member_relationships[]" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Select...</option>
                                <option value="Spouse">Spouse</option>
                                <option value="Child">Child</option>
                                <option value="Parent">Parent</option>
                                <option value="Sibling">Sibling</option>
                                <option value="Grandparent">Grandparent</option>
                                <option value="Grandchild">Grandchild</option>
                                <option value="In-law">In-law</option>
                                <option value="Other Relative">Other Relative</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Age</label>
                            <input type="number" name="family_member_ages[]" min="0" max="150"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Age">
                        </div>
                    </div>
                `;
                
                // Add remove event listener
                div.querySelector('.remove-family-member').addEventListener('click', function() {
                    div.remove();
                    updateFamilyCount();
                    renumberFamilyMembers();
                });
                
                return div;
            }

            function renumberFamilyMembers() {
                const entries = familyMembersContainer.querySelectorAll('.family-member-entry');
                entries.forEach((entry, idx) => {
                    entry.querySelector('span').textContent = `Family Member #${idx + 1}`;
                });
            }

            if (addFamilyMemberBtn) {
                addFamilyMemberBtn.addEventListener('click', function() {
                    const entry = createFamilyMemberEntry(familyMemberIndex);
                    familyMembersContainer.appendChild(entry);
                    familyMemberIndex++;
                    updateFamilyCount();
                });
            }

            // Handle old input for family members (if form validation failed)
            @if(old('family_member_names'))
                @foreach(old('family_member_names', []) as $index => $name)
                    (function() {
                        const entry = createFamilyMemberEntry({{ $index }});
                        entry.querySelector('input[name="family_member_names[]"]').value = "{{ $name }}";
                        entry.querySelector('select[name="family_member_relationships[]"]').value = "{{ old('family_member_relationships')[$index] ?? '' }}";
                        entry.querySelector('input[name="family_member_ages[]"]').value = "{{ old('family_member_ages')[$index] ?? '' }}";
                        familyMembersContainer.appendChild(entry);
                        familyMemberIndex++;
                    })();
                @endforeach
                updateFamilyCount();
            @endif
        });
    </script>

    <!-- Face-API.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
    
    <!-- Face Verification Script -->
    <script>
        // Wait for face-api.js to load
        document.addEventListener('DOMContentLoaded', function() {
            // Delay initialization to ensure face-api.js is loaded
            setTimeout(initFaceVerification, 1000);
        });

        let idFaceDescriptor = null;
        let selfieFaceDescriptor = null;
        let videoStream = null;

        async function initFaceVerification() {
            // Check if face-api is available
            if (typeof faceapi === 'undefined') {
                console.log('Face-API.js not loaded yet, retrying...');
                setTimeout(initFaceVerification, 500);
                return;
            }

            console.log('Initializing Face Verification...');
            
            // Load models from CDN
            const MODEL_URL = 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model';
            
            try {
                await Promise.all([
                    faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
                    faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
                    faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL)
                ]);
                console.log('Face-API models loaded successfully!');
            } catch (error) {
                console.error('Error loading face-api models:', error);
            }

            // Setup event listeners
            setupFaceVerificationListeners();
        }

        function setupFaceVerificationListeners() {
            const validIdFront = document.getElementById('valid_id_front');
            const startCameraBtn = document.getElementById('start-camera-btn');
            const captureSelfieBtn = document.getElementById('capture-selfie-btn');
            const retakeSelfieBtn = document.getElementById('retake-selfie-btn');

            // ID Photo Upload Handler
            validIdFront.addEventListener('change', async function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = async function(event) {
                        const idPreviewImg = document.getElementById('id-preview-img');
                        const idPlaceholder = document.getElementById('id-placeholder');
                        const idFaceStatus = document.getElementById('id-face-status');
                        
                        idPreviewImg.src = event.target.result;
                        idPreviewImg.classList.remove('hidden');
                        idPlaceholder.classList.add('hidden');
                        
                        // Detect face in ID
                        idFaceStatus.classList.remove('hidden');
                        idFaceStatus.innerHTML = '<span class="inline-flex items-center text-blue-600"><i class="fas fa-spinner fa-spin mr-2"></i>Detecting face in ID...</span>';
                        
                        try {
                            const img = await faceapi.fetchImage(event.target.result);
                            const detection = await faceapi.detectSingleFace(img, new faceapi.TinyFaceDetectorOptions())
                                .withFaceLandmarks()
                                .withFaceDescriptor();
                            
                            if (detection) {
                                idFaceDescriptor = detection.descriptor;
                                idFaceStatus.innerHTML = '<span class="inline-flex items-center text-green-600"><i class="fas fa-check-circle mr-2"></i>Face detected in ID!</span>';
                                
                                // Compare if selfie already taken
                                if (selfieFaceDescriptor) {
                                    compareFaces();
                                }
                            } else {
                                idFaceStatus.innerHTML = '<span class="inline-flex items-center text-red-600"><i class="fas fa-exclamation-circle mr-2"></i>No face detected. Please upload a clear photo.</span>';
                                idFaceDescriptor = null;
                            }
                        } catch (error) {
                            console.error('Error detecting face in ID:', error);
                            idFaceStatus.innerHTML = '<span class="inline-flex items-center text-red-600"><i class="fas fa-exclamation-circle mr-2"></i>Error processing image.</span>';
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Start Camera Button
            startCameraBtn.addEventListener('click', async function() {
                const video = document.getElementById('webcam-video');
                const selfieCanvas = document.getElementById('selfie-canvas');
                const selfiePreview = document.getElementById('selfie-preview');
                const selfiePlaceholder = document.getElementById('selfie-placeholder');
                
                try {
                    videoStream = await navigator.mediaDevices.getUserMedia({ 
                        video: { facingMode: 'user', width: 640, height: 480 } 
                    });
                    
                    video.srcObject = videoStream;
                    video.classList.remove('hidden');
                    selfiePlaceholder.classList.add('hidden');
                    selfieCanvas.classList.add('hidden');
                    selfiePreview.classList.add('hidden');
                    
                    startCameraBtn.classList.add('hidden');
                    captureSelfieBtn.classList.remove('hidden');
                    retakeSelfieBtn.classList.add('hidden');
                } catch (error) {
                    console.error('Error accessing camera:', error);
                    alert('Could not access camera. Please ensure camera permissions are granted.');
                }
            });

            // Capture Selfie Button
            captureSelfieBtn.addEventListener('click', async function() {
                const video = document.getElementById('webcam-video');
                const selfieCanvas = document.getElementById('selfie-canvas');
                const selfiePreview = document.getElementById('selfie-preview');
                
                // Draw video frame to canvas
                selfieCanvas.width = video.videoWidth;
                selfieCanvas.height = video.videoHeight;
                const ctx = selfieCanvas.getContext('2d');
                ctx.drawImage(video, 0, 0);
                
                // Get image data
                const imageData = selfieCanvas.toDataURL('image/jpeg');
                selfiePreview.src = imageData;
                
                // Stop video stream
                if (videoStream) {
                    videoStream.getTracks().forEach(track => track.stop());
                }
                
                video.classList.add('hidden');
                selfiePreview.classList.remove('hidden');
                
                captureSelfieBtn.classList.add('hidden');
                retakeSelfieBtn.classList.remove('hidden');
                
                // Detect face in selfie
                const faceMatchResult = document.getElementById('face-match-result');
                const faceMatchLoading = document.getElementById('face-match-loading');
                
                faceMatchResult.classList.remove('hidden');
                faceMatchLoading.classList.remove('hidden');
                document.getElementById('face-match-success').classList.add('hidden');
                document.getElementById('face-match-error').classList.add('hidden');
                
                try {
                    const img = await faceapi.fetchImage(imageData);
                    const detection = await faceapi.detectSingleFace(img, new faceapi.TinyFaceDetectorOptions())
                        .withFaceLandmarks()
                        .withFaceDescriptor();
                    
                    if (detection) {
                        selfieFaceDescriptor = detection.descriptor;
                        
                        // Compare faces if ID face is already detected
                        if (idFaceDescriptor) {
                            compareFaces();
                        } else {
                            faceMatchLoading.classList.add('hidden');
                            document.getElementById('face-match-error').classList.remove('hidden');
                            document.getElementById('face-match-error').innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i><strong>Please upload your ID first!</strong> <span>We need your ID photo to compare with.</span>';
                        }
                    } else {
                        faceMatchLoading.classList.add('hidden');
                        document.getElementById('face-match-error').classList.remove('hidden');
                        document.getElementById('face-match-error').innerHTML = '<i class="fas fa-times-circle mr-2"></i><strong>No face detected in selfie!</strong> <span>Please retake with better lighting.</span>';
                        selfieFaceDescriptor = null;
                    }
                } catch (error) {
                    console.error('Error detecting face in selfie:', error);
                    faceMatchLoading.classList.add('hidden');
                    document.getElementById('face-match-error').classList.remove('hidden');
                }
            });

            // Retake Selfie Button
            retakeSelfieBtn.addEventListener('click', async function() {
                const video = document.getElementById('webcam-video');
                const selfiePreview = document.getElementById('selfie-preview');
                const selfiePlaceholder = document.getElementById('selfie-placeholder');
                
                // Reset face match result
                document.getElementById('face-match-result').classList.add('hidden');
                document.getElementById('face_verified').value = '0';
                selfieFaceDescriptor = null;
                
                // Start camera again
                try {
                    videoStream = await navigator.mediaDevices.getUserMedia({ 
                        video: { facingMode: 'user', width: 640, height: 480 } 
                    });
                    
                    video.srcObject = videoStream;
                    video.classList.remove('hidden');
                    selfiePreview.classList.add('hidden');
                    selfiePlaceholder.classList.add('hidden');
                    
                    retakeSelfieBtn.classList.add('hidden');
                    captureSelfieBtn.classList.remove('hidden');
                } catch (error) {
                    console.error('Error accessing camera:', error);
                    alert('Could not access camera. Please ensure camera permissions are granted.');
                }
            });
        }

        function compareFaces() {
            const faceMatchLoading = document.getElementById('face-match-loading');
            const faceMatchSuccess = document.getElementById('face-match-success');
            const faceMatchError = document.getElementById('face-match-error');
            const faceVerifiedInput = document.getElementById('face_verified');
            const matchScore = document.getElementById('match-score');
            
            if (!idFaceDescriptor || !selfieFaceDescriptor) {
                return;
            }
            
            // Calculate Euclidean distance between face descriptors
            const distance = faceapi.euclideanDistance(idFaceDescriptor, selfieFaceDescriptor);
            const similarity = Math.max(0, 1 - distance) * 100;
            
            faceMatchLoading.classList.add('hidden');
            
            // Threshold: distance < 0.6 is considered a match (or similarity > 40%)
            if (distance < 0.6) {
                faceMatchSuccess.classList.remove('hidden');
                faceMatchError.classList.add('hidden');
                matchScore.textContent = `Match confidence: ${similarity.toFixed(1)}%`;
                faceVerifiedInput.value = '1';
            } else {
                faceMatchError.classList.remove('hidden');
                faceMatchSuccess.classList.add('hidden');
                faceMatchError.innerHTML = `<i class="fas fa-times-circle mr-2"></i><strong>Face Mismatch!</strong> <span>Similarity: ${similarity.toFixed(1)}%. The selfie does not match your ID. Please retake.</span>`;
                faceVerifiedInput.value = '0';
            }
        }
    </script>
</body>
</html>