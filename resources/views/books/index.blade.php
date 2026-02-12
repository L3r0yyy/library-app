<!DOCTYPE html>
<html>
<head>
    <title>Library App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f4f4f4; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background: #333; color: white; }
    </style>
</head>
<body>
    <h1>Available Books</h1>
    <div style="margin-bottom: 20px;">
    <form action="/books" method="GET">
        <input type="text" name="search" placeholder="Search by title or author..." 
               value="{{ request('search') }}" 
               style="padding: 10px; width: 300px; border: 1px solid #ccc; border-radius: 4px;">
        <button type="submit" style="padding: 10px 20px; background: #333; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Search
        </button>
        <a href="/books" style="margin-left: 10px; color: #666; text-decoration: none;">Clear</a>
    </form>
</div>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
    @foreach($books as $book)
        <tr style="{{ $book->is_overdue ? 'background-color: #ffebee;' : '' }}">
            <td>{{ $book->title }}</td>
            <td>{{ $book->author }}</td>
            <td>{{ $book->category->name }}</td>
            <td>
                @if($book->current_borrower)
                    <span style="color: {{ $book->is_overdue ? 'red' : '#e67e22' }}; font-weight: bold;">
                        {{ $book->is_overdue ? 'OVERDUE:' : 'Borrowed by:' }}
                    </span> 
                    {{ $book->current_borrower->name }} <br>
                    <small>Due: {{ $book->current_borrower->pivot->due_date }}</small>
                    
                    <form action="{{ route('books.return', $book->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" style="background: #e74c3c; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; margin-left: 5px; font-size: 0.8em;">
                            Return
                        </button>
                    </form>
                @else
        {{-- Show Borrow Button --}}
        <form action="{{ route('books.borrow', $book->id) }}" method="POST">
            @csrf
            <button type="submit" style="background: #27ae60; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">
                Borrow Now
            </button>
        </form>
    @endif
</td>
        </tr>
    @endforeach
        </tbody>
    </table>
    <div style="margin-top: 20px;">
    {{ $books->links() }}
</div>
</body>
</html>