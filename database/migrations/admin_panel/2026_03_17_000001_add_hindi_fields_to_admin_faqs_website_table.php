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
        Schema::table('admin_faqs_website', function (Blueprint $table) {
            $table->text('question_hi')->nullable()->after('question');
            $table->longText('answer_hi')->nullable()->after('answer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_faqs_website', function (Blueprint $table) {
            $table->dropColumn('question_hi');
            $table->dropColumn('answer_hi');
        });
    }
};
