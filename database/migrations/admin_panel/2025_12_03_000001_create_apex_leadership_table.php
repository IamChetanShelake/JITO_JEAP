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
        Schema::connection('admin_panel')->create('apex_leadership', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->string('designation');
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
        Schema::connection('admin_panel')->dropIfExists('apex_leadership');
    }
};
