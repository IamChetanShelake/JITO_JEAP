<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('admin_panel')->table('donors', function (Blueprint $table) {
            // Add donor_type enum (member/general) - default to member for backward compatibility
            $table->enum('donor_type', ['member', 'general'])->default('member')->after('password');

            // Add can_login boolean - default to true for members
            $table->boolean('can_login')->default(true)->after('donor_type');

            // Add status enum (active/converted/inactive) - default to active
            $table->enum('status', ['active', 'converted', 'inactive'])->default('active')->after('can_login');
        });
    }

    public function down(): void
    {
        Schema::connection('admin_panel')->table('donors', function (Blueprint $table) {
            $table->dropColumn(['donor_type', 'can_login', 'status']);
        });
    }
};
