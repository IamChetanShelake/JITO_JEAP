<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReportTemplate;

class ReportTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $predefinedReports = [
            [
                'name' => 'Student Summary',
                'description' => 'Basic student information including name, mobile, course, and chapter',
                'selected_fields' => [
                    'name',
                    'mobile',
                    'application_number',
                    'education.course_name',
                    'education.institution_name',
                    'chapter.name',
                    'application_status',
                ],
                'category' => 'student',
            ],
            [
                'name' => 'Payment Summary',
                'description' => 'Payment and funding details including loan amount and assistance',
                'selected_fields' => [
                    'name',
                    'application_number',
                    'funding.loan_amount_requested',
                    'funding.loan_category',
                    'workflow.assistance_amount',
                    'approval.approved_amount',
                    'approval.disbursement_system',
                ],
                'category' => 'payment',
            ],
            [
                'name' => 'Chapter Report',
                'description' => 'Students grouped by chapter with key details',
                'selected_fields' => [
                    'chapter.name',
                    'chapter.zone',
                    'name',
                    'mobile',
                    'application_number',
                    'education.course_name',
                    'application_status',
                ],
                'category' => 'chapter',
            ],
            [
                'name' => 'Family Details Report',
                'description' => 'Complete family information for all students',
                'selected_fields' => [
                    'name',
                    'application_number',
                    'family.father_name',
                    'family.father_mobile',
                    'family.father_occupation',
                    'family.father_annual_income',
                    'family.mother_name',
                    'family.mother_mobile',
                    'family.mother_occupation',
                    'family.mother_annual_income',
                    'family.total_family_members',
                    'family.annual_family_income',
                ],
                'category' => 'student',
            ],
            [
                'name' => 'Education Details Report',
                'description' => 'Complete education and course information',
                'selected_fields' => [
                    'name',
                    'application_number',
                    'education.course_name',
                    'education.course_type',
                    'education.institution_name',
                    'education.university_name',
                    'education.start_year',
                    'education.expected_year',
                    'education.course_duration',
                    'education.tuition_fee',
                    'education.hostel_fee',
                    'education.other_fee',
                ],
                'category' => 'student',
            ],
            [
                'name' => 'Workflow Status Report',
                'description' => 'Current workflow and approval status of all applications',
                'selected_fields' => [
                    'name',
                    'application_number',
                    'workflow.stage',
                    'workflow.status',
                    'workflow.final_status',
                    'workflow.assistance_amount',
                    'approval.meeting_no',
                    'pdc.courier_receive_status',
                ],
                'category' => 'other',
            ],
            [
                'name' => '15-Day Report',
                'description' => 'Applications from the last 15 days',
                'selected_fields' => [
                    'name',
                    'mobile',
                    'application_number',
                    'created_at',
                    'education.course_name',
                    'chapter.name',
                    'application_status',
                ],
                'category' => 'student',
            ],
            [
                'name' => 'Monthly Report',
                'description' => 'Applications from the current month',
                'selected_fields' => [
                    'name',
                    'mobile',
                    'application_number',
                    'created_at',
                    'education.course_name',
                    'chapter.name',
                    'application_status',
                    'funding.loan_amount_requested',
                ],
                'category' => 'student',
            ],
            [
                'name' => 'Complete Student Profile',
                'description' => 'Comprehensive student profile with all key information',
                'selected_fields' => [
                    'name',
                    'mobile',
                    'email',
                    'application_number',
                    'date_of_birth',
                    'gender',
                    'city',
                    'state',
                    'pincode',
                    'education.course_name',
                    'education.institution_name',
                    'chapter.name',
                    'application_status',
                    'created_at',
                ],
                'category' => 'student',
            ],
            [
                'name' => 'Disbursement Report',
                'description' => 'Disbursement details and payment schedules',
                'selected_fields' => [
                    'name',
                    'application_number',
                    'approval.meeting_no',
                    'approval.disbursement_system',
                    'approval.approved_amount',
                    'pdc.courier_receive_status',
                    'pdc.courier_receive_date',
                    'workflow.final_status',
                ],
                'category' => 'payment',
            ],
        ];

        foreach ($predefinedReports as $report) {
            ReportTemplate::create([
                'name' => $report['name'],
                'description' => $report['description'],
                'selected_fields' => $report['selected_fields'],
                'filters' => [],
                'is_predefined' => true,
                'category' => $report['category'],
                'created_by' => null, // System created
            ]);
        }

        $this->command->info('Predefined reports seeded successfully!');
    }
}