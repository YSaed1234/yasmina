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
            $table->decimal('commission_percentage', 5, 2)->default(0)->after('status');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('commission_amount', 10, 2)->default(0)->after('vendor_discount_type');
            $table->decimal('vendor_net_amount', 10, 2)->default(0)->after('commission_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn('commission_percentage');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['commission_amount', 'vendor_net_amount']);
        });
    }
};
