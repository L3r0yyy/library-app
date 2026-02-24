<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Statistics Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Books -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Books</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $totalBooks }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Available Books -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition-shadow">
                     <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Available to Borrow</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $availableBooks }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Books on Loan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition-shadow">
                     <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-500 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Currently on Loan</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $borrowedBooks }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Loans & Recently Added -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                
                <!-- My Active Loans -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">My Active Borrowed Books</h3>
                    </div>
                    <div class="p-6 text-gray-900">
                        @if ($activeLoans->isEmpty())
                            <p class="text-gray-500 text-center py-4">You have no active loans.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">Book</th>
                                            <th scope="col" class="px-6 py-3 text-center">Due Date</th>
                                            <th scope="col" class="px-6 py-3 text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($activeLoans as $loan)
                                            <tr class="bg-white border-b {{ $loan->is_overdue ? 'bg-red-50 border-red-200' : '' }}">
                                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                    {{ $loan->title }}
                                                    <span class="block text-xs font-normal text-gray-500">{{ $loan->author }}</span>
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    @if($loan->is_overdue)
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            Overdue by {{ \Carbon\Carbon::parse($loan->pivot->due_date)->diffInDays(now()) }} days
                                                        </span>
                                                    @else
                                                        {{ \Carbon\Carbon::parse($loan->pivot->due_date)->format('M d, Y') }}
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-right">
                                                    <form action="{{ route('books.return', $loan->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="font-medium text-blue-600 hover:text-blue-800 hover:underline">Return</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recently Added -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">Recently Added Books</h3>
                        <a href="{{ route('books.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Browse All &rarr;</a>
                    </div>
                    <div class="p-6 text-gray-900">
                        @if ($recentBooks->isEmpty())
                            <p class="text-gray-500 text-center py-4">No books have been added yet.</p>
                        @else
                            <ul class="divide-y divide-gray-200">
                                @foreach($recentBooks as $book)
                                    <li class="py-3 sm:py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $book->title }}
                                                </p>
                                                <p class="text-sm text-gray-500 truncate">
                                                    by {{ $book->author }}
                                                </p>
                                            </div>
                                            <div class="inline-flex items-center text-sm font-medium">
                                                @if($book->is_available)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Available</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">On Loan</span>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
