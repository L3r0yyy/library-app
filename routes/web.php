<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/books', [BookController::class, 'index']);
Route::post('/books/{id}/borrow', [BookController::class, 'borrow'])->name('books.borrow');
Route::post('/books/{id}/return', [BookController::class, 'returnBook'])->name('books.return');


