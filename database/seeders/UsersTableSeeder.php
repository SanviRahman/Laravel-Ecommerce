<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Delete all users
        DB::table('users')->delete();
        
        // Reset auto-increment
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 1');
        
        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create specific test users
        $testUsers = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@example.com',
                'user_type' => 'admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'John Doe',
                'email' => 'user@example.com',
                'user_type' => 'user',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($testUsers as $user) {
            User::create($user);
        }

        // Create random users WITHOUT using factory (to avoid duplicate emails)
        $this->createRandomUsers(20); // 20 random users
        
        // Create admin users
        $this->createAdminUsers(5); // 5 admin users
        
        // Create regular users
        $this->createRegularUsers(10); // 10 regular users

        $this->command->info('Total users created: ' . User::count());
        $this->command->info('Admin users: ' . User::where('user_type', 'admin')->count());
        $this->command->info('Regular users: ' . User::where('user_type', 'user')->count());
    }
    
    /**
     * Create random users manually
     */
    private function createRandomUsers($count)
    {
        $faker = \Faker\Factory::create();
        
        for ($i = 0; $i < $count; $i++) {
            User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'user_type' => $faker->randomElement(['user', 'admin', 'moderator']),
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
    
    /**
     * Create admin users
     */
    private function createAdminUsers($count)
    {
        $faker = \Faker\Factory::create();
        
        for ($i = 0; $i < $count; $i++) {
            User::create([
                'name' => $faker->name(),
                'email' => 'admin' . ($i + 1) . '@test.com', // Unique email pattern
                'user_type' => 'admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
    
    /**
     * Create regular users
     */
    private function createRegularUsers($count)
    {
        $faker = \Faker\Factory::create();
        
        for ($i = 0; $i < $count; $i++) {
            User::create([
                'name' => $faker->name(),
                'email' => 'user' . ($i + 1) . '@test.com', // Unique email pattern
                'user_type' => 'user',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}