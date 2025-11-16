<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UbscAccountController;
use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return view('homepage');
    });
Route::get('/profile', function () {
    return view('profile');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

Route::middleware(['auth:web'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'showProfile'])->name('profile');
    Route::get('/welcome', function () {
        return view('welcome');
    })->name('welcome');
});

Route::get('/signup', [SignupController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [SignupController::class, 'signUp'])->name('signup.post');

// Identity upload routes (for Warga UB only)
Route::get('/signup/upload-identity', [SignUpController::class, 'showUploadIdentitas'])->name('signup.upload-identitas');
Route::post('/signup/upload-identity', [SignUpController::class, 'uploadIdentitas'])->name('signup.upload-identitas.post');

// Verification pending page (for Warga UB after upload)
Route::get('/signup/verification-pending', [SignUpController::class, 'showVerificationPending'])->name('signup.verification-pending');

// Admin Routes - Protected by AdminAuth middleware
Route::prefix('admin')->name('admin.')->group(function () {

    // Admin Auth Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected Admin Routes
    Route::middleware(['auth:admin'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Verification Menu
        Route::prefix('verification')->name('verification.')->group(function () {
            Route::get('/', [VerificationController::class, 'index'])->name('index');
            Route::get('/photo/{id}', [VerificationController::class, 'viewPhoto'])->name('photo');
            Route::post('/approve/{id}', [VerificationController::class, 'approve'])->name('approve');
            Route::post('/reject/{id}', [VerificationController::class, 'reject'])->name('reject');
        });

        // UBSC Account Management (CRUD)
        Route::resource('ubsc-account', UbscAccountController::class)->names([
            'index' => 'ubsc_account.index',
            'create' => 'ubsc_account.create',
            'store' => 'ubsc_account.store',
            'edit' => 'ubsc_account.edit',
            'update' => 'ubsc_account.update',
            'destroy' => 'ubsc_account.destroy',
        ]);
    });
});

