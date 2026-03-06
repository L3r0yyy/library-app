<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;

class BookController extends Controller
{
    public function index(Request $request)
{
    // 1. Grab the search term from the URL (e.g., ?search=...)
    $search = $request->query('search');

    // 2. Build the query
    $query = Book::with('category');

    // 3. If a search term exists, filter the results
    if ($search) {
        $query->where('title', 'like', "%{$search}%")
              ->orWhere('author', 'like', "%{$search}%");
    }

    // 4. Return the results as a Resource Collection
    return BookResource::collection($query->get());
}
}