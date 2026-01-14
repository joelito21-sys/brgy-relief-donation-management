@component('mail::layout')
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 100px; width: auto; margin-bottom: 5px; display: block; margin: 0 auto;">
            Barangay Cubacub Relief and Donation Management Program
        @endcomponent
    @endslot

    # Response to Your Inquiry

    Dear {{ $name }},

    Thank you for contacting us. Here is our response to your inquiry:

    ---

    {{ $responseContent }}

    ---

    ### Your Original Message:
    _{{ $originalMessage }}_

    If you have further questions, please do not hesitate to contact us.

    Thanks,<br>
    {{ config('app.name') }}

    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
