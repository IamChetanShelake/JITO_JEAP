<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('admin_panel')->table('donor_personal_details', function (Blueprint $table) {
            // Add birth_photo and anniversary_photo columns if they don't exist
            if (!Schema::connection('admin_panel')->hasColumn('donor_personal_details', 'birth_photo')) {
                $table->text('birth_photo')->nullable()->after('anniversary_date');
            }
            
            if (!Schema::connection('admin_panel')->hasColumn('donor_personal_details', 'anniversary_photo')) {
                $table->text('anniversary_photo')->nullable()->after('birth_photo');
            }
        });
    }

    public function down(): void
    {
        Schema::connection('admin_panel')->table('donor_personal_details', function (Blueprint $table) {
            if (Schema::connection('admin_panel')->hasColumn('donor_personal_details', 'anniversary_photo')) {
                $table->dropColumn('anniversary_photo');
            }
            
            if (Schema::connection('admin_panel')->hasColumn('donor_personal_details', 'birth_photo')) {
                $table->dropColumn('birth_photo');
            }
        });
    }
};
