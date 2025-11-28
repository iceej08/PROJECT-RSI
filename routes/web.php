<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\DaftarMemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AkunMemberController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\PromosiController;
use App\Http\Controllers\Admin\UbscAccountController;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\Admin\VerifikasiPembayaranController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/signup', [SignupController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [SignupController::class, 'signUp'])->name('signup.post');

// Upload identitas Warga UB
Route::get('/signup/upload-identity', [SignupController::class, 'showUploadIdentitas'])
    ->name('signup.upload-identitas');
Route::post('/signup/upload-identity', [SignupController::class, 'uploadIdentitas'])
    ->name('signup.upload-identitas.post');

Route::get('/signup/verification-pending', [SignupController::class, 'showVerificationPending'])
    ->name('signup.verification-pending');

/*
|--------------------------------------------------------------------------
| USER (MEMBER) ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:web'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');

    Route::get('/welcome', function () {
        return view('welcomepage');
    })->name('welcome');

    Route::get('/membership', [DaftarMemberController::class, 'showPilihanPaket'])
        ->name('pelanggan.pilih-paket');

    Route::post('/membership/invoice', [DaftarMemberController::class, 'buatInvoice'])
        ->name('pelanggan.buat-invoice');

    Route::get('/invoice/{id}', [DaftarMemberController::class, 'showInvoice'])
        ->name('pelanggan.invoice.show');

    Route::post('/invoice/{id}/cancel', [DaftarMemberController::class, 'cancelInvoice'])
        ->name('pelanggan.invoice.cancel');

    Route::post('/invoice/{id}/unggah-bukti', [DaftarMemberController::class, 'unggahBuktiBayar'])
        ->name('pelanggan.invoice.unggah-bukti');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Akun Member
    |--------------------------------------------------------------------------
    */

    Route::resource('akun-member', AkunMemberController::class);
    Route::post('/akun-member/{id}/toggle-status', [AkunMemberController::class, 'toggleStatus'])
        ->name('akun-member.toggle-status');
    Route::put('/akun-member/{id}', [AkunMemberController::class, 'updateMembership'])
        ->name('akun-member.updateMembership');
    Route::post('/akun-member', [AkunMemberController::class, 'tambahMember'])
        ->name('akun-member.tambahMember');

    /*
    |--------------------------------------------------------------------------
    | Verification Menu (Verifikasi Warga UB)
    |--------------------------------------------------------------------------
    */

    Route::prefix('verification')->name('verification.')->group(function () {
        Route::get('/', [VerificationController::class, 'index'])->name('index');
        Route::get('/photo/{id}', [VerificationController::class, 'viewPhoto'])->name('photo');
        Route::post('/approve/{id}', [VerificationController::class, 'approve'])->name('approve');
        Route::post('/reject/{id}', [VerificationController::class, 'reject'])->name('reject');
    });

    /*
    |--------------------------------------------------------------------------
    | FAQ & Promosi
    |--------------------------------------------------------------------------
    */

    Route::resource('faq', FAQController::class);
    Route::resource('promosi', PromosiController::class);

    /*
    |--------------------------------------------------------------------------
    | UBSC Account CRUD
    |--------------------------------------------------------------------------
    */

    Route::resource('ubsc-account', UbscAccountController::class)
        ->names([
            'index' => 'ubsc_account.index',
            'create' => 'ubsc_account.create',
            'store'  => 'ubsc_account.store',
            'edit'   => 'ubsc_account.edit',
            'update' => 'ubsc_account.update',
            'destroy'=> 'ubsc_account.destroy',
        ]);

    /*
    |--------------------------------------------------------------------------
    | VERIFIKASI PEMBAYARAN (PAKET MEMBER)
    |--------------------------------------------------------------------------
    */

    Route::get('/verifikasi-pembayaran', [VerifikasiPembayaranController::class, 'index'])
        ->name('verifikasi-pembayaran'); // ALIAS FIX untuk menghilangkan error

    Route::prefix('verifikasi-pembayaran')->name('verifikasi-pembayaran.')->group(function () {
        Route::get('/', [VerifikasiPembayaranController::class, 'index'])->name('index');
        Route::get('/bukti/{id}', [VerifikasiPembayaranController::class, 'viewBukti'])->name('bukti');
        Route::post('/approve/{id}', [VerifikasiPembayaranController::class, 'approve'])->name('approve');
        Route::post('/reject/{id}', [VerifikasiPembayaranController::class, 'reject'])->name('reject');
    });
});
