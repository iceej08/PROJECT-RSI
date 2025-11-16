<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\AkunMemberController;
use App\Http\Controllers\DaftarMemberController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('homepage');
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

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/welcome', function () {
        return view('welcome');
    })->name('welcome');

    Route::get('/profil', function () {
        return view('pelanggan.profil');
    })->name('profil');

    Route::get('/membership', [DaftarMemberController::class, 'showPilihanPaket'])->name('pelanggan.pilih-paket');
    Route::post('/membership/invoice', [DaftarMemberController::class, 'buatInvoice'])->name('pelanggan.buat-invoice');
    Route::get('/invoice/{id}', [DaftarMemberController::class, 'showInvoice'])->name('pelanggan.invoice.show');
    Route::post('/invoice/{id}/upload-payment', [DaftarMemberController::class, 'unggahBuktiBayar'])->name('pelanggan.invoice.unggah-bukti');

});

Route::get('/signup', [SignupController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [SignupController::class, 'signUp'])->name('signup.post');

Route::get('/signup', [SignUpController::class, 'showSignUpForm'])->name('signup');
Route::post('/signup', [SignUpController::class, 'signUp'])->name('signup.post');

// Identity upload routes (for Warga UB only)
Route::get('/signup/upload-identity', [SignUpController::class, 'showUploadIdentitas'])->name('signup.upload-identitas');
Route::post('/signup/upload-identity', [SignUpController::class, 'uploadIdentitas'])->name('signup.upload-identitas.post');

// Verification pending page (for Warga UB after upload)
Route::get('/signup/verification-pending', [SignUpController::class, 'showVerificationPending'])->name('signup.verification-pending');




