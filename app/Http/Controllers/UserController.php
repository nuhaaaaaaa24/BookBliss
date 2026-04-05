<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Show Login Page
    public function showLogin()
    {
        return view('users.login');
    }

    // Show Register Page
    public function showRegister()
    {
        return view('users.register');
    }

    // REGISTER USER
    public function register(Request $request)
    {
        // Validate
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|confirmed|min:6',
        ]);

        // Convert interests array to string
        // Fix interests
        $interestsArray = $request->input('interests', []); // default empty array
        if (!is_array($interestsArray)) {
            $interestsArray = [$interestsArray]; // wrap single value
        }
        $interests = count($interestsArray) > 0 ? implode(',', $interestsArray) : null;

        // Create user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'bio'        => $request->bio,
            'interests'  => $interests,
        ]);

        // Auto login after register
        Auth::login($user);

        // Redirect to home
        return redirect('/home');
    }

    // LOGIN USER
    public function login(Request $request)
    {
        // Validate
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt login
        if (Auth::attempt($request->only('email', 'password'))) {
            // Regenerate session (security)
            $request->session()->regenerate();

            return redirect('/home');
        }

        // If failed
        return back()->with('error', 'Invalid email or password');
    }

    // HOME PAGE
    public function home()
    {
        return view('home');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}