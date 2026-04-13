<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenges – BookBliss</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/challenges.css') }}">
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
            <a href="{{ route('challenges') }}" class="active">Challenges</a>
            <a href="{{ route('profile') }}">Profile</a>
        </div>
    </nav>
    <hr>

    <header class="topbar challenges-topbar">
        <h1>Reading Challenges</h1>
        <p>{{ $challenges->count() }} {{ Str::plural('challenge', $challenges->count()) }} running · join one or create your own</p>
    </header>

    @if(session('success'))
        <div class="flash flash--success">{{ session('success') }}</div>
    @endif

    <main class="challenges-main">

        @if($challenges->isEmpty())
            <div class="shelf-empty">
                <span class="shelf-empty__icon">🏆</span>
                <p>No challenges yet. Be the first to start one!</p>
            </div>
        @else
            <div class="challenges-grid">
                @foreach($challenges as $challenge)
                    <article class="challenge-card">

                        <div class="challenge-card__ribbon"></div>

                        <div class="challenge-card__body">
                            @if($challenge->is_private)
                                <span class="badge-private">🔒 Private</span>
                            @else
                                <span class="badge-public">🌍 Public</span>
                            @endif
                            <h3 class="challenge-card__name">{{ $challenge->name }}</h3>
                            <p class="challenge-card__goal">{{ $challenge->goal }}</p>
                        </div>

                        <div class="challenge-card__meta">
                            <div class="meta-item">
                                <span class="meta-icon">📅</span>
                                <span>{{ \Carbon\Carbon::parse($challenge->start_date)->format('d M') }}
                                    – {{ \Carbon\Carbon::parse($challenge->end_date)->format('d M Y') }}</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-icon">👥</span>
                                <span>{{ $challenge->participants->count() }} {{ Str::plural('participant', $challenge->participants->count()) }}</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-icon">⏳</span>
                                @php
                                    $monthsLeft = floor(now()->diffInMonths(\Carbon\Carbon::parse($challenge->end_date), false));
                                @endphp

                                @if($monthsLeft > 0)
                                    <span>{{ $monthsLeft }} {{ $monthsLeft == 1 ? 'month' : 'months' }} left</span>
                                @else
                                    <span class="meta-ended">Ended</span>
                                @endif
                            </div>
                        </div>

                        <div class="challenge-card__footer">

                            {{-- CREATOR --}}
                            @if($challenge->user_id === auth()->id())

                                <form method="POST"
                                    action="{{ route('challenges.delete', $challenge->id) }}"
                                    id="deleteChallenge{{ $challenge->id }}">

                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                            class="btn-delete"
                                            onclick="showDeleteChallenge({{ $challenge->id }})">
                                        Delete
                                    </button>

                                    <div id="confirmChallenge{{ $challenge->id }}"
                                        class="delete-confirm"
                                        style="display:none;">
                                        <span>Delete this challenge?</span>

                                        <button type="submit" class="btn-confirm-yes">Yes</button>
                                        <button type="button"
                                                class="btn-confirm-no"
                                                onclick="hideDeleteChallenge({{ $challenge->id }})">
                                            No
                                        </button>
                                    </div>
                                </form>

                            @else

                                {{-- NON-CREATOR USERS ONLY --}}

                                @if($challenge->is_private)

                                    {{-- PRIVATE CHALLENGE --}}
                                    <span class="locked-text">🔒 Private Challenge</span>

                                @else

                                    {{-- PUBLIC CHALLENGE --}}
                                    @if($challenge->participants->contains(auth()->id()))

                                        <form method="POST" action="{{ route('challenges.leave', $challenge->id) }}">
                                            @csrf
                                            <button type="submit" class="btn-leave">Leave</button>
                                        </form>

                                    @else

                                        <form method="POST" action="{{ route('challenges.join', $challenge->id) }}">
                                            @csrf
                                            <button type="submit" class="btn-join">Join Challenge</button>
                                        </form>

                                    @endif

                                @endif

                            @endif

                        </div>

                    </article>
                @endforeach
            </div>
        @endif
    </main>

    <button class="fab" id="openModal" aria-label="Create a new challenge">+</button>

    <div class="modal-overlay" id="modalOverlay">
        <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
            <div class="modal__header">
                <h2 id="modalTitle">Create a Challenge</h2>
                <button class="modal__close" id="closeModal" aria-label="Close">&times;</button>
            </div>
            <form method="POST" action="{{ route('challenges.store') }}" class="modal__form" id="challengeForm">
                @csrf
                <div class="form-group">
                    <label for="name">Challenge Name</label>
                    <input type="text" id="name" name="name" placeholder="e.g. Summer Reading Sprint" required value="{{ old('name') }}">
                    @error('name')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Duration</label>
                    <div class="date-row">
                        <div class="date-field">
                            <span class="date-label">From</span>
                            <input type="date" id="start_date" name="start_date" required value="{{ old('start_date') }}">
                        </div>
                        <span class="date-sep">→</span>
                        <div class="date-field">
                            <span class="date-label">To</span>
                            <input type="date" id="end_date" name="end_date" required value="{{ old('end_date') }}">
                        </div>
                    </div>
                    @error('start_date')<span class="form-error">{{ $message }}</span>@enderror
                    @error('end_date')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="goal">Goal</label>
                    <input type="text" id="goal" name="goal" placeholder="e.g. Read 3 books in a month" required value="{{ old('goal') }}">
                    <span class="form-hint">Describe what participants should aim to achieve.</span>
                    @error('goal')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="modal__footer">
                    <button type="button" class="btn-cancel" id="cancelModal">Cancel</button>
                    <button type="submit" class="btn-submit">Create Challenge</button>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_private" value="1">
                        Private Challenge 🔒
                    </label>
                </div>
            </form>
        </div>
    </div>

    <script>
        const fab=document.getElementById('openModal'),overlay=document.getElementById('modalOverlay'),
        closeBtn=document.getElementById('closeModal'),cancelBtn=document.getElementById('cancelModal');
        const open=()=>{overlay.classList.add('is-open');document.body.style.overflow='hidden';};
        const close=()=>{overlay.classList.remove('is-open');document.body.style.overflow='';};
        fab.addEventListener('click',open);
        closeBtn.addEventListener('click',close);
        cancelBtn.addEventListener('click',close);
        overlay.addEventListener('click',e=>{if(e.target===overlay)close();});
        const today=new Date().toISOString().split('T')[0];
        document.getElementById('start_date').min=today;
        document.getElementById('end_date').min=today;
        document.getElementById('start_date').addEventListener('change',function(){
        document.getElementById('end_date').min=this.value;
        });
        @if($errors->any()) open(); @endif
        function showDeleteChallenge(id) {
            document.getElementById('confirmChallenge' + id).style.display = 'block';
        }

        function hideDeleteChallenge(id) {
            document.getElementById('confirmChallenge' + id).style.display = 'none';
        }
    </script>
</body>
</html>