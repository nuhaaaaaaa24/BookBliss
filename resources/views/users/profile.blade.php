<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile – BookBliss</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
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
            <a href="{{ route('profile') }}" class="active">Profile</a>
        </div>
    </nav>
    <hr>

    <header class="topbar profile-topbar">
        <h1>My Profile</h1>
        <p>Your reading identity</p>
    </header>

    <main class="profile-main">

        {{-- ── Profile Card ── --}}
        <div class="profile-card">

            {{-- Avatar --}}
            <div class="profile-avatar">
                {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
            </div>

            {{-- Name & Email --}}
            <div class="profile-identity">
                <h2 class="profile-name">{{ $user->first_name }} {{ $user->last_name }}</h2>
                <p class="profile-email">{{ $user->email }}</p>
            </div>

        </div>

        {{-- ── Bio & Interests ── --}}
        <div class="profile-sections">

            <section class="profile-section">
                <div class="profile-section__header">
                    <span class="profile-section__icon">📝</span>
                    <h3 class="profile-section__title">Bio</h3>
                </div>
                <p class="profile-section__content">
                    {{ $user->bio ?? 'No bio yet. Tell the community a little about yourself!' }}
                </p>
            </section>

            <section class="profile-section profile-section--alt">
                <div class="profile-section__header">
                    <span class="profile-section__icon">📚</span>
                    <h3 class="profile-section__title">Reading Interests</h3>
                </div>
                <p class="profile-section__content">
                    {{ $user->interests ?? 'No interests listed yet. What genres do you love?' }}
                </p>
            </section>

        </div>

        {{-- ── Account Actions ── --}}
        <div class="profile-actions">
            <h3 class="profile-actions__title">Account</h3>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>

    </main>

    <footer class="footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </footer>

</body>
</html>