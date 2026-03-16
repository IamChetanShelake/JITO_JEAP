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
        Schema::table('third_stage_documents', function (Blueprint $table) {
            $table->json('domestic_marksheets')->nullable()->after('documents');
            $table->string('domestic_paid_fees_receipt')->nullable()->after('domestic_marksheets');
            $table->string('domestic_cancelled_cheque')->nullable()->after('domestic_paid_fees_receipt');

            $table->text('foreign_address')->nullable()->after('domestic_cancelled_cheque');
            $table->string('foreign_contact_number')->nullable()->after('foreign_address');
            $table->string('foreign_ssn_or_country_id')->nullable()->after('foreign_contact_number');
            $table->string('foreign_immigration_copy')->nullable()->after('foreign_ssn_or_country_id');
            $table->string('foreign_paid_fees_receipt')->nullable()->after('foreign_immigration_copy');
            $table->string('foreign_bank_name')->nullable()->after('foreign_paid_fees_receipt');
            $table->string('foreign_bank_account_number')->nullable()->after('foreign_bank_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('third_stage_documents', function (Blueprint $table) {
            $table->dropColumn([
                'domestic_marksheets',
                'domestic_paid_fees_receipt',
                'domestic_cancelled_cheque',
                'foreign_address',
                'foreign_contact_number',
                'foreign_ssn_or_country_id',
                'foreign_immigration_copy',
                'foreign_paid_fees_receipt',
                'foreign_bank_name',
                'foreign_bank_account_number',
            ]);
        });
    }
};
