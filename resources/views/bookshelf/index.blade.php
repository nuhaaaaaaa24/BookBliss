<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookshelf – BookBliss</title>
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
            <a href="{{ route('bookshelf') }}" class="active">Bookshelf</a>
            <a href="{{ route('forum') }}">Forum</a>
            <a href="{{ route('challenges') }}">Challenges</a>
            <a href="{{ route('profile') }}">Profile</a>
        </div>
    </nav>
    <hr>

    <header class="topbar">
        <h1>My Bookshelf</h1>
        <p>{{ $books->count() }} {{ Str::plural('book', $books->count()) }} on your shelf</p>
    </header>

    @if(session('success'))
        <div class="flash flash--success">{{ session('success') }}</div>
    @endif

    <main class="shelf-main">

        @if($books->isEmpty())
            <div class="shelf-empty">
                <span class="shelf-empty__icon">📭</span>
                <p>Your shelf is empty. Add your first book!</p>
            </div>
        @else
            <div class="shelf-grid">
                @foreach($books as $book)
                    <article class="book-card {{ $book->status === 'reading' ? 'book-card--reading' : '' }}">

                        {{-- Cover --}}
                        <div class="book-card__cover-wrap">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}"
                                     alt="{{ $book->title }} cover"
                                     class="book-card__cover">
                            @else
                                <div class="book-card__cover book-card__cover--placeholder">
                                    <span>{{ strtoupper(substr($book->title, 0, 1)) }}</span>
                                </div>
                            @endif

                            @if($book->status === 'reading')
                                <span class="book-card__badge">Reading</span>
                            @elseif($book->status === 'done')
                                <span class="book-card__badge book-card__badge--done">Done ✓</span>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="book-card__info">
                            <h3 class="book-card__title">{{ $book->title }}</h3>
                            <p class="book-card__author">{{ $book->author }}</p>
                        </div>

                        {{-- Actions --}}
                        <div class="book-card__actions">
                            @if($book->status !== 'done')
                                <form method="POST" action="{{ route('books.done', $book->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-done">Mark as Done</button>
                                </form>
                            @else
                                <span class="book-card__done-label">Finished 🎉</span>
                            @endif

                            <form method="POST" action="{{ route('books.delete', $book->id) }}" id="deleteForm{{ $book->id }}">
                                @csrf
                                @method('DELETE')

                                <button type="button" class="btn-delete" onclick="showDelete({{ $book->id }})">
                                    Delete
                                </button>

                                <div id="confirmBox{{ $book->id }}" class="delete-confirm" style="display:none; margin-top:10px;">
                                    <span>Delete this book?</span>

                                    <button type="submit" class="btn-confirm-yes">Yes</button>
                                    <button type="button" class="btn-confirm-no" onclick="hideDelete({{ $book->id }})">No</button>
                                </div>
                            </form>
                        </div>

                    </article>
                @endforeach
            </div>
        @endif
    </main>

    <button class="fab" id="openModal" aria-label="Add a new book">+</button>

    <div class="modal-overlay" id="modalOverlay">
        <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">

            <div class="modal__header">
                <h2 id="modalTitle">Add a New Book</h2>
                <button class="modal__close" id="closeModal" aria-label="Close">&times;</button>
            </div>

            <form method="POST"
                  action="{{ route('books.store') }}"
                  enctype="multipart/form-data"
                  class="modal__form"
                  id="addBookForm">
                @csrf

                <div class="form-group">
                    <label for="title">Book Name</label>
                    <input type="text" id="title" name="title"
                           placeholder="e.g. The Name of the Wind"
                           required value="{{ old('title') }}">
                    @error('title')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="author">Author</label>
                    <input type="text" id="author" name="author"
                           placeholder="e.g. Patrick Rothfuss"
                           required value="{{ old('author') }}">
                    @error('author')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="cover_image">Cover Image</label>
                    <div class="file-upload" id="fileUploadArea">
                        <input type="file" id="cover_image" name="cover_image"
                               accept="image/*" class="file-upload__input">
                        <div class="file-upload__ui" id="fileUploadUI">
                            <span class="file-upload__icon">📷</span>
                            <span class="file-upload__text">Click to upload a cover</span>
                            <span class="file-upload__hint">JPG, PNG, WEBP · max 2 MB</span>
                        </div>
                        <img id="coverPreview" class="file-upload__preview" src="" alt="Cover preview">
                    </div>
                    @error('cover_image')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="modal__footer">
                    <button type="button" class="btn-cancel" id="cancelModal">Cancel</button>
                    <button type="submit" class="btn-submit">Add to Shelf</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </footer>

    <script>
        const fab      = document.getElementById('openModal');
        const overlay  = document.getElementById('modalOverlay');
        const closeBtn = document.getElementById('closeModal');
        const cancelBtn= document.getElementById('cancelModal');
        const fileInput= document.getElementById('cover_image');
        const preview  = document.getElementById('coverPreview');
        const fileUI   = document.getElementById('fileUploadUI');

        const openModal  = () => { overlay.classList.add('is-open'); document.body.style.overflow = 'hidden'; };
        const closeModal = () => { overlay.classList.remove('is-open'); document.body.style.overflow = ''; };

        fab.addEventListener('click', openModal);
        closeBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);
        overlay.addEventListener('click', e => { if (e.target === overlay) closeModal(); });

        fileInput.addEventListener('change', () => {
            const file = fileInput.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.style.display = 'block';
                fileUI.style.display = 'none';
            };
            reader.readAsDataURL(file);
        });

        @if($errors->any())
            openModal();
        @endif
        function showDelete(id) {
            document.getElementById('confirmBox' + id).style.display = 'block';
        }

        function hideDelete(id) {
            document.getElementById('confirmBox' + id).style.display = 'none';
        }
    </script>
</body>
</html>