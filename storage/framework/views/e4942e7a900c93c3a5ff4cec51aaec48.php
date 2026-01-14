

<?php $__env->startSection('title', 'Forgot Password'); ?>

<?php $__env->startSection('subtitle', 'Enter your email address to receive a One-Time Password (OTP).'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-teal-900">
                Forgot Password
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Enter your email address and we'll send you an OTP to reset your donor password.
            </p>
        </div>

        <?php if(session('status')): ?>
            <div class="rounded-md bg-green-50 p-4 mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            <?php echo e(session('status')); ?>

                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if($errors->any()): ?>
            <div class="rounded-md bg-red-50 p-4 mb-4">
                <div class="flex">
                     <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                         <ul class="list-disc list-inside text-sm text-red-600">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <form class="mt-8 space-y-6" method="POST" action="<?php echo e(route('donor.password.otp.send')); ?>">
            <?php echo csrf_field(); ?>

            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="email" class="sr-only">Email Address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 
                                  placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-teal-500 
                                  focus:border-teal-500 focus:z-10 sm:text-sm" 
                           value="<?php echo e(old('email')); ?>" placeholder="Email Address">
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent 
                                            text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 
                                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-paper-plane text-teal-500 group-hover:text-teal-400"></i>
                    </span>
                    Send OTP
                </button>
            </div>

            <div class="text-center">
                <a href="<?php echo e(route('donor.login')); ?>" class="font-medium text-teal-600 hover:text-teal-500">
                    <i class="fas fa-arrow-left mr-1"></i> Back to login
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/donor/auth/passwords/otp-request.blade.php ENDPATH**/ ?>