<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('confirm_orders', function (Blueprint $table) {
            // নতুন কলাম যোগ করুন
            $table->boolean('is_paid')->default(false);
            $table->string('payment_method')->nullable()->change(); // Optional payment
            $table->string('payment_status')->default('pending')->change();
            $table->string('stripe_session_id')->nullable();
            $table->string('stripe_payment_intent_id')->nullable();
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->timestamp('payment_date')->nullable();

            // Payment details
            $table->string('mobile_banking_method')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('transaction_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('confirm_orders', function (Blueprint $table) {
            $table->dropColumn([
                'is_paid', 'stripe_session_id', 'stripe_payment_intent_id',
                'paid_amount', 'payment_date', 'mobile_banking_method',
                'mobile_number', 'bank_name', 'account_number', 'transaction_id',
            ]);
        });
    }
};
