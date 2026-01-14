@extends('donor.layouts.dashboard')

@section('header', 'My Donation History')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">My Donation History</h1>
            <p class="text-muted mb-0">View your past donations and receipts</p>
        </div>
        <a href="{{ route('donor.donations.index') }}" 
           class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> New Donation
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if($donations->isEmpty())
                <div class="text-center py-6">
                    <div class="mb-4">
                        <i class="fas fa-inbox fa-4x text-muted opacity-50"></i>
                    </div>
                    <h5 class="mb-2 fw-bold">No donations yet</h5>
                    <p class="text-muted mb-4">Your donation history will appear here.</p>
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                        <a href="{{ route('donor.donations.index') }}" 
                           class="btn btn-primary">
                            <i class="fas fa-heart me-2"></i>Make Your First Donation
                        </a>
                    </div>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Donation ID</th>
                                <th scope="col">Type</th>
                                <th scope="col">Details</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date</th>
                                <th scope="col" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($donations as $donation)
                            <tr>
                                <td class="fw-bold">#{{ $donation->id }}</td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary-emphasis px-2 py-1 rounded-pill">
                                        {{ ucfirst($donation->type) }}
                                    </span>
                                </td>
                                <td>
                                    @if($donation->type === 'cash')
                                        <span class="fw-bold text-success">₱{{ number_format($donation->amount, 2) }}</span>
                                    @else
                                        <span class="text-muted">{{ $donation->items_count }} items</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-warning-subtle text-warning-emphasis',
                                            'received' => 'bg-success-subtle text-success-emphasis',
                                            'in_transit' => 'bg-info-subtle text-info-emphasis',
                                            'cancelled' => 'bg-danger-subtle text-danger-emphasis',
                                            'completed' => 'bg-success-subtle text-success-emphasis',
                                        ][$donation->status] ?? 'bg-secondary-subtle text-secondary-emphasis';
                                    @endphp
                                    <span class="badge {{ $statusClasses }} px-2 py-1 rounded-pill">
                                        @if($donation->status === 'completed')
                                            <i class="fas fa-check-circle me-1"></i>
                                        @elseif($donation->status === 'pending')
                                            <i class="fas fa-clock me-1"></i>
                                        @elseif($donation->status === 'cancelled')
                                            <i class="fas fa-times-circle me-1"></i>
                                        @endif
                                        {{ ucfirst(str_replace('_', ' ', $donation->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="text-muted">{{ $donation->created_at->format('M d, Y') }}</div>
                                    <div class="small text-muted">{{ $donation->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('donor.donations.show', $donation) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i>View
                                    </a>
                                    @if($donation->type === 'cash')
                                        <a href="#" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-file-invoice me-1"></i>Receipt
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing {{ $donations->firstItem() }} to {{ $donations->lastItem() }} of {{ $donations->total() }} results
                    </div>
                    <div>
                        {{ $donations->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection