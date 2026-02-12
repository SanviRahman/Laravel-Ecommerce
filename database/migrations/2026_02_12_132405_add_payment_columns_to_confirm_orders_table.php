<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('confirm_orders', function (Blueprint $table) {
            // Mobile Banking Columns
            $table->string('mobile_banking_method')->nullable()->after('payment_status');
            $table->string('mobile_number')->nullable()->after('mobile_banking_method');
            
            // Bank Transfer Columns
            $table->string('bank_name')->nullable()->after('mobile_number');
            $table->string('account_number')->nullable()->after('bank_name');
            
            // Common Transaction ID for both mobile banking and bank transfer
            $table->string('transaction_id')->nullable()->after('account_number');
            
            // Stripe payment intent ID fix
            $table->string('stripe_payment_intent_id')->nullable()->after('stripe_payment_intent');
            
            // Payment amount and date
            $table->decimal('paid_amount', 10, 2)->nullable()->after('transaction_id');
            $table->timestamp('payment_date')->nullable()->after('paid_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('confirm_orders', function (Blueprint $table) {
            $table->dropColumn([
                'mobile_banking_method',
                'mobile_number',
                'bank_name',
                'account_number',
                'transaction_id',
                'stripe_payment_intent_id',
                'paid_amount',
                'payment_date',
            ]);
        });
    }
};