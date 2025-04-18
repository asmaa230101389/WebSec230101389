<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
    <p>Dear {{ $name }},</p>
    <p>Please click on the following link to verify your email address:</p>
    <p><a href="{{ $link }}" target="_blank">Verify Email</a></p>
    <p>If you did not create an account, no further action is required.</p>
    <p>Thank you,</p>
    <p>{{ config('app.name') }} Team</p>
</body>
</html>