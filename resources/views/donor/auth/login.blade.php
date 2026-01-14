<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Portal - {{ config('app.name', 'Barangay Cubacub Relief and Donation Management Program') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
    <!-- Main Login Card -->
    <div class="px-8 py-10 glass-effect rounded-2xl shadow-2xl border border-white/20 animate-slide-up">
        <!-- Logo and Welcome -->
        <div class="text-center mb-8 animate-fade-in">
            <div class="flex justify-center mb-4">
                <div class="relative">
                    <img src="{{ asset('images/logo.png') }}" alt="Flood Relief Logo" class="relative h-24 w-auto">
                </div>
            </div>
            <h1 class="text-2xl lg:text-3xl font-bold text-white mb-4 leading-tight">Barangay Cubacub Relief and Donation Management Program</h1>
            <h2 class="text-xl font-semibold text-white/90 mb-2">Welcome Back, Donor</h2>
            <p class="text-sm text-white/80">Sign in to your donor account</p>
            <div class="mt-4 flex items-center justify-center space-x-2">
                <div class="h-px bg-white/30 w-12"></div>
                <i class="fas fa-heart text-pink-400 text-xs animate-pulse-slow"></i>
                <div class="h-px bg-white/30 w-12"></div>
            </div>
        </div>

        <!-- Login Form -->
        <form class="space-y-6" action="{{ route('donor.login') }}" method="POST">
            @csrf
            
            <!-- Email Input -->
            <div class="animate-slide-up" style="animation-delay: 0.1s;">
                <label for="email" class="block text-sm font-medium text-white/90 mb-1">Email Address</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-white/70 group-hover:text-white transition-colors"></i>
                    </div>
                    <input id="email" name="email" type="email" autocomplete="email" required
                           class="form-input pl-10 group-hover:bg-white/15 transition-all" 
                           placeholder="you@example.com">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <i class="fas fa-check-circle text-green-400 text-sm"></i>
                    </div>
                </div>
                @error('email')
                    <p class="mt-1 text-sm text-red-400 animate-slide-up">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="animate-slide-up" style="animation-delay: 0.2s;">
                <div class="flex items-center justify-between mb-1">
                    <label for="password" class="block text-sm font-medium text-white/90">Password</label>
                    <a href="{{ route('donor.password.request') }}" class="text-xs text-white/70 hover:text-white transition-colors group">
                        <i class="fas fa-question-circle mr-1 group-hover:animate-pulse"></i>
                        Forgot password?
                    </a>
                </div>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-white/70 group-hover:text-white transition-colors"></i>
                    </div>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                           class="form-input pl-10 group-hover:bg-white/15 transition-all pr-10" 
                           placeholder="••••••••">
                    <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <i id="password-toggle" class="fas fa-eye text-white/70 hover:text-white transition-colors cursor-pointer"></i>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-400 animate-slide-up">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center animate-slide-up" style="animation-delay: 0.3s;">
                <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-white/30 rounded bg-white/10">
                <label for="remember_me" class="ml-2 block text-sm text-white/80 cursor-pointer hover:text-white transition-colors">
                    Remember me
                </label>
            </div>

            <!-- Submit Button -->
            <div class="animate-slide-up" style="animation-delay: 0.4s;">
                <button type="submit" class="btn-primary relative overflow-hidden group">
                    <div class="absolute inset-0 shimmer"></div>
                    <span class="relative">
                        <i class="fas fa-sign-in-alt mr-2 group-hover:animate-bounce"></i> 
                        Sign in
                    </span>
                </button>
            </div>
        </form>

        <!-- Divider -->
        <div class="mt-6 animate-slide-up" style="animation-delay: 0.5s;">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-white/20"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-3 bg-transparent text-white/70 text-xs font-medium">
                        OR CONTINUE WITH
                    </span>
                </div>
            </div>

            <!-- Social Login Buttons -->
            <div class="mt-6 grid grid-cols-2 gap-3">
                <div class="animate-slide-up" style="animation-delay: 0.6s;">
                    <a href="#" class="btn-outline group">
                        <i class="fab fa-google mr-2 group-hover:animate-spin"></i> 
                        Google
                    </a>
                </div>
                <div class="animate-slide-up" style="animation-delay: 0.7s;">
                    <a href="#" class="btn-outline group">
                        <i class="fab fa-facebook-f mr-2 group-hover:animate-pulse"></i> 
                        Facebook
                    </a>
                </div>
            </div>
        </div>

        <!-- Sign Up Link -->
        <div class="mt-6 text-center animate-slide-up" style="animation-delay: 0.8s;">
            <p class="text-sm text-white/80">
                Don't have an account? 
                <a href="{{ route('donor.register') }}" class="font-medium text-indigo-400 hover:text-indigo-300 transition-colors group">
                    Create an account
                    <i class="fas fa-arrow-right ml-1 text-xs group-hover:translate-x-1 transition-transform"></i>
                </a>
            </p>
            <div class="mt-4">
                <a href="{{ route('home') }}" class="text-xs text-white/60 hover:text-white transition-colors inline-flex items-center group">
                    <i class="fas fa-arrow-left mr-1 group-hover:-translate-x-1 transition-transform"></i> 
                    Back to Home
                </a>
            </div>
        </div>
    </div>

    <!-- Additional Info Card -->
    <div class="mt-6 px-6 py-4 glass-effect rounded-xl border border-white/10 animate-slide-up" style="animation-delay: 0.9s;">
        <div class="flex items-center justify-between text-sm">
            <div class="flex items-center space-x-2">
                <i class="fas fa-shield-alt text-green-400"></i>
                <span class="text-white/80">Secure Login</span>
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
            &copy; {{ date('Y') }} {{ config('app.name', 'Barangay Cubacub Relief and Donation Management Program') }}. All rights reserved.
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
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        
        emailInput.addEventListener('blur', function() {
            if (this.validity.valid && this.value) {
                this.classList.add('ring-2', 'ring-green-400/50');
            }
        });
        
        emailInput.addEventListener('focus', function() {
            this.classList.remove('ring-2', 'ring-green-400/50');
        });

        // Loading state for form submission
        const form = document.querySelector('form');
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalContent = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Signing in...';
            submitBtn.disabled = true;
            
            // Reset after 5 seconds (in case of errors)
            setTimeout(() => {
                submitBtn.innerHTML = originalContent;
                submitBtn.disabled = false;
            }, 5000);
        });
    });
</script>
</body>
</html>
