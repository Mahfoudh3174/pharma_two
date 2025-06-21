<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Log;

class AuthController
{
    public function register(Request $request)
    {
        Log::info('Register request received', ['request' => $request->all()]);
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15|unique:users|regex:/^[2-4][0-9]{7}$/',
            'password' => 'required|string',
        ]);
        Log::info('Validated data', ['data' => $validatedData]);

        $user = User::create([
            'name' => $validatedData['username'],
            'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            'phone' => $validatedData['phone'],
        ]);
        Log::info('User created', ['user_id' => $user->id]);


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
}