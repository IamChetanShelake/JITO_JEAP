<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP for Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f8f8ff;
            border-radius: 10px;
            padding: 30px;
            border: 1px solid #3E2B87;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #3E2B87;
            margin: 0;
        }
        .otp-box {
            background-color: #3E2B87;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>JITO JEAP</h1>
            <p>Educational Assistance Program</p>
        </div>

        <p>Hello,</p>
        
        <p>We received a request to reset your password. Please use the following OTP to verify your identity:</p>
        
        <div class="otp-box">
            {{ $otp }}
        </div>
        
        <p><strong>This OTP is valid for 10 minutes only.</strong></p>
        
        <p>If you did not request a password reset, please ignore this email or contact support if you have concerns.</p>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} JITO JEAP. All rights reserved.</p>
            <p>This is an automated email. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
