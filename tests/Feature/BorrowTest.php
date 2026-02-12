<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Category;
use Carbon\Carbon;

class BorrowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_borrow_available_book()
    {
        $category = Category::create(['name' => 'Fiction']);
        $book = Book::create([
            'title' => 'Available Book',
            'author' => 'Author Y',
            'isbn' => '99999',
            'category_id' => $category->id,
        ]);

        $user = User::factory()->create();

        // Simulate borrowing
        $response = $this->post(route('books.borrow', $book->id));

        $response->assertRedirect();
        
        // Assert book is attached to a user (logic attaches to RANDOM user, so we check book users count)
        $this->assertCount(1, $book->users);
        $this->assertNotNull($book->users->first()->pivot->due_date);
    }

    public function test_cannot_borrow_already_borrowed_book()
    {
        $category = Category::create(['name' => 'Fiction']);
        $book = Book::create([
            'title' => 'Borrowed Book',
            'author' => 'Author Z',
            'isbn' => '88888',
            'category_id' => $category->id,
        ]);

        $user1 = User::factory()->create();
        $book->users()->attach($user1->id, ['due_date' => now()->addDays(14)]);

        // Try to borrow again
        $response = $this->post(route('books.borrow', $book->id));

        $response->assertSessionHas('error', 'Book is already borrowed.');
        
        $book->refresh();
        // Since we now restrict it, the count should remain 1
        $this->assertCount(1, $book->users); 
    }

    public function test_user_can_return_book()
    {
        $category = Category::create(['name' => 'Fiction']);
        $book = Book::create([
            'title' => 'Book to Return',
            'author' => 'Author A',
            'isbn' => '77777',
            'category_id' => $category->id,
        ]);

        $user = User::factory()->create();
        $book->users()->attach($user->id, ['due_date' => now()->addDays(14)]);

        // Verify it is borrowed
        $this->assertCount(1, $book->users);

        // Return the book
        $response = $this->post(route('books.return', $book->id));
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Book returned successfully.');

        $book->refresh();
        $this->assertCount(0, $book->users);
    }
}
