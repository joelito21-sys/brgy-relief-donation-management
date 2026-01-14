@extends('layouts.admin')

@section('title', 'Notifications')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Notifications</h1>
    <div>
        <form action="{{ route('admin.notifications.clear-read') }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger" 
                    onclick="return confirm('Are you sure you want to clear all read notifications?')">
                <i class="fas fa-trash-alt fa-sm"></i> Clear Read
            </button>
        </form>
        <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST" class="d-inline ml-2" id="mark-all-read-form">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-check-circle fa-sm"></i> Mark All as Read
            </button>
        </form>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">All Notifications</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Filter:</div>
                        <a class="dropdown-item" href="{{ route('admin.notifications.index', ['filter' => 'all']) }}">All</a>
                        <a class="dropdown-item" href="{{ route('admin.notifications.index', ['filter' => 'unread']) }}">Unread Only</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" id="refresh-notifications">
                            <i class="fas fa-sync-alt fa-sm fa-fw mr-2 text-gray-400"></i>Refresh
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($notifications->isEmpty())
                    <div class="text-center py-4">
                        <i class="far fa-bell-slash fa-3x text-gray-300 mb-3"></i>
                        <p class="text-muted">No notifications found.</p>
                    </div>
                @else
                    <div class="list-group list-group-flush">
                        @foreach($notifications as $notification)
                            @php
                                $data = $notification->data;
                                $isUnread = is_null($notification->read_at);
                                $notificationClass = $isUnread ? 'bg-light' : '';
                                $icon = 'fa-bell';
                                $iconColor = 'text-primary';
                                
                                if (isset($data['type'])) {
                                    switch($data['type']) {
                                        case 'cash':
                                            $icon = 'fa-money-bill-wave';
                                            $iconColor = 'text-success';
                                            break;
                                        case 'food':
                                            $icon = 'fa-utensils';
                                            $iconColor = 'text-warning';
                                            break;
                                        case 'clothing':
                                            $icon = 'fa-tshirt';
                                            $iconColor = 'text-info';
                                            break;
                                        case 'medical':
                                            $icon = 'fa-medkit';
                                            $iconColor = 'text-danger';
                                            break;
                                    }
                                }
                                
                                $timeAgo = $notification->created_at->diffForHumans();
                                $url = $data['url'] ?? '#';
                                $amount = isset($data['amount']) ? '₱' . number_format($data['amount'], 2) : '';
                                $donorName = $data['donor_name'] ?? 'Anonymous';
                            @endphp
                            
                            <a href="{{ $url }}" class="list-group-item list-group-item-action {{ $notificationClass }} py-3" 
                               data-notification-id="{{ $notification->id }}">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        <i class="fas {{ $icon }} {{ $iconColor }} fa-2x"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">
                                                @if(isset($data['type']))
                                                    {{ ucfirst($data['type']) }} Donation 
                                                    @if(!empty($amount))
                                                        - {{ $amount }}
                                                    @endif
                                                @else
                                                    {{ $data['title'] ?? 'New Notification' }}
                                                @endif
                                                @if($isUnread)
                                                    <span class="badge badge-primary ml-2">New</span>
                                                @endif
                                            </h6>
                                            <small>{{ $timeAgo }}</small>
                                        </div>
                                        <p class="mb-1">
                                            @if(isset($data['message']))
                                                {{ $data['message'] }}
                                            @else
                                                {{ $donorName }} made a donation.
                                            @endif
                                        </p>
                                        @if(isset($data['reference_number']))
                                            <small class="text-muted">Reference: {{ $data['reference_number'] }}</small>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $notifications->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Mark notification as read when clicked
    document.querySelectorAll('[data-notification-id]').forEach(element => {
        element.addEventListener('click', function() {
            const notificationId = this.getAttribute('data-notification-id');
            if (notificationId) {
                fetch(`/admin/notifications/${notificationId}/mark-as-read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    credentials: 'same-origin'
                });
            }
        });
    });
    
    // Mark all as read form submission
    document.getElementById('mark-all-read-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-HTTP-Method-Override': 'PATCH',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({}),
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload the page to update the UI
                window.location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    });
    
    // Refresh notifications
    document.getElementById('refresh-notifications')?.addEventListener('click', function(e) {
        e.preventDefault();
        window.location.reload();
    });
    
    // Check for new notifications every 30 seconds
    setInterval(() => {
        fetch('{{ route("admin.notifications.unread-count") }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            const counter = document.getElementById('notification-counter');
            if (counter) {
                const currentCount = parseInt(counter.textContent) || 0;
                if (data.count > currentCount) {
                    // If there are new notifications, show a toast or update the counter
                    counter.textContent = data.count > 9 ? '9+' : data.count;
                    counter.classList.remove('d-none');
                    
                    // Optionally show a toast notification
                    // You can implement a toast notification system here
                }
            }
        })
        .catch(error => console.error('Error checking for new notifications:', error));
    }, 30000); // Check every 30 seconds
</script>
@endpush
