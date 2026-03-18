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
        Schema::create('universities_website_migration', function (Blueprint $table) {
            $table->id();
            $table->string('university_name');
            $table->string('location')->nullable();
            $table->enum('university_type', ['domestic', 'foreign'])->default('domestic');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('universities_website_migration');
    }
};
