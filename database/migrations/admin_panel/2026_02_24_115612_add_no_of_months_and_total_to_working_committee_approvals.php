<?php

use GuzzleHttp\Promise\Create;
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
         Schema::connection('admin_panel')->create('working_committee_approvals', function (Blueprint $table) {
            $table->string('no_of_months')->nullable();
            $table->string('total')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('working_committee_approvals', function (Blueprint $table) {
            $table->dropColumn(['no_of_months', 'total']);
        });
    }
};
