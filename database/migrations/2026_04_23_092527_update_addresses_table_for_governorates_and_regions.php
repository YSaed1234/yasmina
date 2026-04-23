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
        Schema::table('addresses', function (Blueprint $table) {
            if (!Schema::hasColumn('addresses', 'governorate_id')) {
                $table->foreignId('governorate_id')->nullable()->constrained()->onDelete('set null');
            }
            if (!Schema::hasColumn('addresses', 'region_id')) {
                $table->foreignId('region_id')->nullable()->constrained()->onDelete('set null');
            }
            if (Schema::hasColumn('addresses', 'shipping_zone_id')) {
                $table->dropForeign(['shipping_zone_id']);
                $table->dropColumn('shipping_zone_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            if (Schema::hasColumn('addresses', 'governorate_id')) {
                $table->dropConstrainedForeignId('governorate_id');
            }
            if (Schema::hasColumn('addresses', 'region_id')) {
                $table->dropConstrainedForeignId('region_id');
            }
            if (!Schema::hasColumn('addresses', 'shipping_zone_id')) {
                $table->foreignId('shipping_zone_id')->nullable()->constrained('shipping_zones')->onDelete('set null');
            }
        });
    }
};
