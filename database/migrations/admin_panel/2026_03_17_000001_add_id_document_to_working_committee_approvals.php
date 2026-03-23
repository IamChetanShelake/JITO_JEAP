<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('admin_panel')->table('working_committee_approvals', function (Blueprint $table) {
            $table->string('document')->nullable()->after('jeap_donor_date');
        });
    }

    public function down(): void
    {
        Schema::connection('admin_panel')->table('working_committee_approvals', function (Blueprint $table) {
            $table->dropColumn('document');
        });
    }
};
