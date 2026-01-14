@extends('donor.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Recent Activities</h2>
                
                @if($activities->count() > 0)
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @foreach($activities as $activity)
                                <li class="relative pb-8">
                                    @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            @php
                                                $iconClasses = [
                                                    'donation_received' => 'bg-green-500',
                                                    'donation_processed' => 'bg-blue-500',
                                                    'donation_delivered' => 'bg-purple-500',
                                                    'donation_used' => 'bg-indigo-500',
                                                    'default' => 'bg-gray-400'
                                                ];
                                                $iconClass = $iconClasses[$activity->type] ?? $iconClasses['default'];
                                                
                                                $icons = [
                                                    'donation_received' => 'fa-box-open',
                                                    'donation_processed' => 'fa-cog',
                                                    'donation_delivered' => 'fa-truck',
                                                    'donation_used' => 'fa-hands-helping',
                                                    'default' => 'fa-info-circle'
                                                ];
                                                $icon = $icons[$activity->type] ?? $icons['default'];
                                            @endphp
                                            <span class="h-8 w-8 rounded-full {{ $iconClass }} flex items-center justify-center ring-8 ring-white">
                                                <i class="fas {{ $icon }} text-white text-sm"></i>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">
                                                    {!! $activity->description !!}
                                                    <span class="font-medium text-gray-900">{{ $activity->donation->type }} donation</span>
                                                </p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <time datetime="{{ $activity->created_at->toIso8601String() }}">
                                                    {{ $activity->created_at->diffForHumans() }}
                                                </time>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">No activities yet</h3>
                        <p class="text-gray-500">Your donation activities will appear here.</p>
                        <div class="mt-6">
                            <a href="{{ route('donor.donate.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fas fa-plus mr-2"></i> Make a Donation
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
