<?php $__env->startComponent('mail::layout'); ?>
    <?php $__env->slot('header'); ?>
        <?php $__env->startComponent('mail::header', ['url' => config('app.url')]); ?>
            <img src="<?php echo new \Illuminate\Support\EncodedHtmlString(asset('images/logo.png')); ?>" alt="Logo" style="height: 100px; width: auto; margin-bottom: 5px; display: block; margin: 0 auto;">
            Barangay Cubacub Relief and Donation Management Program
        <?php echo $__env->renderComponent(); ?>
    <?php $__env->endSlot(); ?>

    # Response to Your Inquiry

    Dear <?php echo new \Illuminate\Support\EncodedHtmlString($name); ?>,

    Thank you for contacting us. Here is our response to your inquiry:

    ---

    <?php echo new \Illuminate\Support\EncodedHtmlString($responseContent); ?>


    ---

    ### Your Original Message:
    _<?php echo new \Illuminate\Support\EncodedHtmlString($originalMessage); ?>_

    If you have further questions, please do not hesitate to contact us.

    Thanks,<br>
    <?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?>


    <?php $__env->slot('footer'); ?>
        <?php $__env->startComponent('mail::footer'); ?>
            © <?php echo new \Illuminate\Support\EncodedHtmlString(date('Y')); ?> <?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?>. All rights reserved.
        <?php echo $__env->renderComponent(); ?>
    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/emails/contact-response.blade.php ENDPATH**/ ?>