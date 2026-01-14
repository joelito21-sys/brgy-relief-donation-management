

<?php $__env->startSection('title', 'Resident Details'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .resident-header {
        background: linear-gradient(135deg, #4f46e5 0%, #0ea5e9 100%);
        padding: 2rem;
        border-radius: 1rem;
        color: white;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    .resident-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: url('patterns/circuit-board.svg'); /* Optional texture */
        opacity: 0.1;
    }
    .profile-avatar {
        background: white;
        padding: 4px;
        border-radius: 50%;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .info-card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s;
        height: 100%;
        background: #fff;
    }
    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .info-label {
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }
    .info-value {
        color: #111827;
        font-weight: 600;
        font-size: 1rem;
    }
    .id-card-preview {
        border-radius: 0.75rem;
        overflow: hidden;
        border: 2px solid #e5e7eb;
        transition: all 0.3s;
        cursor: pointer;
        position: relative;
        max-width: 160px;
    }
    .id-card-preview:hover {
        border-color: #4f46e5;
        transform: scale(1.02);
    }
    .id-card-preview img {
        width: 100%;
        height: 100px;
        object-fit: cover;
    }
    .id-card-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.2s;
    }
    .id-card-preview:hover .id-card-overlay {
        opacity: 1;
    }
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-weight: 600;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .status-pending { background: #fef3c7; color: #d97706; }
    .status-approved { background: #dcfce7; color: #16a34a; }
    .status-rejected { background: #fee2e2; color: #dc2626; }
    
    .timeline-item {
        border-left: 2px solid #e5e7eb;
        padding-left: 1.5rem;
        padding-bottom: 2rem;
        position: relative;
    }
    .timeline-item:last-child { border-left: transparent; }
    .timeline-dot {
        width: 12px;
        height: 12px;
        background: #4f46e5;
        border-radius: 50%;
        position: absolute;
        left: -7px;
        top: 0;
        border: 2px solid white;
        box-shadow: 0 0 0 2px #4f46e5;
    }
    .timeline-date {
        font-size: 0.75rem;
        color: #6b7280;
        margin-bottom: 0.25rem;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid pb-5">
    <!-- Header Section -->
    <div class="resident-header">
        <div class="d-flex justify-content-between align-items-start">
            <div class="d-flex align-items-center gap-4">
                <div class="profile-avatar text-center">
                    <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($resident->first_name . ' ' . $resident->last_name)); ?>&background=random&size=128" 
                         alt="Profile" class="rounded-circle" width="80" height="80">
                </div>
                <div>
                    <h1 class="display-6 fw-bold mb-1"><?php echo e($resident->first_name); ?> <?php echo e($resident->last_name); ?></h1>
                    <div class="d-flex align-items-center gap-3">
                        <span class="opacity-75"><i class="fas fa-envelope me-2"></i><?php echo e($resident->email); ?></span>
                        <span class="opacity-75">|</span>
                        <span class="opacity-75"><i class="fas fa-phone me-2"></i><?php echo e($resident->phone); ?></span>
                    </div>
                </div>
            </div>
            <a href="<?php echo e(route('admin.residents.index')); ?>" class="btn btn-light btn-sm shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Back to List
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Info Column -->
        <div class="col-lg-8">
            <!-- Personal Information -->
            <div class="card info-card mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold text-primary mb-4">
                        <i class="fas fa-user-circle me-2"></i>Personal Details
                    </h5>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="info-label">ID Number</div>
                            <div class="info-value"><?php echo e($resident->id_number); ?></div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">ID Type</div>
                            <div class="info-value"><?php echo e($resident->id_type); ?></div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">Registration Date</div>
                            <div class="info-value"><?php echo e($resident->created_at->format('M d, Y')); ?><br><small class="text-muted"><?php echo e($resident->created_at->format('h:i A')); ?></small></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ID Photos -->
            <div class="card info-card mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold text-primary mb-4">
                        <i class="fas fa-id-card me-2"></i>Identification Documents
                    </h5>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="info-label mb-2">Valid ID (Front)</div>
                            <?php if($resident->valid_id_front): ?>
                                <?php $frontUrl = asset('storage/' . str_replace('\\', '/', $resident->valid_id_front)); ?>
                                <div class="id-card-preview" onclick="window.open('<?php echo e($frontUrl); ?>', '_blank')">
                                    <img src="<?php echo e($frontUrl); ?>" alt="ID Front">
                                    <div class="id-card-overlay">
                                        <span class="text-white fw-bold"><i class="fas fa-search-plus me-2"></i>View Full Size</span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-secondary text-center py-4">
                                    <i class="fas fa-image fa-2x mb-2 text-muted"></i>
                                    <p class="m-0 text-muted">No front ID uploaded</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label mb-2">Valid ID (Back)</div>
                            <?php if($resident->valid_id_back): ?>
                                <?php $backUrl = asset('storage/' . str_replace('\\', '/', $resident->valid_id_back)); ?>
                                <div class="id-card-preview" onclick="window.open('<?php echo e($backUrl); ?>', '_blank')">
                                    <img src="<?php echo e($backUrl); ?>" alt="ID Back">
                                    <div class="id-card-overlay">
                                        <span class="text-white fw-bold"><i class="fas fa-search-plus me-2"></i>View Full Size</span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-secondary text-center py-4">
                                    <i class="fas fa-image fa-2x mb-2 text-muted"></i>
                                    <p class="m-0 text-muted">No back ID uploaded</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address & Emergency -->
            <div class="card info-card">
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h5 class="card-title fw-bold text-primary mb-4">
                                <i class="fas fa-map-marker-alt me-2"></i>Address
                            </h5>
                            <div class="d-flex flex-column gap-3">
                                <div>
                                    <div class="info-label">Street / Purok</div>
                                    <div class="info-value"><?php echo e($resident->house_number ? $resident->house_number . ', ' : ''); ?><?php echo e($resident->address); ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="info-label">Barangay</div>
                                        <div class="info-value"><?php echo e($resident->barangay); ?></div>
                                    </div>
                                    <div class="col-6">
                                        <div class="info-label">City</div>
                                        <div class="info-value"><?php echo e($resident->city); ?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="info-label">Province</div>
                                        <div class="info-value"><?php echo e($resident->province); ?></div>
                                    </div>
                                    <div class="col-6">
                                        <div class="info-label">Country</div>
                                        <div class="info-value"><?php echo e($resident->country); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 border-start ps-md-4">
                            <h5 class="card-title fw-bold text-primary mb-4">
                                <i class="fas fa-phone-volume me-2"></i>Emergency Contact
                            </h5>
                            <div class="d-flex flex-column gap-3">
                                <div>
                                    <div class="info-label">Contact Name</div>
                                    <div class="info-value"><?php echo e($resident->emergency_contact_name); ?></div>
                                </div>
                                <div>
                                    <div class="info-label">Contact Number</div>
                                    <div class="info-value text-danger fw-bold"><?php echo e($resident->emergency_contact_phone); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Column -->
        <div class="col-lg-4">
            <!-- Action Card -->
            <div class="card info-card mb-4 border-0 shadow-lg">
                <div class="card-body p-4 text-center">
                    <h5 class="fw-bold text-uppercase text-muted mb-4 text-start">Application Status</h5>
                    
                    <?php if($resident->isPending()): ?>
                        <div class="status-badge status-pending mb-3 transform scale-125">
                            <i class="fas fa-clock"></i> Pending Approval
                        </div>
                        <p class="text-muted small mb-4">Review the details before processing this request.</p>
                        
                        <div class="d-grid gap-2">
                            <form method="POST" action="<?php echo e(route('admin.residents.approve', $resident)); ?>" class="d-grid">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-success py-2 fw-bold" onclick="return confirm('Approve this resident registration?')">
                                    <i class="fas fa-check-circle me-2"></i> Approve
                                </button>
                            </form>
                            <button type="button" class="btn btn-outline-danger py-2 fw-bold" onclick="showRejectModal(<?php echo e($resident->id); ?>)">
                                <i class="fas fa-times-circle me-2"></i> Reject
                            </button>
                        </div>

                    <?php elseif($resident->isApproved()): ?>
                        <div class="status-badge status-approved mb-3 table-scale-125">
                            <i class="fas fa-check-circle"></i> Account Approved
                        </div>
                        <p class="text-success small mb-0">Access granted on <?php echo e($resident->updated_at->format('M d, Y')); ?></p>
                    
                    <?php elseif($resident->isRejected()): ?>
                        <div class="status-badge status-rejected mb-3 table-scale-125">
                            <i class="fas fa-ban"></i> Application Rejected
                        </div>
                        <?php if($resident->rejection_reason): ?>
                            <div class="bg-light rounded p-3 text-start border-start border-4 border-danger">
                                <small class="text-muted d-block mb-1">Reason:</small>
                                <span class="text-dark"><?php echo e($resident->rejection_reason); ?></span>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Statistics -->
            <div class="card info-card mb-4">
                <div class="card-body p-4">
                     <h5 class="fw-bold text-uppercase text-muted mb-4">Participation Stats</h5>
                     <div class="row g-2">
                         <div class="col-6">
                             <div class="p-3 rounded bg-light text-center border">
                                 <h3 class="fw-bold text-primary mb-0"><?php echo e($resident->reliefRequests()->count()); ?></h3>
                                 <small class="text-muted">Requests</small>
                             </div>
                         </div>
                         <div class="col-6">
                             <div class="p-3 rounded bg-light text-center border">
                                 <h3 class="fw-bold text-success mb-0"><?php echo e($resident->receivedDonations()->count()); ?></h3>
                                 <small class="text-muted">Received</small>
                             </div>
                         </div>
                     </div>
                </div>
            </div>

            <!-- Activity Timeline -->
            <div class="card info-card">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-uppercase text-muted mb-4">Recent Activity</h5>
                    <?php if($resident->activityLogs && $resident->activityLogs->count() > 0): ?>
                        <div class="ps-2">
                            <?php $__currentLoopData = $resident->activityLogs->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-date"><?php echo e($log->created_at->format('M d, h:i A')); ?></div>
                                    <div class="fw-bold text-dark"><?php echo e($log->description); ?></div>
                                    <?php if($log->causer): ?>
                                        <small class="text-muted">by <?php echo e($log->causer->name ?? 'System'); ?></small>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted py-3">
                            <i class="fas fa-history fa-2x mb-2 opacity-50"></i>
                            <p class="m-0 small">No activity recorded yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1rem;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger">Reject Application</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="rejectForm">
                <?php echo csrf_field(); ?>
                <div class="modal-body pt-3 pb-4">
                    <p class="text-muted mb-3">Please specify mainly why this resident's registration is being rejected. This will be sent to the user via email.</p>
                    <div class="form-floating">
                        <textarea name="rejection_reason" id="rejection_reason" class="form-control" placeholder="Reason" style="height: 120px"></textarea>
                        <label for="rejection_reason">Rejection Reason (Optional)</label>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4">Confirm Rejection</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function showRejectModal(residentId) {
    const form = document.getElementById('rejectForm');
    form.action = `/admin/residents/${residentId}/reject`;
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/admin/residents/show.blade.php ENDPATH**/ ?>