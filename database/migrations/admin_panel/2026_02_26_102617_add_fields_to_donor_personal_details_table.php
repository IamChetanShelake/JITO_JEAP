<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('admin_panel')->table('donor_personal_details', function (Blueprint $table) {

            if (!Schema::connection('admin_panel')->hasColumn('donor_personal_details', 'resi_pin_code')) {
                $table->string('resi_pin_code')->nullable()->after('preferred_residence_address');
            }

            if (!Schema::connection('admin_panel')->hasColumn('donor_personal_details', 'jatf_member')) {
                $table->enum('jatf_member', ['yes', 'no'])->nullable()->after('jito_member');
            }

            if (!Schema::connection('admin_panel')->hasColumn('donor_personal_details', 'arogyam_member')) {
                $table->enum('arogyam_member', ['yes', 'no'])->nullable()->after('jatf_member');
            }
        });
    }

    public function down(): void
    {
        Schema::connection('admin_panel')->table('donor_personal_details', function (Blueprint $table) {

            if (Schema::connection('admin_panel')->hasColumn('donor_personal_details', 'resi_pin_code')) {
                $table->dropColumn('resi_pin_code');
            }

            if (Schema::connection('admin_panel')->hasColumn('donor_personal_details', 'jatf_member')) {
                $table->dropColumn('jatf_member');
            }

            if (Schema::connection('admin_panel')->hasColumn('donor_personal_details', 'arogyam_member')) {
                $table->dropColumn('arogyam_member');
            }
        });
    }
};