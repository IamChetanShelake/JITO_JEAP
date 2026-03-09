<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('admin_panel')->create('working_committee_approval_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('working_committee_approval_id');
            $table->unsignedBigInteger('edited_by')->nullable();
            $table->decimal('old_approval_financial_assistance_amount', 15, 2)->nullable();
            $table->string('old_meeting_no')->nullable();
            $table->date('old_w_c_approval_date')->nullable();
            $table->string('old_disbursement_system')->nullable();
            $table->integer('old_disbursement_in_year')->nullable();
            $table->integer('old_disbursement_in_half_year')->nullable();
            $table->json('old_yearly_dates')->nullable();
            $table->json('old_yearly_amounts')->nullable();
            $table->json('old_half_yearly_dates')->nullable();
            $table->json('old_half_yearly_amounts')->nullable();
            $table->json('old_installment_amount')->nullable();
            $table->json('old_no_of_months')->nullable();
            $table->json('old_total')->nullable();
            $table->decimal('old_additional_installment_amount', 15, 2)->nullable();
            $table->string('old_repayment_type')->nullable();
            $table->date('old_repayment_starting_from')->nullable();
            $table->integer('old_no_of_cheques_to_be_collected')->nullable();
            $table->text('old_w_c_approval_remark')->nullable();
            $table->text('old_remarks_for_approval')->nullable();
            $table->json('changed_fields')->nullable();
            $table->timestamps();

            $table->index('user_id', 'wc_approval_histories_user_id_idx');
            $table->index('working_committee_approval_id', 'wc_approval_histories_approval_id_idx');
        });
    }

    public function down(): void
    {
        Schema::connection('admin_panel')->dropIfExists('working_committee_approval_histories');
    }
};
