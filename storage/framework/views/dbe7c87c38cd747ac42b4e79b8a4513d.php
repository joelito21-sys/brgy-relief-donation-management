<?php $__env->startSection('title', 'Donor Dashboard'); ?>
<?php $__env->startSection('header', 'Dashboard Overview'); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('styles'); ?>
    <style>
        .stats-card {
            background: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            height: 100%;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .stat-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }
        .stat-content {
            flex-grow: 1;
        }
        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            line-height: 1;
            margin-bottom: 0.25rem;
        }
        .stat-label {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 500;
        }
    </style>
    <?php $__env->stopPush(); ?>

    <div class="row g-4 mt-4">

        <!-- Stats Row -->
        <div class="col-md-6 col-lg-3">
            <div class="stats-card">
                <div class="stat-icon" style="background-color: #e0f2fe; color: #0369a1;">
                    <i class="fas fa-donate"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">₱7,411.00</div>
                    <div class="stat-label">Total Donations</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stats-card">
                <div class="stat-icon" style="background-color: #dcfce7; color: #15803d;">
                    <i class="fas fa-hands-helping"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">12</div>
                    <div class="stat-label">Donations Made</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stats-card">
                <div class="stat-icon" style="background-color: #fef3c7; color: #b45309;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">500+</div>
                    <div class="stat-label">People Helped</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stats-card">
                <div class="stat-icon" style="background-color: #f3e8ff; color: #7e22ce;">
                    <i class="fas fa-medal"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">Hero</div>
                    <div class="stat-label">Your Impact Level</div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-lg-8">
            <!-- Recent Donations -->
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Donations</h5>
                    <a href="<?php echo e(route('donor.donations.index')); ?>" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <?php if(isset($recentDonations) && count($recentDonations) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $recentDonations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($donation->created_at->format('M d, Y')); ?></td>
                                            <td>₱<?php echo e(number_format($donation->amount, 2)); ?></td>
                                            <td><?php echo e(ucfirst($donation->type)); ?></td>
                                            <td>
                                                <?php
                                                    $statusColors = [
                                                        'completed' => 'success',
                                                        'pending' => 'warning',
                                                        'failed' => 'danger',
                                                        'processing' => 'info'
                                                    ];
                                                    $color = $statusColors[$donation->status] ?? 'secondary';
                                                ?>
                                                <span class="badge bg-<?php echo e($color); ?>"><?php echo e(ucfirst($donation->status)); ?></span>
                                            </td>
                                            <td class="text-end">
                                                <a href="<?php echo e(route('donor.donations.show', $donation->id)); ?>" class="btn btn-sm btn-link p-0">
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center p-5">
                            <div class="mb-3">
                                <i class="fas fa-inbox fa-3x text-muted"></i>
                            </div>
                            <h5>No donations yet</h5>
                            <p class="text-muted">Your donation history will appear here</p>
                            <a href="<?php echo e(route('donor.donations.index')); ?>" class="btn btn-primary mt-2">
                                <i class="fas fa-plus me-2"></i>Make Your First Donation
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Donation -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Quick Donation</h5>
                </div>
                <div class="card-body">
                    <form id="quickDonationForm">
                        <div class="mb-3">
                            <label class="form-label">Amount (₱)</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">₱</span>
                                <input type="number" class="form-control" placeholder="Enter amount" min="100" step="1" required>
                            </div>
                            <div class="form-text">Minimum donation: ₱100</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Donation Type</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="donationType" id="oneTime" checked>
                                <label class="form-check-label" for="oneTime">
                                    One-time donation
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="donationType" id="monthly">
                                <label class="form-check-label" for="monthly">
                                    Monthly recurring
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-heart me-2"></i>Donate Now
                        </button>
                    </form>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Activities</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 py-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2">
                                        <i class="fas fa-donate"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1">Donation Received</h6>
                                    <p class="mb-0 small text-muted">Your donation of ₱1,000 has been received</p>
                                    <small class="text-muted">2 hours ago</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0 py-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-success bg-opacity-10 text-success rounded-circle p-2">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1">Donation Processed</h6>
                                    <p class="mb-0 small text-muted">Your donation is being distributed</p>
                                    <small class="text-muted">1 day ago</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0 py-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-info bg-opacity-10 text-info rounded-circle p-2">
                                        <i class="fas fa-bullhorn"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1">New Campaign</h6>
                                    <p class="mb-0 small text-muted">Emergency relief for flood victims in Cagayan</p>
                                    <small class="text-muted">3 days ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="#" class="btn btn-sm btn-outline-primary w-100">View All Activities</a>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        // Quick Donation Form Submission
        document.getElementById('quickDonationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const amount = this.querySelector('input[type="number"]').value;
            const isRecurring = document.getElementById('monthly').checked;
            
            // Here you would typically process the donation
            console.log(`Processing ${isRecurring ? 'monthly' : 'one-time'} donation of ₱${amount}`);
            
            // Show success message
            alert(`Thank you for your donation of ₱${amount}!`);
            this.reset();
        });
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('donor.layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/donor/dashboard.blade.php ENDPATH**/ ?>