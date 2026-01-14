<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Flood Control System')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="h-full">
    <div class="min-h-full flex">
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div class="text-center">
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                        <?php echo $__env->yieldContent('title'); ?>
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        <?php echo $__env->yieldContent('subtitle'); ?>
                    </p>
                </div>

                <div class="mt-8">
                    <div class="mt-6">
                        <?php if (! empty(trim($__env->yieldContent('content')))): ?>
                            <?php echo $__env->yieldContent('content'); ?>
                        <?php else: ?>
                            <?php echo e($slot ?? ''); ?>

                        <?php endif; ?>
                    </div>
                </div>
                
                <?php if (! empty(trim($__env->yieldContent('footer')))): ?>
                    <div class="mt-8 text-center text-sm text-gray-500">
                        <?php echo $__env->yieldContent('footer'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="hidden lg:block relative w-0 flex-1">
            <img class="absolute inset-0 h-full w-full object-cover" src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1908&q=80" alt="Flood Control">
        </div>
    </div>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/layouts/auth.blade.php ENDPATH**/ ?>