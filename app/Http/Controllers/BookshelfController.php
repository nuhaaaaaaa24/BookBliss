<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookshelfController extends Controller
{
    public function index()
    {
        $books = Book::latest()->get();
        return view('bookshelf.index', compact('books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
        }

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'cover_image' => $path,
            'status' => 'reading',

            // 🔥 THIS IS WHAT YOU ARE MISSING
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Book added!');
    }

    public function markDone(Book $book)
    {
        $book->update(['status' => 'done']);

        return back()->with('success', 'Book completed 🎉');
    }
    
    public function destroy(Book $book)
    {
        $book->delete();

        return back()->with('success', 'Book deleted 🗑️');
    }
}