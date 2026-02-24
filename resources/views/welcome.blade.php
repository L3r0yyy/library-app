<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    
                    <div class="text-center py-16">
                        <svg viewBox="0 0 24 24" fill="none" class="w-32 h-32 mx-auto text-indigo-500 mb-8" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 19V6.2C4 5.0799 4 4.51984 4.21799 4.09202C4.40973 3.71569 4.71569 3.40973 5.09202 3.21799C5.51984 3 6.0799 3 7.2 3H16.8C17.9201 3 18.4802 3 18.908 3.21799C19.2843 3.40973 19.5903 3.71569 19.782 4.09202C20 4.51984 20 5.0799 20 6.2V17H6C4.89543 17 4 17.8954 4 19ZM4 19C4 20.1046 4.89543 21 6 21H20M9 7H15M9 11H15M19 17V21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        
                        <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl mb-4">
                            Welcome to the Library
                        </h1>
                        
                        <p class="text-xl text-gray-500 mb-10 max-w-2xl mx-auto">
                            Managing your catalog has never been easier. Access books, check out records, and more.
                        </p>
                        
                        <div class="flex justify-center gap-4">
                            <a href="{{ route('books.index') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                                Browse Books
                            </a>
                            
                            @guest
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                                    Log In
                                </a>
                            @endguest
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
