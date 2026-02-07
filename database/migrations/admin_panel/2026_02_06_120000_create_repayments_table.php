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
        Schema::connection('admin_panel')->create('repayments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('payment_date');
            $table->decimal('amount', 15, 2);
            $table->enum('payment_mode', ['pdc', 'neft', 'cash']);
            $table->string('reference_number')->nullable();
            $table->enum('status', ['pending', 'cleared', 'bounced'])->default('pending');
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'payment_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('admin_panel')->dropIfExists('repayments');
    }
};
