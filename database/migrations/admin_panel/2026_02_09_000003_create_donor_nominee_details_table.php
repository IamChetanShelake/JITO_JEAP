<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('admin_panel')->create('donor_nominee_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained('donors')->onDelete('cascade');

            // Nominee Details
            $table->string('nominee_title')->nullable();
            $table->string('nominee_name')->nullable();
            $table->string('nominee_relationship')->nullable();
            $table->string('nominee_mobile')->nullable();
            $table->text('nominee_address')->nullable();
            $table->string('nominee_city')->nullable();
            $table->string('nominee_pincode')->nullable();

            // Status
            $table->string('submit_status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('admin_panel')->dropIfExists('donor_nominee_details');
    }
};
