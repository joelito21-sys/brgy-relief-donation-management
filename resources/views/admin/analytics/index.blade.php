@extends('admin.layouts.app')

@section('title', 'Analytics Dashboard')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6" style="color: black;">Analytics Dashboard</h1>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6" style="border: 1px solid #8B5CF6;">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Residents</p>
                    <p class="text-2xl font-semibold text-gray-800" style="color: black; font-weight: bold;">
                        {{ isset($totalResidents) ? number_format($totalResidents) : '0' }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6" style="border: 1px solid #8B5CF6;">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-donate text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Donations</p>
                    <p class="text-2xl font-semibold text-gray-800" style="color: black; font-weight: bold;">
                        ₱{{ isset($totalDonations) ? number_format($totalDonations, 2) : '0.00' }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6" style="border: 1px solid #8B5CF6;">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-tasks text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Pending Requests</p>
                    <p class="text-2xl font-semibold text-gray-800" style="color: black; font-weight: bold;">
                        {{ isset($pendingRequests) ? number_format($pendingRequests) : '0' }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6" style="border: 1px solid #8B5CF6;">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-truck text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Completed Distributions</p>
                    <p class="text-2xl font-semibold text-gray-800" style="color: black; font-weight: bold;">
                        {{ isset($completedDistributions) ? number_format($completedDistributions) : '0' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Row 1 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Donations Over Time -->
        <div class="bg-white rounded-lg shadow p-6" style="border: 1px solid #8B5CF6;">
            <h3 class="text-lg font-medium mb-4" style="color: #8B5CF6; font-weight: bold;">Donations Over Time</h3>
            <canvas id="donationsChart" height="300"></canvas>
        </div>
        
        <!-- Requests by Status -->
        <div class="bg-white rounded-lg shadow p-6" style="border: 1px solid #8B5CF6;">
            <h3 class="text-lg font-medium mb-4" style="color: #8B5CF6; font-weight: bold;">Relief Requests by Status</h3>
            <canvas id="requestsChart" height="300"></canvas>
        </div>
    </div>
    
    <!-- Charts Row 2 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Donors -->
        <div class="bg-white rounded-lg shadow p-6" style="border: 1px solid #8B5CF6;">
            <h3 class="text-lg font-medium mb-4" style="color: #8B5CF6; font-weight: bold;">Top Donors</h3>
            <div class="space-y-4">
                @forelse($topDonors ?? [] as $donor)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-user text-gray-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900" style="color: black; font-weight: bold;">
                                    {{ $donor->donor->name ?? 'Anonymous' }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $donor->donor->email ?? '' }}
                                </p>
                            </div>
                        </div>
                        <span class="text-sm font-semibold text-indigo-600" style="color: #8B5CF6; font-weight: bold;">
                            ₱{{ number_format($donor->total_donated, 2) }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4" style="color: black; font-weight: bold;">No donation data available</p>
                @endforelse
            </div>
        </div>
        
        <!-- Recent Activities -->
        <div class="bg-white rounded-lg shadow p-6" style="border: 1px solid #8B5CF6;">
            <h3 class="text-lg font-medium mb-4" style="color: #8B5CF6; font-weight: bold;">Recent Activities</h3>
            <div class="space-y-4">
                @forelse($recentActivities ?? [] as $activity)
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-bell text-gray-500"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900" style="color: black; font-weight: bold;">
                                {{ $activity->description }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ isset($activity->created_at) ? \Carbon\Carbon::parse($activity->created_at)->diffForHumans() : '' }}
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4" style="color: black; font-weight: bold;">No recent activities</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
    .bg-white {
        background-color: white;
    }
    
    .rounded-lg {
        border-radius: 0.5rem;
    }
    
    .shadow {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .font-bold {
        font-weight: 700;
    }
</style>

@push('scripts')
<script>
    // Donations Over Time Chart
    const donationsCtx = document.getElementById('donationsChart').getContext('2d');
    new Chart(donationsCtx, {
        type: 'line',
        data: {
            labels: @json($months ?? []),
            datasets: [{
                label: 'Donations (₱)',
                data: @json($donationsData ?? []),
                borderColor: 'rgb(139, 92, 246)',
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₱' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Requests by Status Chart
    const requestsCtx = document.getElementById('requestsChart').getContext('2d');
    new Chart(requestsCtx, {
        type: 'doughnut',
        data: {
            labels: @json(($requestsByStatus ?? collect())->keys()->map(fn($status) => ucfirst($status))->toArray()),
            datasets: [{
                data: @json(($requestsByStatus ?? collect())->values()->toArray()),
                backgroundColor: [
                    'rgba(139, 92, 246, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(156, 163, 175, 0.8)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                }
            }
        }
    });
</script>
@endpush
@endsection