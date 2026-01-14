@extends('donor.layouts.dashboard')

@section('title', 'Message Details')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('donor.messages.index') }}" class="text-decoration-none text-primary d-inline-flex align-items-center fw-medium">
            <i class="fas fa-arrow-left me-2"></i> Back to Messages
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1 text-gray-800">{{ $message->subject }}</h5>
                <small class="text-muted">
                    Sent on {{ $message->created_at->format('F j, Y \a\t g:i A') }}
                </small>
            </div>
            <div>
                @if($message->status === 'replied')
                    <span class="badge bg-success rounded-pill px-3 py-2">Replied</span>
                @else
                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Pending</span>
                @endif
            </div>
        </div>
        
        <div class="card-body p-4">
            <div class="mb-5">
                <h6 class="text-uppercase text-muted small fw-bold mb-2">Your Message</h6>
                <div class="bg-light rounded p-3 text-dark border">
                    {{ $message->message }}
                </div>
            </div>

            @if($message->status === 'replied' && $message->admin_response)
                <div class="border-top pt-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-shrink-0 me-3">
                            <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; color: var(--bs-primary);">
                                <i class="fas fa-user-shield fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold text-dark mb-1">Admin Response</h6>
                            <p class="text-muted small mb-2">
                                Responded on {{ $message->responded_at->format('F j, Y \a\t g:i A') }}
                            </p>
                            <div class="alert alert-primary mb-0 border-0" role="alert">
                                {{ $message->admin_response }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

