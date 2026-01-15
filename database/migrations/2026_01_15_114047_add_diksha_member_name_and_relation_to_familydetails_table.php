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
            $table->string('diksha_member_name')->nullable();
            $table->string('diksha_member_relation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('familydetails', function (Blueprint $table) {
            $table->dropColumn(['diksha_member_name', 'diksha_member_relation']);
        });
    }
};
