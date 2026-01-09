<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'admin_remark')) {
            Schema::table('users', function (Blueprint $table) {
                $table->text('admin_remark')->nullable()->after('submit_status');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'admin_remark')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('admin_remark');
            });
        }
    }
};
