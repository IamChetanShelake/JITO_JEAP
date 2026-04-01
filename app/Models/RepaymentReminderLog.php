<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepaymentReminderLog extends Model
{
    protected $connection = 'admin_panel';
    protected $fillable = [
        'user_id',
        'installment_no',
        'repayment_date',
        'sent_at',
    ];
}
