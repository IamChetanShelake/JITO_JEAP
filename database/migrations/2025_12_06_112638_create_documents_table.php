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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Education Documents
            $table->string('board')->nullable();
            $table->string('board2')->nullable();
            $table->string('graduation')->nullable();
            $table->string('post_graduation')->nullable();
            $table->string('fee_structure')->nullable();
            $table->string('admission_letter')->nullable();
            $table->string('statement')->nullable();

            // Identity & Address Proof
            $table->string('visa')->nullable();
            $table->string('passport')->nullable();
            $table->string('applicant_aadhar')->nullable();
            $table->string('applicant_pan')->nullable();
            $table->string('birth_certificate')->nullable();
            $table->string('electricity_bill')->nullable();

            // Financial Documents
            $table->string('father_itr')->nullable();
            $table->string('father_balanceSheet_pr_lss_stmnt')->nullable();
            $table->string('form16_salary_sleep')->nullable();
            $table->string('father_mother_income')->nullable();
            $table->string('loan_arrangement')->nullable();
            $table->string('father_bank_stmnt')->nullable();
            $table->string('mother_bank_stmnt')->nullable();
            $table->string('student_main_bank_details')->nullable();

            // Additional Documents
            $table->string('jain_sangh_cert')->nullable();
            $table->string('jatf_recommendation')->nullable();
            $table->string('other_docs')->nullable();
            $table->string('extra_curri')->nullable();

            $table->string('status')->default('step6_completed');
            $table->enum('submit_status', ['pending', 'submited', 'approved', 'resubmit'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
