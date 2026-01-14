@extends('layouts.resident')

@section('title', 'Donations Received')
@section('page-title', 'Donations Received')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Donations Received</h2>
            <p class="text-gray-600 mt-1">Track the relief items and assistance you have received</p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-box text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Items Received</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_received_items'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-truck text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Distributions</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_distributions'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full">
                        <i class="fas fa-calendar text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Last Distribution</p>
                        <p class="text-lg font-bold text-gray-900">
                            {{ $stats['last_distribution'] ? $stats['last_distribution']->format('M d, Y') : 'None' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Distributions List -->
        <div class="space-y-6">
            @if($distributions->count() > 0)
                @foreach($distributions as $distribution)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Distribution #{{ $distribution->id }}</h3>
                                    <p class="text-sm text-gray-600">
                                        Distributed on: {{ $distribution->distributed_at->format('M d, Y h:i A') }}
                                    </p>
                                </div>
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Completed
                                </span>
                            </div>

                            @if($distribution->distributed_items && $distribution->distributed_items->count() > 0)
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-900 mb-3">Items Received:</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        @foreach($distribution->distributed_items as $item)
                                            <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                                    @if($item->category === 'food')
                                                        <i class="fas fa-utensils text-indigo-600"></i>
                                                    @elseif($item->category === 'clothing')
                                                        <i class="fas fa-tshirt text-indigo-600"></i>
                                                    @elseif($item->category === 'medicine')
                                                        <i class="fas fa-pills text-indigo-600"></i>
                                                    @else
                                                        <i class="fas fa-box text-indigo-600"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">{{ $item->name }}</p>
                                                    <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                                                    @if($item->expiry_date)
                                                        <p class="text-xs text-orange-600">Expires: {{ $item->expiry_date->format('M d, Y') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($distribution->notes)
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-900 mb-2">Distribution Notes:</h4>
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                        <p class="text-sm text-blue-800">{{ $distribution->notes }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($distribution->distributed_by)
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-900 mb-2">Distributed By:</h4>
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-gray-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $distribution->distributed_by }}</p>
                                            <p class="text-xs text-gray-500">Relief Worker</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    {{ $distribution->distribution_location ?? 'Evacuation Center' }}
                                </div>
                                <button class="inline-flex items-center px-3 py-1.5 border border-indigo-300 text-sm font-medium rounded text-indigo-700 bg-white hover:bg-indigo-50">
                                    <i class="fas fa-download mr-1"></i>
                                    Download Receipt
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                    <i class="fas fa-box-open text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Donations Received Yet</h3>
                    <p class="text-gray-600 mb-6">You haven't received any relief items yet. Your requests will appear here once they are approved and distributed.</p>
                    <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-plus mr-2"></i>
                        Submit Relief Request
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
