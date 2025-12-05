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
        Schema::create('familydetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('number_family_members')->nullable();
            $table->integer('total_family_income')->nullable();
            $table->integer('total_students')->nullable();
            $table->integer('family_member_diksha')->nullable()->nullable();
            $table->integer('total_insurance_coverage')->nullable();
            $table->integer('total_premium_paid')->nullable();
            // Father details
            $table->string('father_name')->nullable();
            $table->integer('father_age')->nullable();
            $table->string('father_marital_status')->nullable();
            $table->string('father_qualification')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('father_mobile')->nullable();
            $table->string('father_email')->nullable();
            $table->integer('father_yearly_gross_income')->nullable();
            $table->integer('father_individual_insurance_coverage')->nullable();
            $table->integer('father_individual_premium_paid')->nullable();
            $table->string('father_aadhaar')->nullable();
            $table->string('father_photo')->nullable();
            // Mother details
            $table->string('mother_name')->nullable();
            $table->integer('mother_age')->nullable();
            $table->string('mother_marital_status')->nullable();
            $table->string('mother_qualification')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->string('mother_mobile')->nullable();
            $table->string('mother_email')->nullable();
            $table->integer('mother_yearly_gross_income')->nullable();
            $table->integer('mother_individual_insurance_coverage')->nullable();
            $table->integer('mother_individual_premium_paid')->nullable();
            $table->string('mother_aadhaar')->nullable();
            $table->string('mother_photo')->nullable();
            // Siblings
            $table->string('has_sibling');
            $table->integer('number_of_siblings')->nullable();
            $table->string('sibling_name_1')->nullable();
            $table->string('sibling_qualification')->nullable();
            $table->string('sibling_occupation')->nullable();
            $table->string('sibling_mobile')->nullable();
            $table->string('sibling_email')->nullable();
            $table->integer('sibling_yearly_income')->nullable();
            $table->integer('sibling_insurance_coverage')->nullable();
            $table->integer('sibling_premium_paid')->nullable();
            // Scholar details
            $table->string('additional_email')->nullable();
            $table->integer('yearly_gross_income')->nullable();
            $table->integer('individual_insurance_coverage');
            $table->integer('individual_premium_paid');
            // Relatives
            $table->string('paternal_uncle_name')->nullable();
            $table->string('paternal_uncle_mobile')->nullable();
            $table->string('paternal_uncle_email')->nullable();
            $table->string('paternal_aunt_name')->nullable();
            $table->string('paternal_aunt_mobile')->nullable();
            $table->string('paternal_aunt_email')->nullable();
            $table->string('maternal_uncle_name')->nullable();
            $table->string('maternal_uncle_mobile')->nullable();
            $table->string('maternal_uncle_email')->nullable();
            $table->string('maternal_aunt_name')->nullable();
            $table->string('maternal_aunt_mobile')->nullable();
            $table->string('maternal_aunt_email')->nullable();
            $table->enum('status', ['pending', 'completed', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('familydetails');
    }
};
