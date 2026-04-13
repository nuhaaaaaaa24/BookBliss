<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile – BookBliss</title>
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
        <h1>Edit Profile</h1>
        <p>Update your details and reading interests</p>
    </header>

    <main class="edit-profile-main">

        @if(session('success'))
            <div class="flash flash--success">{{ session('success') }}</div>
        @endif

        <div class="edit-profile-card">

            <form method="POST" action="{{ route('profile.update') }}" class="edit-form">
                @csrf

                <div class="form-row">
                    <div class="edit-form__group">
                        <label for="first_name">First Name</label>
                        <input type="text"
                               id="first_name"
                               name="first_name"
                               value="{{ old('first_name', $user->first_name) }}"
                               placeholder="First Name"
                               required>
                        @error('first_name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="edit-form__group">
                        <label for="last_name">Last Name</label>
                        <input type="text"
                               id="last_name"
                               name="last_name"
                               value="{{ old('last_name', $user->last_name) }}"
                               placeholder="Last Name"
                               required>
                        @error('last_name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="edit-form__group">
                    <label for="bio">Bio</label>
                    <textarea id="bio"
                              name="bio"
                              placeholder="Tell the community a little about yourself...">{{ old('bio', $user->bio) }}</textarea>
                    @error('bio')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="edit-form__group">
                    <label for="interests">Reading Interests</label>
                    <input type="text"
                           id="interests"
                           name="interests"
                           value="{{ old('interests', $user->interests) }}"
                           placeholder="e.g. Fantasy, Historical Fiction, Sci-Fi">
                    <span class="form-hint">Separate genres or topics with commas.</span>
                    @error('interests')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="edit-form__footer">
                    <a href="{{ route('profile') }}" class="btn-back">← Back</a>
                    <button type="submit" class="btn-update">Save Changes</button>
                </div>

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