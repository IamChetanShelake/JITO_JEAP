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
        Schema::connection('admin_panel')->create('working_committee_approvals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->longText('w_c_approval_remark')->nullable();
            $table->longText('w_c_rejection_remark')->nullable();
            $table->date('w_c_approval_date')->nullable();
            $table->string('meeting_no')->nullable();
            $table->enum('disbursement_system', ['yearly', 'half_yearly'])->nullable();
            $table->integer('disbursement_in_year')->nullable();
            $table->integer('disbursement_in_half_year')->nullable();
            $table->json('yearly_dates')->nullable();
            $table->json('yearly_amounts')->nullable();
            $table->json('half_yearly_dates')->nullable();
            $table->json('half_yearly_amounts')->nullable();
            $table->decimal('approval_financial_assistance_amount', 15, 2)->nullable();
            $table->decimal('installment_amount', 15, 2)->nullable();
            $table->decimal('additional_installment_amount', 15, 2)->nullable();
            $table->enum('repayment_type', ['yearly', 'half_yearly', 'quarterly', 'monthly'])->nullable();
            $table->integer('no_of_cheques_to_be_collected')->nullable();
            $table->date('repayment_starting_from')->nullable();
            $table->text('remarks_for_approval')->nullable();
            $table->unsignedBigInteger('processed_by')->nullable();
            $table->enum('approval_status', ['approved', 'rejected', 'hold'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('admin_panel')->dropIfExists('working_committee_approvals');
    }
};
