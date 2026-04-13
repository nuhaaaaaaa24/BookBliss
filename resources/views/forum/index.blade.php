<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum – BookBliss</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forum.css') }}">
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
            <a href="{{ route('forum') }}" class="active">Forum</a>
            <a href="{{ route('challenges') }}">Challenges</a>
            <a href="{{ route('profile') }}">Profile</a>
        </div>
    </nav>
    <hr>

    <header class="topbar">
        <h1>Community Forum</h1>
        <p>Share thoughts, recommendations &amp; bookish musings</p>
    </header>

    <main class="forum-main">

        {{-- ── Create Post ── --}}
        <section class="forum-compose">
            <h2 class="section-title">New Post</h2>
            <form method="POST" action="{{ route('posts.store') }}" class="compose-form">
                @csrf
                <input type="text"
                       name="title"
                       placeholder="Post title"
                       class="compose-input"
                       value="{{ old('title') }}"
                       required>
                <textarea name="body"
                          placeholder="Write something..."
                          class="compose-textarea"
                          required>{{ old('body') }}</textarea>
                <div class="compose-footer">
                    <button type="submit" class="btn-post">Post</button>
                </div>
            </form>
        </section>

        <div class="forum-divider"></div>

        {{-- ── Posts Feed ── --}}
        <section class="forum-feed">
            @forelse($posts as $post)
                <article class="post-card">

                    <div class="post-card__body">
                        <h3 class="post-card__title">{{ $post->title }}</h3>
                        <p class="post-card__content">{{ $post->body }}</p>
                    </div>

                    <div class="post-card__footer">
                        <div class="post-meta">
                            <span class="post-meta__avatar">{{ strtoupper(substr($post->user->first_name, 0, 1)) }}</span>
                            <span class="post-meta__name">{{ $post->user->first_name }}</span>
                            <span class="post-meta__dot">·</span>
                            <span class="post-meta__date">{{ $post->created_at->format('d M Y') }}</span>
                        </div>

                        <form method="POST" action="{{ route('posts.like', $post->id) }}" class="like-form">
                            @csrf
                            <button type="submit" class="btn-like">
                                <span class="like-icon">♥</span>
                                <span class="like-count">{{ $post->likes->count() }}</span>
                            </button>
                        </form>

                        <button type="button"
                                class="btn-comment-toggle"
                                onclick="toggleComments({{ $post->id }})">
                            💬 {{ $post->comments->count() }}
                        </button>
                    </div>
                    {{-- Comments Section --}}
                    <div class="post-comments" id="comments{{ $post->id }}" style="display:none;">

                        {{-- Add comment form --}}
                        <form method="POST" action="{{ route('posts.comment', $post->id) }}" class="comment-form">
                            @csrf
                            <input type="text" name="body" placeholder="Write a comment..." required>
                            <button type="submit">Send</button>
                        </form>

                        {{-- Comments list --}}
                        <div class="comments-list">

                            @foreach($post->comments as $comment)
                                <div class="comment">
                                    <span class="comment-user">
                                        {{ $comment->user->first_name }}
                                    </span>
                                    <span class="comment-body">
                                        {{ $comment->body }}
                                    </span>
                                </div>
                            @endforeach

                        </div>

                    </div>

                </article>
            @empty
                <div class="forum-empty">
                    <span>📜</span>
                    <p>No posts yet. Start the conversation!</p>
                </div>
            @endforelse
        </section>

    </main>
    <script>
        function toggleComments(id) {
            const box = document.getElementById('comments' + id);

            if (!box) return;

            box.style.display =
                (box.style.display === 'none' || box.style.display === '')
                ? 'block'
                : 'none';
        }
    </script>
</body>
</html>