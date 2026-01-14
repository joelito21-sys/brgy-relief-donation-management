

<?php $__env->startSection('title', 'My Relief Requests'); ?>
<?php $__env->startSection('page-title', 'Relief Requests'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">My Relief Requests</h2>
                <p class="text-gray-600 mt-1">Track and manage your relief assistance requests</p>
            </div>
            <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-plus mr-2"></i>
                New Request
            </a>
        </div>

        <!-- Status Filters -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-4 border-b border-gray-200">
                <div class="flex flex-wrap gap-2">
                    <button class="px-4 py-2 text-sm font-medium rounded-full bg-indigo-100 text-indigo-800">
                        All (<?php echo e($stats['total_requests']); ?>)
                    </button>
                    <button class="px-4 py-2 text-sm font-medium rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Pending (<?php echo e($stats['pending_requests']); ?>)
                    </button>
                    <button class="px-4 py-2 text-sm font-medium rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Approved (<?php echo e($stats['approved_requests']); ?>)
                    </button>
                    <button class="px-4 py-2 text-sm font-medium rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Completed (<?php echo e($stats['completed_requests']); ?>)
                    </button>
                </div>
            </div>
        </div>

        <!-- Requests List -->
        <div class="space-y-6">
            <?php if($reliefRequests->count() > 0): ?>
                <?php $__currentLoopData = $reliefRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <h3 class="text-lg font-medium text-gray-900">Request #<?php echo e($request->id); ?></h3>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            <?php echo e($request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($request->status === 'approved' ? 'bg-blue-100 text-blue-800' : 
                                               ($request->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'))); ?>">
                                            <?php echo e(ucfirst($request->status)); ?>

                                        </span>
                                        <?php if($request->priority === 'urgent'): ?>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>Urgent
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="text-sm text-gray-600 mb-4">
                                        <p>Submitted: <?php echo e($request->created_at->format('M d, Y h:i A')); ?></p>
                                        <?php if($request->updated_at != $request->created_at): ?>
                                            <p>Last Updated: <?php echo e($request->updated_at->format('M d, Y h:i A')); ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <?php if($request->items && $request->items->count() > 0): ?>
                                        <div class="mb-4">
                                            <h4 class="text-sm font-medium text-gray-900 mb-2">Requested Items:</h4>
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                                <?php $__currentLoopData = $request->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                                        <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                                                            <i class="fas fa-box text-indigo-600 text-xs"></i>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-900"><?php echo e($item->name); ?></p>
                                                            <p class="text-xs text-gray-500">Quantity: <?php echo e($item->quantity); ?></p>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if($request->notes): ?>
                                        <div class="mb-4">
                                            <h4 class="text-sm font-medium text-gray-900 mb-2">Additional Notes:</h4>
                                            <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg"><?php echo e($request->notes); ?></p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if($request->distributions && $request->distributions->count() > 0): ?>
                                        <div class="mb-4">
                                            <h4 class="text-sm font-medium text-gray-900 mb-2">Distribution Status:</h4>
                                            <div class="space-y-2">
                                                <?php $__currentLoopData = $request->distributions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $distribution): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                                                        <div class="flex items-center">
                                                            <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                                            <span class="text-sm text-green-800">
                                                                <?php echo e($distribution->distributed_items->count()); ?> items distributed
                                                            </span>
                                                        </div>
                                                        <span class="text-xs text-green-600">
                                                            <?php echo e($distribution->distributed_at->format('M d, Y')); ?>

                                                        </span>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="ml-4 flex-shrink-0">
                                    <div class="flex flex-col space-y-2">
                                        <?php if($request->status === 'pending'): ?>
                                            <a href="<?php echo e(route('resident.relief-requests.edit', $request->id)); ?>" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                                                <i class="fas fa-edit mr-1"></i>
                                                Edit
                                            </a>
                                            <form action="<?php echo e(route('resident.relief-requests.destroy', $request->id)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to cancel this request?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-red-300 text-sm font-medium rounded text-red-700 bg-white hover:bg-red-50">
                                                    <i class="fas fa-times mr-1"></i>
                                                    Cancel
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        
                                        <a href="<?php echo e(route('resident.relief-requests.show', $request->id)); ?>" class="inline-flex items-center px-3 py-1.5 border border-indigo-300 text-sm font-medium rounded text-indigo-700 bg-white hover:bg-indigo-50">
                                            <i class="fas fa-eye mr-1"></i>
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                    <i class="fas fa-clipboard-list text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Relief Requests Yet</h3>
                    <p class="text-gray-600 mb-6">You haven't submitted any relief assistance requests yet.</p>
                    <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-plus mr-2"></i>
                        Create Your First Request
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.resident', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/resident/relief-requests/index.blade.php ENDPATH**/ ?>