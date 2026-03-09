<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('admin_panel')->table('working_committee_approvals', function (Blueprint $table) {
            $table->string('can_be_jito_member', 10)->nullable()->after('remarks_for_approval');
            $table->date('jito_member_date')->nullable()->after('can_be_jito_member');
            $table->string('can_be_jeap_donor', 10)->nullable()->after('jito_member_date');
            $table->date('jeap_donor_date')->nullable()->after('can_be_jeap_donor');
        });
    }

    public function down(): void
    {
        Schema::connection('admin_panel')->table('working_committee_approvals', function (Blueprint $table) {
            $table->dropColumn([
                'can_be_jito_member',
                'jito_member_date',
                'can_be_jeap_donor',
                'jeap_donor_date',
            ]);
        });
    }
};
