<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('confirm_orders', function (Blueprint $table) {
            // Stripe related columns
            $table->string('stripe_session_id')->nullable()->after('payment_method');
            $table->string('stripe_payment_intent_id')->nullable()->after('stripe_session_id');
            
            // Mobile banking and bank transfer columns
            $table->string('mobile_banking_method')->nullable()->after('stripe_payment_intent_id');
            $table->string('mobile_number')->nullable()->after('mobile_banking_method');
            $table->string('bank_name')->nullable()->after('mobile_number');
            $table->string('account_number')->nullable()->after('bank_name');
            $table->string('transaction_id')->nullable()->after('account_number');
            
            // Additional payment info
            $table->decimal('paid_amount', 10, 2)->nullable()->after('total');
            $table->timestamp('payment_date')->nullable()->after('paid_amount');
            
            // Indexes for faster queries
            $table->index(['stripe_session_id', 'transaction_id']);
        });
    }

    public function down(): void
    {
        Schema::table('confirm_orders', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_session_id',
                'stripe_payment_intent_id',
                'mobile_banking_method',
                'mobile_number',
                'bank_name',
                'account_number',
                'transaction_id',
                'paid_amount',
                'payment_date'
            ]);
        });
    }
};