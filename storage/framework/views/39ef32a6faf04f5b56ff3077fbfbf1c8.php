<?php $__env->startSection('title', 'Admin Login'); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full max-w-md space-y-8">
    <div class="w-full max-w-md mx-auto p-8 rounded-lg shadow-lg auth-card">
        <div class="text-center">
            <div class="flex flex-col items-center">
                <div class="p-4 bg-white rounded-full shadow-md mb-4">
                    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="<?php echo e(config('app.name', 'Barangay Cubacub Relief and Donation Management Program')); ?>" class="h-32 w-auto">
                </div>
                <h1 class="text-2xl header-text"><?php echo e(config('app.name', 'Barangay Cubacub Relief and Donation Management Program')); ?></h1>
                <h2 class="mt-2 text-xl subheader-text">
                    Admin Portal
                </h2>
                <p class="mt-1 text-sm description-text">Sign in to access the admin dashboard</p>
            </div>
        </div>
        <form method="POST" action="<?php echo e(route('admin.login')); ?>" class="mt-8 space-y-6">
            <?php if($errors->any()): ?>
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                <?php echo e($errors->first()); ?>

                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php echo csrf_field(); ?>
            <div class="rounded-md shadow-sm space-y-4">
                <div>
                    <label for="email" class="sr-only">Email address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required
                               class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 sm:text-sm auth-input"
                               placeholder="Email address" value="<?php echo e(old('email')); ?>">
                    </div>
                </div>

                <div>
                    <label for="password" class="sr-only">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 sm:text-sm auth-input"
                               placeholder="Password">
                    </div>
                </div>
            </div>

            <div class="flex items-center">
                <input id="remember-me" name="remember" type="checkbox"
                       class="h-4 w-4 text-violet-600 focus:ring-violet-500 border-gray-300 rounded" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                <label for="remember-me" class="ml-2 block text-sm description-text">
                    Remember me
                </label>
            </div>

            <div>
                <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold text-black bg-violet-600 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500 transition-colors duration-200 transform hover:shadow-md rounded-lg">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-violet-300 group-hover:text-violet-200 transition-colors duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    Sign in
                </button>
            </div>
        </form>
        
        <div class="mt-6 text-center">
            <p class="text-sm description-text">
                Need an account? 
                <a href="#" class="font-bold text-violet-600 hover:text-violet-500">
                    Contact administrator
                </a>
            </p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>