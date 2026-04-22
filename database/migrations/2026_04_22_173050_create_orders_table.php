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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('total', 12, 2);
            $table->string('status')->default('new'); // new, processing, shipped, delivered, cancelled
            $table->string('payment_status')->default('pending'); // pending, paid, failed
            $table->string('payment_method')->nullable(); // cod, card, etc.
            $table->json('shipping_details'); // name, email, phone, address, city
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
