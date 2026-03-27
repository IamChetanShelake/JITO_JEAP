<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('document_below_pgs');
        Schema::dropIfExists('documents_belows');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // These tables would need to be recreated with full schema if rolled back
        // Not recommended to rollback this migration
    }
};