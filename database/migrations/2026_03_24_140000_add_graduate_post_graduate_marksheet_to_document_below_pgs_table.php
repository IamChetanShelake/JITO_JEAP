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
        Schema::table('document_below_pgs', function (Blueprint $table) {
            $table->string('graduate_post_graduate_marksheet')->nullable()->after('hsc_diploma_marksheet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_below_pgs', function (Blueprint $table) {
            $table->dropColumn('graduate_post_graduate_marksheet');
        });
    }
};
