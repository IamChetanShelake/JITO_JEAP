<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the column already exists
        $columnExists = DB::connection('admin_panel')
            ->getSchemaBuilder()
            ->hasColumn('colleges_website', 'courses');

        if (!$columnExists) {
            Schema::connection('admin_panel')->table('colleges_website', function (Blueprint $table) {
                $table->json('courses')->nullable()->after('city');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('admin_panel')->table('colleges_website', function (Blueprint $table) {
            $table->dropColumn('courses');
        });
    }
};
