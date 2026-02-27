<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('admin_panel')->table('donor_payment_details', function (Blueprint $table) {
            // Add commitment_id foreign key (nullable - for both member and general donors)
            $table->foreignId('commitment_id')
                ->nullable()
                ->constrained('donation_commitments')
                ->onDelete('set null')
                ->after('donor_id');

            // Add amount field for individual payments
            $table->decimal('amount', 15, 2)->nullable()->after('commitment_id');

            // Add payment_date
            $table->date('payment_date')->nullable()->after('amount');

            // Add financial_year
            $table->string('financial_year', 9)->nullable()->after('payment_date');

            // Add payment_mode
            $table->string('payment_mode', 50)->nullable()->after('financial_year');

            // Add remarks
            $table->text('remarks')->nullable()->after('payment_mode');
        });
    }

    public function down(): void
    {
        Schema::connection('admin_panel')->table('donor_payment_details', function (Blueprint $table) {
            $table->dropForeign(['commitment_id']);
            $table->dropColumn([
                'commitment_id',
                'amount',
                'payment_date',
                'financial_year',
                'payment_mode',
                'remarks'
            ]);
        });
    }
};
