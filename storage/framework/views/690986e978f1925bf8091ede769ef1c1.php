

<?php $__env->startSection('title', 'Create Distribution Notification'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .form-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    
    .form-header {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }
    
    .form-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: radial-gradient(circle, rgba(102, 126, 234, 0.3) 0%, transparent 70%);
    }
    
    .form-header-content {
        position: relative;
        z-index: 1;
    }
    
    .form-header h2 {
        color: #fff;
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 0.25rem;
    }
    
    .form-header p {
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 0;
        font-size: 0.9rem;
    }
    
    .header-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: white;
        box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
    }
    
    .form-section {
        background: #f8f9fc;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.25rem;
        border: 1px solid #e3e6f0;
        transition: all 0.3s ease;
    }
    
    .form-section:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .section-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e3e6f0;
    }
    
    .section-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.75rem;
        font-size: 0.9rem;
    }
    
    .section-icon.blue { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
    .section-icon.green { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; }
    .section-icon.orange { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; }
    .section-icon.purple { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }
    .section-icon.pink { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; }
    
    .section-title {
        font-weight: 600;
        color: #1a1a2e;
        font-size: 1rem;
        margin: 0;
    }
    
    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.85rem;
    }
    
    .form-label .required { color: #ef4444; }
    
    .form-control-modern {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        background: #fff;
    }
    
    .form-control-modern:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background: #fff;
    }
    
    .form-hint {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.35rem;
    }
    
    .type-selector {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    
    .type-card {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.25rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        background: #fff;
    }
    
    .type-card:hover { border-color: #667eea; background: rgba(102, 126, 234, 0.05); }
    .type-card.selected { border-color: #667eea; background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); }
    
    .type-card-icon {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        font-size: 1.1rem;
    }
    
    .type-card:first-child .type-card-icon { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
    .type-card:last-child .type-card-icon { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; }
    
    .type-card-title { font-weight: 600; color: #1a1a2e; margin-bottom: 0.25rem; font-size: 0.9rem; }
    .type-card-desc { font-size: 0.75rem; color: #6b7280; }
    
    .location-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; }
    
    .toggle-switch {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.25rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        cursor: pointer;
    }
    
    .toggle-label { color: white; font-weight: 500; font-size: 0.9rem; }
    
    .toggle-input {
        width: 46px;
        height: 24px;
        appearance: none;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 12px;
        cursor: pointer;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .toggle-input::before {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: white;
        top: 2px;
        left: 2px;
        transition: all 0.3s ease;
    }
    
    .toggle-input:checked { background: rgba(255, 255, 255, 0.5); }
    .toggle-input:checked::before { left: 24px; }
    
    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 0.875rem 2rem;
        font-size: 0.95rem;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 8px 16px rgba(102, 126, 234, 0.25);
    }
    
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 24px rgba(102, 126, 234, 0.35); color: white; }
    
    .btn-cancel {
        background: #f3f4f6;
        border: 2px solid #e5e7eb;
        color: #374151;
        padding: 0.875rem 2rem;
        font-size: 0.95rem;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .btn-cancel:hover { background: #e5e7eb; color: #1f2937; }
    
    .action-buttons { display: flex; gap: 1rem; padding-top: 0.5rem; }
    
    @media (max-width: 768px) {
        .type-selector, .location-grid { grid-template-columns: 1fr; }
        .action-buttons { flex-direction: column; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <div class="form-card mt-4 mb-4">
                <!-- Header -->
                <div class="form-header">
                    <div class="form-header-content d-flex align-items-center">
                        <div class="header-icon mr-3">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div>
                            <h2>Create Distribution Notification</h2>
                            <p>Send important distribution information to residents</p>
                        </div>
                    </div>
                </div>
                
                <!-- Form Body -->
                <div class="p-4">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show rounded-lg" role="alert">
                            <i class="fas fa-check-circle mr-2"></i><?php echo e(session('success')); ?>

                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    <?php endif; ?>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger alert-dismissible fade show rounded-lg" role="alert">
                            <i class="fas fa-exclamation-triangle mr-2"></i><strong>Please fix the errors below</strong>
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('admin.distribution-notifications.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <!-- Basic Information -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon blue"><i class="fas fa-info"></i></div>
                                <h5 class="section-title">Basic Information</h5>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Notification Title <span class="required">*</span></label>
                                <input type="text" name="title" class="form-control form-control-modern <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       value="<?php echo e(old('title')); ?>" placeholder="e.g., Emergency Food Distribution - Barangay Cubacub" required>
                                <p class="form-hint">A clear and descriptive title for the notification</p>
                                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label class="form-label">Message <span class="required">*</span></label>
                                <textarea name="message" rows="3" class="form-control form-control-modern <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          placeholder="Enter the main message for residents..." required><?php echo e(old('message')); ?></textarea>
                                <p class="form-hint">Provide detailed information about the distribution</p>
                                <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Distribution Type -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon green"><i class="fas fa-users"></i></div>
                                <h5 class="section-title">Distribution Type</h5>
                            </div>
                            
                            <div class="type-selector">
                                <label class="type-card" id="type-general">
                                    <input type="radio" name="distribution_type" value="general" <?php echo e(old('distribution_type', 'general') == 'general' ? 'checked' : ''); ?> style="display: none;">
                                    <div class="type-card-icon"><i class="fas fa-globe"></i></div>
                                    <div class="type-card-title">General Distribution</div>
                                    <div class="type-card-desc">Notify all residents in area</div>
                                </label>
                                <label class="type-card" id="type-specific">
                                    <input type="radio" name="distribution_type" value="specific" <?php echo e(old('distribution_type') == 'specific' ? 'checked' : ''); ?> style="display: none;">
                                    <div class="type-card-icon"><i class="fas fa-user"></i></div>
                                    <div class="type-card-title">Specific Distribution</div>
                                    <div class="type-card-desc">Notify specific request</div>
                                </label>
                            </div>

                            <div id="general-fields" class="mt-3">
                                <label class="form-label">Target Purok (Optional)</label>
                                <select name="target_area" id="target_area" class="form-control form-control-modern" onchange="updateResidentCount()">
                                    <option value="" data-count="<?php echo e($totalApprovedResidents); ?>">All Approved Residents (<?php echo e($totalApprovedResidents); ?> residents)</option>
                                    <?php for($i = 1; $i <= 10; $i++): ?>
                                        <?php $purokName = "Purok $i"; $count = $purokCounts[$purokName] ?? 0; ?>
                                        <option value="<?php echo e($purokName); ?>" data-count="<?php echo e($count); ?>" <?php echo e(old('target_area') == $purokName ? 'selected' : ''); ?>>
                                            <?php echo e($purokName); ?> (<?php echo e($count); ?> residents)
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <p class="form-hint">Select a Purok or leave empty for all residents</p>
                                
                                <!-- Resident Count Summary -->
                                <div id="resident-count-box" class="mt-3 p-3 rounded-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <div class="d-flex align-items-center text-white">
                                        <div class="mr-3">
                                            <i class="fas fa-users fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold" id="count-label">All Approved Residents</div>
                                            <div class="h3 mb-0" id="count-number"><?php echo e($totalApprovedResidents); ?></div>
                                            <small class="opacity-75">will receive this notification</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="specific-fields" class="mt-3" style="display: none;">
                                <label class="form-label">Relief Request <span class="required">*</span></label>
                                <select name="relief_request_id" class="form-control form-control-modern">
                                    <option value="" disabled selected>-- Select Request --</option>
                                    <?php $__empty_1 = true; $__currentLoopData = $reliefRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($request->id); ?>">#<?php echo e($request->id); ?> - <?php echo e($request->full_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <option value="" disabled>No requests available</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Location & Schedule -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon orange"><i class="fas fa-map-marker-alt"></i></div>
                                <h5 class="section-title">Location & Schedule</h5>
                            </div>
                            
                            <div class="location-grid">
                                <div>
                                    <label class="form-label">Location <span class="required">*</span></label>
                                    <input type="text" name="location" class="form-control form-control-modern <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('location')); ?>" placeholder="e.g., Barangay Hall" required>
                                    <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <label class="form-label">Date & Time <span class="required">*</span></label>
                                    <input type="datetime-local" name="scheduled_date" id="scheduled_date" 
                                           class="form-control form-control-modern <?php $__errorArgs = ['scheduled_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('scheduled_date', now()->addDay()->format('Y-m-d\TH:i'))); ?>" required>
                                    <?php $__errorArgs = ['scheduled_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Info -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon purple"><i class="fas fa-sticky-note"></i></div>
                                <h5 class="section-title">Additional Information</h5>
                            </div>
                            <textarea name="additional_info" rows="2" class="form-control form-control-modern" 
                                      placeholder="Extra notes (items to bring, requirements, etc.)"><?php echo e(old('additional_info')); ?></textarea>
                        </div>

                        <!-- Send Options -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon pink"><i class="fas fa-paper-plane"></i></div>
                                <h5 class="section-title">Send Options</h5>
                            </div>
                            <label class="toggle-switch">
                                <span class="toggle-label"><i class="fas fa-bolt mr-2"></i>Send immediately</span>
                                <input type="checkbox" name="send_immediately" class="toggle-input" value="1" <?php echo e(old('send_immediately') ? 'checked' : ''); ?>>
                            </label>
                        </div>

                        <!-- Buttons -->
                        <div class="action-buttons">
                            <button type="submit" class="btn btn-submit flex-grow-1">
                                <i class="fas fa-paper-plane mr-2"></i>Create Notification
                            </button>
                            <a href="<?php echo e(route('admin.distribution-notifications.index')); ?>" class="btn btn-cancel">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Type card selection
    document.querySelectorAll('.type-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.type-card').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            const type = this.querySelector('input').value;
            document.getElementById('general-fields').style.display = type === 'general' ? 'block' : 'none';
            document.getElementById('specific-fields').style.display = type === 'specific' ? 'block' : 'none';
        });
        if (card.querySelector('input').checked) card.classList.add('selected');
    });
    
    // Update resident count display when Purok selection changes
    function updateResidentCount() {
        const select = document.getElementById('target_area');
        const selectedOption = select.options[select.selectedIndex];
        const count = selectedOption.getAttribute('data-count');
        const label = selectedOption.value || 'All Approved Residents';
        
        document.getElementById('count-label').textContent = label;
        document.getElementById('count-number').textContent = count;
    }
    
    // Set minimum datetime
    const now = new Date();
    document.getElementById('scheduled_date').min = new Date(now - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/admin/distribution-notifications/create.blade.php ENDPATH**/ ?>