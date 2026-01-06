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
            // Drop old pan card fields
            $table->dropColumn(['g_one_pan_card_no', 'g_one_pan_card_upload', 'g_two_pan_card_no', 'g_two_pan_card_upload']);

            // Drop attorney fields
            $table->dropColumn(['attorney_name', 'attorney_email', 'attorney_phone', 'attorney_address', 'attorney_relation_with_student']);

            // Drop old address fields to replace with split fields
            $table->dropColumn(['g_one_permanent_address', 'g_two_permanent_address']);

            // Add new address fields for first guarantor
            $table->text('g_one_permanent_flat_no')->nullable();
            $table->text('g_one_permanent_address')->nullable();
            $table->string('g_one_permanent_city')->nullable();
            $table->string('g_one_permanent_district')->nullable();
            $table->string('g_one_permanent_state')->nullable();
            $table->string('g_one_permanent_pincode', 10)->nullable();

            // Add new address fields for second guarantor
            $table->text('g_two_permanent_flat_no')->nullable();
            $table->text('g_two_permanent_address')->nullable();
            $table->string('g_two_permanent_city')->nullable();
            $table->string('g_two_permanent_district')->nullable();
            $table->string('g_two_permanent_state')->nullable();
            $table->string('g_two_permanent_pincode', 10)->nullable();

            // Add business name fields
            $table->string('g_one_srvice')->nullable();
            $table->string('g_two_srvice')->nullable();

            // Change income to integer
            $table->integer('g_one_income')->nullable()->change();
            $table->integer('g_two_income')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
