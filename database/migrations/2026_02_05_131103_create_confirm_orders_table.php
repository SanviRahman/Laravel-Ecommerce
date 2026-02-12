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
        Schema::create('confirm_orders', function (Blueprint $table) {
            $table->id();
            
            // Order Identification
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('session_id')->nullable();
            
            // Customer Information
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->text('notes')->nullable();
            
            // Order Financial Details
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            
            // Order Status
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])
                  ->default('pending');
            
            // Payment Information - SINGLE SET OF PAYMENT COLUMNS
            $table->string('payment_method')->default('cash_on_delivery');
            $table->string('payment_status')->default('pending');
            
            // Stripe Payment Columns (ONLY HERE - No duplicates)
            $table->string('stripe_session_id')->nullable();
            $table->string('stripe_payment_intent')->nullable();
            $table->string('stripe_payment_status')->nullable();
            
            // Payment Completion Columns
            $table->boolean('is_paid')->default(false);
            $table->timestamp('paid_at')->nullable();
            
            // Customer Type
            $table->enum('customer_type', ['guest', 'registered'])->default('guest');
            
            // Timestamps
            $table->timestamps();
            
            // Foreign Key Constraint
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('confirm_orders');
    }
};