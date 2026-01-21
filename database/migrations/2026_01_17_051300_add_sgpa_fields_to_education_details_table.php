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
            $table->string('school_sgpa')->nullable()->after('school_CGPA');
            $table->string('jc_sgpa')->nullable()->after('jc_CGPA');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('education_details', function (Blueprint $table) {
            $table->dropColumn(['school_sgpa', 'jc_sgpa']);
        });
    }
};