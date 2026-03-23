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
        Schema::connection('admin_panel')->table('admin_about_jito_website', function (Blueprint $table) {
            if (!Schema::connection('admin_panel')->hasColumn('admin_about_jito_website', 'number')) {
                $table->string('number')->nullable()->after('image');
            }
            if (!Schema::connection('admin_panel')->hasColumn('admin_about_jito_website', 'stat_text')) {
                $table->string('stat_text')->nullable()->after('number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('admin_panel')->table('admin_about_jito_website', function (Blueprint $table) {
            if (Schema::connection('admin_panel')->hasColumn('admin_about_jito_website', 'stat_text')) {
                $table->dropColumn('stat_text');
            }
            if (Schema::connection('admin_panel')->hasColumn('admin_about_jito_website', 'number')) {
                $table->dropColumn('number');
            }
        });
    }
};
