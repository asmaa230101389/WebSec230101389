<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
</head>
<body>
    <h2>Hello, {{ $name }}</h2>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <p>
        <a href="{{ $resetLink }}" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">
            Reset Password
        </a>
    </p>
    <p>This password reset link will expire in 60 minutes.</p>
    <p>If you did not request a password reset, please ignore this email.</p>
    <p>Thank you,<br>WebSecService Team</p>
</body>
</html>