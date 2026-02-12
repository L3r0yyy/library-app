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
    return [
        'title' => $this->faker->sentence(3), // Generates a 3-word title
        'author' => $this->faker->name(),     // Generates a fake name
        'isbn' => $this->faker->isbn13(),    // Generates a valid-looking ISBN
        'category_id' => \App\Models\Category::inRandomOrder()->first()->id, 
        'is_available' => true,
    ];
}
}