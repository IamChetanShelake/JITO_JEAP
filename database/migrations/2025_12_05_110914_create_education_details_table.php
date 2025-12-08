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
        Schema::create('education_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Current Education
            $table->enum('current_pursuing', ['yes', 'no']);
            $table->string('current_course_name')->nullable();
            $table->string('current_institution')->nullable();
            $table->string('current_university')->nullable();
            $table->integer('current_start_year')->nullable();
            $table->integer('current_expected_year')->nullable();
            $table->enum('current_mode_of_study', ['full-time', 'part-time', 'distance', 'online'])->nullable();

            // Completed Qualifications
            $table->enum('qualifications', ['diploma', 'graduation', 'masters', 'phd', 'none'])->nullable();
            $table->string('qualification_course_name')->nullable();
            $table->string('qualification_institution')->nullable();
            $table->string('qualification_university')->nullable();
            $table->string('qualification_specialization')->nullable();
            $table->string('qualification_years')->nullable();
            $table->string('qualification_percentage')->nullable();
            $table->enum('qualification_mode_of_study', ['full-time', 'part-time', 'distance', 'online'])->nullable();

            // Junior College (12th Grade)
            $table->string('jc_college_name')->nullable();
            $table->string('jc_stream')->nullable();
            $table->string('jc_board')->nullable();
            $table->integer('jc_completion_year')->nullable();
            $table->string('jc_percentage')->nullable();

            // School / 10th Grade Information
            $table->string('school_name')->nullable();
            $table->string('school_board')->nullable();
            $table->integer('school_completion_year')->nullable();
            $table->string('school_percentage')->nullable();

            // Additional Curriculum
            $table->string('ielts_overall_band_year')->nullable();
            $table->string('toefl_score_year')->nullable();
            $table->string('duolingo_det_score_year')->nullable();
            $table->string('gre_score_year')->nullable();
            $table->string('gmat_score_year')->nullable();
            $table->string('sat_score_year')->nullable();

            // Work Experience
            $table->enum('have_work_experience', ['yes', 'no'])->nullable();
            $table->string('organization_name')->nullable();
            $table->string('work_profile')->nullable();
            $table->string('work_duration')->nullable();
            $table->string('work_location_city')->nullable();
            $table->string('work_country')->nullable();
            $table->enum('work_type', ['full-time', 'internship', 'freelance', 'volunteer'])->nullable();

            // Additional Achievements
            $table->text('awards_recognition')->nullable();
            $table->text('volunteer_work')->nullable();
            $table->text('leadership_roles')->nullable();
            $table->text('sports_cultural')->nullable();

            // Financial Need Overview
            $table->string('institute_name')->nullable();
            $table->string('course_name')->nullable();
            $table->string('city_name')->nullable();
            $table->string('country')->nullable();
            $table->integer('duration')->nullable();

            // Financial Summary Table
            $table->decimal('tuition_fee_year1', 15, 2)->nullable();
            $table->decimal('tuition_fee_year2', 15, 2)->nullable();
            $table->decimal('tuition_fee_year3', 15, 2)->nullable();
            $table->decimal('tuition_fee_year4', 15, 2)->nullable();
            $table->decimal('group_2_year1', 15, 2)->nullable();
            $table->decimal('group_2_year2', 15, 2)->nullable();
            $table->decimal('group_2_year3', 15, 2)->nullable();
            $table->decimal('group_2_year4', 15, 2)->nullable();
            $table->decimal('group_3_year1', 15, 2)->nullable();
            $table->decimal('group_3_year2', 15, 2)->nullable();
            $table->decimal('group_3_year3', 15, 2)->nullable();
            $table->decimal('group_3_year4', 15, 2)->nullable();
            $table->decimal('group_4_year1', 15, 2)->nullable();
            $table->decimal('group_4_year2', 15, 2)->nullable();
            $table->decimal('group_4_year3', 15, 2)->nullable();
            $table->decimal('group_4_year4', 15, 2)->nullable();

            $table->string('status')->default('step3_completed');
            $table->enum('submit_status', ['pending', 'submited', 'approved', 'resubmit'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education_details');
    }
};
