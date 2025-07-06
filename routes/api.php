<?php


use App\Http\Controllers\api\CardController;
use App\Http\Controllers\api\CategoryController;
use App\Models\Fcm;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use Illuminate\Validation\ValidationException;



Route::post('/login', function (Request $request) {





        // Determine if identifier is email or phone
        $field = filter_var($request->credential, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'phone';

        // Attempt authentication
        if (!Auth::attempt([$field => $request->credential, 'password' => $request->password])) {
           return response()->json([
                'fr_message' => 'Identifiant ou mot de passe incorrect.',
                'ar_message' => 'اسم المستخدم أو كلمة المرور غير صحيحة.',
            ]);
        }
        

        $user = $request->user();

        if ($user->status !== 'active') {
            Auth::logout();
            return response()->json([
                'fr_message' => 'Votre compte est inactif. Veuillez contacter un administrateur.',
                'ar_message' => 'حسابك غير نشط. يرجى الاتصال بالمسؤول.',
            ]);
        }

        // Check if the user is a pharmacy and if their associated pharmacy is inactive
        if ($user->isPharmacy() && $user->pharmacy ) {
            Auth::logout();
            return response()->json([
                'fr_message' => "L'utilisateur n'existe pas.",
                'ar_message' => 'المستخدم غير موجود.',
            ]);
        }
        Fcm::where('user_id', '=', $user->id)->delete();

        Fcm::updateOrCreate(['token' => $request->token, 'user_id' => $user->id]);

        $token = $user->createToken('tokenn')->plainTextToken;
                if (!$user->email_verified_at) {
            return response()->json([
                'fr_message' => 'Veuillez vérifier votre email pour activer votre compte.',
                'ar_message'=>'يرجى التحقق من بريدك الإلكتروني لتفعيل حسابك.',
                'email' => $user->email,
            'token' => $token,
            ]);
        }

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);

});
Route::post('/register', [AuthController::class, 'register']);

// Password reset routes (no authentication required)
Route::post('/password/send-otp', [AuthController::class, 'sendPasswordResetOtp']);
Route::post('/password/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/password/reset', [AuthController::class, 'resetPassword']);
//verify email
Route::post('/email/send-otp', [AuthController::class, 'sendVerifyEmailOtp']);
Route::post('/email/verify-otp', [AuthController::class, 'verifyEmailOtp']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    // Categories routes
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/{category}', [CategoryController::class, 'show']);
        Route::get('/pharmacy/{pharmacyId}', [CategoryController::class, 'pharmacyCategories']);
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
        Route::delete('/{id}', [\App\Http\Controllers\api\CommandeController::class, 'delete']);
        Route::put('/{id}/validate', [\App\Http\Controllers\api\CommandeController::class, 'validate']);
        Route::put('/{id}/reject', [\App\Http\Controllers\api\CommandeController::class, 'reject']);
    });
    //cart
    Route::prefix('cart')->group(function () {
        Route::post('/', [CardController::class,'store']);
        Route::get('/', [CardController::class, 'index']);
        Route::delete('/{id}', [CardController::class,'delete']);
        Route::get('/cart-count/{id}', [CardController::class,'show']);
    });
    // categories
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});





