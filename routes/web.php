<?php

use App\Http\Controllers\Category\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\PdfController;

define('PAGINATE', 10);

Route::get('/', function () {
    return view('home');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');

});


Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth','verified'])->group(function () {
  Route::get('/categories',[CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category}',[CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/create',[CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

Route::middleware(['auth','verified'])->group(function () {
    // Pharmacy routes
    Route::get('/pharmacy/create', [\App\Http\Controllers\PharmacyController::class, 'create'])->name('pharmacy.create');
    Route::post('/pharmacy', [\App\Http\Controllers\PharmacyController::class, 'store'])->name('pharmacy.store');
    Route::get('/pharmacy/edit', [PharmacyController::class, 'edit'])->name('pharmacy.edit');
    Route::put('/pharmacy', [PharmacyController::class, 'update'])->name('pharmacy.update');
    
    // Pharmacy medication management
    Route::get('/pharmacy/medications', [PharmacyController::class, 'medications'])->name('pharmacy.medications');
    Route::get('/pharmacy/medications/{pharmacy}/edit/{medication}', [PharmacyController::class, 'editMedication'])->name('pharmacy.medications.edit');
    Route::put('/pharmacy/medications/{medication}', [PharmacyController::class, 'updateMedication'])->name('pharmacy.medications.update');
    Route::delete('/pharmacy/medications/{medication}', [PharmacyController::class, 'removeMedication'])->name('pharmacy.medications.destroy');
 
    Route::middleware(['auth','verified'])->group(function () {
        Route::resource('medications', MedicationController::class);
    });
    Route::get('/facture/{id}', [PdfController::class, 'generatePdf'])->name('facture.generate');

    Route::get("commandes/details/{commande}",[CommandeController::class, "details"])->name("commandes.details");
    Route::get("commandes/validate/{commande}",[CommandeController::class, "validate"])->name("commandes.validate");
    Route::post("commandes/reject",[CommandeController::class, "reject"])->name("commandes.reject");
    Route::get("commandes/delivered/{commande}",[CommandeController::class, "delivered"])->name("commandes.delivered");
    // Route::get('/commandes/show/{commande}', [CommandeController::class, 'show'])->name('commandes.show');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::patch('/users/{user}/toggle-status', [\App\Http\Controllers\AdminDashboardController::class, 'toggleUserStatus'])->name('admin.users.toggle_status');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\AdminDashboardController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\AdminDashboardController::class, 'updateUser'])->name('admin.users.update');
    Route::patch('/pharmacies/{pharmacy}/toggle-status', [\App\Http\Controllers\AdminDashboardController::class, 'togglePharmacyStatus'])->name('admin.pharmacies.toggle_status');
    Route::get('/pharmacies/{pharmacy}', [\App\Http\Controllers\AdminDashboardController::class, 'pharmacyDetails'])->name('admin.pharmacies.details');
    Route::get('/pharmacies/{pharmacy}/edit', [\App\Http\Controllers\AdminDashboardController::class, 'editPharmacy'])->name('admin.pharmacies.edit');
    Route::put('/pharmacies/{pharmacy}', [\App\Http\Controllers\AdminDashboardController::class, 'updatePharmacy'])->name('admin.pharmacies.update');
    // More admin routes can be added here
});

Route::middleware(['auth', 'ensure.pharmacy', 'pharmacy','verified'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    // Add more pharmacy routes here
});

Route::middleware(['auth', 'ensure.pharmacy', 'user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
    // Add more user routes here
});

require __DIR__.'/auth.php';
