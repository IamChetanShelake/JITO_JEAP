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
        Schema::connection('admin_panel')->create('jito_jeap_banks', function (Blueprint $table) {
            $table->id();
            $table->string('account_name');
            $table->string('bank_name');
            $table->string('account_type');
            $table->string('account_number');
            $table->string('ifsc_code');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('admin_panel')->dropIfExists('jito_jeap_banks');
    }
};
