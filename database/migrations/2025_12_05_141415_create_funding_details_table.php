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
        Schema::create('funding_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Amount Requested
            $table->enum('amount_requested_year', ['year1', 'year2', 'year3', 'year4']);
            $table->decimal('tuition_fees_amount', 15, 2)->nullable();

            // Own family funding (Father + Mother)
            $table->enum('family_funding_status', ['applied', 'approved', 'received', 'pending'])->nullable();
            $table->string('family_funding_trust')->nullable();
            $table->string('family_funding_contact')->nullable();
            $table->string('family_funding_mobile')->nullable();
            $table->decimal('family_funding_amount', 15, 2)->nullable();

            // Bank Loan
            $table->enum('bank_loan_status', ['applied', 'approved', 'received', 'pending'])->nullable();
            $table->string('bank_loan_trust')->nullable();
            $table->string('bank_loan_contact')->nullable();
            $table->string('bank_loan_mobile')->nullable();
            $table->decimal('bank_loan_amount', 15, 2)->nullable();

            // Other Assistance (1)
            $table->enum('other_assistance1_status', ['applied', 'approved', 'received', 'pending'])->nullable();
            $table->string('other_assistance1_trust')->nullable();
            $table->string('other_assistance1_contact')->nullable();
            $table->string('other_assistance1_mobile')->nullable();
            $table->decimal('other_assistance1_amount', 15, 2)->nullable();

            // Other Assistance (2)
            $table->enum('other_assistance2_status', ['applied', 'approved', 'received', 'pending'])->nullable();
            $table->string('other_assistance2_trust')->nullable();
            $table->string('other_assistance2_contact')->nullable();
            $table->string('other_assistance2_mobile')->nullable();
            $table->decimal('other_assistance2_amount', 15, 2)->nullable();

            // Local Assistance
            $table->enum('local_assistance_status', ['applied', 'approved', 'received', 'pending'])->nullable();
            $table->string('local_assistance_trust')->nullable();
            $table->string('local_assistance_contact')->nullable();
            $table->string('local_assistance_mobile')->nullable();
            $table->decimal('local_assistance_amount', 15, 2)->nullable();

            // Total funding amount
            $table->decimal('total_funding_amount', 15, 2)->nullable();

            // Sibling Assistance
            $table->enum('sibling_assistance', ['yes', 'no']);
            $table->string('sibling_ngo_name')->nullable();
            $table->enum('sibling_loan_status', ['applied', 'approved', 'received', 'pending'])->nullable();
            $table->enum('sibling_applied_year', ['1st_year', '2nd_year', '3rd_year', '4th_year'])->nullable();
            $table->decimal('sibling_applied_amount', 15, 2)->nullable();

            // Bank Details
            $table->string('account_holder_name');
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('branch_name');
            $table->string('ifsc_code');
            $table->text('bank_address');

            $table->string('status')->default('step4_completed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funding_details');
    }
};
