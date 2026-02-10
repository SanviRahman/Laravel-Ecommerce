<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // সুরক্ষিতভাবে শুধু missing কলামগুলো add করুন
        
        // 1. is_paid column (নতুন)
        if (!Schema::hasColumn('confirm_orders', 'is_paid')) {
            Schema::table('confirm_orders', function (Blueprint $table) {
                $table->boolean('is_paid')->default(false)->after('payment_status');
            });
        }
        
        // 2. stripe_session_id (নতুন)
        if (!Schema::hasColumn('confirm_orders', 'stripe_session_id')) {
            Schema::table('confirm_orders', function (Blueprint $table) {
                $table->string('stripe_session_id')->nullable()->after('is_paid');
            });
        }
        
        // 3. stripe_payment_intent_id (নতুন)
        if (!Schema::hasColumn('confirm_orders', 'stripe_payment_intent_id')) {
            Schema::table('confirm_orders', function (Blueprint $table) {
                $table->string('stripe_payment_intent_id')->nullable()->after('stripe_session_id');
            });
        }
        
        // 4. paid_amount (নতুন)
        if (!Schema::hasColumn('confirm_orders', 'paid_amount')) {
            Schema::table('confirm_orders', function (Blueprint $table) {
                $table->decimal('paid_amount', 10, 2)->nullable()->after('total');
            });
        }
        
        // 5. payment_date (নতুন)
        if (!Schema::hasColumn('confirm_orders', 'payment_date')) {
            Schema::table('confirm_orders', function (Blueprint $table) {
                $table->timestamp('payment_date')->nullable()->after('paid_amount');
            });
        }
        
        // ✅ IMPORTANT: payment_method, payment_status, mobile_banking_method ইত্যাদি 
        // ইতিমধ্যে আছে, সেগুলো modify করবেন না
    }

    public function down()
    {
        // Revert করার সময়ও সুরক্ষিতভাবে
        
        if (Schema::hasColumn('confirm_orders', 'is_paid')) {
            Schema::table('confirm_orders', function (Blueprint $table) {
                $table->dropColumn('is_paid');
            });
        }
        
        if (Schema::hasColumn('confirm_orders', 'stripe_session_id')) {
            Schema::table('confirm_orders', function (Blueprint $table) {
                $table->dropColumn('stripe_session_id');
            });
        }
        
        if (Schema::hasColumn('confirm_orders', 'stripe_payment_intent_id')) {
            Schema::table('confirm_orders', function (Blueprint $table) {
                $table->dropColumn('stripe_payment_intent_id');
            });
        }
        
        if (Schema::hasColumn('confirm_orders', 'paid_amount')) {
            Schema::table('confirm_orders', function (Blueprint $table) {
                $table->dropColumn('paid_amount');
            });
        }
        
        if (Schema::hasColumn('confirm_orders', 'payment_date')) {
            Schema::table('confirm_orders', function (Blueprint $table) {
                $table->dropColumn('payment_date');
            });
        }
    }
};