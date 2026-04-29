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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('commission_type')->nullable()->after('commission_amount');
            $table->decimal('commission_value', 10, 2)->nullable()->after('commission_type');
            $table->string('product_commission_type')->nullable()->after('commission_value');
            $table->decimal('product_commission_value', 10, 2)->nullable()->after('product_commission_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['commission_type', 'commission_value', 'product_commission_type', 'product_commission_value']);
        });
    }
};
