<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('admin_panel')->table('donor_documents', function (Blueprint $table) {
            $table->text('birth_photo')->nullable()->after('authorization_letter_file');
            $table->text('anniversary_photo')->nullable()->after('birth_photo');
        });
    }

    public function down(): void
    {
        Schema::connection('admin_panel')->table('donor_documents', function (Blueprint $table) {
            $table->dropColumn(['birth_photo', 'anniversary_photo']);
        });
    }
};
