<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="flex flex-col sm:flex-row items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">Dashboard Overview</h1>
        <a href="<?php echo e(route('admin.reports.index')); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
            <i class="fas fa-download mr-2"></i> Generate Report
        </a>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Residents -->
        <div class="bg-white rounded-lg shadow border-l-4 border-blue-500 h-full p-4 transform hover:-translate-y-1 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-blue-500 uppercase mb-1">Total Residents</div>
                    <div class="text-2xl font-bold text-gray-800"><?php echo e($stats['total_residents']); ?></div>
                </div>
                <div>
                    <i class="fas fa-users text-3xl text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Pending Residents -->
        <div class="bg-white rounded-lg shadow border-l-4 border-yellow-500 h-full p-4 transform hover:-translate-y-1 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-yellow-500 uppercase mb-1">Pending Residents</div>
                    <div class="text-2xl font-bold text-gray-800"><?php echo e($stats['pending_residents']); ?></div>
                </div>
                <div>
                    <i class="fas fa-user-clock text-3xl text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Total Donations -->
        <div class="bg-white rounded-lg shadow border-l-4 border-green-500 h-full p-4 transform hover:-translate-y-1 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-green-500 uppercase mb-1">Total Donations</div>
                    <div class="text-2xl font-bold text-gray-800">₱<?php echo e(number_format($stats['total_donations']['cash'], 2)); ?></div>
                </div>
                <div>
                    <i class="fas fa-donate text-3xl text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Pending Requests -->
        <div class="bg-white rounded-lg shadow border-l-4 border-cyan-500 h-full p-4 transform hover:-translate-y-1 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-cyan-500 uppercase mb-1">Pending Requests</div>
                    <div class="text-2xl font-bold text-gray-800"><?php echo e($stats['pending_requests']); ?></div>
                </div>
                <div>
                    <i class="fas fa-tasks text-3xl text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Access Navigation Grid -->
    <h2 class="text-lg font-bold text-gray-800 mb-4">Quick Access</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
        <!-- Manage Residents -->
        <a href="<?php echo e(route('admin.residents.index')); ?>" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition-all hover:-translate-y-1 group">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-xl group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="ml-3 font-bold text-gray-800 text-lg">Residents</h3>
            </div>
            <p class="text-sm text-gray-500">Manage resident profiles, approvals, and verify identities.</p>
        </a>

        <!-- Create Resident -->
        <a href="<?php echo e(route('admin.residents.create')); ?>" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition-all hover:-translate-y-1 group">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h3 class="ml-3 font-bold text-gray-800 text-lg">Add Resident</h3>
            </div>
            <p class="text-sm text-gray-500">Register a new resident manually into the system.</p>
        </a>

        <!-- Donors -->
        <a href="<?php echo e(route('admin.donors.index')); ?>" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition-all hover:-translate-y-1 group">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-pink-100 text-pink-600 flex items-center justify-center text-xl group-hover:bg-pink-600 group-hover:text-white transition-colors">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <h3 class="ml-3 font-bold text-gray-800 text-lg">Donors</h3>
            </div>
            <p class="text-sm text-gray-500">View and manage donor information and history.</p>
        </a>

        <!-- Donations Management -->
        <a href="<?php echo e(route('admin.donations.index')); ?>" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition-all hover:-translate-y-1 group">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-green-100 text-green-600 flex items-center justify-center text-xl group-hover:bg-green-600 group-hover:text-white transition-colors">
                    <i class="fas fa-donate"></i>
                </div>
                <h3 class="ml-3 font-bold text-gray-800 text-lg">Donations</h3>
            </div>
            <p class="text-sm text-gray-500">Track incoming cash and in-kind donations.</p>
        </a>

        <!-- Relief Requests -->
        <a href="<?php echo e(route('admin.relief-requests.index')); ?>" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition-all hover:-translate-y-1 group">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center text-xl group-hover:bg-purple-600 group-hover:text-white transition-colors">
                    <i class="fas fa-hands-helping"></i>
                </div>
                <h3 class="ml-3 font-bold text-gray-800 text-lg">Relief Requests</h3>
            </div>
            <p class="text-sm text-gray-500">Process and fulfill assistance requests from residents.</p>
        </a>

        <!-- Inventory -->
        <a href="<?php echo e(route('admin.inventory.index')); ?>" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition-all hover:-translate-y-1 group">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center text-xl group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <i class="fas fa-boxes"></i>
                </div>
                <h3 class="ml-3 font-bold text-gray-800 text-lg">Inventory</h3>
            </div>
            <p class="text-sm text-gray-500">Monitor stock levels of relief goods and supplies.</p>
        </a>

        <!-- Distributions -->
        <a href="<?php echo e(route('admin.distributions.index')); ?>" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition-all hover:-translate-y-1 group">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-teal-100 text-teal-600 flex items-center justify-center text-xl group-hover:bg-teal-600 group-hover:text-white transition-colors">
                    <i class="fas fa-truck"></i>
                </div>
                <h3 class="ml-3 font-bold text-gray-800 text-lg">Distributions</h3>
            </div>
            <p class="text-sm text-gray-500">Manage distribution schedules and notifications.</p>
        </a>

        <!-- Reports -->
        <a href="<?php echo e(route('admin.reports.index')); ?>" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition-all hover:-translate-y-1 group">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-red-100 text-red-600 flex items-center justify-center text-xl group-hover:bg-red-600 group-hover:text-white transition-colors">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h3 class="ml-3 font-bold text-gray-800 text-lg">Reports</h3>
            </div>
            <p class="text-sm text-gray-500">Generate and download detailed system reports.</p>
        </a>

        <!-- Analytics -->
        <a href="<?php echo e(route('admin.analytics')); ?>" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition-all hover:-translate-y-1 group">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-cyan-100 text-cyan-600 flex items-center justify-center text-xl group-hover:bg-cyan-600 group-hover:text-white transition-colors">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="ml-3 font-bold text-gray-800 text-lg">Analytics</h3>
            </div>
            <p class="text-sm text-gray-500">Visual data insights and trends overview.</p>
        </a>

        <!-- Settings -->
        <a href="<?php echo e(route('admin.settings')); ?>" class="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition-all hover:-translate-y-1 group">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center text-xl group-hover:bg-gray-600 group-hover:text-white transition-colors">
                    <i class="fas fa-cog"></i>
                </div>
                <h3 class="ml-3 font-bold text-gray-800 text-lg">Settings</h3>
            </div>
            <p class="text-sm text-gray-500">Configure system preferences and accounts.</p>
        </a>
    </div>

    <!-- Content Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Donations -->
        <div class="bg-white shadow rounded-lg mb-4">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                <h6 class="m-0 font-bold text-blue-600">Recent Donations</h6>
                <a href="<?php echo e(route('admin.donations.index')); ?>" class="text-sm text-blue-500 hover:text-blue-700">View All</a>
            </div>
            <div class="p-4">
                <?php if(count($stats['recent_donations']) > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ref #</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donor</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__currentLoopData = $stats['recent_donations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900"><?php echo e($donation->reference_number ?? $donation->id); ?></td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-600"><?php echo e($donation->donor->name ?? 'Anonymous'); ?></td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <?php if($donation->type == 'cash'): ?>
                                                ₱<?php echo e(number_format($donation->amount, 2)); ?>

                                            <?php else: ?>
                                                In-Kind
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                <?php echo e($donation->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                   ($donation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800')); ?>">
                                                <?php echo e(ucfirst($donation->status)); ?>

                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 text-center py-4">No recent donations found.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pending Residents -->
        <div class="bg-white shadow rounded-lg mb-4">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                <h6 class="m-0 font-bold text-yellow-600">Pending Resident Verifications</h6>
                <a href="<?php echo e(route('admin.residents.index')); ?>" class="text-sm text-blue-500 hover:text-blue-700">View All</a>
            </div>
            <div class="p-4">
                <?php if(count($stats['pending_residents_list']) > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barangay</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__currentLoopData = $stats['pending_residents_list']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resident): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo e($resident->first_name); ?> <?php echo e($resident->last_name); ?></td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?php echo e($resident->barangay); ?></td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500"><?php echo e($resident->created_at->format('M d, Y')); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 text-center py-4">No pending resident verifications.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>