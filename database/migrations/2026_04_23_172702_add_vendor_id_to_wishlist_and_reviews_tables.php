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
        Schema::table('wishlists', function (Blueprint $table) {
            $table->unsignedBigInteger('vendor_id')->nullable()->after('user_id')->index();
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('vendor_id')->nullable()->after('product_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropColumn('vendor_id');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('vendor_id');
        });
    }
};
