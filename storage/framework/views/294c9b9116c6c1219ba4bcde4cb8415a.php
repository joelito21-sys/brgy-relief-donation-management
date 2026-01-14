<?php $__env->startSection('title', 'Reports'); ?>

<?php $__env->startSection('content'); ?>
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="stat-card bg-gradient-to-r from-violet-500 to-violet-600 rounded-xl p-6  text-black">
        <div class="flex items-center justify-between">
            <div>
                <p class=" text-black text-sm">Total Reports</p>
                
                <p class="text-3xl font-bold mt-2  text-black"><?php echo e($totalReports ?? 0); ?></p>
            </div>
            <div class="bg-white rounded-lg p-3">
                <i class="fas fa-chart-bar text-2xl text-black"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-black">
        <div class="flex items-center justify-between">
            <div>
                <p class=" text-black text-black">This Month</p>
                
                <p class="text-3xl font-bold mt-2  text-black"><?php echo e($monthlyReports ?? 0); ?></p>
            </div>
            <div class="bg-white/20 rounded-lg p-3">
                <i class="fas fa-calendar-alt text-2xl  text-black"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card bg-gradient-to-r from-amber-500 to-amber-600 rounded-xl p-6  text-black">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-black text-sm">Pending</p>
               
                <p class="text-3xl font-bold mt-2  text-black"><?php echo e($pendingReports ?? 0); ?></p>
            </div>
            <div class="bg-white/20 rounded-lg p-3">
                <i class="fas fa-clock text-2xl  text-black"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-black">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-black text-sm">Generated Today</p>
              
                <p class="text-3xl font-bold mt-2  text-black"><?php echo e($todayReports ?? 0); ?></p>
            </div>
            <div class="bg-white/20 rounded-lg p-3">
                <i class="fas fa-file-export text-2xl  text-black"></i>
            </div>
        </div>
    </div>
</div>

<!-- Report Data Table -->
<?php if(isset($distributions) && count($distributions) > 0): ?>
<div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-8">
    <div class="border-b border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900">Distribution Records</h3>
        <p class="text-gray-600 mt-1">Showing <?php echo e(count($distributions)); ?> distribution records</p>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Request ID</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Distributed By</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Distribution Date</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__currentLoopData = $distributions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $distribution): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($distribution->id); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($distribution->relief_request_id ?? 'N/A'); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($distribution->distributedBy->name ?? 'N/A'); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($distribution->distribution_date->format('M d, Y')); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            <?php if($distribution->status == 'pending'): ?> bg-yellow-100 text-yellow-800
                            <?php elseif($distribution->status == 'in_progress'): ?> bg-blue-100 text-blue-800
                            <?php elseif($distribution->status == 'completed'): ?> bg-green-100 text-green-800
                            <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                            <?php echo e(ucfirst($distribution->status)); ?>

                        </span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- Donations Table -->
<?php if(isset($donations) && count($donations) > 0): ?>
<div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-8">
    <div class="border-b border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900">Donation Records</h3>
        <p class="text-gray-600 mt-1">Showing <?php echo e(count($donations)); ?> donation records</p>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Donor</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__currentLoopData = $donations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($donation->id); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($donation->donor->name ?? 'N/A'); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₱<?php echo e(number_format($donation->amount, 2)); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($donation->created_at->format('M d, Y')); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            <?php if($donation->status == 'pending'): ?> bg-yellow-100 text-yellow-800
                            <?php elseif($donation->status == 'approved'): ?> bg-green-100 text-green-800
                            <?php elseif($donation->status == 'rejected'): ?> bg-red-100 text-red-800
                            <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                            <?php echo e(ucfirst($donation->status)); ?>

                        </span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- Relief Requests Table -->
<?php if(isset($requests) && count($requests) > 0): ?>
<div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-8">
    <div class="border-b border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900">Relief Request Records</h3>
        <p class="text-gray-600 mt-1">Showing <?php echo e(count($requests)); ?> relief request records</p>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Resident</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Family Members</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($request->id); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($request->resident->name ?? 'N/A'); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($request->family_members); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($request->created_at->format('M d, Y')); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            <?php if($request->status == 'pending'): ?> bg-yellow-100 text-yellow-800
                            <?php elseif($request->status == 'approved'): ?> bg-blue-100 text-blue-800
                            <?php elseif($request->status == 'ready_for_pickup'): ?> bg-purple-100 text-purple-800
                            <?php elseif($request->status == 'claimed'): ?> bg-green-100 text-green-800
                            <?php elseif($request->status == 'delivered'): ?> bg-indigo-100 text-indigo-800
                            <?php elseif($request->status == 'rejected'): ?> bg-red-100 text-red-800
                            <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                            <?php echo e(ucfirst(str_replace('_', ' ', $request->status))); ?>

                        </span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- Donors Table -->
<?php if(isset($donors) && count($donors) > 0): ?>
<div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-8">
    <div class="border-b border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900">Donor Records</h3>
        <p class="text-gray-600 mt-1">Showing <?php echo e(count($donors)); ?> donor records</p>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Created</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__currentLoopData = $donors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($donor->id); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($donor->name); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($donor->email ?? 'N/A'); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($donor->phone ?? 'N/A'); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($donor->created_at->format('M d, Y')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- Success Message -->
<?php if(isset($report_type)): ?>
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
    <strong>Success!</strong> Generated <?php echo e($report_type); ?> report from <?php echo e($start_date ?? ''); ?> to <?php echo e($end_date ?? ''); ?>.
    <?php if(isset($donations)): ?>
        Found <?php echo e(count($donations)); ?> donation records.
    <?php elseif(isset($requests)): ?>
        Found <?php echo e(count($requests)); ?> relief request records.
    <?php elseif(isset($distributions)): ?>
        Found <?php echo e(count($distributions)); ?> distribution records.
    <?php elseif(isset($donors)): ?>
        Found <?php echo e(count($donors)); ?> donor records.
    <?php endif; ?>
</div>
<?php elseif(session('success')): ?>
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
    <strong>Success!</strong> <?php echo e(session('success')); ?>

</div>
<?php endif; ?>

<!-- Main Content Card -->
<div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl border border-violet-200">
    <!-- Header -->
    <div class="border-b border-gray-200 p-6">
        <h2 class="text-xl font-bold text-black">Generate Reports</h2>
    </div>

    <!-- Report Form -->
    <div class="p-6">
        <form action="<?php echo e(route('admin.reports.generate')); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-sm font-bold text-black mb-2">
                        <i class="fas fa-calendar-day mr-2 text-gray-400"></i>Start Date
                    </label>
                    <input type="date" 
                           id="start_date" 
                           name="start_date" 
                           value="<?php echo e(request('start_date', $defaultStartDate ?? now()->subMonth()->format('Y-m-d'))); ?>" 
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-colors text-black">
                </div>

                <!-- End Date -->
                <div>
                    <label for="end_date" class="block text-sm font-bold text-black mb-2">
                        <i class="fas fa-calendar-check mr-2 text-gray-400"></i>End Date
                    </label>
                    <input type="date" 
                           id="end_date" 
                           name="end_date" 
                           value="<?php echo e(request('end_date', $defaultEndDate ?? now()->format('Y-m-d'))); ?>" 
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-colors text-black">
                </div>

                <!-- Report Type -->
                <div>
                    <label for="report_type" class="block text-sm font-bold text-black mb-2">
                        <i class="fas fa-file-alt mr-2 text-gray-400"></i>Report Type
                    </label>
                    <select id="report_type" 
                            name="report_type" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-colors text-black">
                        <option value="">Select Report Type</option>
                        <option value="donations" <?php echo e(request('report_type') == 'donations' ? 'selected' : ''); ?>>
                            <i class="fas fa-hand-holding-heart mr-2"></i>Donations
                        </option>
                        <option value="distributions" <?php echo e(request('report_type') == 'distributions' ? 'selected' : ''); ?>>
                            <i class="fas fa-truck mr-2"></i>Distributions
                        </option>
                        <option value="relief_requests" <?php echo e(request('report_type') == 'relief_requests' ? 'selected' : ''); ?>>
                            <i class="fas fa-hand-holding-medical mr-2"></i>Relief Requests
                        </option>
                        <option value="inventory" <?php echo e(request('report_type') == 'inventory' ? 'selected' : ''); ?>>
                            <i class="fas fa-boxes mr-2"></i>Inventory
                        </option>
                        <option value="residents" <?php echo e(request('report_type') == 'residents' ? 'selected' : ''); ?>>
                            <i class="fas fa-users mr-2"></i>Residents
                        </option>
                        <option value="donors" <?php echo e(request('report_type') == 'donors' ? 'selected' : ''); ?>>
                            <i class="fas fa-user-friends mr-2"></i>Donors
                        </option>
                    </select>
                </div>
            </div>

            <!-- Additional Options -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Format -->
                <div>
                    <label for="format" class="block text-sm font-bold text-black mb-2">
                        <i class="fas fa-file-download mr-2 text-gray-400"></i>Export Format
                    </label>
                    <select id="format" 
                            name="format" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-colors text-black">
                        <option value="view" selected>View in Browser</option>
                        <option value="csv">Download as CSV</option>
                        <option value="xml">Download as XML</option>
                        <option value="pdf">Download as PDF</option>
                    </select>
                </div>

                <!-- Include Charts -->
                <div>
                    <label class="block text-sm font-bold text-black mb-2">
                        <i class="fas fa-chart-line mr-2 text-gray-400"></i>Additional Options
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="include_charts" value="1" class="mr-2 rounded text-violet-600 focus:ring-violet-500">
                            <span class="text-sm text-black">Include Charts</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="include_summary" value="1" checked class="mr-2 rounded text-violet-600 focus:ring-violet-500">
                            <span class="text-sm text-black">Include Summary</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center pt-4">
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-violet-600 to-violet-700  text-black rounded-lg hover:from-violet-700 hover:to-violet-800 transition-all transform hover:scale-105 shadow-lg font-bold">
                    <i class="fas fa-file-export mr-2"></i>Generate Report
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('Form is being submitted');
            console.log('Form method:', form.method);
            console.log('Form action:', form.action);
            
            // Log all form data
            const formData = new FormData(form);
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }
        });
    }
});
</script>

<!-- Recent Reports -->
<?php if(isset($recentReports) && $recentReports->count() > 0): ?>
<div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl border border-violet-200 mt-8">
    <div class="border-b border-gray-200 p-6">
        <h2 class="text-xl font-bold text-black">Recent Reports</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Report Type</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Date Range</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Generated</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Format</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__currentLoopData = $recentReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-violet-100 text-black">
                            <?php echo e(ucfirst($report->type)); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-black">
                        <?php echo e($report->start_date); ?> to <?php echo e($report->end_date); ?>

                    </td>
                    <td class="px-6 py-4 text-sm text-black">
                        <?php echo e($report->created_at->format('M d, Y h:i A')); ?>

                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-gray-100 text-black">
                            <?php echo e(strtoupper($report->format)); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <a href="<?php echo e($report->file_url); ?>" 
                               target="_blank"
                               class="action-btn inline-flex items-center px-3 py-1.5 bg-violet-100 text-black rounded-lg hover:bg-violet-200 text-sm font-bold">
                                <i class="fas fa-download mr-1"></i>Download
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<style>
    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 0.5rem;
        overflow: hidden;
        background: white;
        box-shadow: 0 0.15rem 1.75rem rgba(139, 92, 246, 0.15);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(139, 92, 246, 0.3) !important;
    }
    
    .action-btn {
        font-weight: 700; /* Bold text */
    }
    
    .bg-gradient-to-r {
        font-weight: 700; /* Bold text */
    }
    
    /* Make all text black except for stat cards */
    .text-gray-700, .text-gray-600, .text-gray-500 {
        color: black !important;
        font-weight: bold !important;
    }
    
    .text-sm, .text-xs {
        font-weight: bold !important;
    }
    
    /* Ensure stat card text is white for visibility */
    .stat-card .text-3xl,
    .stat-card .text-black {
        color: black!important;
    }
    
    .stat-card .text-violet-100,
    .stat-card .text-green-100,
    .stat-card .text-amber-100,
    .stat-card .text-purple-100 {
        color: rgba(21, 19, 19, 0.8) !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>