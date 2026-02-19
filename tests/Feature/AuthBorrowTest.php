<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthBorrowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_borrow_book()
    {
        $category = Category::create(['name' => 'Fiction']);
        $book = Book::factory()->create(['category_id' => $category->id]);

        $response = $this->post(route('books.borrow', $book->id));

        $response->assertRedirect(route('login'));
        $this->assertFalse($book->users()->exists());
    }

    public function test_authenticated_user_can_borrow_book()
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Fiction']);
        $book = Book::factory()->create(['category_id' => $category->id, 'is_available' => true]);

        $response = $this->actingAs($user)
                         ->post(route('books.borrow', $book->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $this->assertTrue($book->refresh()->users()->where('user_id', $user->id)->exists());
        $this->assertEquals(0, $book->is_available); // SQLite boolean might be 0/1
    }

    public function test_cannot_borrow_unavailable_book()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $category = Category::create(['name' => 'Fiction']);
        $book = Book::factory()->create(['category_id' => $category->id, 'is_available' => false]);
        
        // Simulate existing loan
        $book->users()->attach($user1->id, ['due_date' => now()->addDays(14)]);

        $response = $this->actingAs($user2)
                         ->post(route('books.borrow', $book->id));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        
        // Ensure user2 didn't borrow it
        $this->assertFalse($book->users()->where('user_id', $user2->id)->exists());
    }

    public function test_user_can_return_book()
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Fiction']);
        $book = Book::factory()->create(['category_id' => $category->id, 'is_available' => false]);
        $book->users()->attach($user->id, ['due_date' => now()->addDays(14)]);

        $response = $this->actingAs($user)
                         ->post(route('books.return', $book->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $this->assertEquals(1, $book->refresh()->is_available);
        $this->assertFalse($book->users()->exists());
    }
}
