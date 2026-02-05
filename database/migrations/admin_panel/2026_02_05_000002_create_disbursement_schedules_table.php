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
        Schema::connection('admin_panel')->create('disbursement_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('workflow_status_id');
            $table->integer('installment_no');
            $table->date('planned_date');
            $table->decimal('planned_amount', 15, 2);
            $table->enum('status', ['pending', 'completed', 'on_hold'])->default('pending');
            $table->timestamps();

            $table->index('user_id');
            $table->index('workflow_status_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('admin_panel')->dropIfExists('disbursement_schedules');
    }
};
