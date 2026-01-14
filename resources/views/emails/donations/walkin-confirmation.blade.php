<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Walk-in Appointment Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #f97316; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9fafb; }
        .receipt { background: white; padding: 20px; border: 1px solid #e5e7eb; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 100px; width: auto; margin-bottom: 15px;">
            <p style="font-size: 18px; font-weight: bold; margin: 0 0 10px;">Barangay Cubacub Relief and Donation Management Program</p>
            <h1>📅 Appointment Confirmed</h1>
        </div>
        
        <div class="content">
            <p>Dear {{ $donation->donor_name }},</p>
            
            <p>Thank you for scheduling your visit. Your walk-in appointment has been confirmed.</p>
            
            <div class="receipt">
                <h2>📋 Appointment Details</h2>
                <p><strong>Appointment Date:</strong> {{ \Carbon\Carbon::parse($donation->payment_details['appointment_date'] ?? $donation->details['appointment_date'])->format('F j, Y') }}</p>
                <p><strong>Time:</strong> {{ $donation->payment_details['appointment_time'] ?? $donation->details['appointment_time'] }}</p>
                <p><strong>Purpose:</strong> {{ ucfirst(str_replace('_', ' ', $donation->payment_details['appointment_type'] ?? $donation->details['appointment_type'])) }}</p>
                <p><strong>Location:</strong> 123 Relief Street, Barangay Hall, Manila</p>
            </div>
            
            <p><strong>Things to bring:</strong></p>
            <ul>
                <li>Valid ID</li>
                <li>Your donation items (if applicable)</li>
                <li>This email confirmation</li>
            </ul>
            
            <p>If you need to reschedule or cancel, please contact us immediately.</p>
            
            <p>Thank you for your support!</p>
            
            <p>With gratitude,</p>
            <p>The Flood Relief Team</p>
            <p>{{ config('app.name') }}</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>Walk-in Appointment Ref: {{ $donation->reference_number }}</p>
        </div>
    </div>
</body>
</html>
