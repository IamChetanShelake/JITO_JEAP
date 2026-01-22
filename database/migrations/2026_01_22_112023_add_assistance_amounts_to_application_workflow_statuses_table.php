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
            $table->decimal('chapter_assistance_amount', 15, 2)->nullable()->after('chapter_updated_at');
            $table->decimal('working_committee_assistance_amount', 15, 2)->nullable()->after('working_committee_updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_workflow_statuses', function (Blueprint $table) {
            $table->dropColumn(['chapter_assistance_amount', 'working_committee_assistance_amount']);
        });
    }
};
