<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Convert existing data to proper date format
        DB::statement("UPDATE education_details SET school_completion_year = CONCAT(school_completion_year, '-01-01') WHERE school_completion_year IS NOT NULL AND LENGTH(school_completion_year) = 4");
        DB::statement("UPDATE education_details SET school_completion_year = CONCAT(school_completion_year, '-01') WHERE school_completion_year IS NOT NULL AND LENGTH(school_completion_year) = 7 AND school_completion_year REGEXP '^[0-9]{4}-[0-9]{2}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('education_details', function (Blueprint $table) {
            $table->integer('school_completion_year')->nullable()->change();
            $table->integer('jc_completion_year')->nullable()->change();
        });
    }
};
");
        DB::statement("UPDATE education_details SET jc_completion_year = CONCAT(jc_completion_year, '-01-01') WHERE jc_completion_year IS NOT NULL AND LENGTH(jc_completion_year) = 4");
        DB::statement("UPDATE education_details SET jc_completion_year = CONCAT(jc_completion_year, '-01') WHERE jc_completion_year IS NOT NULL AND LENGTH(jc_completion_year) = 7 AND jc_completion_year REGEXP '^[0-9]{4}-[0-9]{2}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('education_details', function (Blueprint $table) {
            $table->integer('school_completion_year')->nullable()->change();
            $table->integer('jc_completion_year')->nullable()->change();
        });
    }
};
");

        Schema::table('education_details', function (Blueprint $table) {
            $table->date('school_completion_year')->nullable()->change();
            $table->date('jc_completion_year')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('education_details', function (Blueprint $table) {
            $table->integer('school_completion_year')->nullable()->change();
            $table->integer('jc_completion_year')->nullable()->change();
        });
    }
};
