<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function familyDetail()
    {
        return $this->hasOne(Familydetail::class);
    }

    public function educationDetail()
    {
        return $this->hasOne(EducationDetail::class);
    }

    public function fundingDetail()
    {
        return $this->hasOne(FundingDetail::class);
    }

    public function guarantorDetail()
    {
        return $this->hasOne(GuarantorDetail::class);
    }

    public function document()
    {
        return $this->hasOne(Document::class);
    }
}
