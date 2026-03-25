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
        Schema::create('documents_below', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('status')->nullable();
            $table->string('submit_status')->nullable();
            $table->text('admin_remark')->nullable();
            
            // 1. SSC Marksheet
            $table->string('ssc_cbse_icse_ib_igcse')->nullable();
            
            // 2. HSC / Diploma Marksheet
            $table->string('hsc_diploma_marksheet')->nullable();
            
            // 3. College Fees Structure
            $table->string('admission_letter_fees_structure')->nullable();
            
            // 4. PAN Card - Applicant
            $table->string('pan_applicant')->nullable();
            
            // 5. Aadhaar Card - Applicant
            $table->string('aadhaar_applicant')->nullable();
            
            // 6. Jain Sangh Certificate
            $table->string('jain_sangh_certificate')->nullable();
            
            // 7. Recommendation of JITO Member
            $table->string('jito_group_recommendation')->nullable();
            
            // 8. Latest Electricity Bill
            $table->string('electricity_bill')->nullable();
            
            // 9. Aadhaar Card - Father / Mother / Guardian
            $table->string('aadhaar_father_mother')->nullable();
            
            // 10. PAN Card - Father / Mother / Guardian
            $table->string('pan_father_mother')->nullable();
            
            // 11. Form No. 16 OR Salary Slips
            $table->string('form16_salary_income_father')->nullable();
            
            // 12. Bank Statement of Father
            $table->string('bank_statement_father_12months')->nullable();
            
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents_below');
    }
};
