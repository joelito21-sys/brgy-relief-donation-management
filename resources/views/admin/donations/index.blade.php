@extends('admin.layouts.app')

@section('title', 'Donations Management')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Home</a>
    <i class="fas fa-chevron-right text-xs"></i>
    <a href="{{ route('admin.donations.index') }}">Donations</a>
    <i class="fas fa-chevron-right text-xs"></i>
    <span>Overview</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Donations Management</h1>
            <p class="mt-2 text-sm text-gray-600">Manage and review different types of donations</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.reports.index') }}" class="btn-primary">
                <i class="fas fa-download mr-2"></i>Export Report
            </a>
        </div>
    </div>

    <!-- Donation Type Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Cash Donations Card -->
        <a href="{{ route('admin.donations.type', 'cash') }}" class="group">
            <div class="card hover:shadow-lg transition-shadow duration-200 cursor-pointer">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-violet-100 rounded-lg group-hover:bg-violet-200 transition-colors">
                            <i class="fas fa-dollar-sign text-violet-600 text-xl"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-gray-900">
                                {{ $stats['cash']['total'] ?? 0 }}
                            </div>
                            <div class="text-sm text-gray-500">Total</div>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Cash Donations</h3>
                    <p class="text-sm text-gray-600 mb-4">Manage monetary donations and payment processing</p>
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center space-x-4">
                            <span class="text-green-600">
                                <i class="fas fa-check-circle mr-1"></i>
                                {{ $stats['cash']['approved'] ?? 0 }} Approved
                            </span>
                           
                        </div>
                        <i class="fas fa-arrow-right text-gray-400 group-hover:text-violet-600 transition-colors"></i>
                    </div>
                </div>
            </div>
        </a>

        <!-- Food Donations Card -->
        <a href="{{ route('admin.donations.type', 'food') }}" class="group">
            <div class="card hover:shadow-lg transition-shadow duration-200 cursor-pointer">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-orange-100 rounded-lg group-hover:bg-orange-200 transition-colors">
                            <i class="fas fa-utensils text-orange-600 text-xl"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-gray-900">
                                {{ $stats['food']['total'] ?? 0 }}
                            </div>
                            <div class="text-sm text-gray-500">Total</div>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Food Donations</h3>
                    <p class="text-sm text-gray-600 mb-4">Review and approve food item donations</p>
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center space-x-4">
                            <span class="text-green-600">
                                <i class="fas fa-check-circle mr-1"></i>
                                {{ $stats['food']['approved'] ?? 0 }} Approved
                            </span>
                            <span class="text-yellow-600">
                                <i class="fas fa-clock mr-1"></i>
                                {{ $stats['food']['pending'] ?? 0 }} Pending
                            </span>
                        </div>
                        <i class="fas fa-arrow-right text-gray-400 group-hover:text-orange-600 transition-colors"></i>
                    </div>
                </div>
            </div>
        </a>

        <!-- Clothing Donations Card -->
        <a href="{{ route('admin.donations.type', 'clothing') }}" class="group">
            <div class="card hover:shadow-lg transition-shadow duration-200 cursor-pointer">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-violet-100 rounded-lg group-hover:bg-violet-200 transition-colors">
                            <i class="fas fa-tshirt text-violet-600 text-xl"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-gray-900">
                                {{ $stats['clothing']['total'] ?? 0 }}
                            </div>
                            <div class="text-sm text-gray-500">Total</div>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Clothing Donations</h3>
                    <p class="text-sm text-gray-600 mb-4">Manage clothing and textile donations</p>
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center space-x-4">
                            <span class="text-green-600">
                                <i class="fas fa-check-circle mr-1"></i>
                                {{ $stats['clothing']['approved'] ?? 0 }} Approved
                            </span>
                            <span class="text-yellow-600">
                                <i class="fas fa-clock mr-1"></i>
                                {{ $stats['clothing']['pending'] ?? 0 }} Pending
                            </span>
                        </div>
                        <i class="fas fa-arrow-right text-gray-400 group-hover:text-violet-600 transition-colors"></i>
                    </div>
                </div>
            </div>
        </a>

        <!-- Medicine Donations Card -->
        <a href="{{ route('admin.donations.type', 'medicine') }}" class="group">
            <div class="card hover:shadow-lg transition-shadow duration-200 cursor-pointer">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-red-100 rounded-lg group-hover:bg-red-200 transition-colors">
                            <i class="fas fa-pills text-red-600 text-xl"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-gray-900">
                                {{ $stats['medicine']['total'] ?? 0 }}
                            </div>
                            <div class="text-sm text-gray-500">Total</div>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Medicine Donations</h3>
                    <p class="text-sm text-gray-600 mb-4">Review medical and pharmaceutical donations</p>
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center space-x-4">
                            <span class="text-green-600">
                                <i class="fas fa-check-circle mr-1"></i>
                                {{ $stats['medicine']['approved'] ?? 0 }} Approved
                            </span>
                            <span class="text-yellow-600">
                                <i class="fas fa-clock mr-1"></i>
                                {{ $stats['medicine']['pending'] ?? 0 }} Pending
                            </span>
                        </div>
                        <i class="fas fa-arrow-right text-gray-400 group-hover:text-red-600 transition-colors"></i>
                    </div>
                </div>
            </div>
        
        <!-- Walk-in Appointments Card -->
        <a href="{{ route('admin.donations.walkins') }}" class="group">
            <div class="card hover:shadow-lg transition-shadow duration-200 cursor-pointer">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors">
                            <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-gray-900">
                                {{ $stats['walkin']['total'] ?? 0 }}
                            </div>
                            <div class="text-sm text-gray-500">Total</div>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Walk-in Appts</h3>
                    <p class="text-sm text-gray-600 mb-4">Manage walk-in donation appointments</p>
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center space-x-4">
                            <span class="text-green-600">
                                <i class="fas fa-check-circle mr-1"></i>
                                {{ $stats['walkin']['approved'] ?? 0 }} Done
                            </span>
                            <span class="text-yellow-600">
                                <i class="fas fa-clock mr-1"></i>
                                {{ $stats['walkin']['pending'] ?? 0 }} Pending
                            </span>
                        </div>
                        <i class="fas fa-arrow-right text-gray-400 group-hover:text-blue-600 transition-colors"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Quick Stats Overview -->
    <div class="card">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Overview Statistics</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-gray-900">{{ array_sum(array_column($stats, 'total')) ?? 0 }}</div>
                    <div class="text-sm text-gray-500">Total Donations</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-600">{{ array_sum(array_column($stats, 'approved')) ?? 0 }}</div>
                    <div class="text-sm text-gray-500">Approved</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-600">{{ array_sum(array_column($stats, 'pending')) ?? 0 }}</div>
                    <div class="text-sm text-gray-500">Pending Review</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-violet-600">₱{{ number_format($stats['cash']['total_amount'] ?? 0, 2) }}</div>
                    <div class="text-sm text-gray-500">Total Cash Amount</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Recent Activity</h2>
                <a href="{{ route('admin.activities') }}" class="text-sm text-violet-600 hover:text-violet-800">
                    View All Activity
                </a>
            </div>
        </div>
        <div class="p-6">
            <div class="text-center py-8">
                <i class="fas fa-history text-gray-300 text-4xl mb-4"></i>
                <p class="text-gray-500">No recent activity data available</p>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }
    
    .card:hover {
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 700;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(139, 92, 246, 0.2);
    }
    
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(139, 92, 246, 0.3);
    }
</style>
@endsection