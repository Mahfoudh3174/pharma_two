<?php


use App\Http\Controllers\CardController;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $hasPharmacy = Pharmacy::where('user_id', $user->id)->exists();

    if ($hasPharmacy) {
        throw ValidationException::withMessages([
            'user' => ['Invalid user. This account is linked to a pharmacy.'],
        ]);
    }

        $token = $user->createToken('tokenn')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);

});
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    Route::prefix('pharmacies')->group(function () {
        Route::get('/', [\App\Http\Controllers\api\PharmacyController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\api\PharmacyController::class, 'show']);
    });
    //orders
    Route::prefix('orders')->group(function () {
        Route::post('/', [\App\Http\Controllers\api\CommandeController::class, 'store']);
        Route::get('/', [\App\Http\Controllers\api\CommandeController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\api\CommandeController::class, 'show']);
        Route::put('/{id}/validate', [\App\Http\Controllers\api\CommandeController::class, 'validate']);
        Route::put('/{id}/reject', [\App\Http\Controllers\api\CommandeController::class, 'reject']);
    });
    //cart
    Route::prefix('cart')->group(function () {
        Route::post('/', [CardController::class,'store']);
        Route::get('/', [CardController::class, 'index']);
        Route::delete('/{id}', [CardController::class,'destroy']);
        Route::get('/{id}', [CardController::class,'show']);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});



