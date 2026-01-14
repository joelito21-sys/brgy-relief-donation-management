@extends('layouts.admin')

@section('title', 'Pending Donations')

@push('styles')
<style>
    .donation-item {
        transition: all 0.2s ease-in-out;
    }
    .donation-item:hover {
        background-color: #f8f9fa;
        transform: translateY(-2px);
    }
    .status-badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }
    .donation-type {
        font-weight: 600;
    }
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
        display: none;
    }
    .loading-spinner {
        width: 3rem;
        height: 3rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="page-title">Pending Donations</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pending Donations</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Total Pending -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pending Donations</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $totalPending }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-4 sm:px-6">
                <div class="text-sm">
                    <a href="{{ route('admin.donations.index') }}" class="font-medium text-blue-600 hover:text-blue-500">View all donations</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('admin.donations.pending') }}" method="GET" class="mb-3 mb-md-0">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search by donor name, email, or ID..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i> Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Container -->
    <div id="alertContainer">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    
    <!-- Pending Donations Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Pending Donations</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Donor</th>
                        <th>Type</th>
                        <th>Donation Details</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donations as $donation)
                        <tr class="donation-item">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-sm bg-light rounded p-1">
                                            <i class="fas fa-user text-primary fs-4"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0">{{ $donation->donor_name }}</h6>
                                        <small class="text-muted">{{ $donation->donor_email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $donation->type)) }}</span>
                            </td>
                            <td>
                                @if($donation->type === 'monetary')
                                    <div class="text-nowrap">₱{{ number_format($donation->amount, 2) }}</div>
                                    <small class="text-muted">via {{ ucfirst($donation->payment_method) }}</small>
                                @else
                                    @php
                                        $details = is_array($donation->details) ? $donation->details : json_decode($donation->details, true);
                                        $items = $details['items'] ?? [];
                                    @endphp
                                    @if(count($items) > 0)
                                        <div class="text-nowrap">{{ count($items) }} {{ Str::plural('item', count($items)) }}</div>
                                        <small class="text-muted">
                                            @foreach(array_slice($items, 0, 2) as $item)
                                                {{ $item['quantity'] ?? 0 }} {{ $item['unit'] ?? '' }} {{ $item['type'] ?? $item['name'] ?? 'Item' }}@if(!$loop->last), @endif
                                            @endforeach
                                            {{ count($items) > 2 ? '...' : '' }}
                                        </small>
                                    @else
                                        <span class="text-muted">No items</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                <div class="text-nowrap">{{ $donation->created_at->format('M d, Y') }}</div>
                                <small class="text-muted">{{ $donation->created_at->diffForHumans() }}</small>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.donations.show', $donation) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.donations.approve', $donation) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Approve Donation">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-danger reject-btn" data-bs-toggle="modal" data-bs-target="#rejectModal" data-id="{{ $donation->id }}" data-bs-toggle="tooltip" title="Reject Donation">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <h5>No pending donations found</h5>
                                    <p class="mb-0">All donations have been processed.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($donations->hasPages())
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Showing {{ $donations->firstItem() }} to {{ $donations->lastItem() }} of {{ $donations->total() }} entries
                </div>
                {{ $donations->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Reject Donation Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Donation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Reason for Rejection</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required placeholder="Please provide a reason for rejecting this donation..."></textarea>
                        <div class="invalid-feedback">Please provide a reason for rejection.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Donation</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Handle reject button click
        var rejectModal = document.getElementById('rejectModal');
        if (rejectModal) {
            rejectModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var donationId = button.getAttribute('data-id');
                var modalForm = rejectModal.querySelector('#rejectForm');
                modalForm.action = `/admin/donations/${donationId}/reject`;
            });
        }

        // Show loading overlay on form submission
        var forms = document.querySelectorAll('form');
        forms.forEach(function(form) {
            form.addEventListener('submit', function() {
                document.getElementById('loadingOverlay').style.display = 'flex';
            });
        });
    });

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>
@endpush
