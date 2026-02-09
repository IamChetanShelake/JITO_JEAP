<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Donor extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $connection = 'admin_panel';

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

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

    // Helper method to get next incomplete step
    public function getNextStep()
    {
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
