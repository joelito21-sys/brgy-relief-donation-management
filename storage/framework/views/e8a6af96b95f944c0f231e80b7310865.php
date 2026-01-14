

<?php $__env->startSection('title', 'Verify OTP'); ?>

<?php $__env->startSection('subtitle', 'Enter the 6-digit code sent to your email.'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-teal-900">
                Verify OTP
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Please enter the 6-digit code sent to <strong><?php echo e(session('reset_donor_email')); ?></strong>
            </p>
        </div>

        <?php if(session('status')): ?>
            <div class="rounded-md bg-green-50 p-4 mb-4">
                <p class="text-sm font-medium text-green-800"><?php echo e(session('status')); ?></p>
            </div>
        <?php endif; ?>
        
        <?php if($errors->any()): ?>
            <div class="rounded-md bg-red-50 p-4 mb-4">
                <ul class="list-disc list-inside text-sm text-red-600">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="mt-8 space-y-6" method="POST" action="<?php echo e(route('donor.password.otp.verify.process')); ?>">
            <?php echo csrf_field(); ?>

            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="otp" class="sr-only">One-Time Password</label>
                    <input id="otp" name="otp" type="text" inputmode="numeric" required 
                           class="appearance-none rounded-md relative block w-full px-3 py-2 border border-teal-300 
                                  placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-teal-500 
                                  focus:border-teal-500 focus:z-10 sm:text-lg text-center tracking-widest" 
                           placeholder="XXX XXX" maxlength="6">
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent 
                                            text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 
                                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    Verify Code
                </button>
            </div>
            
            <div class="flex items-center justify-between text-sm">
                <form action="<?php echo e(route('donor.password.otp.send')); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="email" value="<?php echo e(session('reset_donor_email')); ?>">
                    <button type="submit" class="font-medium text-teal-600 hover:text-teal-500 bg-transparent border-0 p-0 cursor-pointer">
                        Resend Code
                    </button>
                </form>
                
                <a href="<?php echo e(route('donor.password.request')); ?>" class="font-medium text-gray-600 hover:text-gray-500">
                    Change Email
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/donor/auth/passwords/otp-verify.blade.php ENDPATH**/ ?>