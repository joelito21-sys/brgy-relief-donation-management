<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Relief Assistance Request</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #ef4444; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9fafb; }
        .details { background: white; padding: 20px; border: 1px solid #e5e7eb; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 14px; }
        .urgency-high { color: #dc2626; font-weight: bold; }
        .urgency-medium { color: #d97706; font-weight: bold; }
        .urgency-low { color: #059669; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 100px; width: auto; margin-bottom: 15px;">
            <p style="font-size: 18px; font-weight: bold; margin: 0 0 10px;">Barangay Cubacub Relief and Donation Management Program</p>
            <h1>🆘 New Relief Request Received</h1>
        </div>
        
        <div class="content">
            <p><strong>Urgency Level:</strong> <span class="urgency-{{ $reliefRequest->urgency_level }}">{{ ucfirst($reliefRequest->urgency_level) }}</span></p>
            
            <div class="details">
                <h2>Request Details</h2>
                <p><strong>Resident:</strong> {{ $reliefRequest->full_name }}</p>
                <p><strong>Contact:</strong> {{ $reliefRequest->contact_number }}</p>
                <p><strong>Address:</strong> {{ $reliefRequest->complete_address }}, {{ $reliefRequest->city_municipality }}</p>
                <p><strong>Family Members:</strong> {{ $reliefRequest->household_size }}</p>
                
                <h3>Assistance Needed:</h3>
                <ul>
                    @foreach($reliefRequest->assistance_types as $type)
                        <li>{{ ucfirst($type) }}</li>
                    @endforeach
                </ul>
                
                <h3>Description:</h3>
                <p>{{ $reliefRequest->description }}</p>
                
                @if($reliefRequest->additional_message)
                    <h3>Additional Message:</h3>
                    <p>{{ $reliefRequest->additional_message }}</p>
                @endif
            </div>
            
            <p>Please review this request in the admin panel.</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>Request ID: {{ $reliefRequest->request_number }}</p>
        </div>
    </div>
</body>
</html>
