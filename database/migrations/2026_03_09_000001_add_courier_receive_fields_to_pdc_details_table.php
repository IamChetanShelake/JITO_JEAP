<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pdc_details', function (Blueprint $table) {
            $table->string('courier_received_by')->nullable()->after('processed_by');
            $table->date('courier_received_date')->nullable()->after('courier_received_by');
            $table->enum('courier_receive_status', ['pending', 'approved', 'hold'])->default('pending')->after('courier_received_date');
            $table->text('courier_receive_hold_remark')->nullable()->after('courier_receive_status');
            $table->unsignedBigInteger('courier_receive_processed_by')->nullable()->after('courier_receive_hold_remark');
            $table->timestamp('courier_receive_processed_at')->nullable()->after('courier_receive_processed_by');
        });
    }

    public function down(): void
    {
        Schema::table('pdc_details', function (Blueprint $table) {
            $table->dropColumn([
                'courier_received_by',
                'courier_received_date',
                'courier_receive_status',
                'courier_receive_hold_remark',
                'courier_receive_processed_by',
                'courier_receive_processed_at',
            ]);
        });
    }
};
