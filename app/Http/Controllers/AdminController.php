<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalBooks = Book::count();
        $totalActiveLoans = DB::table('book_user')->count();
        $totalOverdueLoans = DB::table('book_user')->where('due_date', '<', now())->count();

        $users = User::paginate(10);

        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalBooks', 
            'totalActiveLoans', 
            'totalOverdueLoans', 
            'users'
        ));
    }

    public function promote(User $user)
    {
        $user->update(['role' => 'admin']);
        return redirect()->back()->with('success', "{$user->name} is now an admin.");
    }
}
