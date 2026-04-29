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
        Schema::table('products', function (Blueprint $table) {
            $table->string('commission_type')->nullable()->after('is_enabled');
            $table->decimal('commission_value', 10, 2)->nullable()->after('commission_type');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('commission_amount', 10, 2)->default(0)->after('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['commission_type', 'commission_value']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('commission_amount');
        });
    }
};
