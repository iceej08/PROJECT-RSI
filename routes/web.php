<?php
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\Admin\AkunMemberController;
use App\Http\Controllers\DaftarMemberController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\Admin\UbscAccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\PromosiController;
use App\Http\Controllers\Admin\VerifikasiPembayaranController;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
// Dan route /home tetap ada:
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/signup', [SignupController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [SignupController::class, 'signUp'])->name('signup.post');

// Identity upload routes (for Warga UB only)
Route::get('/signup/upload-identity', [SignUpController::class, 'showUploadIdentitas'])->name('signup.upload-identitas');
Route::post('/signup/upload-identity', [SignUpController::class, 'uploadIdentitas'])->name('signup.upload-identitas.post');

// Verification pending page (for Warga UB after upload)
Route::get('/signup/verification-pending', [SignUpController::class, 'showVerificationPending'])->name('signup.verification-pending');

// Route Homepage dengan Data dari Database
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth:web'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
    Route::get('/welcome', function () {
        return view('welcomepage');
    })->name('welcome');

    Route::get('/membership', [DaftarMemberController::class, 'showPilihanPaket'])->name('pelanggan.pilih-paket');
    Route::post('/membership/invoice', [DaftarMemberController::class, 'buatInvoice'])->name('pelanggan.buat-invoice');
    Route::get('/invoice/{id}', [DaftarMemberController::class, 'showInvoice'])->name('pelanggan.invoice.show');
    // kalau user back ke halaman pilih paket
    Route::post('/invoice/{id}/cancel', [DaftarMemberController::class, 'cancelInvoice'])
     ->name('pelanggan.invoice.cancel');
    Route::post('/invoice/{id}/unggah-bukti', [DaftarMemberController::class, 'unggahBuktiBayar'])->name('pelanggan.invoice.unggah-bukti');

});

    // Protected Admin Routes
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/akun-member', function () {
        return view('admin.akun-member.index');
    })->name('akun-member');

    Route::resource('akun-member', AkunMemberController::class);
    Route::put('/akun-member/{id}', [AkunMemberController::class, 'update'])->name('akun-member.update');
    Route::post('/akun-member', [AkunMemberController::class, 'tambahMember'])->name('akun-member.tambahMember');

    // Verification Menu
    Route::prefix('verification')->name('verification.')->group(function () {
        Route::get('/', [VerificationController::class, 'index'])->name('index');
        Route::get('/photo/{id}', [VerificationController::class, 'viewPhoto'])->name('photo');
        Route::post('/approve/{id}', [VerificationController::class, 'approve'])->name('approve');
        Route::post('/reject/{id}', [VerificationController::class, 'reject'])->name('reject');
    });
        Route::resource('faq', FAQController::class);
        Route::resource('promosi', PromosiController::class);

    // UBSC Account Management (CRUD)
    Route::resource('ubsc-account', UbscAccountController::class)->names([
        'index' => 'ubsc_account.index',
        'create' => 'ubsc_account.create',
        'store' => 'ubsc_account.store',
        'edit' => 'ubsc_account.edit',
        'update' => 'ubsc_account.update',
        'destroy' => 'ubsc_account.destroy',
    ]);

    Route::prefix('verifikasi-pembayaran')->name('verifikasi-pembayaran.')->group(function () {
        Route::get('/', [VerifikasiPembayaranController::class, 'index'])->name('index');
        Route::get('/bukti/{id}', [VerifikasiPembayaranController::class, 'viewBukti'])->name('bukti');
        Route::post('/approve/{id}', [VerifikasiPembayaranController::class, 'approve'])->name('approve');
        Route::post('/reject/{id}', [VerifikasiPembayaranController::class, 'reject'])->name('reject');
    });
});
