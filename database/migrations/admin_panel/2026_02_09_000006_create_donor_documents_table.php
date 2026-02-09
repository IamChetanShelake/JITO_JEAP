<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('admin_panel')->create('donor_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained('donors')->onDelete('cascade');

            // Document Files
            $table->string('pan_member_file')->nullable();
            $table->string('pan_donor_file')->nullable();
            $table->string('photo_file')->nullable();
            $table->string('address_proof_file')->nullable();
            $table->string('authorization_letter_file')->nullable();

            // Checklist
            $table->boolean('check_signature')->default(false);
            $table->boolean('check_contact')->default(false);
            $table->boolean('check_nominee')->default(false);
            $table->boolean('check_pan')->default(false);
            $table->boolean('check_payment')->default(false);

            // Status
            $table->string('submit_status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('admin_panel')->dropIfExists('donor_documents');
    }
};
