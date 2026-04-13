<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookBliss – Home</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body class="dashboard-page">

    <nav class="navbar">
        <div class="nav-left">
            <span class="logo">📖 BookBliss</span>
        </div>
        <div class="nav-links">
            <a href="{{ route('home') }}" class="active">Home</a>
            <a href="{{ route('bookshelf') }}">Bookshelf</a>
            <a href="{{ route('forum') }}">Forum</a>
            <a href="{{ route('challenges') }}">Challenges</a>
            <a href="{{ route('profile') }}">Profile</a>
        </div>
    </nav>
    <hr>

    <header class="topbar home-topbar">
        <h1>Welcome back, {{ auth()->user()->first_name }}!</h1>
        <p>Here's what's been happening in your reading world</p>
    </header>

    <main class="home-main">

        {{-- ════════════════════
             MY BOOKS
        ════════════════════ --}}
        <section class="home-section">
            <div class="home-section__header">
                <h2 class="home-section__title"><span>📚</span> My Books</h2>
                <a href="{{ route('bookshelf') }}" class="home-section__link">View all →</a>
            </div>

            @if($books->isEmpty())
                <div class="home-empty">
                    <p>You haven't added any books yet.</p>
                    <a href="{{ route('bookshelf') }}" class="btn-empty">Go to Bookshelf</a>
                </div>
            @else
                <div class="books-row">
                    @foreach($books->take(5) as $book)
                        <div class="book-spine-card">
                            <div class="book-spine-card__cover">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}"
                                         alt="{{ $book->title }} cover">
                                @else
                                    <div class="book-spine-card__placeholder">
                                        {{ strtoupper(substr($book->title, 0, 1)) }}
                                    </div>
                                @endif
                                @if($book->status === 'reading')
                                    <span class="book-spine-card__badge">Reading</span>
                                @endif
                            </div>
                            <p class="book-spine-card__title">{{ Str::limit($book->title, 22) }}</p>
                            <p class="book-spine-card__author">{{ Str::limit($book->author, 18) }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- ════════════════════
             FORUM
        ════════════════════ --}}
        <section class="home-section">
            <div class="home-section__header">
                <h2 class="home-section__title"><span>💬</span> Forum</h2>
                <a href="{{ route('forum') }}" class="home-section__link">View all →</a>
            </div>

            @if($posts->isEmpty())
                <div class="home-empty">
                    <p>No posts yet. Start a conversation!</p>
                    <a href="{{ route('forum') }}" class="btn-empty">Go to Forum</a>
                </div>
            @else
                <div class="posts-list">
                    @foreach($posts->take(4) as $post)
                        <div class="post-row">
                            <div class="post-row__avatar">
                                {{ strtoupper(substr($post->user->first_name ?? '?', 0, 1)) }}
                            </div>
                            <div class="post-row__content">
                                <p class="post-row__title">{{ $post->title }}</p>
                                <p class="post-row__body">{{ Str::limit($post->body, 80) }}</p>
                                <div class="post-row__meta">
                                    <span>{{ $post->user->first_name ?? 'Unknown' }}</span>
                                    <span class="meta-sep">·</span>
                                    <span>{{ $post->created_at->format('d M Y') }}</span>
                                    <span class="meta-sep">·</span>
                                    <span>♥ {{ $post->likes->count() }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- ════════════════════
             CHALLENGES
        ════════════════════ --}}
        <section class="home-section home-section--last">
            <div class="home-section__header">
                <h2 class="home-section__title"><span>🏆</span> Challenges</h2>
                <a href="{{ route('challenges') }}" class="home-section__link">View all →</a>
            </div>

            @if($challenges->isEmpty())
                <div class="home-empty">
                    <p>No active challenges. Create one!</p>
                    <a href="{{ route('challenges') }}" class="btn-empty">Go to Challenges</a>
                </div>
            @else
                <div class="challenges-list">
                    @foreach($challenges->take(3) as $challenge)
                    @php
                        $daysLeft = \Carbon\Carbon::now()->diffInDays(
                            \Carbon\Carbon::parse($challenge->end_date),
                            false
                        );

                        $daysLeft = (int) $daysLeft;

                        $monthsLeft = intdiv($daysLeft, 30);
                        $remainingDays = $daysLeft % 30;
                    @endphp

                    <div class="challenge-row">
                        <div class="challenge-row__left">
                            <p class="challenge-row__name">{{ $challenge->name }}</p>
                            <p class="challenge-row__goal">{{ $challenge->goal }}</p>

                            <div class="challenge-row__meta">
                                <span>📅 {{ \Carbon\Carbon::parse($challenge->start_date)->format('d M') }}
                                    – {{ \Carbon\Carbon::parse($challenge->end_date)->format('d M Y') }}</span>
                                <span class="meta-sep">·</span>
                                <span>👥 {{ $challenge->participants->count() }} participants</span>
                            </div>
                        </div>

                        <div class="challenge-row__right">
                            @if($monthsLeft >= 1)
                                <span class="time-badge time-badge--active">{{ $monthsLeft }}mo left</span>
                            @elseif($daysLeft > 0)
                                <span class="time-badge time-badge--soon">{{ $daysLeft }}d left</span>
                            @else
                                <span class="time-badge time-badge--ended">Ended</span>
                            @endif
                        </div>
                    </div>
                @endforeach
                </div>
            @endif
        </section>

    </main>
</body>
</html>