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
        Schema::connection('admin_panel')->create('report_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->json('selected_fields'); // Store selected fields as JSON
            $table->json('filters')->nullable(); // Store filter conditions as JSON
            $table->boolean('is_predefined')->default(false); // Mark as predefined report
            $table->string('category')->nullable(); // e.g., 'student', 'payment', 'donor'
            $table->unsignedBigInteger('created_by')->nullable(); // Admin user ID who created the template
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('admin_panel')->dropIfExists('report_templates');
    }
};