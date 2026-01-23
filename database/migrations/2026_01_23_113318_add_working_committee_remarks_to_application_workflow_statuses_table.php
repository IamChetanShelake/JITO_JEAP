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
            $table->text('working_committee_remarks')->nullable()->after('working_committee_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_workflow_statuses', function (Blueprint $table) {
            $table->dropColumn('working_committee_remarks');
        });
    }
};
