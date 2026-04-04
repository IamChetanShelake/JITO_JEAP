<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('funding_details', function (Blueprint $table) {
            $table->tinyInteger('bank_cheque_declaration')->default(0)->nullable()->after('submit_status');
        });
    }

    public function down(): void
    {
        Schema::table('funding_details', function (Blueprint $table) {
            $table->dropColumn('bank_cheque_declaration');
        });
    }
};