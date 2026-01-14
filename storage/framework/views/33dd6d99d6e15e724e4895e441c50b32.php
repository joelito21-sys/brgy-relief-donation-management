<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thank You for Your Cash Donation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #3b82f6; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9fafb; }
        .receipt { background: white; padding: 20px; border: 1px solid #e5e7eb; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" style="height: 100px; width: auto; margin-bottom: 15px;">
            <p style="font-size: 18px; font-weight: bold; margin: 0 0 10px;">Barangay Cubacub Relief and Donation Management Program</p>
            <h1>🎉 Thank You for Your Generous Cash Donation!</h1>
        </div>
        
        <div class="content">
            <p>Dear <?php echo e($donation->donor_name); ?>,</p>
            
            <p>We are incredibly grateful for your cash donation of <strong>₱<?php echo e(number_format($donation->amount, 2)); ?></strong>. Your generosity will make a significant difference in providing relief to families affected by the floods.</p>
            
            <div class="receipt">
                <h2>📋 Donation Receipt</h2>
                <p><strong>Receipt #:</strong> <?php echo e($donation->reference_number); ?></p>
                <p><strong>Date:</strong> <?php echo e($donation->created_at->format('F j, Y')); ?></p>
                <p><strong>Amount:</strong> ₱<?php echo e(number_format($donation->amount, 2)); ?></p>
                <p><strong>Payment Method:</strong> <?php echo e(ucfirst($donation->payment_method)); ?></p>
                <?php if($donation->payment_method === 'bank'): ?>
                    <p><strong>Bank:</strong> <?php echo e($donation->details['bank_name'] ?? 'N/A'); ?></p>
                    <p><strong>Sender Name:</strong> <?php echo e($donation->details['sender_name'] ?? 'N/A'); ?></p>
                <?php endif; ?>
            </div>
            
            <p>Your generous contribution will help us provide:</p>
            <ul>
                <li>Emergency food supplies for affected families</li>
                <li>Clean drinking water and essential supplies</li>
                <li>Medical assistance and first aid supplies</li>
                <li>Temporary shelter materials for displaced families</li>
                <li>Clothing and blankets for those who lost everything</li>
            </ul>
            
            <p>Every donation, no matter the size, brings hope to families who have lost so much. Your kindness and compassion during this difficult time demonstrate the true spirit of community and solidarity. Together, we are stronger than any storm.</p>
            
            <p>"When we give cheerfully and accept gratefully, everyone is blessed." - Maya Angelou</p>
            
            <p>Your donation has been automatically processed and recorded. You will receive updates on how your contribution is making an impact. We'll send you periodic reports on the relief efforts you're supporting. Your donation is tax-deductible (receipt attached for your records).</p>
            
            <p>Want to see the ongoing impact of your donation? Follow our relief efforts:</p>
            <p><a href="<?php echo e(route('donor.dashboard')); ?>">Track Your Impact</a></p>
            
            <p>If you have any questions or would like to volunteer your time as well, please don't hesitate to contact us.</p>
            
            <p>Contact Information:</p>
            <p>Flood Relief Hotline: +63 2 1234 5678</p>
            <p>Email: relief@floodcontrol.org</p>
            <p>Website: <?php echo e(config('app.url')); ?></p>
            
            <p>Once again, thank you for being a beacon of hope in these challenging times. Your generosity will ripple through our community and bring comfort to those who need it most.</p>
            
            <p>With deepest gratitude,</p>
            <p>The Flood Relief Team</p>
            <p><?php echo e(config('app.name')); ?></p>
        </div>
        
        <div class="footer">
            <p>This email serves as an official receipt for your donation. Please save it for your records. If you need an official printed receipt for tax purposes, please reply to this email with your mailing address.</p>
            <p>&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. All rights reserved.</p>
            <p>This is an automated receipt for your cash donation. Reference #: <?php echo e($donation->reference_number); ?></p>
        </div>
    </div>
</body>
</html>
   <?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/emails/donations/cash-receipt.blade.php ENDPATH**/ ?>