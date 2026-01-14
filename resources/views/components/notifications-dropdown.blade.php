@php
    $notifications = auth()->user()->unreadNotifications()->latest()->take(10)->get();
    $unreadCount = auth()->user()->unreadNotifications->count();
    $hasUnread = $unreadCount > 0;
    $unreadClass = $hasUnread ? 'counter' : 'd-none';
    $emptyClass = $notifications->isEmpty() ? 'd-none' : '';
    $emptyMessageClass = $notifications->isEmpty() ? '' : 'd-none';
@endphp

<!-- Nav Item - Alerts -->
<li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <!-- Counter - Alerts -->
        <span class="badge badge-danger badge-counter {{ $unreadClass }}" id="notification-counter">
            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
        </span>
    </a>
    <!-- Dropdown - Alerts -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
        aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">
            Donation Notifications
        </h6>
        <div id="notification-items">
            @forelse($notifications as $notification)
                <x-notification-item :notification="$notification" />
            @empty
                <div class="dropdown-item text-center small text-gray-500">
                    No new notifications
                </div>
            @endforelse
        </div>
        <a class="dropdown-item text-center small text-gray-500" href="{{ route('admin.notifications') }}">
            Show All Notifications
        </a>
    </div>
</li>

@push('scripts')
<script>
    // Mark notifications as read when dropdown is shown
    document.getElementById('alertsDropdown').addEventListener('shown.bs.dropdown', function () {
        // Only mark as read if there are unread notifications
        if ({{ $unreadCount }} > 0) {
            fetch('{{ route("admin.notifications.mark-all-read") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the counter
                    const counter = document.getElementById('notification-counter');
                    if (counter) {
                        counter.classList.add('d-none');
                    }
                }
            })
            .catch(error => console.error('Error marking notifications as read:', error));
        }
    });

    // Listen for new donation notifications via Echo
    @if(config('broadcasting.default') === 'pusher')
        window.Echo.private('App.Models.User.' + {{ auth()->id() }})
            .notification((notification) => {
                // Update the notification counter
                const counter = document.getElementById('notification-counter');
                if (counter) {
                    const currentCount = parseInt(counter.textContent) || 0;
                    const newCount = currentCount + 1;
                    counter.textContent = newCount > 9 ? '9+' : newCount;
                    counter.classList.remove('d-none');
                }

                // Add the new notification to the top of the list
                const notificationItems = document.getElementById('notification-items');
                if (notificationItems) {
                    // Remove the "no notifications" message if it exists
                    const emptyMessage = notificationItems.querySelector('.text-center');
                    if (emptyMessage) {
                        emptyMessage.remove();
                    }

                    // Create a new notification item
                    const notificationItem = document.createElement('div');
                    notificationItem.innerHTML = `
                        <a href="${notification.url}" class="dropdown-item">
                            <div class="d-flex align-items-center">
                                <div class="mr-3">
                                    <div class="icon-circle bg-${notification.color || 'primary'}">
                                        <i class="fas ${notification.icon || 'fa-bell'} text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">Just now</div>
                                    <span class="font-weight-bold">${notification.title || 'New Notification'}</span>
                                    <div class="text-muted small">${notification.message || ''}</div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                    `;
                    
                    // Insert the new notification at the top
                    notificationItems.insertBefore(notificationItem.firstChild, notificationItems.firstChild);
                }
            });
    @endif
</script>
@endpush
