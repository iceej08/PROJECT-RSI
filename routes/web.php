<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\Admin\AkunMemberController;
use App\Http\Controllers\DaftarMemberController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UbscAccountController;
use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return view('home');
    });

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/akun-member', function () {
        return view('admin.akun-member.index');
    })->name('akun-member');

    Route::resource('akun-member', AkunMemberController::class);
    Route::post('/akun-member/{id}/toggle-status', [AkunMemberController::class, 'toggleStatus'])->name('akun-member.toggle-status');
    Route::put('/akun-member/{id}', [AkunMemberController::class, 'updateMembership'])->name('akun-member.updateMembership');
    Route::post('/akun-member', [AkunMemberController::class, 'tambahMember'])->name('akun-member.tambahMember');
});

Route::middleware(['auth:web'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
    Route::get('/welcome', function () {
        return view('welcome');
    })->name('welcome');

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    Route::get('/membership', [DaftarMemberController::class, 'showPilihanPaket'])->name('pelanggan.pilih-paket');
    Route::post('/membership/invoice', [DaftarMemberController::class, 'buatInvoice'])->name('pelanggan.buat-invoice');
    Route::get('/invoice/{id}', [DaftarMemberController::class, 'showInvoice'])->name('pelanggan.invoice.show');
    // kalau user back ke halaman pilih paket
    Route::post('/invoice/{id}/cancel', [DaftarMemberController::class, 'cancelInvoice'])
     ->name('pelanggan.invoice.cancel');
    Route::post('/invoice/{id}/unggah-bukti', [DaftarMemberController::class, 'unggahBuktiBayar'])->name('pelanggan.invoice.unggah-bukti');

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
    // Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    // Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    // Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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

