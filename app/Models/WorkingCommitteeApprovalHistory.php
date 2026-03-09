<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingCommitteeApprovalHistory extends Model
{
    protected $connection = 'admin_panel';

    protected $table = 'working_committee_approval_histories';

    protected $guarded = [];

    protected $casts = [
        'old_w_c_approval_date' => 'date',
        'old_repayment_starting_from' => 'date',
        'old_jito_member_date' => 'date',
        'old_jeap_donor_date' => 'date',
        'old_yearly_dates' => 'array',
        'old_yearly_amounts' => 'array',
        'old_half_yearly_dates' => 'array',
        'old_half_yearly_amounts' => 'array',
        'old_installment_amount' => 'array',
        'old_no_of_months' => 'array',
        'old_total' => 'array',
        'old_approval_financial_assistance_amount' => 'decimal:2',
        'old_additional_installment_amount' => 'decimal:2',
        'changed_fields' => 'array',
    ];
}
