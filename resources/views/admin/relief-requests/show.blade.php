@extends('admin.layouts.app')

@section('title', 'Relief Request Details')

@push('styles')
<style>
    /* Enhanced Status Badges */
    .status-badge {
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        padding: 0.5rem 1.25rem;
        border-radius: 50rem;
        text-transform: uppercase;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border: none;
    }
    .status-pending { 
        background: linear-gradient(135deg, #fff3cd, #ffeaa7);
        color: #856404;
    }
    .status-approved { 
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #155724;
    }
    .status-rejected { 
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
    }
    .status-ready { 
        background: linear-gradient(135deg, #d1ecf1, #bee5eb);
        color: #0c5460;
    }
    .status-claimed { 
        background: linear-gradient(135deg, #e2d4f0, #d6c1f0);
        color: #3d1e6d;
    }
    .status-delivered { 
        background: linear-gradient(135deg, #d1f2eb, #a3e4d7);
        color: #0b5345;
    }

    /* Enhanced Timeline */
    .timeline {
        position: relative;
        padding-left: 3rem;
        margin-left: 1rem;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 1rem;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(to bottom, #4e73df, #36b9cc);
        border-radius: 2px;
    }
    .timeline-item {
        position: relative;
        padding-bottom: 2rem;
        padding-left: 2.5rem;
    }
    .timeline-item:last-child {
        padding-bottom: 1rem;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -0.25rem;
        top: 0.25rem;
        width: 1.5rem;
        height: 1.5rem;
        border-radius: 50%;
        background-color: #4e73df;
        border: 4px solid #fff;
        box-shadow: 0 0 0 3px #4e73df;
        z-index: 2;
        transition: all 0.3s ease;
    }
    .timeline-item.completed::before {
        background-color: #1cc88a;
        box-shadow: 0 0 0 3px #1cc88a;
    }
    .timeline-item.pending::before {
        background-color: #f6c23e;
        box-shadow: 0 0 0 3px #f6c23e;
    }
    .timeline-item.rejected::before {
        background-color: #e74a3b;
        box-shadow: 0 0 0 3px #e74a3b;
    }
    .timeline-item.current::before {
        animation: pulse 2s infinite;
        box-shadow: 0 0 0 3px #4e73df, 0 0 0 6px rgba(78, 115, 223, 0.3);
    }
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    .timeline-icon {
        font-size: 1.25rem;
    }

    /* QR Code Styling */
    .qr-code-container {
        max-width: 220px;
        margin: 0 auto;
        padding: 1.5rem;
        border: 1px solid #e3e6f0;
        border-radius: 0.75rem;
        text-align: center;
        background: #fff;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        transition: all 0.3s ease;
    }
    .qr-code-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 2rem rgba(0, 0, 0, 0.2);
    }
    .qr-code {
        width: 100%;
        height: auto;
        margin-bottom: 1.25rem;
    }

    /* Item Images */
    .item-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 0.5rem;
        border: 1px solid #e3e6f0;
        transition: all 0.2s ease;
    }
    .item-image:hover {
        transform: scale(1.05);
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
    }

    /* Card Improvements */
    .card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }
    .card:hover {
        box-shadow: 0 0.5rem 2rem rgba(0, 0, 0, 0.2);
    }
    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.25rem 1.5rem;
        background-color: #f8f9fc;
        border-radius: 0.75rem 0.75rem 0 0 !important;
    }
    .card-body {
        padding: 1.5rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .timeline {
            padding-left: 2.5rem;
        }
        .timeline-item {
            padding-left: 2rem;
        }
        .btn-group {
            width: 100%;
            margin-top: 1rem;
        }
        .btn-group .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
        .qr-code-container {
            max-width: 180px;
            padding: 1rem;
        }
    }

    /* Floating Action Button */
    .floating-actions {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    .floating-btn {
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15);
        transition: all 0.2s;
    }
    .floating-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.75rem 2rem rgba(0, 0, 0, 0.2);
    }
    .floating-btn i {
        font-size: 1.5rem;
    }
    
    /* Stats Cards */
    .stat-card {
        border-radius: 0.75rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15);
    }
    
    /* Badge Improvements */
    .badge {
        padding: 0.5em 0.85em;
        font-weight: 600;
        border-radius: 0.375rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark">Relief Request Details</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.relief-requests.index') }}">Relief Requests</a></li>
                    <li class="breadcrumb-item active" aria-current="page">#{{ $reliefRequest->request_number }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.relief-requests.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1 d-none d-md-inline"></i>
                <span class="d-inline d-md-none"><i class="fas fa-arrow-left"></i></span>
                <span class="d-none d-md-inline">Back to List</span>
            </a>
            
            @if($reliefRequest->isPending())
                <button type="button" class="btn btn-success" 
                        onclick="event.preventDefault(); document.getElementById('approveForm').submit();"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Approve Request">
                    <i class="fas fa-check me-1 d-none d-md-inline"></i>
                    <span class="d-none d-md-inline">Approve</span>
                    <span class="d-inline d-md-none"><i class="fas fa-check"></i></span>
                </button>
                
                <button type="button" class="btn btn-danger" 
                        data-bs-toggle="modal" data-bs-target="#rejectModal"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Reject Request">
                    <i class="fas fa-times me-1 d-none d-md-inline"></i>
                    <span class="d-none d-md-inline">Reject</span>
                    <span class="d-inline d-md-none"><i class="fas fa-times"></i></span>
                </button>
            @elseif($reliefRequest->isApproved() && !$reliefRequest->isReadyForPickup())
                <button type="button" class="btn btn-info text-white" 
                        onclick="event.preventDefault(); document.getElementById('readyForPickupForm').submit();"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Mark as Ready for Pickup">
                    <i class="fas fa-box-open me-1 d-none d-md-inline"></i>
                    <span class="d-none d-md-inline">Ready for Pickup</span>
                    <span class="d-inline d-md-none"><i class="fas fa-box-open"></i></span>
                </button>
            @elseif($reliefRequest->isReadyForPickup() && !$reliefRequest->isClaimed())
                <button type="button" class="btn btn-primary" 
                        data-bs-toggle="modal" data-bs-target="#markAsClaimedModal"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Mark as Claimed">
                    <i class="fas fa-check-circle me-1 d-none d-md-inline"></i>
                    <span class="d-none d-md-inline">Mark as Claimed</span>
                    <span class="d-inline d-md-none"><i class="fas fa-check-circle"></i></span>
                </button>
            @endif
            
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    @if($reliefRequest->isPending())
                        <li>
                            <a class="dropdown-item text-success" href="#" 
                               onclick="event.preventDefault(); document.getElementById('approveForm').submit();">
                                <i class="fas fa-check me-2"></i> Approve Request
                            </a>
                            <form id="approveForm" action="{{ route('admin.relief-requests.approve', $reliefRequest) }}" 
                                  method="POST" style="display: none;">
                                @csrf
                                @method('PATCH')
                            </form>
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" 
                               data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <i class="fas fa-times me-2"></i> Reject Request
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                    @endif
                    
                    @if($reliefRequest->isApproved())
                        <li>
                            <a class="dropdown-item text-primary" href="#" 
                               onclick="event.preventDefault(); document.getElementById('readyForPickupForm').submit();">
                                <i class="fas fa-box-open me-2"></i> Mark as Ready for Pickup
                            </a>
                            <form id="readyForPickupForm" action="{{ route('admin.relief-requests.ready-for-pickup', $reliefRequest) }}" 
                                  method="POST" style="display: none;">
                                @csrf
                                @method('PATCH')
                            </form>
                        </li>
                    @endif
                    
                    @if($reliefRequest->isReadyForPickup())
                        <li>
                            <a class="dropdown-item text-success" href="#" 
                               onclick="event.preventDefault(); document.getElementById('markAsClaimedForm').submit();">
                                <i class="fas fa-check-circle me-2"></i> Mark as Claimed
                            </a>
                            <form id="markAsClaimedForm" action="{{ route('admin.relief-requests.mark-claimed', $reliefRequest) }}" 
                                  method="POST" style="display: none;">
                                @csrf
                                @method('PATCH')
                            </form>
                        </li>
                    @endif
                    
                    @if($reliefRequest->isClaimed())
                        <li>
                            <a class="dropdown-item text-success" href="#" 
                               onclick="event.preventDefault(); document.getElementById('markAsDeliveredForm').submit();">
                                <i class="fas fa-truck me-2"></i> Mark as Delivered
                            </a>
                            <form id="markAsDeliveredForm" action="{{ route('admin.relief-requests.mark-delivered', $reliefRequest) }}" 
                                  method="POST" style="display: none;">
                                @csrf
                                @method('PATCH')
                            </form>
                        </li>
                    @endif
                    
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#printSlipModal">
                            <i class="fas fa-print me-2"></i> Print Claim Slip
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.relief-requests.download-qr', $reliefRequest) }}" target="_blank">
                            <i class="fas fa-download me-2"></i> Download QR Code
                        </a>
                    </li>
                    @if($reliefRequest->isPending())
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.relief-requests.edit', $reliefRequest) }}">
                                <i class="fas fa-edit me-2"></i> Edit Request
                            </a>
                        </li>
                    @endif
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash-alt me-2"></i> Delete Request
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Request Details Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>Request Information
                    </h5>
                    <span class="status-badge status-{{ str_replace('_', '-', $reliefRequest->status) }}">
                        {{ $reliefRequest->status_label }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="text-muted mb-1 fw-bold">
                                    <i class="fas fa-hashtag me-1"></i>Request Number
                                </h6>
                                <p class="mb-0 h5 fw-bold">{{ $reliefRequest->request_number }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-1 fw-bold">
                                    <i class="fas fa-calendar me-1"></i>Request Date
                                </h6>
                                <p class="mb-0">{{ $reliefRequest->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-1 fw-bold">
                                    <i class="fas fa-users me-1"></i>Family Members
                                </h6>
                                <p class="mb-0">{{ $reliefRequest->family_members }} person(s)</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="text-muted mb-1 fw-bold">
                                    <i class="fas fa-truck me-1"></i>Delivery Method
                                </h6>
                                <p class="mb-0">{{ $reliefRequest->delivery_method_label }}</p>
                            </div>
                            @if($reliefRequest->delivery_method === 'pickup')
                                <div class="mb-3">
                                    <h6 class="text-muted mb-1 fw-bold">
                                        <i class="fas fa-map-marker-alt me-1"></i>Pickup Location
                                    </h6>
                                    <p class="mb-0">{{ $reliefRequest->pickup_location }}</p>
                                </div>
                                @if($reliefRequest->scheduled_pickup_date)
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-1 fw-bold">
                                            <i class="fas fa-clock me-1"></i>Scheduled Pickup
                                        </h6>
                                        <p class="mb-0">{{ $reliefRequest->scheduled_pickup_date->format('M d, Y h:i A') }}</p>
                                    </div>
                                @endif
                            @else
                                <div class="mb-3">
                                    <h6 class="text-muted mb-1 fw-bold">
                                        <i class="fas fa-home me-1"></i>Delivery Address
                                    </h6>
                                    <p class="mb-0">{{ $reliefRequest->delivery_address }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @if($reliefRequest->reason)
                        <div class="mt-3">
                            <h6 class="text-muted mb-1 fw-bold">
                                <i class="fas fa-comment me-1"></i>Reason for Request
                            </h6>
                            <p class="mb-0">{{ $reliefRequest->reason }}</p>
                        </div>
                    @endif
                    
                    @if($reliefRequest->rejection_reason)
                        <div class="mt-3">
                            <h6 class="text-muted mb-1 fw-bold">
                                <i class="fas fa-exclamation-circle me-1"></i>Rejection Reason
                            </h6>
                            <p class="mb-0 text-danger">{{ $reliefRequest->rejection_reason }}</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Items Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-box me-2"></i>Requested Items
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Item</th>
                                    <th>Type</th>
                                    <th class="text-end">Quantity</th>
                                    <th class="text-end">Unit</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reliefRequest->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('images/default-item.jpg') }}" 
                                                     alt="{{ $item->name }}" class="item-image me-3">
                                                <span class="fw-medium">{{ $item->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                {{ $item->type_label }}
                                            </span>
                                        </td>
                                        <td class="text-end fw-bold">{{ $item->pivot->quantity }}</td>
                                        <td class="text-end">{{ $item->unit }}</td>
                                        <td>{{ $item->pivot->notes ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Resident Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-user me-2"></i>Personal Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1 fw-bold">
                                <i class="fas fa-user me-1"></i>Full Name
                            </h6>
                            <p class="mb-0 fw-bold">{{ $reliefRequest->full_name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1 fw-bold">
                                <i class="fas fa-phone me-1"></i>Contact Number
                            </h6>
                            <p class="mb-0">{{ $reliefRequest->contact_number ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1 fw-bold">
                                <i class="fas fa-envelope me-1"></i>Email Address
                            </h6>
                            <p class="mb-0">{{ $reliefRequest->email_address ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1 fw-bold">
                                <i class="fas fa-id-card me-1"></i>ID Number
                            </h6>
                            <p class="mb-0">{{ $reliefRequest->id_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <h6 class="text-muted mb-3 mt-4 fw-bold">
                        <i class="fas fa-map-marked-alt me-1"></i>Address Information
                    </h6>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <h6 class="text-muted mb-1 fw-bold">
                                <i class="fas fa-home me-1"></i>Complete Address
                            </h6>
                            <p class="mb-0">{{ $reliefRequest->complete_address ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="text-muted mb-1 fw-bold">
                                <i class="fas fa-city me-1"></i>City/Municipality
                            </h6>
                            <p class="mb-0">{{ $reliefRequest->city_municipality ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="text-muted mb-1 fw-bold">
                                <i class="fas fa-map me-1"></i>Province
                            </h6>
                            <p class="mb-0">{{ $reliefRequest->province ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6 class="text-muted mb-1 fw-bold">
                                <i class="fas fa-mail-bulk me-1"></i>Postal Code
                            </h6>
                            <p class="mb-0">{{ $reliefRequest->postal_code ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1 fw-bold">
                                <i class="fas fa-users me-1"></i>Household Size
                            </h6>
                            <p class="mb-0 fw-bold">{{ $reliefRequest->household_size ?? 'N/A' }} people</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1 fw-bold">
                                <i class="fas fa-exclamation-triangle me-1"></i>Urgency Level
                            </h6>
                            <p class="mb-0">
                                <span class="badge bg-{{ 
                                    $reliefRequest->urgency_level === 'high' ? 'danger' : 
                                    ($reliefRequest->urgency_level === 'medium' ? 'warning' : 'info') 
                                }}">
                                    {{ ucfirst($reliefRequest->urgency_level ?? 'N/A') }}
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    @if($reliefRequest->resident)
                    <div class="mt-3">
                        <a href="{{ route('admin.residents.show', $reliefRequest->resident) }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-user me-1"></i> View Resident Profile
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Relief Request Details -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-clipboard-list me-2"></i>Relief Request Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted mb-2 fw-bold">
                            <i class="fas fa-hands-helping me-1"></i>Type of Assistance Needed
                        </h6>
                        <div class="d-flex flex-wrap gap-2">
                            @if($reliefRequest->assistance_types)
                                @if(is_string($reliefRequest->assistance_types))
                                    @php $types = json_decode($reliefRequest->assistance_types, true) ?: []; @endphp
                                @else
                                    @php $types = $reliefRequest->assistance_types; @endphp
                                @endif
                                @foreach($types as $type)
                                    <span class="badge bg-primary">
                                        @switch($type)
                                            @case('cash')
                                                <i class="fas fa-dollar-sign me-1"></i> Cash
                                                @break
                                            @case('food')
                                                <i class="fas fa-utensils me-1"></i> Food Supplies
                                                @break
                                            @case('water')
                                                <i class="fas fa-tint me-1"></i> Clean Water
                                                @break
                                            @case('medicine')
                                                <i class="fas fa-pills me-1"></i> Medicine
                                                @break
                                            @case('clothing')
                                                <i class="fas fa-tshirt me-1"></i> Clothing
                                                @break
                                            @case('shelter')
                                                <i class="fas fa-home me-1"></i> Shelter
                                                @break
                                            @case('evacuation')
                                                <i class="fas fa-truck me-1"></i> Evacuation
                                                @break
                                            @default
                                                {{ ucfirst($type) }}
                                        @endswitch
                                    </span>
                                @endforeach
                            @else
                                <span class="text-muted">No assistance types specified</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted mb-1 fw-bold">
                            <i class="fas fa-align-left me-1"></i>Detailed Description
                        </h6>
                        <p class="mb-0">{{ $reliefRequest->description ?? 'No description provided' }}</p>
                    </div>
                    
                    @if($reliefRequest->additional_message)
                    <div class="mb-3">
                        <h6 class="text-muted mb-1 fw-bold">
                            <i class="fas fa-comment-dots me-1"></i>Additional Message
                        </h6>
                        <p class="mb-0">{{ $reliefRequest->additional_message }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Family Members Affected -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-users me-2"></i>Family Members Affected
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-6 mb-3">
                            <div class="text-center">
                                <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                                    <i class="fas fa-child text-info fa-lg"></i>
                                </div>
                                <h6 class="text-muted mb-1 small">Children (0-12)</h6>
                                <p class="mb-0 fw-bold text-info h5">{{ $reliefRequest->children_count ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="text-center">
                                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                                    <i class="fas fa-user-friends text-warning fa-lg"></i>
                                </div>
                                <h6 class="text-muted mb-1 small">Elderly (60+)</h6>
                                <p class="mb-0 fw-bold text-warning h5">{{ $reliefRequest->elderly_count ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="text-center">
                                <div class="bg-secondary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                                    <i class="fas fa-wheelchair text-secondary fa-lg"></i>
                                </div>
                                <h6 class="text-muted mb-1 small">Persons with Disability</h6>
                                <p class="mb-0 fw-bold text-secondary h5">{{ $reliefRequest->pwd_count ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="text-center">
                                <div class="bg-pink bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                                    <i class="fas fa-baby text-pink fa-lg"></i>
                                </div>
                                <h6 class="text-muted mb-1 small">Pregnant Women</h6>
                                <p class="mb-0 fw-bold text-pink h5">{{ $reliefRequest->pregnant_count ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Emergency Contact -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-ambulance me-2"></i>Emergency Contact Person
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1 fw-bold">
                                <i class="fas fa-user me-1"></i>Contact Name
                            </h6>
                            <p class="mb-0 fw-bold">{{ $reliefRequest->emergency_contact_name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-1 fw-bold">
                                <i class="fas fa-phone me-1"></i>Contact Phone
                            </h6>
                            <p class="mb-0">{{ $reliefRequest->emergency_contact_phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Status Timeline -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-history me-2"></i>Request Timeline
                    </h5>
                    <span class="badge bg-{{ $reliefRequest->isRejected() ? 'danger' : ($reliefRequest->isDelivered() ? 'success' : 'primary') }} text-uppercase">
                        {{ str_replace('_', ' ', $reliefRequest->status) }}
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="timeline p-4">
                        <!-- Request Created -->
                        <div class="timeline-item {{ $reliefRequest->created_at ? 'completed' : '' }}">
                            <div class="d-flex">
                                <div class="timeline-icon me-3">
                                    <i class="fas fa-file-import fa-fw text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="mb-0 fw-bold">Request Submitted</h6>
                                        @if($reliefRequest->created_at)
                                            <span class="badge bg-success rounded-pill">
                                                <i class="fas fa-check me-1"></i>Completed
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-muted small mb-1">
                                        <i class="far fa-clock me-1"></i>
                                        {{ $reliefRequest->created_at ? $reliefRequest->created_at->format('M d, Y h:i A') : 'Pending' }}
                                    </p>
                                    @if($reliefRequest->created_at && $reliefRequest->created_by)
                                        <p class="small text-muted mb-0">
                                            <i class="fas fa-user me-1"></i>
                                            {{ $reliefRequest->createdBy->name ?? 'System' }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Approval Status -->
                        <div class="timeline-item {{ $reliefRequest->isApproved() || $reliefRequest->isRejected() ? 'completed' : ($reliefRequest->isPending() ? 'current' : '') }}">
                            <div class="d-flex">
                                <div class="timeline-icon me-3">
                                    @if($reliefRequest->isRejected())
                                        <i class="fas fa-times-circle fa-fw text-danger"></i>
                                    @elseif($reliefRequest->isApproved())
                                        <i class="fas fa-check-circle fa-fw text-success"></i>
                                    @else
                                        <i class="fas fa-search fa-fw text-warning"></i>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="mb-0 fw-bold">
                                            {{ $reliefRequest->isRejected() ? 'Request Rejected' : 'Request Review' }}
                                        </h6>
                                        @if($reliefRequest->isApproved() || $reliefRequest->isRejected())
                                            <span class="badge bg-success rounded-pill">
                                                <i class="fas fa-check me-1"></i>Completed
                                            </span>
                                        @elseif($reliefRequest->isPending())
                                            <span class="badge bg-warning rounded-pill text-dark">
                                                <i class="fas fa-spinner fa-pulse me-1"></i>In Progress
                                            </span>
                                        @endif
                                    </div>
                                    
                                    @if($reliefRequest->isApproved() || $reliefRequest->isRejected())
                                        <p class="text-muted small mb-1">
                                            <i class="far fa-clock me-1"></i>
                                            {{ $reliefRequest->approved_at ? $reliefRequest->approved_at->format('M d, Y h:i A') : 
                                               ($reliefRequest->rejected_at ? $reliefRequest->rejected_at->format('M d, Y h:i A') : 'N/A') }}
                                        </p>
                                        @if($reliefRequest->approver)
                                            <p class="small text-muted mb-1">
                                                <i class="fas fa-user-check me-1"></i>
                                                {{ $reliefRequest->approver->name }}
                                            </p>
                                        @endif
                                        @if($reliefRequest->isRejected() && $reliefRequest->rejection_reason)
                                            <div class="alert alert-danger p-2 mt-2 small" role="alert">
                                                <i class="fas fa-exclamation-circle me-1"></i>
                                                <strong>Reason:</strong> {{ $reliefRequest->rejection_reason }}
                                            </div>
                                        @endif
                                    @else
                                        <p class="text-muted small mb-0">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Awaiting admin review
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        @if($reliefRequest->isApproved())
                            <!-- Ready for Pickup -->
                            <div class="timeline-item {{ $reliefRequest->isReadyForPickup() || $reliefRequest->isClaimed() || $reliefRequest->isDelivered() ? 'completed' : '' }}">
                                <div class="d-flex">
                                    <div class="timeline-icon me-3">
                                        <i class="fas fa-box-open fa-fw text-info"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold">Ready for Pickup</h6>
                                            @if($reliefRequest->isReadyForPickup() || $reliefRequest->isClaimed() || $reliefRequest->isDelivered())
                                                <span class="badge bg-success rounded-pill">
                                                    <i class="fas fa-check me-1"></i>Completed
                                                </span>
                                            @endif
                                        </div>
                                        
                                        @if($reliefRequest->isReadyForPickup() || $reliefRequest->isClaimed() || $reliefRequest->isDelivered())
                                            <p class="text-muted small mb-1">
                                                <i class="far fa-clock me-1"></i>
                                                {{ $reliefRequest->ready_for_pickup_at->format('M d, Y h:i A') }}
                                            </p>
                                            @if($reliefRequest->preparedBy)
                                                <p class="small text-muted mb-1">
                                                    <i class="fas fa-user-tie me-1"></i>
                                                    {{ $reliefRequest->preparedBy->name }}
                                                </p>
                                            @endif
                                            @if($reliefRequest->delivery_method === 'pickup' && $reliefRequest->pickup_location)
                                                <div class="alert alert-info p-2 mt-2 small" role="alert">
                                                    <i class="fas fa-map-marker-alt me-1"></i>
                                                    <strong>Pickup Location:</strong> {{ $reliefRequest->pickup_location }}
                                                </div>
                                            @endif
                                        @else
                                            <p class="text-muted small mb-0">
                                                <i class="fas fa-spinner fa-pulse me-1"></i>
                                                Preparing your items...
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Claimed/Delivered -->
                            @if($reliefRequest->isClaimed() || $reliefRequest->isDelivered())
                                <div class="timeline-item {{ $reliefRequest->isClaimed() || $reliefRequest->isDelivered() ? 'completed' : '' }}">
                                    <div class="d-flex">
                                        <div class="timeline-icon me-3">
                                            <i class="fas {{ $reliefRequest->delivery_method === 'delivery' ? 'fa-truck' : 'fa-hand-holding-heart' }} fa-fw text-success"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <h6 class="mb-0 fw-bold">
                                                    {{ $reliefRequest->delivery_method === 'delivery' && $reliefRequest->isDelivered() ? 'Package Delivered' : 'Package Claimed' }}
                                                </h6>
                                                <span class="badge bg-success rounded-pill">
                                                    <i class="fas fa-check me-1"></i>Completed
                                                </span>
                                            </div>
                                            <p class="text-muted small mb-1">
                                                <i class="far fa-clock me-1"></i>
                                                {{ $reliefRequest->claimed_at ? $reliefRequest->claimed_at->format('M d, Y h:i A') : 
                                                   ($reliefRequest->delivered_at ? $reliefRequest->delivered_at->format('M d, Y h:i A') : 'N/A') }}
                                            </p>
                                            @if($reliefRequest->delivery_method === 'delivery' && $reliefRequest->delivered_by)
                                                <p class="small text-muted mb-0">
                                                    <i class="fas fa-user-shield me-1"></i>
                                                    Delivered by {{ $reliefRequest->deliveredBy->name ?? 'Staff' }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- QR Code -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-qrcode me-2"></i>Claim Code
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="qr-code-container mb-3">
                        @if($reliefRequest->qr_code_path && file_exists(public_path('storage/' . $reliefRequest->qr_code_path)))
                            <img src="{{ asset('storage/' . $reliefRequest->qr_code_path) }}" alt="QR Code" class="img-fluid qr-code">
                        @else
                            <div class="text-center p-4">
                                <i class="fas fa-qrcode fa-5x text-muted mb-3"></i>
                                <p class="mb-0">QR Code not generated</p>
                            </div>
                        @endif
                    </div>
                    <h4 class="mb-3 fw-bold">{{ $reliefRequest->claim_code }}</h4>
                    <p class="text-muted small mb-0">
                        Show this code to claim your relief items at the distribution center.
                    </p>
                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('admin.relief-requests.download-qr', $reliefRequest) }}" 
                           class="btn btn-outline-primary">
                            <i class="fas fa-download me-1"></i> Download QR Code
                        </a>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#printSlipModal">
                            <i class="fas fa-print me-1"></i> Print Claim Slip
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Request Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admin.relief-requests.reject', $reliefRequest) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Relief Request</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to reject this relief request? Please provide a reason for rejection.</p>
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label fw-bold">Reason for Rejection</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-1"></i> Reject Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Print Slip Modal -->
<div class="modal fade" id="printSlipModal" tabindex="-1" aria-labelledby="printSlipModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title" id="printSlipModalLabel">Print Claim Slip</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <iframe id="printFrame" src="{{ route('admin.relief-requests.print', $reliefRequest) }}" 
                        style="width: 100%; height: 70vh; border: none;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printSlip()">
                    <i class="fas fa-print me-1"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admin.relief-requests.destroy', $reliefRequest) }}" method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Relief Request</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this relief request? This action cannot be undone.</p>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="confirmDelete" required>
                        <label class="form-check-label fw-bold" for="confirmDelete">
                            I understand that this action is permanent
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" id="deleteButton" disabled>
                        <i class="fas fa-trash-alt me-1"></i> Delete Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Enable delete button when checkbox is checked
    document.getElementById('confirmDelete').addEventListener('change', function() {
        document.getElementById('deleteButton').disabled = !this.checked;
    });
    
    // Print slip function
    function printSlip() {
        const printFrame = document.getElementById('printFrame');
        printFrame.contentWindow.print();
    }
    
    // Auto-print when modal is shown (optional)
    document.getElementById('printSlipModal').addEventListener('shown.bs.modal', function () {
        // Uncomment to auto-print when the modal is opened
        // setTimeout(printSlip, 1000);
    });
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush