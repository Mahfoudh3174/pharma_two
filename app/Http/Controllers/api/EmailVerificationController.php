<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class EmailVerificationController extends Controller
{
    /**
     * Send email verification notification
     */
    public function sendVerificationEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email is already verified'
            ]);
        }

        // Check if user is linked to a pharmacy
        if ($user->pharmacy()->exists()) {
            throw ValidationException::withMessages([
                'email' => ['Invalid user. This account is linked to a pharmacy.'],
            ]);
        }

        // Send verification email
        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Verification email sent successfully'
        ]);
    }

    /**
     * Verify email with signed URL
     */
    public function verify(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'hash' => 'required|string',
        ]);

        $user = User::findOrFail($request->id);

        // Check if user is linked to a pharmacy
        if ($user->pharmacy()->exists()) {
            throw ValidationException::withMessages([
                'user' => ['Invalid user. This account is linked to a pharmacy.'],
            ]);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email is already verified'
            ]);
        }

        // Verify the hash
        if (!hash_equals(
            sha1($user->getEmailForVerification()),
            $request->hash
        )) {
            throw ValidationException::withMessages([
                'hash' => ['Invalid verification link.'],
            ]);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json([
            'message' => 'Email verified successfully',
            'user' => $user
        ]);
    }

    /**
     * Check if email is verified
     */
    public function checkVerification(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'email_verified' => $user->hasVerifiedEmail(),
            'user' => $user
        ]);
    }
}
