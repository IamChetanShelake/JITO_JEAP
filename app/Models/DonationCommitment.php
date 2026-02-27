<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationCommitment extends Model
{
    use HasFactory;

    protected $connection = 'admin_panel';

    protected $guarded = [];

    protected $casts = [
        'committed_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Status constants
    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Get the donor that owns this commitment.
     */
    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    /**
     * Get the payments associated with this commitment.
     */
    public function payments()
    {
        return $this->hasMany(DonorPaymentDetail::class, 'commitment_id');
    }

    /**
     * Check if the commitment is active.
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check if the commitment is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Check if the commitment is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /**
     * Cancel the commitment.
     */
    public function cancel(): void
    {
        $this->status = self::STATUS_CANCELLED;
        $this->save();
    }

    /**
     * Complete the commitment.
     */
    public function complete(): void
    {
        $this->status = self::STATUS_COMPLETED;
        $this->save();
    }

    /**
     * Get the total amount paid against this commitment.
     */
    public function getTotalPaidAmount(): float
    {
        return $this->payments()
            ->whereNotNull('amount')
            ->sum('amount');
    }

    /**
     * Check if the commitment is fully paid.
     */
    public function isFullyPaid(): bool
    {
        return $this->getTotalPaidAmount() >= (float) $this->committed_amount;
    }

    /**
     * Get the remaining amount to be paid.
     */
    public function getRemainingAmount(): float
    {
        return max(0, (float) $this->committed_amount - $this->getTotalPaidAmount());
    }
}
