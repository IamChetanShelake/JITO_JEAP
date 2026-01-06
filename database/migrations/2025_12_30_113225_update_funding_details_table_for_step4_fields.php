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
            // Add new JSON column for funding data
            $table->json('funding_details')->nullable()->after('user_id');

            // Add new sibling fields
            $table->string('sibling_name')->nullable()->after('sibling_assistance');
            $table->string('sibling_number')->nullable()->after('sibling_name');
            $table->string('ngo_number')->nullable()->after('sibling_ngo_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('funding_details', function (Blueprint $table) {
            $table->dropColumn([
                'funding_details',
                'sibling_name',
                'sibling_number',
                'ngo_number'
            ]);
        });
    }
};
