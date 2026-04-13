<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Post;
use App\Models\Challenge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showLogin()
    {
        return view('users.login');
    }

    public function showRegister()
    {
        return view('users.register');
    }

    // HOME
    public function home()
    {
        $books = Book::latest()->get();
        $posts = Post::latest()->get();
        $challenges = Challenge::latest()->get();

        return view('home', compact('books', 'posts', 'challenges'));
    }

    // REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|confirmed|min:6',
        ]);

        $interestsArray = $request->input('interests', []);
        if (!is_array($interestsArray)) {
            $interestsArray = [$interestsArray];
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'bio'        => $request->bio,
            'interests'  => implode(',', $interestsArray),
        ]);

        Auth::login($user);

        return redirect('/home');
    }

    // LOGIN
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials'
        ]);
    }

    // PROFILE
    public function showProfile()
    {
        return view('users.profile', ['user' => Auth::user()]);
    }
    
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'bio'        => 'nullable|string|max:1000',
            'interests'  => 'nullable|string'
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'bio'        => $request->bio,
            'interests'  => $request->interests,
        ]);

        return redirect()->route('profile')->with('success', 'Profile updated!');
    }
    public function editProfile()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        return view('users.edit-profile', compact('user'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}