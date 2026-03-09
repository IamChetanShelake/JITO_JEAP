<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('admin_panel')->create('admin_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_role', 20);
            $table->unsignedBigInteger('recipient_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('working_committee_approval_id')->nullable();
            $table->unsignedBigInteger('history_id')->nullable();
            $table->string('title');
            $table->text('message');
            $table->string('action_url')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->index(['recipient_role', 'recipient_id'], 'admin_notifications_recipient_idx');
            $table->index('user_id', 'admin_notifications_user_idx');
            $table->index('is_read', 'admin_notifications_read_idx');
        });
    }

    public function down(): void
    {
        Schema::connection('admin_panel')->dropIfExists('admin_notifications');
    }
};
