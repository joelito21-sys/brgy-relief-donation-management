<?php $__env->startSection('title', 'Distribution Notifications'); ?>

<?php $__env->startSection('content'); ?>
<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="stat-card bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg transform hover:-translate-y-1 transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Notifications</p>
                <p class="text-3xl font-bold mt-2"><?php echo e($notifications->total()); ?></p>
            </div>
            <div class="bg-white/20 rounded-lg p-3 backdrop-blur-sm">
                <i class="fas fa-bell text-2xl text-white"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl p-6 text-white shadow-lg transform hover:-translate-y-1 transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-emerald-100 text-sm font-medium">Sent Successfully</p>
                <p class="text-3xl font-bold mt-2"><?php echo e($notifications->where('is_sent', true)->count()); ?></p>
            </div>
            <div class="bg-white/20 rounded-lg p-3 backdrop-blur-sm">
                <i class="fas fa-check-circle text-2xl text-white"></i>
            </div>
        </div>
    </div>

    <div class="stat-card bg-gradient-to-r from-amber-500 to-amber-600 rounded-xl p-6 text-white shadow-lg transform hover:-translate-y-1 transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-amber-100 text-sm font-medium">Pending</p>
                <p class="text-3xl font-bold mt-2"><?php echo e($notifications->where('is_sent', false)->count()); ?></p>
            </div>
            <div class="bg-white/20 rounded-lg p-3 backdrop-blur-sm">
                <i class="fas fa-clock text-2xl text-white"></i>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-white rounded-xl shadow-xl border border-blue-100 overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Distribution Notifications</h2>
            <p class="text-sm text-gray-500 mt-1">Manage and send relief distribution alerts to residents</p>
        </div>
        <a href="<?php echo e(route('admin.distribution-notifications.create')); ?>" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-bold flex items-center shadow-md">
            <i class="fas fa-plus mr-2"></i> Create Notification
        </a>
    </div>

    <!-- Flash Messages (Tailwind) -->
    <?php if(session('success')): ?>
        <div class="m-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg flex items-center">
            <i class="fas fa-check-circle mr-3 text-emerald-500 text-xl"></i>
            <span class="font-medium"><?php echo e(session('success')); ?></span>
            <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-500 hover:text-emerald-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="m-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center">
            <i class="fas fa-exclamation-circle mr-3 text-red-500 text-xl"></i>
            <span class="font-medium"><?php echo e(session('error')); ?></span>
             <button onclick="this.parentElement.remove()" class="ml-auto text-red-500 hover:text-red-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    <?php endif; ?>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-1/4">Title / Message</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Location</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Scheduled Date</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Sent By</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900"><?php echo e($notification->title); ?></div>
                            <div class="text-sm text-gray-500 truncate max-w-xs" title="<?php echo e($notification->message); ?>">
                                <?php echo e(Str::limit($notification->message, 50)); ?>

                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold <?php echo e($notification->distribution_type === 'general' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800'); ?>">
                                <i class="fas <?php echo e($notification->distribution_type === 'general' ? 'fa-bullhorn' : 'fa-users'); ?> mr-1.5"></i>
                                <?php echo e(ucfirst($notification->distribution_type)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                                <?php echo e($notification->location); ?>

                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <i class="far fa-calendar-alt text-gray-400 mr-2"></i>
                            <?php echo e($notification->formatted_scheduled_date); ?>

                        </td>
                        <td class="px-6 py-4">
                            <?php if($notification->is_sent): ?>
                                <div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                        <i class="fas fa-check-circle mr-1.5"></i> Sent
                                    </span>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <?php echo e($notification->sent_at->format('M d, Y h:i A')); ?>

                                    </div>
                                </div>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                    <i class="fas fa-clock mr-1.5"></i> Pending
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <?php if($notification->sentBy): ?>
                                <div class="flex items-center">
                                    <div class="h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs mr-2">
                                        <?php echo e(substr($notification->sentBy->name, 0, 1)); ?>

                                    </div>
                                    <?php echo e($notification->sentBy->name); ?>

                                </div>
                            <?php else: ?>
                                <span class="text-gray-400">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="<?php echo e(route('admin.distribution-notifications.show', $notification)); ?>" 
                                   class="p-1.5 text-blue-600 hover:bg-blue-50 rounded" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <?php if(!$notification->is_sent): ?>
                                    <form action="<?php echo e(route('admin.distribution-notifications.send', $notification)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure you want to send this notification to all residents?')"
                                                class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded" 
                                                title="Send Notification">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </form>
                                    
                                    <form action="<?php echo e(route('admin.distribution-notifications.destroy', $notification)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure you want to delete this notification?')"
                                                class="p-1.5 text-red-600 hover:bg-red-50 rounded" 
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <div class="h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-bell-slash text-3xl text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">No notifications found</h3>
                                <p class="text-sm mt-1 mb-4">Create a distribution notification to alert residents.</p>
                                <a href="<?php echo e(route('admin.distribution-notifications.create')); ?>" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-bold transition-colors">
                                    <i class="fas fa-plus mr-2"></i> Create First Notification
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if($notifications->hasPages()): ?>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            <?php echo e($notifications->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/admin/distributions/index.blade.php ENDPATH**/ ?>