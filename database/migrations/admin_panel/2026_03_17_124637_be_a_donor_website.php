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
        Schema::create('be_donor_website', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable();
            $table->text('benefit')->nullable();
            $table->text('description')->nullable();
            $table->string('become_member_step')->nullable();
            $table->text('what_to_do')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('be_donor_website');
    }
};
