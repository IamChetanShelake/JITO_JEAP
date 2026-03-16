<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'admin_panel';
    
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('empowering_dreams', function (Blueprint $table) {
            $table->text('vision_description')->nullable()->after('description');
            $table->text('mission_description')->nullable()->after('vision_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('empowering_dreams', function (Blueprint $table) {
            $table->dropColumn(['vision_description', 'mission_description']);
        });
    }
};
