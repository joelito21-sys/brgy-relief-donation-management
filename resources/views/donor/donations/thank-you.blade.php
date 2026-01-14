@extends('layouts.donor')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <!-- Success Message -->
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    @if($donation->type === 'cash')
                        @if($donation->payment_method === 'walkin')
                            <!-- Walk-in Specific Message -->
                            <h2 class="mt-3 text-2xl font-bold text-gray-900">Appointment Scheduled!</h2>
                            <p class="mt-2 text-gray-600">Thank you for scheduling your visit. We look forward to seeing you.</p>
                            <p class="mt-2 text-gray-600">A confirmation email has been sent to {{ $donation->donor_email }}.</p>
                        @else
                            <!-- Regular Cash Donation Message -->
                            <h2 class="mt-3 text-2xl font-bold text-gray-900">Thank You for Your Donation!</h2>
                            <p class="mt-2 text-gray-600">Your generous cash donation of <span class="font-semibold">₱{{ number_format($donation->amount, 2) }}</span> has been received.</p>
                            
                            @if($donation->payment_method === 'bank_transfer')
                                <p class="mt-2 text-gray-600">We'll verify your bank transfer and update the status of your donation shortly.</p>
                            @else
                                <p class="mt-2 text-gray-600">We'll process your donation and send you a confirmation email soon.</p>
                            @endif
                        @endif
                    @else
                        <h2 class="mt-3 text-2xl font-bold text-gray-900">Thank You for Your Donation!</h2>
                        <p class="mt-2 text-gray-600">Your generous {{ ucfirst($donation->type) }} donation has been review by admin.</p>
                        <p class="mt-2 text-gray-600">Your donation is now <strong>pending waiting for admin review</strong>. We'll review your donation details and send you a confirmation email once approved.</p>
                    @endif
                    
                    <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900">
                            {{ $donation->payment_method === 'walkin' ? 'Appointment Details' : 'Donation Details' }}
                        </h3>
                        <dl class="mt-2 space-y-2">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Reference Number</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $donation->reference_number ?? 'N/A' }}</dd>
                            </div>
                            
                            @if($donation->payment_method === 'walkin')
                                <!-- Walk-in Specific Details -->
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Appointment Date</dt>
                                    <dd class="text-sm font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($donation->payment_details['appointment_date'] ?? $donation->details['appointment_date'])->format('M d, Y') }}
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Time</dt>
                                    <dd class="text-sm font-medium text-gray-900">
                                        {{ $donation->payment_details['appointment_time'] ?? $donation->details['appointment_time'] }}
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Purpose</dt>
                                    <dd class="text-sm font-medium text-gray-900 capitalize">
                                        {{ str_replace('_', ' ', $donation->payment_details['appointment_type'] ?? $donation->details['appointment_type']) }}
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Location</dt>
                                    <dd class="text-sm font-medium text-gray-900">Barangay Hall</dd>
                                </div>
                            @endif

                            @if($donation->payment_method !== 'walkin')
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Donation Type</dt>
                                    <dd class="text-sm font-medium text-gray-900 capitalize">{{ $donation->type }}</dd>
                                </div>
                                
                                @if($donation->type === 'cash')
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Amount</dt>
                                        <dd class="text-sm font-medium text-gray-900">₱{{ number_format($donation->amount, 2) }}</dd>
                                    </div>
                                    @if($donation->payment_method)
                                        <div class="flex justify-between">
                                            <dt class="text-sm text-gray-500">Payment Method</dt>
                                            <dd class="text-sm font-medium text-gray-900 capitalize">{{ str_replace('_', ' ', $donation->payment_method) }}</dd>
                                        </div>
                                    @endif
                                @else
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Quantity</dt>
                                        <dd class="text-sm font-medium text-gray-900">{{ $donation->quantity ?? 'N/A' }} {{ $donation->unit ?? 'items' }}</dd>
                                    </div>
                                    
                                    @if($donation->delivery_method)
                                        <div class="flex justify-between">
                                            <dt class="text-sm text-gray-500">Delivery Method</dt>
                                            <dd class="text-sm font-medium text-gray-900 capitalize">{{ $donation->delivery_method === 'dropoff' ? 'Drop Off' : 'Pickup' }}</dd>
                                        </div>
                                    @endif
                                    
                                    @if($donation->pickup_date)
                                        <div class="flex justify-between">
                                            <dt class="text-sm text-gray-500">Preferred Date</dt>
                                            <dd class="text-sm font-medium text-gray-900">{{ $donation->pickup_date->format('M d, Y') }}</dd>
                                        </div>
                                    @endif
                                @endif
                            @endif
                            
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Status</dt>
                                <dd class="text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $donation->status === 'approved' || $donation->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($donation->status) }}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>
                    
                    <div class="mt-8 flex justify-center space-x-3">
                        <a href="{{ route('donor.donations.history') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            View Donation History
                        </a>
                        <a href="{{ route('donor.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    @push('scripts')
    <script>
        // Show a success message if redirected with success
        document.addEventListener('DOMContentLoaded', function() {
            alert('{{ session('success') }}');
        });
    </script>
    @endpush
@endif

@if(session('error'))
    @push('scripts')
    <script>
        // Show an error message if there was an error
        document.addEventListener('DOMContentLoaded', function() {
            alert('Error: {{ session('error') }}');
        });
    </script>
    @endpush
@endif
@endsection
