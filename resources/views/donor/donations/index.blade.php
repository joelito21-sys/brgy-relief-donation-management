@extends('donor.layouts.dashboard')

@section('title', 'My Donations - Barangay Cubacub Relief and Donation Management Program')

@section('header', 'My Donations')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 fw-bold text-dark mb-1">My Donations</h1>
                        <p class="text-muted mb-0 small">View your past donations and receipts</p>
                    </div>
                    <a href="{{ route('donor.donations.index') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Make New Donation
                    </a>
                </div>
                <div class="card-body">
                    @if(isset($donations) && $donations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Donation ID</th>
                                        <th>Type</th>
                                        <th>Details</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
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
                                                <span class="text-muted">{{ $donation->items_count ?? 0 }} items</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($donation->status === 'completed')
                                                <span class="badge bg-success-subtle text-success-emphasis px-2 py-1 rounded-pill">
                                                    <i class="fas fa-check-circle me-1"></i> Completed
                                                </span>
                                            @elseif($donation->status === 'pending')
                                                <span class="badge bg-warning-subtle text-warning-emphasis px-2 py-1 rounded-pill">
                                                    <i class="fas fa-clock me-1"></i> Pending
                                                </span>
                                            @elseif($donation->status === 'cancelled')
                                                <span class="badge bg-danger-subtle text-danger-emphasis px-2 py-1 rounded-pill">
                                                    <i class="fas fa-times-circle me-1"></i> Cancelled
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary-emphasis px-2 py-1 rounded-pill">
                                                    {{ ucfirst($donation->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $donation->created_at->format('M d, Y') }}</span>
                                            <div class="small text-muted">{{ $donation->created_at->format('h:i A') }}</div>
                                        </td>
                                        <td>
                                            <a href="{{ route('donor.donations.show', $donation) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye me-1"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($donations instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="text-muted">
                                    Showing {{ $donations->firstItem() }} to {{ $donations->lastItem() }} of {{ $donations->total() }} results
                                </div>
                                <div>
                                    {{ $donations->links() }}
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-6">
                            <div class="mb-4">
                                <i class="fas fa-donate fa-4x text-muted opacity-50"></i>
                            </div>
                            <h5 class="mb-2 fw-bold">No donations yet</h5>
                            <p class="text-muted mb-4">You haven't made any donations yet. Start making a difference today!</p>
                            <a href="{{ route('donor.donations.index') }}" class="btn btn-primary">
                                <i class="fas fa-heart me-2"></i>Make Your First Donation
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection