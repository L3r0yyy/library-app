<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_books_link_is_visible_on_dashboard()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee(route('books.index'));
        $response->assertSee('Books');
    }

    public function test_books_page_uses_app_layout_and_shows_nav_for_authenticated_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/books');

        $response->assertStatus(200);
        $response->assertSee($user->name); // User name in nav dropdown
        $response->assertSee('Dashboard'); // Link to dashboard
        $response->assertSee('Log Out');   // Logout option
    }

    public function test_books_page_works_for_guest_and_shows_login_link_in_nav()
    {
        $response = $this->get('/books');

        $response->assertStatus(200);
        $response->assertSee('Log in');    // Nav link for guest
        $response->assertSee('Register');  // Nav link for guest
        $response->assertDontSee('Dashboard'); // Should not see dashboard link in nav
    }
}
