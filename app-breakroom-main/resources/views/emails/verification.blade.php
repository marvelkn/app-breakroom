<!DOCTYPE html>
<html>

<head>
    <title>Email Verification - Breakroom</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .otp-code {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            padding: 10px;
            margin: 20px 0;
            text-align: center;
            border: 2px solid #2563eb;
            border-radius: 5px;
        }

        .warning {
            color: #666;
            font-size: 14px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h2>Welcome to Breakroom!</h2>
    <p>Hello!</p>
    <p>Thank you for registering. To complete your registration, please use the following verification code:</p>

    <div>
        <h2>Verify Your Email</h2>
        <p>Your verification code is: {{ $verificationCode }}</p>
    </div>

    <p>This code will expire in 10 minutes for security purposes.</p>

    <p class="warning">
        If you didn't create an account on Breakroom, please ignore this email.
    </p>

    <p>Best regards,<br>The Breakroom Team</p>
</body>

</html>