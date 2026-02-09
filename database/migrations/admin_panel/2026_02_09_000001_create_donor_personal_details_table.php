<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('admin_panel')->create('donor_personal_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained('donors')->onDelete('cascade');

            // Title and Name
            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('surname')->nullable();

            // Address
            $table->text('complete_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('resi_landline')->nullable();

            // Contact
            $table->string('mobile_no')->nullable();
            $table->string('whatsapp_no')->nullable();
            $table->string('email_id_1')->nullable();
            $table->string('email_id_2')->nullable();

            // Preferred Address
            $table->text('preferred_residence_address')->nullable();
            $table->text('preferred_office_address')->nullable();

            // Personal Details
            $table->string('pan_no')->nullable();
            $table->string('chapter_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('anniversary_date')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('mother_tongue')->nullable();
            $table->string('district_of_native_place')->nullable();
            $table->string('fathers_name')->nullable();
            $table->string('hobby_1')->nullable();
            $table->string('hobby_2')->nullable();

            // Status
            $table->string('submit_status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('admin_panel')->dropIfExists('donor_personal_details');
    }
};
