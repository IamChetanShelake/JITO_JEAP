<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'approval_stage')) {
                $table->enum('approval_stage', ['appex', 'working_committee', 'chapter', 'completed'])->default('appex')->after('submit_status');
            }

            if (!Schema::hasColumn('users', 'approved_by_appex')) {
                $table->boolean('approved_by_appex')->nullable()->after('approval_stage');
                $table->text('appex_remark')->nullable()->after('approved_by_appex');
                $table->timestamp('appex_approved_at')->nullable()->after('appex_remark');
            }

            if (!Schema::hasColumn('users', 'approved_by_working_committee')) {
                $table->boolean('approved_by_working_committee')->nullable()->after('appex_approved_at');
                $table->text('working_committee_remark')->nullable()->after('approved_by_working_committee');
                $table->timestamp('working_committee_approved_at')->nullable()->after('working_committee_remark');
            }

            if (!Schema::hasColumn('users', 'approved_by_chapter')) {
                $table->boolean('approved_by_chapter')->nullable()->after('working_committee_approved_at');
                $table->text('chapter_remark')->nullable()->after('approved_by_chapter');
                $table->timestamp('chapter_approved_at')->nullable()->after('chapter_remark');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'chapter_approved_at')) {
                $table->dropColumn('chapter_approved_at');
            }
            if (Schema::hasColumn('users', 'chapter_remark')) {
                $table->dropColumn('chapter_remark');
            }
            if (Schema::hasColumn('users', 'approved_by_chapter')) {
                $table->dropColumn('approved_by_chapter');
            }

            if (Schema::hasColumn('users', 'working_committee_approved_at')) {
                $table->dropColumn('working_committee_approved_at');
            }
            if (Schema::hasColumn('users', 'working_committee_remark')) {
                $table->dropColumn('working_committee_remark');
            }
            if (Schema::hasColumn('users', 'approved_by_working_committee')) {
                $table->dropColumn('approved_by_working_committee');
            }

            if (Schema::hasColumn('users', 'appex_approved_at')) {
                $table->dropColumn('appex_approved_at');
            }
            if (Schema::hasColumn('users', 'appex_remark')) {
                $table->dropColumn('appex_remark');
            }
            if (Schema::hasColumn('users', 'approved_by_appex')) {
                $table->dropColumn('approved_by_appex');
            }

            if (Schema::hasColumn('users', 'approval_stage')) {
                $table->dropColumn('approval_stage');
            }
        });
    }
};
