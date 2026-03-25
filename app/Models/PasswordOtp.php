<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordOtp extends Model
{
    protected $fillable = [
        'email',
        'otp',
        'purpose',
        'is_verified',
        'expires_at',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * Check if the OTP is expired.
     */
    public function isExpired(): bool
    {
        return now()->greaterThan($this->expires_at);
    }

    /**
     * Check if the OTP is valid (not expired and not verified).
     */
    public function isValid(): bool
    {
        return !$this->is_verified && !$this->isExpired();
    }

    /**
     * Verify the OTP.
     */
    public function verify(): bool
    {
        if ($this->isValid()) {
            $this->is_verified = true;
            $this->save();
            return true;
        }
        return false;
    }

    /**
     * Generate a new OTP for the given email.
     */
    public static function generateOtp(string $email): string
    {
        // Delete any existing unverified OTPs for this email
        self::where('email', $email)
            ->where('is_verified', false)
            ->delete();

        // Generate a 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Create new OTP record
        self::create([
            'email' => $email,
            'otp' => $otp,
            'purpose' => 'password_reset',
            'is_verified' => false,
            'expires_at' => now()->addMinutes(10),
        ]);

        return $otp;
    }

    /**
     * Find a valid OTP for the given email and OTP code.
     */
    public static function findValidOtp(string $email, string $otp): ?self
    {
        return self::where('email', $email)
            ->where('otp', $otp)
            ->where('is_verified', false)
            ->where('expires_at', '>', now())
            ->first();
    }
}
