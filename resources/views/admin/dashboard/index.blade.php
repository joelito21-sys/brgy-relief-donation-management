@extends('admin.layouts.app-new')

@section('title', 'Dashboard')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Home</a>
    <i class="fas fa-chevron-right text-xs"></i>
    <span>Dashboard</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Active Incidents -->
        <div class="stat-card">
            <div class="relative z-10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-sm font-medium opacity-90">Active Incidents</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $stats['active_incidents'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-white text-sm opacity-90">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>12% from last month</span>
                </div>
            </div>
        </div>

        <!-- Pending Requests -->
        <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
            <div class="relative z-10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-sm font-medium opacity-90">Pending Requests</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $stats['pending_requests'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-white text-sm opacity-90">
                    <i class="fas fa-arrow-down mr-1"></i>
                    <span>8% from last week</span>
                </div>
            </div>
        </div>

        <!-- Total Donors -->
        <div class="stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <div class="relative z-10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-sm font-medium opacity-90">Total Donors</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $stats['total_donors'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-white text-sm opacity-90">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>23% from last month</span>
                </div>
            </div>
        </div>

        <!-- Available Resources -->
        <div class="stat-card" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
            <div class="relative z-10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white text-sm font-medium opacity-90">Available Resources</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $stats['available_resources'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-box text-white text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-white text-sm opacity-90">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>5% from last week</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
                </div>
                <div class="p-6">
                    @forelse($recentActivities as $activity)
                        <div class="flex items-start space-x-3 p-4 hover:bg-gray-50 rounded-lg transition-colors">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-bell text-blue-600 text-sm"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">{{ $activity->description }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-gray-400 text-4xl mb-3"></i>
                            <p class="text-gray-500">No recent activity</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
            </div>
            <div class="p-6 space-y-3">
                <a href="{{ route('admin.relief-requests.index') }}" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <i class="fas fa-plus-circle text-blue-600 mr-3"></i>
                    <span class="text-sm font-medium text-blue-900">Review Relief Requests</span>
                </a>
                <a href="{{ route('admin.donations.index') }}" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <i class="fas fa-eye text-green-600 mr-3"></i>
                    <span class="text-sm font-medium text-green-900">View New Donations</span>
                </a>
                <a href="{{ route('admin.distributions.create') }}" class="flex items-center p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <i class="fas fa-truck text-purple-600 mr-3"></i>
                    <span class="text-sm font-medium text-purple-900">Schedule Distribution</span>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex items-center p-3 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                    <i class="fas fa-chart-bar text-orange-600 mr-3"></i>
                    <span class="text-sm font-medium text-orange-900">Generate Reports</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Donations and Relief Requests -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Resident Registrations -->
        <div class="card lg:col-span-2">
            <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Recent Residents Awaiting Review</h3>
                <a href="{{ route('admin.residents.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
            </div>
            <div class="p-6">
                @if(!empty($stats['recent_residents']) && $stats['recent_residents']->count())
                    <div class="space-y-3">
                        @foreach($stats['recent_residents'] as $resident)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $resident->first_name }} {{ $resident->last_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $resident->email }} • Registered {{ $resident->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <form method="POST" action="{{ route('admin.residents.approve', $resident) }}">
                                        @csrf
                                        <button class="text-xs px-3 py-1 rounded-full bg-green-100 text-green-800 hover:bg-green-200">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.residents.reject', $resident) }}">
                                        @csrf
                                        <button class="text-xs px-3 py-1 rounded-full bg-red-100 text-red-800 hover:bg-red-200">Reject</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-user-clock text-gray-400 text-4xl mb-3"></i>
                        <p class="text-gray-500">No recent resident registrations</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Donations -->
        <div class="card">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Donations</h3>
                    <a href="{{ route('admin.donations.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                </div>
            </div>
            <div class="p-6">
                @if(isset($stats['recent_donations']) && $stats['recent_donations']->count() > 0)
                    <div class="space-y-4">
                        @foreach($stats['recent_donations']->take(5) as $donation)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-donate text-green-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $donation->donor->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $donation->type }} - {{ $donation->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($donation->type === 'cash')
                                        <p class="text-sm font-semibold text-green-600">₱{{ number_format($donation->amount, 2) }}</p>
                                    @else
                                        <p class="text-sm font-semibold text-gray-600">{{ $donation->quantity }} {{ $donation->unit ?? 'items' }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-hand-holding-heart text-gray-400 text-4xl mb-3"></i>
                        <p class="text-gray-500">No recent donations</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Relief Requests -->
        <div class="card">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Relief Requests</h3>
                    <a href="{{ route('admin.relief-requests.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                </div>
            </div>
            <div class="p-6">
                @php
                    $recentRequests = \App\Models\ReliefRequest::with('user')->latest()->take(5)->get();
                @endphp
                @if($recentRequests->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentRequests as $request)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-hands-helping text-blue-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $request->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $request->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $request->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $request->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-clipboard-list text-gray-400 text-4xl mb-3"></i>
                        <p class="text-gray-500">No recent requests</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-refresh dashboard data every 30 seconds
    setInterval(() => {
        // You can add AJAX calls here to refresh specific dashboard data
        console.log('Refreshing dashboard data...');
    }, 30000);

    // Initialize tooltips and other interactive elements
    document.addEventListener('DOMContentLoaded', function() {
        // Add any dashboard-specific JavaScript here
    });
</script>
@endpush
