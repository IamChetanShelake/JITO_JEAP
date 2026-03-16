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
        Schema::table('edit_bank_detail_requests', function (Blueprint $table) {
            $table->string('bank_update_status')
                ->nullable()
                ->default('pending')
                ->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('edit_bank_detail_requests', function (Blueprint $table) {
            $table->dropColumn('bank_update_status');
        });
    }
};
