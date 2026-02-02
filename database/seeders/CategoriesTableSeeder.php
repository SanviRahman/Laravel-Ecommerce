<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Delete all categories (not truncate)
        DB::table('categories')->delete();
        
        // Reset auto-increment
        DB::statement('ALTER TABLE categories AUTO_INCREMENT = 1');
        
        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create categories
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics'],
            ['name' => 'Clothing', 'slug' => 'clothing'],
            ['name' => 'Books', 'slug' => 'books'],
            ['name' => 'Home & Garden', 'slug' => 'home-garden'],
            ['name' => 'Sports', 'slug' => 'sports'],
            ['name' => 'Beauty', 'slug' => 'beauty'],
            ['name' => 'Toys', 'slug' => 'toys'],
            ['name' => 'Food & Beverages', 'slug' => 'food-beverages'],
            ['name' => 'Health & Fitness', 'slug' => 'health-fitness'],
            ['name' => 'Automotive', 'slug' => 'automotive'],
            ['name' => 'Jewelry', 'slug' => 'jewelry'],
            ['name' => 'Furniture', 'slug' => 'furniture'],
            ['name' => 'Music', 'slug' => 'music'],
            ['name' => 'Movies & TV', 'slug' => 'movies-tv'],
            ['name' => 'Gaming', 'slug' => 'gaming'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('✅ ' . count($categories) . ' categories created.');
    }
}