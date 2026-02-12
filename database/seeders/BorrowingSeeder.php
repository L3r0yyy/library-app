<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BorrowingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::all();
        $books = \App\Models\Book::all();


        foreach($users as $user) {

             $randomBookIds = $books->random(2)->pluck('id');
             
             $user->books()->attach($randomBookIds, ['due_date'  => now()->addDays(rand(7,21))
             ]);
        }
    }
}
