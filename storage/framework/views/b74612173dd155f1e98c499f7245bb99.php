

<?php $__env->startSection('title', 'Create New Resident'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl border border-violet-200">
        

        <!-- Form -->
        <form method="POST" action="<?php echo e(route('admin.residents.store')); ?>" class="p-6">
            <?php echo csrf_field(); ?>
            
            <!-- Personal Information -->
            <div class="mb-8">
                <h2 class="text-lg font-bold text-black mb-4 pb-2 border-b border-gray-200">Personal Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-bold text-black mb-2">First Name *</label>
                        <input type="text" 
                               name="first_name" 
                               id="first_name" 
                               value="<?php echo e(old('first_name')); ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="Juan"
                               required>
                        <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-red-600 text-sm font-bold"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-bold text-black mb-2">Last Name *</label>
                        <input type="text" 
                               name="last_name" 
                               id="last_name" 
                               value="<?php echo e(old('last_name')); ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="Dela Cruz"
                               required>
                        <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-red-600 text-sm font-bold"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-black mb-2">Email Address *</label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="<?php echo e(old('email')); ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="resident@example.com"
                               required>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-red-600 text-sm font-bold"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-black mb-2">Password *</label>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="••••••••"
                               required>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-red-600 text-sm font-bold"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-black mb-2">Confirm Password *</label>
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="••••••••"
                               required>
                        <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-red-600 text-sm font-bold"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-bold text-black mb-2">Phone Number *</label>
                        <input type="text" 
                               name="phone" 
                               id="phone" 
                               value="<?php echo e(old('phone')); ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="09XX-XXX-XXXX"
                               required>
                        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-red-600 text-sm font-bold"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- ID Number -->
                    <div>
                        <label for="id_number" class="block text-sm font-bold text-black mb-2">ID Number *</label>
                        <input type="text" 
                               name="id_number" 
                               id="id_number" 
                               value="<?php echo e(old('id_number')); ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="Government ID Number"
                               required>
                        <?php $__errorArgs = ['id_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-red-600 text-sm font-bold"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- ID Type -->
                    <div>
                        <label for="id_type" class="block text-sm font-bold text-black mb-2">ID Type *</label>
                        <select name="id_type" 
                                id="id_type"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                                required>
                            <option value="">Select ID type</option>
                            <option value="passport" <?php echo e(old('id_type') == 'passport' ? 'selected' : ''); ?>>Passport</option>
                            <option value="driver_license" <?php echo e(old('id_type') == 'driver_license' ? 'selected' : ''); ?>>Driver's License</option>
                            <option value="sss" <?php echo e(old('id_type') == 'sss' ? 'selected' : ''); ?>>SSS ID</option>
                            <option value="voters_id" <?php echo e(old('id_type') == 'voters_id' ? 'selected' : ''); ?>>Voter's ID</option>
                            <option value="philhealth" <?php echo e(old('id_type') == 'philhealth' ? 'selected' : ''); ?>>PhilHealth ID</option>
                            <option value="others" <?php echo e(old('id_type') == 'others' ? 'selected' : ''); ?>>Others</option>
                        </select>
                        <?php $__errorArgs = ['id_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-red-600 text-sm font-bold"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="mb-8">
                <h2 class="text-lg font-bold text-black mb-4 pb-2 border-b border-gray-200">Address Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Street Address -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-bold text-black mb-2">Street Address *</label>
                        <input type="text" 
                               name="address" 
                               id="address" 
                               value="<?php echo e(old('address')); ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="123 Main Street"
                               required>
                        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-red-600 text-sm font-bold"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Barangay -->
                    <div>
                        <label for="barangay" class="block text-sm font-bold text-black mb-2">Barangay *</label>
                        <input type="text" 
                               name="barangay" 
                               id="barangay" 
                               value="<?php echo e(old('barangay')); ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="Barangay Name"
                               required>
                        <?php $__errorArgs = ['barangay'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-red-600 text-sm font-bold"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-bold text-black mb-2">City *</label>
                        <input type="text" 
                               name="city" 
                               id="city" 
                               value="<?php echo e(old('city')); ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="City Name"
                               required>
                        <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-red-600 text-sm font-bold"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Province -->
                    <div>
                        <label for="province" class="block text-sm font-bold text-black mb-2">Province *</label>
                        <input type="text" 
                               name="province" 
                               id="province" 
                               value="<?php echo e(old('province')); ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="Province Name"
                               required>
                        <?php $__errorArgs = ['province'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-red-600 text-sm font-bold"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Postal Code -->
                    <div>
                        <label for="postal_code" class="block text-sm font-bold text-black mb-2">Postal Code</label>
                        <input type="text" 
                               name="postal_code" 
                               id="postal_code" 
                               value="<?php echo e(old('postal_code')); ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="XXXX">
                        <?php $__errorArgs = ['postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-red-600 text-sm font-bold"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <!-- Emergency Contact -->
            <div class="mb-8">
                <h2 class="text-lg font-bold text-black mb-4 pb-2 border-b border-gray-200">Emergency Contact</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Emergency Contact Name -->
                    <div>
                        <label for="emergency_contact_name" class="block text-sm font-bold text-black mb-2">Emergency Contact Name *</label>
                        <input type="text" 
                               name="emergency_contact_name" 
                               id="emergency_contact_name" 
                               value="<?php echo e(old('emergency_contact_name')); ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="Contact Person Name"
                               required>
                        <?php $__errorArgs = ['emergency_contact_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-red-600 text-sm font-bold"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Emergency Contact Phone -->
                    <div>
                        <label for="emergency_contact_phone" class="block text-sm font-bold text-black mb-2">Emergency Contact Phone *</label>
                        <input type="text" 
                               name="emergency_contact_phone" 
                               id="emergency_contact_phone" 
                               value="<?php echo e(old('emergency_contact_phone')); ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black font-bold"
                               placeholder="09XX-XXX-XXXX"
                               required>
                        <?php $__errorArgs = ['emergency_contact_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-red-600 text-sm font-bold"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-violet-600 to-violet-700 text-white rounded-lg hover:from-violet-700 hover:to-violet-800 transition-all transform hover:scale-105 shadow-lg font-bold">
                    <i class="fas fa-save mr-2"></i>Create Resident
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Make all text black */
    .text-gray-700, .text-gray-600, .text-gray-500 {
        color: black !important;
        font-weight: bold !important;
    }
    
    .text-sm, .text-xs {
        font-weight: bold !important;
    }
    
    input::placeholder, textarea::placeholder, select::placeholder {
        color: #9CA3AF !important;
        font-weight: normal !important;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/admin/residents/create.blade.php ENDPATH**/ ?>