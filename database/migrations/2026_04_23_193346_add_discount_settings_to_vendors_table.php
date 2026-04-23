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
        Schema::table('vendors', function (Blueprint $table) {
            $table->decimal('order_threshold', 12, 2)->nullable();
            $table->decimal('order_threshold_discount', 12, 2)->nullable();
            $table->string('order_threshold_discount_type')->default('fixed'); // fixed, percentage
            
            $table->integer('min_items_for_discount')->nullable();
            $table->decimal('items_discount_amount', 12, 2)->nullable();
            $table->string('items_discount_type')->default('fixed'); // fixed, percentage
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn([
                'order_threshold', 
                'order_threshold_discount', 
                'order_threshold_discount_type',
                'min_items_for_discount',
                'items_discount_amount',
                'items_discount_type'
            ]);
        });
    }
};
