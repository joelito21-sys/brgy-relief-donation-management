@extends('layouts.admin')

@section('title', 'Donation Details')

@push('styles')
<style>
    .donation-details {
        background: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .donation-header {
        border-bottom: 1px solid #e9ecef;
        padding: 1.5rem;
    }
    .donation-body {
        padding: 1.5rem;
    }
    .donation-section {
        margin-bottom: 2rem;
    }
    .donation-section:last-child {
        margin-bottom: 0;
    }
    .donation-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #2d3748;
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 0.5rem;
    }
    .detail-row {
        display: flex;
        margin-bottom: 0.75rem;
    }
    .detail-label {
        font-weight: 600;
        color: #4a5568;
        width: 180px;
        flex-shrink: 0;
    }
    .detail-value {
        color: #2d3748;
        flex-grow: 1;
    }
    .status-badge {
        display: inline-block;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 600;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
    }
    .badge-pending {
        background-color: #fef3c7;
        color: #92400e;
    }
    .badge-approved {
        background-color: #dcfce7;
        color: #166534;
    }
    .badge-rejected {
        background-color: #fee2e2;
        color: #991b1b;
    }
    .badge-completed {
        background-color: #dbeafe;
        color: #1e40af;
    }
    .photo-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }
    .photo-item {
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        overflow: hidden;
    }
    .photo-item img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }
    .back-button {
        display: inline-flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    .back-button i {
        margin-right: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <a href="{{ route('admin.donations.index') }}" class="btn btn-light back-button">
        <i class="fas fa-arrow-left"></i> Back to Donations
    </a>

    <div class="donation-details">
        <!-- Header -->
        <div class="donation-header d-flex justify-content-between align-items-center">
            <div>
                <h2 class="h4 mb-0">Reference Number: {{ $donation->reference_number ?? $donation->id }}</h2>
                <p class="text-muted mb-0">Created on {{ $donation->created_at->format('M d, Y \a\t h:i A') }}</p>
            </div>
            <div>
                @php
                    $statusClass = [
                        'pending' => 'badge-pending',
                        'approved' => 'badge-approved',
                        'rejected' => 'badge-rejected',
                        'completed' => 'badge-completed'
                    ][$donation->status] ?? 'bg-secondary';
                @endphp
                <span class="status-badge {{ $statusClass }}">
                    {{ ucfirst($donation->status) }}
                </span>
            </div>
        </div>

        <!-- Body -->
        <div class="donation-body">
            <!-- Donor Information -->
            <div class="donation-section">
                <h3 class="donation-section-title">Donor Information</h3>
                <div class="detail-row">
                    <div class="detail-label">Name</div>
                    <div class="detail-value">
                        {{ $donation->donor_name }}
                        @if($donation->donor)
                            <span class="text-muted">(Registered Donor)</span>
                        @else
                            <span class="text-muted">(Guest Donor)</span>
                        @endif
                    </div>
                </div>
                @if($donation->donor_email)
                <div class="detail-row">
                    <div class="detail-label">Email</div>
                    <div class="detail-value">
                        <a href="mailto:{{ $donation->donor_email }}">{{ $donation->donor_email }}</a>
                    </div>
                </div>
                @endif
                @if($donation->donor_phone)
                <div class="detail-row">
                    <div class="detail-label">Phone</div>
                    <div class="detail-value">{{ $donation->donor_phone }}</div>
                </div>
                @endif
                @if($donation->donor_address)
                <div class="detail-row">
                    <div class="detail-label">Address</div>
                    <div class="detail-value">{{ $donation->donor_address }}</div>
                </div>
                @endif
            </div>

            <!-- Donation Details -->
            <div class="donation-section">
                <h3 class="donation-section-title">Donation Details</h3>
                <div class="detail-row">
                    <div class="detail-label">Type</div>
                    <div class="detail-value">
                        @php
                            $typeIcons = [
                                'cash' => 'money-bill-wave',
                                'food' => 'utensils',
                                'clothing' => 'tshirt',
                                'medical' => 'pills',
                                'other' => 'gift'
                            ];
                            $icon = $typeIcons[$donation->type] ?? 'gift';
                        @endphp
                        <i class="fas fa-{{ $icon }} me-2"></i>
                        {{ ucfirst($donation->type) }} Donation
                    </div>
                </div>

                @if($donation->type === 'cash')
                    <div class="detail-row">
                        <div class="detail-label">Amount</div>
                        <div class="detail-value">₱{{ number_format($donation->amount, 2) }}</div>
                    </div>
                    @if($donation->payment_method)
                    <div class="detail-row">
                        <div class="detail-label">Payment Method</div>
                        <div class="detail-value">{{ ucfirst(str_replace('_', ' ', $donation->payment_method)) }}</div>
                    </div>
                    @endif
                    @if($donation->payment_reference)
                    <div class="detail-row">
                        <div class="detail-label">Reference Number</div>
                        <div class="detail-value">{{ $donation->payment_reference }}</div>
                    </div>
                    @endif
                @else
                    <div class="detail-row">
                        <div class="detail-label">Items Count</div>
                        <div class="detail-value">{{ $donation->items_count ?? 1 }} items</div>
                    </div>
                    @if($donation->delivery_method)
                    <div class="detail-row">
                        <div class="detail-label">Delivery Method</div>
                        <div class="detail-value">{{ ucfirst($donation->delivery_method) }}</div>
                    </div>
                    @endif
                    @if($donation->pickup_date)
                    <div class="detail-row">
                        <div class="detail-label">Preferred Date</div>
                        <div class="detail-value">{{ $donation->pickup_date->format('M d, Y') }}</div>
                    </div>
                    @endif
                    @if($donation->pickup_address)
                    <div class="detail-row">
                        <div class="detail-label">Address</div>
                        <div class="detail-value">{{ $donation->pickup_address }}</div>
                    </div>
                    @endif
                    @if($donation->description)
                    <div class="detail-row">
                        <div class="detail-label">Description</div>
                        <div class="detail-value">{{ $donation->description }}</div>
                    </div>
                    @endif
                @endif

                @if($donation->notes)
                <div class="detail-row">
                    <div class="detail-label">Notes</div>
                    <div class="detail-value">{{ $donation->notes }}</div>
                </div>
                @endif
            </div>

            <!-- Status Information -->
            <div class="donation-section">
                <h3 class="donation-section-title">Status Information</h3>
                <div class="detail-row">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">
                        <span class="status-badge {{ $statusClass }}">
                            {{ ucfirst($donation->status) }}
                        </span>
                    </div>
                </div>
                
                @if($donation->approved_by && $donation->approved_at)
                <div class="detail-row">
                    <div class="detail-label">Approved By</div>
                    <div class="detail-value">
                        {{ $donation->approvedBy->name ?? 'System' }}
                        <span class="text-muted">on {{ $donation->approved_at->format('M d, Y \a\t h:i A') }}</span>
                    </div>
                </div>
                @endif

                @if($donation->rejection_reason)
                <div class="detail-row">
                    <div class="detail-label">Rejection Reason</div>
                    <div class="detail-value text-danger">{{ $donation->rejection_reason }}</div>
                </div>
                @endif
            </div>

            <!-- Photos -->
            @if(!empty($photoUrls))
            <div class="donation-section">
                <h3 class="donation-section-title">Photos</h3>
                <div class="photo-gallery">
                    @foreach($photoUrls as $photoUrl)
                    <div class="photo-item">
                        <a href="{{ $photoUrl }}" data-fancybox="gallery">
                            <img src="{{ $photoUrl }}" alt="Donation photo" class="img-fluid">
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Receipt -->
            @if($donation->receipt_path)
            <div class="donation-section">
                <h3 class="donation-section-title">Receipt</h3>
                <div class="detail-row">
                    <div class="detail-label">Receipt</div>
                    <div class="detail-value">
                        <a href="{{ Storage::url($donation->receipt_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-receipt me-1"></i> View Receipt
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Fancybox for image gallery
    Fancybox.bind("[data-fancybox]", {
        // Your custom options
    });
});
</script>
@endpush
