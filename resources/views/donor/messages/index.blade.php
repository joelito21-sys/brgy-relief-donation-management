@extends('donor.layouts.dashboard')

@section('title', 'My Messages')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">My Messages</h1>
            <p class="text-muted small mb-0">Track your inquiries and admin responses</p>
        </div>
        <a href="{{ route('donor.contact') }}" class="btn btn-dark">
            <i class="fas fa-plus me-2"></i> New Message
        </a>
    </div>

    <div class="card shadow-sm">
        @if($messages->count() > 0)
            <div class="list-group list-group-flush">
                @foreach($messages as $message)
                <a href="{{ route('donor.messages.show', $message) }}" class="list-group-item list-group-item-action p-4">
                    <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                        <h5 class="mb-0 text-dark fw-bold text-truncate" style="max-width: 70%;">{{ $message->subject }}</h5>
                        <small class="text-dark">
                            <i class="fas fa-calendar me-1"></i> {{ $message->created_at->format('M d, Y') }}
                        </small>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-0 text-dark small text-truncate" style="max-width: 75%;">
                            <i class="fas fa-envelope me-1 text-dark"></i> {{ Str::limit($message->message, 80) }}
                        </p>
                        
                        @if($message->status === 'replied')
                            <span class="badge bg-success text-white rounded-pill">Replied</span>
                        @else
                            <span class="badge bg-warning text-dark rounded-pill">Pending</span>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
            
            @if($messages->hasPages())
                <div class="card-footer bg-white border-top-0 py-3">
                    {{ $messages->links() }}
                </div>
            @endif
        @else
            <div class="card-body text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-inbox text-muted fa-3x"></i>
                </div>
                <h5 class="text-muted">You haven't sent any messages yet.</h5>
                <p class="text-muted mb-4">Have a question or concern? Send us a message.</p>
                <a href="{{ route('donor.contact') }}" class="btn btn-dark">
                    Contact Support
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

