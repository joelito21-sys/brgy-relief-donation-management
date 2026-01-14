

<?php $__env->startSection('title', 'Emergency Contact'); ?>
<?php $__env->startSection('page-title', 'Emergency Contact'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Emergency Alert -->
        <div class="bg-red-50 border-l-4 border-red-400 p-6 mb-8 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-400 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-red-800">Emergency Assistance</h3>
                    <div class="mt-2 text-red-700">
                        <p>If you are in immediate danger or need urgent assistance, contact emergency services right away.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Emergency Contacts -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-phone-alt text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Emergency Hotline</h3>
                        <p class="text-gray-600">24/7 Emergency Services</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">National Emergency</p>
                            <p class="text-sm text-gray-600">Police, Fire, Medical</p>
                        </div>
                        <a href="tel:911" class="text-2xl font-bold text-red-600 hover:text-red-700">911</a>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">Flood Relief Hotline</p>
                            <p class="text-sm text-gray-600">Assistance & Rescue</p>
                        </div>
                        <a href="tel:1234567" class="text-lg font-bold text-indigo-600 hover:text-indigo-700">123-4567</a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-hospital text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Medical Services</h3>
                        <p class="text-gray-600">Hospitals & Clinics</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">City Hospital</p>
                            <p class="text-sm text-gray-600">Emergency Room</p>
                        </div>
                        <a href="tel:5551234" class="text-lg font-bold text-blue-600 hover:text-blue-700">555-1234</a>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">Red Cross</p>
                            <p class="text-sm text-gray-600">First Aid & Rescue</p>
                        </div>
                        <a href="tel:5555678" class="text-lg font-bold text-blue-600 hover:text-blue-700">555-5678</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Relief Team Contacts -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Relief Team Contacts</h3>
                    <p class="text-gray-600">Local flood relief assistance team</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-indigo-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Team Leader</p>
                            <p class="text-sm text-gray-600">John Smith</p>
                        </div>
                    </div>
                    <a href="tel:09123456789" class="text-indigo-600 hover:text-indigo-700 font-medium">
                        <i class="fas fa-phone mr-1"></i>0912-345-6789
                    </a>
                </div>

                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-truck text-green-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Logistics</p>
                            <p class="text-sm text-gray-600">Maria Santos</p>
                        </div>
                    </div>
                    <a href="tel:09123456790" class="text-green-600 hover:text-green-700 font-medium">
                        <i class="fas fa-phone mr-1"></i>0912-345-6790
                    </a>
                </div>

                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-first-aid text-purple-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Medical Team</p>
                            <p class="text-sm text-gray-600">Dr. Lee Chen</p>
                        </div>
                    </div>
                    <a href="tel:09123456791" class="text-purple-600 hover:text-purple-700 font-medium">
                        <i class="fas fa-phone mr-1"></i>0912-345-6791
                    </a>
                </div>
            </div>
        </div>

        <!-- Evacuation Centers -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-home text-orange-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Evacuation Centers</h3>
                    <p class="text-gray-600">Nearest evacuation centers and shelters</p>
                </div>
            </div>
            
            <div class="space-y-4">
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900 mb-1">Central Community Center</h4>
                            <p class="text-sm text-gray-600 mb-2">123 Main Street, Barangay Central</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-users mr-2"></i>
                                <span>Capacity: 200 people</span>
                                <span class="mx-2">•</span>
                                <i class="fas fa-bed mr-2"></i>
                                <span>Available: 45 beds</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <a href="tel:09123456792" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                                <i class="fas fa-phone mr-1"></i>
                                Call
                            </a>
                        </div>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900 mb-1">High School Gymnasium</h4>
                            <p class="text-sm text-gray-600 mb-2">456 Education Ave, Barangay North</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-users mr-2"></i>
                                <span>Capacity: 300 people</span>
                                <span class="mx-2">•</span>
                                <i class="fas fa-bed mr-2"></i>
                                <span>Available: 120 beds</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <a href="tel:09123456793" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                                <i class="fas fa-phone mr-1"></i>
                                Call
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Your Emergency Contact -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-star text-purple-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Your Emergency Contact</h3>
                    <p class="text-gray-600">Your registered emergency contact person</p>
                </div>
            </div>
            
            <?php if(Auth::guard('resident')->user()->emergency_contact_name): ?>
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-purple-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900"><?php echo e(Auth::guard('resident')->user()->emergency_contact_name); ?></p>
                                <p class="text-sm text-gray-600">Emergency Contact</p>
                            </div>
                        </div>
                        <a href="tel:<?php echo e(Auth::guard('resident')->user()->emergency_contact_phone); ?>" 
                           class="inline-flex items-center px-4 py-2 border border-purple-300 text-sm font-medium rounded text-purple-700 bg-purple-50 hover:bg-purple-100">
                            <i class="fas fa-phone mr-2"></i>
                            <?php echo e(Auth::guard('resident')->user()->emergency_contact_phone); ?>

                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <i class="fas fa-user-friends text-gray-300 text-4xl mb-4"></i>
                    <p class="text-gray-600 mb-4">No emergency contact registered. Update your profile to add one.</p>
                    <a href="<?php echo e(route('resident.profile.edit')); ?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        <i class="fas fa-edit mr-2"></i>
                        Update Profile
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.resident', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/resident/emergency.blade.php ENDPATH**/ ?>