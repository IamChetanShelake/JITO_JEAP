<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('admin_panel')->create('donor_payment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained('donors')->onDelete('cascade');

            // Bank Details (JITO Education Assistance Foundation - static)
            $table->string('cheque_favoring')->default('JITO EDUCATION ASSISTANCE FOUNDATION');
            $table->string('bank_name')->default('ICICI BANK');
            $table->string('branch_name')->default('WATER FIELD ROAD, BANDRA (WEST)');
            $table->string('account_number')->default('003801040441');
            $table->string('ifsc_code')->default('ICIC0000388');

            // Payment Entries (JSON array for multiple payments)
            $table->json('payment_entries')->nullable();
            // Structure: [{"utr_no": "", "cheque_date": "", "amount": "", "bank_branch": "", "issued_by": ""}]

            // Status
            $table->string('submit_status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('admin_panel')->dropIfExists('donor_payment_details');
    }
};
