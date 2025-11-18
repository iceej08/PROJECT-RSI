<?php


use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\AkunMemberController;
use App\Http\Controllers\DaftarMemberController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UbscAccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\PromosiController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('home');
    });
Route::get('/profile', function () {
    return view('profile');
});

// Route Homepage dengan Data dari Database
Route::get('/home', [HomeController::class, 'index'])->name('home');
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
        return view('welcomepage');
    })->name('welcome');

    // Route::get('/profil', function () {
    //     return view('pelanggan.profil');
    // })->name('profil');

    Route::get('/membership', [DaftarMemberController::class, 'showPilihanPaket'])->name('pelanggan.pilih-paket');
    Route::post('/membership/invoice', [DaftarMemberController::class, 'buatInvoice'])->name('pelanggan.buat-invoice');
    Route::get('/invoice/{id}', [DaftarMemberController::class, 'showInvoice'])->name('pelanggan.invoice.show');
    Route::post('/invoice/{id}/upload-payment', [DaftarMemberController::class, 'unggahBuktiBayar'])->name('pelanggan.invoice.unggah-bukti');

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
            Route::resource('faq', FAQController::class);
            Route::resource('promosi', PromosiController::class);
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
