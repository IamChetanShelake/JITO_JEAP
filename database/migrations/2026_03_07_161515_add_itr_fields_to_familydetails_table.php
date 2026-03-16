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
        $table->string('current_year_itr')->nullable();
        $table->string('last_year_itr')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
public function down(): void
{
    Schema::table('familydetails', function (Blueprint $table) {
        $table->dropColumn(['current_year_itr', 'last_year_itr']);
    });
}
};
