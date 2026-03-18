<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pdc_details', function (Blueprint $table) {
            $table->json('courier_receive_verified_documents')->nullable()->after('courier_receive_processed_at');
        });
    }

    public function down(): void
    {
        Schema::table('pdc_details', function (Blueprint $table) {
            $table->dropColumn('courier_receive_verified_documents');
        });
    }
};
