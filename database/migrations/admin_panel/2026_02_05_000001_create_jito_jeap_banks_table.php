<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $connection = 'admin_panel';
    public function up(): void
    {
        Schema::create('jito_jeap_banks', function (Blueprint $table) {
            $table->id();
            $table->string('account_name');
            $table->string('bank_name');
            $table->string('account_type');
            $table->string('account_number');
            $table->string('ifsc_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jito_jeap_banks');
    }
};
