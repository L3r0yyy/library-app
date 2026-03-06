<div>
    {{-- Search Bar --}}
    <div class="mb-6">
        <input 
            wire:model.live="search" 
            type="text" 
            placeholder="Search books by title or author..."
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
    </div>

    {{-- Loading Indicator --}}
    <div wire:loading class="text-blue-500 text-sm mb-4">
        Searching...
    </div>

    {{-- Search Results --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($books as $book)
                    <tr class="{{ $book->is_overdue ? 'bg-red-50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $book->title }}</div>
                            <div class="text-sm text-gray-500">{{ $book->isbn }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $book->author }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $book->category->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($book->current_borrower)
                                <div class="text-sm {{ $book->is_overdue ? 'text-red-600 font-bold' : 'text-orange-600' }}">
                                    {{ $book->is_overdue ? 'OVERDUE' : 'Borrowed' }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    by {{ $book->current_borrower->name }}<br>
                                    Due: {{ \Carbon\Carbon::parse($book->current_borrower->pivot->due_date)->format('M d, Y') }}
                                </div>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Available
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex gap-2">
                                @if($book->current_borrower)
                                    @auth
                                        @if(Auth::id() === $book->current_borrower->id)
                                            <form action="{{ route('books.return', $book->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Return</button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 cursor-not-allowed">Unavailable</span>
                                        @endif
                                    @endauth
                                @else
                                    @auth
                                        <form action="{{ route('books.borrow', $book->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900 font-bold">Borrow</button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-900">Login</a>
                                    @endauth
                                @endif
                                
                                @auth
                                    @if(auth()->user()->isAdmin())
                                        <span class="text-gray-300">|</span>
                                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            No books found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $books->links() }}
    </div>
</div>