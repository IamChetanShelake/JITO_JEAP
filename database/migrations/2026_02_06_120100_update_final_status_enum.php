<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement(
            "ALTER TABLE application_workflow_statuses MODIFY final_status " .
            "ENUM('in_progress','rejected','approved','hold','disbursement_in_progress','disbursement_completed','loan_closed') " .
            "NOT NULL DEFAULT 'in_progress'"
        );
    }

    public function down(): void
    {
        DB::statement(
            "ALTER TABLE application_workflow_statuses MODIFY final_status " .
            "ENUM('in_progress','rejected','approved') " .
            "NOT NULL DEFAULT 'in_progress'"
        );
    }
};
