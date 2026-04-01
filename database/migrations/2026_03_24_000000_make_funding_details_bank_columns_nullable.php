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
        Schema::table('funding_details', function (Blueprint $table) {
            // Make bank detail columns nullable
            $table->string('account_holder_name')->nullable()->change();
            $table->string('bank_name')->nullable()->change();
            $table->string('account_number')->nullable()->change();
            $table->string('branch_name')->nullable()->change();
            $table->string('ifsc_code')->nullable()->change();
            $table->string('bank_address')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('funding_details', function (Blueprint $table) {
            // Revert back to not nullable (use with caution if data exists)
            $table->string('account_holder_name')->nullable(false)->change();
            $table->string('bank_name')->nullable(false)->change();
            $table->string('account_number')->nullable(false)->change();
            $table->string('branch_name')->nullable(false)->change();
            $table->string('ifsc_code')->nullable(false)->change();
            $table->string('bank_address')->nullable(false)->change();
        });
    }
};