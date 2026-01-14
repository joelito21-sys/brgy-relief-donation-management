<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Registration - <?php echo e(config('app.name', 'Barangay Cubacub Relief and Donation Management Program')); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'gradient': 'gradient 8s ease infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        gradient: {
                            '0%, 100%': { backgroundPosition: '0% 50%' },
                            '50%': { backgroundPosition: '100% 50%' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .form-input {
            @apply mt-1 block w-full rounded-lg border border-white/20 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 transition duration-200 pl-10 bg-white/10 backdrop-blur-sm text-white placeholder-white/70;
        }
        .btn-primary {
            @apply w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-200 transform hover:scale-105;
        }
        .btn-outline {
            @apply w-full flex justify-center py-2.5 px-4 border border-white/30 rounded-lg shadow-sm text-sm font-medium text-white bg-white/10 hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white/50 transition duration-200 backdrop-blur-sm transform hover:scale-105;
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
        .shape-3 {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            top: 60%;
            left: 15%;
            animation-duration: 18s;
            animation-delay: -2s;
        }
        .animated-gradient {
            background: linear-gradient(-45deg, #0284c7, #3b82f6, #8b5cf6, #06b6d4);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .shimmer {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4" style="background: linear-gradient(135deg, #0f766e 0%, #115e59 100%); background-size: cover; background-attachment: fixed;">

<!-- Animated Background -->
<div class="floating-shapes">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
</div>

<!-- Decorative Elements -->
<div class="fixed top-0 left-0 w-full h-1 animated-gradient"></div>
<div class="fixed bottom-0 left-0 w-full h-1 animated-gradient"></div>

<div class="w-full max-w-md mx-auto text-white">
    <!-- Main Registration Card -->
    <div class="px-8 py-10 glass-effect rounded-2xl shadow-2xl border border-white/20 animate-slide-up">
        <!-- Logo and Welcome -->
        <div class="text-center mb-8 animate-fade-in">
            <div class="flex justify-center mb-4">
                <div class="relative">
                    <div class="absolute inset-0 animated-gradient rounded-full opacity-20 blur-xl"></div>
                    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Flood Relief Logo" class="relative h-12 w-auto">
                </div>
            </div>
            <h2 class="text-2xl font-bold text-white mb-2">Join Our Community</h2>
            <p class="text-sm text-white/80">Create your donor account</p>
            <div class="mt-4 flex items-center justify-center space-x-2">
                <div class="h-px bg-white/30 w-12"></div>
                <i class="fas fa-heart text-pink-400 text-xs animate-pulse-slow"></i>
                <div class="h-px bg-white/30 w-12"></div>
            </div>
        </div>

        <!-- Registration Form -->
        <form class="space-y-6" method="POST" action="<?php echo e(route('donor.register')); ?>" id="donorForm">
            <?php echo csrf_field(); ?>
            
            <!-- Full Name Input -->
            <div class="animate-slide-up" style="animation-delay: 0.1s;">
                <label for="name" class="block text-sm font-medium text-white/90 mb-1">Full Name</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-white/70 group-hover:text-white transition-colors"></i>
                    </div>
                    <input id="name" name="name" type="text" required
                           class="form-input pl-10 group-hover:bg-white/15 transition-all" 
                           placeholder="Enter your full name" value="<?php echo e(old('name')); ?>" autocomplete="name" autofocus>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <i class="fas fa-check-circle text-green-400 text-sm"></i>
                    </div>
                </div>
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-400 animate-slide-up"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Email Input -->
            <div class="animate-slide-up" style="animation-delay: 0.2s;">
                <label for="email" class="block text-sm font-medium text-white/90 mb-1">Email Address</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-white/70 group-hover:text-white transition-colors"></i>
                    </div>
                    <input id="email" name="email" type="email" autocomplete="email" required
                           class="form-input pl-10 group-hover:bg-white/15 transition-all" 
                           placeholder="you@example.com" value="<?php echo e(old('email')); ?>">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <i class="fas fa-check-circle text-green-400 text-sm"></i>
                    </div>
                </div>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-400 animate-slide-up"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Phone Number Input -->
            <div class="animate-slide-up" style="animation-delay: 0.3s;">
                <label for="phone" class="block text-sm font-medium text-white/90 mb-1">Phone Number</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-phone text-white/70 group-hover:text-white transition-colors"></i>
                    </div>
                    <!-- value="<?php echo e(old('phone')); ?>" is removed to rely on JS setting "09" or re-setting old value logically -->
                    <input id="phone" name="phone" type="tel" required maxlength="11"
                           class="form-input pl-10 group-hover:bg-white/15 transition-all" 
                           placeholder="09123456789" value="<?php echo e(old('phone', '09')); ?>">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <i class="fas fa-check-circle text-green-400 text-sm"></i>
                    </div>
                </div>
                <!-- Helper text -->
                <p class="text-xs text-white/60 mt-1 pl-1">Ex: 09123456789 (11 digits)</p>
                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-400 animate-slide-up"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Password Input -->
            <div class="animate-slide-up" style="animation-delay: 0.4s;">
                <div class="flex items-center justify-between mb-1">
                    <label for="password" class="block text-sm font-medium text-white/90">Password</label>
                </div>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-white/70 group-hover:text-white transition-colors"></i>
                    </div>
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                           class="form-input pl-10 group-hover:bg-white/15 transition-all pr-10" 
                           placeholder="••••••••">
                    <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <i id="password-toggle" class="fas fa-eye text-white/70 hover:text-white transition-colors cursor-pointer"></i>
                    </button>
                </div>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-400 animate-slide-up"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Confirm Password Input -->
            <div class="animate-slide-up" style="animation-delay: 0.5s;">
                <div class="flex items-center justify-between mb-1">
                    <label for="password_confirmation" class="block text-sm font-medium text-white/90">Confirm Password</label>
                </div>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-white/70 group-hover:text-white transition-colors"></i>
                    </div>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                           class="form-input pl-10 group-hover:bg-white/15 transition-all pr-10" 
                           placeholder="••••••••">
                    <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <i id="password_confirmation-toggle" class="fas fa-eye text-white/70 hover:text-white transition-colors cursor-pointer"></i>
                    </button>
                </div>
            </div>

            <!-- Terms and Conditions -->
            <div class="flex items-start animate-slide-up" style="animation-delay: 0.6s;">
                <input id="terms" name="terms" type="checkbox" required class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-white/30 rounded bg-white/10 mt-1">
                <label for="terms" class="ml-2 block text-sm text-white/80 cursor-pointer hover:text-white transition-colors">
                    I agree to the <a href="<?php echo e(route('terms')); ?>" class="text-indigo-400 hover:text-indigo-300 transition-colors">Terms of Service</a> and 
                    <a href="<?php echo e(route('privacy')); ?>" class="text-indigo-400 hover:text-indigo-300 transition-colors">Privacy Policy</a>
                </label>
            </div>
            <?php $__errorArgs = ['terms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1 text-sm text-red-400 animate-slide-up"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <!-- Submit Button -->
            <div class="animate-slide-up" style="animation-delay: 0.7s;">
                <button type="submit" class="btn-primary relative overflow-hidden group" id="submitBtn">
                    <div class="absolute inset-0 shimmer"></div>
                    <span class="relative">
                        <i class="fas fa-user-plus mr-2 group-hover:animate-bounce"></i> 
                        Create Account
                    </span>
                </button>
            </div>
        </form>

        <!-- Divider -->
        <div class="mt-6 animate-slide-up" style="animation-delay: 0.8s;">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-white/20"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-3 bg-transparent text-white/70 text-xs font-medium">
                        ALREADY HAVE AN ACCOUNT?
                    </span>
                </div>
            </div>
        </div>

        <!-- Login Link -->
        <div class="mt-6 text-center animate-slide-up" style="animation-delay: 0.9s;">
            <a href="<?php echo e(route('donor.login')); ?>" class="font-medium text-indigo-400 hover:text-indigo-300 transition-colors group">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Sign in to your account
            </a>
            <div class="mt-4">
                <a href="<?php echo e(route('home')); ?>" class="text-xs text-white/60 hover:text-white transition-colors inline-flex items-center group">
                    <i class="fas fa-arrow-left mr-1 group-hover:-translate-x-1 transition-transform"></i> 
                    Back to Home
                </a>
            </div>
        </div>
    </div>

    <!-- Additional Info Card -->
    <div class="mt-6 px-6 py-4 glass-effect rounded-xl border border-white/10 animate-slide-up" style="animation-delay: 1.0s;">
        <div class="flex items-center justify-between text-sm">
            <div class="flex items-center space-x-2">
                <i class="fas fa-shield-alt text-green-400"></i>
                <span class="text-white/80">Secure Registration</span>
            </div>
            <div class="flex items-center space-x-2">
                <i class="fas fa-lock text-blue-400"></i>
                <span class="text-white/80">SSL Protected</span>
            </div>
            <div class="flex items-center space-x-2">
                <i class="fas fa-user-shield text-purple-400"></i>
                <span class="text-white/80">Privacy First</span>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="fixed bottom-0 w-full py-4 bg-black/80 backdrop-blur-sm border-t border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-xs text-white/60">
            &copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name', 'Barangay Cubacub Relief and Donation Management Program')); ?>. All rights reserved.
        </p>
    </div>
</footer>

<script>
    // Password toggle functionality
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const toggle = document.getElementById(inputId + '-toggle');
        
        if (input.type === 'password') {
            input.type = 'text';
            toggle.classList.remove('fa-eye');
            toggle.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            toggle.classList.remove('fa-eye-slash');
            toggle.classList.add('fa-eye');
        }
    }

    // Enhanced page load animation
    document.addEventListener('DOMContentLoaded', function() {
        // Phone number restriction logic
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

        // Staggered fade in for elements
        const elements = document.querySelectorAll('.animate-slide-up');
        elements.forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            setTimeout(() => {
                el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }, index * 100);
        });

        // Form validation feedback
        const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], input[type="password"]');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.validity.valid && this.value) {
                    this.classList.add('ring-2', 'ring-green-400/50');
                }
            });
            
            input.addEventListener('focus', function() {
                this.classList.remove('ring-2', 'ring-green-400/50');
            });
        });

        // Loading state for form submission
        const form = document.getElementById('donorForm');
        const submitBtn = document.getElementById('submitBtn');
        
        if (form) {
            form.addEventListener('submit', function() {
                const originalContent = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating Account...';
                submitBtn.disabled = true;
                
                // Reset after 5 seconds (in case of errors)
                setTimeout(() => {
                    submitBtn.innerHTML = originalContent;
                    submitBtn.disabled = false;
                }, 5000);
            });
        }
    });
</script>
</body>
</html><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/donor/auth/register.blade.php ENDPATH**/ ?>