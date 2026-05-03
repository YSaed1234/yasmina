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
            $table->string('manager_name')->nullable()->after('subscription_fees');
            $table->string('manager_id_number')->nullable()->after('manager_name');
            $table->string('manager_phone')->nullable()->after('manager_id_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn(['manager_name', 'manager_id_number', 'manager_phone']);
        });
    }
};
