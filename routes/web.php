<?php

use Illuminate\Support\Facades\Route;

// --- KONTROLER PUBLIK (USER BIASA) ---
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController; // Memakai 'u' kecil (sesuai file Anda)

// --- KONTROLER ADMIN ---
use App\Http\Controllers\AdminController;          // Untuk Dashboard & Verifikasi Pembayaran
use App\Http\Controllers\Admin\AuthController;  // Login Admin (INI SUDAH ANDA MILIKI)

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- RUTE PUBLIK (USER BIASA) ---

Route::get('/', function () {
    return view('homepage');
});

// Rute Login & Logout (User Biasa)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rute Signup (User Biasa)
Route::get('/signup', [SignupController::class, 'showSignUpForm'])->name('signup');
Route::post('/signup', [SignupController::class, 'signUp'])->name('signup.post');
Route::get('/signup/upload-identity', [SignupController::class, 'showUploadIdentitas'])->name('signup.upload-identitas');
Route::post('/signup/upload-identity', [SignupController::class, 'uploadIdentitas'])->name('signup.upload-identitas.post');
Route::get('/signup/verification-pending', [SignupController::class, 'showVerificationPending'])->name('signup.verification-pending');

// --- RUTE PROTEKSI (USER BIASA) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/welcome', function () {
        return view('welcome');
    })->name('welcome');
});


// =========================================================================
// --- GRUP RUTE ADMIN ---
// =========================================================================

// --- RUTE LOGIN ADMIN (PUBLIK) ---
// Rute ini TIDAK boleh di dalam middleware 'auth:admin'
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Rute untuk MENAMPILKAN form login admin
    // Menggunakan AuthController Anda yang sudah ada
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

    // Rute untuk MEMPROSES login admin
    // Menggunakan AuthController Anda yang sudah ada
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});


// --- RUTE PROTEKSI (ADMIN) ---
// Rute ini hanya bisa diakses SETELAH admin login
// Menggunakan middleware 'auth:admin' (yang akan kita perbaiki)
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Rute Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Rute Logout Admin
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- FITUR BARU: VERIFIKASI PEMBAYARAN ---
    
    // Rute untuk MENAMPILKAN halaman verifikasi
    Route::get('/paymentverification', [AdminController::class, 'verifikasiPembayaran'])
         ->name('verifikasi-pembayaran'); // Nama ini penting untuk redirect

    // Rute untuk MEMPROSES verifikasi
    Route::patch('/paymentverification/{pembayaran}', [AdminController::class, 'prosesVerifikasi'])
         ->name('proses-verifikasi');
});