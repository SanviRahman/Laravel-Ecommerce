<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Create 100 random products
        Product::factory()->count(100)->create();
        
        $this->command->info('✓ 100 products created.');
    }
}