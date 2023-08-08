<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resend Verification Email</title>
</head>
<body>
    <div>
        <p>
            Before proceeding, please check your email for a verification link. If you did not receive the email,
        </p>
        
        
        <form method="POST" action="{{ route('user.verify.resend') }}">
            @csrf
            <label for="email">Enter your email:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Request Verification</button>
        </form>
    </div>
</body>
</html>
