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
        Schema::table('education_details', function (Blueprint $table) {
            // Rename institute_name to university_name to match blade file
            $table->renameColumn('institute_name', 'university_name');

            // Add new fields for financial need overview
            $table->string('college_name')->nullable()->after('university_name');
            $table->string('start_year')->nullable()->after('country'); // Changed from date to string for month input
            $table->string('expected_year')->nullable()->after('start_year'); // Changed from date to string for month input
            $table->string('nirf_ranking')->nullable()->after('expected_year');

            // Add marks fields for school
            $table->integer('10th_mark_obtained')->nullable()->after('school_percentage');
            $table->integer('10th_mark_out_of')->nullable()->after('10th_mark_obtained');
            $table->string('school_CGPA')->nullable()->after('10th_mark_out_of');

            // Add marks fields for junior college
            $table->integer('12th_mark_obtained')->nullable()->after('jc_percentage');
            $table->integer('12th_mark_out_of')->nullable()->after('12th_mark_obtained');
            $table->string('jc_CGPA')->nullable()->after('12th_mark_out_of');

            // Update qualification years to date fields
            $table->dropColumn('qualification_years');
            $table->date('qualification_start_year')->nullable()->after('qualification_university');
            $table->date('qualification_end_year')->nullable()->after('qualification_start_year');

            // Add marksheet fields as JSON for arrays
            $table->json('marksheet_type')->nullable()->after('qualification_mode_of_study');
            $table->json('marks_obtained')->nullable()->after('marksheet_type');
            $table->json('out_of')->nullable()->after('marks_obtained');
            $table->json('percentage')->nullable()->after('out_of');
            $table->json('cgpa')->nullable()->after('percentage');

            // Add 5th year columns for financial summary
            $table->decimal('tuition_fee_year5', 15, 2)->nullable()->after('tuition_fee_year4');
            $table->decimal('group_2_year5', 15, 2)->nullable()->after('group_2_year4');
            $table->decimal('group_3_year5', 15, 2)->nullable()->after('group_3_year4');
            $table->decimal('group_4_year5', 15, 2)->nullable()->after('group_4_year4');

            // Add total columns
            $table->decimal('tuition_fee_total', 15, 2)->nullable()->after('tuition_fee_year5');
            $table->decimal('group_2_total', 15, 2)->nullable()->after('group_2_year5');
            $table->decimal('group_3_total', 15, 2)->nullable()->after('group_3_year5');
            $table->decimal('group_4_total', 15, 2)->nullable()->after('group_4_year5');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('education_details', function (Blueprint $table) {
            // Reverse the changes
            $table->renameColumn('university_name', 'institute_name');

            $table->dropColumn([
                'college_name', 'start_year', 'expected_year', 'nirf_ranking',
                '10th_mark_obtained', '10th_mark_out_of', 'school_CGPA',
                '12th_mark_obtained', '12th_mark_out_of', 'jc_CGPA',
                'qualification_start_year', 'qualification_end_year',
                'marksheet_type', 'marks_obtained', 'out_of', 'percentage', 'cgpa',
                'tuition_fee_year5', 'group_2_year5', 'group_3_year5', 'group_4_year5',
                'tuition_fee_total', 'group_2_total', 'group_3_total', 'group_4_total'
            ]);

            $table->string('qualification_years')->nullable()->after('qualification_university');
        });
    }
};
