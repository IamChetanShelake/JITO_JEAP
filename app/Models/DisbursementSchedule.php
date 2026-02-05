<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DisbursementSchedule extends Model
{
    protected $connection = 'admin_panel';

    protected $fillable = [
        'user_id',
        'workflow_status_id',
        'installment_no',
        'planned_date',
        'planned_amount',
        'status'
    ];

    protected $casts = [
        'planned_date' => 'date',
        'planned_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function workflowStatus(): BelongsTo
    {
        return $this->belongsTo(ApplicationWorkflowStatus::class, 'workflow_status_id');
    }

    public function disbursement(): HasOne
    {
        return $this->hasOne(Disbursement::class);
    }
}
