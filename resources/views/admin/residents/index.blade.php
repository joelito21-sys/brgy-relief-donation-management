@extends('admin.layouts.app')

@section('title', 'Resident Management')

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="stat-card bg-gradient-to-r from-violet-500 to-violet-600 rounded-xl p-6 text-black">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-violet-100 text-sm">Total Residents</p>
               
                <p class="text-3xl font-bold mt-2 text-black">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white rounded-lg p-3">
                <i class="fas fa-users text-2xl text-black"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card bg-gradient-to-r from-amber-500 to-amber-600 rounded-xl p-6 text-black">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-amber-100 text-sm">Pending</p>
             
                <p class="text-3xl font-bold mt-2 text-black">{{ $stats['pending'] }}</p>
            </div>
            <div class="bg-white rounded-lg p-3">
                <i class="fas fa-clock text-2xl text-black"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-black">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm">Approved</p>
                
                <p class="text-3xl font-bold mt-2 text-black">{{ $stats['approved'] }}</p>
            </div>
            <div class="bg-white rounded-lg p-3">
                <i class="fas fa-check-circle text-2xl text-black"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card bg-gradient-to-r from-red-500 to-red-600 rounded-xl p-6 text-black">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-red-100 text-sm">Rejected</p>
              
                <p class="text-3xl font-bold mt-2 text-black">{{ $stats['rejected'] }}</p>
            </div>
            <div class="bg-black rounded-lg p-3">
                <i class="fas fa-times-circle text-2xl text-black"></i>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Card -->
<div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl border border-violet-200">
    <!-- Header with Search and Filter -->
    <div class="border-b border-gray-200 p-6" style="background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <h2 class="text-xl font-bold text-white">Resident Registrations</h2>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <form method="GET" action="{{ route('admin.residents.index') }}" class="flex gap-3">
                    <div class="relative">
                        <input type="text" name="search" 
                               class="pl-10 pr-4 py-2 border border-violet-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black" 
                               placeholder="Search residents..." 
                               value="{{ request('search') }}">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    
                    <select name="status" class="px-4 py-2 border border-violet-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    
                    <button type="submit" class="px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition-colors font-bold">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                </form>
                
                <a href="{{ route('admin.residents.create') }}" 
                   class="px-4 py-2 bg-gradient-to-r from-violet-600 to-violet-700 text-white rounded-lg hover:from-violet-700 hover:to-violet-800 transition-all transform hover:scale-105 shadow-lg font-bold flex items-center">
                    <i class="fas fa-plus mr-2"></i>Add New Resident
                </a>
            </div>
        </div>
    </div>

    <!-- Bulk Actions (hidden by default) -->
    @if($residents->count() > 0)
    <div class="hidden bulk-actions bg-amber-50 border border-amber-200 px-6 py-3" id="bulkActions">
        <div class="flex items-center justify-between">
            <span class="text-amber-800 font-bold">
                <span id="selectedCount">0</span> residents selected
            </span>
            <div class="flex gap-2">
                <button type="button" onclick="bulkApprove()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-bold">
                    <i class="fas fa-check mr-2"></i>Approve Selected
                </button>
                <button type="button" onclick="showBulkRejectModal()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-bold">
                    <i class="fas fa-times mr-2"></i>Reject Selected
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left">
                        <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-violet-600 focus:ring-violet-500">
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Name</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Address</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Registered</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($residents as $resident)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <input type="checkbox" name="resident_ids[]" value="{{ $resident->id }}" 
                               class="resident-checkbox rounded border-gray-300 text-violet-600 focus:ring-violet-500" 
                               {{ !$resident->isPending() ? 'disabled' : '' }}>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-violet-100 rounded-full flex items-center justify-center mr-3">
                                <span class="text-violet-600 font-medium text-sm">{{ substr($resident->first_name, 0, 1) }}{{ substr($resident->last_name, 0, 1) }}</span>
                            </div>
                            <div>
                                <a href="{{ route('admin.residents.show', $resident) }}" class="font-bold text-black hover:text-violet-600">
                                    {{ $resident->first_name }} {{ $resident->last_name }}
                                </a>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center text-black">
                            <i class="fas fa-envelope text-gray-400 mr-2 text-sm"></i>
                            {{ $resident->email }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center text-black">
                            <i class="fas fa-phone text-gray-400 mr-2 text-sm"></i>
                            {{ $resident->phone }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-black">
                            <i class="fas fa-map-marker-alt text-gray-400 mr-2 text-sm"></i>
                            {{ $resident->house_number }}, {{ $resident->address }}
                            @if($resident->subdivision) <br>({{ $resident->subdivision }}) @endif
                            <br>
                            {{ $resident->barangay }}, {{ $resident->city }}, {{ $resident->province }}, {{ $resident->country }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($resident->isPending())
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                <i class="fas fa-clock mr-1"></i>Pending
                            </span>
                        @elseif($resident->isApproved())
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>Approved
                            </span>
                        @elseif($resident->isRejected())
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-1"></i>Rejected
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-black">
                        {{ $resident->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.residents.show', $resident) }}" 
                               class="action-btn inline-flex items-center px-3 py-1.5 bg-violet-100 text-black rounded-lg hover:bg-violet-200 text-sm font-bold">
                                <i class="fas fa-eye mr-1"></i>View
                            </a>
                            
                            @if($resident->isPending())
                                <form method="POST" action="{{ route('admin.residents.approve', $resident) }}" class="inline" onsubmit="return confirm('Approve this resident?')">
                                    @csrf
                                    <button type="submit" class="action-btn inline-flex items-center px-3 py-1.5 bg-green-100 text-black rounded-lg hover:bg-green-200 text-sm font-bold">
                                        <i class="fas fa-check mr-1"></i>Approve
                                    </button>
                                </form>
                                <button type="button" onclick="showRejectModal({{ $resident->id }})" 
                                        class="action-btn inline-flex items-center px-3 py-1.5 bg-red-100 text-black rounded-lg hover:bg-red-200 text-sm font-bold">
                                    <i class="fas fa-times mr-1"></i>Reject
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
                            <p class="text-gray-500 text-lg font-bold">No residents found</p>
                            <p class="text-gray-400 text-sm font-bold">Try adjusting your search or filters</p>
                            <a href="{{ route('admin.residents.create') }}" class="mt-4 px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition-colors font-bold">
                                <i class="fas fa-plus mr-2"></i>Add First Resident
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($residents->count() > 0)
    <div class="border-t border-gray-200 px-6 py-4">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm text-black font-bold">
                Showing <span class="font-bold">{{ $residents->firstItem() }}</span> to 
                <span class="font-bold">{{ $residents->lastItem() }}</span> of 
                <span class="font-bold">{{ $residents->total() }}</span> entries
            </div>
            {{ $residents->links() }}
        </div>
    </div>
    @endif
</div>

<!-- Reject Modal -->
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50" id="rejectModal">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-black">Reject Resident Registration</h3>
                <button type="button" onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form method="POST" id="rejectForm">
                @csrf
                <div class="mb-4">
                    <label for="rejection_reason" class="block text-sm font-bold text-black mb-2">
                        Rejection Reason (Optional)
                    </label>
                    <textarea name="rejection_reason" id="rejection_reason" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black"
                              placeholder="Please provide a reason for rejection..."></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()" 
                            class="px-4 py-2 bg-gray-200 text-black rounded-lg hover:bg-gray-300 transition-colors font-bold">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-bold">
                        <i class="fas fa-times mr-2"></i>Reject Registration
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bulk Reject Modal -->
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50" id="bulkRejectModal">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-black">Bulk Reject Residents</h3>
                <button type="button" onclick="closeBulkRejectModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form method="POST" id="bulkRejectModalForm">
                @csrf
                <div class="mb-4">
                    <label for="bulk_rejection_reason" class="block text-sm font-bold text-black mb-2">
                        Rejection Reason (Optional)
                    </label>
                    <textarea name="rejection_reason" id="bulk_rejection_reason" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black"
                              placeholder="Please provide a reason for rejection..."></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeBulkRejectModal()" 
                            class="px-4 py-2 bg-gray-200 text-black rounded-lg hover:bg-gray-300 transition-colors font-bold">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-bold">
                        <i class="fas fa-times mr-2"></i>Reject Selected
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hidden forms for bulk actions -->
<form method="POST" action="{{ route('admin.residents.bulk.approve') }}" id="bulkApproveForm" class="hidden">
    @csrf
    <input type="hidden" name="resident_ids" id="bulkApproveIds">
</form>
<form method="POST" action="{{ route('admin.residents.bulk.reject') }}" id="bulkRejectForm" class="hidden">
    @csrf
    <input type="hidden" name="resident_ids" id="bulkRejectIds">
    <input type="hidden" name="rejection_reason" id="bulkRejectionReason">
</form>

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
        color: black !important;
    }
    
    .stat-card .text-violet-100,
    .stat-card .text-amber-100,
    .stat-card .text-green-100,
    .stat-card .text-red-100 {
        color: rgba(19, 17, 17, 0.8) !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkbox functionality
    const selectAll = document.getElementById('selectAll');
    const residentCheckboxes = document.querySelectorAll('.resident-checkbox:not(:disabled)');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    
    selectAll?.addEventListener('change', function() {
        residentCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActions();
    });
    
    residentCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });
    
    function updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('.resident-checkbox:checked');
        const count = checkedBoxes.length;
        
        if (count > 0) {
            bulkActions?.classList.remove('hidden');
            selectedCount.textContent = count;
        } else {
            bulkActions?.classList.add('hidden');
        }
    }
    
    // Bulk approve
    window.bulkApprove = function() {
        const checkedIds = Array.from(document.querySelectorAll('.resident-checkbox:checked')).map(cb => cb.value);
        document.getElementById('bulkApproveIds').value = checkedIds.join(',');
        if (confirm(`Approve ${checkedIds.length} resident(s)?`)) {
            document.getElementById('bulkApproveForm').submit();
        }
    };
    
    // Bulk reject
    window.showBulkRejectModal = function() {
        const checkedIds = Array.from(document.querySelectorAll('.resident-checkbox:checked')).map(cb => cb.value);
        document.getElementById('bulkRejectIds').value = checkedIds.join(',');
        document.getElementById('bulkRejectModal').classList.remove('hidden');
    };
    
    window.closeBulkRejectModal = function() {
        document.getElementById('bulkRejectModal').classList.add('hidden');
    };
    
    // Bulk reject form submission
    document.getElementById('bulkRejectModalForm')?.addEventListener('submit', function() {
        document.getElementById('bulkRejectionReason').value = document.getElementById('bulk_rejection_reason').value;
        document.getElementById('bulkRejectForm').submit();
    });
});

// Individual reject modal
window.showRejectModal = function(residentId) {
    const form = document.getElementById('rejectForm');
    form.action = `/admin/residents/${residentId}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
};

window.closeRejectModal = function() {
    document.getElementById('rejectModal').classList.add('hidden');
};
</script>
@endsection