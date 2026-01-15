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
        Schema::create('application_workflow_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('current_stage', ['apex_1', 'chapter', 'working_committee', 'apex_2'])->default('apex_1');
            $table->enum('apex_1_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('apex_1_approval_remarks')->nullable();
            $table->text('apex_1_reject_remarks')->nullable();
            $table->timestamp('apex_1_updated_at')->nullable();
            $table->enum('chapter_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('chapter_remarks')->nullable();
            $table->timestamp('chapter_updated_at')->nullable();
            $table->enum('working_committee_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('working_committee_remarks')->nullable();
            $table->timestamp('working_committee_updated_at')->nullable();
            $table->enum('apex_2_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('apex_2_remarks')->nullable();
            $table->timestamp('apex_2_updated_at')->nullable();
            $table->enum('final_status', ['in_progress', 'rejected', 'approved'])->default('in_progress');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_workflow_statuses');
    }
};
