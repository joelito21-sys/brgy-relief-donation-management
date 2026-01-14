@extends('donor.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Donation #{{ $donation->id }}</h1>
            <p class="text-gray-600">Donated on {{ $donation->created_at->format('F j, Y') }}</p>
        </div>
        <div class="mt-4 md:mt-0">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ 
                $donation->status === 'completed' ? 'bg-green-100 text-green-800' : 
                ($donation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') 
            }}">
                {{ ucfirst($donation->status) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Donation Details -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Donation Details
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                Donation Type
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ ucfirst($donation->type) }} Donation
                            </dd>
                        </div>
                        
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                Donation Date
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $donation->created_at->format('F j, Y \a\t g:i A') }}
                            </dd>
                        </div>
                        
                        @if($donation->type === 'cash')
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Amount
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    ₱{{ number_format($donation->amount, 2) }}
                                </dd>
                            </div>
                            
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Payment Method
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ ucfirst(str_replace('_', ' ', $donation->payment_method ?? 'N/A')) }}
                                </dd>
                            </div>
                        @else
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">
                                    Items Donated
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if(isset($donation->items) && count($donation->items) > 0)
                                        <ul class="list-disc pl-5">
                                            @foreach($donation->items as $item)
                                                <li>{{ $item['name'] }} ({{ $item['quantity'] }} {{ $item['unit'] }})</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        No items specified
                                    @endif
                                </dd>
                            </div>
                        @endif
                        
                        @if($donation->message)
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">
                                    Your Message
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">
                                    {{ $donation->message }}
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
        
        <!-- Donation Status -->
        <div>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Donation Status
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @php
                                $steps = [
                                    'pending' => [
                                        'name' => 'Pending',
                                        'description' => 'We\'ve received your donation and it\'s being processed.',
                                        'icon' => 'clock',
                                    ],
                                    'processing' => [
                                        'name' => 'Processing',
                                        'description' => 'Your donation is being processed by our team.',
                                        'icon' => 'cog',
                                    ],
                                    'in_transit' => [
                                        'name' => 'In Transit',
                                        'description' => 'Your donation is on its way to the beneficiaries.',
                                        'icon' => 'truck',
                                    ],
                                    'completed' => [
                                        'name' => 'Completed',
                                        'description' => 'Your donation has been delivered successfully.',
                                        'icon' => 'check-circle',
                                    ],
                                ];
                                
                                $currentStep = array_search($donation->status, array_keys($steps));
                                if ($currentStep === false) $currentStep = 0;
                            @endphp
                            
                            @foreach($steps as $status => $step)
                                @php
                                    $isComplete = $currentStep >= array_search($status, array_keys($steps));
                                    $isCurrent = $donation->status === $status;
                                @endphp
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white {{ $isComplete ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-500' }}">
                                                    <i class="fas fa-{{ $step['icon'] }} text-xs"></i>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm {{ $isComplete ? 'text-gray-900' : 'text-gray-500' }}">
                                                        {{ $step['name'] }}
                                                    </p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    @if($isCurrent)
                                                        <span class="text-blue-600 font-medium">In progress</span>
                                                    @elseif($isComplete)
                                                        <span class="text-green-500">
                                                            <i class="fas fa-check"></i> Complete
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-2 ml-11">
                                            <p class="text-sm text-gray-500">
                                                {{ $step['description'] }}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            
            @if($donation->type === 'cash')
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Payment Information
                        </h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        @if($donation->receipt_path)
                            <div class="text-center mb-4">
                                <p class="text-sm font-medium text-gray-500 mb-2">Scan to verify donation</p>
                                <img src="{{ asset('storage/' . str_replace('public/', '', $donation->receipt_path)) }}" 
                                     alt="Donation QR Code" 
                                     class="mx-auto h-40 w-40 object-contain">
                                <p class="mt-2 text-xs text-gray-500">Donation #{{ $donation->id }}</p>
                            </div>
                        @endif
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    Payment Method
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ ucfirst($donation->payment_method) }}
                                </dd>
                            </div>
                            @if($donation->reference_number)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">
                                        Reference Number
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $donation->reference_number }}
                                    </dd>
                                </div>
                            @endif
                        </dl>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Receipt
                        </h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6 text-center">
                        <p class="text-sm text-gray-500 mb-4">Download your donation receipt</p>
                        <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-download mr-2"></i> Download Receipt
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    <div class="mt-8">
        <a href="{{ route('donor.donations.history') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
            <i class="fas fa-arrow-left mr-2"></i> Back to Donation History
        </a>
    </div>
</div>
@endsection
