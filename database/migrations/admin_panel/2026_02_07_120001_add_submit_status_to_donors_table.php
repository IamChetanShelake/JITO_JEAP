<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('admin_panel')->table('donors', function (Blueprint $table) {
            $table->string('submit_status')->default('pending')->after('remember_token');
        });
    }

    public function down(): void
    {
        Schema::connection('admin_panel')->table('donors', function (Blueprint $table) {
            $table->dropColumn('submit_status');
        });
    }
};
