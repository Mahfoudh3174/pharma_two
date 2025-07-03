
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset OTP</title>
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
            background-color: #4F46E5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .otp-code {
            background-color: #4F46E5;
            color: white;
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            letter-spacing: 8px;
        }
        .warning {
            background-color: #FEF3C7;
            border: 1px solid #F59E0B;
            color: #92400E;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Email Verification</h1>
    </div>
    
    <div class="content">
        <p>Hello{{ $userName ? ' ' . $userName : '' }},</p>
        
        <p>We received a request to verify your email. Use the following OTP (One-Time Password) to complete the email verification process:</p>
        
        <div class="otp-code">
            {{ $otp }}
        </div>
        
        <div class="warning">
            <strong>Important:</strong>
            <ul>
                <li>This OTP will expire in 10 minutes</li>
                <li>Do not share this OTP with anyone</li>
                <li>If you didn't request this email verification, please ignore this email</li>
            </ul>
        </div>
        
        <p>If you have any questions or need assistance, please contact our support team.</p>
        
        <p>Best regards,<br>Your Pharmacy Team</p>
    </div>
    
    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
    </div>
</body>
</html> 