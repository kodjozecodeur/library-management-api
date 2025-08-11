<?php

namespace Database\Factories;

use App\Models\Books;
use App\Models\Members;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rentals>
 */
class RentalsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isReturned = $this->faker->boolean(50);
        return [
            'book_id' => Books::inRandomOrder()->first()->id ?? Books::factory(),
            'member_id' => Members::inRandomOrder()->first()->id ?? Members::factory(),
            'rented_at' => now()->subDays(rand(1, 10)),
            'due_at' => now()->addDays(rand(1, 15)),
            'returned_at' => $isReturned ? now()->subDays(rand(0, 5)) : null
        ];
    }
}
