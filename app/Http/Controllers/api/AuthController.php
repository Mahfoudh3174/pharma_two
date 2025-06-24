<?php

namespace App\Http\Controllers\api;

use App\Mail\PasswordResetOtpMail;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Log;

class AuthController
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15|unique:users|regex:/^[2-4][0-9]{7}$/',
            'password' => 'required|string',
        ]);

        $user = User::create([
            'name' => $validatedData['username'],
            'email' => $validatedData['email'],
            'email_verified_at' => now(),
                'password' => Hash::make($validatedData['password']),
            'phone' => $validatedData['phone'],
        ]);


        return response()->json([
            'user' => $user,
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Send password reset OTP
     */
    public function sendPasswordResetOtp(Request $request)
    {
        Log::info('Sending password reset OTP', ['email' => $request->email]);
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        // Generate OTP
        $otpRecord = PasswordResetOtp::generateOtp($request->email);

        try {
            // Send email
            Mail::to($request->email)->send(new PasswordResetOtpMail($otpRecord->otp, $user->name));

            return response()->json([
                'message' => 'Password reset OTP sent successfully',
                'email' => $request->email
            ], 200);

        } catch (\Exception $e) {
            // Delete the OTP if email sending fails
            $otpRecord->delete();

            Log::error('Failed to send password reset OTP: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to send OTP. Please try again later.'
            ], 500);
        }
    }

    /**
     * Reset password using OTP
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string|size:6',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
        ]);

        // Find the OTP record
        $otpRecord = PasswordResetOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('used', false)
            ->first();

        if (!$otpRecord) {
            return response()->json([
                'message' => 'Invalid OTP'
            ], 400);
        }

        if ($otpRecord->isExpired()) {
            return response()->json([
                'message' => 'OTP has expired'
            ], 400);
        }

        // Update user password
        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Mark OTP as used
        $otpRecord->markAsUsed();

        // Revoke all tokens for the user (force logout from all devices)
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Password reset successfully'
        ], 200);
    }

    /**
     * Verify OTP without resetting password
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string|size:6',
        ]);

        $otpRecord = PasswordResetOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('used', false)
            ->first();

        if (!$otpRecord) {
            return response()->json([
                'message' => 'Invalid OTP'
            ], 400);
        }

        if ($otpRecord->isExpired()) {
            return response()->json([
                'message' => 'OTP has expired'
            ], 400);
        }

        return response()->json([
            'message' => 'OTP verified successfully'
        ], 200);
    }
}