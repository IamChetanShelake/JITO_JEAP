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
            $table->string('college_name')->nullable()->after('university_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('education_details', function (Blueprint $table) {
            $table->dropColumn('college_name');
        });
    }
};
