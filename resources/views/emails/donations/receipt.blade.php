<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thank You for Your Donation - Flood Relief PH</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4a86e8;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .donation-details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #777;
            text-align: center;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4a86e8;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 100px; width: auto; margin-bottom: 15px;">
        <p style="font-size: 18px; font-weight: bold; margin: 0 0 10px;">Barangay Cubacub Relief and Donation Management Program</p>
        <h1>Thank You for Your Generous Donation!</h1>
    </div>
    
    <div class="content">
        <p>Dear {{ $user->name ?? 'Valued Donor' }},</p>
        
        <p>On behalf of the entire Flood Relief PH team, we want to express our deepest gratitude for your generous donation. Your support helps us continue our mission to provide assistance to those affected by floods and natural disasters.</p>
        
        <div class="donation-details">
            <h3>Donation Details</h3>
            <p><strong>Donation ID:</strong> #{{ $donation->id ?? 'N/A' }}</p>
            <p><strong>Date:</strong> {{ $donation->created_at->format('F j, Y') ?? now()->format('F j, Y') }}</p>
            <p><strong>Amount:</strong> ₱{{ number_format($donation->amount ?? 0, 2) }}</p>
            <p><strong>Payment Method:</strong> {{ $donation->payment_method ?? 'N/A' }}</p>
            @if(isset($donation->reference_number))
                <p><strong>Reference Number:</strong> {{ $donation->reference_number }}</p>
            @endif
        </div>
        
        <p>Your donation will be used to provide essential resources such as food, clean water, shelter, and medical assistance to those in need.</p>
        
        <p>If you have any questions about your donation or would like to get more involved with our cause, please don't hesitate to contact us at <a href="mailto:contact@floodrelief.ph">contact@floodrelief.ph</a>.</p>
        
        <div style="text-align: center; margin: 25px 0;">
            <a href="{{ route('donor.dashboard') }}" class="button">View Your Donation History</a>
        </div>
        
        <p>Once again, thank you for your support. Together, we can make a difference in the lives of those affected by natural disasters.</p>
        
        <p>With gratitude,<br>
        <strong>The Flood Relief PH Team</strong></p>
        
        <div class="footer">
            <p>© {{ date('Y') }} Flood Relief PH. All rights reserved.</p>
            <p>123 Help Street, Quezon City, Philippines</p>
            <p>Email: contact@floodrelief.ph | Phone: +63 2 1234 5678</p>
        </div>
    </div>
</body>
</html>
