<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $totalBooks = App\Models\Book::count();
    $availableBooks = App\Models\Book::where('is_available', true)->count();
    $borrowedBooks = App\Models\Book::where('is_available', false)->count();

    /** @var \App\Models\User $user */
    $user = auth()->user();
    
    // Get books currently borrowed by the user
    $activeLoans = $user->books()->withPivot('due_date')->get();

    $recentBooks = App\Models\Book::latest()->take(5)->get();

    return view('dashboard', compact('totalBooks', 'availableBooks', 'borrowedBooks', 'activeLoans', 'recentBooks'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/books', [BookController::class, 'index'])->name('books.index');

Route::middleware('auth')->group(function () {
    // User Actions
    Route::post('/books/{id}/borrow', [BookController::class, 'borrow'])->name('books.borrow');
    Route::post('/books/{id}/return', [BookController::class, 'returnBook'])->name('books.return');

    // Admin Management Actions
    Route::middleware('admin')->group(function () {
        Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
        Route::post('/admin/users/{user}/promote', [\App\Http\Controllers\AdminController::class, 'promote'])->name('admin.users.promote');
        
        Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
        Route::post('/books', [BookController::class, 'store'])->name('books.store');
        Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    });
});
