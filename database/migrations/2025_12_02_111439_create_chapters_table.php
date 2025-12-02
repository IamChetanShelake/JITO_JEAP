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
            $table->foreignId('zone_id')->constrained('zones')->onDelete('cascade');
            $table->string('chapter_name');
            $table->string('code')->unique();
            $table->string('city');
            $table->string('pincode');
            $table->string('state');
            $table->string('chairman');
            $table->string('contact_no');
            $table->boolean('status')->default(true);
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
