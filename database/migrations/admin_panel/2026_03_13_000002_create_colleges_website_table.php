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
        Schema::connection('admin_panel')->create('colleges_website', function (Blueprint $table) {
            $table->id();
            $table->string('college_name');
            $table->string('university_name');
            $table->enum('college_type', ['domestic', 'foreign']);
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
        Schema::connection('admin_panel')->dropIfExists('colleges_website');
    }
};
