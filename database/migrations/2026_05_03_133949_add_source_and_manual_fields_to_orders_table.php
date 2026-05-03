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
            $table->string('source')->default('web')->after('status');
            $table->boolean('is_manual')->default(false)->after('source');
            $table->string('customer_name')->nullable()->after('is_manual');
            $table->string('customer_phone')->nullable()->after('customer_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['source', 'is_manual', 'customer_name', 'customer_phone']);
        });
    }
};
