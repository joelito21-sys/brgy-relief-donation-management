@extends('admin.layouts.app')

@section('title', 'Message Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Message Details</h1>
            <nav class="flex mt-1 text-sm text-gray-500 rounded-lg bg-gray-50 px-2 py-1 w-fit" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.contact-messages.index') }}" class="inline-flex items-center text-gray-700 hover:text-blue-600">
                            Contact Messages
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-gray-500">Details</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center">
            <i class="fas fa-check-circle mr-3 text-green-500"></i>
            {{ session('success') }}
            <button onclick="this.parentElement.remove()" class="ml-auto text-green-500 hover:text-green-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Message Content -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h2 class="font-bold text-gray-800 flex items-center">
                        <i class="fas fa-envelope-open-text mr-2 text-violet-600"></i> Message from {{ $contactMessage->name }}
                    </h2>
                    <div>
                        @if($contactMessage->status == 'pending')
                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-700 border border-amber-200">
                                Pending
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">
                                Replied
                            </span>
                        @endif
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Sender Name</label>
                            <div class="text-gray-900">{{ $contactMessage->name }}</div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                            <div class="text-gray-900">
                                <a href="mailto:{{ $contactMessage->email }}" class="text-blue-600 hover:underline">{{ $contactMessage->email }}</a>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Subject</label>
                            <div class="text-gray-900 font-medium">{{ $contactMessage->subject }}</div>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Date Received</label>
                            <div class="text-gray-900 text-sm">{{ $contactMessage->created_at->format('F d, Y h:i A') }}</div>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Message</label>
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 text-gray-800 whitespace-pre-line">
                            {{ $contactMessage->message }}
                        </div>
                    </div>
                    
                    @if($contactMessage->status == 'replied')
                        <div class="pt-4 mt-4 border-t border-gray-100">
                            <h3 class="text-emerald-600 font-bold flex items-center mb-2">
                                <i class="fas fa-check-circle mr-2"></i> Admin Response
                            </h3>
                            <p class="text-xs text-gray-500 mb-3">Replied on {{ $contactMessage->responded_at->format('M d, Y h:i A') }}</p>
                            <div class="p-4 bg-emerald-50 rounded-lg border border-emerald-100 text-gray-800">
                                {!! nl2br(e($contactMessage->admin_response)) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Reply Box -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50">
                    <h2 class="font-bold text-gray-800 flex items-center">
                        <i class="fas fa-reply mr-2 text-violet-600"></i> Reply
                    </h2>
                </div>
                <div class="p-6">
                    @if($contactMessage->status == 'pending')
                        <form action="{{ route('admin.contact-messages.reply', $contactMessage) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="response" class="block text-sm font-medium text-gray-700 mb-2">Response Message</label>
                                <textarea name="response" id="response" rows="6" 
                                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-violet-500 focus:ring focus:ring-violet-200 focus:ring-opacity-50" 
                                          placeholder="Type your reply here..." required></textarea>
                            </div>
                            <button type="submit" class="w-full btn-primary bg-violet-600 hover:bg-violet-700 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors flex items-center justify-center">
                                <i class="fas fa-paper-plane mr-2"></i> Send Reply
                            </button>
                        </form>
                    @else
                        <div class="text-center py-6 text-gray-500">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-check-double text-2xl text-emerald-500"></i>
                            </div>
                            <p class="font-medium">This message has already been replied to.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Danger Zone -->
            <div class="bg-white rounded-xl shadow-sm border border-red-200 overflow-hidden">
                <div class="p-6 border-b border-red-100 bg-red-50">
                    <h2 class="font-bold text-red-700 flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Danger Zone
                    </h2>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-600 mb-4">Delete this message permanently. This action cannot be undone.</p>
                    <form action="{{ route('admin.contact-messages.destroy', $contactMessage) }}" method="POST" onsubmit="return confirm('This action cannot be undone. Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors flex items-center justify-center">
                            <i class="fas fa-trash mr-2"></i> Delete Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
