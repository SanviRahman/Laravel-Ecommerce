<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categoryName = $this->faker->unique()->words(rand(1, 3), true);
        
        return [
            'name' => ucfirst($categoryName),
            'slug' => Str::slug($categoryName),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    /**
     * Create categories with specific names
     */
    public function withName(string $name): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $name,
            'slug' => Str::slug($name),
        ]);
    }

    /**
     * Electronics category
     */
    public function electronics(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Electronics',
            'slug' => 'electronics',
        ]);
    }

    /**
     * Clothing category
     */
    public function clothing(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Clothing',
            'slug' => 'clothing',
        ]);
    }

    /**
     * Books category
     */
    public function books(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Books',
            'slug' => 'books',
        ]);
    }

    /**
     * Home & Garden category
     */
    public function homeGarden(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Home & Garden',
            'slug' => 'home-garden',
        ]);
    }

    /**
     * Sports category
     */
    public function sports(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Sports',
            'slug' => 'sports',
        ]);
    }

    /**
     * Beauty category
     */
    public function beauty(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Beauty',
            'slug' => 'beauty',
        ]);
    }
}