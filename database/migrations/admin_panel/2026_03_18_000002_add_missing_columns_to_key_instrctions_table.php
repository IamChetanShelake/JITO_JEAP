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
        // First, check if table exists with typo name and add columns
        Schema::connection('admin_panel')->table('key_instrctions', function (Blueprint $table) {
            if (!Schema::connection('admin_panel')->hasColumn('key_instrctions', 'icon_svg')) {
                $table->text('icon_svg')->nullable()->after('icon');
            }
            if (!Schema::connection('admin_panel')->hasColumn('key_instrctions', 'icon_image')) {
                $table->string('icon_image')->nullable()->after('icon_svg');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('admin_panel')->table('key_instrctions', function (Blueprint $table) {
            $table->dropColumn(['icon_svg', 'icon_image']);
        });
    }
};
