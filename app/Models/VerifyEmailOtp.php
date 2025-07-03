<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifyEmailOtp extends Model
{
     protected $guarded = [
        'id',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];

    /**
     * Check if the OTP is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Check if the OTP is valid (not expired and not used)
     */
    public function isValid(): bool
    {
        return !$this->isExpired() && !$this->used;
    }

    /**
     * Mark the OTP as used
     */
    public function markAsUsed(): void
    {
        $this->update(['used' => true]);
    }

    /**
     * Generate a new OTP for the given email
     */
    public static function generateOtp(string $email): self
    {
        // Delete any existing unused OTPs for this email
        self::where('email', $email)
            ->where('used', false)
            ->delete();

        return self::create([
            'email' => $email,
            'otp' => str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT),
            'expires_at' => now()->addMinutes(10), // OTP expires in 10 minutes
        ]);
    }
}
