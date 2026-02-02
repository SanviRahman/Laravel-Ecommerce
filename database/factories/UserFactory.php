<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $emailCounter = 1; // Static counter for unique emails
        
        return [
            'name' => $this->faker->name(),
            'email' => 'user' . $emailCounter++ . '@example.com', // Always unique
            'user_type' => $this->faker->randomElement(['user', 'admin', 'moderator']),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Admin user state
     */
    public function admin(): static
    {
        static $adminEmailCounter = 1;
        
        return $this->state(fn (array $attributes) => [
            'user_type' => 'admin',
            'email' => 'admin' . $adminEmailCounter++ . '@test.com',
        ]);
    }

    /**
     * Regular user state
     */
    public function regular(): static
    {
        static $userEmailCounter = 1;
        
        return $this->state(fn (array $attributes) => [
            'user_type' => 'user',
            'email' => 'regular' . $userEmailCounter++ . '@test.com',
        ]);
    }
}