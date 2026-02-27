<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonorPaymentDetail extends Model
{
    use HasFactory;

    protected $connection = 'admin_panel';

    protected $guarded = [];

    protected $casts = [
        'payment_entries' => 'array',
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    /**
     * Get the commitment associated with this payment (for members).
     */
    public function commitment()
    {
        return $this->belongsTo(DonationCommitment::class, 'commitment_id');
    }

    /**
     * Check if this is a member payment (has commitment).
     */
    public function isMemberPayment(): bool
    {
        return $this->commitment_id !== null;
    }

    /**
     * Check if this is a general donor payment (no commitment).
     */
    public function isGeneralPayment(): bool
    {
        return $this->commitment_id === null;
    }

    /**
     * Get the financial year based on payment date.
     */
    public function getFinancialYearAttribute(): ?string
    {
        if (!$this->payment_date) {
            return null;
        }

        $year = $this->payment_date->year;
        $month = $this->payment_date->month;

        // Financial year starts from April (month 4)
        if ($month >= 4) {
            return $year . '-' . ($year + 1);
        } else {
            return ($year - 1) . '-' . $year;
        }
    }
}
