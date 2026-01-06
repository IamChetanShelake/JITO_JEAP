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
        Schema::create('guarantor_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // First Guarantor
            $table->string('g_one_name');
            $table->enum('g_one_gender', ['male', 'female']);
            $table->text('g_one_permanent_address');
            $table->string('g_one_phone', 15);
            $table->string('g_one_email');
            $table->string('g_one_relation_with_student');
            $table->string('g_one_aadhar_card_number', 12);
            $table->string('g_one_pan_card_no', 10);
            $table->date('g_one_d_o_b');
            $table->string('g_one_income', 50);
            $table->string('g_one_pan_card_upload')->nullable();

            // Second Guarantor
            $table->string('g_two_name');
            $table->enum('g_two_gender', ['male', 'female']);
            $table->text('g_two_permanent_address');
            $table->string('g_two_phone', 15);
            $table->string('g_two_email');
            $table->string('g_two_relation_with_student');
            $table->string('g_two_aadhar_card_number', 12);
            $table->string('g_two_pan_card_no', 10);
            $table->date('g_two_d_o_b');
            $table->string('g_two_income', 50);
            $table->string('g_two_pan_card_upload')->nullable();

            // Power of Attorney
            $table->string('attorney_name');
            $table->string('attorney_email');
            $table->string('attorney_phone', 15);
            $table->text('attorney_address');
            $table->string('attorney_relation_with_student');

            $table->string('status')->default('step5_completed');
            $table->enum('submit_status', ['pending', 'submited', 'approved', 'resubmit'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guarantor_details');
    }
};
