<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use Illuminate\Validation\ValidationException;



Route::post('/login', function (Request $request) {

           $request->validate([
            'credential' => 'required|string',
            'password' => 'required|string',
        ]);
        

        // Determine if identifier is email or phone
        $field = filter_var($request->credential, FILTER_VALIDATE_EMAIL) 
            ? 'email' 
            : 'phone';

        // Attempt authentication
        if (!Auth::attempt([$field => $request->credential, 'password' => $request->password])) {
            throw ValidationException::withMessages([
                'credential' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = $request->user();
        $token = $user->createToken('tokenn')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);

});
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});