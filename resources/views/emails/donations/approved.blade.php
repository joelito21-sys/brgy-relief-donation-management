@component('mail::layout')
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 100px; width: auto; margin-bottom: 5px; display: block; margin: 0 auto;">
            Barangay Cubacub Relief and Donation Management Program
        @endcomponent
    @endslot

    <div style="max-width: 600px; margin: 0 auto; font-family: 'Arial', sans-serif; color: #2d3748;">
        <!-- Header with logo -->
        <div style="text-align: center; padding: 20px 0; border-bottom: 1px solid #e2e8f0;">
            <h1 style="color: #2d3748; margin: 0;">Thank You for Your Generous Donation!</h1>
        </div>

        <!-- Main content -->
        <div style="padding: 30px 20px;">
            <p style="font-size: 16px; line-height: 1.6; margin-bottom: 20px;">
                Dear {{ $donation->donor->name ?? 'Valued Donor' }},
            </p>

            <p style="font-size: 16px; line-height: 1.6; margin-bottom: 25px;">
                We are truly grateful for your generous donation. Your support helps us continue our mission and make a real difference in the lives of those we serve.
            </p>

            <!-- Donation Details -->
            <div style="background-color: #f8fafc; border-radius: 8px; padding: 20px; margin: 25px 0; border-left: 4px solid #4299e1;">
                <h2 style="color: #2d3748; margin-top: 0; margin-bottom: 15px; font-size: 18px;">Donation Details</h2>
                
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0; width: 40%; color: #718096;">Donation ID:</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0; font-weight: 600;">#{{ $donation->id }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0; color: #718096;">Type:</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0; font-weight: 600; text-transform: capitalize;">{{ $donation->type }}</td>
                    </tr>
                    @if($donation->type === 'cash')
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0; color: #718096;">Amount:</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0; font-weight: 600;">{{ number_format($donation->amount, 2) }} {{ $donation->currency ?? 'USD' }}</td>
                    </tr>
                    @else
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0; color: #718096;">Items:</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0; font-weight: 600;">{{ $donation->items_count ?? 1 }} items</td>
                    </tr>
                    @endif
                    <tr>
                        <td style="padding: 8px 0; color: #718096;">Date:</td>
                        <td style="padding: 8px 0; font-weight: 600;">{{ $donation->created_at->format('F j, Y') }}</td>
                    </tr>
                </table>
            </div>

            @if($donation->type === 'cash')
            <!-- Receipt Section -->
            <div style="background-color: #f0fff4; border-radius: 8px; padding: 20px; margin: 25px 0; border-left: 4px solid #48bb78;">
                <h2 style="color: #2d3748; margin-top: 0; margin-bottom: 15px; font-size: 18px;">Official Receipt</h2>
                <p style="margin: 10px 0; color: #2f855a;">
                    This email serves as your official receipt for tax purposes. Please keep it for your records.
                </p>
                <div style="margin-top: 15px;">
                    <p style="margin: 5px 0; font-size: 14px;"><strong>Organization:</strong> {{ config('app.name') }}</p>
                    <p style="margin: 5px 0; font-size: 14px;"><strong>Tax ID:</strong> [YOUR_TAX_ID]</p>
                    <p style="margin: 5px 0; font-size: 14px;"><strong>Payment Method:</strong> {{ $donation->payment_method ?? 'Not specified' }}</p>
                    <p style="margin: 5px 0; font-size: 14px;"><strong>Status:</strong> <span style="color: #38a169; font-weight: 600;">Approved</span></p>
                </div>
                <p style="font-style: italic; margin: 15px 0 0; font-size: 13px; color: #718096;">
                    * This receipt is valid for tax purposes in accordance with applicable laws.
                </p>
            </div>
            @endif

            <!-- Thank you message -->
            <div style="margin: 30px 0; text-align: center;">
                <p style="font-size: 16px; line-height: 1.6; margin-bottom: 20px;">
                    Your generosity is making a real difference. Thank you for being part of our mission!
                </p>
                @component('mail::button', ['url' => url('/donations/' . $donation->id), 'color' => 'primary'])
                    View Your Donation
                @endcomponent
            </div>
        </div>

        <!-- Footer -->
        <div style="text-align: center; padding: 20px; background-color: #f8fafc; border-top: 1px solid #e2e8f0; font-size: 14px; color: #718096;">
            <p style="margin: 0 0 10px 0;">
                If you have any questions about your donation, please contact our support team at
                <a href="mailto:support@example.com" style="color: #4299e1; text-decoration: none;">support@example.com</a>
            </p>
            <p style="margin: 0;">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>

    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
