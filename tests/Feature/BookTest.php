<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Category;
use Carbon\Carbon;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_books_page_loads_and_lists_books()
    {
        $category = Category::create(['name' => 'Fiction']);
        Book::create([
            'title' => 'Test Book',
            'author' => 'Test Author',
            'isbn' => '1234567890',
            'category_id' => $category->id,
            'is_available' => true,
        ]);

        $response = $this->get('/books');

        $response->assertStatus(200);
        $response->assertSee('Test Book');
    }

    public function test_search_functionality()
    {
        $category = Category::create(['name' => 'Fiction']);
        Book::create([
            'title' => 'Learning Laravel',
            'author' => 'John Doe',
            'isbn' => '11111',
            'category_id' => $category->id,
        ]);
        Book::create([
            'title' => 'Mastering PHP',
            'author' => 'Jane Doe',
            'isbn' => '22222',
            'category_id' => $category->id,
        ]);

        // Search by title
        $response = $this->get('/books?search=Laravel');
        $response->assertSee('Learning Laravel');
        $response->assertDontSee('Mastering PHP');

        // Search by author
        $response = $this->get('/books?search=Jane');
        $response->assertSee('Mastering PHP');
        $response->assertDontSee('Learning Laravel');
    }

    public function test_book_user_relationship_due_date_access()
    {
        $category = Category::create(['name' => 'Fiction']);
        $book = Book::create([
            'title' => 'Borrowed Book',
            'author' => 'Author X',
            'isbn' => '33333',
            'category_id' => $category->id,
        ]);

        $user = User::factory()->create();
        
        // Attach user to book with due_date
        $book->users()->attach($user->id, ['due_date' => Carbon::now()->addDays(7)]);

        // Reload book logic to simulate controller
        $book = Book::with('users')->first();

        $this->assertNotNull($book->users->first()->pivot->due_date);
    }
}
