<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingCommitteeApproval extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'admin_panel';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'working_committee_approvals';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'w_c_approval_date' => 'date',
        'repayment_starting_from' => 'date',
        'yearly_dates' => 'array',
        'yearly_amounts' => 'array',
        'half_yearly_dates' => 'array',
        'half_yearly_amounts' => 'array',
        'approval_financial_assistance_amount' => 'decimal:2',
        'installment_amount' => 'decimal:2',
        'additional_installment_amount' => 'decimal:2',
    ];
}
