@extends('admin.layouts.app')

@section('title', 'Distribution Notifications')

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
                            <h4 class="mb-0">Distribution Notifications</h4>
                            <p class="mb-0 small">Manage and send distribution notifications to residents</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.distribution-notifications.create') }}" class="btn btn-light text-primary font-weight-bold">
                        <i class="fas fa-plus mr-1"></i> Create Notification
                    </a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle fa-lg mr-2"></i>
                                <div>{{ session('success') }}</div>
                            </div>
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle fa-lg mr-2"></i>
                                <div>{{ session('error') }}</div>
                            </div>
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Title & Message</th>
                                    <th>Type</th>
                                    <th>Location</th>
                                    <th>Scheduled Date</th>
                                    <th>Status</th>
                                    <th>Sent By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($notifications as $notification)
                                    <tr>
                                        <td>
                                            <strong>{{ $notification->title }}</strong>
                                            <br>
                                            <small class="text-muted">{{ Str::limit($notification->message, 50) }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">
                                                {{ ucfirst($notification->distribution_type) }}
                                            </span>
                                        </td>
                                        <td>{{ $notification->location }}</td>
                                        <td>{{ $notification->formatted_scheduled_date }}</td>
                                        <td>
                                            @if($notification->is_sent)
                                                <span class="badge badge-success">Sent</span>
                                                <br>
                                                <small class="text-muted">{{ $notification->sent_at->format('M d, Y h:i A') }}</small>
                                            @else
                                                <span class="badge badge-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($notification->sentBy)
                                                {{ $notification->sentBy->name }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.distribution-notifications.show', $notification) }}" 
                                                   class="btn btn-info" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                @if(!$notification->is_sent)
                                                    <form action="{{ route('admin.distribution-notifications.send', $notification) }}" 
                                                          method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success" 
                                                                onclick="return confirm('Are you sure you want to send this notification to all residents?')"
                                                                title="Send Notification">
                                                            <i class="fas fa-paper-plane"></i>
                                                        </button>
                                                    </form>
                                                    
                                                    <form action="{{ route('admin.distribution-notifications.destroy', $notification) }}" 
                                                          method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" 
                                                                onclick="return confirm('Are you sure you want to delete this notification?')"
                                                                title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No distribution notifications found</h5>
                                            <p class="text-muted">Get started by creating your first notification</p>
                                            <a href="{{ route('admin.distribution-notifications.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus mr-1"></i> Create First Notification
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection