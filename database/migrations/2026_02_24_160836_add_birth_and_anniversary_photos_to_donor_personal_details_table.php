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
        if (!Schema::connection('admin_panel')->hasColumn('donor_personal_details', 'birth_photo')) {
            $table->string('birth_photo')->nullable()->after('date_of_birth');
        }
        if (!Schema::connection('admin_panel')->hasColumn('donor_personal_details', 'anniversary_photo')) {
            $table->string('anniversary_photo')->nullable()->after('anniversary_date');
        }
    });
}

public function down(): void
{
    Schema::connection('admin_panel')->table('donor_personal_details', function (Blueprint $table) {
        $table->dropColumn(['birth_photo', 'anniversary_photo']);
    });
}
};
