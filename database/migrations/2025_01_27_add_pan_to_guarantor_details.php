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
        Schema::table('guarantor_details', function (Blueprint $table) {
            // Add PAN fields after aadhar card fields
            $table->string('g_one_pan', 10)->nullable()->after('g_one_aadhar_card_number');
            $table->string('g_two_pan', 10)->nullable()->after('g_two_aadhar_card_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guarantor_details', function (Blueprint $table) {
            $table->dropColumn(['g_one_pan', 'g_two_pan']);
        });
    }
};
