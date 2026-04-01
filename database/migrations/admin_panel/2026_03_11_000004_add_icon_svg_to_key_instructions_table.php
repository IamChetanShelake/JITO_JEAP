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
        if (!Schema::connection('admin_panel')->hasTable('key_instructions')) {
            return;
        }

        if (!Schema::connection('admin_panel')->hasColumn('key_instructions', 'icon_svg')) {
            Schema::connection('admin_panel')->table('key_instructions', function (Blueprint $table) {
                $table->text('icon_svg')->nullable()->after('icon');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::connection('admin_panel')->hasTable('key_instructions')) {
            return;
        }

        if (Schema::connection('admin_panel')->hasColumn('key_instructions', 'icon_svg')) {
            Schema::connection('admin_panel')->table('key_instructions', function (Blueprint $table) {
                $table->dropColumn('icon_svg');
            });
        }
    }
};
