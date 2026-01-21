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
        // Column already added in create_review_submits_table migration
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('review_submits', function (Blueprint $table) {
            //
        });
    }
};
