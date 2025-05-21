<?php

use App\Http\Controllers\Category\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicationController;

define('PAGINATE', 10);

Route::get('/', function () {
    return view('home');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth','verified'])->group(function () {
  Route::get('/categories',[CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create',[CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Pharmacy routes
    Route::get('/pharmacy/create', [PharmacyController::class, 'create'])->name('pharmacy.create');
    Route::post('/pharmacy', [PharmacyController::class, 'store'])->name('pharmacy.store');
    Route::get('/pharmacy/edit', [PharmacyController::class, 'edit'])->name('pharmacy.edit');
    Route::put('/pharmacy', [PharmacyController::class, 'update'])->name('pharmacy.update');
    
    // Pharmacy medication management
    Route::get('/pharmacy/medications', [PharmacyController::class, 'medications'])->name('pharmacy.medications');
    Route::get('/pharmacy/medications/{pharmacy}/edit/{medication}', [PharmacyController::class, 'editMedication'])->name('pharmacy.medications.edit');
    Route::put('/pharmacy/medications/{medication}', [PharmacyController::class, 'updateMedication'])->name('pharmacy.medications.update');
    Route::delete('/pharmacy/medications/{medication}', [PharmacyController::class, 'removeMedication'])->name('pharmacy.medications.destroy');
 
    Route::middleware(['auth'])->group(function () {
        Route::resource('medications', MedicationController::class);
    });

    Route::get("commandes/details/{commande}",[CommandeController::class, "details"])->name("commandes.details");
    Route::get("commandes/validate/{commande}",[CommandeController::class, "validate"])->name("commandes.validate");
    Route::post("commandes/reject",[CommandeController::class, "reject"])->name("commandes.reject");
});


require __DIR__.'/auth.php';
