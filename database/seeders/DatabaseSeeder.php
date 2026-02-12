<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
 
        $this->call([
         CategorySeeder::class,
     ]);
 
     $books = \App\Models\Book::factory(50)->create();

         $this->call([
            BorrowingSeeder::class,
         ]);

     $users = User::all();

     // Populate the pivot table
     $books->each(function ($book) use ($users) {
         $book->users()->attach(
             $users->random(rand(1, 4))->pluck('id')->toArray()
         );
     });
    }
}
