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
            $table->dropColumn('qualifications');
            $table->enum('qualifications', ['diploma', 'graduation', 'masters', 'phd', 'none'])->nullable()->after('current_mode_of_study');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('education_details', function (Blueprint $table) {
            $table->dropColumn('qualifications');
            $table->string('qualifications')->nullable()->after('current_mode_of_study');
        });
    }
};
