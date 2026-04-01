<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('admin_panel')->create('repayment_reminder_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('installment_no');
            $table->date('repayment_date');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'installment_no', 'repayment_date'], 'repayment_reminder_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repayment_reminder_logs');
    }
};
