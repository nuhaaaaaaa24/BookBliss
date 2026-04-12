<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookBliss Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="dashboard-page">
    <nav class="navbar">
        <div class="nav-left">
            <span class="logo">📖 BookBliss</span>
        </div>

        <div class="nav-links">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('bookshelf') }}">Bookshelf</a>
            <a href="{{ route('forum') }}">Forum</a>
            <a href="{{ route('challenges') }}">Challenges</a>
            <a href="{{ route('profile') }}">Profile</a>
        </div>
    </nav>
    <hr>
    <header class="topbar">
        <h1>Welcome {{ auth()->user()->first_name }}!</h1>
    </header>
    <!-- Dashboard Sections -->
   <main class="dashboard">
        <h2>📚 My Bookshelf</h2>

        <h2>💬 Community Forum</h2>

        <h2>🏆 Challenges</h2>
    </main>

</body>
</html>