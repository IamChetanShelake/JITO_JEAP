<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pdc_courier_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pdc_detail_id');
            $table->unsignedBigInteger('user_id');
            $table->string('action', 50);
            $table->unsignedBigInteger('action_by')->nullable();
            $table->timestamp('action_at')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();

            $table->index(['pdc_detail_id', 'action']);
            $table->index(['user_id', 'action_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pdc_courier_histories');
    }
};
