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
        Schema::table('key_instructions', function (Blueprint $table) {
            if (!Schema::hasColumn('key_instructions', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('order');
            }
            if (!Schema::hasColumn('key_instructions', 'display_order')) {
                $table->integer('display_order')->default(0)->after('is_active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('key_instructions', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'display_order']);
        });
    }
};
