<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Statistics Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Users -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Users</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</h3>
                        </div>
                    </div>
                </div>

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

                <!-- Active Loans -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition-shadow">
                     <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Active Loans</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $totalActiveLoans }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Overdue Loans -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition-shadow">
                     <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-500 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Overdue Loans</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $totalOverdueLoans }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Management -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">User Management</h3>
                </div>
                
                @if (session('success'))
                    <div class="p-4 bg-green-50 border-l-4 border-green-400 text-green-800">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">Email</th>
                                    <th scope="col" class="px-6 py-3">Role</th>
                                    <th scope="col" class="px-6 py-3">Joined</th>
                                    <th scope="col" class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            {{ $user->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($user->isAdmin())
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Admin</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">User</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $user->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @if(!$user->isAdmin())
                                                <form action="{{ route('admin.users.promote', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Promote {{ $user->name }} to Admin?');">
                                                    @csrf
                                                    <button type="submit" class="font-medium text-indigo-600 hover:text-indigo-900">Make Admin</button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 italic">Admin</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
