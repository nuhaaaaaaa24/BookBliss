<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="auth-page">

<div class="container">
    <h2>Login</h2>
    @if($errors->has('login'))
        <div class="error-message">
            {{ $errors->first('login') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>
    <div class="link">
        Don't have an account? <a href="{{ route('register') }}">Register</a>
    </div>
</div>

</body>
</html>