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
            $table->string('start_year')->nullable()->change(); // Change from date to string
            $table->string('expected_year')->nullable()->change(); // Change from date to string
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('education_details', function (Blueprint $table) {
            $table->date('start_year')->nullable()->change(); // Change back to date
            $table->date('expected_year')->nullable()->change(); // Change back to date
        });
    }
};
