<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('admin_panel')->create('donor_family_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained('donors')->onDelete('cascade');

            // Spouse Details
            $table->string('spouse_title')->nullable();
            $table->string('spouse_name')->nullable();
            $table->date('spouse_birth_date')->nullable();
            $table->enum('jito_member', ['yes', 'no'])->nullable();
            $table->string('jito_uid')->nullable();
            $table->string('spouse_blood_group')->nullable();
            $table->integer('number_of_kids')->default(0);

            // Children Details (JSON array)
            $table->json('children_details')->nullable();

            // Status
            $table->string('submit_status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('admin_panel')->dropIfExists('donor_family_details');
    }
};
