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
        $schema = Schema::connection('admin_panel');

        if ($schema->hasTable('key_instrctions') && !$schema->hasTable('key_instructions')) {
            $schema->rename('key_instrctions', 'key_instructions');
        }

        if (!$schema->hasTable('key_instructions')) {
            return;
        }

        if (!$schema->hasColumn('key_instructions', 'icon_svg')) {
            $schema->table('key_instructions', function (Blueprint $table) {
                $table->text('icon_svg')->nullable()->after('icon');
            });
        }

        if (!$schema->hasColumn('key_instructions', 'icon_image')) {
            $schema->table('key_instructions', function (Blueprint $table) {
                $table->string('icon_image')->nullable()->after('icon_svg');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $schema = Schema::connection('admin_panel');

        if (!$schema->hasTable('key_instructions')) {
            return;
        }

        $columnsToDrop = [];
        if ($schema->hasColumn('key_instructions', 'icon_svg')) {
            $columnsToDrop[] = 'icon_svg';
        }
        if ($schema->hasColumn('key_instructions', 'icon_image')) {
            $columnsToDrop[] = 'icon_image';
        }

        if (!empty($columnsToDrop)) {
            $schema->table('key_instructions', function (Blueprint $table) use ($columnsToDrop) {
                $table->dropColumn($columnsToDrop);
            });
        }
    }
};
