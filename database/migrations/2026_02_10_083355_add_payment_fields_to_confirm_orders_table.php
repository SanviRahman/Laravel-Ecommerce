<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('confirm_orders', function (Blueprint $table) {
            if (!Schema::hasColumn('confirm_orders', 'is_paid')) {
                $table->boolean('is_paid')->default(false);
            }
            
            if (!Schema::hasColumn('confirm_orders', 'stripe_session_id')) {
                $table->string('stripe_session_id')->nullable();
            }
            
            if (!Schema::hasColumn('confirm_orders', 'stripe_payment_intent_id')) {
                $table->string('stripe_payment_intent_id')->nullable();
            }
            
            if (!Schema::hasColumn('confirm_orders', 'paid_amount')) {
                $table->decimal('paid_amount', 10, 2)->nullable();
            }
            
            if (!Schema::hasColumn('confirm_orders', 'payment_date')) {
                $table->timestamp('payment_date')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('confirm_orders', function (Blueprint $table) {
            $columns = ['is_paid', 'stripe_session_id', 'stripe_payment_intent_id', 'paid_amount', 'payment_date'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('confirm_orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};