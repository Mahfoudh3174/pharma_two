<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    /**
     * Send OTP for password reset
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Check if user is linked to a pharmacy
        if ($user->pharmacy()->exists()) {
            throw ValidationException::withMessages([
                'email' => ['Invalid user. This account is linked to a pharmacy.'],
            ]);
        }

        // Generate OTP
        $otp = PasswordResetOtp::generateOtp($request->email);

        // Send OTP via email (you can customize this)
        $this->sendOtpEmail($user, $otp->otp);

        return response()->json([
            'message' => 'OTP sent successfully to your email',
            'email' => $request->email
        ]);
    }

    /**
     * Verify OTP and reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string|size:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        // Check if user is linked to a pharmacy
        if ($user->pharmacy()->exists()) {
            throw ValidationException::withMessages([
                'email' => ['Invalid user. This account is linked to a pharmacy.'],
            ]);
        }

        // Find and validate OTP
        $otpRecord = PasswordResetOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('used', false)
            ->first();

        if (!$otpRecord || !$otpRecord->isValid()) {
            throw ValidationException::withMessages([
                'otp' => ['Invalid or expired OTP.'],
            ]);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Mark OTP as used
        $otpRecord->markAsUsed();

        return response()->json([
            'message' => 'Password reset successfully'
        ]);
    }

    /**
     * Send OTP email
     */
    private function sendOtpEmail(User $user, string $otp)
    {
        // For now, we'll just log the OTP
        // In production, you should implement proper email sending
        \Log::info("OTP for {$user->email}: {$otp}");
        
        // You can implement proper email sending here using Laravel's Mail facade
        // Mail::to($user->email)->send(new PasswordResetOtpMail($otp));
    }
}
