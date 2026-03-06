<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Donor extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $connection = 'admin_panel';
    protected $table = 'donors';

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'can_login' => 'boolean',
        ];
    }

    // Donor type constants
    const TYPE_MEMBER = 'member';
    const TYPE_GENERAL = 'general';

    // Status constants
    const STATUS_ACTIVE = 'active';
    const STATUS_CONVERTED = 'converted';
    const STATUS_INACTIVE = 'inactive';

    // Relationships
    public function personalDetail()
    {
        return $this->hasOne(DonorPersonalDetail::class);
    }

    public function familyDetail()
    {
        return $this->hasOne(DonorFamilyDetail::class);
    }

    public function nomineeDetail()
    {
        return $this->hasOne(DonorNomineeDetail::class);
    }

    public function membershipDetail()
    {
        return $this->hasOne(DonorMembershipDetail::class);
    }

    public function professionalDetail()
    {
        return $this->hasOne(DonorProfessionalDetail::class);
    }

    public function document()
    {
        return $this->hasOne(DonorDocument::class);
    }

    public function paymentDetail()
    {
        return $this->hasOne(DonorPaymentDetail::class);
    }

    /**
     * Get the donation commitments for this donor.
     */
    public function commitments()
    {
        return $this->hasMany(DonationCommitment::class);
    }

    /**
     * Alias for commitments() - for backward compatibility
     */
    public function donationCommitments()
    {
        return $this->hasMany(DonationCommitment::class);
    }

    /**
     * Get the active commitment for this donor.
     */
    public function activeCommitment()
    {
        return $this->hasOne(DonationCommitment::class)->where('status', DonationCommitment::STATUS_ACTIVE);
    }

    /**
     * Check if the donor is a member donor.
     */
    public function isMember(): bool
    {
        return $this->donor_type === self::TYPE_MEMBER;
    }

    /**
     * Check if the donor is a general donor.
     */
    public function isGeneral(): bool
    {
        return $this->donor_type === self::TYPE_GENERAL;
    }

    /**
     * Check if the donor can login.
     */
    public function canLogin(): bool
    {
        return (bool) $this->can_login;
    }

    /**
     * Check if the donor is active.
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check if the donor is converted from member to general.
     */
    public function isConverted(): bool
    {
        return $this->status === self::STATUS_CONVERTED;
    }

    /**
     * Convert donor from member to general.
     * This will:
     * - Set donor_type to 'general'
     * - Set can_login to false
     * - Set status to 'converted'
     * - Clear password
     * - Cancel all active commitments
     */
    public function convertToGeneral(): void
    {
        // Cancel all active commitments
        $this->commitments()
            ->where('status', DonationCommitment::STATUS_ACTIVE)
            ->update(['status' => DonationCommitment::STATUS_CANCELLED]);

        // Update donor fields
        $this->donor_type = self::TYPE_GENERAL;
        $this->can_login = false;
        $this->status = self::STATUS_CONVERTED;
        $this->password = null;
        $this->save();
    }

    /**
     * Create a donation commitment for this donor.
     */
    public function createCommitment(array $data): DonationCommitment
    {
        return $this->commitments()->create([
            'committed_amount' => $data['committed_amount'],
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'status' => DonationCommitment::STATUS_ACTIVE,
        ]);
    }

    // Helper method to get next incomplete step
    public function getNextStep()
    {
        // For general donors, skip membership-related steps
        if ($this->isGeneral()) {
            if (!$this->personalDetail || $this->personalDetail->submit_status !== 'submited') {
                return 'step1';
            }
            if (!$this->paymentDetail || $this->paymentDetail->submit_status !== 'submited') {
                return 'step7';
            }
            if ($this->submit_status !== 'completed') {
                return 'step8';
            }
            return 'completed';
        }

        // For member donors, check all steps
        if (!$this->personalDetail || $this->personalDetail->submit_status !== 'submited') {
            return 'step1';
        }
        if (!$this->familyDetail || $this->familyDetail->submit_status !== 'submited') {
            return 'step2';
        }
        if (!$this->nomineeDetail || $this->nomineeDetail->submit_status !== 'submited') {
            return 'step3';
        }
        if (!$this->membershipDetail || $this->membershipDetail->submit_status !== 'submited') {
            return 'step4';
        }
        if (!$this->professionalDetail || $this->professionalDetail->submit_status !== 'submited') {
            return 'step5';
        }
        if (!$this->document || $this->document->submit_status !== 'submited') {
            return 'step6';
        }
        if (!$this->paymentDetail || $this->paymentDetail->submit_status !== 'submited') {
            return 'step7';
        }
        if ($this->submit_status !== 'completed') {
            return 'step8';
        }
        return 'completed';
    }
}
