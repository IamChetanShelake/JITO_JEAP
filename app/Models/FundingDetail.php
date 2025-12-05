<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FundingDetail extends Model
{
    protected $fillable = [
        'user_id',
        'amount_requested_year',
        'tuition_fees_amount',

        // Own family funding
        'family_funding_status',
        'family_funding_trust',
        'family_funding_contact',
        'family_funding_mobile',
        'family_funding_amount',

        // Bank Loan
        'bank_loan_status',
        'bank_loan_trust',
        'bank_loan_contact',
        'bank_loan_mobile',
        'bank_loan_amount',

        // Other Assistance (1)
        'other_assistance1_status',
        'other_assistance1_trust',
        'other_assistance1_contact',
        'other_assistance1_mobile',
        'other_assistance1_amount',

        // Other Assistance (2)
        'other_assistance2_status',
        'other_assistance2_trust',
        'other_assistance2_contact',
        'other_assistance2_mobile',
        'other_assistance2_amount',

        // Local Assistance
        'local_assistance_status',
        'local_assistance_trust',
        'local_assistance_contact',
        'local_assistance_mobile',
        'local_assistance_amount',

        // Total funding amount
        'total_funding_amount',

        // Sibling Assistance
        'sibling_assistance',
        'sibling_ngo_name',
        'sibling_loan_status',
        'sibling_applied_year',
        'sibling_applied_amount',

        // Bank Details
        'account_holder_name',
        'bank_name',
        'account_number',
        'branch_name',
        'ifsc_code',
        'bank_address',

        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
