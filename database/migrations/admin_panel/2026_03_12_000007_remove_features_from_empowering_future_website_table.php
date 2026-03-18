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
        Schema::table('empowering_future_website', function (Blueprint $table) {
            $table->dropColumn('features');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('empowering_future_website', function (Blueprint $table) {
            $table->string('features')->nullable();
        });
    }
};
