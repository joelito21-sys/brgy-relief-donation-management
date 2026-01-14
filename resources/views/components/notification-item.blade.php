@props(['notification'])

@php
    $donation = $notification->data;
    $donationType = $donation['type'] ?? 'donation';
    $amount = isset($donation['amount']) ? '₱' . number_format($donation['amount'], 2) : '';
    $donorName = $donation['donor_name'] ?? 'Anonymous';
    $reference = $donation['reference_number'] ?? 'N/A';
    $paymentMethod = $donation['payment_method'] ? ucfirst(str_replace('_', ' ', $donation['payment_method'])) : 'N/A';
    
    // Set icon and color based on donation type
    $icon = 'fa-gift';
    $color = 'primary';
    
    if ($donationType === 'cash') {
        $icon = 'fa-money-bill-wave';
        $color = 'success';
    } elseif (in_array($donationType, ['food', 'clothing', 'medical'])) {
        $icon = 'fa-tshirt';
        if ($donationType === 'food') $icon = 'fa-utensils';
        if ($donationType === 'medical') $icon = 'fa-medkit';
        $color = 'info';
    }
    
    $timeAgo = $notification->created_at->diffForHumans();
    $url = $donation['url'] ?? '#';
@endphp

<a href="{{ $url }}" class="dropdown-item">
    <div class="d-flex align-items-center">
        <div class="mr-3">
            <div class="icon-circle bg-{{ $color }}">
                <i class="fas {{ $icon }} text-white"></i>
            </div>
        </div>
        <div>
            <div class="small text-gray-500">{{ $timeAgo }}</div>
            <span class="font-weight-bold">
                {{ ucfirst($donationType) }} Donation: {{ $amount }}
                @if($donationType === 'cash')
                    via {{ $paymentMethod }}
                @endif
            </span>
            <div class="text-muted small">
                From: {{ $donorName }}<br>
                @if($donationType === 'cash')
                    Ref: {{ $reference }}
                @else
                    {{ $donation['message'] ?? '' }}
                @endif
            </div>
        </div>
    </div>
</a>
@if(!$loop->last)
    <div class="dropdown-divider"></div>
@endif
