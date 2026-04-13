<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile – BookBliss</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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

    <header class="topbar">
        <h1>My Profile</h1>
        <p>Your reading identity</p>
    </header>

    <main class="profile-main">

        {{-- ── Hero: avatar + name + edit button all in one row ── --}}
        <div class="profile-hero">
            <div class="profile-avatar">
                {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
            </div>
            <div class="profile-identity">
                <h2 class="profile-name">{{ $user->first_name }} {{ $user->last_name }}</h2>
                <p class="profile-email">{{ $user->email }}</p>
            </div>
            <a href="{{ route('profile.edit') }}" class="btn-edit-profile">Edit Profile</a>
        </div>

        {{-- ── Bio & Interests side by side ── --}}
        <div class="profile-info-grid">

            <section class="profile-info-card profile-info-card--bio">
                <div class="profile-info-card__header">
                    <span class="profile-info-card__icon">📝</span>
                    <h3 class="profile-info-card__title">Bio</h3>
                </div>
                <p class="profile-info-card__body {{ is_null($user->bio) ? 'is-empty' : '' }}">
                    {{ $user->bio ?? 'No bio yet. Tell the community a little about yourself!' }}
                </p>
            </section>

            <section class="profile-info-card profile-info-card--interests">
                <div class="profile-info-card__header">
                    <span class="profile-info-card__icon">📚</span>
                    <h3 class="profile-info-card__title">Reading Interests</h3>
                </div>
                <p class="profile-info-card__body {{ is_null($user->interests) ? 'is-empty' : '' }}">
                    {{ $user->interests ?? 'No interests listed yet. What genres do you love?' }}
                </p>
            </section>

        </div>

        {{-- ── Account row ── --}}
        <div class="profile-account-row">
            <h3 class="profile-account-row__title">Account</h3>
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