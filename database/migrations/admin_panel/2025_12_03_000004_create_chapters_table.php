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
        Schema::connection('admin_panel')->create('chapters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('zone_id');
            $table->string('chapter_head');
            $table->string('chapter_name');
            $table->string('city');
            $table->string('pincode');
            $table->string('state');
            $table->string('email')->unique();
            $table->string('contact');
            $table->boolean('status')->default(true);
            $table->boolean('show_hide')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('admin_panel')->dropIfExists('chapters');
    }
};
