@extends('admin.layouts.app')

@section('title', 'Resident Requests Management')

@push('styles')
<style>
    .status-badge {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        font-weight: 500;
        border-radius: 9999px;
    }
    .status-pending { 
        background-color: #fef3c7; 
        color: #92400e; 
    }
    .status-approved { 
        background-color: #d1fae5; 
        color: #065f46; 
    }
    .status-for_delivery { 
        background-color: #dbeafe; 
        color: #1e40af; 
    }
    .status-completed { 
        background-color: #f3f4f6; 
        color: #374151; 
    }
    .status-rejected { 
        background-color: #fee2e2; 
        color: #991b1b; 
    }
    
    .urgency-badge {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        font-weight: 500;
        border-radius: 9999px;
    }
    .urgency-low { 
        background-color: #d1fae5; 
        color: #065f46; 
    }
    .urgency-medium { 
        background-color: #fef3c7; 
        color: #92400e; 
    }
    .urgency-high { 
        background-color: #fed7aa; 
        color: #9a3412; 
    }
    .urgency-critical { 
        background-color: #fee2e2; 
        color: #991b1b; 
    }
    
    .category-badge {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        font-weight: 500;
        border-radius: 9999px;
        background-color: #ede9fe;
        color: #5b21b6;
    }
    
    .priority-high { 
        border-left: 4px solid #dc3545; 
    }
    .priority-critical { 
        border-left: 4px solid #dc3545; 
        background-color: #fee2e2; 
    }
    
    .action-btn {
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 500;
        border-radius: 0.25rem;
        transition: background-color 0.2s ease-in-out;
    }
    .btn-approve { 
        background-color: #28a745; 
        color: white; 
    }
    .btn-approve:hover { 
        background-color: #218838; 
    }
    .btn-delivery { 
        background-color: #007bff; 
        color: white; 
    }
    .btn-delivery:hover { 
        background-color: #0069d9; 
    }
    .btn-complete { 
        background-color: #6c757d; 
        color: white; 
    }
    .btn-complete:hover { 
        background-color: #5a6268; 
    }
    .btn-reject { 
        background-color: #dc3545; 
        color: white; 
    }
    .btn-reject:hover { 
        background-color: #c82333; 
    }
    .btn-view { 
        background-color: #6610f2; 
        color: white; 
    }
    .btn-view:hover { 
        background-color: #520dc2; 
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif
    
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Resident Requests Management</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.requests.export') }}?{{ http_build_query(request()->query()) }}" class="btn btn-sm btn-success">
                <i class="fas fa-download mr-1"></i> Export
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Requests</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Approved</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['approved'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">For Delivery</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['for_delivery'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-truck fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-gray shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-gray-600 text-uppercase mb-1">Completed</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['completed'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Rejected</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['rejected'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filters</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.requests.index') }}">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="for_delivery" {{ request('status') == 'for_delivery' ? 'selected' : '' }}>For Delivery</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select name="category" id="category" class="form-select">
                            <option value="">All Categories</option>
                            <option value="goods" {{ request('category') == 'goods' ? 'selected' : '' }}>Goods/Items</option>
                            <option value="cash" {{ request('category') == 'cash' ? 'selected' : '' }}>Cash Assistance</option>
                            <option value="services" {{ request('category') == 'services' ? 'selected' : '' }}>Services</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="urgency_level" class="form-label">Urgency</label>
                        <select name="urgency_level" id="urgency_level" class="form-select">
                            <option value="">All Urgency Levels</option>
                            <option value="low" {{ request('urgency_level') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ request('urgency_level') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ request('urgency_level') == 'high' ? 'selected' : '' }}>High</option>
                            <option value="critical" {{ request('urgency_level') == 'critical' ? 'selected' : '' }}>Critical</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" name="search" id="search" class="form-control" placeholder="Request #, Name, Description..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="date_from" class="form-label">Date From</label>
                        <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="date_to" class="form-label">Date To</label>
                        <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter mr-1"></i> Apply Filters
                        </button>
                        <a href="{{ route('admin.requests.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times mr-1"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Separate Category Sections -->
    @php
        $cashRequests = $requests->where('category', 'cash');
        $goodsRequests = $requests->where('category', 'goods');
        $servicesRequests = $requests->where('category', 'services');
    @endphp

    <!-- Cash Assistance Requests -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-success text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-money-bill-wave mr-2"></i>
                Cash Assistance Requests ({{ $cashRequests->count() }})
            </h6>
        </div>
        <div class="card-body">
            @if($cashRequests->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Request #</th>
                                <th>Resident</th>
                                <th>Amount</th>
                                <th>Purpose</th>
                                <th>Urgency</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cashRequests as $request)
                                <tr>
                                    <td>
                                        <strong>{{ $request->request_number }}</strong>
                                        @if($request->supporting_documents && count($request->supporting_documents) > 0)
                                            <i class="fas fa-paperclip text-muted" title="{{ count($request->supporting_documents) }} document(s)"></i>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $request->resident->first_name }} {{ $request->resident->last_name }}
                                        <br>
                                        <small class="text-muted">{{ $request->resident->email }}</small>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-success">
                                            ₱{{ number_format($request->amount_requested ?? 0, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>{{ Str::limit($request->cash_purpose ?? $request->purpose, 50) }}</small>
                                    </td>
                                    <td>
                                        <span class="urgency-badge urgency-{{ $request->urgency_level }}">
                                            {{ ucfirst($request->urgency_level) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $request->status }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>{{ $request->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        @if($request->status === 'pending')
                                            <div class="btn-group btn-group-sm">
                                                <form action="{{ route('admin.requests.approve', $request) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success" title="Approve">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.requests.reject', $request) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger" title="Reject" onclick="return confirm('Reject this request?')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($request->status === 'approved')
                                            <form action="{{ route('admin.requests.markForDelivery', $request) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm" title="Mark for Delivery">
                                                    <i class="fas fa-truck mr-1"></i>For Delivery
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('admin.requests.show', $request) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-money-bill-wave fa-3x text-gray-300 mb-3"></i>
                    <p class="text-muted">No cash assistance requests found.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Goods & Items Requests -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-info text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-box mr-2"></i>
                Goods & Items Requests ({{ $goodsRequests->count() }})
            </h6>
        </div>
        <div class="card-body">
            @if($goodsRequests->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Request #</th>
                                <th>Resident</th>
                                <th>Items</th>
                                <th>Quantity</th>
                                <th>Urgency</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($goodsRequests as $request)
                                <tr>
                                    <td>
                                        <strong>{{ $request->request_number }}</strong>
                                        @if($request->supporting_documents && count($request->supporting_documents) > 0)
                                            <i class="fas fa-paperclip text-muted" title="{{ count($request->supporting_documents) }} document(s)"></i>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $request->resident->first_name }} {{ $request->resident->last_name }}
                                        <br>
                                        <small class="text-muted">{{ $request->resident->email }}</small>
                                    </td>
                                    <td>
                                        @if($request->items_requested)
                                            @foreach($request->items_requested as $item)
                                                <span class="badge bg-light text-dark">{{ $item['name'] ?? 'N/A' }}</span>
                                            @endforeach
                                        @else
                                            <small class="text-muted">No items specified</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($request->items_requested)
                                            {{ collect($request->items_requested)->sum('quantity') ?? 0 }} items
                                        @else
                                            <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="urgency-badge urgency-{{ $request->urgency_level }}">
                                            {{ ucfirst($request->urgency_level) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $request->status }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>{{ $request->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        @if($request->status === 'pending')
                                            <div class="btn-group btn-group-sm">
                                                <form action="{{ route('admin.requests.approve', $request) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success" title="Approve">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.requests.reject', $request) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger" title="Reject" onclick="return confirm('Reject this request?')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($request->status === 'approved')
                                            <form action="{{ route('admin.requests.markForDelivery', $request) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm" title="Mark for Delivery">
                                                    <i class="fas fa-truck mr-1"></i>For Delivery
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('admin.requests.show', $request) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-box fa-3x text-gray-300 mb-3"></i>
                    <p class="text-muted">No goods & items requests found.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Services Requests -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-purple text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-hands-helping mr-2"></i>
                Services Requests ({{ $servicesRequests->count() }})
            </h6>
        </div>
        <div class="card-body">
            @if($servicesRequests->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Request #</th>
                                <th>Resident</th>
                                <th>Service Type</th>
                                <th>Duration</th>
                                <th>Urgency</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($servicesRequests as $request)
                                <tr>
                                    <td>
                                        <strong>{{ $request->request_number }}</strong>
                                        @if($request->supporting_documents && count($request->supporting_documents) > 0)
                                            <i class="fas fa-paperclip text-muted" title="{{ count($request->supporting_documents) }} document(s)"></i>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $request->resident->first_name }} {{ $request->resident->last_name }}
                                        <br>
                                        <small class="text-muted">{{ $request->resident->email }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ ucfirst($request->service_type ?? 'Not specified') }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>{{ ucfirst($request->service_duration ?? 'Not specified') }}</small>
                                    </td>
                                    <td>
                                        <span class="urgency-badge urgency-{{ $request->urgency_level }}">
                                            {{ ucfirst($request->urgency_level) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $request->status }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>{{ $request->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        @if($request->status === 'pending')
                                            <div class="btn-group btn-group-sm">
                                                <form action="{{ route('admin.requests.approve', $request) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success" title="Approve">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.requests.reject', $request) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger" title="Reject" onclick="return confirm('Reject this request?')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($request->status === 'approved')
                                            <form action="{{ route('admin.requests.markForDelivery', $request) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm" title="Mark for Delivery">
                                                    <i class="fas fa-truck mr-1"></i>For Delivery
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('admin.requests.show', $request) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-hands-helping fa-3x text-gray-300 mb-3"></i>
                    <p class="text-muted">No services requests found.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
