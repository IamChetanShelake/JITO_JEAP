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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); 
            $table->string('email')->unique();
            $table->string('role')->default('user');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->default('active');
            $table->string('register_date')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->date('d_o_b')->nullable();
            $table->string('birth_place')->nullable();
            $table->enum('financial_asset_type', ['domestic', 'foreign_finance_assistant'])->nullable();
            $table->enum('financial_asset_for', ['graduation', 'post_graduation'])->nullable();
            $table->string('aadhar_card_number')->nullable();
            $table->string('age')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable(); 
            $table->enum('marital_status', ['married', 'unmarried'])->nullable(); 
            $table->string('religion')->nullable();
            $table->enum('nationality', ['indian', 'foreigner'])->nullable(); 
            $table->string('pan_card')->nullable();
            $table->string('alternate_email')->nullable();
            $table->string('alternate_phone')->nullable();
            $table->string('blood_group')->nullable();
            $table->enum('specially_abled', ['yes', 'no'])->nullable(); 
            $table->string('current_address')->nullable();
            $table->string('city')->nullable();
            $table->string('chapter')->nullable();
            $table->string('state')->nullable();
            $table->string('new_zone')->nullable();
            $table->string('pin_code')->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
