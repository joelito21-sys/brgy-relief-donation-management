

<?php $__env->startSection('title', 'Distribution Notifications'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-lg mt-4">
                <div class="card-header bg-gradient-primary text-white py-4 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            <i class="fas fa-bell fa-2x"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">Distribution Notifications</h4>
                            <p class="mb-0 small">Manage and send distribution notifications to residents</p>
                        </div>
                    </div>
                    <a href="<?php echo e(route('admin.distribution-notifications.create')); ?>" class="btn btn-light text-primary font-weight-bold">
                        <i class="fas fa-plus mr-1"></i> Create Notification
                    </a>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle fa-lg mr-2"></i>
                                <div><?php echo e(session('success')); ?></div>
                            </div>
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle fa-lg mr-2"></i>
                                <div><?php echo e(session('error')); ?></div>
                            </div>
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Title & Message</th>
                                    <th>Type</th>
                                    <th>Location</th>
                                    <th>Scheduled Date</th>
                                    <th>Status</th>
                                    <th>Sent By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo e($notification->title); ?></strong>
                                            <br>
                                            <small class="text-muted"><?php echo e(Str::limit($notification->message, 50)); ?></small>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">
                                                <?php echo e(ucfirst($notification->distribution_type)); ?>

                                            </span>
                                        </td>
                                        <td><?php echo e($notification->location); ?></td>
                                        <td><?php echo e($notification->formatted_scheduled_date); ?></td>
                                        <td>
                                            <?php if($notification->is_sent): ?>
                                                <span class="badge badge-success">Sent</span>
                                                <br>
                                                <small class="text-muted"><?php echo e($notification->sent_at->format('M d, Y h:i A')); ?></small>
                                            <?php else: ?>
                                                <span class="badge badge-warning">Pending</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($notification->sentBy): ?>
                                                <?php echo e($notification->sentBy->name); ?>

                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="<?php echo e(route('admin.distribution-notifications.show', $notification)); ?>" 
                                                   class="btn btn-info" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                <?php if(!$notification->is_sent): ?>
                                                    <form action="<?php echo e(route('admin.distribution-notifications.send', $notification)); ?>" 
                                                          method="POST" style="display: inline;">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="btn btn-success" 
                                                                onclick="return confirm('Are you sure you want to send this notification to all residents?')"
                                                                title="Send Notification">
                                                            <i class="fas fa-paper-plane"></i>
                                                        </button>
                                                    </form>
                                                    
                                                    <form action="<?php echo e(route('admin.distribution-notifications.destroy', $notification)); ?>" 
                                                          method="POST" style="display: inline;">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-danger" 
                                                                onclick="return confirm('Are you sure you want to delete this notification?')"
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
                                        <td colspan="7" class="text-center py-5">
                                            <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No distribution notifications found</h5>
                                            <p class="text-muted">Get started by creating your first notification</p>
                                            <a href="<?php echo e(route('admin.distribution-notifications.create')); ?>" class="btn btn-primary">
                                                <i class="fas fa-plus mr-1"></i> Create First Notification
                                            </a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <?php echo e($notifications->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/admin/distribution-notifications/index.blade.php ENDPATH**/ ?>