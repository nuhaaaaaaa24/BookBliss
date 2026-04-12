<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChallengeController extends Controller
{
    public function index()
    {
        $challenges = Challenge::latest()->get();
        return view('challenges.index', compact('challenges'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'goal' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        Challenge::create([
            'name' => $request->name,
            'goal' => $request->goal,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Challenge created!');
    }

    public function join(Challenge $challenge)
    {
        $challenge->participants()->attach(Auth::id());
        return back();
    }
}