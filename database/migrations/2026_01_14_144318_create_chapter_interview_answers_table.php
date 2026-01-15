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
        Schema::create('chapter_interview_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('workflow_id');
            $table->tinyInteger('question_no')->unsigned(); // 1-15
            $table->text('question_text')->nullable(); // optional, for audit
            $table->text('answer_text')->nullable();
            $table->enum('answered_by', ['admin', 'chapter']);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('workflow_id')->references('id')->on('application_workflow_statuses')->onDelete('cascade');

            // Index for performance
            $table->index(['user_id', 'workflow_id', 'question_no']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chapter_interview_answers');
    }
};
