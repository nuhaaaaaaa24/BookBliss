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
        $challenges = Challenge::where(function ($query) {
            $query->where('is_private', false)
                ->orWhere('user_id', auth()->id());
        })->latest()->get();

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
            'is_private' => $request->has('is_private'),
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Challenge created!');
    }

    public function join(Challenge $challenge)
    {
        $challenge->participants()->attach(Auth::id());
        return back();
    }

    public function destroy(Challenge $challenge)
    {
        if ($challenge->user_id !== auth()->id()) {
            abort(403);
        }

        $challenge->delete();

        return back()->with('success', 'Challenge deleted');
    }

    public function leave(Challenge $challenge)
    {
        $challenge->participants()->detach(auth()->id());

        return back()->with('success', 'You left the challenge');
    }
}