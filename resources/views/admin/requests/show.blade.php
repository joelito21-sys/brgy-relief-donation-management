@extends('layouts.admin')

@section('title', 'Request Details - ' . $request->request_number)

@push('styles')
<style>
    .status-badge {
        @apply px-3 py-1 text-sm font-medium rounded-full;
    }
    .status-pending { @apply bg-yellow-100 text-yellow-800; }
    .status-approved { @apply bg-green-100 text-green-800; }
    .status-for_delivery { @apply bg-blue-100 text-blue-800; }
    .status-completed { @apply bg-gray-100 text-gray-800; }
    .status-rejected { @apply bg-red-100 text-red-800; }
    
    .urgency-badge {
        @apply px-3 py-1 text-sm font-medium rounded-full;
    }
    .urgency-low { @apply bg-green-100 text-green-800; }
    .urgency-medium { @apply bg-yellow-100 text-yellow-800; }
    .urgency-high { @apply bg-orange-100 text-orange-800; }
    .urgency-critical { @apply bg-red-100 text-red-800; }
    
    .category-badge {
        @apply px-3 py-1 text-sm font-medium rounded-full bg-purple-100 text-purple-800;
    }
    
    .priority-bar {
        @apply bg-gray-200 rounded-full h-4 overflow-hidden;
    }
    .priority-fill {
        @apply h-full transition-all duration-300;
    }
    
    .document-card {
        @apply border rounded-lg p-3 hover:shadow-md transition-shadow duration-200;
    }
    
    .action-btn {
        @apply px-4 py-2 font-medium rounded transition-colors duration-200;
    }
    .btn-approve { @apply bg-green-600 hover:bg-green-700 text-white; }
    .btn-delivery { @apply bg-blue-600 hover:bg-blue-700 text-white; }
    .btn-complete { @apply bg-gray-600 hover:bg-gray-700 text-white; }
    .btn-reject { @apply bg-red-600 hover:bg-red-700 text-white; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Request Details</h1>
            <p class="text-gray-600">Request #{{ $request->request_number }}</p>
        </div>
        <div>
            <a href="{{ route('admin.requests.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> Back to Requests
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Request Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Request Information</h6>
                    <div class="d-flex gap-2">
                        <span class="category-badge">{{ $request->category_display }}</span>
                        <span class="urgency-badge urgency-{{ $request->urgency_level }}">
                            {{ ucfirst($request->urgency_level) }} Priority
                        </span>
                        <span class="status-badge status-{{ $request->status }}">
                            {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-gray-700">Request Details</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Request Number:</strong></td>
                                    <td>{{ $request->request_number }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Type:</strong></td>
                                    <td>{{ ucfirst($request->type) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Subcategory:</strong></td>
                                    <td>{{ $request->subcategory ? ucfirst(str_replace('_', ' ', $request->subcategory)) : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Submitted:</strong></td>
                                    <td>{{ $request->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                @if($request->completed_at)
                                    <tr>
                                        <td><strong>Completed:</strong></td>
                                        <td>{{ $request->completed_at->format('M d, Y h:i A') }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-gray-700">Priority Assessment</h6>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Priority Score:</span>
                                    <span class="font-weight-bold">{{ $request->priority_score }}/100</span>
                                </div>
                                <div class="priority-bar">
                                    <div class="priority-fill bg-{{ $request->urgency_color === 'red' ? 'danger' : ($request->urgency_color === 'orange' ? 'warning' : ($request->urgency_color === 'yellow' ? 'info' : 'success')) }}" 
                                         style="width: {{ $request->priority_score }}%"></div>
                                </div>
                            </div>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Verified:</strong></td>
                                    <td>
                                        @if($request->is_verified)
                                            <span class="text-success">
                                                <i class="fas fa-check-circle"></i> 
                                                Yes ({{ $request->verified_at->format('M d, Y') }})
                                            </span>
                                            @if($request->verifiedBy)
                                                by {{ $request->verifiedBy->name }}
                                            @endif
                                        @else
                                            <span class="text-muted">
                                                <i class="fas fa-times-circle"></i> No
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Delivery Method:</strong></td>
                                    <td>{{ ucfirst($request->preferred_delivery_method) }}</td>
                                </tr>
                                @if($request->assigned_to)
                                    <tr>
                                        <td><strong>Assigned To:</strong></td>
                                        <td>{{ $request->assignedTo->name ?? 'N/A' }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-4">
                        <h6 class="text-gray-700">Description</h6>
                        <p class="text-gray-600">{{ $request->description }}</p>
                    </div>

                    <!-- Purpose -->
                    <div class="mt-4">
                        <h6 class="text-gray-700">Purpose of Request</h6>
                        <p class="text-gray-600">{{ $request->purpose }}</p>
                    </div>

                    <!-- Impact Description -->
                    <div class="mt-4">
                        <h6 class="text-gray-700">Impact Description</h6>
                        <p class="text-gray-600">{{ $request->impact_description }}</p>
                    </div>

                    <!-- Special Instructions -->
                    @if($request->special_instructions)
                        <div class="mt-4">
                            <h6 class="text-gray-700">Special Instructions</h6>
                            <p class="text-gray-600">{{ $request->special_instructions }}</p>
                        </div>
                    @endif

                    <!-- Admin Notes -->
                    @if($request->admin_notes)
                        <div class="mt-4">
                            <h6 class="text-gray-700">Admin Notes</h6>
                            <div class="bg-light p-3 rounded">
                                <p class="text-gray-600 mb-0">{{ $request->admin_notes }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Request Details Based on Category -->
            @if($request->is_cash_request())
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Cash Assistance Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-gray-700">Amount Requested</h6>
                                <h3 class="text-success">{{ $request->formatted_amount }}</h3>
                            </div>
                            @if($request->cash_purpose)
                                <div class="col-md-6">
                                    <h6 class="text-gray-700">Purpose of Funds</h6>
                                    <p class="text-gray-600">{{ ucfirst(str_replace('_', ' ', $request->cash_purpose)) }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @elseif($request->is_goods_request())
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Items Requested</h6>
                    </div>
                    <div class="card-body">
                        @if($request->items_requested && count($request->items_requested) > 0)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Quantity</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($request->items_requested as $item)
                                            <tr>
                                                <td>{{ $item['name'] }}</td>
                                                <td>{{ $item['quantity'] }}</td>
                                                <td>{{ $item['description'] ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">No specific items listed</p>
                        @endif
                    </div>
                </div>
            @elseif($request->category === 'services')
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Service Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($request->service_type)
                                <div class="col-md-6">
                                    <h6 class="text-gray-700">Service Type</h6>
                                    <p class="text-gray-600">{{ ucfirst(str_replace('_', ' ', $request->service_type)) }}</p>
                                </div>
                            @endif
                            @if($request->service_duration)
                                <div class="col-md-6">
                                    <h6 class="text-gray-700">Service Duration</h6>
                                    <p class="text-gray-600">{{ ucfirst($request->service_duration) }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Supporting Documents -->
            @if($request->supporting_documents && count($request->supporting_documents) > 0)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Supporting Documents</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($request->supporting_documents as $index => $document)
                                <div class="col-md-6 mb-3">
                                    <div class="document-card">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">{{ $document['original_name'] }}</h6>
                                                <small class="text-muted">
                                                    {{ number_format($document['size'] / 1024, 2) }} KB
                                                </small>
                                            </div>
                                            <a href="{{ route('admin.requests.download-document', [$request->id, $index]) }}" 
                                               class="btn btn-sm btn-primary" target="_blank">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Resident Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Resident Information</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if($request->resident->id_photo)
                            <img src="{{ Storage::url($request->resident->id_photo) }}" 
                                 alt="ID Photo" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-gray-200 d-inline-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-user fa-2x text-gray-400"></i>
                            </div>
                        @endif
                    </div>
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $request->resident->first_name }} {{ $request->resident->last_name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $request->resident->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Phone:</strong></td>
                            <td>{{ $request->resident->phone_number ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                <span class="status-badge status-{{ $request->resident->status }}">
                                    {{ ucfirst($request->resident->status) }}
                                </span>
                            </td>
                        </tr>
                        @if($request->resident->area)
                            <tr>
                                <td><strong>Area:</strong></td>
                                <td>{{ $request->resident->area->name ?? 'N/A' }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

            <!-- Delivery Address -->
            @if($request->delivery_address)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Delivery Address</h6>
                    </div>
                    <div class="card-body">
                        @if(is_array($request->delivery_address))
                            <p class="mb-0">
                                {{ $request->delivery_address['line1'] ?? '' }}<br>
                                {{ $request->delivery_address['line2'] ?? '' }}<br>
                                {{ $request->delivery_address['city'] ?? '' }}, {{ $request->delivery_address['province'] ?? '' }}<br>
                                {{ $request->delivery_address['postal_code'] ?? '' }}
                            </p>
                        @else
                            <p class="mb-0">{{ $request->delivery_address }}</p>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
                </div>
                <div class="card-body">
                    @if($request->status === 'pending')
                        <form action="{{ route('admin.requests.approve', $request->id) }}" method="POST" class="mb-2">
                            @csrf
                            <input type="hidden" name="_method" value="PATCH">
                            <button type="submit" class="btn action-btn btn-approve w-100" onclick="return confirm('Approve this request?')">
                                <i class="fas fa-check mr-2"></i>Approve Request
                            </button>
                        </form>
                        <button type="button" class="btn action-btn btn-reject w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="fas fa-times mr-2"></i>Reject Request
                        </button>
                    @elseif($request->status === 'approved')
                        <form action="{{ route('admin.requests.for-delivery', $request->id) }}" method="POST" class="mb-2">
                            @csrf
                            <input type="hidden" name="_method" value="PATCH">
                            <button type="submit" class="btn action-btn btn-delivery w-100" onclick="return confirm('Mark this request for delivery?')">
                                <i class="fas fa-truck mr-2"></i>Mark for Delivery
                            </button>
                        </form>
                    @elseif($request->status === 'for_delivery')
                        <form action="{{ route('admin.requests.complete', $request->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="PATCH">
                            <button type="submit" class="btn action-btn btn-complete w-100" onclick="return confirm('Mark this request as completed?')">
                                <i class="fas fa-check-circle mr-2"></i>Mark as Completed
                            </button>
                        </form>
                    @elseif($request->status === 'completed')
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle mr-2"></i>
                            This request has been completed on {{ $request->completed_at->format('M d, Y h:i A') }}
                        </div>
                    @elseif($request->status === 'rejected')
                        <div class="alert alert-danger">
                            <i class="fas fa-times-circle mr-2"></i>
                            This request has been rejected.
                        </div>
                    @endif

                    <!-- Update Status Form -->
                    <div class="mt-3">
                        <form action="{{ route('admin.requests.update-status', $request->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="PATCH">
                            <div class="mb-2">
                                <label for="status" class="form-label">Update Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="{{ $request->status }}" selected>{{ ucfirst(str_replace('_', ' ', $request->status)) }}</option>
                                    @if($request->status !== 'pending')
                                        <option value="pending">Pending</option>
                                    @endif
                                    @if($request->status !== 'approved')
                                        <option value="approved">Approved</option>
                                    @endif
                                    @if($request->status !== 'for_delivery')
                                        <option value="for_delivery">For Delivery</option>
                                    @endif
                                    @if($request->status !== 'completed')
                                        <option value="completed">Completed</option>
                                    @endif
                                    @if($request->status !== 'rejected')
                                        <option value="rejected">Rejected</option>
                                    @endif
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="admin_notes" class="form-label">Admin Notes</label>
                                <textarea name="admin_notes" id="admin_notes" class="form-control" rows="2">{{ $request->admin_notes }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save mr-2"></i>Update Status
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Reject Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.requests.reject', $request->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Rejection Reason *</label>
                        <textarea name="rejection_reason" id="rejection_reason" class="form-control" rows="4" required placeholder="Please provide a reason for rejecting this request..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times mr-2"></i>Reject Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
