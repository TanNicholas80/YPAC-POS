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
        Schema::table('transactions', function (Blueprint $table) {
            $table->boolean('is_whatsapp')->default(false)->after('id');
            $table->string('customer_name')->nullable()->after('is_whatsapp');
            $table->text('customer_address')->nullable()->after('customer_name');
            $table->float('shipping_cost')->default(0)->after('total');
            $table->string('payment_proof')->nullable()->after('qris_public_id');
            $table->string('payment_proof_public_id')->nullable()->after('payment_proof');
            
            // Allow payment_method to be string and nullable (cashier can set payment_method to transfer_bank or qris later)
            $table->string('payment_method')->nullable()->change();

            // Allow user_id to be nullable (since WhatsApp checkouts are initially guest transactions)
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'is_whatsapp',
                'customer_name',
                'customer_address',
                'shipping_cost',
                'payment_proof',
                'payment_proof_public_id',
            ]);
            
            $table->enum('payment_method', ['cash', 'qris'])->change();
        });
    }
};
