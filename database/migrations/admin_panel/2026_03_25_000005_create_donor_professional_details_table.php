<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('admin_panel')->create('donor_professional_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained('donors')->onDelete('cascade');

            // Company Details
            $table->string('company_name')->nullable();
            $table->string('company_activity_details')->nullable();
            $table->string('designation')->nullable();
            $table->string('company_website')->nullable();

            // Office Address
            $table->text('office_address')->nullable();
            $table->string('office_state')->nullable();
            $table->string('office_city')->nullable();
            $table->string('office_pincode')->nullable();
            $table->string('office_telephone')->nullable();
            $table->string('office_mobile')->nullable();

            // PAN
            $table->string('pan_no')->nullable();

            // Coordinator Details
            $table->string('coordinator_name')->nullable();
            $table->string('coordinator_mobile')->nullable();
            $table->string('coordinator_email_1')->nullable();
            $table->string('coordinator_email_2')->nullable();

            // Status
            $table->string('submit_status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('admin_panel')->dropIfExists('donor_professional_details');
    }
};
