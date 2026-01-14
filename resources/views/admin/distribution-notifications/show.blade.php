@extends('admin.layouts.app')

@section('title', 'Distribution Notification Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-lg mt-4">
                <div class="card-header bg-gradient-primary text-white py-4 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            <i class="fas fa-bell fa-2x"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">Distribution Notification Details</h4>
                            <p class="mb-0 small">View detailed information about this notification</p>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('admin.distribution-notifications.index') }}" class="btn btn-light text-primary font-weight-bold">
                            <i class="fas fa-arrow-left mr-1"></i> Back to List
                        </a>
                        @if(isset($distributionNotification) && !$distributionNotification->is_sent)
                            <form action="{{ route('admin.distribution-notifications.send', $distributionNotification) }}" 
                                  method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success font-weight-bold" 
                                        onclick="return confirm('Are you sure you want to send this notification to all residents?')">
                                    <i class="fas fa-paper-plane mr-1"></i> Send Notification
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if(!isset($distributionNotification))
                        <div class="alert alert-danger">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle fa-lg mr-2"></i>
                                <div>
                                    <h4>Error: Notification Not Found</h4>
                                    <p>The requested notification could not be found.</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.distribution-notifications.index') }}" class="btn btn-primary">Back to List</a>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-8">
                                <!-- Notification Details -->
                                <div class="card mb-4 border rounded-lg">
                                    <div class="card-header bg-light py-3">
                                        <h6 class="mb-0 font-weight-bold text-primary">
                                            <i class="fas fa-info-circle mr-2"></i>Notification Information
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="30%"><strong>Title:</strong></td>
                                                <td>{{ $distributionNotification->title }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Message:</strong></td>
                                                <td>{{ $distributionNotification->message }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Type:</strong></td>
                                                <td>
                                                    <span class="badge badge-primary">
                                                        {{ ucfirst($distributionNotification->distribution_type) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Location:</strong></td>
                                                <td>{{ $distributionNotification->location }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Scheduled Date:</strong></td>
                                                <td>{{ $distributionNotification->formatted_scheduled_date }}</td>
                                            </tr>
                                            @if($distributionNotification->target_area)
                                                <tr>
                                                    <td><strong>Target Area:</strong></td>
                                                    <td>{{ $distributionNotification->target_area }}</td>
                                                </tr>
                                            @endif
                                            @if($distributionNotification->additional_info)
                                                <tr>
                                                    <td><strong>Additional Information:</strong></td>
                                                    <td>{{ $distributionNotification->additional_info }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td><strong>Status:</strong></td>
                                                <td>
                                                    @if($distributionNotification->is_sent)
                                                        <span class="badge badge-success">Sent</span>
                                                        <br>
                                                        <small class="text-muted">Sent on {{ $distributionNotification->sent_at->format('F j, Y \a\t g:i A') }}</small>
                                                    @else
                                                        <span class="badge badge-warning">Pending</span>
                                                        <br>
                                                        <small class="text-muted">Not yet sent to residents</small>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- Linked Information -->
                                @if($distributionNotification->distribution || $distributionNotification->reliefRequest)
                                    <div class="card mb-4 border rounded-lg">
                                        <div class="card-header bg-light py-3">
                                            <h6 class="mb-0 font-weight-bold text-primary">
                                                <i class="fas fa-link mr-2"></i>Linked Information
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            @if($distributionNotification->distribution)
                                                <div class="alert alert-info">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-dolly fa-lg mr-2"></i>
                                                        <div>
                                                            <strong>Linked Distribution:</strong> 
                                                            <a href="{{ route('admin.distributions.show', $distributionNotification->distribution) }}">
                                                                {{ $distributionNotification->distribution->title }}
                                                            </a>
                                                            <br>
                                                            <small>Status: {{ ucfirst($distributionNotification->distribution->status) }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            @if($distributionNotification->reliefRequest)
                                                <div class="alert alert-success">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-file-invoice fa-lg mr-2"></i>
                                                        <div>
                                                            <strong>Linked Relief Request:</strong> 
                                                            <a href="{{ route('admin.relief-requests.show', $distributionNotification->reliefRequest) }}">
                                                                {{ $distributionNotification->reliefRequest->request_number }}
                                                            </a>
                                                            <br>
                                                            <small>Resident: {{ $distributionNotification->reliefRequest->user->name }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Target Residents Information -->
                                <div class="card mb-4 border rounded-lg">
                                    <div class="card-header bg-light py-3">
                                        <h6 class="mb-0 font-weight-bold text-primary">
                                            <i class="fas fa-users mr-2"></i>Target Recipients
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-info">
                                            @if($distributionNotification->distribution_type === 'specific')
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-user mr-2"></i>
                                                    <div>
                                                        <strong>Specific Resident:</strong> Only the resident who made the relief request will be notified.
                                                    </div>
                                                </div>
                                            @else
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-users mr-2"></i>
                                                    <div>
                                                        <strong>General Distribution:</strong> 
                                                        @if($distributionNotification->target_area)
                                                            All approved residents in {{ $distributionNotification->target_area }} area.
                                                        @else
                                                            All approved residents in the system.
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Admin Information -->
                                <div class="card border rounded-lg mb-4">
                                    <div class="card-header bg-light py-3">
                                        <h6 class="mb-0 font-weight-bold text-primary">
                                            <i class="fas fa-user-shield mr-2"></i>Admin Information
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Created By:</strong></p>
                                        @if($distributionNotification->sentBy)
                                            <p>{{ $distributionNotification->sentBy->name }}</p>
                                            <p class="text-muted">{{ $distributionNotification->sentBy->email }}</p>
                                        @else
                                            <p class="text-muted">System</p>
                                        @endif
                                        
                                        <hr>
                                        
                                        <p><strong>Created:</strong></p>
                                        <p>{{ $distributionNotification->created_at->format('F j, Y \a\t g:i A') }}</p>
                                        
                                        @if($distributionNotification->updated_at->ne($distributionNotification->created_at))
                                            <p><strong>Last Updated:</strong></p>
                                            <p>{{ $distributionNotification->updated_at->format('F j, Y \a\t g:i A') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Actions -->
                                @if(!$distributionNotification->is_sent)
                                    <div class="card border rounded-lg">
                                        <div class="card-header bg-light py-3">
                                            <h6 class="mb-0 font-weight-bold text-primary">
                                                <i class="fas fa-cogs mr-2"></i>Actions
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('admin.distribution-notifications.send', $distributionNotification) }}" 
                                                  method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-block font-weight-bold mb-2" 
                                                        onclick="return confirm('Are you sure you want to send this notification to all target residents?')">
                                                    <i class="fas fa-paper-plane mr-1"></i> Send Now
                                                </button>
                                            </form>
                                            
                                            <hr>
                                            
                                            <a href="{{ route('admin.distribution-notifications.edit', $distributionNotification) }}" 
                                               class="btn btn-warning btn-block font-weight-bold mb-2">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </a>
                                            
                                            <form action="{{ route('admin.distribution-notifications.destroy', $distributionNotification) }}" 
                                                  method="POST" class="mt-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-block font-weight-bold" 
                                                        onclick="return confirm('Are you sure you want to delete this notification?')">
                                                    <i class="fas fa-trash mr-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection