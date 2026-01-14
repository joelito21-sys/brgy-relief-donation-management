@component('mail::layout')
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 100px; width: auto; margin-bottom: 5px; display: block; margin: 0 auto;">
            Barangay Cubacub Relief and Donation Management Program
        @endcomponent
    @endslot

    # New Contact Message Received

    **From:** {{ $name }} ({{ $email }})
    **Subject:** {{ $subject }}

    ## Message:

    {{ $messageContent }}

    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
