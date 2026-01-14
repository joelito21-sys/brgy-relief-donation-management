<?php $__env->startSection('title', 'Choose Donation Type - Barangay Cubacub Relief and Donation Management Program'); ?>

<?php $__env->startSection('header', 'Choose Donation Type'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-dark mb-3">Choose Donation Type</h1>
                <p class="lead text-muted mb-4">Select how you'd like to contribute to our flood relief efforts</p>
                <div class="underline mx-auto"></div>
            </div>
            
            <div class="row">
                <!-- Cash Donation -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-all duration-300">
                        <div class="card-body d-flex flex-column text-center p-4">
                            <div class="icon-wrapper bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                                <i class="fas fa-money-bill-wave text-primary fs-1"></i>
                            </div>
                            <h3 class="card-title fw-bold text-dark mb-3">Cash Donation</h3>
                            <p class="card-text text-muted flex-grow-1 mb-4">Make a monetary donation to support our relief efforts.</p>
                            <a href="<?php echo e(route('donor.donations.cash.index')); ?>" 
                               class="btn btn-primary w-100 py-2 fw-medium mt-auto">
                                Donate Now
                                <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Food Donation -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-all duration-300">
                        <div class="card-body d-flex flex-column text-center p-4">
                            <div class="icon-wrapper bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                                <i class="fas fa-utensils text-success fs-1"></i>
                            </div>
                            <h3 class="card-title fw-bold text-dark mb-3">Food Donation</h3>
                            <p class="card-text text-muted flex-grow-1 mb-4">Donate food items to help feed affected families.</p>
                            <a href="<?php echo e(route('donor.donations.food.index')); ?>" 
                               class="btn btn-success w-100 py-2 fw-medium mt-auto">
                                Donate Now
                                <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Clothing Donation -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-all duration-300">
                        <div class="card-body d-flex flex-column text-center p-4">
                            <div class="icon-wrapper bg-purple bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                                <i class="fas fa-tshirt text-purple fs-1"></i>
                            </div>
                            <h3 class="card-title fw-bold text-dark mb-3">Clothing Donation</h3>
                            <p class="card-text text-muted flex-grow-1 mb-4">Donate clothes to help those affected by the floods.</p>
                            <a href="<?php echo e(route('donor.donations.clothing.index')); ?>" 
                               class="btn btn-purple w-100 py-2 fw-medium mt-auto">
                                Donate Now
                                <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Medicine Donation -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-all duration-300">
                        <div class="card-body d-flex flex-column text-center p-4">
                            <div class="icon-wrapper bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                                <i class="fas fa-pills text-danger fs-1"></i>
                            </div>
                            <h3 class="card-title fw-bold text-dark mb-3">Medicine Donation</h3>
                            <p class="card-text text-muted flex-grow-1 mb-4">Donate medical supplies for those in need.</p>
                            <a href="<?php echo e(route('donor.donations.medicine.index')); ?>" 
                               class="btn btn-danger w-100 py-2 fw-medium mt-auto">
                                Donate Now
                                <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <a href="<?php echo e(route('donor.dashboard')); ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .icon-wrapper {
        transition: all 0.3s ease;
    }
    
    .card:hover .icon-wrapper {
        transform: scale(1.1);
    }
    
    .underline {
        height: 4px;
        width: 80px;
        background: linear-gradient(90deg, #28a745, #20c997);
        border-radius: 2px;
    }
    
    .btn-purple {
        background-color: #6f42c1;
        border-color: #6f42c1;
        color: white;
    }
    
    .btn-purple:hover {
        background-color: #5a32a3;
        border-color: #5a32a3;
        color: white;
    }
    
    .text-purple {
        color: #6f42c1 !important;
    }
    
    .bg-purple {
        background-color: #6f42c1 !important;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('donor.layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/donor/donations/types/index.blade.php ENDPATH**/ ?>