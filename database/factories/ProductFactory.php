<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_title' => fake()->words(3, true),
            'product_description' => fake()->paragraph(3),
            'product_price' => fake()->randomFloat(2, 10, 1000),
            'product_quantity' => fake()->numberBetween(1, 100),
            'product_category' => Category::inRandomOrder()->first()->id,
            'product_image' => 'uploads/products/default.jpg',
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }
}