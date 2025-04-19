<!DOCTYPE html>
<html>
<head>
    <title>Email Verified</title>
</head>
<body>
    <h2>Congratulations!</h2>
    <p>Dear {{ $user->name }}, your email {{ $user->email }} has been verified.</p>
    <p><a href="{{ route('login') }}">Go to Login</a></p>
</body>
</html>