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
            if (!Schema::hasColumn('application_workflow_statuses', 'third_stage_notification_sent_at')) {
                $table->timestamp('third_stage_notification_sent_at')->nullable()->after('apex_2_updated_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_workflow_statuses', function (Blueprint $table) {
            if (Schema::hasColumn('application_workflow_statuses', 'third_stage_notification_sent_at')) {
                $table->dropColumn('third_stage_notification_sent_at');
            }
        });
    }
};
