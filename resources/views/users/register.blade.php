<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form id="registerForm" method="POST" action="{{ route('register') }}">
            @csrf
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
            <textarea name="bio" placeholder="Bio"></textarea>
            <input type="text" name="interests" placeholder="Interests (comma separated)">
            <button type="submit">Register</button>
        </form>
        <div class="link">
            Already have an account? <a href="{{ route('login') }}">Login</a>
        </div>
    </div>

    <script>
        const form = document.getElementById('registerForm');
        form.addEventListener('submit', (e) => {
            const pwd = form.password.value;
            const confirmPwd = form.password_confirmation.value;
            if(pwd !== confirmPwd){
                e.preventDefault();
                alert('Passwords do not match!');
            }
        });
    </script>
</body>
</html>