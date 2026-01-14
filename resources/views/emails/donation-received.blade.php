@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 100px; width: auto; margin-bottom: 5px; display: block; margin: 0 auto;">
            Barangay Cubacub Relief and Donation Management Program
        @endcomponent
    @endslot

    {{-- Body --}}
    # Thank You for Your {{ $donation->type_label }}

    Hello {{ $donation->donor_name }},

    @if($donation->isCashDonation())
        Thank you for your generous cash donation of **{{ $donation->formatted_amount }}**.
        
        **Payment Method:** {{ ucfirst(str_replace('_', ' ', $donation->payment_method)) }}
        
        @if($donation->donation_frequency !== 'one_time')
            Your **{{ $donation->donation_frequency }}** donation has been set up successfully.
        @endif
    @elseif($donation->isFoodDonation())
        Thank you for your food donation of **{{ $donation->quantity }} {{ $donation->unit }} of {{ $donation->food_name }}**.
    @elseif($donation->isClothingDonation())
        Thank you for your clothing donation of **{{ $donation->quantity }} items**.
        
        **Type:** {{ implode(', ', $donation->clothing_types) }}
        @if($donation->other_clothing_type)
            ({{ $donation->other_clothing_type }})
        @endif
    @elseif($donation->isMedicineDonation())
        Thank you for your medicine donation of **{{ $donation->medicine_name }} ({{ $donation->dosage }})**.
        
        **Quantity:** {{ $donation->quantity }} {{ $donation->form === 'other' ? $donation->other_form : $donation->form . 's' }}
        @if($donation->prescription_path)
            
            **Prescription:** [View Prescription]({{ $donation->prescriptionUrl }})
        @endif
    @endif

    ---

    ## Delivery Information

    @if($donation->delivery_method === 'pickup')
        You have chosen to deliver the items to our collection center. Please find the details below:
        
        **Location:** 123 Flood Relief Center, Barangay 123, City  
        **Hours:** Monday to Saturday, 9:00 AM - 5:00 PM
    @else
        We have scheduled a pickup for your donation:
        
        **Date:** {{ $donation->pickup_date->format('F j, Y') }}  
        **Time:** {{ $donation->pickup_time === 'morning' ? '9:00 AM - 12:00 PM' : '1:00 PM - 5:00 PM' }}  
        **Address:** {{ $donation->pickup_address }}
    @endif

    ---

    ## Next Steps

    - Our team will review your donation and may contact you if we need any additional information.
    - You will receive updates about the status of your donation.
    - If you have any questions, please reply to this email.

    Thank you for supporting our flood relief efforts. Your contribution will make a difference in the lives of those affected by the floods.

    @component('mail::button', ['url' => url('/donations/' . $donation->id)])
        View Donation Status
    @endcomponent

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
