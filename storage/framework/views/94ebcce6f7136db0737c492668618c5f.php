

<?php $__env->startSection('title', 'Contact Messages'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Contact Messages</h1>
            <p class="text-sm text-gray-500 mt-1">View and manage messages from donors</p>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if(session('success')): ?>
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center">
            <i class="fas fa-check-circle mr-3 text-green-500"></i>
            <?php echo e(session('success')); ?>

            <button onclick="this.parentElement.remove()" class="ml-auto text-green-500 hover:text-green-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    <?php endif; ?>

    <!-- Messages Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h2 class="font-bold text-gray-800 flex items-center">
                <i class="fas fa-envelope mr-2 text-violet-600"></i> Messages List
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <?php if($messages->count() > 0): ?>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-semibold tracking-wider">
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Sender Info</th>
                            <th class="px-6 py-4">Subject</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <?php if($message->status == 'pending'): ?>
                                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-700 border border-amber-200">
                                            Pending
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">
                                            Replied
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900"><?php echo e($message->name); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e($message->email); ?></div>
                                </td>
                                <td class="px-6 py-4 text-gray-700 font-medium">
                                    <?php echo e($message->subject); ?>

                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <?php echo e($message->created_at->format('M d, Y h:i A')); ?>

                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="<?php echo e(route('admin.contact-messages.show', $message)); ?>" 
                                           class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" 
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.contact-messages.destroy', $message)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" 
                                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" 
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="p-12 text-center text-gray-500">
                    <div class="mb-4">
                        <i class="fas fa-inbox text-4xl text-gray-300"></i>
                    </div>
                    <p class="font-medium">No contact messages found.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if($messages->hasPages()): ?>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                <?php echo e($messages->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/admin/contact_messages/index.blade.php ENDPATH**/ ?>