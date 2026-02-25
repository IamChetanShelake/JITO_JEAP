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
        Schema::connection('admin_panel')->table('donor_personal_details', function (Blueprint $table) {
            $table->enum('jito_member', ['yes', 'no'])->nullable()->after('hobby_2');
            $table->string('jito_uid', 50)->nullable()->after('jito_member');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('admin_panel')->table('donor_personal_details', function (Blueprint $table) {
            $table->dropColumn(['jito_member', 'jito_uid']);
        });
    }
};
