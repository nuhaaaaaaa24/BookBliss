<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookBliss Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <h1>Welcome {{ auth()->user()->first_name }}!</h1>

        <hr>

        <!-- Dashboard Sections -->
        <div class="dashboard">
            <section>
                <h2>📚 My Bookshelf</h2>
            </section>

            <section>
                <h2>💬 Community Forum</h2>
            </section>

            <section>
                <h2>🏆 Challenges</h2>
            </section>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</body>
</html>