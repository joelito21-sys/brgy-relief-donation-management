<?php $__env->startSection('title', __('Reset Password')); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        /* Add any custom styles here */
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('subtitle', __('Enter your email address and we\'ll send you a link to reset your password.')); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                <?php echo e(__('Reset Password')); ?>

            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                <?php echo e(__('Enter your email address and we\'ll send you a link to reset your password.')); ?>

            </p>
        </div>

        <?php if(session('status')): ?>
            <div class="rounded-md bg-green-50 p-4 mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            <?php echo e(session('status')); ?>

                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <form class="mt-8 space-y-6" method="POST" action="<?php echo e(route('donor.password.email')); ?>">
            <?php echo csrf_field(); ?>

            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="email" class="sr-only"><?php echo e(__('Email Address')); ?></label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 
                                  placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 
                                  focus:border-indigo-500 focus:z-10 sm:text-sm <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           value="<?php echo e(old('email')); ?>" placeholder="<?php echo e(__('Email Address')); ?>">
                    
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent 
                                            text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 
                                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <?php echo e(__('Send Password Reset Link')); ?>

                </button>
            </div>

            <div class="text-center">
                <a href="<?php echo e(route('donor.login')); ?>" class="font-medium text-indigo-600 hover:text-indigo-500">
                    <?php echo e(__('Back to login')); ?>

                </a>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/donor/auth/passwords/email.blade.php ENDPATH**/ ?>