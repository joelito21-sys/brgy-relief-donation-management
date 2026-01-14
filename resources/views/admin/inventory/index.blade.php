@extends('admin.layouts.app')

@section('title', 'Inventory Management')

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="stat-card bg-gradient-to-r from-violet-500 to-violet-600 rounded-xl p-6 text-black">
        <div class="flex items-center justify-between">
            <div>
                <p class="tex-black text-sm text-black">Total Items</p>
                <p class="text-3xl font-bold mt-2 text-black" >{{ $totalItems ?? 0 }}</p>
            </div>
            <div class="bg-black rounded-lg p-3">
                <i class="fas fa-boxes text-2xl"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-black">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-black text-sm text-black">In Stock Items</p>
                <p class="text-3xl font-bold mt-2 text-black" >{{ $items->where('quantity', '>', 0)->count() ?? 0 }}</p>
            </div>
            <div class="bg-black rounded-lg p-3">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card bg-gradient-to-r from-amber-500 to-amber-600 rounded-xl p-6 text-black">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-black text-sm text-black">Low Stock Items</p>
                <p class="text-3xl font-bold mt-2 text-black">{{ $lowStockItems->count() ?? 0 }}</p>
            </div>
            <div class="bg-black rounded-lg p-3">
                <i class="fas fa-exclamation-triangle text-2xl"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-black">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-black text-sm text-black">Total Value</p>
                <p class="text-3xl font-bold mt-2 text-black">₱{{ number_format($totalValue ?? 0) }}</p>
            </div>
            <div class="bg-black rounded-lg p-3">
                <i class="fas fa-dollar-sign text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Card -->
<div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl border border-violet-200">
    <!-- Header -->
    <div class="border-b border-gray-200 p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <h2 class="text-xl font-bold text-black">Inventory Items</h2>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative">
                    <input type="text" 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black" 
                           placeholder="Search items..." 
                           id="searchInput">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent text-black" id="categoryFilter">
                    <option value="">All Categories</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category }}">{{ $category }}</option>
                    @endforeach
                </select>
                
                <a href="{{ route('admin.inventory.create') }}" 
                   class="px-4 py-2 bg-gradient-to-r from-violet-600 to-violet-700 text-white rounded-lg hover:from-violet-700 hover:to-violet-800 transition-all transform hover:scale-105 shadow-lg font-bold">
                    <i class="fas fa-plus mr-2"></i>Add New Item
                </a>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full" id="inventoryTable">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Item</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Category</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Unit Price</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Total Value</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-black uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($items ?? [] as $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                @if($item->image)
                                    <img class="h-10 w-10 rounded-lg object-cover" 
                                         src="{{ Storage::url($item->image) }}" 
                                         alt="{{ $item->name }}">
                                @else
                                    <div class="h-10 w-10 rounded-lg bg-gradient-to-r from-violet-500 to-violet-600 flex items-center justify-center">
                                        <i class="fas fa-box text-white text-sm"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-black">{{ $item->name }}</div>
                                <div class="text-sm text-black">{{ $item->description ?? 'No description' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-violet-100 text-black">
                            {{ $item->category }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            @if($item->quantity <= 10)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-black">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    {{ $item->quantity }}
                                </span>
                            @elseif($item->quantity <= 50)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-black">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $item->quantity }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-black">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    {{ $item->quantity }}
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-black font-bold">₱{{ number_format($item->unit_price, 2) }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-black font-bold">₱{{ number_format($item->quantity * $item->unit_price, 2) }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.inventory.show', $item) }}" 
                               class="action-btn inline-flex items-center px-3 py-1.5 bg-violet-100 text-black rounded-lg hover:bg-violet-200 text-sm font-bold">
                                <i class="fas fa-eye mr-1"></i>View
                            </a>
                            
                            <a href="{{ route('admin.inventory.edit', $item) }}" 
                               class="action-btn inline-flex items-center px-3 py-1.5 bg-amber-100 text-black rounded-lg hover:bg-amber-200 text-sm font-bold">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                            
                            <form method="POST" action="{{ route('admin.inventory.destroy', $item) }}" class="inline" onsubmit="return confirm('Delete this item?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn inline-flex items-center px-3 py-1.5 bg-red-100 text-black rounded-lg hover:bg-red-200 text-sm font-bold">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-box-open text-gray-300 text-4xl mb-4"></i>
                            <p class="text-black text-lg font-bold">No inventory items found</p>
                            <p class="text-black text-sm">Add your first item to get started</p>
                            <a href="{{ route('admin.inventory.create') }}" class="mt-4 px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition-colors font-bold">
                                <i class="fas fa-plus mr-2"></i>Add First Item
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(isset($items) && $items->count() > 0)
    <div class="border-t border-gray-200 px-6 py-4">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm text-black font-bold">
                Showing <span class="font-bold">{{ $items->firstItem() }}</span> to 
                <span class="font-bold">{{ $items->lastItem() }}</span> of 
                <span class="font-bold">{{ $items->total() }}</span> entries
            </div>
            {{ $items->links() }}
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