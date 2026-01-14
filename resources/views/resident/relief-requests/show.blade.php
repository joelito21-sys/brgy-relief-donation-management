@extends('layouts.resident')

@section('title', 'View Relief Request')
@section('page-title', 'Request Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Back Button -->
        <a href="{{ route('resident.relief-requests.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-indigo-600 mb-6 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Requests
        </a>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-bold text-gray-800">Request #{{ $reliefRequest->id }}</h2>
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                        {{ $reliefRequest->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $reliefRequest->status === 'approved' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $reliefRequest->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $reliefRequest->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                    ">
                        {{ $reliefRequest->status }}
                    </span>
                </div>
                <span class="text-sm text-gray-500">
                    <i class="far fa-clock mr-1"></i> {{ $reliefRequest->created_at->format('M d, Y h:i A') }}
                </span>
            </div>

            <div class="p-6 space-y-8">
                <!-- Status Timeline -->
                <div class="relative">
                    <div class="absolute left-0 top-1/2 w-full h-1 bg-gray-200 -z-10 transform -translate-y-1/2"></div>
                    <div class="flex justify-between">
                        <!-- Submitted -->
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white mb-2 shadow-md">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="text-xs font-bold text-indigo-700">Submitted</span>
                            <span class="text-[10px] text-gray-500">{{ $reliefRequest->created_at->format('M d') }}</span>
                        </div>

                        <!-- Reviewed -->
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full 
                                {{ in_array($reliefRequest->status, ['approved', 'completed', 'rejected']) ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-400' }} 
                                flex items-center justify-center mb-2 shadow-md transition-colors delay-75">
                                <i class="fas fa-search"></i>
                            </div>
                            <span class="text-xs font-bold {{ in_array($reliefRequest->status, ['approved', 'completed', 'rejected']) ? 'text-indigo-700' : 'text-gray-400' }}">Reviewed</span>
                        </div>

                        <!-- Completed -->
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full 
                                {{ $reliefRequest->status === 'completed' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-400' }} 
                                flex items-center justify-center mb-2 shadow-md transition-colors delay-150">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <span class="text-xs font-bold {{ $reliefRequest->status === 'completed' ? 'text-indigo-700' : 'text-gray-400' }}">Completed</span>
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user-circle text-indigo-500 mr-2"></i> Personal Details
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Full Name</span>
                            <p class="font-medium text-gray-900">{{ $reliefRequest->full_name }}</p>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Contact Number</span>
                            <p class="font-medium text-gray-900">{{ $reliefRequest->contact_number }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Address</span>
                            <p class="font-medium text-gray-900">{{ $reliefRequest->complete_address }}, {{ $reliefRequest->city_municipality }}, {{ $reliefRequest->province }}</p>
                        </div>
                    </div>
                </div>

                <!-- Request Details -->
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-indigo-500 mr-2"></i> Request Information
                    </h3>
                    <div class="bg-indigo-50 p-5 rounded-lg border border-indigo-100">
                        <div class="mb-4">
                            <span class="block text-xs font-semibold text-indigo-600 uppercase tracking-wider mb-1">Assistance Needed</span>
                            <div class="flex flex-wrap gap-2">
                                @if(is_array($reliefRequest->assistance_types))
                                    @foreach($reliefRequest->assistance_types as $type)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 border border-indigo-200">
                                            {{ ucfirst($type) }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-gray-500 italic">No specific types listed</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <span class="block text-xs font-semibold text-indigo-600 uppercase tracking-wider mb-1">Urgency Level</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $reliefRequest->urgency_level === 'high' ? 'bg-red-100 text-red-800 border border-red-200' : '' }}
                                {{ $reliefRequest->urgency_level === 'medium' ? 'bg-orange-100 text-orange-800 border border-orange-200' : '' }}
                                {{ $reliefRequest->urgency_level === 'low' ? 'bg-green-100 text-green-800 border border-green-200' : '' }}
                            ">
                                {{ ucfirst($reliefRequest->urgency_level) }} Priority
                            </span>
                        </div>

                        <div>
                            <span class="block text-xs font-semibold text-indigo-600 uppercase tracking-wider mb-1">Description / Reason</span>
                            <p class="text-gray-800 bg-white p-3 rounded border border-indigo-100 shadow-sm text-sm">
                                {{ $reliefRequest->description ?: 'No description provided.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Admin Response / Distribution Info -->
                @if($reliefRequest->status !== 'pending' && isset($reliefRequest->admin_response))
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-reply text-green-500 mr-2"></i> Admin Updates
                        </h3>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <p class="text-gray-700 italic">"{{ $reliefRequest->admin_response }}"</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Footer Actions -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                @if($reliefRequest->status === 'pending')
                    <a href="{{ route('resident.relief-requests.edit', $reliefRequest->id) }}" class="px-4 py-2 bg-white text-gray-700 font-medium rounded-lg border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm transition-colors">
                        Edit Request
                    </a>
                @endif
                <a href="{{ route('resident.relief-requests.index') }}" class="px-4 py-2 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-md transition-all transform hover:-translate-y-0.5">
                    Close
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
