<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Contact Form Submission</title>
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
            background-color: #393186;
            color: #FFD800;
            padding: 20px;
            text-align: center;
        }
        .content {
            background-color: #f4f4f4;
            padding: 20px;
            margin-top: 20px;
        }
        .field {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            color: #393186;
        }
        .value {
            margin-top: 5px;
            padding: 10px;
            background-color: #fff;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>New Contact Form Submission - JITO JEAP</h2>
    </div>
    
    <div class="content">
        <div class="field">
            <div class="label">Name:</div>
            <div class="value">{{ $name }}</div>
        </div>
        
        <div class="field">
            <div class="label">Email:</div>
            <div class="value">{{ $email }}</div>
        </div>
        
        <div class="field">
            <div class="label">Phone:</div>
            <div class="value">{{ $phone ?? 'N/A' }}</div>
        </div>
        
        <div class="field">
            <div class="label">Subject:</div>
            <div class="value">{{ $subject ?? 'N/A' }}</div>
        </div>
        
        <div class="field">
            <div class="label">Message:</div>
            <div class="value">{{ $userMessage }}</div>
        </div>
    </div>
    
    <div class="footer">
        <p>This email was sent from the JITO JEAP contact form.</p>
    </div>
</body>
</html>
