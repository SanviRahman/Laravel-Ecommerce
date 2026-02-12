<?php
// database/migrations/2024_01_01_000001_add_size_and_measurement_to_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // JSON field for available sizes (S,M,L,XL,XXL)
            $table->json('available_sizes')->nullable()->after('product_quantity');
            // Text field for measurement details
            $table->text('measurement_details')->nullable()->after('available_sizes');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['available_sizes', 'measurement_details']);
        });
    }
};