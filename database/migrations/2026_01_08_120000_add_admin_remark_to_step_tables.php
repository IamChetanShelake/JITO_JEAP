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
        $tables = [
            'familydetails',
            'education_details',
            'funding_details',
            'guarantor_details',
            'documents'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    if (!Schema::hasColumn($table->getTable(), 'admin_remark')) {
                        $table->text('admin_remark')->nullable()->after('submit_status');
                    }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'familydetails',
            'education_details',
            'funding_details',
            'guarantor_details',
            'documents'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    if (Schema::hasColumn($table->getTable(), 'admin_remark')) {
                        $table->dropColumn('admin_remark');
                    }
                });
            }
        }
    }
};
