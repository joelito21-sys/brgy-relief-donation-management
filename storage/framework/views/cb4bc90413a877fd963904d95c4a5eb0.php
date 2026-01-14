

<?php $__env->startSection('title', 'Resident Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Welcome Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">Welcome, <?php echo e($resident->first_name); ?> <?php echo e($resident->last_name); ?>!</h1>
                    <p class="text-indigo-100 mt-2">Your flood relief assistance dashboard</p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-indigo-100">Current Status</div>
                    <div class="text-xl font-semibold text-white">
                        <?php if($evacuationStatus === false): ?>
                            🏠 At Home
                        <?php else: ?>
                            🚨 Evacuated
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Evacuation Alert -->
        <div class="mb-8">
            <div class="<?php echo e($evacuationStatus === false ? 'bg-green-50 border-green-200' : 'bg-yellow-50 border-yellow-200'); ?> border-l-4 p-4 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas <?php echo e($evacuationStatus === false ? 'fa-home text-green-400' : 'fa-exclamation-triangle text-yellow-400'); ?> text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-medium <?php echo e($evacuationStatus === false ? 'text-green-800' : 'text-yellow-800'); ?>">
                            <?php echo e($evacuationStatus === false ? 'Safety Status' : 'Evacuation Notice'); ?>

                        </h3>
                        <div class="mt-2 text-sm <?php echo e($evacuationStatus === false ? 'text-green-700' : 'text-yellow-700'); ?>">
                            <p><?php echo e($evacuationInfo['message']); ?></p>
                            <p class="mt-1"><?php echo e($evacuationInfo['action']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Distribution Notifications -->
        <div class="mb-8">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Upcoming Distributions</h2>
                    <span class="text-sm text-gray-400">View All</span>
                </div>
                <div class="p-6">
                    <?php
                        // Fetch all notifications without strict filtering first
                        $allNotifications = \App\Models\DistributionNotification::all();
                        
                        // More inclusive query to display notifications
                        $upcomingNotifications = \App\Models\DistributionNotification::where('scheduled_date', '>', now())
                            ->where(function($query) use ($resident) {
                                // Include all general notifications regardless of targeting
                                $query->where('distribution_type', 'general')
                                    // Include specific notifications for this resident
                                    ->orWhere(function($subQuery) use ($resident) {
                                        $subQuery->where('distribution_type', 'specific')
                                            ->whereHas('reliefRequest', function($reliefQuery) use ($resident) {
                                                $reliefQuery->where('user_id', $resident->user_id);
                                            });
                                    })
                                    // Include notifications with no type specified
                                    ->orWhereNull('distribution_type');
                            })
                            ->orderBy('scheduled_date', 'asc')
                            ->take(5)
                            ->get();
                    ?>
                    
                    <?php if($upcomingNotifications->count() > 0): ?>
                        <div class="space-y-4">
                            <?php $__currentLoopData = $upcomingNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border-l-4 border-indigo-500 bg-indigo-50 p-4 rounded">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h3 class="font-medium text-indigo-900"><?php echo e($notification->title); ?></h3>
                                            <p class="text-sm text-indigo-700 mt-1"><?php echo e($notification->message); ?></p>
                                            <div class="mt-2 text-sm text-indigo-600">
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                <?php echo e($notification->formatted_scheduled_date); ?>

                                            </div>
                                            <div class="mt-1 text-sm text-indigo-600">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                <?php echo e($notification->location); ?>

                                            </div>
                                            <?php if($notification->additional_info): ?>
                                                <div class="mt-2 text-sm text-indigo-600">
                                                    <i class="fas fa-info-circle mr-1"></i>
                                                    <?php echo e($notification->additional_info); ?>

                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="ml-4">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                <?php echo e(ucfirst($notification->distribution_type ?? 'general')); ?>

                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <i class="fas fa-bell-slash text-gray-300 text-4xl mb-4"></i>
                            <p class="text-gray-500">No upcoming distributions scheduled</p>
                            <p class="text-sm text-gray-400 mt-2">Check back later for new distribution announcements</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-clipboard-list text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Requests</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['total_requests']); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pending</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['pending_requests']); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Completed</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['completed_requests']); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full">
                        <i class="fas fa-box text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Items Received</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['total_received_items']); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Relief Requests -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Recent Relief Requests</h2>
                    </div>
                    <div class="p-6">
                        <?php if($reliefRequests->count() > 0): ?>
                            <div class="space-y-4">
                                <?php $__currentLoopData = $reliefRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <h3 class="font-medium text-gray-900">Request #<?php echo e($request->id); ?></h3>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                <?php echo e($request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($request->status === 'approved' ? 'bg-blue-100 text-blue-800' : 
                                                   ($request->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'))); ?>">
                                                <?php echo e(ucfirst($request->status)); ?>

                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-2">
                                            <?php echo e($request->created_at->format('M d, Y h:i A')); ?>

                                        </p>
                                        <?php if($request->items && $request->items->count() > 0): ?>
                                            <div class="text-sm text-gray-700">
                                                <strong>Items requested:</strong>
                                                <ul class="mt-1 ml-4 list-disc">
                                                    <?php $__currentLoopData = $request->items->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li><?php echo e($item->name); ?> (<?php echo e($item->quantity); ?>)</li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($request->items->count() > 3): ?>
                                                        <li>... and <?php echo e($request->items->count() - 3); ?> more</li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                        <div class="mt-3">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                                View Details →
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-8">
                                <i class="fas fa-clipboard-list text-gray-300 text-4xl mb-4"></i>
                                <p class="text-gray-500">No relief requests yet</p>
                                <a href="#" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    <i class="fas fa-plus mr-2"></i>Create New Request
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Recent Activity</h2>
                    </div>
                    <div class="p-6">
                        <?php if($recentActivities->count() > 0): ?>
                            <div class="space-y-4">
                                <?php $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-<?php echo e($activity['color']); ?>-100 rounded-full flex items-center justify-center">
                                                <i class="<?php echo e($activity['icon']); ?> text-<?php echo e($activity['color']); ?>-600 text-xs"></i>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900">
                                                <?php echo e($activity['title']); ?>

                                            </p>
                                            <p class="text-sm text-gray-500">
                                                <?php echo e($activity['description']); ?>

                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">
                                                <?php echo e($activity['date']->diffForHumans()); ?>

                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-8">
                                <i class="fas fa-history text-gray-300 text-4xl mb-4"></i>
                                <p class="text-gray-500">No recent activity</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-plus text-indigo-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-900">New Relief Request</h3>
                                <p class="text-sm text-gray-500">Request assistance</p>
                            </div>
                        </a>

                        <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-edit text-green-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-900">Update Profile</h3>
                                <p class="text-sm text-gray-500">Edit your information</p>
                            </div>
                        </a>

                        <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-phone text-purple-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-900">Emergency Contact</h3>
                                <p class="text-sm text-gray-500">Get help now</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.resident', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/resident/dashboard.blade.php ENDPATH**/ ?>