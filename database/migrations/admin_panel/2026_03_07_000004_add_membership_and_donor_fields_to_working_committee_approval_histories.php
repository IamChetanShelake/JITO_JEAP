<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('admin_panel')->table('working_committee_approval_histories', function (Blueprint $table) {
            $table->string('old_can_be_jito_member', 10)->nullable()->after('old_remarks_for_approval');
            $table->date('old_jito_member_date')->nullable()->after('old_can_be_jito_member');
            $table->string('old_can_be_jeap_donor', 10)->nullable()->after('old_jito_member_date');
            $table->date('old_jeap_donor_date')->nullable()->after('old_can_be_jeap_donor');
        });
    }

    public function down(): void
    {
        Schema::connection('admin_panel')->table('working_committee_approval_histories', function (Blueprint $table) {
            $table->dropColumn([
                'old_can_be_jito_member',
                'old_jito_member_date',
                'old_can_be_jeap_donor',
                'old_jeap_donor_date',
            ]);
        });
    }
};
