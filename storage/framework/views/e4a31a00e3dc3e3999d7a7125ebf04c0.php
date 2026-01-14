

<?php $__env->startSection('title', 'Verify Email - Donor Portal'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center p-4" style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-green-600 rounded-full opacity-20 blur-xl"></div>
                    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Flood Relief Logo" class="relative h-16 w-auto mx-auto">
                </div>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Barangay Cubacub Relief and Donation Management Program</h1>
        </div>

        <!-- Verification Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-green-100">
            <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 text-center">
                <i class="fas fa-envelope-open-text text-4xl text-white mb-3"></i>
                <h2 class="text-xl font-bold text-white">Verify Your Email</h2>
            </div>
            
            <div class="p-6">
                <!-- Success Message -->
                <?php if(session('status')): ?>
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span class="text-green-700 font-medium"><?php echo e(session('status')); ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Error Messages -->
                <?php if($errors->any()): ?>
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                            <span class="text-red-700 font-medium">Verification Failed</span>
                        </div>
                        <ul class="list-disc list-inside text-red-600 text-sm mt-2">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Verification Info -->
                <div class="text-center mb-6">
                    <div class="mb-4">
                        <i class="fas fa-paper-plane text-green-500 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Check Your Email</h3>
                    <p class="text-gray-600 mb-3">
                        We've sent a 6-digit verification code to:
                    </p>
                    <div class="bg-green-50 rounded-lg p-3 mb-4">
                        <p class="font-medium text-green-700 break-all"><?php echo e($donor->email); ?></p>
                    </div>
                    <p class="text-gray-500 text-sm">
                        The code will expire in 30 minutes. Please enter it below to verify your email.
                    </p>
                </div>

                <!-- OTP Form -->
                <form action="<?php echo e(route('donor.verification.verify')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-6">
                        <label for="otp" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-key mr-1"></i>
                            Verification Code
                        </label>
                        <div class="flex space-x-2 justify-center">
                            <?php for($i = 0; $i < 6; $i++): ?>
                                <input type="text" 
                                       id="otp-<?php echo e($i); ?>"
                                       name="otp[]"
                                       class="w-12 h-12 text-2xl text-center font-bold border-2 border-gray-300 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-colors"
                                       maxlength="1"
                                       pattern="[0-9]"
                                       inputmode="numeric"
                                       required>
                            <?php endfor; ?>
                            <input type="hidden" id="otp" name="otp">
                        </div>
                        <div class="mt-2 text-center">
                            <span class="text-sm text-gray-500">Enter the 6-digit code from your email</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-4 rounded-lg shadow-md transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-green-300 focus:ring-opacity-50">
                        <i class="fas fa-check-circle mr-2"></i>
                        Verify Email
                    </button>
                </form>

                <!-- Resend Section -->
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <div class="text-center">
                        <p class="text-gray-600 mb-3">
                            Didn't receive the code?
                        </p>
                        <form action="<?php echo e(route('donor.verification.resend')); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="text-green-600 hover:text-green-800 font-medium inline-flex items-center">
                                <i class="fas fa-redo mr-1"></i>
                                Resend Code
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Change Email -->
                <div class="mt-4 text-center">
                    <small class="text-gray-500">
                        Wrong email address? 
                        <a href="<?php echo e(route('donor.register')); ?>" class="text-green-600 hover:text-green-800 font-medium">
                            Register again
                        </a>
                    </small>
                </div>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="mt-6 text-center">
            <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center text-green-700 hover:text-green-900 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Home
            </a>
        </div>
    </div>
</div>

<script>
// Auto-focus and format OTP input
document.addEventListener('DOMContentLoaded', function() {
    const otpInputs = document.querySelectorAll('input[name="otp[]"]');
    const hiddenOtp = document.getElementById('otp');
    
    // Focus on first input
    if (otpInputs.length > 0) {
        otpInputs[0].focus();
    }
    
    // Handle input navigation
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            // Allow only numbers
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Move to next input if filled
            if (this.value.length === 1 && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
            
            // Update hidden input
            updateHiddenOtp();
        });
        
        // Handle backspace
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && this.value === '' && index > 0) {
                otpInputs[index - 1].focus();
            }
        });
        
        // Handle paste
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const paste = (e.clipboardData || window.clipboardData).getData('text');
            const numbers = paste.replace(/[^0-9]/g, '').substring(0, 6);
            
            for (let i = 0; i < numbers.length; i++) {
                if (otpInputs[i]) {
                    otpInputs[i].value = numbers[i];
                }
            }
            
            if (numbers.length < 6 && otpInputs[numbers.length]) {
                otpInputs[numbers.length].focus();
            } else if (numbers.length === 6) {
                otpInputs[5].focus();
            }
            
            updateHiddenOtp();
        });
    });
    
    function updateHiddenOtp() {
        const otpValue = Array.from(otpInputs).map(input => input.value).join('');
        hiddenOtp.value = otpValue;
    }
    
    // Auto-submit when all digits entered
    const observer = new MutationObserver(function() {
        const otpValue = Array.from(otpInputs).map(input => input.value).join('');
        if (otpValue.length === 6) {
            // Form will submit on button click
        }
    });
    
    otpInputs.forEach(input => {
        observer.observe(input, { attributes: true, childList: true, subtree: true });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.simple', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/donor/auth/verify-email.blade.php ENDPATH**/ ?>