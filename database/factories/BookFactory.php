<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $books = [
            ['title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee'],
            ['title' => '1984', 'author' => 'George Orwell'],
            ['title' => 'The Great Gatsby', 'author' => 'F. Scott Fitzgerald'],
            ['title' => 'Pride and Prejudice', 'author' => 'Jane Austen'],
            ['title' => 'The Catcher in the Rye', 'author' => 'J.D. Salinger'],
            ['title' => 'The Hobbit', 'author' => 'J.R.R. Tolkien'],
            ['title' => 'Fahrenheit 451', 'author' => 'Ray Bradbury'],
            ['title' => 'Jane Eyre', 'author' => 'Charlotte Bronte'],
            ['title' => 'Animal Farm', 'author' => 'George Orwell'],
            ['title' => 'Wuthering Heights', 'author' => 'Emily Bronte'],
            ['title' => 'Brave New World', 'author' => 'Aldous Huxley'],
            ['title' => 'The Lord of the Rings', 'author' => 'J.R.R. Tolkien'],
            ['title' => 'Harry Potter and the Sorcerer\'s Stone', 'author' => 'J.K. Rowling'],
            ['title' => 'The Alchemist', 'author' => 'Paulo Coelho'],
            ['title' => 'The Da Vinci Code', 'author' => 'Dan Brown'],
            ['title' => 'The Chronicles of Narnia', 'author' => 'C.S. Lewis'],
            ['title' => 'The Kite Runner', 'author' => 'Khaled Hosseini'],
            ['title' => 'The Book Thief', 'author' => 'Markus Zusak'],
            ['title' => 'The Hunger Games', 'author' => 'Suzanne Collins'],
            ['title' => 'The Girl with the Dragon Tattoo', 'author' => 'Stieg Larsson'],
            ['title' => 'Life of Pi', 'author' => 'Yann Martel'],
            ['title' => 'The Hitchhiker\'s Guide to the Galaxy', 'author' => 'Douglas Adams'],
            ['title' => 'Clean Code', 'author' => 'Robert C. Martin'],
            ['title' => 'The Pragmatic Programmer', 'author' => 'Andrew Hunt'],
            ['title' => 'Refactoring', 'author' => 'Martin Fowler'],
            ['title' => 'Design Patterns', 'author' => 'Erich Gamma'],
            ['title' => 'Introduction to Algorithms', 'author' => 'Thomas H. Cormen'],
        ];

        $book = $this->faker->randomElement($books);

        return [
            'title' => $book['title'],
            'author' => $book['author'],
            'isbn' => $this->faker->unique()->isbn13(),
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id ?? \App\Models\Category::factory(), 
            'is_available' => true,
        ];
    }
}