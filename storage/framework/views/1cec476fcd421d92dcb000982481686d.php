<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Relief Assistance Request</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #ef4444; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9fafb; }
        .details { background: white; padding: 20px; border: 1px solid #e5e7eb; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 14px; }
        .urgency-high { color: #dc2626; font-weight: bold; }
        .urgency-medium { color: #d97706; font-weight: bold; }
        .urgency-low { color: #059669; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🆘 New Relief Request Received</h1>
        </div>
        
        <div class="content">
            <p><strong>Urgency Level:</strong> <span class="urgency-<?php echo e($reliefRequest->urgency_level); ?>"><?php echo e(ucfirst($reliefRequest->urgency_level)); ?></span></p>
            
            <div class="details">
                <h2>Request Details</h2>
                <p><strong>Resident:</strong> <?php echo e($reliefRequest->full_name); ?></p>
                <p><strong>Contact:</strong> <?php echo e($reliefRequest->contact_number); ?></p>
                <p><strong>Address:</strong> <?php echo e($reliefRequest->complete_address); ?>, <?php echo e($reliefRequest->city_municipality); ?></p>
                <p><strong>Family Members:</strong> <?php echo e($reliefRequest->household_size); ?></p>
                
                <h3>Assistance Needed:</h3>
                <ul>
                    <?php $__currentLoopData = $reliefRequest->assistance_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e(ucfirst($type)); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                
                <h3>Description:</h3>
                <p><?php echo e($reliefRequest->description); ?></p>
                
                <?php if($reliefRequest->additional_message): ?>
                    <h3>Additional Message:</h3>
                    <p><?php echo e($reliefRequest->additional_message); ?></p>
                <?php endif; ?>
            </div>
            
            <p>Please review this request in the admin panel.</p>
        </div>
        
        <div class="footer">
            <p>&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. All rights reserved.</p>
            <p>Request ID: <?php echo e($reliefRequest->request_number); ?></p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/emails/relief-request-admin.blade.php ENDPATH**/ ?>