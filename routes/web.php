<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookshelfController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\PostController;

// 🌐 PUBLIC ROUTES
Route::get('/', [UserController::class, 'showLogin']);

Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::get('/register', [UserController::class, 'showRegister'])->name('register');
Route::post('/register', [UserController::class, 'register']);


// 🔒 PROTECTED ROUTES
Route::middleware('auth')->group(function () {

    // HOME
    Route::get('/home', [UserController::class, 'home'])
        ->name('home');

    // PROFILE
    Route::get('/profile', [UserController::class, 'showProfile'])
        ->name('profile');

    Route::post('/profile', [UserController::class, 'updateProfile']);

    Route::post('/logout', [UserController::class, 'logout'])
        ->name('logout');

    // 📚 BOOKSHELF
    Route::get('/bookshelf', [BookshelfController::class, 'index'])
        ->name('bookshelf');

    Route::post('/books', [BookshelfController::class, 'store'])
        ->name('books.store');

    Route::patch('/books/{book}/done', [BookshelfController::class, 'markDone'])
        ->name('books.done');

    Route::delete('/books/{book}', [BookshelfController::class, 'destroy'])
        ->name('books.delete');

    // 🏆 CHALLENGES
    Route::get('/challenges', [ChallengeController::class, 'index'])
        ->name('challenges');

    Route::post('/challenges', [ChallengeController::class, 'store'])
        ->name('challenges.store');

    Route::post('/challenges/{challenge}/join', [ChallengeController::class, 'join'])
        ->name('challenges.join');

    Route::delete('/challenges/{challenge}', [ChallengeController::class, 'destroy'])
        ->name('challenges.delete');

    Route::post('/challenges/{challenge}/leave', [ChallengeController::class, 'leave'])
        ->name('challenges.leave');

    // 📝 FORUM
    Route::get('/forum', [PostController::class, 'index'])
        ->name('forum');

    Route::post('/forum', [PostController::class, 'store'])
        ->name('posts.store');

    Route::post('/forum/{post}/like', [PostController::class, 'like'])
        ->name('posts.like');
        
    //Profile
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

    // COMMENTS
    Route::post('/forum/{post}/comment', [PostController::class, 'comment'])->name('posts.comment');
});