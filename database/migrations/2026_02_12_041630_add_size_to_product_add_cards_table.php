<?php
// database/migrations/2024_01_01_000002_add_size_to_product_add_cards_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_add_cards', function (Blueprint $table) {
            // String field for selected size
            $table->string('size')->nullable()->after('quantity');
        });
    }

    public function down(): void
    {
        Schema::table('product_add_cards', function (Blueprint $table) {
            $table->dropColumn('size');
        });
    }
};