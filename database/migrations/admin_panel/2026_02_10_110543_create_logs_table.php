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
        Schema::connection('admin_panel')->create('logs', function (Blueprint $table) {
            $table->id();
            
            // User identification
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            
            // Process details
            $table->string('process_type'); // e.g., 'application_submission', 'document_upload', 'status_update', 'approval', 'rejection', etc.
            $table->string('process_action'); // e.g., 'created', 'updated', 'approved', 'rejected', 'submitted', etc.
            $table->text('process_description')->nullable(); // Detailed description of what happened
            
            // Process tracking
            $table->string('process_by_name')->nullable(); // Name of the person who performed the action
            $table->string('process_by_role')->nullable(); // Role of the person (admin, apex, working_committee, etc.)
            $table->unsignedBigInteger('process_by_id')->nullable(); // ID of the person who performed the action
            
            // Additional context
            $table->string('module')->nullable(); // e.g., 'user', 'application', 'document', 'payment', 'donor', etc.
            $table->string('action_url')->nullable(); // URL where the action was performed
            $table->text('old_values')->nullable(); // JSON of old values before change
            $table->text('new_values')->nullable(); // JSON of new values after change
            $table->text('additional_data')->nullable(); // Any additional data related to the process
            
            // Timestamps
            $table->timestamp('process_date')->useCurrent();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['user_id', 'process_date']);
            $table->index(['process_type', 'process_date']);
            $table->index(['process_by_id', 'process_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('admin_panel')->dropIfExists('logs');
    }
};
