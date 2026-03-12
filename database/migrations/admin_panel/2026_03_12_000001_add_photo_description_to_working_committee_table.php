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
        Schema::connection('admin_panel')->table('working_committee', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('name');
            $table->text('description')->nullable()->after('designation');
            $table->integer('display_order')->default(0)->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('admin_panel')->table('working_committee', function (Blueprint $table) {
            $table->dropColumn(['photo', 'description', 'display_order']);
        });
    }
};