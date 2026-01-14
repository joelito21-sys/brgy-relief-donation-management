<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - Barangay Cubacub Relief and Donation Management Program</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 300;
        }
        .content {
            padding: 40px 30px;
        }
        .otp-container {
            background-color: #f8f9fa;
            border: 2px dashed #6c63ff;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 30px 0;
        }
        .otp-code {
            font-size: 36px;
            font-weight: bold;
            letter-spacing: 8px;
            color: #6c63ff;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        .footer p {
            margin: 5px 0;
            color: #6c757d;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #6c63ff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
            margin: 20px 0;
        }
        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 100px; width: auto; margin-bottom: 15px;">
            <h1>Barangay Cubacub Relief and Donation Management Program</h1>
            <p>Email Verification Required</p>
        </div>
        
        <div class="content">
            <h2>Hello {{ $user->name }},</h2>
            
            <p>Thank you for registering with the Flood Control System! To complete your registration and access your account, please verify your email address using the 6-digit code below.</p>
            
            <div class="otp-container">
                <h3>Your Verification Code</h3>
                <div class="otp-code">{{ $otp }}</div>
                <p><small>This code will expire in 30 minutes</small></p>
            </div>
            
            <div class="warning">
                <strong>🔒 Security Notice:</strong> Never share this verification code with anyone. Our team will never ask for your verification code via email or phone.
            </div>
            
            <p>If you didn't create an account with us, please ignore this email or contact our support team immediately.</p>
            
            <p>For your security, please enter this code on the verification page to complete your registration.</p>
        </div>
        
        <div class="footer">
            <p><strong>Barangay Cubacub Relief and Donation Management Program</strong></p>
            <p>Helping communities prepare and respond to flood emergencies</p>
            <p><small>This is an automated message. Please do not reply to this email.</small></p>
        </div>
    </div>
</body>
</html>