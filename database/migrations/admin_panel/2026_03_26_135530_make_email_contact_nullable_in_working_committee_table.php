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
        Schema::connection('admin_panel')->table('working_committee', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->string('contact')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('admin_panel')->table('working_committee', function (Blueprint $table) {
            $table->string('email')->unique()->change();
            $table->string('contact')->change();
        });
    }
};
