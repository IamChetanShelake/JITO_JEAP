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
            // Change enum columns to string columns for sibling fields
            $table->string('sibling_loan_status')->nullable()->change();
            $table->string('sibling_applied_year')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('funding_details', function (Blueprint $table) {
            //
        });
    }
};
