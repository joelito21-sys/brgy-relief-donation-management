@extends('layouts.resident')

@section('title', 'Change Password')

@push('styles')
<style>
    .gradient-bg {
        background: linear-gradient(135deg, #0284c7 0%, #3b82f6 50%, #8b5cf6 100%);
    }
    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .floating-shapes {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: -1;
    }
    .shape {
        position: absolute;
        border-radius: 50%;
        opacity: 0.1;
        animation: float 15s infinite linear;
    }
    .shape-1 {
        width: 200px;
        height: 200px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        top: 10%;
        left: 5%;
        animation-duration: 20s;
    }
    .shape-2 {
        width: 150px;
        height: 150px;
        background: linear-gradient(135deg, #10b981, #3b82f6);
        bottom: 15%;
        right: 10%;
        animation-duration: 25s;
        animation-delay: -5s;
    }
    @keyframes float {
        '0%, 100%': { transform: 'translateY(0)' },
        '50%': { transform: 'translateY(-10px)' },
    }
    .form-input {
        transition: all 0.3s ease;
    }
    .form-input:focus {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(59, 130, 246, 0.1);
    }
    .submit-btn {
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        transition: all 0.3s ease;
    }
    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(59, 130, 246, 0.3);
    }
    .password-strength {
        height: 4px;
        border-radius: 2px;
        transition: all 0.3s ease;
    }
    .strength-weak { background: #ef4444; width: 33%; }
    .strength-medium { background: #f59e0b; width: 66%; }
    .strength-strong { background: #10b981; width: 100%; }
</style>
@endpush

@section('content')
<div class="min-h-screen relative">
    <!-- Animated Background -->
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
    </div>

    <!-- Gradient Background -->
    <div class="gradient-bg min-h-screen py-8">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-8 animate-fade-in">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full mb-4">
                        <i class="fas fa-lock text-3xl text-white"></i>
                    </div>
                    <h1 class="text-4xl font-bold text-white mb-4">Change Password</h1>
                    <p class="text-xl text-white/90 max-w-2xl mx-auto">
                        Update your account password to keep your information secure.
                    </p>
                </div>

                <!-- Main Content -->
                <div class="glass-effect rounded-2xl shadow-2xl p-8">
                    <form action="#" method="POST" class="space-y-6" onsubmit="event.preventDefault(); alert('Password change feature coming soon!'); return false;">
                        @csrf

                        <!-- Current Password -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-key mr-2 text-gray-400"></i>Current Password
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       name="current_password"
                                       id="current_password"
                                       required
                                       class="form-input w-full px-4 py-3 pr-12 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Enter your current password">
                                <button type="button" 
                                        onclick="togglePassword('current_password')"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye" id="current_password_icon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- New Password -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-lock mr-2 text-gray-400"></i>New Password
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       name="new_password"
                                       id="new_password"
                                       required
                                       minlength="8"
                                       oninput="checkPasswordStrength(this.value)"
                                       class="form-input w-full px-4 py-3 pr-12 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Enter your new password">
                                <button type="button" 
                                        onclick="togglePassword('new_password')"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye" id="new_password_icon"></i>
                                </button>
                            </div>
                            
                            <!-- Password Strength Indicator -->
                            <div class="mt-2">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs text-gray-600">Password Strength</span>
                                    <span id="strength_text" class="text-xs font-medium text-gray-600">Enter a password</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1">
                                    <div id="strength_bar" class="password-strength strength-weak"></div>
                                </div>
                            </div>

                            <!-- Password Requirements -->
                            <div class="mt-3 space-y-1">
                                <p class="text-xs text-gray-600">Password must contain:</p>
                                <ul class="text-xs text-gray-500 space-y-1">
                                    <li id="req_length" class="flex items-center">
                                        <i class="fas fa-times-circle text-red-500 mr-2"></i>
                                        At least 8 characters
                                    </li>
                                    <li id="req_upper" class="flex items-center">
                                        <i class="fas fa-times-circle text-red-500 mr-2"></i>
                                        One uppercase letter
                                    </li>
                                    <li id="req_lower" class="flex items-center">
                                        <i class="fas fa-times-circle text-red-500 mr-2"></i>
                                        One lowercase letter
                                    </li>
                                    <li id="req_number" class="flex items-center">
                                        <i class="fas fa-times-circle text-red-500 mr-2"></i>
                                        One number
                                    </li>
                                    <li id="req_special" class="flex items-center">
                                        <i class="fas fa-times-circle text-red-500 mr-2"></i>
                                        One special character
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-lock mr-2 text-gray-400"></i>Confirm New Password
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       name="confirm_password"
                                       id="confirm_password"
                                       required
                                       oninput="checkPasswordMatch()"
                                       class="form-input w-full px-4 py-3 pr-12 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Confirm your new password">
                                <button type="button" 
                                        onclick="togglePassword('confirm_password')"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye" id="confirm_password_icon"></i>
                                </button>
                            </div>
                            <p id="match_message" class="mt-2 text-sm hidden"></p>
                        </div>

                        <!-- Security Tips -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-600 text-lg"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-semibold text-blue-800">Security Tips</h3>
                                    <ul class="mt-2 text-sm text-blue-700 space-y-1">
                                        <li>• Use a combination of letters, numbers, and symbols</li>
                                        <li>• Avoid using personal information or common words</li>
                                        <li>• Don't reuse passwords from other accounts</li>
                                        <li>• Consider using a password manager</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('resident.profile.edit') }}" 
                               class="px-8 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </a>
                            <button type="submit" 
                                    class="submit-btn px-8 py-3 text-white rounded-lg font-semibold">
                                <i class="fas fa-save mr-2"></i>Update Password
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Quick Links -->
                <div class="mt-6 glass-effect rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('resident.profile.edit') }}" 
                           class="flex items-center space-x-3 p-3 bg-white rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all">
                            <i class="fas fa-user-edit text-blue-600"></i>
                            <span class="text-gray-700">Edit Profile</span>
                        </a>
                        <a href="{{ route('resident.dashboard') }}" 
                           class="flex items-center space-x-3 p-3 bg-white rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all">
                            <i class="fas fa-home text-blue-600"></i>
                            <span class="text-gray-700">Back to Dashboard</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '_icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function checkPasswordStrength(password) {
    const strengthBar = document.getElementById('strength_bar');
    const strengthText = document.getElementById('strength_text');
    
    // Check requirements
    const requirements = {
        length: password.length >= 8,
        upper: /[A-Z]/.test(password),
        lower: /[a-z]/.test(password),
        number: /[0-9]/.test(password),
        special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
    };
    
    // Update requirement indicators
    updateRequirement('req_length', requirements.length);
    updateRequirement('req_upper', requirements.upper);
    updateRequirement('req_lower', requirements.lower);
    updateRequirement('req_number', requirements.number);
    updateRequirement('req_special', requirements.special);
    
    // Calculate strength
    const score = Object.values(requirements).filter(Boolean).length;
    
    // Update strength indicator
    strengthBar.className = 'password-strength';
    
    if (score <= 2) {
        strengthBar.classList.add('strength-weak');
        strengthText.textContent = 'Weak';
        strengthText.className = 'text-xs font-medium text-red-600';
    } else if (score <= 4) {
        strengthBar.classList.add('strength-medium');
        strengthText.textContent = 'Medium';
        strengthText.className = 'text-xs font-medium text-yellow-600';
    } else {
        strengthBar.classList.add('strength-strong');
        strengthText.textContent = 'Strong';
        strengthText.className = 'text-xs font-medium text-green-600';
    }
    
    // Check password match
    checkPasswordMatch();
}

function updateRequirement(id, met) {
    const element = document.getElementById(id);
    const icon = element.querySelector('i');
    
    if (met) {
        icon.classList.remove('fa-times-circle', 'text-red-500');
        icon.classList.add('fa-check-circle', 'text-green-500');
    } else {
        icon.classList.remove('fa-check-circle', 'text-green-500');
        icon.classList.add('fa-times-circle', 'text-red-500');
    }
}

function checkPasswordMatch() {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const matchMessage = document.getElementById('match_message');
    const confirmField = document.getElementById('confirm_password');
    
    if (confirmPassword === '') {
        matchMessage.classList.add('hidden');
        confirmField.classList.remove('border-green-500', 'border-red-500');
        return;
    }
    
    matchMessage.classList.remove('hidden');
    
    if (newPassword === confirmPassword) {
        matchMessage.textContent = 'Passwords match!';
        matchMessage.className = 'mt-2 text-sm text-green-600';
        confirmField.classList.remove('border-red-500');
        confirmField.classList.add('border-green-500');
    } else {
        matchMessage.textContent = 'Passwords do not match';
        matchMessage.className = 'mt-2 text-sm text-red-600';
        confirmField.classList.remove('border-green-500');
        confirmField.classList.add('border-red-500');
    }
}
</script>
@endpush
