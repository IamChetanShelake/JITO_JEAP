<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('admin_panel')->table('donors', function (Blueprint $table) {
            $table->bigInteger('membership_number')->nullable()->after('phone');
        });
    }

    public function down(): void
    {
        Schema::connection('admin_panel')->table('donors', function (Blueprint $table) {
            $table->dropColumn('membership_number');
        });
    }
};