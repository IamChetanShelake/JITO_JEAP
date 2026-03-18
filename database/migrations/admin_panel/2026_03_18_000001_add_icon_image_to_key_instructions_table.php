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
        Schema::connection('admin_panel')->table('key_instructions', function (Blueprint $table) {
            $table->string('icon_image')->nullable()->after('icon_svg');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('admin_panel')->table('key_instructions', function (Blueprint $table) {
            $table->dropColumn('icon_image');
        });
    }
};
