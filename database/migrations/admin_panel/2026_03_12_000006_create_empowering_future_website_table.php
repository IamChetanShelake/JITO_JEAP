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
        Schema::create('empowering_future_website', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->text('vision')->nullable();
            $table->text('vision_description')->nullable();
            $table->text('mission')->nullable();
            $table->text('mission_description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empowering_future_website');
    }
};
