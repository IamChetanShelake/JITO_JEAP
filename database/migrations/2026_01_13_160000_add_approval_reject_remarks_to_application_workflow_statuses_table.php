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
        Schema::table('application_workflow_statuses', function (Blueprint $table) {
            // Apex 1
            if (!Schema::hasColumn('application_workflow_statuses', 'apex_1_approval_remarks')) {
                $table->text('apex_1_approval_remarks')->nullable()->after('apex_1_status');
            }
            if (!Schema::hasColumn('application_workflow_statuses', 'apex_1_reject_remarks')) {
                $table->text('apex_1_reject_remarks')->nullable()->after('apex_1_approval_remarks');
            }
            if (Schema::hasColumn('application_workflow_statuses', 'apex_1_remarks')) {
                $table->dropColumn('apex_1_remarks');
            }

            // Chapter
            if (!Schema::hasColumn('application_workflow_statuses', 'chapter_approval_remarks')) {
                $table->text('chapter_approval_remarks')->nullable()->after('chapter_status');
            }
            if (!Schema::hasColumn('application_workflow_statuses', 'chapter_reject_remarks')) {
                $table->text('chapter_reject_remarks')->nullable()->after('chapter_approval_remarks');
            }
            if (Schema::hasColumn('application_workflow_statuses', 'chapter_remarks')) {
                $table->dropColumn('chapter_remarks');
            }

            // Working Committee
            if (!Schema::hasColumn('application_workflow_statuses', 'working_committee_approval_remarks')) {
                $table->text('working_committee_approval_remarks')->nullable()->after('working_committee_status');
            }
            if (!Schema::hasColumn('application_workflow_statuses', 'working_committee_reject_remarks')) {
                $table->text('working_committee_reject_remarks')->nullable()->after('working_committee_approval_remarks');
            }
            if (Schema::hasColumn('application_workflow_statuses', 'working_committee_remarks')) {
                $table->dropColumn('working_committee_remarks');
            }

            // Apex 2
            if (!Schema::hasColumn('application_workflow_statuses', 'apex_2_approval_remarks')) {
                $table->text('apex_2_approval_remarks')->nullable()->after('apex_2_status');
            }
            if (!Schema::hasColumn('application_workflow_statuses', 'apex_2_reject_remarks')) {
                $table->text('apex_2_reject_remarks')->nullable()->after('apex_2_approval_remarks');
            }
            if (Schema::hasColumn('application_workflow_statuses', 'apex_2_remarks')) {
                $table->dropColumn('apex_2_remarks');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_workflow_statuses', function (Blueprint $table) {
            // Apex 1
            $table->dropColumn(['apex_1_approval_remarks', 'apex_1_reject_remarks']);
            $table->text('apex_1_remarks')->nullable()->after('apex_1_status');

            // Chapter
            $table->dropColumn(['chapter_approval_remarks', 'chapter_reject_remarks']);
            $table->text('chapter_remarks')->nullable()->after('chapter_status');

            // Working Committee
            $table->dropColumn(['working_committee_approval_remarks', 'working_committee_reject_remarks']);
            $table->text('working_committee_remarks')->nullable()->after('working_committee_status');

            // Apex 2
            $table->dropColumn(['apex_2_approval_remarks', 'apex_2_reject_remarks']);
            $table->text('apex_2_remarks')->nullable()->after('apex_2_status');
        });
    }
};
