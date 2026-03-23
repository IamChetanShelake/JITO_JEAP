<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pdc_details', function (Blueprint $table) {
            $table->unsignedInteger('courier_cheque_total')->nullable()->after('courier_receive_verified_documents');
            $table->unsignedInteger('courier_cheque_received')->nullable()->after('courier_cheque_total');
            $table->unsignedInteger('courier_cheque_pending')->nullable()->after('courier_cheque_received');

            $table->unsignedBigInteger('courier_receive_approved_by')->nullable()->after('courier_cheque_pending');
            $table->timestamp('courier_receive_approved_at')->nullable()->after('courier_receive_approved_by');

            $table->boolean('courier_send_back')->nullable()->after('courier_receive_approved_at');
            $table->text('courier_send_back_reason')->nullable()->after('courier_send_back');
            $table->date('courier_send_back_date')->nullable()->after('courier_send_back_reason');
        });
    }

    public function down(): void
    {
        Schema::table('pdc_details', function (Blueprint $table) {
            $table->dropColumn([
                'courier_cheque_total',
                'courier_cheque_received',
                'courier_cheque_pending',
                'courier_receive_approved_by',
                'courier_receive_approved_at',
                'courier_send_back',
                'courier_send_back_reason',
                'courier_send_back_date',
            ]);
        });
    }
};
