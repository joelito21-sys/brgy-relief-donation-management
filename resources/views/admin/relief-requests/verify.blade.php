@extends('admin.layouts.app')

@section('title', 'Verify Relief Request')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header bg-primary text-white py-4">
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            <i class="fas fa-qrcode fa-2x"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">Relief Request Verification</h4>
                            <p class="mb-0 small">Verify relief request using QR code</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($reliefRequest)
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <i class="fas fa-check-circle fa-3x text-success"></i>
                            </div>
                            <h5 class="mb-3">Valid Relief Request Found</h5>
                            <p class="text-muted">Request #{{ $reliefRequest->request_number }}</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="text-muted mb-1">Resident Name</h6>
                                    <p class="mb-0 fw-bold">{{ $reliefRequest->full_name ?? 'N/A' }}</p>
                                </div>
                                <div class="mb-3">
                                    <h6 class="text-muted mb-1">Contact Number</h6>
                                    <p class="mb-0">{{ $reliefRequest->contact_number ?? 'N/A' }}</p>
                                </div>
                                <div class="mb-3">
                                    <h6 class="text-muted mb-1">Family Members</h6>
                                    <p class="mb-0">{{ $reliefRequest->family_members ?? 'N/A' }} person(s)</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="text-muted mb-1">Request Status</h6>
                                    <span class="badge bg-{{ 
                                        $reliefRequest->status === 'pending' ? 'warning' : 
                                        ($reliefRequest->status === 'approved' ? 'primary' : 
                                        ($reliefRequest->status === 'ready_for_pickup' ? 'info' : 
                                        ($reliefRequest->status === 'claimed' ? 'success' : 'secondary'))) 
                                    }}">
                                        {{ ucfirst(str_replace('_', ' ', $reliefRequest->status)) }}
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <h6 class="text-muted mb-1">Delivery Method</h6>
                                    <p class="mb-0">{{ $reliefRequest->delivery_method_label ?? 'N/A' }}</p>
                                </div>
                                <div class="mb-3">
                                    <h6 class="text-muted mb-1">Claim Code</h6>
                                    <p class="mb-0 fw-bold">{{ $reliefRequest->claim_code }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h6 class="text-muted mb-2">Requested Items</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Item</th>
                                            <th class="text-end">Quantity</th>
                                            <th class="text-end">Unit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reliefRequest->items as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td class="text-end">{{ $item->pivot->quantity }}</td>
                                                <td class="text-end">{{ $item->unit }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="button" class="btn btn-success btn-lg" onclick="printSlip()">
                                <i class="fas fa-print me-2"></i>Print Claim Slip
                            </button>
                            <a href="{{ route('admin.relief-requests.index') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Relief Requests
                            </a>
                        </div>
                    @else
                        <div class="text-center">
                            <div class="mb-3">
                                <i class="fas fa-exclamation-triangle fa-3x text-warning"></i>
                            </div>
                            <h5 class="mb-3">Invalid Relief Request</h5>
                            <p class="text-muted">The relief request could not be found or is invalid.</p>
                            <a href="{{ route('admin.relief-requests.index') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Relief Requests
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function printSlip() {
        // This would typically open a print dialog or redirect to a print view
        alert('In a real implementation, this would print the claim slip.');
    }
</script>
@endsection