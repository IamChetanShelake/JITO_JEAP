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
        Schema::table('education_details', function (Blueprint $table) {
            $table->renameColumn('tuition_fee_year1', 'group_1_year1');
            $table->renameColumn('tuition_fee_year2', 'group_1_year2');
            $table->renameColumn('tuition_fee_year3', 'group_1_year3');
            $table->renameColumn('tuition_fee_year4', 'group_1_year4');
            $table->renameColumn('tuition_fee_year5', 'group_1_year5');
            $table->renameColumn('tuition_fee_total', 'group_1_total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('education_details', function (Blueprint $table) {
            $table->renameColumn('group_1_year1', 'tuition_fee_year1');
            $table->renameColumn('group_1_year2', 'tuition_fee_year2');
            $table->renameColumn('group_1_year3', 'tuition_fee_year3');
            $table->renameColumn('group_1_year4', 'tuition_fee_year4');
            $table->renameColumn('group_1_year5', 'tuition_fee_year5');
            $table->renameColumn('group_1_total', 'tuition_fee_total');
        });
    }
};
