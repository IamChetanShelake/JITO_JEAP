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
        Schema::table('documents', function (Blueprint $table) {
            // Drop old fields
            $table->dropColumn([
                'board',
                'board2',
                'graduation',
                'post_graduation',
                'fee_structure',
                'admission_letter',
                'statement',
                'visa',
                'passport',
                'applicant_aadhar',
                'applicant_pan',
                'birth_certificate',
                'electricity_bill',
                'father_itr',
                'father_balanceSheet_pr_lss_stmnt',
                'form16_salary_sleep',
                'father_mother_income',
                'loan_arrangement',
                'father_bank_stmnt',
                'mother_bank_stmnt',
                'student_main_bank_details',
                'jain_sangh_cert',
                'jatf_recommendation',
                'other_docs',
                'extra_curri'
            ]);

            // Add new fields
            $table->string('ssc_cbse_icse_ib_igcse')->nullable();
            $table->string('hsc_diploma_marksheet')->nullable();
            $table->string('graduate_post_graduate_marksheet')->nullable();
            $table->string('admission_letter_fees_structure')->nullable();
            $table->string('passport_applicant')->nullable();
            $table->string('visa_applicant')->nullable();
            $table->string('aadhaar_applicant')->nullable();
            $table->string('pan_applicant')->nullable();
            $table->string('student_bank_details_statement')->nullable();
            $table->string('jito_group_recommendation')->nullable();
            $table->string('jain_sangh_certificate')->nullable();
            $table->string('electricity_bill')->nullable();
            $table->string('itr_acknowledgement_father')->nullable();
            $table->string('itr_computation_father')->nullable();
            $table->string('form16_salary_income_father')->nullable();
            $table->string('bank_statement_father_12months')->nullable();
            $table->string('bank_statement_mother_12months')->nullable();
            $table->string('aadhaar_father_mother')->nullable();
            $table->string('pan_father_mother')->nullable();
            $table->string('proof_funds_arranged')->nullable();
            $table->string('guarantor1_aadhaar')->nullable();
            $table->string('guarantor1_pan')->nullable();
            $table->string('guarantor2_aadhaar')->nullable();
            $table->string('guarantor2_pan')->nullable();
            $table->string('student_handwritten_statement')->nullable();
            $table->string('other_documents')->nullable();
            $table->string('extra_curricular')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            // Drop new fields
            $table->dropColumn([
                'ssc_cbse_icse_ib_igcse',
                'hsc_diploma_marksheet',
                'graduate_post_graduate_marksheet',
                'admission_letter_fees_structure',
                'passport_applicant',
                'visa_applicant',
                'aadhaar_applicant',
                'pan_applicant',
                'student_bank_details_statement',
                'jito_group_recommendation',
                'jain_sangh_certificate',
                'electricity_bill',
                'itr_acknowledgement_father',
                'itr_computation_father',
                'form16_salary_income_father',
                'bank_statement_father_12months',
                'bank_statement_mother_12months',
                'aadhaar_father_mother',
                'pan_father_mother',
                'proof_funds_arranged',
                'guarantor1_aadhaar',
                'guarantor1_pan',
                'guarantor2_aadhaar',
                'guarantor2_pan',
                'student_handwritten_statement',
                'other_documents',
                'extra_curricular'
            ]);

            // Add back old fields
            $table->string('board')->nullable();
            $table->string('board2')->nullable();
            $table->string('graduation')->nullable();
            $table->string('post_graduation')->nullable();
            $table->string('fee_structure')->nullable();
            $table->string('admission_letter')->nullable();
            $table->string('statement')->nullable();
            $table->string('visa')->nullable();
            $table->string('passport')->nullable();
            $table->string('applicant_aadhar')->nullable();
            $table->string('applicant_pan')->nullable();
            $table->string('birth_certificate')->nullable();
            $table->string('electricity_bill')->nullable();
            $table->string('father_itr')->nullable();
            $table->string('father_balanceSheet_pr_lss_stmnt')->nullable();
            $table->string('form16_salary_sleep')->nullable();
            $table->string('father_mother_income')->nullable();
            $table->string('loan_arrangement')->nullable();
            $table->string('father_bank_stmnt')->nullable();
            $table->string('mother_bank_stmnt')->nullable();
            $table->string('student_main_bank_details')->nullable();
            $table->string('jain_sangh_cert')->nullable();
            $table->string('jatf_recommendation')->nullable();
            $table->string('other_docs')->nullable();
            $table->string('extra_curri')->nullable();
        });
    }
};
