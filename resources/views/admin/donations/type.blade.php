@extends('admin.layouts.app')

@section('title', ucfirst($type) . ' Donations Management')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Home</a>
    <i class="fas fa-chevron-right text-xs"></i>
    <a href="{{ route('admin.donations.index') }}">Donations</a>
    <i class="fas fa-chevron-right text-xs"></i>
    <span>{{ ucfirst($type) }} Donations</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ ucfirst($type) }} Donations</h1>
            <p class="mt-2 text-sm text-gray-600">Manage {{ $type }} donations and review submissions</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.donations.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>Back to Overview
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @if($type === 'cash')
            <div class="card p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-dollar-sign text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Cash Amount</p>
                        <p class="text-2xl font-bold text-gray-900">₱{{ number_format($donations->sum('amount'), 2) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="card p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-list text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Transactions</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $donations->total() }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="card p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-list text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $donations->total() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="card p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pending</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $pendingDonations->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="card p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Approved</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $approvedDonations->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="card p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-red-100 rounded-lg">
                        <i class="fas fa-times-circle text-red-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Rejected</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $rejectedDonations->count() }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Cash Donations (All Auto-Approved) -->
    @if($type === 'cash' && $donations->count() > 0)
        <div class="card">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg mr-3">
                            <i class="fas fa-dollar-sign text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Cash Donations</h3>
                            <p class="text-sm text-gray-600">All cash donations are automatically approved</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                        {{ $donations->count() }} transactions
                    </span>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($donations as $donation)
                        <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-dollar-sign text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $donation->donor_name }}</p>
                                        <p class="text-sm text-gray-600">{{ $donation->donor_email }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $donation->created_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-blue-600">₱{{ number_format($donation->amount, 2) }}</p>
                                    <div class="mt-1">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Auto-approved
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-white rounded-lg p-3">
                                <p class="text-sm text-gray-700"><strong>Payment Method:</strong> {{ $donation->payment_method ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-700"><strong>Reference:</strong> {{ $donation->reference_number ?? 'N/A' }}</p>
                                @if($donation->message)
                                    <p class="text-sm text-gray-700"><strong>Message:</strong> {{ $donation->message }}</p>
                                @endif
                            </div>

                            <div class="mt-3">
                                <a href="{{ route('admin.donations.show', $donation) }}" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-center">
                                    <i class="fas fa-eye mr-2"></i>View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Pending Donations (Non-Cash Only) -->
    @if($type !== 'cash' && $pendingDonations->count() > 0)
        <div class="card">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-100 rounded-lg mr-3">
                            <i class="fas fa-clock text-yellow-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Pending {{ ucfirst($type) }} Donations</h3>
                            <p class="text-sm text-gray-600">Awaiting review and approval</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                        {{ $pendingDonations->count() }} pending
                    </span>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($pendingDonations as $donation)
                        <div class="p-4 bg-white rounded-lg border border-gray-200">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-{{ $type === 'cash' ? 'dollar-sign' : ($type === 'food' ? 'utensils' : ($type === 'clothing' ? 'tshirt' : 'pills')) }} text-yellow-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $donation->donor_name }}</p>
                                        <p class="text-sm text-gray-600">{{ $donation->donor_email }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $donation->created_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($type === 'cash')
                                        <p class="text-lg font-bold text-gray-900">₱{{ number_format($donation->amount, 2) }}</p>
                                    @else
                                        <p class="text-lg font-bold text-gray-900">{{ $donation->quantity ?? 0 }} {{ $type === 'food' ? 'items' : ($type === 'clothing' ? 'pieces' : 'units') }}</p>
                                    @endif
                                    <div class="mt-1">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-3 mb-3">
                                @if($type === 'cash')
                                    <p class="text-sm text-gray-700"><strong>Payment Method:</strong> {{ $donation->payment_method ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-700"><strong>Reference:</strong> {{ $donation->reference_number ?? 'N/A' }}</p>
                                @elseif($type === 'food')
                                    @php
                                        $foodItems = json_decode($donation->food_type, true) ?? [];
                                    @endphp
                                    @if(!empty($foodItems))
                                        @foreach($foodItems as $item)
                                            <p class="text-sm text-gray-700"><strong>Food Type:</strong> {{ ucfirst(str_replace('_', ' ', $item['type'] ?? 'N/A')) }}</p>
                                            <p class="text-sm text-gray-700"><strong>Quantity:</strong> {{ $item['quantity'] ?? 'N/A' }} {{ $item['unit'] ?? 'items' }}</p>
                                            @break
                                        @endforeach
                                    @else
                                        <p class="text-sm text-gray-700"><strong>Details:</strong> N/A</p>
                                    @endif
                                @elseif($type === 'clothing')
                                    @php
                                        $clothingItems = json_decode($donation->clothing_types, true) ?? [];
                                    @endphp
                                    @if(!empty($clothingItems))
                                        @foreach($clothingItems as $item)
                                            <p class="text-sm text-gray-700"><strong>Type:</strong> {{ ucfirst(str_replace('_', ' ', $item['type'] ?? 'N/A')) }}</p>
                                            <p class="text-sm text-gray-700"><strong>Quantity:</strong> {{ $item['quantity'] ?? 'N/A' }}</p>
                                            <p class="text-sm text-gray-700"><strong>Condition:</strong> {{ ucfirst(str_replace('_', ' ', $item['condition'] ?? 'N/A')) }}</p>
                                            @break
                                        @endforeach
                                    @else
                                        <p class="text-sm text-gray-700"><strong>Details:</strong> N/A</p>
                                    @endif
                                @elseif($type === 'medicine')
                                    @php
                                        $medicineDetails = json_decode($donation->medicine_type, true) ?? [];
                                    @endphp
                                    @if(!empty($medicineDetails))
                                        <p class="text-sm text-gray-700"><strong>Medicine:</strong> {{ $medicineDetails['name'] ?? 'N/A' }}</p>
                                        <p class="text-sm text-gray-700"><strong>Quantity:</strong> {{ $medicineDetails['quantity'] ?? 'N/A' }}</p>
                                        <p class="text-sm text-gray-700"><strong>Condition:</strong> {{ ucfirst($medicineDetails['condition'] ?? 'N/A') }}</p>
                                    @else
                                        <p class="text-sm text-gray-700"><strong>Details:</strong> N/A</p>
                                    @endif
                                @endif
                            </div>

                            <div class="flex gap-2">
                                @if($type === 'cash')
                                    <!-- Cash donations are auto-approved, show view details button only -->
                                    <a href="{{ route('admin.donations.show', $donation) }}" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-center">
                                        <i class="fas fa-eye mr-2"></i>View Details
                                    </a>
                                @else
                                    <!-- Other donation types need approval -->
                                    <a href="{{ route('admin.donations.show', $donation) }}" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors text-center">
                                        <i class="fas fa-search mr-2"></i>Review Details
                                    </a>
                                    <form method="POST" action="{{ route('admin.donations.accept', $donation) }}" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                            <i class="fas fa-check mr-2"></i>Accept
                                        </button>
                                    </form>
                                    <button onclick="showRejectModal({{ $donation->id }})" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                        <i class="fas fa-times mr-2"></i>Reject
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Approved Donations (Non-Cash Only) -->
    @if($type !== 'cash' && $approvedDonations->count() > 0)
        <div class="card">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg mr-3">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Approved {{ ucfirst($type) }} Donations</h3>
                            <p class="text-sm text-gray-600">Ready for processing</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                        {{ $approvedDonations->count() }} approved
                    </span>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($approvedDonations as $donation)
                        <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-{{ $type === 'cash' ? 'dollar-sign' : ($type === 'food' ? 'utensils' : ($type === 'clothing' ? 'tshirt' : 'pills')) }} text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $donation->donor_name }}</p>
                                        <p class="text-sm text-gray-600">{{ $donation->donor_email }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $donation->created_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($type === 'cash')
                                        <p class="text-lg font-bold text-gray-900">₱{{ number_format($donation->amount, 2) }}</p>
                                    @else
                                        <p class="text-lg font-bold text-gray-900">{{ $donation->quantity ?? 0 }} {{ $type === 'food' ? 'items' : ($type === 'clothing' ? 'pieces' : 'units') }}</p>
                                    @endif
                                    <div class="mt-1">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Approved
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-white rounded-lg p-3">
                                @if($type === 'cash')
                                    <p class="text-sm text-gray-700"><strong>Payment Method:</strong> {{ $donation->payment_method ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-700"><strong>Reference:</strong> {{ $donation->reference_number ?? 'N/A' }}</p>
                                @else
                                    <p class="text-sm text-gray-700"><strong>Delivery Method:</strong> {{ ucfirst($donation->delivery_method ?? 'N/A') }}</p>
                                    @if($donation->pickup_date)
                                        <p class="text-sm text-gray-700"><strong>Pickup Date:</strong> {{ $donation->pickup_date->format('M d, Y') }}</p>
                                    @endif
                                @endif
                            </div>

                            <div class="mt-3 flex gap-2">
                                <a href="{{ route('admin.donations.show', $donation) }}" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-center">
                                    <i class="fas fa-eye mr-2"></i>View Details
                                </a>
                                @if($type !== 'cash')
                                    <form method="POST" action="{{ route('admin.donations.updateStatus', $donation) }}" class="flex-1">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors" onclick="return confirm('Mark this donation as completed? This will update the donor dashboard.')">
                                            <i class="fas fa-check-circle mr-2"></i>Mark Complete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Rejected Donations (Non-Cash Only) -->
    @if($type !== 'cash' && $rejectedDonations->count() > 0)
        <div class="card">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="p-2 bg-red-100 rounded-lg mr-3">
                            <i class="fas fa-times-circle text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Rejected {{ ucfirst($type) }} Donations</h3>
                            <p class="text-sm text-gray-600">Not approved</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                        {{ $rejectedDonations->count() }} rejected
                    </span>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($rejectedDonations as $donation)
                        <div class="p-4 bg-red-50 rounded-lg border border-red-200">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-{{ $type === 'cash' ? 'dollar-sign' : ($type === 'food' ? 'utensils' : ($type === 'clothing' ? 'tshirt' : 'pills')) }} text-red-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $donation->donor_name }}</p>
                                        <p class="text-sm text-gray-600">{{ $donation->donor_email }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $donation->created_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($type === 'cash')
                                        <p class="text-lg font-bold text-gray-900">₱{{ number_format($donation->amount, 2) }}</p>
                                    @else
                                        <p class="text-lg font-bold text-gray-900">{{ $donation->quantity ?? 0 }} {{ $type === 'food' ? 'items' : ($type === 'clothing' ? 'pieces' : 'units') }}</p>
                                    @endif
                                    <div class="mt-1">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Rejected
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-white rounded-lg p-3">
                                @if($donation->admin_notes)
                                    <p class="text-sm text-gray-700"><strong>Reason:</strong> {{ $donation->admin_notes }}</p>
                                @endif
                                <p class="text-sm text-gray-700"><strong>Rejected on:</strong> {{ $donation->updated_at->format('M d, Y h:i A') }}</p>
                            </div>

                            <div class="mt-3">
                                <a href="{{ route('admin.donations.show', $donation) }}" class="w-full px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-center">
                                    <i class="fas fa-eye mr-2"></i>View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Completed Donations (Non-Cash Only) -->
    @if($type !== 'cash' && $completedDonations->count() > 0)
        <div class="card">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg mr-3">
                            <i class="fas fa-check-double text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Completed {{ ucfirst($type) }} Donations</h3>
                            <p class="text-sm text-gray-600">Successfully distributed</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                        {{ $completedDonations->count() }} completed
                    </span>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($completedDonations as $donation)
                        <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-{{ $type === 'cash' ? 'dollar-sign' : ($type === 'food' ? 'utensils' : ($type === 'clothing' ? 'tshirt' : 'pills')) }} text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $donation->donor_name }}</p>
                                        <p class="text-sm text-gray-600">{{ $donation->donor_email }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $donation->created_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($type === 'cash')
                                        <p class="text-lg font-bold text-gray-900">₱{{ number_format($donation->amount, 2) }}</p>
                                    @else
                                        <p class="text-lg font-bold text-gray-900">{{ $donation->quantity ?? 0 }} {{ $type === 'food' ? 'items' : ($type === 'clothing' ? 'pieces' : 'units') }}</p>
                                    @endif
                                    <div class="mt-1">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Completed
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-white rounded-lg p-3">
                                @if($type === 'cash')
                                    <p class="text-sm text-gray-700"><strong>Payment Method:</strong> {{ $donation->payment_method ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-700"><strong>Reference:</strong> {{ $donation->reference_number ?? 'N/A' }}</p>
                                @else
                                    <p class="text-sm text-gray-700"><strong>Delivery Method:</strong> {{ ucfirst($donation->delivery_method ?? 'N/A') }}</p>
                                    @if($donation->pickup_date)
                                        <p class="text-sm text-gray-700"><strong>Pickup Date:</strong> {{ $donation->pickup_date->format('M d, Y') }}</p>
                                    @endif
                                @endif
                            </div>

                            <div class="mt-3 flex gap-2">
                                <a href="{{ route('admin.donations.show', $donation) }}" class="w-full px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-center">
                                    <i class="fas fa-eye mr-2"></i>View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Pagination -->
    @if($donations->hasPages())
        <div class="flex justify-center">
            {{ $donations->links() }}
        </div>
    @endif
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Reject Donation</h3>
            <form id="rejectForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">Reason for rejection</label>
                    <textarea id="admin_notes" name="admin_notes" rows="3" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Please provide a reason for rejection..."></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                        Reject
                    </button>
                    <button type="button" onclick="closeRejectModal()" class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showRejectModal(donationId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = `/admin/donations/${donationId}/reject`;
    modal.classList.remove('hidden');
}

function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.classList.add('hidden');
}
</script>
@endsection
