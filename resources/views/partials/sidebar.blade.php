<!-- Modern Sidebar Navigation -->
<aside class="w-80 bg-white shadow-2xl border-r border-gray-200 fixed left-0 top-0 h-full z-30 transform transition-transform duration-300 ease-in-out" id="sidebar">
    <!-- Sidebar Header -->
    <div class="gradient-bg p-6 relative overflow-hidden">
        <div class="floating-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
        </div>
        <div class="relative z-10">
            <div class="flex items-center space-x-3">
                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-2">
                    <i class="fas fa-shield-alt text-white text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white">Admin Panel</h2>
                    <p class="text-white/80 text-sm">Barangay Cubacub Relief and Donation Management Program</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="p-4 space-y-2">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fas fa-tachometer-alt w-5"></i>
            <span class="font-medium">Dashboard</span>
        </a>

        <!-- Manage Residents -->
        <a href="{{ route('admin.residents.index') }}" 
           class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.residents.*') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fas fa-users w-5"></i>
            <span class="font-medium">Manage Residents</span>
        </a>

        <!-- Donor Management -->
        <a href="{{ route('admin.donors.index') }}" 
           class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.donors.*') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fas fa-hand-holding-heart w-5"></i>
            <span class="font-medium">Donor Management</span>
        </a>

        <!-- Relief Requests -->
        <a href="{{ route('admin.requests.index') }}" 
           class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.requests.*') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fas fa-hands-helping w-5"></i>
            <span class="font-medium">Relief Requests</span>
        </a>

        <!-- Donations -->
        <a href="{{ route('admin.donations.index') }}" 
           class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.donations.*') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fas fa-donate w-5"></i>
            <span class="font-medium">Donations</span>
        </a>

        <!-- Inventory -->
        <a href="{{ route('admin.inventory.index') }}" 
           class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.inventory.*') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fas fa-boxes w-5"></i>
            <span class="font-medium">Inventory</span>
        </a>

        <!-- Activities -->
        <a href="{{ route('admin.activities.index') }}" 
           class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.activities.*') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fas fa-calendar-alt w-5"></i>
            <span class="font-medium">Activities</span>
        </a>

        <!-- Reports -->
        <a href="{{ route('admin.reports.index') }}" 
           class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.reports.*') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fas fa-chart-bar w-5"></i>
            <span class="font-medium">Reports</span>
        </a>

        <!-- Settings -->
        <a href="{{ route('admin.settings.index') }}" 
           class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.settings.*') ? 'active' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fas fa-cog w-5"></i>
            <span class="font-medium">Settings</span>
        </a>
    </nav>

    <!-- Pending Residents Section -->
    <div class="p-4 border-t border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Pending Residents</h3>
            <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-xs font-bold">1</span>
        </div>
        
        <!-- View All Link -->
        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium mb-4 inline-flex items-center">
            <i class="fas fa-eye mr-2"></i>View All
        </a>

        <!-- Pending Resident Card -->
        <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-xl p-4 border border-orange-200 mb-4">
            <div class="flex items-start space-x-3">
                <div class="bg-orange-200 rounded-full p-2">
                    <i class="fas fa-user text-orange-600"></i>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-800">jojo serafin</h4>
                    <p class="text-sm text-gray-600">aadmin@gmail.com</p>
                    <p class="text-xs text-gray-500 mt-1">Nov 30, 2025</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 space-y-2">
                <button onclick="showRejectModal()" 
                        class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg transition-colors flex items-center justify-center">
                    <i class="fas fa-times-circle mr-2"></i>Reject Resident
                </button>
            </div>
        </div>
    </div>

    <!-- Logout Button -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200">
        <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
            @csrf
            <button type="submit" 
                    class="w-full flex items-center justify-center space-x-3 p-3 rounded-lg text-red-600 hover:bg-red-50 transition-colors">
                <i class="fas fa-sign-out-alt w-5"></i>
                <span class="font-medium">Logout</span>
            </button>
        </form>
    </div>
</aside>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4 transform transition-all">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-800">Reject Resident</h3>
            <button onclick="hideRejectModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <form id="rejectForm" onsubmit="submitRejection(event)">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Rejection Reason <span class="text-red-500">*</span>
                </label>
                <textarea name="rejection_reason" 
                          required
                          rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                          placeholder="Please provide a reason for rejection..."></textarea>
            </div>
            
            <div class="flex space-x-3">
                <button type="button" 
                        onclick="hideRejectModal()"
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-times mr-2"></i>Cancel
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    <i class="fas fa-check mr-2"></i>Reject
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Styles -->
<style>
    .gradient-bg {
        background: linear-gradient(135deg, #0284c7 0%, #3b82f6 50%, #8b5cf6 100%);
    }
    .sidebar-item {
        transition: all 0.3s ease;
    }
    .sidebar-item:hover {
        transform: translateX(4px);
    }
    .sidebar-item.active {
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        color: white;
    }
    .floating-shapes {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: -1;
    }
    .shape {
        position: absolute;
        border-radius: 50%;
        opacity: 0.1;
        animation: float 15s infinite linear;
    }
    .shape-1 {
        width: 200px;
        height: 200px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        top: 10%;
        left: 5%;
        animation-duration: 20s;
    }
    .shape-2 {
        width: 150px;
        height: 150px;
        background: linear-gradient(135deg, #10b981, #3b82f6);
        bottom: 15%;
        right: 10%;
        animation-duration: 25s;
        animation-delay: -5s;
    }
    @keyframes float {
        '0%, 100%': { transform: 'translateY(0)' },
        '50%': { transform: 'translateY(-10px)' },
    }
</style>

<!-- JavaScript -->
<script>
    function showRejectModal() {
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectModal').classList.add('flex');
    }

    function hideRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectModal').classList.remove('flex');
        document.getElementById('rejectForm').reset();
    }

    function submitRejection(event) {
        event.preventDefault();
        
        const formData = new FormData(event.target);
        const reason = formData.get('rejection_reason');
        
        // Show success message
        alert('Resident rejected successfully!\nReason: ' + reason);
        
        // Hide modal and reset form
        hideRejectModal();
        
        // Here you would typically make an AJAX call to your backend
        // fetch('/admin/residents/reject', { method: 'POST', body: formData })
    }

    // Close modal when clicking outside
    document.getElementById('rejectModal').addEventListener('click', function(event) {
        if (event.target === this) {
            hideRejectModal();
        }
    });
</script>
