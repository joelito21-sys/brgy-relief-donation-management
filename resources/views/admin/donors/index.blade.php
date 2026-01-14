@extends('admin.layouts.app')

@section('title', 'Donor Management')

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="stat-card bg-gradient-to-r from-violet-500 to-violet-600 rounded-xl p-6 text-black">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-black text-sm">Total Donors</p>
                <p class="text-3xl font-bold mt-2 text-black">{{ $stats['total'] ?? 0 }}</p>
            </div>
            <div class="bg-black rounded-lg p-3">
                <i class="fas fa-hand-holding-heart text-2xl"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-black">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-black text-sm">Active Donors</p>
                <p class="text-3xl font-bold mt-2 text-black">{{ $stats['active'] ?? 0 }}</p>
            </div>
            <div class="bg-black rounded-lg p-3">
                <i class="fas fa-user-check text-2xl"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card bg-gradient-to-r from-amber-500 to-amber-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-black text-sm text-black">Total Donations</p>
                <p class="text-3xl font-bold mt-2 text-black">{{ $stats['donations'] ?? 0 }}</p>
            </div>
            <div class="bg-white/20 rounded-lg p-3">
                <i class="fas fa-gift text-2xl"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-black">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-black text-sm text-black">This Month</p>
                <p class="text-3xl font-bold mt-2 text-black">{{ $stats['this_month'] ?? 0 }}</p>
            </div>
            <div class="bg-white/20 rounded-lg p-3">
                <i class="fas fa-calendar-alt text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Card -->
<div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl border border-violet-200">
    <!-- Header -->
    <div class="border-b border-gray-200 p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <h2 class="text-xl font-bold text-black">Donors List</h2>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative">
                    <input type="text" 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black" 
                           placeholder="Search donors..." 
                           id="searchInput">
                    <i class="fas fa-search absolute left-3 top-3 text-black"></i>
                </div>
                
                <a href="{{ route('admin.donors.create') }}" 
                   class="px-4 py-2 bg-gradient-to-r from-violet-600 to-violet-700 text-black rounded-lg hover:from-violet-700 hover:to-violet-800 transition-all transform hover:scale-105 shadow-lg font-bold">
                    <i class="fas fa-plus mr-2"></i>Add New Donor
                </a>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full" id="donorsTable">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">ID</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Name</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Donations</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($donors as $donor)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center justify-center w-8 h-8 bg-violet-100 text-black rounded-full text-sm font-bold">
                            {{ $donor->id }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                @if($donor->profile_photo_path)
                                    <img class="h-10 w-10 rounded-full object-cover" 
                                         src="{{ Storage::url($donor->profile_photo_path) }}" 
                                         alt="{{ $donor->name }}">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-violet-500 to-violet-600 flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">
                                            {{ strtoupper(substr($donor->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-black">{{ $donor->name }}</div>
                                <div class="text-sm text-black">Joined: {{ $donor->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center text-black">
                            <i class="fas fa-envelope text-gray-400 mr-2 text-sm"></i>
                            <span class="font-bold">{{ $donor->email }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center text-black">
                            <i class="fas fa-phone text-gray-400 mr-2 text-sm"></i>
                            <span class="font-bold">{{ $donor->phone ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-violet-100 text-black">
                                <i class="fas fa-gift mr-1"></i>
                                {{ $donor->donations_count ?? 0 }} Donations
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($donor->is_active)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-black">
                                <i class="fas fa-check-circle mr-1"></i>Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-black">
                                <i class="fas fa-times-circle mr-1"></i>Inactive
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.donors.show', $donor) }}" 
                               class="action-btn inline-flex items-center px-3 py-1.5 bg-violet-100 text-black rounded-lg hover:bg-violet-200 text-sm font-bold">
                                <i class="fas fa-eye mr-1"></i>View
                            </a>
                            
                            <form method="POST" action="{{ route('admin.donors.toggle-status', $donor) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="action-btn inline-flex items-center px-3 py-1.5 {{ $donor->is_active ? 'bg-red-100 text-black hover:bg-red-200' : 'bg-green-100 text-black hover:bg-green-200' }} rounded-lg text-sm font-bold">
                                    <i class="fas fa-{{ $donor->is_active ? 'ban' : 'check' }} mr-1"></i>
                                    {{ $donor->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-hand-holding-heart text-gray-300 text-4xl mb-4"></i>
                            <p class="text-black text-lg font-bold">No donors found</p>
                            <p class="text-black text-sm">Start by adding your first donor</p>
                            <a href="{{ route('admin.donors.create') }}" class="mt-4 px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition-colors font-bold">
                                <i class="fas fa-plus mr-2"></i>Add First Donor
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($donors->count() > 0)
    <div class="border-t border-gray-200 px-6 py-4">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm text-black font-bold">
                Showing <span class="font-bold">{{ $donors->firstItem() }}</span> to 
                <span class="font-bold">{{ $donors->lastItem() }}</span> of 
                <span class="font-bold">{{ $donors->total() }}</span> entries
            </div>
            
            <div class="flex items-center space-x-2">
                {{ $donors->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

<style>
    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 0.5rem;
        overflow: hidden;
        background:white;
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
    
    /* Make all text black */
    .text-gray-900, .text-gray-600, .text-gray-500 {
        color: black !important;
        font-weight: bold !important;
    }
    
    .text-sm, .text-xs {
        font-weight: bold !important;
    }
</style>
@endsection