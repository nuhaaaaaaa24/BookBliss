<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'showLogin']);

// Auth
Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::get('/register', [UserController::class, 'showRegister'])->name('register');
Route::post('/register', [UserController::class, 'register']);

// Protected
Route::get('/home', [UserController::class, 'home'])->middleware('auth');

// Logout
Route::post('/logout', [UserController::class, 'logout'])->name('logout');