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
        Schema::create('our_testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // Title of the testimonial
            $table->string('image')->nullable(); // Image path for the person
            $table->text('about')->nullable(); // About the person
            $table->text('feedback')->nullable(); // The testimonial feedback
            $table->string('name')->nullable(); // Name of the person giving testimonial
            $table->date('date')->nullable(); // Date of the testimonial

            $table->integer('display_order')->default(0); // For ordering testimonials
            $table->boolean('is_active')->default(true); // Status of the testimonial
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('our_testimonials');
    }
};