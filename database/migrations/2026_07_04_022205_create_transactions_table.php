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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->float('subtotal');
            $table->float('tax');
            $table->float('total');
            $table->enum('payment_method', ['cash', 'qris']);
            $table->float('amount_paid')->nullable();
            $table->float('change_amount')->nullable();
            $table->string('qris_image')->nullable();
            $table->string('qris_public_id')->nullable();
            $table->enum('status', ['pending', 'completed', 'cancelled']);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
