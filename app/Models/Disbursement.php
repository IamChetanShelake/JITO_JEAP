<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disbursement extends Model
{
    protected $connection = 'admin_panel';

    protected $fillable = [
        'disbursement_schedule_id',
        'user_id',
        'jito_jeap_bank_id',
        'disbursement_date',
        'amount',
        'utr_number',
        'remarks'
    ];

    protected $casts = [
        'disbursement_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function disbursementSchedule(): BelongsTo
    {
        return $this->belongsTo(DisbursementSchedule::class, 'disbursement_schedule_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jitoJeapBank(): BelongsTo
    {
        return $this->belongsTo(JitoJeapBank::class, 'jito_jeap_bank_id');
    }
}
