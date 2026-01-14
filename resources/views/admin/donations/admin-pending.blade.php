@extends('layouts.admin')

@section('title', 'Pending Donations - Admin')

@push('styles')
<style>
    .donation-card {
        transition: all 0.3s ease;
        border-left: 4px solid #f39c12;
        margin-bottom: 1.5rem;
    }
    .donation-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .donor-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
    }
    .donation-amount {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2c3e50;
    }
    .donation-meta {
        font-size: 0.85rem;
        color: #6c757d;
    }
    .badge-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    .action-buttons .btn {
        min-width: 100px;
        margin: 0 0.25rem;
    }
    .empty-state {
        padding: 3rem 1rem;
        text-align: center;
        background: #f8f9fa;
        border-radius: 0.5rem;
        margin: 2rem 0;
    }
    .empty-state i {
        font-size: 3rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pending Donations</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pending Donations</li>
            </ol>
        </nav>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $donations->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                This Week</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $thisWeekCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                High Priority</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $highPriorityCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Avg. Processing Time</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $avgProcessingTime }} days</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-stopwatch fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Donations List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Pending Donations</h6>
            <div class="dropdown no-arrow
            ">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Actions:</div>
                    <a class="dropdown-item" href="#"><i class="fas fa-file-export fa-sm fa-fw mr-2 text-gray-400"></i>Export to Excel</a>
                    <a class="dropdown-item" href="#"><i class="fas fa-print fa-sm fa-fw mr-2 text-gray-400"></i>Print List</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"><i class="fas fa-sync-alt fa-sm fa-fw mr-2 text-gray-400"></i>Refresh</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($donations->count() > 0)
                @foreach($donations as $donation)
                    <div class="card mb-3 donation-card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-1 text-center">
                                    <div class="donor-avatar mx-auto">
                                        {{ substr($donation->donor->name ?? '?', 0, 1) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <h5 class="mb-1">{{ $donation->donor->name ?? 'Anonymous Donor' }}</h5>
                                    <p class="text-muted small mb-1">#{{ $donation->id }}</p>
                                    <span class="badge badge-pill badge-pending">
                                        <i class="far fa-clock mr-1"></i> Pending
                                    </span>
                                </div>
                                <div class="col-md-2 text-center">
                                    <div class="donation-amount">
                                        ₱{{ number_format($donation->amount, 2) }}
                                    </div>
                                    <div class="donation-meta">
                                        {{ ucfirst($donation->payment_method) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="d-flex align-items-center">
                                        <i class="far fa-calendar-alt text-muted mr-2"></i>
                                        <div>
                                            <div class="font-weight-bold">{{ $donation->created_at->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ $donation->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 text-right">
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.donations.show', $donation->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="far fa-eye"></i> View
                                        </a>
                                        <form action="{{ route('admin.donations.approve', $donation->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-outline-danger reject-btn" 
                                                data-toggle="modal" 
                                                data-target="#rejectModal" 
                                                data-id="{{ $donation->id }}">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $donations->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox fa-4x mb-3"></i>
                    <h4>No Pending Donations</h4>
                    <p class="text-muted">There are currently no pending donations to review.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Reject Donation Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Reject Donation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rejection_reason">Reason for Rejection</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required placeholder="Please provide a reason for rejecting this donation..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Donation</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Handle reject button click
        $('.reject-btn').on('click', function() {
            var donationId = $(this).data('id');
            var form = $('#rejectForm');
            form.attr('action', '/admin/donations/' + donationId + '/reject');
        });

        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    });
</script>
@endpush
