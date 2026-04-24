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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->enum('type', ['bogo_same', 'bogo_different']);
            $table->foreignId('buy_product_id')->constrained('products')->onDelete('cascade');
            $table->integer('buy_quantity')->default(1);
            $table->foreignId('get_product_id')->nullable()->constrained('products')->onDelete('cascade');
            $table->integer('get_quantity')->default(1);
            $table->enum('discount_type', ['percentage', 'fixed', 'free']);
            $table->decimal('discount_value', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
