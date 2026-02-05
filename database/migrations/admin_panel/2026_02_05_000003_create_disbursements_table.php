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
        Schema::connection('admin_panel')->create('disbursements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('disbursement_schedule_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('jito_jeap_bank_id');
            $table->date('disbursement_date');
            $table->decimal('amount', 15, 2);
            $table->string('utr_number', 255);
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index('disbursement_schedule_id');
            $table->index('user_id');
            $table->index('jito_jeap_bank_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('admin_panel')->dropIfExists('disbursements');
    }
};
