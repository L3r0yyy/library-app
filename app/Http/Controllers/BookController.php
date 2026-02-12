<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index(Request $request)
    {
       $query =  \App\Models\Book::with(['category', 'users']);
       

       if ($request->has('search')) {

        $search = $request->input('search');
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('author', 'like', "%{$search}%");
        });
       }

       $books = $query->paginate(10); 


       return view('books.index', compact('books'));


}

    public function borrow($id)
    {
        $book = \App\Models\Book::findOrFail($id);

        if ($book->users()->exists()) {
            return redirect()->back()->with('error', 'Book is already borrowed.');
        }

        $user = \App\Models\User::inRandomOrder()->first();
        $book->users()->attach($user->id, [
            'due_date' => now()->addDays(14)
        ]);

        return redirect()->back()->with('success', 'Book borrowed successfully.');
    }

    public function returnBook($id)
    {
        $book = \App\Models\Book::findOrFail($id);
        
        // Detach all users (since we assume one borrower for now based on logic)
        // Or specific logic if we had auth()->id()
        $book->users()->detach();

        return redirect()->back()->with('success', 'Book returned successfully.');
    }
    
}
