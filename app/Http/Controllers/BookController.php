<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if (!$book->is_available) {
            return redirect()->back()->with('error', 'Book is already borrowed.');
        }

        $user = Auth::user();
        $book->users()->attach($user->id, [
            'due_date' => now()->addDays(14)
        ]);

        $book->update(['is_available' => false]);

        return redirect()->back()->with('success', 'Book borrowed successfully.');
    }

    public function returnBook($id)
    {
        $book = \App\Models\Book::findOrFail($id);
        
        $book->users()->detach();
        $book->update(['is_available' => true]);

        return redirect()->back()->with('success', 'Book returned successfully.');
    }
    
}
