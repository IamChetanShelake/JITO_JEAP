<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('admin_panel')->create('donation_commitments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained('donors')->onDelete('cascade');

            // Commitment details
            $table->decimal('committed_amount', 15, 2);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // Status: active/completed/cancelled
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');

            $table->timestamps();

            // Index for faster queries
            $table->index(['donor_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::connection('admin_panel')->dropIfExists('donation_commitments');
    }
};
