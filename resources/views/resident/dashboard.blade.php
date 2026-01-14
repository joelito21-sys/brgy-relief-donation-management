@extends('layouts.resident')

@section('title', 'Resident Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Welcome Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">Welcome, {{ $resident->first_name }} {{ $resident->last_name }}!</h1>
                    <p class="text-indigo-100 mt-2">Your flood relief assistance dashboard</p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-indigo-100">Current Status</div>
                    <div class="text-xl font-semibold text-white">
                        @if($evacuationStatus === false)
                            🏠 At Home
                        @else
                            🚨 Evacuated
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Evacuation Alert -->
        <div class="mb-8">
            <div class="{{ $evacuationStatus === false ? 'bg-green-50 border-green-200' : 'bg-yellow-50 border-yellow-200' }} border-l-4 p-4 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas {{ $evacuationStatus === false ? 'fa-home text-green-400' : 'fa-exclamation-triangle text-yellow-400' }} text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-medium {{ $evacuationStatus === false ? 'text-green-800' : 'text-yellow-800' }}">
                            {{ $evacuationStatus === false ? 'Safety Status' : 'Evacuation Notice' }}
                        </h3>
                        <div class="mt-2 text-sm {{ $evacuationStatus === false ? 'text-green-700' : 'text-yellow-700' }}">
                            <p>{{ $evacuationInfo['message'] }}</p>
                            <p class="mt-1">{{ $evacuationInfo['action'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Distribution Notifications -->
        <div class="mb-8">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Upcoming Distributions</h2>
                    <span class="text-sm text-gray-400">View All</span>
                </div>
                <div class="p-6">
                    @php
                        // Fetch all notifications without strict filtering first
                        $allNotifications = \App\Models\DistributionNotification::all();
                        
                        // More inclusive query to display notifications
                        $upcomingNotifications = \App\Models\DistributionNotification::where('scheduled_date', '>', now())
                            ->where(function($query) use ($resident) {
                                // Include all general notifications regardless of targeting
                                $query->where('distribution_type', 'general')
                                    // Include specific notifications for this resident
                                    ->orWhere(function($subQuery) use ($resident) {
                                        $subQuery->where('distribution_type', 'specific')
                                            ->whereHas('reliefRequest', function($reliefQuery) use ($resident) {
                                                $reliefQuery->where('user_id', $resident->user_id);
                                            });
                                    })
                                    // Include notifications with no type specified
                                    ->orWhereNull('distribution_type');
                            })
                            ->orderBy('scheduled_date', 'asc')
                            ->take(5)
                            ->get();
                    @endphp
                    
                    @if($upcomingNotifications->count() > 0)
                        <div class="space-y-4">
                            @foreach($upcomingNotifications as $notification)
                                <div class="border-l-4 border-indigo-500 bg-indigo-50 p-4 rounded">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h3 class="font-medium text-indigo-900">{{ $notification->title }}</h3>
                                            <p class="text-sm text-indigo-700 mt-1">{{ $notification->message }}</p>
                                            <div class="mt-2 text-sm text-indigo-600">
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                {{ $notification->formatted_scheduled_date }}
                                            </div>
                                            <div class="mt-1 text-sm text-indigo-600">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                {{ $notification->location }}
                                            </div>
                                            @if($notification->additional_info)
                                                <div class="mt-2 text-sm text-indigo-600">
                                                    <i class="fas fa-info-circle mr-1"></i>
                                                    {{ $notification->additional_info }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                {{ ucfirst($notification->distribution_type ?? 'general') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-bell-slash text-gray-300 text-4xl mb-4"></i>
                            <p class="text-gray-500">No upcoming distributions scheduled</p>
                            <p class="text-sm text-gray-400 mt-2">Check back later for new distribution announcements</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-clipboard-list text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Requests</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_requests'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pending</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_requests'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Completed</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['completed_requests'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full">
                        <i class="fas fa-box text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Items Received</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_received_items'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Relief Requests -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Recent Relief Requests</h2>
                    </div>
                    <div class="p-6">
                        @if($reliefRequests->count() > 0)
                            <div class="space-y-4">
                                @foreach($reliefRequests as $request)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <h3 class="font-medium text-gray-900">Request #{{ $request->id }}</h3>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($request->status === 'approved' ? 'bg-blue-100 text-blue-800' : 
                                                   ($request->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                                                {{ ucfirst($request->status) }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-2">
                                            {{ $request->created_at->format('M d, Y h:i A') }}
                                        </p>
                                        @if($request->items && $request->items->count() > 0)
                                            <div class="text-sm text-gray-700">
                                                <strong>Items requested:</strong>
                                                <ul class="mt-1 ml-4 list-disc">
                                                    @foreach($request->items->take(3) as $item)
                                                        <li>{{ $item->name }} ({{ $item->quantity }})</li>
                                                    @endforeach
                                                    @if($request->items->count() > 3)
                                                        <li>... and {{ $request->items->count() - 3 }} more</li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="mt-3">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                                View Details →
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-clipboard-list text-gray-300 text-4xl mb-4"></i>
                                <p class="text-gray-500">No relief requests yet</p>
                                <a href="#" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    <i class="fas fa-plus mr-2"></i>Create New Request
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Recent Activity</h2>
                    </div>
                    <div class="p-6">
                        @if($recentActivities->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentActivities as $activity)
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-{{ $activity['color'] }}-100 rounded-full flex items-center justify-center">
                                                <i class="{{ $activity['icon'] }} text-{{ $activity['color'] }}-600 text-xs"></i>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $activity['title'] }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ $activity['description'] }}
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">
                                                {{ $activity['date']->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-history text-gray-300 text-4xl mb-4"></i>
                                <p class="text-gray-500">No recent activity</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-plus text-indigo-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-900">New Relief Request</h3>
                                <p class="text-sm text-gray-500">Request assistance</p>
                            </div>
                        </a>

                        <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-edit text-green-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-900">Update Profile</h3>
                                <p class="text-sm text-gray-500">Edit your information</p>
                            </div>
                        </a>

                        <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-phone text-purple-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-900">Emergency Contact</h3>
                                <p class="text-sm text-gray-500">Get help now</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
