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
        Schema::table('familydetails', function (Blueprint $table) {
            $table->integer('recent_electricity_amount')->nullable();
            $table->integer('total_monthly_emi')->nullable();
            $table->integer('mediclaim_insurance_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('familydetails', function (Blueprint $table) {
            $table->dropColumn(['recent_electricity_amount', 'total_monthly_emi', 'mediclaim_insurance_amount']);
        });
    }
};
