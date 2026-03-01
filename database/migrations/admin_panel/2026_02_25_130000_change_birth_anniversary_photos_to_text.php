<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check if columns exist first before modifying
        $hasBirthPhoto = Schema::connection('admin_panel')->hasColumn('donor_personal_details', 'birth_photo');
        $hasAnniversaryPhoto = Schema::connection('admin_panel')->hasColumn('donor_personal_details', 'anniversary_photo');

        if ($hasBirthPhoto) {
            // First, set any NULL values or empty strings for problematic rows
            DB::connection('admin_panel')->statement(
                "UPDATE donor_personal_details SET birth_photo = '[]' WHERE birth_photo IS NULL OR birth_photo = ''"
            );

            // Use ALTER TABLE with MODIFY - allow data truncation warnings to pass
            DB::connection('admin_panel')->statement(
                "ALTER TABLE donor_personal_details MODIFY COLUMN birth_photo TEXT NOT NULL"
            );
        }

        if ($hasAnniversaryPhoto) {
            // First, set any NULL values or empty strings for problematic rows
            DB::connection('admin_panel')->statement(
                "UPDATE donor_personal_details SET anniversary_photo = '[]' WHERE anniversary_photo IS NULL OR anniversary_photo = ''"
            );

            // Use ALTER TABLE with MODIFY - allow data truncation warnings to pass
            DB::connection('admin_panel')->statement(
                "ALTER TABLE donor_personal_details MODIFY COLUMN anniversary_photo TEXT NOT NULL"
            );
        }
    }

    public function down(): void
    {
        // Check if columns exist first before modifying
        $hasBirthPhoto = Schema::connection('admin_panel')->hasColumn('donor_personal_details', 'birth_photo');
        $hasAnniversaryPhoto = Schema::connection('admin_panel')->hasColumn('donor_personal_details', 'anniversary_photo');

        if ($hasBirthPhoto) {
            DB::connection('admin_panel')->statement(
                "ALTER TABLE donor_personal_details MODIFY COLUMN birth_photo VARCHAR(255) NOT NULL"
            );
        }

        if ($hasAnniversaryPhoto) {
            DB::connection('admin_panel')->statement(
                "ALTER TABLE donor_personal_details MODIFY COLUMN anniversary_photo VARCHAR(255) NOT NULL"
            );
        }
    }
};
